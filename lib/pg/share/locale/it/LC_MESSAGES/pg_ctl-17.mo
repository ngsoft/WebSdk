��    �      �  �   �	            	     *  &   <     c     �     �     �     �  /   �       "   2  1   U  �   �  "   #  j   F  o   �     !  D   ?  !   �  3   �  ?   �  H     D   c  C   �  E   �  ?   2  ?   r  >   �  9   �  L   +  B   x  E   �  �     0   �  F   �  >   �  B   =  I   �  %   �  <   �  O   -  7   }     �     �     �     �  M   �     9  -   I  !   w  C   �  y   �  9   W  C   �  B   �  C     D   \  >   �  @   �  '   !  (   I  ,   r  7   �  2   �  6   
  >   A  *   �  /   �  7   �  4     %   H  %   n  1   �  0   �  #   �       4   9  7   n  2   �  5   �  0     /   @  +   p  -   �  3   �  7   �     6  +   V  1   �  6   �  6   �  1   "   *   T   "      7   �   "   �   $   �   J   "!     m!     �!  2   �!  0   �!     "  #   "  !   ;"     ]"      |"  $   �"      �"  ,   �"     #  4   0#  %   e#  $   �#  "   �#  !   �#  u   �#  F   k$     �$  7   �$  )   �$  %   (%  &   N%     u%     }%  /   �%  &   �%  0   �%  .   $&  -   S&     �&     �&      �&  ,   �&     �&     '     /'     ='  M   L'  B   �'     �'     �'      (     (  #   '(     K(     [(     l(     |(     �(      �(  "   �(     �(  �  )  $   +     1+  $   C+  #   h+  %   �+     �+     �+     �+  /    ,     0,  "   P,  1   s,  �   �,  "   A-  j   d-  s   �-     C.  D   a.     �.  5   �.  K   �.  L   G/  Q   �/  U   �/  S   <0  D   �0  M   �0  C   #1  ?   g1  R   �1  I   �1  H   D2  �   �2  4   '3  P   \3  I   �3  Q   �3  Y   I4  0   �4  T   �4  p   )5  B   �5     �5  	   �5     �5     6  \    6     }6  9   �6      �6  c   �6  �   R7  Q   �7  n   ;8  w   �8  m   "9  e   �9  `   �9  k   W:  )   �:  ,   �:  3   ;  N   N;  A   �;  =   �;  T   <  9   r<  :   �<  H   �<  I   0=  +   z=  .   �=  >   �=  :   >  )   O>  "   y>  ?   �>  Q   �>  A   .?  K   p?  :   �?  2   �?  /   *@  7   Z@  <   �@  F   �@  #   A  7   :A  A   rA  O   �A  P   B  A   UB  5   �B  !   �B  D   �B  &   4C  3   [C  l   �C  #   �C       D  K   AD  <   �D     �D  7   �D  0   E  "   IE  )   lE  (   �E  '   �E  G   �E     /F  >   NF  -   �F  *   �F  &   �F  #   G  }   1G  G   �G     �G  L   H  +   aH  5   �H  -   �H  
   �H  $   �H  :   !I  .   \I  4   �I  +   �I  9   �I     &J     =J  &   QJ  4   xJ  $   �J     �J     �J     �J  ^   K  R   pK     �K     �K      �K     L  6   0L     gL     �L     �L  #   �L  0   �L  (   M  %   :M  #   `M         �       /       N   l   8       �   O           !   �   �   j   �                  m   �   E       =   *       C       Q      t          &          �   \              B      _      >   �       ?   z           �       -           
      K   4   D       i   U   p   6   �   �   `   c                      1              @   P   7   {   �   Z          d   "           �      :       9   q           �   g   )   T   A   W   ^       .       ;   $   o      �                           f   �   y   b   2   <   s         	   e   �           #       J   �       3   ]   �   v               x      G      �   +   (   �   ,   n   �   �   Y   L   �   5   F       u       V   ~   �       �          %   H         X   |      k   }      R       S   r   �       0   [       a       h   I       M   '      w                  
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
 could not read binary "%s": %m invalid binary "%s": %m out of memory out of memory
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
 waiting for server to promote... waiting for server to shut down... waiting for server to start... Project-Id-Version: pg_ctl (PostgreSQL) 11
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2023-04-24 03:48+0000
PO-Revision-Date: 2023-09-05 08:14+0200
Last-Translator: Domenico Sgarbossa <sgarbossa.domenico@gmail.com>
Language-Team: https://github.com/dvarrazzo/postgresql-it
Language: it
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Poedit-SourceCharset: utf-8
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Poedit 2.3
 
Nomi di segnali permessi per kill:
 
Opzioni comuni:
 
Opzioni per register e unregister:
 
Opzioni per l'avvio o il riavvio:
 
Opzioni per l'arresto o il riavvio:
 
Segnala i bug a <%s>.
 
I modi di spegnimento sono:
 
I tipi di avvio sono:
   %s init[db]   [-D DATADIR] [-s] [-o OPTIONS]
   %s kill       SIGNALNAME PID
   %s logrotate  [-D DATADIR] [-s]
   %s promote    [-D DATADIR] [-W] [-t SECS] [-s]
   %s register   [-D DATADIR] [-N SERVICENAME] [-U USERNAME] [-P PASSWORD]
                    [-S START-TYPE] [-e SOURCE] [-W] [-t SECS] [-s] [-o OPTIONS]
   %s reload     [-D DATADIR] [-s]
   %s restart    [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
                    [-o OPZIONI] [-c]
   %s start      [-D DATADIR] [-l FILENAME] [-W] [-t SECS] [-s]
                    [-o OPZIONI] [-p PERCORSO] [-c]
   %s status     [-D DATADIR]
    %s stop      [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
   %s unregister [-N SERVIZIO]
   -?, --help             mostra questo aiuto ed esci
   -D, --pgdata DATADIR   posizione dell'area di archiviazione del database
   -N SERVIZIO     nome del servizio con cui registrare il server PostgreSQL
   -P PASSWORD     password per l'account con cui registrare il server PostgreSQL
   -S TIPO-AVVIO   tipo di avvio del servizio con cui registrare il server PostgreSQL
   -U UTENTE       nome utente dell'account con cui registrare il server PostgreSQL
   -V, --version          mostra informazioni sulla versione ed esci
   -W, --no-wait          non aspettare fino al completamento dell'operazione
   -c, --core-files       permette a postgres di produrre core file
   -c, --core-files       non disponibile su questa piattaforma
   -e SORGENTE            sorgente eventi per il log quando eseguito come servizio
   -l, --log NOMEFILE     scrivi (o accoda) il log del server in NOMEFILE
   -m, --mode=MODE        MODE può essere "smart", "fast" o "immediate"
   -o, --options=OPZIONI  opzioni da riga di comando da passare a postgres
                         (programma eseguibile del server PostgreSQL) o initdb
   -p PATH-TO-POSTGRES    normalmente non necessario
   -s, --silent           mostra solo gli errori, non i messaggi di informazione
   -t, --timeout=SEC      secondi da aspettare quando si usa l'opzione -w
   -w, --wait             aspetta fino al completamento dell'operazione (default)
   auto       avvia il servizio automaticamente durante l'avvio del sistema (predefinito)
   demand     avvia il servizio quando richiesto
   fast        termina direttamente, con una corretta procedura di arresto (default)
   immediate   termina senza un arresto completo: ciò porterà ad un recupero
              dei dati al riavvio
   smart       termina dopo che tutti i client si sono disconnessi
  fatto
  fallito
  attesa interrotta
 Pagina iniziale di %s: <%s>
 %s è un programma per inizializzare, avviare, fermare o controllare un server PostgreSQL.

 %s() non riuscito: %m %s: l'opzione -S non è supportata su questa piattaforma
 %s: il file PID "%s" non esiste
 %s: un altro server potrebbe essere in esecuzione; si sta provando ad avviare il server ugualmente
 %s: non può essere eseguito da root
Effettua il login (usando per esempio "su") con l'utente
(non privilegiato) che controllerà il processo server.
 %s: non è possibile promuovere il server: il server non è in modalità standby
 %s: non è possibile promuovere il server: il server è in esecuzione in modalità a utente singolo (PID: %d)
 %s: non è possibile eseguire il reload del server; il server è in esecuzione in modalità a utente singolo (PID: %d)
 %s: non è possibile riavviare il server; il server è in esecuzione in modalità a utente singolo (PID: %d)
 %s: impossibile ruotare il file di registro; il server per utente singolo è in esecuzione (PID: %d)
 %s: non è possibile configurare il limite di grandezza dei core file; impedito dall'hard limit
 %s: non è possibile fermare il server; il server è in esecuzione in modalità a utente singolo (PID: %d)
 %s: il file di controllo sembra corrotto
 %s: accesso alla directory "%s" fallito: %s
 %s: allocazione dei SID fallita: codice errore %lu
 %s: impossibile creare il file del segnale di rotazione del registro "%s": %s
 %s: creazione del file di segnale di promozione "%s" fallito: %s
 %s: creazione del token ristretto fallita: codice errore %lu
 %s: non è stato possibile determinare la directory dei dati usando il comando "%s"
 %s: il proprio programma eseguibile non è stato trovato
 %s: il programma eseguibile postgres non è stato trovato
 %s: errore nella lettura dei LUID per i privilegi: codice di errore %lu
 %s: errore nella lettura del token di informazione: codice di errore %lu
 %s: apertura del file PID "%s" fallita: %s
 %s: apertura del file di log "%s" fallita: %s
 %s: apertura del token di processo fallita: codice errore %lu
 %s: apertura del servizio "%s" fallita: codice errore %lu
 %s: apertura del service manager fallita
 %s: lettura del file "%s" fallita
 %s: registrazione del servizio "%s" fallita: codice errore %lu
 %s: impossibile rimuovere il file del segnale di rotazione del registro "%s": %s
 %s: rimozione del file di segnale di promozione "%s" fallita: %s
 %s: impossibile inviare il segnale di rotazione del registro (PID: %d): %s
 %s: invio del segnale di promozione fallito (PID: %d): %s
 %s: invio segnale di reload fallito (PID: %d): %s
 %s: invio del segnale %d fallito (PID: %d): %s
 %s: invio del segnale di arresto fallito (PID: %d): %s
 %s: l'avvio del server è fallito
Esamina il log di output.
 %s: impossibile avviare il server a causa di un errore di setid(): %s
 %s: errore di avvio del server: %s
 %s: errore di avvio del server: codice dell'errore %lu
 %s: non è possibile avviare il servizio "%s": codice errore %lu
 %s: rimozione della registrazione del servizio "%s" fallita: codice errore %lu
 %s: impossibile scrivere il file del segnale di rotazione del registro "%s": %s
 %s: scrittura del file di segnale di promozione "%s" fallita: %s
 %s: inizializzazione del sistema di database fallita
 %s: la directory "%s" non esiste
 %s: la directory "%s" non è la directory di un cluster di database
 %s: dati non validi nel file PID "%s"
 %s: mancano gli argomenti per la modalità di kill
 %s: nessuna directory del database è stata specificata e la variabile d'ambiente PGDATA non è configurata
 %s: nessuna operazione specificata
 %s: nessun server in esecuzione
 %s: il vecchio processo del server (PID: %d) sembra non essere più attivo
 %s: il file di opzione "%s" deve avere esattamente una riga
 %s: memoria esaurita
 %s: il server non è stato promosso nel tempo previsto
 %s: il server non è partito nel tempo previsto
 %s: il server non si è arrestato
 %s: il server è in esecuzione (PID: %d)
 %s: il servizio "%s" è già registrato
 %s: il servizio "%s" non è registrato
 %s: il server è in esecuzione in modalità a utente singolo (PID: %d)
 %s: il file PID "%s" è vuoto
 %s: troppi argomenti nella riga di comando (il primo è "%s")
 %s: modalità di operazione sconosciuta "%s"
 %s: modalità di arresto sconosciuta "%s"
 %s: nome del segnale sconosciuto "%s"
 %s: tipo di avvio sconosciuto "%s"
 NOTA: L'opzione "-m fast" disconnette le sessioni immediatamente invece di
attendere che siano le sessioni a disconnettersi.
 Se l'opzione -D è omessa, viene usata la variabile d'ambiente PGDATA.
 Il server è in esecuzione?
 Si prega di terminare il server in modalità utente singolo e di riprovare.
 Il server è avviato e accetta connessioni
 Il tempo di attesa per l'avvio del server è scaduto
 Prova "%s --help" per maggiori informazioni.
 Utilizzo:
 In attesa che il server si avvii...
 impossibile duplicare il puntatore nullo (errore interno)
 processo figlio uscito con codice di uscita %d processo figlio uscito con stato non riconosciuto %d processo figlio terminato da eccezione 0x%X il processo figlio è stato terminato dal segnale %d: %s\ comando non eseguibile comando non trovato programma "%s" da eseguire non trovato determinazione della directory corrente fallita: %s
 lettura del binario "%s" fallita: %m binario non valido "%s": %m memoria esaurita memoria esaurita
 il programma "%s" è necessario per %s ma non è stato trovato nella stessa directory di "%s"
 il programma "%s" è stato trovato da "%s" ma non era della stessa versione di %s
 server promosso
 il server sta venendo promosso
 il server è in fase di arresto
 segnale inviato al server
 il server ha segnalato di ruotare il file di registro
 il server è stato avviato
 il server si sta avviando
 il server è stato arrestato
 il server si sta avviando comunque
 si sta provando ad avviare il server ugualmente
 in attesa della promozione del server... in attesa dell'arresto del server.... in attesa che il server si avvii... 