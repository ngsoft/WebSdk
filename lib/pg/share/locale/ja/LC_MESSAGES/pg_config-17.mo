��    -      �  =   �      �  E   �  0   '     X  :   k  E   �  I   �  L   6  s   �  K   �  =   C  B   �  i   �  G   .  J   v  M   �  M     ?   ]  G   �  >   �  6   $	  <   [	  >   �	  F   �	  P   
  I   o
  4   �
  2   �
     !     5  *   E     p  	   �     �  &   �     �  "   �      �       $   <  0   a     �  $   �     �     �  �  �  f   �  H   2     {  I   �  L   �  P   .  S     �   �  R   Z  =   �  A   �  k   -  P   �  Q   �  T   <  T   �  U   �  N   <  O   �  C   �  B     M   b  O   �  d      R   e  >   �  =   �     5     R  8   p     �     �  ,   �  -        5  5   D  +   z  5   �  8   �  D        Z  :   x     �     �        ,      -                                      (            %         )                 *      "      
                     #      '                                                 +   !   	   $         &       
%s provides information about the installed version of PostgreSQL.

 
With no arguments, all known items are shown.

   %s [OPTION]...

   --bindir              show location of user executables
   --cc                  show CC value used when PostgreSQL was built
   --cflags              show CFLAGS value used when PostgreSQL was built
   --cflags_sl           show CFLAGS_SL value used when PostgreSQL was built
   --configure           show options given to "configure" script when
                        PostgreSQL was built
   --cppflags            show CPPFLAGS value used when PostgreSQL was built
   --docdir              show location of documentation files
   --htmldir             show location of HTML documentation files
   --includedir          show location of C header files of the client
                        interfaces
   --includedir-server   show location of C header files for the server
   --ldflags             show LDFLAGS value used when PostgreSQL was built
   --ldflags_ex          show LDFLAGS_EX value used when PostgreSQL was built
   --ldflags_sl          show LDFLAGS_SL value used when PostgreSQL was built
   --libdir              show location of object code libraries
   --libs                show LIBS value used when PostgreSQL was built
   --localedir           show location of locale support files
   --mandir              show location of manual pages
   --pgxs                show location of extension makefile
   --pkgincludedir       show location of other C header files
   --pkglibdir           show location of dynamically loadable modules
   --sharedir            show location of architecture-independent support files
   --sysconfdir          show location of system-wide configuration files
   --version             show the PostgreSQL version
   -?, --help            show this help, then exit
 %s home page: <%s>
 %s() failed: %m %s: could not find own program executable
 %s: invalid argument: %s
 Options:
 Report bugs to <%s>.
 Try "%s --help" for more information.
 Usage:
 could not execute command "%s": %m could not find a "%s" to execute could not read binary "%s": %m could not read from command "%s": %m could not resolve path "%s" to absolute form: %m invalid binary "%s": %m no data was returned by command "%s" not recorded out of memory Project-Id-Version: pg_config (PostgreSQL 17)
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-03-11 09:58+0900
PO-Revision-Date: 2024-03-11 16:20+0900
Last-Translator: Kyotaro Horiguchi <horikyota.ntt@gmail.com>
Language-Team: Japan PostgreSQL Users Group <jpug-doc@ml.postgresql.jp>
Language: ja
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Poedit 1.8.13
 
%sはインストールされたバージョンのPostgreSQLに関する情報を提供します。

 
引数がない場合、既知の項目をすべて表示します。

   %s [オプション]...

   --bindir              ユーザー実行ファイルの場所を表示
   --cc                  PostgreSQL構築時に使用したCCの値を表示
   --cflags              PostgreSQL構築時に使用したCFLAGSの値を表示
   --cflags_sl           PostgreSQL構築時に使用したCFLAGS_SLの値を表示
   --configure           PostgreSQL構築時に"configure"スクリプトに与えた
                        オプションを表示
   --cppflags            PostgreSQL構築時に使用したCPPFLAGSの値を表示
   --docdir              文書ファイルの場所を表示
   --htmldir             html文書ファイルの場所を表示
   --includedir          クライアントインタフェースのCヘッダファイルの場所を表示
   --includedir-server   サーバー用Cヘッダファイルの場所を表示
   --ldflags             PostgreSQL構築時に使用したLDFLAGSの値を表示
   --ldflags_ex          PostgreSQL構築時に使用したLDFLAGS_EXの値を表示
   --ldflags_sl          PostgreSQL構築時に使用したLDFLAGS_SLの値を表示
   --libdir              オブジェクトコードライブラリの場所を表示
   --libs                PostgreSQL構築時に使用したLIBSの値を表示
   --localedir           ロケールサポートファイルの場所を表示
   --mandir              マニュアルページの場所を表示
   --pgxs                機能拡張のmakefileの場所を表示
   --pkgincludedir       その他のCヘッダファイルの場所を表示
   --pkglibdir           動的ロード可能モジュールの場所を表示
   --sharedir            アーキテクチャ非依存のサポートファイルの場所を表示
   --sysconfdir          システム全体の設定ファイルの場所を表示
   --version             PostgreSQLのバージョンを表示
   -?, --help            このヘルプを表示して終了
 %s ホームページ: <%s>
 %s()が失敗しました: %m %s: 実行ファイル自体がありませんでした
 %s: 無効な引数です: %s
 オプション:
 バグは<%s>に報告してください。
 詳細は"%s --help"を行ってください
 使用方法:
 コマンド"%s"を実行できませんでした: %m 実行する"%s"がありませんでした バイナリ"%s"を読み取れませんでした: %m コマンド"%s"から読み取れませんでした: %m パス"%s"を絶対パス形式に変換できませんでした: %m 不正なバイナリ"%s": %m コマンド"%s"がデータを返却しませんでした 記録されていません メモリ不足です 