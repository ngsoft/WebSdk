Þ            )         °  Û   ±  
                3   7  8   k  D   ¤  L   é  C   6  w   z  w   ò     j  6   ~  %   µ     Û  $   ã  /     )   8  (   b  (        ´     Ó     Ü     ä     ë       !   $     F     U  	   u  è    &  h
       ¼   ¢  -   _  `     C   î  I   2  a   |  K   Þ  X   *  g        ë  S     2   \       1     :   Í  G     G   P  A     5   Ú               %  $   1  3   V  ?        Ê  -   á                        	                                                    
                                                                 
For use as "archive_cleanup_command" in postgresql.conf:
  archive_cleanup_command = 'pg_archivecleanup [OPTION]... ARCHIVELOCATION %%r'
e.g.
  archive_cleanup_command = 'pg_archivecleanup /mnt/server/archiverdir %%r'
 
Options:
 
Or for use as a standalone archive cleaner:
e.g.
  pg_archivecleanup /mnt/server/archiverdir 000000010000000000000010.00000020.backup
 
Report bugs to <%s>.
   %s [OPTION]... ARCHIVELOCATION OLDESTKEPTWALFILE
   -?, --help                  show this help, then exit
   -V, --version               output version information, then exit
   -b, --clean-backup-history  clean up files including backup history files
   -d, --debug                 generate debug output (verbose mode)
   -n, --dry-run               dry run, show the names of the files that would be
                              removed
   -x, --strip-extension=EXT   strip this extension before identifying files for
                              clean up
 %s home page: <%s>
 %s removes older WAL files from PostgreSQL archives.

 Try "%s --help" for more information. Usage:
 archive location "%s" does not exist cannot duplicate null pointer (internal error)
 could not close archive location "%s": %m could not open archive location "%s": %m could not read archive location "%s": %m could not remove file "%s": %m detail:  error:  hint:  invalid file name argument must specify archive location must specify oldest kept WAL file out of memory
 too many command-line arguments warning:  Project-Id-Version: pg_archivecleanup (PostgreSQL 17)
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-09-05 09:59+0900
PO-Revision-Date: 2024-09-05 10:38+0900
Last-Translator: Kyotaro Horiguchi <horikyota.ntt@gmail.com>
Language-Team: Japan PostgreSQL Users Group <jpug-doc@ml.postgresql.jp>
Language: ja
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: Poedit 1.8.13
Plural-Forms: nplurals=1; plural=0;
 
postgresql.confã§"archive_cleanup_command"ã¨ãã¦ä½¿ç¨ããå ´åã¯ä»¥ä¸ã®ããã«ãã¾ã:
  archive_cleanup_command = 'pg_archivecleanup [ãªãã·ã§ã³]... ã¢ã¼ã«ã¤ãã®å ´æ %%r'
ä¾ã¨ãã¦ã¯:
  archive_cleanup_command = 'pg_archivecleanup /mnt/server/archiverdir %%r'
 
ãªãã·ã§ã³:
 
ãããã¯ã¹ã¿ã³ãã¢ã­ã³ã®ã¢ã¼ã«ã¤ãã¯ãªã¼ãã¼ã¨ãã¦ä½¿ãå ´åã¯:
ä½¿ç¨ä¾
  pg_archivecleanup /mnt/server/archiverdir 000000010000000000000010.00000020.backup
 
ãã°ã¯<%s>ã«å ±åãã¦ãã ããã
 %s [ãªãã·ã§ã³] ... {ã¢ã¼ã«ã¤ãã®å ´æ} {ä¿å­ããæå¤ã® WAL ãã¡ã¤ã«å}
   -?, --help                  ãã®ãã«ããè¡¨ç¤ºãã¦çµäº
   -V, --version               ãã¼ã¸ã§ã³æå ±ãè¡¨ç¤ºãã¦çµäº
   -b, --clean-backup-history  ããã¯ã¢ãããã¹ããªãã¡ã¤ã«ãå«ãã¦åé¤ãã
   -d, --debug                 ãããã°æå ±ãåºå(åé·ã¢ã¼ã)
   -n, --dry-run               ãªãã¼ãµã«ãåé¤å¯¾è±¡ã®ãã¡ã¤ã«åãè¡¨ç¤º
   -x, --strip-extension=EXT   åé¤å¯¾è±¡ã®ãã¡ã¤ã«ã®ç¢ºèªåã«ãã®æ¡å¼µå­ãåé¤ãã
 %s ãã¼ã ãã¼ã¸: <%s>
 %sã¯PostgreSQLã®ã¢ã¼ã«ã¤ãããå¤ãWALãã¡ã¤ã«ãåé¤ãã¾ãã

 è©³ç´°ã¯"%s --help"ãå®è¡ãã¦ãã ããã ä½¿ç¨æ³:
 ã¢ã¼ã«ã¤ãã®å ´æ"%s"ãå­å¨ãã¾ãã nullãã¤ã³ã¿ã¯è¤è£½ã§ãã¾ãã(åé¨ã¨ã©ã¼)
 ã¢ã¼ã«ã¤ãã®å ´æ"%s"ãã¯ã­ã¼ãºã§ãã¾ããã§ãã: %m ã¢ã¼ã«ã¤ãã®å ´æ"%s"ããªã¼ãã³ã§ãã¾ããã§ãã: %m ã¢ã¼ã«ã¤ãã®å ´æ"%s"ãèª­ã¿è¾¼ãã¾ããã§ãã: %m ãã¡ã¤ã«"%s"ãåé¤ã§ãã¾ããã§ãã: %m è©³ç´°:  ã¨ã©ã¼:  ãã³ã:  ãã¡ã¤ã«åå¼æ°ãç¡å¹ã§ã ã¢ã¼ã«ã¤ãã®å ´æãæå®ãã¦ãã ãã ä¿å­ããæå¤ã®WALãã¡ã¤ã«ãæå®ãã¦ãã ãã ã¡ã¢ãªä¸è¶³ã§ã
 ã³ãã³ãã©ã¤ã³å¼æ°ãå¤ããã¾ã è­¦å:  