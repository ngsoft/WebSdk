��    ~        �   �      �
      �
     �
  &   �
          +     J     `  !   s  3   �  ?   �  H   	  D   R  C   �  E   �  ?   !  ?   a  >   �  9   �  L     B   g  E   �  �   �  0   u  F   �  >   �  B   ,  I   o  %   �  O   �  7   /     g     n     w  M   �  -   �  !     C   '  y   k  9   �  C     B   c  C   �  >   �  @   )  '   j  (   �  ,   �  2   �  6     >   R  *   �  /   �  %   �  %     1   8  0   j  #   �     �  4   �  2     0   E  /   v  +   �  -   �  3         4  +   T  1   �  6   �  1   �  *     "   F  7   i  "   �  $   �  J   �     4     P  2   g  0   �     �     �      �  $         C  ,   d     �  4   �  %   �  $     "   1  !   T  u   v  F   �     3  7   G  )     %   �  &   �     �     �  /     &   M  0   t  .   �  -   �                +  ,   L     y     �     �     �     �     �     �                 '      8      H       `   "   �      �   �  �   ,   �"     �"  &   �"  "   #  %   ?#     e#     }#  !   �#  @   �#  H   �#  N   >$  >   �$  D   �$  J   %  ?   \%  =   �%  D   �%  8   &  [   X&  P   �&  I   '  �   O'  2   �'  O   (  F   c(  F   �(  S   �(  -   E)  [   s)  B   �)     *      *     0*  ^   J*  /   �*     �*  L   �*  �   F+  A   �+  `   ),  b   �,  b   �,  [   P-  _   �-  *   .  '   7.  9   _.  ?   �.  D   �.  E   /  ?   d/  ?   �/  ,   �/  /   0  9   A0  <   {0  0   �0  $   �0  A   1  >   P1  F   �1  G   �1  7   2  D   V2  ?   �2  &   �2  8   3  =   ;3  A   y3  >   �3  5   �3     04  6   N4  &   �4  6   �4  S   �4     75     P5  <   p5  8   �5     �5     �5  &   6  *   @6  #   k6  @   �6     �6  4   �6  (   #7  )   L7  &   v7  )   �7  q   �7  G   98     �8  \   �8  ,   �8  1    9  6   R9     �9  '   �9  <   �9  0   �9  ;   +:  5   g:  7   �:     �:     �:      ;  <   );  '   f;     �;     �;     �;     �;     �;     �;     <     ,<     @<     _<  #   r<  '   �<  %   �<  &   �<     <   y   ]           [          *           K   5      
      |   2   s   W         7      Z   Y   ?   r       8   n   {       (         j      _   d   "               m   T                   	   >   .                   U   L   }      3   9   u   J   f   V       6   p          0       O       B      )       X   C       q   w   !       %   S   x           e         A      :       H      4   F       l   N   t              o           I              =   D   b   R   c   '   M   i           #   ^   E   h                     -       \   $      ,       P   &   `           z       @      G       k      +   g   ~   a      ;   Q   /                   v       1    
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
Shutdown modes are:
 
Start types are:
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
   immediate   quit without complete shutdown; will lead to recovery on restart
   smart       quit after all clients have disconnected
  done
  failed
  stopped waiting
 %s is a utility to initialize, start, stop, or control a PostgreSQL server.

 %s: -S option not supported on this platform
 %s: PID file "%s" does not exist
 %s: another server might be running; trying to start server anyway
 %s: cannot be run as root
Please log in (using, e.g., "su") as the (unprivileged) user that will
own the server process.
 %s: cannot promote server; server is not in standby mode
 %s: cannot promote server; single-user server is running (PID: %d)
 %s: cannot reload server; single-user server is running (PID: %d)
 %s: cannot restart server; single-user server is running (PID: %d)
 %s: cannot set core file size limit; disallowed by hard limit
 %s: cannot stop server; single-user server is running (PID: %d)
 %s: control file appears to be corrupt
 %s: could not access directory "%s": %s
 %s: could not allocate SIDs: error code %lu
 %s: could not create promote signal file "%s": %s
 %s: could not create restricted token: error code %lu
 %s: could not determine the data directory using command "%s"
 %s: could not find own program executable
 %s: could not find postgres program executable
 %s: could not open PID file "%s": %s
 %s: could not open log file "%s": %s
 %s: could not open process token: error code %lu
 %s: could not open service "%s": error code %lu
 %s: could not open service manager
 %s: could not read file "%s"
 %s: could not register service "%s": error code %lu
 %s: could not remove promote signal file "%s": %s
 %s: could not send promote signal (PID: %d): %s
 %s: could not send reload signal (PID: %d): %s
 %s: could not send signal %d (PID: %d): %s
 %s: could not send stop signal (PID: %d): %s
 %s: could not start server
Examine the log output.
 %s: could not start server: %s
 %s: could not start server: error code %lu
 %s: could not start service "%s": error code %lu
 %s: could not unregister service "%s": error code %lu
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
 server promoted
 server promoting
 server shutting down
 server signaled
 server started
 server starting
 server stopped
 starting server anyway
 waiting for server to promote... waiting for server to shut down... waiting for server to start... Project-Id-Version: pg_ctl (PostgreSQL 9.5)
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2023-04-24 03:48+0000
PO-Revision-Date: 2023-04-24 09:09+0200
Last-Translator: grzegorz <begina.felicysym@wp.eu>
Language-Team: begina.felicysym@wp.eu
Language: pl
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=3; plural=(n==1 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2);
X-Generator: Virtaal 0.7.1
 
Dopuszczalne nazwy sygnałów dla zabicia:
 
Opcje ogólne:
 
Opcje rejestracji i wyrejestrowania:
 
Opcje uruchomienia lub restartu:
 
Opcje dla zatrzymania lub restartu:
 
Tryby zamknięcia to:
 
Rodzaje startu to:
   %s unregister [-N NAZWAUSLUGI]
   -?, --help             pokaż tą pomoc i zakończ działanie
   -D, --pgdata=KATDANE   położenie miejsca przechowywania bazy danych
   -N SERVICENAME  nazwa usługi, na której rejestruje się serwer PostgreSQL
   -P PASSWORD     hasło konta rejestracji serwera PostgreSQL
   -S TYP-STARTU   typ startu usługi rejestracji serwera PostgreSQL
   -U USERNAME     nazwa użytkownika konta rejestracji serwera PostgreSQL
   -V, --version          pokaż informacje o wersji i zakończ
   -W, --no-wait          nie czekaj na zakończenie operacji
   -c, --core-files       zezwól postgresowi utworzyć pliki jądra
   -c, --core-files       niedostępne na tej platformie
   -e ŹRÓDŁO              źródło zdarzenia do logowania gdy uruchomiono jako usługę
   -l, --log=NAZWAPLIKU   zapisuje (lub dodaje) komunikaty serwera do NAZWAPLIKU
   -m, --mode=TRYB        TRYB może być "smart", "fast" lub "immediate"
   -o, --options=OPCJE    opcje wiersza poleceń przekazywanych postgresowi
                         (program wykonywalny PostgreSQL) lub initdb
   -p ŚCIEŻKA-DO-POSTGRES    zwykle niekonieczna
   -s, --silent           wypisz tylko błędy, bez komunikatów informacyjnych
   -t, --timeout=SEKUNDY  sekundy oczekiwania podczas użycia opcji -w
   -w, --wait             czekaj na zakończenie operacji (domyślnie)
   auto       uruchamia usługę automatycznie w czasie startu systemu (domyślnie)
   demand     uruchamia usługę na żądanie
   immediate   wyjście bez pełnego zamknięcia; doprowadzi do odzyskiwania przy restarcie
   smart       wyjście po rozłączeniu się wszystkich klientów
  zakończono
  niepowodzenie
  oczekiwanie zakończone
 %s jest narzędziem do inicjacji, uruchamiania, zatrzymywania i kontroli serwera PostgreSQL.

 %s: opcja -S nieobsługiwana na tej platformie
 %s: plik PID "%s" nie istnieje
 %s: inny serwer może być uruchomiony, próba uruchomienia serwera mimo to
 %s: nie można uruchomić jako root
Proszę zalogować się (używając np: "su") na (nieuprzywilejowanego) użytkownika który
będzie właścicielem procesu.
 %s: nie można rozgłosić serwera; nie jest w trybie gotowości
 %s: Nie można rozgłosić serwera; jest uruchomiony serwer pojedynczego użytkownika (PID: %d)
 %s: Nie można przeładować serwera; jest uruchomiony serwer pojedynczego użytkownika (PID: %d)
 %s: Nie można zrestartować serwera; jest uruchomiony serwer pojedynczego użytkownika (PID: %d)
 %s: nie można ustawić ograniczenia rozmiaru pliku jądra; zablokowane przez twardy limit
 %s: Nie można zatrzymać serwera; jest uruchomiony serwer pojedynczego użytkownika (PID: %d)
 %s: plik kontrolny wydaje się uszkodzony
 %s: brak dostępu do katalogu "%s": %s
 %s: nie udało się przydzielić SIDów: kod błędu %lu
 %s: nie można utworzyć pliku sygnału rozgłoszenia "%s": %s
 %s: nie udało się utworzyć ograniczonego tokena: kod błędu %lu
 %s: nie można określić folderu danych przy użyciu polecenia "%s"
 %s: nie udało się znaleźć własnego programu wykonywalnego
 %s: nie udało się znaleźć programu wykonywalnego postgresa
 %s: nie można otworzyć pliku PID "%s": %s
 %s: nie można otworzyć pliku logów "%s": %s
 %s: nie można otworzyć tokenu procesu: kod błędu %lu
 %s: nie udało się otworzyć usługi "%s": kod błędu %lu
 %s: nie udało się otworzyć menadżera usług
 %s: nie można czytać z pliku "%s"
 %s: nie udało się zarejestrować usługi "%s": kod błędu %lu
 %s: nie można usunąć pliku sygnału rozgłoszenia "%s": %s
 %s: nie udało się wysłać sygnału rozgłaszającego (PID: %d): %s
 %s: nie udało się wysłać sygnału przeładowującego (PID: %d): %s
 %s: nie udało się wysłać sygnału %d (PID: %d): %s
 %s: nie udało się wysłać sygnału zatrzymującego (PID: %d): %s
 %s: Nie udało się uruchomić serwera
Sprawdź logi wyjścia.
 %s: nie można uruchomić serwera: %s
 %s: nie udało się uruchomić serwera: kod błędu %lu
 %s: nie udało się uruchomić usługi "%s": kod błędu %lu
 %s: nie udało się wyrejestrować usługi "%s": kod błędu %lu
 %s: nie można zapisać pliku sygnału rozgłoszenia "%s": %s
 %s: inicjacja systemu bazy danych nie powiodła się
 %s: folder "%s" nie istnieje
 %s: folder "%s" nie jest folderem klastra bazy danych
 %s: niepoprawne dane w pliku PID "%s"
 %s: nie wskazano wszystkich argumentów trybu zabicia
 %s: nie wskazano folderu bazy danych ani nie ustawiono zmiennej środowiska PGDATA
 %s: nie podano operacji
 %s: brak uruchomionego serwera
 %s: poprzedni proces serwera (PID: %d) wydaje się zginął
 %s: plik opcji "%s" musi mieć dokładnie jedną linię
 %s: brak pamięci
 %s: serwer nie zatrzymał się
 %s: jest uruchomiony serwer (PID: %d)
 %s: usługa "%s" jest już zarejestrowana
 %s: usługa "%s" niezarejestrowana
 %s: jest uruchomiony serwer pojedynczego użytkownika (PID: %d)
 %s: plik PID "%s" jest pusty
 %s: za duża ilość parametrów (pierwszy to "%s")
 %s: nierozpoznany tryb autoryzacji "%s"
 %s: nierozpoznany tryb wyłączenia "%s"
 %s: nierozpoznana nazwa sygnału "%s"
 %s: nierozpoznany tryb uruchomienia "%s"
 PORADA: Opcja "-m fast" rozłącza natychmiast sesje zamiast
czekać na odłączenie sesji przez użytkowników.
 Jeśli nie jest podana -D, używana jest zmienna środowiskowa PGDATA.
 Czy serwer działa?
 Proszę zakończyć działanie serwera pojedynczego użytkownika i spróbować raz jeszcze.
 Serwer uruchomiony i akceptuje połączenia
 Minął czas oczekiwania na uruchomienie serwera
 Spróbuj "%s --help" aby uzyskać więcej informacji.
 Składnia:
 Oczekiwanie na uruchomienie serwera...
 nie można powielić pustego wskazania (błąd wewnętrzny)
 proces potomny zakończył działanie z kodem %d proces potomny zakończył działanie z nieznanym stanem %d proces potomny został zatrzymany przez wyjątek 0x%X proces potomny został zakończony przez sygnał %d: %s polecenie nie wykonywalne polecenia nie znaleziono nie znaleziono "%s" do wykonania nie można zidentyfikować aktualnego folderu roboczego: %s
 nie można odczytać binarnego "%s": %m niepoprawny binarny "%s": %m brak pamięci brak pamięci
 serwer rozgłoszony
 serwer w trakcie rozgłaszania
 zatrzymywanie serwera
 serwer zasygnalizowany
 uruchomiono serwer
 serwer w trakcie uruchamiania
 serwer zatrzymany
 uruchomienie serwera mimo wszystko
 oczekiwanie na rozgłoszenie serwera... oczekiwanie na zatrzymanie serwera... oczekiwanie na uruchomienie serwera... 