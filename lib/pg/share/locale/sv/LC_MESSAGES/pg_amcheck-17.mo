��    x      �  �   �      (
      )
     J
     `
     q
     �
     �
  M   �
  S     H   V  V   �  =   �  A   4  U   v  Z   �  K   '  M   s  I   �  I     T   U  T   �     �  <     D   W  B   �  <   �  D     B   a  A   �  :   �  H   !  8   j  6   �  =   �  M     K   f  ;   �  U   �  7   D  =   |  ;   �  :   �  8   1  <   j  ,   �  0   �  7        =  <   @     }     �  +   �     �     �     �       %   +     Q     a     i  V   �  /   �  )   	  9   3     m     �  /   �     �  +   �  !   &     H  !   e  &   �     �  3   �     �  :        L     U     m  *   �     �  :   �  ,   �  !   '     I     a  3   h  2   �  ;   �       :   #  :   ^     �     �     �      �  '   �  /   '     W  %   m     �  .   �  #   �  0   �     -  &   <     c     t  C   �  0   �  4   �     -  ,   G  /   t  #   �     �     �  (   �  	   "    ,  (   �      �      �      !  $   !     B!  N   `!  W   �!  F   "  R   N"  D   �"  <   �"  `   ##  h   �#  G   �#  Q   5$  \   �$  S   �$  b   8%  W   �%     �%  C   &  I   R&  C   �&  <   �&  J   '  G   h'  G   �'  A   �'  J   :(  ?   �(  =   �(  D   )  J   H)  L   �)  >   �)  L   *  7   l*  E   �*  B   �*  B   -+  :   p+  <   �+  -   �+  1   ,  8   H,     �,  L   �,     �,  #   �,  .   -  "   ;-     ^-  -   p-     �-  .   �-     �-     �-     .  X   .  -   v.  /   �.  ;   �.  #   /  #   4/  2   X/     �/  2   �/  "   �/     0  !    0  *   B0  (   m0  3   �0     �0  6   �0     1  "   1  %   >1  3   d1     �1  :   �1  -   �1  "   2     *2     C2  =   J2  9   �2  <   �2     �2  9   3  :   P3  !   �3     �3     �3  &   �3  9   �3  E   54     {4  <   �4  %   �4  <   �4  7   :5  ,   r5     �5  ,   �5     �5     �5  B   6  7   H6  :   �6  #   �6  '   �6  3   7  )   ;7     e7     z7  3   �7  	   �7     I   ?          x   @          /           S       V   F   
       n   6   ]      o   v   t   =       T       K   #       4   e   c   b       r      >   Y   Q   8   &      ,   s   U   [   P   l       G   R   *   .                 9   C       `   d       H   \               _              2      j      ^   	       ;       h   i              <   :      D   L   q   f   J   -   %   w   g          7      k   "   +       3   (             Z   E       X   B   0      '   M   m       5   W               )   p      O           1          a       $       u                            !             N                A           
B-tree index checking options:
 
Connection options:
 
Other options:
 
Report bugs to <%s>.
 
Table checking options:
 
Target options:
       --checkunique               check unique constraint if index is unique
       --endblock=BLOCK            check table(s) only up to the given block number
       --exclude-toast-pointers    do NOT follow relation TOAST pointers
       --heapallindexed            check that all heap tuples are found within indexes
       --install-missing           install missing extensions
       --maintenance-db=DBNAME     alternate maintenance database
       --no-dependent-indexes      do NOT expand list of relations to include indexes
       --no-dependent-toast        do NOT expand list of relations to include TOAST tables
       --no-strict-names           do NOT require patterns to match objects
       --on-error-stop             stop checking at end of first corrupt page
       --parent-check              check index parent/child relationships
       --rootdescend               search from root page to refind tuples
       --skip=OPTION               do NOT check "all-frozen" or "all-visible" blocks
       --startblock=BLOCK          begin checking table(s) at the given block number
   %s [OPTION]... [DBNAME]
   -?, --help                      show this help, then exit
   -D, --exclude-database=PATTERN  do NOT check matching database(s)
   -I, --exclude-index=PATTERN     do NOT check matching index(es)
   -P, --progress                  show progress information
   -R, --exclude-relation=PATTERN  do NOT check matching relation(s)
   -S, --exclude-schema=PATTERN    do NOT check matching schema(s)
   -T, --exclude-table=PATTERN     do NOT check matching table(s)
   -U, --username=USERNAME         user name to connect as
   -V, --version                   output version information, then exit
   -W, --password                  force password prompt
   -a, --all                       check all databases
   -d, --database=PATTERN          check matching database(s)
   -e, --echo                      show the commands being sent to the server
   -h, --host=HOSTNAME             database server host or socket directory
   -i, --index=PATTERN             check matching index(es)
   -j, --jobs=NUM                  use this many concurrent connections to the server
   -p, --port=PORT                 database server port
   -r, --relation=PATTERN          check matching relation(s)
   -s, --schema=PATTERN            check matching schema(s)
   -t, --table=PATTERN             check matching table(s)
   -v, --verbose                   write a lot of output
   -w, --no-password               never prompt for password
 %*s/%s relations (%d%%), %*s/%s pages (%d%%) %*s/%s relations (%d%%), %*s/%s pages (%d%%) %*s %*s/%s relations (%d%%), %*s/%s pages (%d%%) (%s%-*.*s) %s %s checks objects in a PostgreSQL database for corruption.

 %s home page: <%s>
 %s must be in range %d..%d Are %s's and amcheck's versions compatible? Cancel request sent
 Command was: %s Could not send cancel request:  Query was: %s Try "%s --help" for more information. Try fewer jobs. Usage:
 btree index "%s.%s.%s":
 btree index "%s.%s.%s": btree checking function returned unexpected number of rows: %d cannot duplicate null pointer (internal error)
 cannot specify a database name with --all cannot specify both a database name and database patterns checking btree index "%s.%s.%s" checking heap table "%s.%s.%s" could not connect to database %s: out of memory could not fsync file "%s": %m could not look up effective user ID %ld: %s could not open directory "%s": %m could not open file "%s": %m could not read directory "%s": %m could not rename file "%s" to "%s": %m could not stat file "%s": %m could not synchronize file system for file "%s": %m database "%s": %s database name contains a newline or carriage return: "%s"
 detail:  end block out of bounds end block precedes start block error sending command to database "%s": %s error:  heap table "%s.%s.%s", block %s, offset %s, attribute %s:
 heap table "%s.%s.%s", block %s, offset %s:
 heap table "%s.%s.%s", block %s:
 heap table "%s.%s.%s":
 hint:  improper qualified name (too many dotted names): %s improper relation name (too many dotted names): %s in database "%s": using amcheck version "%s" in schema "%s" including database "%s" internal error: received unexpected database pattern_id %d internal error: received unexpected relation pattern_id %d invalid argument for option %s invalid end block invalid start block invalid value "%s" for option %s no btree indexes to check matching "%s" no connectable databases to check matching "%s" no databases to check no heap tables to check matching "%s" no relations to check no relations to check in schemas matching "%s" no relations to check matching "%s" option %s is not supported by amcheck version %s out of memory
 processing of database "%s" failed: %s query failed: %s query was: %s
 shell command argument contains a newline or carriage return: "%s"
 skipping database "%s": amcheck is not installed socket file descriptor out of range for select(): %d start block out of bounds this build does not support sync method "%s" too many command-line arguments (first is "%s") too many jobs for this platform: %d unrecognized sync method: %s user does not exist user name lookup failure: error code %lu warning:  Project-Id-Version: PostgreSQL 17
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-08-27 15:52+0000
PO-Revision-Date: 2024-08-27 18:29+0200
Last-Translator: Dennis Björklund <db@zigo.dhs.org>
Language-Team: Swedish <pgsql-translators@postgresql.org>
Language: sv
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
Flaggor för kontroll av B-tree-index:
 
Flaggor för anslutning:
 
Andra flaggor:
 
Rapportera fel till <%s>.
 
Flaggor för kontroll av tabeller:
 
Flaggor för destinationen:
       --checkunique               verifiera unik-villkor om indexet är unikt
       --endblock=BLOCK            kontrollera tabell(er) fram till angivet blocknummer
       --exclude-toast-pointers    följ INTE relationers TOAST-pekare
       --heapallindexed            kontrollera att alla heap-tupler hittas i index
       --install-missing           installera utökningar som saknas
       --maintenance-db=DBNAMN     val av underhållsdatabas
       --no-dependent-indexes      expandera INTE listan med relationer för att inkludera index
       --no-dependent-toast        expandera inte listan av relationer för att inkludera TOAST-tabeller
       --no-strict-names           kräv INTE mallar för matcha objekt
       --on-error-stop             sluta kontrollera efter första korrupta sidan
       --parent-check              kontrollera förhållandet mellan barn/förälder i index
       --rootdescend               sök från root-sidan för att återfinna tupler
       --skip=FLAGGA               kontrollera INTE block som är "all-frozen" eller "all-visible"
       --startblock=BLOCK          börja kontollera tabell(er) vid angivet blocknummer
   %s [FLAGGA]... [DBNAMN]
   -?, --help                      visa denna hjälp, avsluta sedan
   -D, --exclude-database=MALL     kontrollera INTE matchande databas(er)
   -I, --exclude-index=MALL        kontrollera INTE matchande index
   -P, --progress                  visa förloppsinformation
   -R, --exclude-relation=MALL     kontrollera INTE matchande relation(er)
   -S, --exclude-schema=MALL       kontrollera INTE matchande schema(n)
   -T, --exclude-table=MALL        kontollera INTE matchande tabell(er)
   -U, --username=ANVÄNDARE        användarnamn att ansluta som
   -V, --version                   visa versionsinformation, avsluta sedan
   -W, --password                  tvinga fram lösenordsfråga
   -a, --all                       kontrollera alla databaser
   -d, --database=MALL             kontrollera matchande databas(er)
   -e, --echo                      visa kommandon som skickas till servern
   -h, --host=VÄRDNAMN             databasens värdnamn eller socketkatalog
   -i, --index=MALL                kontrollera matchande index
   -j, --jobs=NUM                  antal samtidiga anslutningar till servern
   -p, --port=PORT                 databasserverns port
   -r, --relation=MALL             kontrollera matchande relation(er)
   -s, --schema=MALL               kontrollera matchande schema(n)
   -t, --table=MALL                kontollera matchande tabell(er)
   -v, --verbose                   skriv massor med utdata
   -w, --no-password               fråga ej efter lösenord
 %*s/%s relationer (%d%%), %*s/%s sidor (%d%%) %*s/%s relationer (%d%%), %*s/%s sidor (%d%%) %*s %*s/%s relationer (%d%%), %*s/%s sidor (%d%%) (%s%-*.*s) %s %s kontrollerar objekt i en PostgreSQL-database för att hitta korruption.

 hemsida för %s: <%s>
 %s måste vara i intervallet %d..%d Är versionerna på %s och amcheck kompatibla? Förfrågan om avbrytning skickad
 Kommandot var: %s Kunde inte skicka förfrågan om avbrytning:  Frågan var: %s Försök med "%s --help" för mer information. Försök med färre job. Användning:
 btree-index "%s.%s.%s":
 btree-index "%s.%s.%s": kontrollfunktion för btree returnerade oväntat antal rader: %d kan inte duplicera null-pekare (internt fel)
 kan inte ange databasnamn tillsammans med --all kan inte ange både ett databasnamn och ett databasmönster kontrollerar btree-index "%s.%s.%s" kontrollerar heap-tabell "%s.%s.%s" kunde inte ansluta till databas %s: slut på minne kunde inte fsync:a fil "%s": %m kunde inte slå upp effektivt användar-id %ld: %s kunde inte öppna katalog "%s": %m kunde inte öppna fil "%s": %m kunde inte läsa katalog "%s": %m kunde inte döpa om fil "%s" till "%s": %m kunde inte göra stat() på fil "%s": %m kan inte synkronisera filsystemet för fil "%s": %m databas "%s": %s databasnamnet innehåller nyrad eller vagnretur: "%s"
 detalj:  slutblocket utanför giltig gräns slutblocket kommer före startblocket fel vid skickande av kommando till databas "%s": %s fel:  heap-tabell "%s.%s.%s", block %s, offset %s, attribut %s:
 heap-tabell "%s.%s.%s", block %s, offset %s:
 heap-tabell "%s.%s.%s", block %s:
 heap-tabell "%s.%s.%s":
 tips:  ej korrekt kvalificerat namn (för många namn med punkt): %s ej korrekt relationsnamn (för många namn med punkt): %s i databas "%s": använder amcheck version "%s" i schema "%s" inkludera databas "%s" internt fel: tog emot oväntat pattern_id %d för databas internt fel: tog emot oväntat pattern_id %d för relation ogiltigt argument för flaggan %s ogiltigt slutblock ogiltigt startblock ogiltigt värde "%s" för flaggan "%s" finns inga btree-index för att kontrollera matching "%s" finns inga anslutningsbara databaser att kontrollera som matchar "%s" inga databaser att kontrollera finns inga heap-tabeller för att kontrollera matchning "%s" finns inga relationer att kontrollera finns inga relationer att kontrollera i schemamatchning "%s" finns inga relations för att kontrollera matching "%s" flaggan %s stöds inte av amcheck version %s slut på minne
 processande av databas "%s" misslyckades: %s fråga misslyckades: %s frågan var: %s
 shell-kommandots argument innehåller nyrad eller vagnretur: "%s"
 hoppar över databas "%s": amcheck är inte installerad deskriptor-index utanför sitt intervall för select(): %d startblocket utanför giltig gräns detta bygge stöder inte synkmetod "%s" för många kommandoradsargument (första är "%s") för många jobb för denna plattform: %d okänd synkmetod: %s användaren finns inte misslyckad sökning efter användarnamn: felkod %lu varning:  