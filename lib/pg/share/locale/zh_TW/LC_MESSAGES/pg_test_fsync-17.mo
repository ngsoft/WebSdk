��    $      <  5   \      0  1   1  2   c  /   �     �  8   �          4     O     j     �     �     �  (   �  U   �  [   F  K   �  c   �     R  .   m  F   �  E   �  %   )  +   O  !   {     �     �     �     �     �     �     �        /     	   5     ?  �  L  6   �	  6   &
  .   ]
  !   �
  7   �
     �
               7     R     r     �     �  P   �  _   �  V   ]  [   �           +  =   L  <   �  %   �  ,   �          9     O     ^     g     t     }     �     �  (   �     �     �     "          
                            !                                  $                  	                   #                                                                  
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
 (in wal_sync_method preference order, except fdatasync is Linux's default)
 * This file system and its mount options do not support direct
  I/O, e.g. ext4 in journaled mode.
 16 *  1kB open_sync writes Direct I/O is not supported on this platform.
 F_NOCACHE supported on this platform for open_datasync and open_sync.
 O_DIRECT supported on this platform for open_datasync and open_sync.
 Try "%s --help" for more information. Usage: %s [-f FILENAME] [-s SECS-PER-TEST]
 could not create thread for alarm could not open output file detail:  error:  fsync failed hint:  invalid argument for option %s n/a n/a* too many command-line arguments (first is "%s") warning:  write failed Project-Id-Version: pg_test_fsync (PostgreSQL) 16
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2023-09-11 20:52+0000
PO-Revision-Date: 2023-11-06 08:49+0800
Last-Translator: Zhenbang Wei <znbang@gmail.com>
Language-Team: 
Language: zh_TW
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Poedit 3.4.1
 
比較使用一個 %dkB 寫入的檔案同步方式:
 
比較使用兩個 %dkB 寫入的檔案同步方式:
 
比較使用不同寫入大小的 open_sync:
 
不使用同步的 %dkB 寫入:
 
測試 fsync 非寫入檔案描述符是否被尊重:
  1 * 16kB open_sync 寫入  2 *  8kB open_sync 寫入  4 *  4kB open_sync 寫入  8 *  2kB open_sync 寫入 %13.3f ops/sec  %6.0f usecs/op
 %s 必須在範圍 %u..%u 內 %s: %m 每個測試 %u 秒
 (如果時間相近，fsync() 可以同步被寫入不同描述符的資料。)
 (這是為了比較在不同的 open_sync 寫入大小下寫入 16kB 的成本而設計的。)
 (按照 wal_sync_method 的優先順序，除了 fdatasync 是 Linux 的預設選項)
 * 這個檔案系統及其掛載選項不支援直接 I/O，例如 ext4 的日誌模式。
 16 *  1kB open_sync 寫入 此平臺不支援直接 I/O。
 此平臺的 open_datasync 和 open_sync 支援 F_NOCACHE。
 此平臺的 open_datasync 和 open_sync 支援 O_DIRECT。
 用 "%s --help" 取得更多資訊。 用法: %s [-f FILENAME] [-s SECS-PER-TEST]
 無法為警報建立執行緒 無法開啟輸出檔 詳細內容:  錯誤:  fsync 失敗 提示:  選項 %s 的參數無效 n/a n/a* 命令列參數過多(第一個是 "%s") 警告:  寫入失敗 