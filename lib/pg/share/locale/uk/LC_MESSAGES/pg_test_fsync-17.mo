��    &      L  5   |      P  1   Q  2   �  /   �     �  8        :     T     o     �     �     �     �  (   �  U     [   f  M   �  c        t  .   �  F   �  E     %   K  +   q  /   �  !   �     �     
               (     /     N     R     W  /   f  	   �     �  �  �  �   O  �   �  ]   `  8   �  �   �  $   �  $   �  $   �  $   �  %     /   B     r     y  �   �  �   �  }   0  �   �  $   �  o   �  g   8  f   �  P     >   X  l   �  O     9   T     �     �     �     �  H   �          %  %   ,  \   R     �  *   �     $          
   #                         "                    !             &                  	                                                                    %                
Compare file sync methods using one %dkB write:
 
Compare file sync methods using two %dkB writes:
 
Compare open_sync with different write sizes:
 
Non-sync'ed %dkB writes:
 
Test if fsync on non-write file descriptor is honored:
  1 * 16kB open_sync write  2 *  8kB open_sync writes  4 *  4kB open_sync writes  8 *  2kB open_sync writes %13.3f ops/sec  %6.0f usecs/op
 %s must be in range %u..%u %s: %m %u second per test
 %u seconds per test
 (If the times are similar, fsync() can sync data written on a different
descriptor.)
 (This is designed to compare the cost of writing 16kB in different write
open_sync sizes.)
 (in "wal_sync_method" preference order, except fdatasync is Linux's default)
 * This file system and its mount options do not support direct
  I/O, e.g. ext4 in journaled mode.
 16 *  1kB open_sync writes Direct I/O is not supported on this platform.
 F_NOCACHE supported on this platform for open_datasync and open_sync.
 O_DIRECT supported on this platform for open_datasync and open_sync.
 Try "%s --help" for more information. Usage: %s [-f FILENAME] [-s SECS-PER-TEST]
 cannot duplicate null pointer (internal error)
 could not create thread for alarm could not open output file detail:  error:  fsync failed hint:  invalid argument for option %s n/a n/a* out of memory
 too many command-line arguments (first is "%s") warning:  write failed Project-Id-Version: postgresql
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
X-Crowdin-File: /REL_17_STABLE/pg_test_fsync.pot
X-Crowdin-File-ID: 1020
 
Порівнювання методів синхронізації файлу, використовуючи один запис %dkB:
 
Порівнювання методів синхронізації файлу, використовуючи два записи %dkB: 
 
Порівняння open_sync з різними розмірами записування:
 
Несинхронізований запис %d КБ:
 
Перевірка, чи здійснюється fsync з дескриптором файлу, відкритого не для запису:
  запис з open_sync 1 * 16 КБ  запис з open_sync 2 *  8 КБ  запис з open_sync 4 *  4 КБ  запис з open_sync 8 *  2 КБ %13.3f оп/с     %6.0f мкс/оп
 %s має бути в діапазоні %u..%u %s: %m %u секунда на тест
 %u секунди на тест
 %u секунд на тест
 %u секунд на тест
 (Якщо час однаковий, fsync() може синхронізувати дані, записані іншим дескриптором.)
 (Це створено для порівняння вартості запису 16 КБ з різними розмірами
записування open_sync.)
 (в порядку переваги для "wal_sync_method", окрім fdatasync за замовчуванням в Linux)
 * Ця файлова система з поточними параметрами монтування не підтримує
  пряме введення/виведення, наприклад, ext4 в режимі журналювання.
 запис з open_sync 16 *  1 КБ Пряме введення/виведення не підтримується на цій платформі.
 F_NOCACHE підтримується на цій платформі для open_datasync і open_sync.
 O_DIRECT на цій платформі підтримується для open_datasync і open_sync.
 Спробуйте "%s --help" для додаткової інформації. Використання: %s [-f FILENAME] [-s SECS-PER-TEST]
 неможливо дублювати нульовий покажчик (внутрішня помилка)
 не вдалося створити потік для сигналізації неможливо відкрити файл виводу деталі:  помилка:  помилка fsync підказка:  неприпустимий аргумент для параметру %s н/д н/д* недостатньо пам'яті
 забагато аргументів у командному рядку (перший "%s") попередження:  записування не вдалося 