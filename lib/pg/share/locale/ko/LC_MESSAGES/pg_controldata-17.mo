Þ    ]           ì      è  X   é  
   B     M  3   f  ?     (   Ú  C   	     G	     [	     k	  ,   o	  ,   	  )   É	  )   ó	  )   
  )   G
  )   q
  )   
  +   Å
  )   ñ
  )     ,   E  )   r  ,     )   É  )   ó  )     ,   G  )   t  )     ,   È  )   õ  )     )   I  )   s  )     )   Ç  )   ñ  )     )   E  )   o  )     )   Ã  )   í  )     ,   A  )   n       )   ®  >  Ø  )     %   A     g  )   o  Æ     "   `                    °     Î  (   ì          2  (   O     x          ª     ¼  )   Ê  )   ô  )     )   H  )   r               »     ¿  )   Â  )   ì      	        &     <     J  /   V  )        °     É  )   à  )   
     4  ­  8  k   æ     R     _  >   x  ;   ·  0   ó  ]   $               ª  2   ®  2   á  9     0   N  1     4   ±  3   æ  5     7   P  5     4   ¾  9   ó  -   -  6   [  1     1   Ä  1   ö  4   (  1   ]  3     6   Ã  1   ú  1   ,  3   ^  6     8   É  9      6   <   7   s   6   «   6   â   /   !  0   I!  /   z!  6   ª!  5   á!  /   "     G"  1   f"  ¿   "  3   X#  =   #     Ê#  -   Ö#    $  $   %  	   1%     ;%     B%  *   ]%  -   %  8   ¶%  *   ï%  *   &  7   E&  '   }&     ¥&     ·&     Ó&  ,   ã&  ,   '  ,   ='  ,   j'  ,   '  	   Ä'  6   Î'     (     	(  0   (  -   =(  5  k(  	   ¡)     «)  
   Ç)  
   Ò)  C   Ý)  ,   !*     N*     j*  ,   *  ,   °*     Ý*     5            -   :               G   [   4                     1           $   J       ]   @                         !   2                  =       '   
       C         E   \   >   ;       "   &          D   Q          U   #   Y   <   L       3   Z      /       ,   	   %   8          (   N   I            7   H           V   .   0   9                  X   A              K   F   B      +   S   P      R   O   T   *      6      W   ?                                  )   M    
If no data directory (DATADIR) is specified, the environment variable PGDATA
is used.

 
Options:
   %s [OPTION] [DATADIR]
   -?, --help             show this help, then exit
   -V, --version          output version information, then exit
  [-D, --pgdata=]DATADIR  data directory
 %s displays control information of a PostgreSQL database cluster.

 %s home page: <%s>
 64-bit integers ??? Backup end location:                  %X/%X
 Backup start location:                %X/%X
 Blocks per segment of large relation: %u
 Bytes per WAL segment:                %u
 Catalog version number:               %u
 Data page checksum version:           %u
 Database block size:                  %u
 Database cluster state:               %s
 Database system identifier:           %llu
 Date/time type storage:               %s
 End-of-backup record required:        %s
 Fake LSN counter for unlogged rels:   %X/%X
 Float8 argument passing:              %s
 Latest checkpoint location:           %X/%X
 Latest checkpoint's NextMultiOffset:  %u
 Latest checkpoint's NextMultiXactId:  %u
 Latest checkpoint's NextOID:          %u
 Latest checkpoint's NextXID:          %u:%u
 Latest checkpoint's PrevTimeLineID:   %u
 Latest checkpoint's REDO WAL file:    %s
 Latest checkpoint's REDO location:    %X/%X
 Latest checkpoint's TimeLineID:       %u
 Latest checkpoint's full_page_writes: %s
 Latest checkpoint's newestCommitTsXid:%u
 Latest checkpoint's oldestActiveXID:  %u
 Latest checkpoint's oldestCommitTsXid:%u
 Latest checkpoint's oldestMulti's DB: %u
 Latest checkpoint's oldestMultiXid:   %u
 Latest checkpoint's oldestXID's DB:   %u
 Latest checkpoint's oldestXID:        %u
 Maximum columns in an index:          %u
 Maximum data alignment:               %u
 Maximum length of identifiers:        %u
 Maximum size of a TOAST chunk:        %u
 Min recovery ending loc's timeline:   %u
 Minimum recovery ending location:     %X/%X
 Mock authentication nonce:            %s
 Report bugs to <%s>.
 Size of a large-object chunk:         %u
 The WAL segment size stored in the file, %d byte, is not a power of two
between 1 MB and 1 GB.  The file is corrupt and the results below are
untrustworthy.

 The WAL segment size stored in the file, %d bytes, is not a power of two
between 1 MB and 1 GB.  The file is corrupt and the results below are
untrustworthy.

 Time of latest checkpoint:            %s
 Try "%s --help" for more information. Usage:
 WAL block size:                       %u
 WARNING: Calculated CRC checksum does not match value stored in file.
Either the file is corrupt, or it has a different layout than this program
is expecting.  The results below are untrustworthy.

 WARNING: invalid WAL segment size
 by reference by value byte ordering mismatch could not close file "%s": %m could not fsync file "%s": %m could not open file "%s" for reading: %m could not open file "%s": %m could not read file "%s": %m could not read file "%s": read %d of %zu could not write file "%s": %m in archive recovery in crash recovery in production max_connections setting:              %d
 max_locks_per_xact setting:           %d
 max_prepared_xacts setting:           %d
 max_wal_senders setting:              %d
 max_worker_processes setting:         %d
 no no data directory specified off on pg_control last modified:             %s
 pg_control version number:            %u
 possible byte ordering mismatch
The byte ordering used to store the pg_control file might not match the one
used by this program.  In that case the results below would be incorrect, and
the PostgreSQL installation would be incompatible with this data directory. shut down shut down in recovery shutting down starting up too many command-line arguments (first is "%s") track_commit_timestamp setting:       %s
 unrecognized status code unrecognized wal_level wal_level setting:                    %s
 wal_log_hints setting:                %s
 yes Project-Id-Version: pg_controldata (PostgreSQL) 16
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2023-09-07 05:52+0000
PO-Revision-Date: 2023-05-30 12:38+0900
Last-Translator: Ioseph Kim <ioseph@uri.sarang.net>
Language-Team: Korean Team <pgsql-kr@postgresql.kr>
Language: ko
MIME-Version: 1.0
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
 
DATADIRì¸ ë°ì´í° ëë í°ë¦¬ë¥¼ ì§ì íì§ ìì¼ë©°, PGDATA íê²½ ë³ìê°ì
ì¬ì©í©ëë¤.

 
ìµìë¤:
   %s [ìµì] [DATADIR]
   -?, --help             ì´ ëìë§ì ë³´ì¬ì£¼ê³  ë§ì¹¨
   -V, --version          ë²ì  ì ë³´ ë³´ì¬ì£¼ê³  ë§ì¹¨
  [-D, --pgdata=]DATADIR  ë°ì´í° ëë í°ë¦¬
 %s íë¡ê·¸ë¨ì PostgreSQL ë°ì´í°ë² ì´ì¤ í´ë¬ì¤í°ì ì ì´ì ë³´ë¥¼ ë³´ì¬ì¤.

 %s ííì´ì§: <%s>
 64-ë¹í¸ ì ì ??? ë°±ì ì¢ë£ ìì¹:                       %X/%X
 ë°±ì ìì ìì¹:                       %X/%X
 ëí ë¦´ë ì´ìì ì¸ê·¸ë¨¼í¸ë¹ ë¸ë­ ê°ì: %u
 WAL ì¸ê·¸ë¨¼í¸ì í¬ê¸°(byte):            %u
 ì¹´íë¡ê·¸ ë²ì  ë²í¸:                   %u
 ë°ì´í° íì´ì§ ì²´í¬ì¬ ë²ì :            %u
 ë°ì´í°ë² ì´ì¤ ë¸ë¡ í¬ê¸°:               %u
 ë°ì´í°ë² ì´ì¤ í´ë¬ì¤í° ìí:           %s
 ë°ì´í°ë² ì´ì¤ ìì¤í ìë³ì:           %llu
 ë ì§/ìê°í ìë£ì ì ì¥ë°©ì:          %s
 ë°±ì ì¢ë£ ë ì½ë íì ì¬ë¶:           %s
 ì¸ë¡ê·¸ ë¦´ë ì´ìì ê°ì§ LSN ì¹´ì´í°:    %X/%X
 Float8 ì¸ì ì ë¬:                     %s
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ìì¹:               %X/%X
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ NextMultiOffset:    %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ NextMultiXactId:    %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ NextOID:            %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ NextXID:            %u:%u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ PrevTimeLineID:     %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ REDO WAL íì¼:      %s
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ REDO ìì¹:          %X/%X
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ TimeLineID:         %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ full_page_writes:   %s
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ìµì CommitTsXid:    %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ì ì¼ì¤ëëActiveXID:%u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ì ì¼ì¤ëëCommitTsXid:%u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ì ì¼ì¤ëëë©í°Xid DB:%u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ì ì¼ì¤ëëMultiXid: %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ì ì¼ì¤ëëXIDì DB: %u
 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ì ì¼ì¤ëëXID:      %u
 ì¸ë±ì¤ìì ì¬ì©íë ìµë ì´ ì:       %u
 ìµë ìë£ ì ë ¬:                       %u
 ìë³ì ìµë ê¸¸ì´:                     %u
 TOAST ì²­í¬ ìµë í¬ê¸°:                 %u
 ìµì ë³µêµ¬ ì¢ë£ ìì¹ì íìë¼ì¸:       %u
 ìµì ë³µêµ¬ ë§ì§ë§ ìì¹:                %X/%X
 ìì ëª¨ì ì¸ì¦:                       %s
 ë¬¸ì ì  ë³´ê³  ì£¼ì: <%s>
 ëí ê°ì²´ ì²­í¬ í¬ê¸°:                  %u
 ì ì¥ë WAL ì¡°ê° íì¼ì í¬ê¸°ë %d ë°ì´í¸ìëë¤. ì´ ê°ì 1MBë¶í° 1GBì¬ì´
2^n ê°ì´ ìëëë¤.  íì¼ì´ ììëìì¼ë©°, ê²°ê³¼ ëí ë¯¿ì ì ììµëë¤.

 ë§ì§ë§ ì²´í¬í¬ì¸í¸ ìê°:               %s
 ìì¸í ì¬í­ì "%s --help" ëªë ¹ì¼ë¡ ì´í´ë³´ì¸ì. ì¬ì©ë²:
 WAL ë¸ë¡ í¬ê¸°:                        %u
 ê²½ê³ : ê³ì°ë CRC ì²´í¬ì¬ê°ì´ íì¼ì ìë ê°ê³¼ íë¦½ëë¤.
ì´ ê²½ì°ë íì¼ì´ ììëìê±°ë, ì´ íë¡ê·¸ë¨ê³¼ ì»¨í¸ë¡¤ íì¼ì ë²ì ì´ íë¦°
ê²½ì°ìëë¤. ê²°ê³¼ê°ë¤ì ë¯¿ì§ ëª»í  ê°ë¤ì´ ì¶ë ¥ë  ì ììµëë¤.

 ê²½ê³ : ìëª»ë WAL ì¡°ê° í¬ê¸°
 ì°¸ì¡°ë³ ê°ë³ ë°ì´í¸ ìì ë¶ì¼ì¹ "%s" íì¼ì ë«ì ì ììµëë¤: %m "%s" íì¼ì fsync í  ì ììµëë¤: %m "%s" íì¼ì ì½ê¸° ëª¨ëë¡ ì´ ì ììµëë¤: %m "%s" íì¼ì ì½ì ì ììµëë¤: %m "%s" íì¼ì ì½ì ì ììµëë¤: %m "%s" íì¼ì ì½ì ì ìì: %d ì½ì, ì ì²´ %zu "%s" íì¼ì ì¸ ì ììµëë¤: %m ìë£ ë³µêµ¬ ì¤ ë¹ì ì ì¢ë£ ë³µêµ¬ ì¤ ì ìê°ëì¤ max_connections ì¤ì ê°:               %d
 max_locks_per_xact ì¤ì ê°:            %d
 max_prepared_xacts ì¤ì ê°:            %d
 max_wal_senders ì¤ì ê°:               %d
 max_worker_processes ì¤ì ê°:          %d
 ìëì¤ ë°ì´í° ëë í°ë¦¬ë¥¼ ì§ì íì§ ìììµëë¤ off on pg_control ë§ì§ë§ ë³ê²½ìê°:           %s
 pg_control ë²ì  ë²í¸:                 %u
 ë°ì´í¸ ììê° ì¼ì¹íì§ ììµëë¤.
pg_control íì¼ì ì ì¥íë ë° ì¬ì©ë ë°ì´í¸ ììë 
ì´ íë¡ê·¸ë¨ìì ì¬ì©íë ììì ì¼ì¹í´ì¼ í©ëë¤.  ì´ ê²½ì° ìë ê²°ê³¼ë
ì¬ë°ë¥´ì§ ìì¼ë©° ì´ ë°ì´í° ëë í°ë¦¬ì PostgreSQLì ì¤ì¹í  ì ììµëë¤. ì¤ì§ë¨ ë³µêµ¬ ìì ì¤ ì¤ì§ë¨ ì¤ì§ ì¤ ìì ì¤ ëë¬´ ë§ì ëªë ¹í ì¸ìë¥¼ ì§ì íìµëë¤. (ì²ì "%s") track_commit_timestamp ì¤ì ê°:        %s
 ìì ìë ìí ì½ë ì ì ìë wal_level wal_level ì¤ì ê°:                     %s
 wal_log_hints ì¤ì ê°:                 %s
 ì 