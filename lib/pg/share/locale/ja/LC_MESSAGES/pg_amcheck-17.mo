Þ    x      Ü  £         (
      )
     J
     `
     q
     
     ¢
  M   ´
  S     H   V  V     =   ö  A   4  U   v  Z   Ì  K   '  M   s  I   Á  I     T   U  T   ª     ÿ  <     D   W  B     <   ß  D     B   a  A   ¤  :   æ  H   !  8   j  6   £  =   Ú  M     K   f  ;   ²  U   î  7   D  =   |  ;   º  :   ö  8   1  <   j  ,   §  0   Ô  7        =  <   @     }       +   ¬     Ø     í     ý       %   +     Q     a     i  V     /   Ù  )   	  9   3     m       /   ¬     Ü  +   ú  !   &     H  !   e  &        ®  3   Ë     ÿ  :        L     U     m  *        ·  :   ¿  ,   ú  !   '     I     a  3   h  2     ;   Ï       :   #  :   ^          ¸     Ê      Þ  '   ÿ  /   '     W  %   m       .   ©  #   Ø  0   ü     -  &   <     c     t  C     0   Ç  4   ø     -  ,   G  /   t  #   ¤     È     å  (   ù  	   "  ©  ,  0   Ö      !      !  -   ?!  $   m!     !  w   ±!  e   )"  a   "     ñ"  Y   #  D   æ#      +$     Ì$     l%  _   þ%  M   ^&  \   ¬&     	'     '  2   .(  G   a(  Y   ©(  Y   )  8   ])  Y   )  S   ð)  S   D*  D   *  M   Ý*  M   ++  J   y+  J   Ä+  S   ,     c,  J   û,  b   F-  M   ©-  J   ÷-  D   B.  D   .  M   Ì.  J   /  ;   e/  ?   ¡/  F   á/     (0  Y   +0     0  2   ¢0  7   Õ0  +   1     91  8   J1     1  2   1  0   Ê1     û1  #   
2  h   .2  :   2  8   Ò2  Z   3  *   f3  (   3  L   º3  4   4  >   <4  A   {4  ;   ½4  ;   ù4  E   55  0   {5  Y   ¬5     6  T   !6     v6  $   6  E   ¤6  A   ê6     ,7  Q   87  F   7  2   Ñ7  !   8     &8  N   28  Z   8  ^   Ü8  %   ;9  L   a9  L   ®9  )   û9     %:     A:  1   ]:  J   :  U   Ú:  3   0;  I   d;  3   ®;  X   â;  F   ;<  U   <     Ø<  8   ï<  (   (=     Q=  ]   f=  a   Ä=  C   &>  $   j>  F   >  ?   Ö>  L   ?  "   c?  !   ?  9   ¨?     â?     I   ?          x   @          /           S       V   F   
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
 skipping database "%s": amcheck is not installed socket file descriptor out of range for select(): %d start block out of bounds this build does not support sync method "%s" too many command-line arguments (first is "%s") too many jobs for this platform: %d unrecognized sync method: %s user does not exist user name lookup failure: error code %lu warning:  Project-Id-Version: pg_amcheck (PostgreSQL 17)
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-08-28 10:42+0900
PO-Revision-Date: 2024-08-28 11:43+0900
Last-Translator: Kyotaro Horiguchi <horikyota.ntt@gmail.com>
Language-Team: 
Language: ja
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: Poedit 1.8.13
Plural-Forms: nplurals=1; plural=0;
 
B-treeã¤ã³ããã¯ã¹æ¤æ»ãªãã·ã§ã³:
 
æ¥ç¶ãªãã·ã§ã³:
 
ãã®ä»ã®ãªãã·ã§ã³:
 
ãã°ã¯<%s>ã«å ±åãã¦ãã ããã
 
ãã¼ãã«æ¤æ»ãªãã·ã§ã³:
 
å¯¾è±¡æå®ãªãã·ã§ã³:
       --checkunique               ã¤ã³ããã¯ã¹ãã¦ãã¼ã¯ã§ããã°ã¦ãã¼ã¯å¶ç´ããã§ãã¯ãã
       --endblock=BLOCK            æå®ãããã­ãã¯çªå·ã¾ã§ãã¼ãã«ã®æ¤æ»ãè¡ã
       --exclude-toast-pointers    ãªã¬ã¼ã·ã§ã³ã®TOASTãã¤ã³ã¿ãè¿½è·¡ãããªãã
       --heapallindexed            ãã¹ã¦ã®ãã¼ãã¿ãã«ãã¤ã³ããã¯ã¹åã«
                                  è¦ã¤ãããã¨ãæ¤æ»
       --install-missing           æ©è½æ¡å¼µããªãå ´åã«ã¤ã³ã¹ãã¼ã«ãã
       --maintenance-db=DBNAME     ä»£æ¿ã®ä¿å®ãã¼ã¿ãã¼ã¹
       --no-dependent-indexes      ãªã¬ã¼ã·ã§ã³ã®ãªã¹ããã¤ã³ããã¯ã¹ãå«ãããã«
                                  æ¡å¼µãããªãã
       --no-dependent-toast        ãªã¬ã¼ã·ã§ã³ã®ãªã¹ããTOASTãã¼ãã«ãå«ã
                                  ããã«æ¡å¼µãããªãã
       --no-strict-names           ãã¿ã¼ã³ããªãã¸ã§ã¯ãã«åè´ãããã¨ãå¿é ã¨
                                  ããªã
       --on-error-stop             æåã®ç ´æãã¼ã¸ã®çµããã§æ¤æ»ãä¸­æ­ãã
       --parent-check              ã¤ã³ããã¯ã¹ã®è¦ªå­é¢ä¿ãæ¤æ»
       --rootdescend               ã¿ãã«åæ¢ç´¢ãã«ã¼ããã¼ã¸ããå®è¡ãã
       --skip=OPTION               "all-frozen"ããã³"all-visible"ã§ãã
                                  ãã­ãã¯ãæ¤æ»ãããªãã
       --startblock=BLOCK          æå®ãããã­ãã¯çªå·ãããã¼ãã«ã®æ¤æ»ã
                                  éå§ãã
   %s [ãªãã·ã§ã³]... [ãã¼ã¿ãã¼ã¹å]
   -?, --help                      ãã®ãã«ããè¡¨ç¤ºãã¦çµäº
   -D, --exclude-database=PATTERN  åè´ãããã¼ã¿ãã¼ã¹ãæ¤æ»ãããªãã
   -I, --exclude-index=PATTERN     åè´ããã¤ã³ããã¯ã¹ãæ¤æ»ãããªãã
   -P, --progress                  é²è¡ç¶æ³ãè¡¨ç¤º
   -R, --exclude-relation=PATTERN  åè´ãããªã¬ã¼ã·ã§ã³ãæ¤æ»ãããªãã
   -S, --exclude-schema=PATTERN    åè´ããã¹ã­ã¼ããæ¤æ»ãããªãã
   -T, --exclude-table=PATTERN     åè´ãããã¼ãã«ãæ¤æ»ãããªãã
   -U, --username=USERNAME         æ¥ç¶ã«ç¨ããã¦ã¼ã¶ã¼å
   -V, --version                   ãã¼ã¸ã§ã³æå ±ãè¡¨ç¤ºãã¦çµäº
   -W, --password                  ãã¹ã¯ã¼ãå¥åè¦æ±ãå¼·å¶ãã
   -a, --all                       ãã¹ã¦ã®ãã¼ã¿ãã¼ã¹ãæ¤æ»
   -d, --database=PATTERN          åè´ãããã¼ã¿ãã¼ã¹ãæ¤æ»
   -e, --echo                      ãµã¼ãã¼ã«éãããã³ãã³ããè¡¨ç¤º
   -h, --host=HOSTNAME             ãã¼ã¿ãã¼ã¹ãµã¼ãã¼ã®ãã¹ãã¾ãã¯
                                  ã½ã±ãããã£ã¬ã¯ããª
   -i, --index=PATTERN             åè´ããã¤ã³ããã¯ã¹ãæ¤æ»
   -j, --jobs=NUM                  ãµã¼ãã¼ã«å¯¾ãã¦æå®ããæ°ã®æ¥ç¶ãä½¿ç¨ãã
   -p, --port=PORT                 ãã¼ã¿ãã¼ã¹ãµã¼ãã¼ã®ãã¼ã
   -r, --relation=PATTERN          åè´ãããªã¬ã¼ã·ã§ã³ãæ¤æ»
   -s, --schema=PATTERN            åè´ããã¹ã­ã¼ããæ¤æ»
   -t, --table=PATTERN             åè´ãããã¼ãã«ãæ¤æ»
   -v, --verbose                   å¤ãã®ã¡ãã»ã¼ã¸ãåºåãã¾ã
   -w, --no-password               ãã¹ã¯ã¼ãå¥åãè¦æ±ããªã
 %*s/%såã®ãªã¬ã¼ã·ã§ã³(%d%%), %*s/%sãã¼ã¸(%d%%) %*s/%såã®ãªã¬ã¼ã·ã§ã³(%d%%), %*s/%sãã¼ã¸(%d%%) %*s %*s/%såã®ãªã¬ã¼ã·ã§ã³(%d%%), %*s/%sãã¼ã¸(%d%%) (%s%-*.*s) %s %sã¯PostgreSQLãã¼ã¿ãã¼ã¹åã®ãªãã¸ã§ã¯ãã®ç ´æãæ¤æ»ãã¾ãã

 %s ãã¼ã ãã¼ã¸: <%s>
 %sã¯%d..%dã®ç¯å²ã«ãªããã°ãªãã¾ãã %sã¨amcheckã®ãã¼ã¸ã§ã³ã¯åã£ã¦ãã¾ãã? ã­ã£ã³ã»ã«è¦æ±ãéä¿¡ãã¾ãã
 ã³ãã³ã: %s ã­ã£ã³ã»ã«è¦æ±ãéä¿¡ã§ãã¾ããã§ãã:  åãåãã: %s è©³ç´°ã¯"%s --help"ãå®è¡ãã¦ãã ããã ã¸ã§ãæ°ãæ¸ããã¦ã¿ã¦ãã ããã ä½¿ç¨æ¹æ³:
 btreeã¤ã³ããã¯ã¹"%s.%s.%s":
 btreeã¤ã³ããã¯ã¹"%s.%s.%s": btreeæ¤ç´¢é¢æ°ãäºæããªãæ°ã®è¡ãè¿å´ãã¾ãã: %d nullãã¤ã³ã¿ã¯è¤è£½ã§ãã¾ãã(åé¨ã¨ã©ã¼)
 --allã§ã¯ãã¼ã¿ãã¼ã¹åã¯æå®ã§ãã¾ãã ãã¼ã¿ãã¼ã¹åã¨ãã¼ã¿ãã¼ã¹ãã¿ã¼ã³ã¯åæã«æå®ã¯ã§ãã¾ãã btreeã¤ã³ããã¯ã¹"%s.%s.%s"ãæ¤æ» ãã¼ããã¼ãã«"%s.%s.%s"ãæ¤æ» ãã¼ã¿ãã¼ã¹%sã«æ¥ç¶ã§ãã¾ããã§ãã: ã¡ã¢ãªä¸è¶³ã§ã ãã¡ã¤ã«"%s"ãfsyncã§ãã¾ããã§ãã: %m å®å¹ã¦ã¼ã¶ã¼ID %ld ãè¦ã¤ããã¾ããã§ãã: %s ãã£ã¬ã¯ããª"%s"ããªã¼ãã³ã§ãã¾ããã§ãã: %m ãã¡ã¤ã«"%s"ããªã¼ãã³ã§ãã¾ããã§ãã: %m ãã£ã¬ã¯ããª"%s"ãèª­ã¿åãã¾ããã§ãã: %m ãã¡ã¤ã«"%s"ã®ååã"%s"ã«å¤æ´ã§ãã¾ããã§ãã: %m ãã¡ã¤ã«"%s"ã®statã«å¤±æãã¾ãã: %m ãã¡ã¤ã«"%s"ã«å¯¾ãã¦ãã¡ã¤ã«ã·ã¹ãã ãåæã§ãã¾ããã§ãã: %m ãã¼ã¿ãã¼ã¹"%s": %s ãã¼ã¿ãã¼ã¹åã«æ¹è¡(LF)ã¾ãã¯å¾©å¸°(CR)ãå«ã¾ãã¦ãã¾ã: "%s"
 è©³ç´°:  çµäºãã­ãã¯ãç¯å²å¤ã§ã çµäºãã­ãã¯ãéå§ãã­ãã¯ããåã«ãªã£ã¦ãã¾ã ãã¼ã¿ãã¼ã¹"%s"ã¸ã®ã³ãã³ãéåºä¸­ã®ã¨ã©ã¼: %s ã¨ã©ã¼:  ãã¼ããã¼ãã«"%s.%s.%s"ããã­ãã¯%sããªãã»ãã%sãå±æ§%s:
 ãã¼ããã¼ãã«"%s.%s.%s"ããã­ãã¯%sããªãã»ãã%s:
 ãã¼ããã¼ãã«"%s.%s.%s"ããã­ãã¯%s:
 ãã¼ããã¼ãã«"%s.%s.%s":
 ãã³ã:  ä¿®é£¾åãä¸é©åã§ã(ãããåºåãã®ååãå¤ããã¾ã): %s ãªã¬ã¼ã·ã§ã³åãä¸é©åã§ã(ãããåºåãã®ååãå¤ããã¾ã): %s ãã¼ã¿ãã¼ã¹"%1$s"å: ã¹ã­ã¼ã"%3$s"åã§amcheck ãã¼ã¸ã§ã³"%2$s"ãä½¿ç¨ä¸­ ãã¼ã¿ãã¼ã¹"%s"ãå«ãã¾ã åé¨ã¨ã©ã¼: äºæããªããã¼ã¿ãã¼ã¹ãã¿ã¼ã³ID %dãåä¿¡ åé¨ã¨ã©ã¼: äºæããªããªã¬ã¼ã·ã§ã³ãã¿ã¼ã³ID %dãåä¿¡ ãªãã·ã§ã³%sã®å¼æ°ãä¸æ­£ã§ã ä¸æ­£ãªçµäºãã­ãã¯ ä¸æ­£ãªéå§ãã­ãã¯ ãªãã·ã§ã³%2$sã«å¯¾ããä¸æ­£ãªå¤"%1$s" %s"ã«åè´ããæ¤æ»å¯¾è±¡ã®btreeã¤ã³ããã¯ã¹ãããã¾ãã "%s"ã«åè´ããæ¤æ»å¯¾è±¡ã®æ¥ç¶å¯è½ãªãã¼ã¿ãã¼ã¹ãããã¾ãã æ¤æ»ãã¹ããã¼ã¿ãã¼ã¹ãããã¾ãã "%s"ã«åè´ããæ¤æ»å¯¾è±¡ã®ãã¼ããã¼ãã«ãããã¾ãã æ¤æ»å¯¾è±¡ã®ãªã¬ã¼ã·ã§ã³ãããã¾ãã "%s"ã«åè´ããã¹ã­ã¼ãåã«æ¤æ»å¯¾è±¡ã®ãªã¬ã¼ã·ã§ã³ãããã¾ãã "%s"ã«åè´ããæ¤æ»å¯¾è±¡ã®ãªã¬ã¼ã·ã§ã³ãããã¾ãã %sãªãã·ã§ã³ã¯amcheckãã¼ã¸ã§ã³"%s"ã§ã¯ãµãã¼ãããã¦ãã¾ãã ã¡ã¢ãªä¸è¶³ã§ã
 ãã¼ã¿ãã¼ã¹"%s"ã®å¦çã«å¤±æãã¾ãã: %s åãåãããå¤±æãã¾ãã: %s åãåãã: %s
 ã·ã§ã«ã³ãã³ãã®å¼æ°ã«æ¹è¡(LF)ã¾ãã¯å¾©å¸°(CR)ãå«ã¾ãã¦ãã¾ã: "%s"
 ãã¼ã¿ãã¼ã¹"%s"ãã¹ã­ãããã¾ã: amcheckãã¤ã³ã¹ãã¼ã«ããã¦ãã¾ãã socket() ã®ã½ã±ãããã¡ã¤ã«è¨è¿°å­ãç¯å²å¤ã§ã: %d éå§ãã­ãã¯ãç¯å²å¤ã§ã ãã®ãã«ãã§ã¯åææ¹å¼"%s"ããµãã¼ããã¦ãã¾ãã ã³ãã³ãã©ã¤ã³å¼æ°ãå¤ããã¾ãã(åé ­ã¯"%s") ãã®ãã©ãããã©ã¼ã ã«å¯¾ãã¦ã¸ã§ãæ°ãå¤ããã¾ã: %d èªè­ã§ããªãåææ¹å¼: %s ã¦ã¼ã¶ã¼ãå­å¨ãã¾ãã ã¦ã¼ã¶ã¼åã®åç§ã«å¤±æ: ã¨ã©ã¼ã³ã¼ã %lu è­¦å:  