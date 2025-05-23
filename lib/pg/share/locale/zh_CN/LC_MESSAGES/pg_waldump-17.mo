��    4      �  G   \      x  
   y     �  %   �  3   �  ?   �  I   5  =     A   �  6   �  �   6  D     �   c  >     �   @  C   �  ~   
	  D   �	     �	     �	  &   
     )
  �   1
  )        8     T     q  !   �     �     �  (   �  %        7  '   R     z     �  (   �  *   �  6   	  .   @      o     �     �  |   �          4     P  $   ^  0   �  /   �  $   �  	   	  �    	   �     �  %   �  7     :   T  >   �  ;   �  J   
  /   U  �   �  >   W  �   �  >   .  �   m  C   �  �   <  :   �     �     
  *   (     S  �   b  #        8     Q     i     �     �     �     �     �          &     F     `  3   |  +   �  A   �  '     '   F     n     w  �   �               4     A  '   ^  )   �      �     �            /       &       $         '                   +          .          2   -      4       	           #          (                       1          %      ,       )      *   3   "           0       !                         
                        
Options:
 
Report bugs to <%s>.
   %s [OPTION]... [STARTSEG [ENDSEG]]
   -?, --help             show this help, then exit
   -V, --version          output version information, then exit
   -b, --bkp-details      output detailed information about backup blocks
   -e, --end=RECPTR       stop reading at WAL location RECPTR
   -f, --follow           keep retrying after reaching end of WAL
   -n, --limit=N          number of records to display
   -p, --path=PATH        directory in which to find log segment files or a
                         directory with a ./pg_wal that contains such files
                         (default: current directory, ./pg_wal, $PGDATA/pg_wal)
   -q, --quiet            do not print any output, except for errors
   -r, --rmgr=RMGR        only show records generated by resource manager RMGR;
                         use --rmgr=list to list valid resource manager names
   -s, --start=RECPTR     start reading at WAL location RECPTR
   -t, --timeline=TLI     timeline from which to read log records
                         (default: 1 or the value used in STARTSEG)
   -x, --xid=XID          only show records with transaction ID XID
   -z, --stats[=record]   show statistics instead of records
                         (optionally, show per-record statistics)
 %s decodes and displays PostgreSQL write-ahead logs for debugging.

 %s home page: <%s>
 ENDSEG %s is before STARTSEG %s Try "%s --help" for more information.
 Usage:
 WAL segment size must be a power of two between 1 MB and 1 GB, but the WAL file "%s" header specifies %d byte WAL segment size must be a power of two between 1 MB and 1 GB, but the WAL file "%s" header specifies %d bytes could not find a valid record after %X/%X could not find any WAL file could not find file "%s": %m could not locate WAL file "%s" could not open directory "%s": %m could not open file "%s" could not open file "%s": %m could not parse "%s" as a transaction ID could not parse end WAL location "%s" could not parse limit "%s" could not parse start WAL location "%s" could not parse timeline "%s" could not read file "%s": %m could not read file "%s": read %d of %zu could not read from file %s, offset %u: %m could not read from file %s, offset %u: read %d of %zu end WAL location %X/%X is not inside file "%s" error in WAL record at %X/%X: %s error:  fatal:  first record is after %X/%X, at %X/%X, skipping over %u byte
 first record is after %X/%X, at %X/%X, skipping over %u bytes
 no arguments specified no start WAL location given out of memory resource manager "%s" does not exist start WAL location %X/%X is not inside file "%s" too many command-line arguments (first is "%s") unrecognized argument to --stats: %s warning:  Project-Id-Version: pg_waldump (PostgreSQL) 13
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2020-06-05 01:45+0000
PO-Revision-Date: 2020-06-23 18:00+0800
Last-Translator: Jie Zhang <zhangjie2@cn.fujitsu.com>
Language-Team: Chinese (Simplified) <zhangjie2@cn.fujitsu.com>
Language: zh_CN
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=(n != 1);
 
选项:
 
臭虫报告至 <%s>.
   %s [选项]... [STARTSEG [ENDSEG]]
   -?, --help             显示此帮助, 然后退出
   -V, --version          输出版本信息, 然后退出
   -b, --bkp-details      输出有关备份块的详细信息
   -e, --end=RECPTR       在指定的WAL位置停止读取
   -f, --follow           在到达可用WAL的末尾之后，继续重试
   -n, --limit=N          要显示的记录数
   -p, --path=PATH        在其中查找日志段文件的目录
                         或包含此类文件的./pg_wal目录
                         (默认值: 当前的目录, ./pg_wal, $PGDATA/pg_wal)
   -q, --quiet            不打印任何输出，错误除外
   -r, --rmgr=RMGR        只显示由RMGR资源管理器生成的记录
                         使用--rmgr=list列出有效的资源管理器名称
   -s, --start=RECPTR     在WAL中位于RECPTR处开始阅读
   -t, --timeline=TLI     要从哪个时间线读取日志记录
                         (默认值：1或者是使用STARTSEG中的值)
   -x, --xid=XID          只显示用给定事务ID标记的记录
   -z, --stats[=record]   显示统计信息而不是记录
                         (或者，显示每个记录的统计信息)
 %s 为了调试，解码并显示PostgreSQL预写日志.

 %s 主页: <%s>
 ENDSEG %s在STARTSEG %s之前 请用 "%s --help" 获取更多的信息.
 使用方法:
 WAL段大小必须是1MB到1GB之间的2次幂，但WAL文件"%s"头指定了%d个字节 WAL段大小必须是1MB到1GB之间的2次幂，但WAL文件"%s"头指定了%d个字节 在%X/%X之后找不到有效记录 找不到任何WAL文件 找不到文件"%s": %m 找不到WAL文件"%s" 无法打开目录 "%s": %m could not open file"%s" 无法打开文件 "%s": %m 无法将"%s"解析为事务ID 无法解析WAL结束位置"%s" 无法解析限制"%s" 无法解析WAL起始位置"%s" 无法解析时间线"%s" 无法读取文件 "%s": %m 无法读取文件"%1$s"：读取了%3$zu中的%2$d 无法从文件 %s读取，偏移量 %u: %m 无法从文件%1$s读取，偏移量%2$u，读取%4$zu中的%3$d WAL结束位置%X/%X不在文件"%s"中 在WAL记录中的%X/%X处错误为: %s 错误:  致命的:  第一条记录在%X/%X之后，位于%X/%X，跳过了%u个字节
 第一条记录在%X/%X之后，位于%X/%X，跳过了%u个字节
 未指定参数 未给出WAL起始位置 内存用尽 资源管理器"%s"不存在 WAL开始位置%X/%X不在文件"%s"中 命令行参数太多 (第一个是 "%s") 无法识别的参数--stats: %s 警告:  