��    �      �  �   �	                 :  &   L     s     �     �     �     �  /   �     "  "   B  1   e  �   �  "   3  j   V  o   �     1  D   O  !   �  3   �  ?   �  H   *  D   s  C   �  E   �  ?   B  ?   �  >   �  9     L   ;  B   �  E   �  �     0   �  F   �  >     B   M  I   �  %   �  <      O   =  7   �     �     �     �     �  M   �     I  -   Y  !   �  C   �  y   �  9   g  C   �  B   �  C   (  D   l  >   �  @   �  '   1  (   Y  ,   �  7   �  2   �  6     >   Q  *   �  /   �  7   �  4   #  %   X  %   ~  1   �  0   �  #        +  4   I  7   ~  2   �  5   �  0     /   P  +   �  -   �  3   �  7        F  +   f  1   �  6   �  6   �  1   2   *   d   "   �   7   �   "   �   $   !  J   2!     }!     �!  2   �!  0   �!     "  #   '"  !   K"     m"      �"  $   �"      �"  ,   �"      #  4   @#  %   u#  $   �#  "   �#  !   �#  u   $  F   {$     �$  7   �$  )   %  %   8%  &   ^%     �%     �%  /   �%  &   �%  0   &  .   4&  -   c&     �&     �&      �&  ,   �&     '  0   ''     X'     p'     ~'  M   �'  B   �'     (     /(     A(     W(  #   h(     �(     �(     �(     �(     �(      �(  "   )     8)  �  W)  Q   �*      O+  [   p+  C   �+  B   ,  C   S,  W   �,  ,   �,  /   -     L-  "   l-  1   �-  �   �-  "   ].  j   �.  p   �.     \/  E   z/  !   �/  |   �/  �   _0  �   �0  �   j1  �   2  �   �2  v   3  w   �3     4  Z   �4  �   �4  �   5  _   6  �   p6  Q   Q7  z   �7  w   8  �   �8  �   9  F   �9  m   �9  �   j:  a   ;     ;     �;  !   �;  #   �;  �   �;     �<  b   �<  7   <=  �   t=  -  ?>  �   m?  �   "@  �   �@  �   �A  �   8B  �   �B  �   �C  [   ND  Z   �D  a   E  �   gE  �   F  �   �F  �   G  s   �G  r   )H  ~   �H  �   I  S   �I  k   �I  �   fJ  }   �J  f   mK  K   �K  �    L  �   �L  ~   EM  �   �M  i   RN  m   �N  U   *O  c   �O  �   �O  �   �P  S   Q  q   [Q  }   �Q  �   KR  �   �R  z   S  f   �S  7   aT  u   �T  F   U  N   VU  �   �U  B   aV  F   �V  m   �V  l   YW      �W  O   �W  G   7X  >   X  :   �X  F   �X  F   @Y  Z   �Y  7   �Y  �   Z  @   �Z  n   �Z  E   X[  E   �[  �   �[  �   �\  0   >]  w   o]  Z   �]  c   B^  Y   �^      _  ?   _  g   M_  Z   �_  q   `  Y   �`  S   �`  &   0a  "   Wa  O   za  y   �a  b   Db  d   �b  8   c     Ec     ac  �   ~c  �   d  3   �d  (   �d  C   �d  8   2e  |   ke  +   �e  &   f  -   ;f  F   if  ]   �f  N   g  `   ]g  L   �g         �       /       N   l   8       �   O           !   �   �   j   �                  m   �   E       =   *       C       Q      t          &          �   \              B      _      >   �       ?   z           �       -           
      K   4   D       i   U   p   6   �   �   `   c                      1              @   P   7   {   �   Z          d   "           �      :       9   q           �   g   )   T   A   W   ^       .   �   ;   $   o      �                           f   �   y   b   2   <   s         	   e   �           #       J   �       3   ]   �   v               x      G      �   +   (   �   ,   n   �   �   Y   L   �   5   F       u       V   ~   �       �          %   H         X   |      k   }      R       S   r   �       0   [       a       h   I       M   '      w                  
Allowed signal names for kill:
 
Common options:
 
Options for register and unregister:
 
Options for start or restart:
 
Options for stop or restart:
 
Report bugs to <%s>.
 
Shutdown modes are:
 
Start types are:
   %s init[db]   [-D DATADIR] [-s] [-o OPTIONS]
   %s kill       SIGNALNAME PID
   %s logrotate  [-D DATADIR] [-s]
   %s promote    [-D DATADIR] [-W] [-t SECS] [-s]
   %s register   [-D DATADIR] [-N SERVICENAME] [-U USERNAME] [-P PASSWORD]
                    [-S START-TYPE] [-e SOURCE] [-W] [-t SECS] [-s] [-o OPTIONS]
   %s reload     [-D DATADIR] [-s]
   %s restart    [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-c]
   %s start      [-D DATADIR] [-l FILENAME] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-p PATH] [-c]
   %s status     [-D DATADIR]
   %s stop       [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
   %s unregister [-N SERVICENAME]
   -?, --help             show this help, then exit
   -D, --pgdata=DATADIR   location of the database storage area
   -N SERVICENAME  service name with which to register PostgreSQL server
   -P PASSWORD     password of account to register PostgreSQL server
   -S START-TYPE   service start type to register PostgreSQL server
   -U USERNAME     user name of account to register PostgreSQL server
   -V, --version          output version information, then exit
   -W, --no-wait          do not wait until operation completes
   -c, --core-files       allow postgres to produce core files
   -c, --core-files       not applicable on this platform
   -e SOURCE              event source for logging when running as a service
   -l, --log=FILENAME     write (or append) server log to FILENAME
   -m, --mode=MODE        MODE can be "smart", "fast", or "immediate"
   -o, --options=OPTIONS  command line options to pass to postgres
                         (PostgreSQL server executable) or initdb
   -p PATH-TO-POSTGRES    normally not necessary
   -s, --silent           only print errors, no informational messages
   -t, --timeout=SECS     seconds to wait when using -w option
   -w, --wait             wait until operation completes (default)
   auto       start service automatically during system startup (default)
   demand     start service on demand
   fast        quit directly, with proper shutdown (default)
   immediate   quit without complete shutdown; will lead to recovery on restart
   smart       quit after all clients have disconnected
  done
  failed
  stopped waiting
 %s home page: <%s>
 %s is a utility to initialize, start, stop, or control a PostgreSQL server.

 %s() failed: %m %s: -S option not supported on this platform
 %s: PID file "%s" does not exist
 %s: another server might be running; trying to start server anyway
 %s: cannot be run as root
Please log in (using, e.g., "su") as the (unprivileged) user that will
own the server process.
 %s: cannot promote server; server is not in standby mode
 %s: cannot promote server; single-user server is running (PID: %d)
 %s: cannot reload server; single-user server is running (PID: %d)
 %s: cannot restart server; single-user server is running (PID: %d)
 %s: cannot rotate log file; single-user server is running (PID: %d)
 %s: cannot set core file size limit; disallowed by hard limit
 %s: cannot stop server; single-user server is running (PID: %d)
 %s: control file appears to be corrupt
 %s: could not access directory "%s": %s
 %s: could not allocate SIDs: error code %lu
 %s: could not create log rotation signal file "%s": %s
 %s: could not create promote signal file "%s": %s
 %s: could not create restricted token: error code %lu
 %s: could not determine the data directory using command "%s"
 %s: could not find own program executable
 %s: could not find postgres program executable
 %s: could not get LUIDs for privileges: error code %lu
 %s: could not get token information: error code %lu
 %s: could not open PID file "%s": %s
 %s: could not open log file "%s": %s
 %s: could not open process token: error code %lu
 %s: could not open service "%s": error code %lu
 %s: could not open service manager
 %s: could not read file "%s"
 %s: could not register service "%s": error code %lu
 %s: could not remove log rotation signal file "%s": %s
 %s: could not remove promote signal file "%s": %s
 %s: could not send log rotation signal (PID: %d): %s
 %s: could not send promote signal (PID: %d): %s
 %s: could not send reload signal (PID: %d): %s
 %s: could not send signal %d (PID: %d): %s
 %s: could not send stop signal (PID: %d): %s
 %s: could not start server
Examine the log output.
 %s: could not start server due to setsid() failure: %s
 %s: could not start server: %s
 %s: could not start server: error code %lu
 %s: could not start service "%s": error code %lu
 %s: could not unregister service "%s": error code %lu
 %s: could not write log rotation signal file "%s": %s
 %s: could not write promote signal file "%s": %s
 %s: database system initialization failed
 %s: directory "%s" does not exist
 %s: directory "%s" is not a database cluster directory
 %s: invalid data in PID file "%s"
 %s: missing arguments for kill mode
 %s: no database directory specified and environment variable PGDATA unset
 %s: no operation specified
 %s: no server running
 %s: old server process (PID: %d) seems to be gone
 %s: option file "%s" must have exactly one line
 %s: out of memory
 %s: server did not promote in time
 %s: server did not start in time
 %s: server does not shut down
 %s: server is running (PID: %d)
 %s: service "%s" already registered
 %s: service "%s" not registered
 %s: single-user server is running (PID: %d)
 %s: the PID file "%s" is empty
 %s: too many command-line arguments (first is "%s")
 %s: unrecognized operation mode "%s"
 %s: unrecognized shutdown mode "%s"
 %s: unrecognized signal name "%s"
 %s: unrecognized start type "%s"
 HINT: The "-m fast" option immediately disconnects sessions rather than
waiting for session-initiated disconnection.
 If the -D option is omitted, the environment variable PGDATA is used.
 Is server running?
 Please terminate the single-user server and try again.
 Server started and accepting connections
 Timed out waiting for server startup
 Try "%s --help" for more information.
 Usage:
 Waiting for server startup...
 cannot duplicate null pointer (internal error)
 child process exited with exit code %d child process exited with unrecognized status %d child process was terminated by exception 0x%X child process was terminated by signal %d: %s command not executable command not found could not find a "%s" to execute could not get current working directory: %s
 could not read binary "%s": %m could not resolve path "%s" to absolute form: %m invalid binary "%s": %m out of memory out of memory
 program "%s" is needed by %s but was not found in the same directory as "%s"
 program "%s" was found by "%s" but was not the same version as %s
 server promoted
 server promoting
 server shutting down
 server signaled
 server signaled to rotate log file
 server started
 server starting
 server stopped
 starting server anyway
 trying to start server anyway
 waiting for server to promote... waiting for server to shut down... waiting for server to start... Project-Id-Version: pg_ctl (PostgreSQL) 15
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2023-08-14 23:18+0000
PO-Revision-Date: 2023-08-15 13:37+0200
Last-Translator: Georgios Kokolatos <gkokolatos@pm.me>
Language-Team: 
Language: el
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=(n != 1);
X-Generator: Poedit 3.3.2
 
Επιτρεπόμενα ονόματα σημάτων για θανάτωση:
 
Κοινές επιλογές:
 
Επιλογές καταχώρησης και διαγραφής καταχώρησης:
 
Επιλογές για έναρξη ή επανεκκίνηση:
 
Επιλογές διακοπής ή επανεκκίνησης:
 
Υποβάλετε αναφορές σφάλματων σε <%s>.
 
Οι λειτουργίες τερματισμού λειτουργίας είναι:
 
Οι τύποι έναρξης είναι:
   %s init[db]   [-D DATADIR] [-s] [-o OPTIONS]
   %s kill       SIGNALNAME PID
   %s logrotate  [-D DATADIR] [-s]
   %s promote    [-D DATADIR] [-W] [-t SECS] [-s]
   %s register   [-D DATADIR] [-N SERVICENAME] [-U USERNAME] [-P PASSWORD]
                    [-S START-TYPE] [-e SOURCE] [-W] [-t SECS] [-s] [-o OPTIONS]
   %s reload     [-D DATADIR] [-s]
   %s restart    [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-c]
   %s start      [-D DATADIR] [-l FILENAME] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-p PATH] [-c]

   %s status     [-D DATADIR]
   %s stop       [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]

   %s unregister [-N SERVICENAME]
   -?, --help             εμφάνισε αυτό το μήνυμα βοήθειας, στη συνέχεια έξοδος
  [-D, --pgdata=]DATADIR  τοποθεσία για τη περιοχή αποθήκευσης της βάσης δεδομένων
   -N SERVICENAME  όνομα υπηρεσίας με το οποίο θα καταχωρηθεί ο διακομιστής PostgreSQL
   -P PASSWORD     κωδικός πρόσβασης του λογαριασμού για την καταγραφή του διακομιστή PostgreSQL
   -S START-TYPE   τύπος έναρξης υπηρεσίας για την καταχώρηση διακομιστή PostgreSQL
   -U USERNAME     όνομα χρήστη του λογαριασμού για την καταγραφή του διακομιστή PostgreSQL
   -V, --version          εμφάνισε πληροφορίες έκδοσης, στη συνέχεια έξοδος
   -W, --no-wait          να μην περιμένει μέχρι να ολοκληρωθεί η λειτουργία
   -c, --core-files       επίτρεψε στην postgres να παράγει αρχεία αποτύπωσης μνήμης
   -c, --core-files       ανεφάρμοστο σε αυτήν την πλατφόρμα
   -e SOURCE              πηγή προέλευσης συμβάντων για καταγραφή κατά την εκτέλεση ως υπηρεσία
   -l, --log=FILENAME     ενέγραψε (ή προσάρτησε) το αρχείο καταγραφής διακομιστή στο FILENAME
   -m, --mode=MODE        MODE μπορεί να είνα «smart», «fast», ή «immediate»
   -o, --options=OPTIONS  επιλογές γραμμής εντολών που θα διαβιστούν στη postgres
                         (εκτελέσιμο αρχείο διακομιστή PostgreSQL) ή initdb
   -p PATH-TO-POSTGRES    κανονικά δεν είναι απαραίτητο
   -s, --silent           εκτύπωση μόνο σφαλμάτων, χωρίς ενημερωτικά μηνύματα
   -t, --timeout=SECS     δευτερόλεπτα αναμονής κατά τη χρήση της επιλογής -w
   -w, --wait             περίμενε μέχρι να ολοκληρωθεί η λειτουργία (προεπιλογή)
   auto       αυτόματη εκκίνηση της υπηρεσίας κατά την εκκίνηση του συστήματος (προεπιλογή)
   demand     έναρξη υπηρεσίας κατ' απαίτηση
   fast        διάκοψε απευθείας, με σωστό τερματισμό (προεπιλογή)
   immediate   διάκοψε άμεσα χωρίς πλήρη τερματισμό· Θα οδηγήσει σε αποκατάσταση κατά την επανεκκίνηση
   smart       διάκοψε μετά την αποσύνδεση όλων των πελατών
  ολοκλήρωση
  απέτυχε.
  διακοπή αναμονής
 %s αρχική σελίδα: <%s>
 %s είναι ένα βοηθητικό πρόγραμμα για την αρχικοποίηση, την εκκίνηση, τη διακοπή ή τον έλεγχο ενός διακομιστή PostgreSQL.

 %s() απέτυχε: %m %s: επιλογή -S δεν υποστηρίζεται σε αυτήν την πλατφόρμα
 %s: το αρχείο PID «%s» δεν υπάρχει
 %s: ενδέχεται να εκτελείται ένας άλλος διακομιστής· γίνεται προσπάθεια εκκίνησης του διακομιστή ούτως ή άλλως
 %s: δεν είναι δυνατή η εκτέλεση ως υπερχρήστης
Συνδεθείτε (χρησιμοποιώντας, π.χ. "su") ως (μη προνομιούχο) χρήστη που θα
να είναι στην κατοχή της η διαδικασία διακομιστή.
 %s: δεν είναι δυνατή η προβίβαση του διακομιστή· ο διακομιστής δεν βρίσκεται σε κατάσταση αναμονής
 %s: δεν είναι δυνατή η προβίβαση του διακομιστή· εκτελείται διακομιστής μοναδικού-χρήστη (PID: %d)
 %s: δεν είναι δυνατή η επαναφόρτωση του διακομιστή· εκτελείται διακομιστής μοναδικού-χρήστη (PID: %d)
 %s: δεν είναι δυνατή η επανεκκίνηση του διακομιστή· εκτελείται διακομιστής μοναδικού-χρήστη (PID: %d)
 %s: δεν είναι δυνατή η περιστροφή του αρχείου καταγραφής· εκτελείται διακομιστής μοναδικού-χρήστη (PID: %d)
 %s: δεν είναι δυνατός ο ορισμός ορίου μεγέθους αρχείου πυρήνα· απαγορεύεται από το σκληρό όριο
 %s: δεν είναι δυνατή η διακοπή του διακομιστή· εκτελείται διακομιστής μοναδικού-χρήστη (PID: %d)
 %s: το αρχείο ελέγχου φαίνεται να είναι αλλοιωμένο
 %s: δεν ήταν δυνατή η πρόσβαση στον κατάλογο «%s»: %s
 %s: δεν ήταν δυνατή η εκχώρηση SIDs: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατή η δημιουργία αρχείου σήματος περιστροφής αρχείου καταγραφής «%s»: %s
 %s: δεν ήταν δυνατή η δημιουργία του αρχείου σήματος προβιβασμού «%s»: %s
 %s: δεν ήταν δυνατή η δημιουργία περιορισμένου διακριτικού: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατός ο προσδιορισμός του καταλόγου δεδομένων με χρήση της εντολής «%s»
 %s: δεν ήταν δυνατή η εύρεση του ιδίου εκτελέσιμου προγράμματος
 %s:  δεν ήταν δυνατή η εύρεση του εκτελέσιμου προγράμματος postgres
 %s: δεν ήταν δυνατή η ανάκτηση LUIDs για δικαιώματα: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατή η ανάκτηση πληροφοριών διακριτικού: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατό το άνοιγμα αρχείου PID «%s»: %s
 %s: δεν ήταν δυνατό το άνοιγμα του αρχείου καταγραφής «%s»: %s
 %s: δεν ήταν δυνατό το άνοιγμα διακριτικού διεργασίας: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατό το άνοιγμα της υπηρεσίας «%s»: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατό το άνοιγμα του διαχειριστή υπηρεσιών
 %s: δεν ήταν δυνατή η ανάγνωση αρχείου «%s»
 %s: δεν ήταν δυνατή η καταχώρηση της υπηρεσίας «%s»: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατή η κατάργηση του αρχείου σήματος περιστροφής αρχείου καταγραφής «%s»: %s
 %s: δεν ήταν δυνατή η κατάργηση του αρχείου σήματος προβιβασμού «%s»: %s
 %s: δεν ήταν δυνατή η αποστολή σήματος περιστροφής αρχείου καταγραφής (PID: %d): %s
 %s: δεν ήταν δυνατή η αποστολή σήματος προβιβασμού (PID: %d): %s
 %s: δεν ήταν δυνατή η αποστολή σήματος επαναφόρτωσης (PID: %d): %s
 %s: δεν ήταν δυνατή η αποστολή %d σήματος (PID: %d): %s
 %s: δεν ήταν δυνατή η αποστολή σήματος διακοπής (PID: %d): %s
 %s: δεν ήταν δυνατή η εκκίνηση του διακομιστή
Εξετάστε την έξοδο του αρχείου καταγραφής.
 %s: δεν ήταν δυνατή η εκκίνηση του διακομιστή λόγω αποτυχίας του setsid(): %s
 %s:  δεν μπόρεσε να εκκινήσει τον διακομιστή: %s
 %s: δεν ήταν δυνατή η εκκίνηση διακομιστή: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατή η εκκίνηση της υπηρεσίας «%s»: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατή η διαγραφή καταχώρησης της υπηρεσίας «%s»: κωδικός σφάλματος %lu
 %s: δεν ήταν δυνατή η εγγραφή του αρχείου σήματος περιστροφής αρχείου καταγραφής «%s»: %s
 %s: δεν ήταν δυνατή η εγγραφή του αρχείου σήματος προβιβασμού «%s»: %s
 %s: αρχικοποίηση του συστήματος βάσης δεδομένων απέτυχε
 %s: ο κατάλογος «%s» δεν υπάρχει
 %s: ο κατάλογος «%s» δεν είναι κατάλογος συστάδας βάσης δεδομένων
 %s: μη έγκυρα δεδομένα στο αρχείο PID «%s»
 %s: λείπουν παράμετροι για τη λειτουργία kill
 %s: δεν έχει καθοριστεί κατάλογος βάσης δεδομένων και δεν έχει καθοριστεί μεταβλητή περιβάλλοντος PGDATA
 %s: δεν καθορίστηκε καμία λειτουργία
 %s: δεν εκτελείται κανένας διακομιστής
 %s: παλεά διαδικασία διακομιστή (PID: %d) φαίνεται να έχει χαθεί
 %s: το αρχείο επιλογής «%s» πρέπει να έχει ακριβώς μία γραμμή
 %s: έλλειψη μνήμης
 %s: ο διακομιστής δεν προβιβάστηκε εγκαίρως
 %s: ο διακομιστής δεν ξεκίνησε εγκαίρως
 %s: ο διακομιστής δεν τερματίζεται
 %s: εκτελείται διακομιστής (PID: %d)
 %s: η υπηρεσία «%s» έχει ήδη καταχωρηθεί
 %s: η υπηρεσία «%s» δεν έχει καταχωρηθεί
 %s: εκτελείται διακομιστής μοναδικού-χρήστη (PID: %d)
 %s: το αρχείο PID «%s» είναι άδειο
 %s: πάρα πολλές παράμετροι εισόδου από την γραμμή εντολών (η πρώτη είναι η «%s»)
 %s: μη αναγνωρισμένη λειτουργία «%s»
 %s: μη αναγνωρισμένη λειτουργία τερματισμού λειτουργίας «%s»
 %s: μη αναγνωρισμένο όνομα σήματος «%s»
 %s: μη αναγνωρίσιμος τύπος έναρξης «%s»
 HINT: Η επιλογή "-m fast" αποσυνδέει αμέσως τις συνεδρίες αντί
να αναμένει για εκ’ συνεδρίας εκκινούμενη αποσύνδεση.
 Εάν παραλειφθεί η επιλογή -D, χρησιμοποιείται η μεταβλητή περιβάλλοντος PGDATA.
 Εκτελείται ο διακομιστής;
 Τερματίστε το διακομιστή μοναδικού-χρήστη και προσπαθήστε ξανά.
 Ο διακομιστής ξεκίνησε και αποδέχτηκε συνδέσεις
 Λήξη χρονικού ορίου αναμονής για εκκίνηση διακομιστή
 Δοκιμάστε «%s --help» για περισσότερες πληροφορίες.
 Χρήση:
 Αναμονή για εκκίνηση διακομιστή...
 δεν ήταν δυνατή η αντιγραφή δείκτη null (εσωτερικό σφάλμα)
 απόγονος διεργασίας τερμάτισε με κωδικό εξόδου %d απόγονος διεργασίας τερμάτισε με μη αναγνωρίσιμη κατάσταση %d απόγονος διεργασίας τερματίστηκε με εξαίρεση 0x%X απόγονος διεργασίας τερματίστηκε με σήμα %d: %s εντολή μη εκτελέσιμη εντολή δεν βρέθηκε δεν βρέθηκε το αρχείο «%s» για να εκτελεστεί δεν ήταν δυνατή η επεξεργασία του τρέχοντος καταλόγου εργασίας: %s
 δεν ήταν δυνατή η ανάγνωση του δυαδικού αρχείου «%s»: %m δεν δύναται η επίλυση διαδρομής «%s» σε απόλυτη μορφή: %m μη έγκυρο δυαδικό αρχείο «%s»: %m έλλειψη μνήμης έλλειψη μνήμης
 το πρόγραμμα «%s» χρειάζεται από %s αλλά δεν βρέθηκε στον ίδιο κατάλογο με το «%s»
 το πρόγραμμα «%s» βρέθηκε από το «%s» αλλά δεν ήταν η ίδια έκδοση με το %s
 ο διακομιστής προβιβάστηκε
 προβίβαση διακομιστή
 τερματισμός λειτουργίας διακομιστή
 στάλθηκε σήμα στον διακομιστή
 ο διακομιστής έλαβε σήμα για την περιστροφή του αρχείου καταγραφής
 ο διακομιστής ξεκίνησε
 εκκίνηση διακομιστή
 ο διακομιστής διακόπηκε
 εκκίνηση του διακομιστή ούτως ή άλλως
 προσπάθεια εκκίνησης του διακομιστή ούτως ή άλλως
 αναμονή για την προβίβαση του διακομιστή... αναμονή για τερματισμό λειτουργίας του διακομιστή... αναμονή για την εκκίνηση του διακομιστή... 