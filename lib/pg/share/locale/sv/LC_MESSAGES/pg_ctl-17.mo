��    �        �   
      �      �     �  &   �     �          "     9     O  /   b     �  "   �  1   �  �     "   �  j   �  o   1     �  D   �  !     3   &  ?   Z  H   �  D   �  C   (  E   l  ?   �  ?   �  >   2  9   q  L   �  B   �  E   ;  �   �  0     F   7  >   ~  B   �  I      %   J  <   p  O   �  7   �     5     <     E     W  M   k     �  -   �  !   �  C     y   ]  9   �  C     B   U  C   �  D   �  >   !  @   `  '   �  (   �  ,   �  7     2   W  6   �  >   �  *      /   +  7   [  4   �  %   �  %   �  1     0   F  #   w     �  4   �  7   �  2   &  5   Y  0   �  /   �  +   �  -     3   J  7   ~     �  +   �  1      6   4   6   k   1   �   *   �   "   �   7   "!  "   Z!  $   }!  J   �!     �!     	"  2    "  0   S"     �"  #   �"  !   �"     �"      �"  $   #      B#  ,   c#     �#  4   �#  %   �#  $   $  "   0$  !   S$  u   u$  F   �$     2%  7   F%  )   ~%  %   �%  &   �%     �%     �%     &  /   3&  &   c&  0   �&  .   �&  -   �&     '     /'  "   A'      d'  ,   �'     �'  $   �'  0   �'     '(  $   ?(     d(     r(  M   �(  B   �(     )     #)     5)     K)  #   \)     �)     �)     �)     �)     �)      �)  "   	*     ,*  �  K*  ,   �+     !,  /   7,  #   g,  #   �,     �,     �,     �,  /   �,     )-  "   I-  0   l-  �   �-  "   >.  l   a.  p   �.     ?/  F   ]/  !   �/  ?   �/  <   0  F   C0  O   �0  M   �0  R   (1  A   {1  C   �1  ?   2  :   A2  T   |2  K   �2  J   3  �   h3  J   4  I   P4  L   �4  I   �4  D   15  (   v5  N   �5  S   �5  5   B6     x6     6     �6     �6  Z   �6     7  0   *7     [7  D   z7  ~   �7  C   >8  B   �8  B   �8  D   9  @   M9  S   �9  D   �9  %   ':  ,   M:  (   z:  5   �:  3   �:  @   ;  ?   N;  7   �;  '   �;  <   �;  4   +<  '   `<  (   �<  0   �<  1   �<  )   =      >=  5   _=  7   �=  5   �=  ?   >  6   C>  6   z>  .   �>  1   �>  9   ?  <   L?  "   �?  *   �?  1   �?  7   	@  6   A@  4   x@  ,   �@  "   �@  ;   �@      9A  *   ZA  N   �A     �A     �A  6   B  :   ?B     zB  #   �B      �B     �B     �B  )   C  (   8C  (   aC     �C  8   �C      �C  "    D     #D     AD  p   aD  I   �D     E  E   +E  .   qE  ,   �E  /   �E     �E     F     'F  -   BF      pF  -   �F  )   �F  )   �F     G     /G  #   GG  "   kG  3   �G      �G  (   �G  B   H     OH  ,   gH     �H     �H  I   �H  F   �H     DI     WI     jI     �I  *   �I     �I     �I     �I     �I  !   J  *   4J  ,   _J  '   �J     �   2   *              ,       �   )   5       K               J   �       _      H          &       E   6   <      O   �   �   8       -      4      �   7   M       �      9       �   f       1       R   �   A   k              N      o   T   V          0       }   >   �          �   !       u   z       x       #          n   +   ]   r              c           m   L               b   X   �   S   B   W      �   g   a   %      "   �      �       p       w   t   q   y   .       P       C           /      [   ^              \   �       d   �   
       �   (   �   l   �           Z   Q   $   i       j       @          ?   U              ;           v       Y   �               I   �   '   :          �   �       F   e   �       �       {       ~   �           `      �   =                	   h   �   �                 s   D   G          |   3      �   �    
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
 %s: could not access directory "%s": %m
 %s: could not allocate SIDs: error code %lu
 %s: could not create log rotation signal file "%s": %m
 %s: could not create promote signal file "%s": %m
 %s: could not create restricted token: error code %lu
 %s: could not determine the data directory using command "%s"
 %s: could not find own program executable
 %s: could not find postgres program executable
 %s: could not get LUIDs for privileges: error code %lu
 %s: could not get token information: error code %lu
 %s: could not open PID file "%s": %m
 %s: could not open log file "%s": %m
 %s: could not open process token: error code %lu
 %s: could not open service "%s": error code %lu
 %s: could not open service manager
 %s: could not read file "%s"
 %s: could not register service "%s": error code %lu
 %s: could not remove log rotation signal file "%s": %m
 %s: could not remove promote signal file "%s": %m
 %s: could not send log rotation signal (PID: %d): %m
 %s: could not send promote signal (PID: %d): %m
 %s: could not send reload signal (PID: %d): %m
 %s: could not send signal %d (PID: %d): %m
 %s: could not send stop signal (PID: %d): %m
 %s: could not start server
Examine the log output.
 %s: could not start server due to setsid() failure: %m
 %s: could not start server: %m
 %s: could not start server: error code %lu
 %s: could not start service "%s": error code %lu
 %s: could not unregister service "%s": error code %lu
 %s: could not write log rotation signal file "%s": %m
 %s: could not write promote signal file "%s": %m
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
 byte ordering mismatch cannot duplicate null pointer (internal error)
 child process exited with exit code %d child process exited with unrecognized status %d child process was terminated by exception 0x%X child process was terminated by signal %d: %s command not executable command not found could not execute command "%s": %m could not find a "%s" to execute could not get current working directory: %m
 could not read binary "%s": %m could not read from command "%s": %m could not resolve path "%s" to absolute form: %m invalid binary "%s": %m no data was returned by command "%s" out of memory out of memory
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
 waiting for server to promote... waiting for server to shut down... waiting for server to start... Project-Id-Version: PostgreSQL 17
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-07-12 14:20+0000
PO-Revision-Date: 2024-07-12 19:04+0200
Last-Translator: Dennis Björklund <db@zigo.dhs.org>
Language-Team: Swedish <pgsql-translators@postgresql.org>
Language: sv
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
 
Tillåtna signalnamn för kommando "kill":
 
Gemensamma flaggor:
 
Flaggor för registrering och avregistrering:
 
Flaggor för start eller omstart:
 
Flaggor för stopp eller omstart:
 
Rapportera fel till <%s>.
 
Stängningsmetoder är:
 
Startmetoder är:
   %s init[db]   [-D DATAKAT] [-s] [-o FLAGGOR]
   %s kill       SIGNALNAMN PID
   %s logrotate  [-D DATAKAT] [-s]
   %s promote    [-D DATAKAT] [-W] [-t SEK] [-s]
   %s register   [-D DATAKAT] [-N TJÄNSTENAMN] [-U ANVÄNDARNAMN] [-P LÖSENORD]
                    [-S STARTTYPE] [-e KÄLLA] [-W] [-t SEK] [-s] [-o FLAGGOR]
   %s reload     [-D DATAKAT] [-s]
   %s restart    [-D DATAKAT] [-m STÄNGNINGSMETOD] [-W] [-t SEK] [-s]
                    [-o FLAGGOR] [-c]
   %s start      [-D DATAKAT] [-l FILNAMN] [-W] [-t SEK] [-s]
                    [-o FLAGGOR] [-p SOKVÄG] [-c]
   %s status     [-D DATAKAT]
   %s stop       [-D DATAKAT] [-m STÄNGNINGSMETOD] [-W] [-t SEK] [-s]
   %s unregister [-N TJÄNSTNAMN]
   -?, --help             visa den här hjälpen, avsluta sedan
   -D, --pgdata=DATAKAT   plats för databasens lagringsarea
   -N TJÄNSTENAMN  tjänstenamn att registrera PostgreSQL-servern med
   -P LÖSENORD     lösenord för konto vid registrering av PostgreSQL-servern
   -S STARTSÄTT    sätt att registrera PostgreSQL-servern vid tjänstestart
   -U NAMN         användarnamn för konto vid registrering av PostgreSQL-servern
   -V, --version          visa versionsinformation, avsluta sedan
   -W, --no-wait          vänta inte på att operationen slutförs
   -c, --core-files       tillåt postgres att skapa core-filer
   -c, --core-files       inte giltig för denna plattform
   -e KÄLLA               händelsekälla för loggning när vi kör som en tjänst
   -l, --log=FILNAMN      skriv, eller tillfoga, server-loggen till FILNAMN
   -m, --mode=METOD       METOD kan vara "smart", "fast" eller "immediate"
   -o, --options=OPTIONS  kommandoradsflaggor som skickas vidare till postgres
                         (PostgreSQL-serverns körbara fil) eller till initdb
   -p SÖKVÄG-TILL-POSTGRES
                         behövs normalt inte
   -s, --silent           skriv bara ut fel, inga informationsmeddelanden
   -t, --timeout=SEK      antal sekunder att vänta när växeln -w används
   -w, --wait             vänta på att operationen slutförs (standard)
   auto       starta tjänsten automatiskt vid systemstart (förval)
   demand     starta tjänsten vid behov
   fast        stäng omedelbart, med en kontrollerad nedstängning (standard)
   immediate   stäng utan kontroller; kommer leda till återställning vid omstart
   smart       stäng när alla klienter har avslutat
  klar
  misslyckades
  avslutade väntan
 hemsida för %s: <%s>
 %s är ett verktyg för att initiera, starta, stanna och att styra
PostgreSQL-tjänsten.

 %s() misslyckades: %m %s: flaggan -S stöds inte på denna plattform.
 %s: PID-filen "%s" finns inte
 %s: en annan server verkar köra; försöker starta servern ändå.
 %s: kan inte köras som root
Logga in (t.ex. med "su") som den (opriviligerade) användare
vilken skall äga serverprocessen.
 %s: kan inte befordra servern; servern är inte i beredskapsläge.
 %s: kan inte befordra servern; en-användar-server kör (PID: %d)
 %s: kan inte ladda om servern; en-användar-server kör (PID: %d)
 %s: kan inte starta om servern. En-användar-server kör (PID: %d).
 %s: kan inte rotera loggfil; en-användar-server kör (PID: %d)
 %s: kan inte sätta storleksgränsning på core-fil; tillåts inte av hård gräns
 %s: Kan inte stanna servern. En-användar-server i drift (PID: %d).
 %s: kontrollfilen verkar vara trasig
 %s: kunde inte komma åt katalogen "%s": %m
 %s: kunde inte tilldela SID: felkod %lu
 %s: kunde inte skapa loggroteringssignalfil "%s": %m
 %s: kunde inte skapa befordringssignalfil "%s": %m
 %s: kunde inte skapa restriktivt styrmärke (token): felkod %lu
 %s: kunde inte bestämma databaskatalogen från kommandot "%s"
 %s: kunde inte hitta det egna programmets körbara fil
 %s: kunde inte hitta körbar postgres.
 %s: kunde inte hämta LUID:er för rättigheter: felkod %lu
 %s: kunde inte hämta token-information: felkod %lu
 %s: kunde inte öppna PID-fil "%s": %m
 %s: kunde inte öppna logg-fil "%s": %m
 %s: kunde inte öppna process-token: felkod %lu
 %s: kunde inte öppna tjänsten "%s": felkod %lu
 %s: kunde inte öppna tjänstehanteraren
 %s: kunde inte läsa filen "%s"
 %s: kunde inte registrera tjänsten "%s": felkod %lu
 %s: kunde inte ta bort loggroteringssignalfil "%s": %m
 %s: kunde inte ta bort befordringssignalfil "%s": %m
 %s: kunde inte skicka signalen för loggrotering (PID: %d): %m
 %s: kunde inte skicka befordringssignal (PID: %d): %m
 %s: kunde inte skicka signalen "reload" (PID: %d): %m
 %s: kunde inte skicka signal %d (PID: %d): %m
 %s: kunde inte skicka stopp-signal (PID: %d): %m
 %s: kunde inte starta servern
Undersök logg-utskriften.
 %s: kunde inte starta servern då setsid() misslyckades: %m
 %s: kunde inte starta servern: %m
 %s: kunde inte starta servern: felkod %lu
 %s: kunde inte starta tjänsten "%s": felkod %lu
 %s: kunde inte avregistrera tjänsten "%s": felkod %lu
 %s: kunde inte skriva loggroteringssignalfil "%s": %m
 %s: kunde inte skriva befordringssignalfil "%s": %m
 %s: skapande av databaskluster misslyckades
 %s: katalogen "%s" existerar inte
 %s: katalogen "%s" innehåller inte något databaskluster.
 %s: ogiltig data i PID-fil "%s"
 %s: saknar argument för "kill"-kommando.
 %s: ingen databaskatalog angiven och omgivningsvariabeln PGDATA är inte satt
 %s: ingen operation angiven
 %s: ingen server kör
 %s: gamla serverprocessen (PID: %d) verkar vara borta
 %s: inställningsfilen "%s" måste bestå av en enda rad.
 %s: slut på minne
 %s: servern befordrades inte i tid
 %s: servern startade inte i tid
 %s: servern stänger inte ner
 %s: servern kör (PID: %d)
 %s: tjänsten "%s" är redan registrerad
 %s: tjänsten "%s" är inte registrerad
 %s: en-användar-server kör. (PID: %d)
 %s: PID-filen "%s" är tom
 %s: för många kommandoradsargument (första är "%s")
 %s: okänd operationsmetod "%s"
 %s: ogiltig stängningsmetod "%s"
 %s: ogiltigt signalnamn "%s"
 %s: ogiltigt startvillkor "%s"
 TIPS: Flaggan "-m fast" avslutar sessioner omedelbart, i stället för att
vänta på deras självvalda avslut.
 Om flaggan -D inte har angivits så används omgivningsvariabeln PGDATA.
 Kör servern?
 Var vänlig att stanna en-användar-servern och försök sedan igen.
 Server startad och accepterar nu anslutningar
 Tidsfristen ute vid väntan på serverstart
 Försök med "%s --help" för mer information.
 Användning:
 Väntar på serverstart...
 byte-ordning stämmer inte kan inte duplicera null-pekare (internt fel)
 barnprocess avslutade med kod %d barnprocess avslutade med okänd statuskod %d barnprocess terminerades med avbrott 0x%X barnprocess terminerades av signal %d: %s kommandot är inte körbart kommandot kan ej hittas kunde inte köra kommandot "%s": %m kunde inte hitta en "%s" att köra kunde inte fastställa nuvarande arbetskatalog: %m
 kunde inte läsa binär "%s": %m kunde inte läsa från kommando "%s": %m kunde inte konvertera sökvägen "%s" till en absolut sökväg: %m ogiltig binär "%s": %m ingen data returnerades från kommandot "%s" slut på minne slut på minne
 programmet "%s" behövs av %s men hittades inte i samma katalog som "%s"
 programmet "%s" hittades av "%s" men är inte av samma version som %s
 servern befordrad
 servern befordras
 servern stänger ner
 servern är signalerad
 servern är signalerad att rotera loggfil
 servern startad
 servern startar
 servern är stoppad
 startar servern ändå
 försöker starta servern ändå
 väntar på att servern skall befordras... väntar på att servern skall stänga ner... väntar på att servern skall starta... 