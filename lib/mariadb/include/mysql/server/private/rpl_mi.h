/* Copyright (c) 2006, 2012, Oracle and/or its affiliates.

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; version 2 of the License.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1335  USA */

#ifndef RPL_MI_H
#define RPL_MI_H

#ifdef HAVE_REPLICATION

#include "rpl_rli.h"
#include "rpl_reporting.h"
#include <my_sys.h>
#include "rpl_filter.h"
#include "keycaches.h"

typedef struct st_mysql MYSQL;

/**
  Domain id based filter to handle DO_DOMAIN_IDS and IGNORE_DOMAIN_IDS used to
  set filtering on replication slave based on event's GTID domain_id.
*/
class Domain_id_filter
{
private:
  /*
    Flag to tell whether the events in the current GTID group get written to
    the relay log. It is set according to the domain_id based filtering rule
    on every GTID_EVENT and reset at the end of current GTID event group.
   */
  bool m_filter;

public:
  /* domain id list types */
  enum enum_list_type {
    DO_DOMAIN_IDS= 0,
    IGNORE_DOMAIN_IDS
  };

  /*
    DO_DOMAIN_IDS (0):
      Ignore all the events which do not belong to any of the domain ids in the
      list.

    IGNORE_DOMAIN_IDS (1):
      Ignore the events which belong to one of the domain ids in the list.
  */
  DYNAMIC_ARRAY m_domain_ids[2];

  Domain_id_filter();

  ~Domain_id_filter();

  /*
    Returns whether the current group needs to be filtered.
  */
  bool is_group_filtered() { return m_filter; }

  /*
    Checks whether the group with the specified domain_id needs to be
    filtered and updates m_filter flag accordingly.
  */
  void do_filter(ulong domain_id);

  /*
    Reset m_filter. It should be called when IO thread receives COMMIT_EVENT or
    XID_EVENT.
  */
  void reset_filter();

  /*
    Clear do_ids and ignore_ids to disable domain id filtering
  */
  void clear_ids();

  /*
    Update the do/ignore domain id filter lists.

    @param do_ids     [IN]            domain ids to be kept
    @param ignore_ids [IN]            domain ids to be filtered out
    @param using_gtid [IN]            use GTID?

    @retval false                     Success
            true                      Error
  */
  bool update_ids(DYNAMIC_ARRAY *do_ids, DYNAMIC_ARRAY *ignore_ids,
                  bool using_gtid);

  /*
    Serialize and store the ids from domain id lists into the thd's protocol
    buffer.

    @param thd [IN]                   thread handler

    @retval void
  */
  void store_ids(THD *thd);
  /* Same as above, but store the id's into a group of fields */
  void store_ids(Field ***field);
  /*
    Initialize the given domain id list (DYNAMIC_ARRAY) with the
    space-separated list of numbers from the specified IO_CACHE where
    the first number is the total number of entries to follows.

    @param f    [IN]                  IO_CACHE file
    @param type [IN]                  domain id list type

    @retval false                     Success
            true                      Error
  */
  bool init_ids(IO_CACHE *f, enum_list_type type);

  /*
    Return the elements of the give domain id list type as string.

    @param type [IN]                  domain id list type

    @retval                           a string buffer storing the total number
                                      of elements followed by the individual
                                      elements (space-separated) in the
                                      specified list.

    Note: Its caller's responsibility to free the returned string buffer.
  */
  char *as_string(enum_list_type type);

};


extern TYPELIB slave_parallel_mode_typelib;

typedef struct st_rows_event_tracker
{
  char binlog_file_name[FN_REFLEN];
  my_off_t first_seen;
  my_off_t last_seen;
  bool stmt_end_seen;
  void update(const char *file_name, my_off_t pos,
              const uchar *buf,
              const Format_description_log_event *fdle);
  void reset();
  bool check_and_report(const char* file_name, my_off_t pos);
} Rows_event_tracker;

/*****************************************************************************
  Replication IO Thread

  Master_info contains:
    - information about how to connect to a master
    - current master log name
    - current master log offset
    - misc control variables

  Master_info is initialized once from the master.info file if such
  exists. Otherwise, data members corresponding to master.info fields
  are initialized with defaults specified by master-* options. The
  initialization is done through init_master_info() call.

  The format of master.info file:

  log_name
  log_pos
  master_host
  master_user
  master_pass
  master_port
  master_connect_retry

  To write out the contents of master.info file to disk ( needed every
  time we read and queue data from the master ), a call to
  flush_master_info() is required.

  To clean up, call end_master_info()

*****************************************************************************/

class Master_info : public Slave_reporting_capability
{
 public:
  enum enum_using_gtid {
    USE_GTID_NO= 0, USE_GTID_CURRENT_POS= 1, USE_GTID_SLAVE_POS= 2
  };

  Master_info(LEX_CSTRING *connection_name, bool is_slave_recovery);
  ~Master_info();
  bool shall_ignore_server_id(ulong s_id);
  void clear_in_memory_info(bool all);
  bool error()
  {
    /* If malloc() in initialization failed */
    return connection_name.str == 0;
  }
  static const char *using_gtid_astext(enum enum_using_gtid arg);
  bool using_parallel()
  {
    return opt_slave_parallel_threads > 0 &&
      parallel_mode > SLAVE_PARALLEL_NONE;
  }
  void release();
  void wait_until_free();
  void lock_slave_threads();
  void unlock_slave_threads();

  ulonglong get_slave_skip_counter()
  {
    return rli.slave_skip_counter;
  }

  ulonglong get_max_relay_log_size()
  {
    return rli.max_relay_log_size;
  }

  /* the variables below are needed because we can change masters on the fly */
  char master_log_name[FN_REFLEN+6]; /* Room for multi-*/
  char host[HOSTNAME_LENGTH*SYSTEM_CHARSET_MBMAXLEN+1];
  char user[USERNAME_LENGTH+1];
  char password[MAX_PASSWORD_LENGTH*SYSTEM_CHARSET_MBMAXLEN+1];
  LEX_CSTRING connection_name; 		/* User supplied connection name */
  LEX_CSTRING cmp_connection_name;	/* Connection name in lower case */
  bool ssl; // enables use of SSL connection if true
  char ssl_ca[FN_REFLEN], ssl_capath[FN_REFLEN], ssl_cert[FN_REFLEN];
  char ssl_cipher[FN_REFLEN], ssl_key[FN_REFLEN];
  char ssl_crl[FN_REFLEN], ssl_crlpath[FN_REFLEN];
  my_bool ssl_verify_server_cert; /* MUST be my_bool, see mysql_option() */

  my_off_t master_log_pos;
  File fd; // we keep the file open, so we need to remember the file pointer
  IO_CACHE file;

  mysql_mutex_t data_lock, run_lock, sleep_lock, start_stop_lock, start_alter_lock, start_alter_list_lock;
  mysql_cond_t data_cond, start_cond, stop_cond, sleep_cond;
  THD *io_thd;
  MYSQL* mysql;
  uint32 file_id;				/* for 3.23 load data infile */
  uint mysql_version;
  Relay_log_info rli;
  uint port;
  Rpl_filter* rpl_filter;      /* Each replication can set its filter rule*/
  /*
    to hold checksum alg in use until IO thread has received FD.
    Initialized to novalue, then set to the queried from master
    @@global.binlog_checksum and deactivated once FD has been received.
  */
  enum_binlog_checksum_alg checksum_alg_before_fd;
  uint connect_retry;
#ifndef DBUG_OFF
  int events_till_disconnect;

  /*
    The following are auxiliary DBUG variables used to kill IO thread in the
    middle of a group/transaction (see "kill_slave_io_after_2_events").
  */
  bool dbug_do_disconnect;
  int dbug_event_counter;
#endif
  bool inited;
  volatile bool abort_slave;
  volatile uint slave_running;
  volatile ulong slave_run_id;
  /*
     The difference in seconds between the clock of the master and the clock of
     the slave (second - first). It must be signed as it may be <0 or >0.
     clock_diff_with_master is computed when the I/O thread starts; for this the
     I/O thread does a SELECT UNIX_TIMESTAMP() on the master.
     "how late the slave is compared to the master" is computed like this:
     clock_of_slave - last_timestamp_executed_by_SQL_thread - clock_diff_with_master

  */
  long clock_diff_with_master;
  /*
    Keeps track of the number of events before fsyncing.
    The option --sync-master-info determines how many
    events should happen before fsyncing.
  */
  uint sync_counter;
  float heartbeat_period;         // interface with CHANGE MASTER or master.info
  ulonglong received_heartbeats;  // counter of received heartbeat events
  DYNAMIC_ARRAY ignore_server_ids;
  ulong master_id;
  /*
    At reconnect and until the first rotate event is seen, prev_master_id is
    the value of master_id during the previous connection, used to detect
    silent change of master server during reconnects.
  */
  ulong prev_master_id;
  /*
    Which kind of GTID position (if any) is used when connecting to master.

    Note that you can not change the numeric values of these, they are used
    in master.info.
  */
  enum enum_using_gtid using_gtid;

  /*
    This GTID position records how far we have fetched into the relay logs.
    This is used to continue fetching when the IO thread reconnects to the
    master.

    (Full slave stop/start does not use it, as it resets the relay logs).
  */
  slave_connection_state gtid_current_pos;
  /*
    If events_queued_since_last_gtid is non-zero, it is the number of events
    queued so far in the relaylog of a GTID-prefixed event group.
    It is zero when no partial event group has been queued at the moment.
  */
  uint64 events_queued_since_last_gtid;
  /*
    The GTID of the partially-queued event group, when
    events_queued_since_last_gtid is non-zero.
  */
  rpl_gtid last_queued_gtid;
  /* Whether last_queued_gtid had the FL_STANDALONE flag set. */
  bool last_queued_gtid_standalone;
  /*
    When slave IO thread needs to reconnect, gtid_reconnect_event_skip_count
    counts number of events to skip from the first GTID-prefixed event group,
    to avoid duplicating events in the relay log.
  */
  uint64 gtid_reconnect_event_skip_count;
  /* gtid_event_seen is false until we receive first GTID event from master. */
  bool gtid_event_seen;
  /**
    The struct holds some history of Rows- log-event reading/queuing
    by the receiver thread. Its fields are updated per each such event
    at time of queue_event(), and they are checked to detect
    the Rows- event group integrity violation at time of first non-Rows-
    event gets handled.
  */
  Rows_event_tracker rows_event_tracker;
  bool in_start_all_slaves, in_stop_all_slaves;
  bool in_flush_all_relay_logs;
  uint users;                                   /* Active user for object */
  uint killed;


  /* No of DDL event group */
  Atomic_counter<uint64> total_ddl_groups;

  /* No of non-transactional event group*/
  Atomic_counter<uint64> total_non_trans_groups;

  /* No of transactional event group*/
  Atomic_counter<uint64> total_trans_groups;

  /* domain-id based filter */
  Domain_id_filter domain_id_filter;

  /* The parallel replication mode. */
  enum_slave_parallel_mode parallel_mode;
  /*
    semi_ack is used to identify if the current binlog event needs an
    ACK from slave, or if delay_master is enabled.
  */
  int semi_ack;
  /*
    The flag has replicate_same_server_id semantics and is raised to accept
    a same-server-id event group by the gtid strict mode semisync slave.
    Own server-id events can normally appear as result of EITHER
    A. this server semisync (failover to) slave crash-recovery:
       the transaction was created on this server then being master,
       got replicated elsewhere right before the crash before commit,
       and finally at recovery the transaction gets evicted from the
       server's binlog and its gtid (slave) state; OR
    B. in a general circular configuration and then when a recieved (returned
       to slave) gtid exists in the server's binlog. Then, in gtid strict mode,
       it must be ignored similarly to the replicate-same-server-id rule.
 */
  bool do_accept_own_server_id= false;
  /*
    Set to 1 when semi_sync is enabled. Set to 0 if there is any transmit
    problems to the slave, in which case any furter semi-sync reply is
    ignored
  */
  bool semi_sync_reply_enabled;
  List <start_alter_info> start_alter_list;
  MEM_ROOT mem_root;
  /*
    Flag is raised at the parallel worker slave stop. Its purpose
    is to mark the whole start_alter_list when slave stops.
    The flag is read by Start Alter event to self-mark its state accordingly
    at time its alter info struct is about to be appened to the list.
  */
  bool is_shutdown= false;

  /*
    A replica will default to Slave_Pos for using Using_Gtid; however, we
    first need to test if the master supports GTIDs. If not, fall back to 'No'.
    Cache the value so future RESET SLAVE commands don't revert to Slave_Pos.
  */
  bool master_supports_gtid= true;

  /*
    When TRUE, transition this server from being an active master to a slave.
    This updates the replication state to account for any transactions which
    were committed into the binary log. In particular, it merges
    gtid_binlog_pos into gtid_slave_pos.
  */
  bool is_demotion= false;
};

struct start_alter_thd_args
{
  rpl_group_info *rgi;
  LEX_CSTRING query;
  LEX_CSTRING *db;
  char *catalog;
  bool shutdown;
  CHARSET_INFO *cs;
};

int init_master_info(Master_info* mi, const char* master_info_fname,
		     const char* slave_info_fname,
		     bool abort_if_no_master_info_file,
		     int thread_mask);
void end_master_info(Master_info* mi);
int flush_master_info(Master_info* mi, 
                      bool flush_relay_log_cache, 
                      bool need_lock_relay_log);
void copy_filter_setting(Rpl_filter* dst_filter, Rpl_filter* src_filter);
void update_change_master_ids(DYNAMIC_ARRAY *new_ids, DYNAMIC_ARRAY *old_ids);
void prot_store_ids(THD *thd, DYNAMIC_ARRAY *ids);
void field_store_ids(Field *field, DYNAMIC_ARRAY *ids);
/*
  Multi master are handled trough this struct.
  Changes to this needs to be protected by LOCK_active_mi;
*/

class Master_info_index
{
private:
  IO_CACHE index_file;
  char index_file_name[FN_REFLEN];

public:
  Master_info_index();
  ~Master_info_index();

  HASH master_info_hash;

  bool init_all_master_info();
  bool write_master_name_to_index_file(LEX_CSTRING *connection_name,
                                       bool do_sync);

  bool check_duplicate_master_info(LEX_CSTRING *connection_name,
                                   const char *host, uint port);
  bool add_master_info(Master_info *mi, bool write_to_file);
  bool remove_master_info(Master_info *mi, bool clear_log_files);
  Master_info *get_master_info(const LEX_CSTRING *connection_name,
                               Sql_condition::enum_warning_level warning);
  bool start_all_slaves(THD *thd);
  bool stop_all_slaves(THD *thd);
  void free_connections();
  bool flush_all_relay_logs();
};


/*
  The class rpl_io_thread_info is the THD::system_thread_info for the IO thread.
*/
class rpl_io_thread_info
{
public:
};


Master_info *get_master_info(const LEX_CSTRING *connection_name,
                             Sql_condition::enum_warning_level warning);
bool check_master_connection_name(LEX_CSTRING *name);
void create_logfile_name_with_suffix(char *res_file_name, size_t length,
                             const char *info_file, 
                             bool append,
                             LEX_CSTRING *suffix);

uchar *get_key_master_info(Master_info *mi, size_t *length,
                           my_bool not_used __attribute__((unused)));
void free_key_master_info(Master_info *mi);
uint any_slave_sql_running(bool already_locked);
bool give_error_if_slave_running(bool already_lock);

/*
  Sets up the basic options for a MYSQL connection, mysql, to connect to the
  primary server described by the Master_info parameter, mi. The timeout must
  be passed explicitly, as different types of connections created by the slave
  will use different values.

  Assumes mysql_init() has already been called on the mysql connection object.
*/
void setup_mysql_connection_for_master(MYSQL *mysql, Master_info *mi,
                                       uint timeout);

#endif /* HAVE_REPLICATION */
#endif /* RPL_MI_H */
