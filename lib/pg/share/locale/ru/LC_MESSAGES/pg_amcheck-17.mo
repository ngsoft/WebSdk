��    x      �  �   �      (
      )
     J
     `
     q
     �
     �
  M   �
  S     H   V  V   �  =   �  A   4  U   v  Z   �  K   '  M   s  I   �  I     T   U  T   �     �  <     D   W  B   �  <   �  D     B   a  A   �  :   �  H   !  8   j  6   �  =   �  M     K   f  ;   �  U   �  7   D  =   |  ;   �  :   �  8   1  <   j  ,   �  0   �  7        =  <   @     }     �  +   �     �     �     �       %   +     Q     a     i  V   �  /   �  )   	  9   3     m     �  /   �     �  +   �  !   &     H  !   e  &   �     �  3   �     �  :        L     U     m  *   �     �  :   �  ,   �  !   '     I     a  3   h  2   �  ;   �       :   #  :   ^     �     �     �      �  '   �  /   '     W  %   m     �  .   �  #   �  0   �     -  &   <     c     t  C   �  0   �  4   �     -  ,   G  /   t  #   �     �     �  (   �  	   "  �  ,  J   �   ,   !  "   3!  @   V!  3   �!  3   �!  �   �!     �"  _   #  �   r#  c   $  Y   w$  �   �$  �   S%  �   �%  �   g&  t   '  �   �'  x   (  �   {(  )   )  W   ,)  w   �)  }   �)  Y   z*  �   �*  y   V+  }   �+  u   N,  N   �,  B   -  E   V-  r   �-  o   .  �   .  x   /  �   ~/  R   0  |   Y0  t   �0  x   K1  a   �1  K   &2  @   r2  D   �2  K   �2     D3  v   G3  +   �3  F   �3  5   14  -   g4  )   �4  B   �4  %   5  Z   (5  L   �5     �5     �5  �   6  p   �6  C   7  n   O7  0   �7  9   �7  [   )8  N   �8  y   �8  :   N9  4   �9  >   �9  H   �9  P   F:  N   �:     �:  �   ;     �;  F   �;  G   �;  >   .<     m<  _   |<  L   �<  7   )=  *   a=     �=  [   �=  a   �=  T   _>  "   �>  ~   �>  �   V?  ?   �?  *   @  ,   J@  C   w@  s   �@  �   /A  4   �A  |   �A  >   kB  �   �B  q   ,C  O   �C     �C  8   D  ;   FD     �D  �   �D  `   )E  r   �E  H   �E  o   FF  c   �F  O   G  F   jG  2   �G  c   �G     HH     I   ?          x   @          /           S       V   F   
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
 skipping database "%s": amcheck is not installed socket file descriptor out of range for select(): %d start block out of bounds this build does not support sync method "%s" too many command-line arguments (first is "%s") too many jobs for this platform: %d unrecognized sync method: %s user does not exist user name lookup failure: error code %lu warning:  Project-Id-Version: pg_amcheck (PostgreSQL) 14
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-09-02 09:29+0300
PO-Revision-Date: 2024-09-05 08:23+0300
Last-Translator: Alexander Lakhin <exclusion@gmail.com>
Language-Team: Russian <pgsql-ru-general@postgresql.org>
Language: ru
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
Параметры проверки индексов-B-деревьев:
 
Параметры подключения:
 
Другие параметры:
 
Об ошибках сообщайте по адресу <%s>.
 
Параметры проверки таблиц:
 
Параметры выбора объектов:
       --checkunique               проверить ограничение уникальности для уникальных индексов
       --endblock=БЛОК             проверить таблицы(у) до блока с заданным номером
       --exclude-toast-pointers    не переходить по указателям в TOAST
       --heapallindexed            проверить, что всем кортежам кучи находится соответствие в индексах
       --install-missing           установить недостающие расширения
       --maintenance-db=ИМЯ_БД     другая опорная база данных
       --no-dependent-indexes      не включать в список проверяемых отношений индексы
       --no-dependent-toast        не включать в список проверяемых отношений TOAST-таблицы
       --no-strict-names           не требовать наличия объектов, соответствующих шаблонам
       --on-error-stop             прекратить проверку по достижении конца первой повреждённой страницы
       --parent-check              проверить связи родитель/потомок в индексах
       --rootdescend               перепроверять поиск кортежей от корневой страницы
       --skip=ТИП_БЛОКА            не проверять блоки типа "all-frozen" или "all-visible"
       --startblock=БЛОК           начать проверку таблиц(ы) с блока с заданным номером
   %s [ПАРАМЕТР]... [ИМЯ_БД]
   -?, --help                      показать эту справку и выйти
   -D, --exclude-database=ШАБЛОН   не проверять соответствующие шаблону базы
   -I, --exclude-index=ШАБЛОН      не проверять соответствующие шаблону индексы
   -P, --progress                  показывать прогресс операции
   -R, --exclude-relation=ШАБЛОН   не проверять соответствующие шаблону отношения
   -S, --exclude-schema=ШАБЛОН     не проверять соответствующие шаблону схемы
   -T, --exclude-table=ШАБЛОН      не проверять соответствующие шаблону таблицы
   -U, --username=ИМЯ              имя пользователя для подключения к серверу
   -V, --version                   показать версию и выйти
   -W, --password                  запросить пароль
   -a, --all                       проверить все базы
   -d, --database=ШАБЛОН           проверить соответствующие шаблону базы
   -e, --echo                      отображать команды, отправляемые серверу
   -h, --host=ИМЯ                  компьютер с сервером баз данных или каталог сокетов
   -i, --index=ШАБЛОН              проверить соответствующие шаблону индексы
   -j, --jobs=ЧИСЛО                устанавливать заданное число подключений к серверу
   -p, --port=ПОРТ                 порт сервера баз данных
   -r, --relation=ШАБЛОН           проверить соответствующие шаблону отношения
   -s, --schema=ШАБЛОН             проверить соответствующие шаблону схемы
   -t, --table=ШАБЛОН              проверить соответствующие шаблону таблицы
   -v, --verbose                   выводить исчерпывающие сообщения
   -w, --no-password               не запрашивать пароль
 отношений: %*s/%s (%d%%), страниц: %*s/%s (%d%%) отношений: %*s/%s (%d%%), страниц: %*s/%s (%d%%) %*s отношений: %*s/%s (%d%%), страниц: %*s/%s (%d%%) (%s%-*.*s) %s %s проверяет объекты в базе данных PostgreSQL на предмет повреждений.

 Домашняя страница %s: <%s>
 значение %s должно быть в диапазоне %d..%d Совместимы ли версии %s и amcheck? Сигнал отмены отправлен
 Выполнялась команда: %s Отправить сигнал отмены не удалось:  Выполнялся запрос: %s Для дополнительной информации попробуйте "%s --help". Попробуйте уменьшить количество заданий. Использование:
 индекс btree "%s.%s.%s":
 индекс btree "%s.%s.%s": функция проверки btree выдала неожиданное количество строк: %d попытка дублирования нулевого указателя (внутренняя ошибка)
 имя базы данных нельзя задавать с --all нельзя задавать одновременно имя базы данных и шаблоны имён проверка индекса btree "%s.%s.%s" проверка базовой таблицы "%s.%s.%s" не удалось подключиться к базе %s (нехватка памяти) не удалось синхронизировать с ФС файл "%s": %m выяснить эффективный идентификатор пользователя (%ld) не удалось: %s не удалось открыть каталог "%s": %m не удалось открыть файл "%s": %m не удалось прочитать каталог "%s": %m не удалось переименовать файл "%s" в "%s": %m не удалось получить информацию о файле "%s": %m не удалось синхронизировать с ФС файл "%s": %m база данных "%s": %s имя базы данных содержит символ новой строки или перевода каретки: "%s"
 подробности:  конечный блок вне допустимых пределов конечный блок предшествует начальному ошибка передачи команды базе "%s": %s ошибка:  базовая таблица "%s.%s.%s", блок %s, смещение %s, атрибут %s:
 базовая таблица "%s.%s.%s", блок %s, смещение %s:
 базовая таблица "%s.%s.%s", блок %s:
 базовая таблица "%s.%s.%s":
 подсказка:  неверное полное имя (слишком много компонентов): %s неверное имя отношения (слишком много компонентов): %s база "%s": используется amcheck версии "%s" в схеме "%s" выбирается база "%s" внутренняя ошибка: получен неожиданный идентификатор шаблона базы %d внутренняя ошибка: получен неожиданный идентификатор шаблона отношения %d недопустимый аргумент параметра %s неверный конечный блок неверный начальный блок неверное значение "%s" для параметра %s не найдены подлежащие проверке индексы btree, соответствующие "%s" не найдены подлежащие проверке доступные базы, соответствующие шаблону "%s" не указаны базы для проверки не найдены подлежащие проверке базовые таблицы, соответствующие "%s" не найдены отношения для проверки не найдены подлежащие проверке отношения в схемах, соответствующих "%s" не найдены подлежащие проверке отношения, соответствующие "%s" параметр %s не поддерживается версией amcheck %s нехватка памяти
 ошибка при обработке базы "%s": %s ошибка при выполнении запроса: %s запрос: %s
 аргумент команды оболочки содержит символ новой строки или перевода каретки: "%s"
 база "%s" пропускается: расширение amcheck не установлено дескриптор файла сокета вне диапазона, допустимого для select(): %d начальный блок вне допустимых пределов эта сборка программы не поддерживает метод синхронизации "%s" слишком много аргументов командной строки (первый: "%s") слишком много заданий для этой платформы: %d нераспознанный метод синхронизации: %s пользователь не существует распознать имя пользователя не удалось (код ошибки: %lu) предупреждение:  