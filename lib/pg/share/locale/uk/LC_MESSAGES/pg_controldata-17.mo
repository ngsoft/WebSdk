��    a      $  �   ,      8  X   9  
   �     �  3   �  ?   �  (   *	  C   S	     �	     �	     �	  ,   �	  ,   �	  )   
  )   C
  )   m
  )   �
  )   �
  )   �
  +     )   A  �   k  )   �  ,     )   I  ,   s  )   �  )   �  )   �  ,     )   K  )   u  ,   �  )   �  )   �  )      )   J  )   t  )   �  )   �  )   �  )     )   F  )   p  )   �  )   �  )   �  ,     )   E     o  )   �  B   �  <   �  )   /  %   Y       )   �     �     �     �  C   �  /   "     R     p  (   �     �     �  (   �          8     L     ^  f   l  )   �  )   �  )   '  )   Q  )   {     �     �     �     �     �  )   �  )       .  	   4     >     T     b  /   n  )   �     �     �  )   �  )   $     N  �  R  �   �     �     �  U   �  a   
  8   l  i   �  )        9     P  Y   T  ]   �  K     )   X  ;   �  P   �  0     ?   @  R   �  ,   �  �      [   �  T   X   4   �   Z   �   G   =!  G   �!  ?   �!  A   "  F   O"  J   �"  T   �"  B   6#  H   y#  I   �#  G   $  H   T$  W   �$  G   �$  W   =%  A   �%  Q   �%  ?   )&  J   i&  A   �&  l   �&  W   c'  D   �'  8    (  B   9(  r   |(  �   �(  @   s)  P   �)     *      *     @*     Z*  4   r*  �   �*  l   T+  3   �+  +   �+  L   !,  6   n,  8   �,  R   �,  6   1-  &   h-  &   �-     �-  �  �-  -   d/  0   �/  0   �/  -   �/  2   "0     U0  -   Z0     �0  
   �0  %   �0  J   �0  2   1    @1  !   B3  ;   d3  !   �3     �3  \   �3  4   ,4  $   a4  *   �4  ,   �4  +   �4     
5     ]   (   1           P   ,                     !   	      -             Q         J   '              a           5      0      `   .   K      B   &   O   ^   T   7   
   :   9       G       X   A           /       %      6   )   F       M              C   2      \   D       +      Z   >   $                *   E       W   N       R   Y           =       U   8   3          L          S   @      I   <   4           #                     _          ;   H   ?             V         [       "    
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
 Either the control file is corrupt, or it has a different layout than this program is expecting.  The results below are untrustworthy. End-of-backup record required:        %s
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
 The WAL segment size must be a power of two between 1 MB and 1 GB. The file is corrupt and the results below are untrustworthy. Time of latest checkpoint:            %s
 Try "%s --help" for more information. Usage:
 WAL block size:                       %u
 by reference by value byte ordering mismatch calculated CRC checksum does not match value stored in control file cannot duplicate null pointer (internal error)
 could not close file "%s": %m could not fsync file "%s": %m could not open file "%s" for reading: %m could not open file "%s": %m could not read file "%s": %m could not read file "%s": read %d of %zu could not write file "%s": %m in archive recovery in crash recovery in production invalid WAL segment size in control file (%d byte) invalid WAL segment size in control file (%d bytes) max_connections setting:              %d
 max_locks_per_xact setting:           %d
 max_prepared_xacts setting:           %d
 max_wal_senders setting:              %d
 max_worker_processes setting:         %d
 no no data directory specified off on out of memory
 pg_control last modified:             %s
 pg_control version number:            %u
 possible byte ordering mismatch
The byte ordering used to store the pg_control file might not match the one
used by this program.  In that case the results below would be incorrect, and
the PostgreSQL installation would be incompatible with this data directory. shut down shut down in recovery shutting down starting up too many command-line arguments (first is "%s") track_commit_timestamp setting:       %s
 unrecognized "wal_level" unrecognized status code wal_level setting:                    %s
 wal_log_hints setting:                %s
 yes Project-Id-Version: postgresql
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-08-31 06:24+0000
PO-Revision-Date: 2024-09-23 19:38
Last-Translator: 
Language-Team: Ukrainian
Language: uk_UA
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=4; plural=((n%10==1 && n%100!=11) ? 0 : ((n%10 >= 2 && n%10 <=4 && (n%100 < 12 || n%100 > 14)) ? 1 : ((n%10 == 0 || (n%10 >= 5 && n%10 <=9)) || (n%100 >= 11 && n%100 <= 14)) ? 2 : 3));
X-Crowdin-Project: postgresql
X-Crowdin-Project-ID: 324573
X-Crowdin-Language: uk
X-Crowdin-File: /REL_17_STABLE/pg_controldata.pot
X-Crowdin-File-ID: 1018
 
Якщо каталог даних не вказано (DATADIR), використовується змінна середовища PGDATA.

 
Параметри:
   %s [OPTION] [DATADIR]
   -?, --help              показати цю довідку потім вийти
   -V, --version            вивести інформацію про версію і вийти
  [-D, --pgdata=]DATADIR  каталог з даними
 %s відображає контрольну інформацію щодо кластеру PostgreSQL.

 Домашня сторінка %s: <%s>
 64-бітні цілі ??? Кінцеве розташування резервного копіювання: %X/%X
 Початкове розташування резервного копіювання: %X/%X
 Блоків на сегмент великого відношення: %u
 Байтів на сегмент WAL: %u
 Номер версії каталогу:               %u
 Версія контрольних сум сторінок даних:      %u
 Розмір блоку бази даних: %u
 Стан кластеру бази даних:              %s
 Системний ідентифікатор бази даних:           %llu
 Дата/час типу сховища: %s
 Або контрольний файл пошкоджено, або він має іншу структуру, ніж очікує ця програма. Наведені нижче результати не заслуговують на довіру. Вимагається запис кінця резервного копіювання: %s
 Фіктивний LSN для таблиць без журналювання: %X/%X
 Передача аргументу Float8:      %s
 Останнє місце знаходження контрольної точки: %X/%X
 Останній NextMultiOffset контрольної точки: %u
 Останній NextMultiXactId контрольної точки: %u
 Останній NextOID контрольної точки: %u
 Останній NextXID контрольної точки: %u%u
 Останній PrevTimeLineID контрольної точки: %u
 Останній файл контрольної точки REDO WAL:  %s
 Розташування останньої контрольної точки: %X%X
 Останній TimeLineID контрольної точки: %u
 Останній full_page_writes контрольної точки: %s
 Останній newestCommitTsXid контрольної точки: %u
 Останній oldestActiveXID контрольної точки: %u
 Останній oldestCommitTsXid контрольної точки:%u
 Остання DB останньої oldestMulti контрольної точки: %u
 Останній oldestMultiXid контрольної точки: %u 
 Остання DB останнього oldestXID контрольної точки: %u
 Останній oldestXID контрольної точки: %u
 Максимальна кількість стовпців в індексі: %u
 Максимальне вирівнювання даних: %u
 Максимальна довжина ідентифікаторів:  %u
 Максимальний розмір сегменту TOAST: %u
 Мінімальна позиція історії часу завершення відновлення: %u
 Мінімальне розташування кінця відновлення: %X/%X
 Імітувати нонс для аутентифікації: %s
 Повідомляти про помилки на <%s>.
 Розмір сегменту великих обїєктів: %u
 Розмір сегмента WAL повинен бути степенем двійки від 1 МБ до 1 ГБ. Файл пошкоджено, і наведені нижче результати не заслуговують на довіру. Час останньої контрольної точки: %s
 Спробуйте "%s --help" для додаткової інформації. Використання:
 Pозмір блоку WAL: %u
 за посиланням за значенням неправильний порядок байтів обчислена контрольна сума CRC не збігається зі значенням, що зберігається в контрольному файлі неможливо дублювати нульовий покажчик (внутрішня помилка)
 неможливо закрити файл "%s": %m не вдалося fsync файл "%s": %m не вдалося відкрити файл "%s" для читання: %m не можливо відкрити файл "%s": %m не вдалося прочитати файл "%s": %m не вдалося прочитати файл "%s": прочитано %d з %zu не вдалося записати файл "%s": %m відновлення в архіві відновлення при збої у виробництві невірний розмір сегменту WAL у файлі керування (%d байт) невірний розмір сегмента WAL у файлі керування (%d байтів) невірний розмір сегмента WAL у файлі керування (%d байтів) невірний розмір сегмента WAL у файлі керування (%d байтів) налаштування max_connections: %d
 налаштування max_locks_per_xact: %d
 налаштування max_prepared_xacts: %d
 налаштування max_wal_senders: %d
 налаштування max_worker_processes: %d
 ні каталог даних не вказано вимк увімк недостатньо пам'яті
 pg_control був модифікований востаннє:         %s
 pg_control номер версії:            %u
 можлива помилка у послідовності байтів.
Порядок байтів, що використовують для зберігання файлу pg_control, може не відповідати тому, який використовується цією програмою. У такому випадку результати нижче будуть неправильним, і інсталяція PostgreSQL буде несумісною з цим каталогом даних. завершення роботи завершення роботи у відновленні завершення роботи запуск забагато аргументів у командному рядку (перший "%s") налаштування track_commit_timestamp: %s
 нерозпізнано "wal_level" невизнаний код статусу налаштування wal_рівня: %s
 налаштування wal_log_hints: %s
 так 