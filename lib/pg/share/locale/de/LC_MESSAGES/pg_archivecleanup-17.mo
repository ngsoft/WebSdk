��            )         �  �   �  
   �  �   �       3   5  8   i  D   �  L   �  C   4  w   x  w   �     h  6   |  %   �     �  $   �  /     )   6  (   `  (   �     �     �     �     �     �       !   "     D     S  	   s  �  }  �   
     �
  �   �
     �  B   �  A   �  K   -  X   y  F   �  Z     �   t     �  7     7   F     ~  (   �  2   �  4   �  1     /   J  &   z     �     �     �     �  '   �  5        7      N  	   o                   	                                                    
                                                                 
For use as archive_cleanup_command in postgresql.conf:
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
 too many command-line arguments warning:  Project-Id-Version: pg_archivecleanup (PostgreSQL) 17
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-06-16 07:53+0000
PO-Revision-Date: 2024-04-04 11:48+0200
Last-Translator: Peter Eisentraut <peter@eisentraut.org>
Language-Team: German <pgsql-translators@postgresql.org>
Language: de
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
Verwendung als archive_cleanup_command in postgresql.conf:
  archive_cleanup_command = 'pg_archivecleanup [OPTION]... ARCHIVVERZ %%r'
z.B.
  archive_cleanup_command = 'pg_archivecleanup /mnt/server/archiv %%r'
 
Optionen:
 
Oder alleinstehende Verwendung zum Aufräumen eines Archivs:
z.B.
  pg_archivecleanup /mnt/server/archiv 000000010000000000000010.00000020.backup
 
Berichten Sie Fehler an <%s>.
   %s [OPTION]... ARCHIVVERZEICHNIS ÄLTESTE-ZU-BEHALTENE-WALDATEI
   -?, --help                  diese Hilfe anzeigen, dann beenden
   -V, --version               Versionsinformationen anzeigen, dann beenden
   -b, --clean-backup-history  Dateien einschließlich Backup-History-Dateien aufräumen
   -d, --debug                 Debug-Ausgaben erzeugen (Verbose-Modus)
   -n, --dry-run               Probelauf, Namen der Dateien anzeigen, die entfernt würden
   -x, --strip-extension=ERW   diese Erweiterung entfernen, bevor aufzuräumende
                              Dateien bestimmt werden
 %s Homepage: <%s>
 %s entfernt alte WAL-Dateien aus PostgreSQL-Archiven.

 Versuchen Sie »%s --help« für weitere Informationen. Aufruf:
 Archivverzeichnis »%s« existiert nicht kann NULL-Zeiger nicht kopieren (interner Fehler)
 konnte Archivverzeichnis »%s« nicht schließen: %m konnte Archivverzeichnis »%s« nicht öffnen: %m konnte Archivverzeichnis »%s« nicht lesen: %m konnte Datei »%s« nicht löschen: %m Detail:  Fehler:  Tipp:  ungültiges Dateinamenargument Archivverzeichnis muss angegeben werden älteste zu behaltene WAL-Datei muss angegeben werden Speicher aufgebraucht
 zu viele Kommandozeilenargumente Warnung:  