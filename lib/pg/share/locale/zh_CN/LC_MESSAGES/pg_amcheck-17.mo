��    _                       	     *     @     Q     h     �  S   �  H   �  V   1	  =   �	  A   �	  U   
  Z   ^
  K   �
  M     I   S  I   �  T   �  T   <     �  <   �  D   �  B   .  <   q  D   �  B   �  A   6  :   x  H   �  8   �  6   5  =   l  M   �  K   �  ;   D  U   �  7   �  ;     =   J  ;   �  :   �  8   �  <   8  ,   u  0   �  7   �       <        K  +   _     �     �  &   �     �     �  V     )   _  9   �     �     �       /        B     T     l  *   �     �     �  :   �  ,     !   .     P  ;   h     �  :   �  :   �     2     Q     c  '   w  /   �     �  %   �       .   !  #   P  *   t     �     �     �  0   �     �  /     	   H  �  R     �     �               3     F  G   V  @   �  P   �  8   0  8   i  J   �  L   �  A   :  M   |  <   �  G     N   O  J   �  #   �  F     >   T  ;   �  5   �  ;      8   A   8   z   8   �   C   �   5   0!  8   f!  ;   �!  D   �!  M    "  8   n"  M   �"  ;   �"  5   1#  8   g#  8   �#  5   �#  5   $  ;   E$  '   �$  +   �$  2   �$     %  6   %     B%     S%     s%     �%  *   �%     �%     �%  A   �%  &   8&  3   _&     �&     �&     �&  *   �&     '     '     -'  )   I'     s'  
   |'  3   �'  (   �'     �'     �'  C   (     T(  2   k(  /   �(     �(     �(     �(  &   	)  1   0)     b)  "   ~)     �)  .   �)  "   �)  %   *     2*     C*     Q*  ,   `*     �*  )   �*     �*        +                 /   S   ?      ,             	       P       K                \      O   )   0   9   -       $         *          J   .   B      8   4   H      E       
                X   D       Z       N          U   :         ]   F              R   1   (   A   &          !       Q       _   6          T   L           M   =      %      '   Y   5       "   G              @   [   ;   I   C       #           7       ^   3               V       <   >   2          W    
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
   -q, --quiet                     don't write any messages
   -r, --relation=PATTERN          check matching relation(s)
   -s, --schema=PATTERN            check matching schema(s)
   -t, --table=PATTERN             check matching table(s)
   -v, --verbose                   write a lot of output
   -w, --no-password               never prompt for password
 %*s/%s relations (%d%%), %*s/%s pages (%d%%) %*s/%s relations (%d%%), %*s/%s pages (%d%%) %*s %*s/%s relations (%d%%), %*s/%s pages (%d%%) (%s%-*.*s) %s %s checks objects in a PostgreSQL database for corruption.

 %s home page: <%s>
 Are %s's and amcheck's versions compatible? Cancel request sent
 Could not send cancel request:  Try "%s --help" for more information.
 Usage:
 btree index "%s.%s.%s":
 btree index "%s.%s.%s": btree checking function returned unexpected number of rows: %d cannot specify a database name with --all cannot specify both a database name and database patterns checking btree index "%s.%s.%s" checking heap table "%s.%s.%s" command was: %s could not connect to database %s: out of memory database "%s": %s end block out of bounds end block precedes start block error sending command to database "%s": %s error:  fatal:  heap table "%s.%s.%s", block %s, offset %s, attribute %s:
 heap table "%s.%s.%s", block %s, offset %s:
 heap table "%s.%s.%s", block %s:
 heap table "%s.%s.%s":
 in database "%s": using amcheck version "%s" in schema "%s" including database "%s" internal error: received unexpected database pattern_id %d internal error: received unexpected relation pattern_id %d invalid argument for option %s invalid end block invalid start block no btree indexes to check matching "%s" no connectable databases to check matching "%s" no databases to check no heap tables to check matching "%s" no relations to check no relations to check in schemas matching "%s" no relations to check matching "%s" number of parallel jobs must be at least 1 query failed: %s query was: %s query was: %s
 skipping database "%s": amcheck is not installed start block out of bounds too many command-line arguments (first is "%s") warning:  Project-Id-Version: pg_amcheck (PostgreSQL) 14
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2021-08-14 05:48+0000
PO-Revision-Date: 2021-08-15 18:00+0800
Last-Translator: Jie Zhang <zhangjie2@fujitsu.com>
Language-Team: Chinese (Simplified) <zhangjie2@fujitsu.com>
Language: zh_CN
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
B树索引检查选项:
 
联接选项:
 
其它选项:
 
臭虫报告至<%s>.
 
表检查选项:
 
目标选项:
       --endblock=BLOCK            检查表仅限于给定的块编号
       --exclude-toast-pointers    不要遵循关系TOAST指示
       --heapallindexed            检查是否在索引中找到所有堆元组
       --install-missing           安装缺少的扩展
       --maintenance-db=DBNAME     备用维护数据库
       --no-dependent-indexes      不要展开关系列表以包含索引
       --no-dependent-toast        不要展开关系列表以包括TOAST表
       --no-strict-names           不需要模式来匹配对象
       --on-error-stop             在第一个损坏页的末尾停止检查
       --parent-check              检查索引父/子关系
       --rootdescend               从根页搜索到重新填充元组
       --skip=OPTION               不要检查"all-frozen"或"all-visible"块
       --startblock=BLOCK          在给定的块编号处开始检查表
   %s [选项]... [数据库名字]
   -?, --help                      显示此帮助信息, 然后退出
   -D, --exclude-database=PATTERN  不检查匹配的数据库
   -I, --exclude-index=PATTERN     不检查匹配的索引
   -P, --progress                  显示进度信息
   -R, --exclude-relation=PATTERN  不检查匹配的关系
   -S, --exclude-schema=PATTERN    不检查匹配模式
   -T, --exclude-table=PATTERN     不检查匹的配表
   -U, --username=USERNAME         要连接的用户名
   -V, --version                   输出版本信息, 然后退出
   -W, --password                  强制密码提示
   -a, --all                       检查所有数据库
   -d, --database=PATTERN          检查匹配的数据库
   -e, --echo                      显示发送到服务端的命令
   -h, --host=HOSTNAME             数据库服务器主机或套接字目录
   -i, --index=PATTERN             检查匹配的索引
   -j, --jobs=NUM                  使用这么多到服务器的并发连接
   -p, --port=PORT                 数据库服务器端口
   -q, --quiet                     不写任何信息
   -r, --relation=PATTERN          检查匹配的关系
   -s, --schema=PATTERN            检查匹配的模式
   -t, --table=PATTERN             检查匹配的表
   -v, --verbose                   写大量的输出
   -w, --no-password               从不提示输入密码
 %*s/%s 关系 (%d%%), %*s/%s 页 (%d%%) %*s/%s 关系 (%d%%), %*s/%s 页 (%d%%) %*s %*s/%s 关系 (%d%%), %*s/%s 页 (%d%%) (%s%-*.*s) %s %s检查PostgreSQL数据库中的对象是否损坏.

 %s 主页: <%s>
 %s和amcheck的版本兼容吗? 取消发送的请求
 无法发送取消请求:  请用 "%s --help" 获取更多的信息.
 使用方法:
 B树索引"%s.%s.%s":
 B树索引"%s.%s.%s":B树检查函数返回了意外的行数: %d 无法使用--all指定数据库名称 不能同时指定数据库名称和数据库模式 检查B树索引"%s.%s.%s" 正在检查堆表"%s.%s.%s" 命令是: %s 无法连接到数据库 %s：内存不足 数据库 "%s": %s 结束块超出范围 结束块在开始块之前 向数据库"%s"发送命令时出错: %s 错误:  致命的: 堆表"%s.%s.%s"，块%s，偏移量%s，属性%s:
 堆表"%s.%s.%s"，块%s，偏移量%s:
 堆表"%s.%s.%s",块%s:
 堆表"%s.%s.%s":
 在数据库"%1$s"中：在模式"%3$s"中使用amcheck版本"%2$s" 包含的数据库"%s" 内部错误:收到意外的数据库pattern_id %d 内部错误:收到意外的关系pattern_id %d 选项%s的参数无效 无效的结束块 起始块无效 没有要检查匹配"%s"的B树索引 没有可连接的数据库来检查匹配的"%s" 没有要检查的数据库 没有要检查匹配"%s"的堆表 没有要检查的关系 在模式中没有要检查匹配"%s"的关系 没有要检查匹配"%s"的关系 并行工作的数量必须至少为1 查询失败: %s 查询是: %s 查询是: %s
 正在跳过数据库"%s"：未安装amcheck 起始块超出范围 命令行参数太多 (第一个是 "%s") 警告:  