��    ]           �      �  X   �  
   B     M  3   f  ?   �  (   �  C   	     G	     [	     k	  ,   o	  ,   �	  )   �	  )   �	  )   
  )   G
  )   q
  )   �
  +   �
  )   �
  )     ,   E  )   r  ,   �  )   �  )   �  )     ,   G  )   t  )   �  ,   �  )   �  )     )   I  )   s  )   �  )   �  )   �  )     )   E  )   o  )   �  )   �  )   �  )     ,   A  )   n     �  )   �  >  �  )     %   A     g  )   o  �   �  "   `     �     �     �     �     �  (   �          2  (   O     x     �     �     �  )   �  )   �  )     )   H  )   r     �     �     �     �  )   �  )   �      	        &     <     J  /   V  )   �     �     �  )   �  )   
     4  �  8  j   �     Y     e  5   �  G   �  -   �  U   ,     �     �     �  =   �  >   �  :   0  8   k  ;   �  <   �  8     8   V  :   �  9   �  :     =   ?  8   }  <   �  9   �  9   -  9   g  <   �  9   �  9     <   R  9   �  9   �  9      9   =   9   w   9   �   9   �   9   %!  9   _!  :   �!  9   �!  9   "  9   H"  ;   �"  >   �"  :   �"     8#  9   N#  p  �#  9   �$  6   3%     j%  8   p%  �   �%  ,   �&     �&  	   �&  %   �&  "   �&  -   '  .   I'  !   x'     �'  *   �'  '   �'     (     '(     @(  :   N(  :   �(  :   �(  :   �(  :   :)     u)  +   z)     �)  
   �)  ;   �)  :   �)  8  5*  	   n+     x+  
   �+  	   �+  8   �+  :   �+     ,     ;,  :   R,  :   �,     �,     5            -   :               G   [   4                     1           $   J       ]   @                         !   2                  =       '   
       C         E   \   >   ;       "   &          D   Q          U   #   Y   <   L       3   Z      /       ,   	   %   8          (   N   I            7   H           V   .   0   9                  X   A              K   F   B      +   S   P      R   O   T   *      6      W   ?                                  )   M    
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
 End-of-backup record required:        %s
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
 The WAL segment size stored in the file, %d byte, is not a power of two
between 1 MB and 1 GB.  The file is corrupt and the results below are
untrustworthy.

 The WAL segment size stored in the file, %d bytes, is not a power of two
between 1 MB and 1 GB.  The file is corrupt and the results below are
untrustworthy.

 Time of latest checkpoint:            %s
 Try "%s --help" for more information. Usage:
 WAL block size:                       %u
 WARNING: Calculated CRC checksum does not match value stored in file.
Either the file is corrupt, or it has a different layout than this program
is expecting.  The results below are untrustworthy.

 WARNING: invalid WAL segment size
 by reference by value byte ordering mismatch could not close file "%s": %m could not fsync file "%s": %m could not open file "%s" for reading: %m could not open file "%s": %m could not read file "%s": %m could not read file "%s": read %d of %zu could not write file "%s": %m in archive recovery in crash recovery in production max_connections setting:              %d
 max_locks_per_xact setting:           %d
 max_prepared_xacts setting:           %d
 max_wal_senders setting:              %d
 max_worker_processes setting:         %d
 no no data directory specified off on pg_control last modified:             %s
 pg_control version number:            %u
 possible byte ordering mismatch
The byte ordering used to store the pg_control file might not match the one
used by this program.  In that case the results below would be incorrect, and
the PostgreSQL installation would be incompatible with this data directory. shut down shut down in recovery shutting down starting up too many command-line arguments (first is "%s") track_commit_timestamp setting:       %s
 unrecognized status code unrecognized wal_level wal_level setting:                    %s
 wal_log_hints setting:                %s
 yes Project-Id-Version: PostgreSQL 15
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2022-09-27 13:15-0300
PO-Revision-Date: 2023-09-05 08:59+0200
Last-Translator: Euler Taveira <euler@eulerto.com>
Language-Team: Brazilian Portuguese <pgsql-translators@postgresql.org>
Language: pt_BR
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=(n>1);
 
Se o diretório de dados (DIRDADOS) não for especificado, a variável de ambiente PGDATA
é utilizada.

 
Opções:
   %s [OPÇÃO] [DIRDADOS]
   -?, --help             mostra essa ajuda e termina
   -V, --version          mostra informação sobre a versão e termina
  [-D, --pgdata=]DIRDADOS diretório de dados
 %s mostra informações de controle de um agrupamento de banco de dados PostgreSQL.

 Página web do %s: <%s>
 inteiros de 64 bits ??? Local de fim da cópia de segurança:                  %X/%X
 Local de início da cópia de segurança:               %X/%X
 Blocos por segmento da relação grande:               %u
 Bytes por segmento do WAL:                           %u
 Número da versão do catálogo:                        %u
 Versão da verificação de páginas de dados:           %u
 Tamanho do bloco do banco de dados:                  %u
 Estado do agrupamento de banco de dados:             %s
 Identificador do sistema de banco de dados:          %llu
 Tipo de data/hora do repositório:                    %s
 Registro de fim-da-cópia-de-segurança requerido:     %s
 Contador LSN falso para relações unlogged:           %X/%X
 Passagem de argumento float8:                        %s
 Local do último ponto de controle:                   %X/%X
 NextMultiOffset do último ponto de controle:         %u
 NextMultiXactId do último ponto de controle:         %u
 NextOID do último ponto de controle:                 %u
 NextXID do último ponto de controle:                 %u:%u
 PrevTimeLineID do último ponto de controle:          %u
 Arquivo com REDO do último ponto de controle:        %s
 Local de REDO do último ponto de controle:           %X/%X
 TimeLineID do último ponto de controle:              %u
 full_page_writes do último ponto de controle:        %s
 newestCommitTsXid do último ponto de controle:       %u
 oldestActiveXID do último ponto de controle:         %u
 oldestCommitTsXid do último ponto de controle:       %u
 BD do oldestMulti do último ponto de controle:       %u
 oldestMultiXid do último ponto de controle:          %u
 BD do oldestXID do último ponto de controle:         %u
 oldestXID do último ponto de controle:               %u
 Máximo de colunas em um índice:                      %u
 Máximo alinhamento de dado:                          %u
 Tamanho máximo de identificadores:                   %u
 Tamanho máximo do bloco TOAST:                       %u
 Linha do tempo do local final mínimo de recuperação: %u
 Local final mínimo de recuperação:                   %X/%X
 nonce para autenticação simulada:                    %s
 Relate erros a <%s>.
 Tamanho máximo do bloco de objeto grande:            %u
 Tamanho do segmento do WAL armazenado no arquivo, %d byte, não é uma potência de
dois entre 1 MB e 1 GB.  O arquivo está corrompido e os resultados abaixos não são
confiáveis.
 Tamanho do segmento do WAL armazenado no arquivo, %d bytes, não é uma potência de
dois entre 1 MB e 1 GB.  O arquivo está corrompido e os resultados abaixos não são
confiáveis.
 Hora do último ponto de controle:                    %s
 Tente "%s --help" para obter informações adicionais. Uso:
 Tamanho do bloco do WAL:                             %u
 AVISO: A soma de verificação de CRC não é a mesma do valor armazenado no arquivo.
O arquivo está corrompido ou tem um formato diferente do que este programa
está esperando.  Os resultados abaixo não são confiáveis.

 AVISO: tamanho do segmento do WAL inválido
 por referência por valor ordenação de bytes não corresponde não pôde fechar arquivo "%s": %m não pôde executar fsync no arquivo "%s": %m não pôde abrir arquivo "%s" para leitura: %m não pôde abrir arquivo "%s": %m não pôde ler arquivo "%s": %m não pôde ler arquivo "%s", leu %d de %zu não pôde escrever no arquivo "%s": %m recuperando de uma cópia recuperando de uma queda em produção Definição de max_connections:                        %d
 Definição de max_locks_per_xact:                     %d
 Definição de max_prepared_xacts:                     %d
 Definição de max_wal_senders:                        %d
 Definição de max_worker_processes:                   %d
 não nenhum diretório de dados foi especificado desabilitado habilitado Última modificação do pg_control:                    %s
 número da versão do pg_control:                      %u
 possível não correspondência da ordenação de bytes
A ordenação de bytes utilizada para armazenar o arquivo pg_control pode não 
corresponder com a utilizada por este programa. Neste caso os resultados abaixo
seriam incorretos, e a instalação do PostgreSQL seria incompatível com o diretório de dados. desligado desligado em recuperação desligando iniciando muitos argumentos de linha de comando (primeiro é "%s") Definição de track_commit_timestamp:                 %s
 código de status desconhecido wal_level desconhecido Definição de wal_level:                              %s
 Definição de wal_log_hints:                          %s
 sim 