��    L      |  e   �      p  X   q  
   �  @   �       5   2  P   h  5   �  A   �  :   1  2   l  1   �  G   �  3   	  *   M	     x	  T   �	     �	     �	     
     /
     F
     \
     z
     �
     �
     �
     �
     �
  j     %   �     �     �  /   �  a   �     W     v  ;   �     �     �     
  !   (  (   J     s  (   �  3   �  !   �       (   ,  &   U     |  3   �  )   �  5   �     -  .   K  -   z  )   �  "   �     �     �       +         9     Z  2   v     �  !   �    �  )   �     
  ,   !  /   N     ~     �  	   �  �  �  �   S     �  [     ,   n  P   �  r   �  R   _  G   �  w   �  P   r  N   �  �     R   �  @   �  *   -  �   X  +   �  F     9   ]  0   �  $   �  F   �  I   4  G   ~  >   �  0     $   6  ?   [  �   �  Z   h     �  4   �  p     �   �  E   1  G   w  M   �  5      4   C   N   x   :   �   H   !  4   K!  I   �!  o   �!  >   :"  8   y"  _   �"  H   #  P   [#  N   �#  E   �#  k   A$  6   �$  O   �$  M   4%  K   �%  =   �%     &     %&     4&  M   I&  C   �&  -   �&  Z   	'     d'  D   �'  �  �'  L   l)  8   �)  o   �)  c   b*  F   �*  :   +     H+     !      D   
      -       E   &   %   3       H   	   9          <   L   :                       1             )   @   *      ?       5          =             A       I               $          2                ,   6      +          0         G   ;          8       7   K   /   (   F   .       C      4   '   "       J      B         #              >                       
If no data directory (DATADIR) is specified, the environment variable PGDATA
is used.

 
Options:
       --sync-method=METHOD set method for syncing files to disk
   %s [OPTION]... [DATADIR]
   -?, --help               show this help, then exit
   -N, --no-sync            do not wait for changes to be written safely to disk
   -P, --progress           show progress information
   -V, --version            output version information, then exit
   -c, --check              check data checksums (default)
   -d, --disable            disable data checksums
   -e, --enable             enable data checksums
   -f, --filenode=FILENODE  check only relation with specified filenode
   -v, --verbose            output verbose messages
  [-D, --pgdata=]DATADIR    data directory
 %lld/%lld MB (%d%%) computed %s enables, disables, or verifies data checksums in a PostgreSQL database cluster.

 %s home page: <%s>
 %s must be in range %d..%d Bad checksums:  %lld
 Blocks scanned:  %lld
 Blocks written: %lld
 Checksum operation completed
 Checksums disabled in cluster
 Checksums enabled in cluster
 Data checksum version: %u
 Files scanned:   %lld
 Files written:  %lld
 Report bugs to <%s>.
 The database cluster was initialized with block size %u, but pg_checksums was compiled with block size %u. Try "%s --help" for more information. Usage:
 byte ordering mismatch cannot duplicate null pointer (internal error)
 checksum verification failed in file "%s", block %u: calculated checksum %X but block contains %X checksums enabled in file "%s" checksums verified in file "%s" cluster is not compatible with this version of pg_checksums cluster must be shut down could not close file "%s": %m could not fsync file "%s": %m could not open directory "%s": %m could not open file "%s" for reading: %m could not open file "%s": %m could not read block %u in file "%s": %m could not read block %u in file "%s": read %d of %d could not read directory "%s": %m could not read file "%s": %m could not read file "%s": read %d of %zu could not rename file "%s" to "%s": %m could not stat file "%s": %m could not synchronize file system for file "%s": %m could not write block %u in file "%s": %m could not write block %u in file "%s": wrote %d of %d could not write file "%s": %m data checksums are already disabled in cluster data checksums are already enabled in cluster data checksums are not enabled in cluster database cluster is not compatible detail:  error:  hint:  invalid segment number %d in file name "%s" invalid value "%s" for option %s no data directory specified option -f/--filenode can only be used with --check out of memory
 pg_control CRC value is incorrect possible byte ordering mismatch
The byte ordering used to store the pg_control file might not match the one
used by this program.  In that case the results below would be incorrect, and
the PostgreSQL installation would be incompatible with this data directory. seek failed for block %u in file "%s": %m syncing data directory this build does not support sync method "%s" too many command-line arguments (first is "%s") unrecognized sync method: %s updating control file warning:  Project-Id-Version: pg_verify_checksums (PostgreSQL) 11
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-09-02 09:29+0300
PO-Revision-Date: 2024-09-04 13:35+0300
Last-Translator: Alexander Lakhin <exclusion@gmail.com>
Language-Team: Russian <pgsql-ru-general@postgresql.org>
Language: ru
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
Если каталог данных (КАТ_ДАННЫХ) не задан, используется значение
переменной окружения PGDATA.

 
Параметры:
       --sync-method=МЕТОД  метод синхронизации файлов с ФС
   %s [ПАРАМЕТР]... [КАТАЛОГ]
   -?, --help               показать эту справку и выйти
   -N, --no-sync            не ждать завершения сохранения данных на диске
   -P, --progress           показывать прогресс операции
   -V, --version            показать версию и выйти
   -c, --check              проверить контрольные суммы данных (по умолчанию)
   -d, --disable            отключить контрольные суммы
   -e, --enable             включить контрольные суммы
   -f, --filenode=ФАЙЛ_УЗЕЛ проверить только отношение с заданным файловым узлом
   -v, --verbose            выводить подробные сообщения
  [-D, --pgdata=]КАТ_ДАННЫХ каталог данных
 %lld/%lld МБ (%d%%) обработано %s включает, отключает, проверяет контрольные суммы данных в кластере БД PostgreSQL.

 Домашняя страница %s: <%s>
 значение %s должно быть в диапазоне %d..%d Неверные контрольные суммы: %lld
 Просканировано блоков: %lld
 Записано блоков: %lld
 Обработка контрольных сумм завершена
 Контрольные суммы в кластере отключены
 Контрольные суммы в кластере включены
 Версия контрольных сумм данных: %u
 Просканировано файлов: %lld
 Записано файлов: %lld
 Об ошибках сообщайте по адресу <%s>.
 Кластер баз данных был инициализирован с размером блока %u, а утилита pg_checksums скомпилирована для размера блока %u. Для дополнительной информации попробуйте "%s --help". Использование:
 несоответствие порядка байт попытка дублирования нулевого указателя (внутренняя ошибка)
 ошибка контрольных сумм в файле "%s", блоке %u: вычислена контрольная сумма %X, но блок содержит %X контрольные суммы в файле "%s" включены контрольные суммы в файле "%s" проверены кластер несовместим с этой версией pg_checksums кластер должен быть отключён не удалось закрыть файл "%s": %m не удалось синхронизировать с ФС файл "%s": %m не удалось открыть каталог "%s": %m не удалось открыть файл "%s" для чтения: %m не удалось открыть файл "%s": %m не удалось прочитать блок %u в файле "%s": %m не удалось прочитать блок %u в файле "%s" (прочитано байт: %d из %d) не удалось прочитать каталог "%s": %m не удалось прочитать файл "%s": %m не удалось прочитать файл "%s" (прочитано байт: %d из %zu) не удалось переименовать файл "%s" в "%s": %m не удалось получить информацию о файле "%s": %m не удалось синхронизировать с ФС файл "%s": %m не удалось записать блок %u в файл "%s": %m не удалось записать блок %u в файле "%s" (записано байт: %d из %d) не удалось записать файл "%s": %m контрольные суммы в кластере уже отключены контрольные суммы в кластере уже включены контрольные суммы в кластере не включены несовместимый кластер баз данных подробности:  ошибка:  подсказка:  неверный номер сегмента %d в имени файла "%s" неверное значение "%s" для параметра %s каталог данных не указан параметр -f/--filenode можно использовать только с --check нехватка памяти
 ошибка контрольного значения в pg_control возможно несоответствие порядка байт
Порядок байт в файле pg_control может не соответствовать используемому
этой программой. В этом случае результаты будут неверными и
установленный PostgreSQL будет несовместим с этим каталогом данных. ошибка при переходе к блоку %u в файле "%s": %m синхронизация каталога данных эта сборка программы не поддерживает метод синхронизации "%s" слишком много аргументов командной строки (первый: "%s") нераспознанный метод синхронизации: %s модификация управляющего файла предупреждение:  