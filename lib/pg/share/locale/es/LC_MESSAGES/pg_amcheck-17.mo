��    x      �  �   �      (
      )
     J
     `
     q
     �
     �
  M   �
  S     H   V  V   �  =   �  A   4  U   v  Z   �  K   '  M   s  I   �  I     T   U  T   �     �  <     D   W  B   �  <   �  D     B   a  A   �  :   �  H   !  8   j  6   �  =   �  M     K   f  ;   �  U   �  7   D  =   |  ;   �  :   �  8   1  <   j  ,   �  0   �  7        =  <   @     }     �  =   �  +   �          +     ;     [  %   i     �     �     �  V   �  /     )   G  9   q     �     �  /   �       +   8  !   d     �  !   �  &   �     �  3   	     =  :   O     �     �     �  *   �     �  :   �  ,   8  !   e     �     �  3   �  2   �  ;        I  :   a  :   �     �     �             '   =  /   e     �  %   �     �  .   �  #        :  &   I     p     �  C   �  0   �  4        :  ,   T  /   �  #   �     �     �  (     	   /  �  9  -   �      !     7!     I!  #   c!     �!  ]   �!  f   �!  K   d"  b   �"  A   #  K   U#  [   �#  \   �#  Y   Z$  _   �$  K   %  _   `%  V   �%  n   &  "   �&  =   �&  U   �&  Q   ='  C   �'  R   �'  Q   &(  M   x(  F   �(  K   )  E   Y)  C   �)  R   �)  L   6*  O   �*  N   �*  b   "+  G   �+  O   �+  N   ,  J   l,  I   �,  :   -  0   <-  4   m-  <   �-     �-  B   �-     %.      <.  M   ].  6   �.  "   �.     /  0   /     H/  -   \/     �/     �/     �/  r   �/  5   ?0  @   u0  g   �0  $   1  !   C1  :   e1  1   �1  3   �1  )   2  &   02  (   W2  6   �2  +   �2  H   �2     ,3  R   E3  	   �3     �3  (   �3  3   �3     4  ?   #4  2   c4  $   �4     �4  	   �4  /   �4  <   5  I   L5     �5  F   �5  B   �5  '   @6     h6     �6  0   �6  ;   �6  J   	7  "   T7  8   w7     �7  C   �7  7   8     K8  6   \8     �8     �8  Y   �8  =   9  B   W9     �9  6   �9  E   �9  ,   7:  !   d:     �:  @   �:     �:     J   @          x   A          /           T       W   G   
       n   7   ^      o   v       >       U       L   #       5   f   d   c       r      ?   Z   R   9   &      ,   s   V   \   Q   l       H   S   *   .                 :   D       a   e       I   ]               `              2      j      _   	       <       i   t              =   ;      E   M   q   g   K   -   %   w   h          8      k   "   +       3   (             [   F       Y   C   0      '   N   m       6   X   4           )   p      P           1          b       $       u                            !             O                B           
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
 %s must be in range %d..%d --checkunique option is not supported by amcheck version "%s" Are %s's and amcheck's versions compatible? Cancel request sent
 Command was: %s Could not send cancel request:  Query was: %s Try "%s --help" for more information. Try fewer jobs. Usage:
 btree index "%s.%s.%s":
 btree index "%s.%s.%s": btree checking function returned unexpected number of rows: %d cannot duplicate null pointer (internal error)
 cannot specify a database name with --all cannot specify both a database name and database patterns checking btree index "%s.%s.%s" checking heap table "%s.%s.%s" could not connect to database %s: out of memory could not fsync file "%s": %m could not look up effective user ID %ld: %s could not open directory "%s": %m could not open file "%s": %m could not read directory "%s": %m could not rename file "%s" to "%s": %m could not stat file "%s": %m could not synchronize file system for file "%s": %m database "%s": %s database name contains a newline or carriage return: "%s"
 detail:  end block out of bounds end block precedes start block error sending command to database "%s": %s error:  heap table "%s.%s.%s", block %s, offset %s, attribute %s:
 heap table "%s.%s.%s", block %s, offset %s:
 heap table "%s.%s.%s", block %s:
 heap table "%s.%s.%s":
 hint:  improper qualified name (too many dotted names): %s improper relation name (too many dotted names): %s in database "%s": using amcheck version "%s" in schema "%s" including database "%s" internal error: received unexpected database pattern_id %d internal error: received unexpected relation pattern_id %d invalid argument for option %s invalid end block invalid start block invalid value "%s" for option %s no btree indexes to check matching "%s" no connectable databases to check matching "%s" no databases to check no heap tables to check matching "%s" no relations to check no relations to check in schemas matching "%s" no relations to check matching "%s" out of memory
 processing of database "%s" failed: %s query failed: %s query was: %s
 shell command argument contains a newline or carriage return: "%s"
 skipping database "%s": amcheck is not installed socket file descriptor out of range for select(): %d start block out of bounds this build does not support sync method "%s" too many command-line arguments (first is "%s") too many jobs for this platform: %d unrecognized sync method: %s user does not exist user name lookup failure: error code %lu warning:  Project-Id-Version: pg_amcheck (PostgreSQL) 16
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-08-01 11:23+0000
PO-Revision-Date: 2024-08-01 20:31-0400
Last-Translator: Carlos Chapi <carloswaldo@babelruins.org>
Language-Team: PgSQL-es-Ayuda <pgsql-es-ayuda@lists.postgresql.org>
Language: es
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: BlackCAT 1.1
 
Opciones para revisión de índices B-tree:
 
Opciones de conexión:
 
Otras opciones:
 
Reporte errores a <%s>.
 
Opciones para revisión de tabla:
 
Opciones de objetivo:
       --checkunique               verificar si restricción de unicidad se cumple en índice
       --endblock=BLOQUE           solo revisar la(s) tabla(s) hasta el número de bloque especificado
       --exclude-toast-pointers    NO seguir punteros TOAST de la relación
       --heapallindexed            revisar que todas las tuplas heap se encuentren en los índices
       --install-missing           instalar extensiones faltantes
       --maintenance-db=BASE       base de datos de mantención alternativa
       --no-dependent-indexes      NO expandir la lista de relaciones para incluir índices
       --no-dependent-toast        NO expandir lista de relaciones para incluir tablas TOAST
       --no-strict-names           NO requerir que los patrones coincidan con los objetos
       --on-error-stop             detener la revisión al final de la primera página corrupta
       --parent-check              revisar relaciones padre/hijo de índice
       --rootdescend               buscar desde la página raíz para volver a encontrar tuplas
       --skip=OPTION               NO revisar bloques «all-frozen» u «all-visible»
       --startblock=BLOQUE         empezar la revisión de la(s) tabla(s) en el número de bloque especificado
   %s [OPCIÓN]... [BASE-DE-DATOS]
   -?, --help                      mostrar esta ayuda y salir
   -D, --exclude-database=PATRÓN   NO revisar la(s) base(s) de datos que coincida(n)
   -I, --exclude-index=PATRÓN      NO revisar el(los) índice(s) que coincida(n)
   -P, --progress                  mostrar información de progreso
   -R, --exclude-relation=PATRÓN   NO revisar la(s) relación(es) que coincida(n)
   -S, --exclude-schema=PATRÓN     NO revisar el(los) esquema(s) que coincida(n)
   -T, --exclude-table=PATRÓN      NO revisar la(s) tabla(s) que coincida(n)
   -U, --username=USUARIO          nombre de usuario para la conexión
   -V, --version                   mostrar información de versión y salir
   -W, --password                  forzar la petición de contraseña
   -a, --all                       revisar todas las bases de datos
   -d, --database=PATRÓN           revisar la(s) base(s) de datos que coincida(n)
   -e, --echo                      mostrar las órdenes enviadas al servidor
   -h, --host=ANFITRIÓN            nombre del servidor o directorio del socket
   -i, --index=PATRÓN              revisar el(los) índice(s) que coincida(n)
   -j, --jobs=NUM                  usar esta cantidad de conexiones concurrentes hacia el servidor
   -p, --port=PUERTO               puerto del servidor de base de datos
   -r, --relation=PATRÓN           revisar la(s) relación(es) que coincida(n)
   -s, --schema=PATRÓN             revisar el(los) esquema(s) que coincida(n)
   -t, --table=PATRÓN              revisar la(s) tabla(s) que coincida(n)
   -v, --verbose                   desplegar varios mensajes informativos
   -w, --no-password               nunca pedir contraseña
 %*s/%s relaciones (%d%%), %*s/%s páginas (%d%%) %*s/%s relaciones (%d%%), %*s/%s páginas (%d%%) %*s %*s/%s relaciones (%d%%), %*s/%s páginas (%d%%), (%s%-*.*s) %s %s busca corrupción en objetos de una base de datos PostgreSQL.

 Sitio web de %s: <%s>
 %s debe estar en el rango %d..%d la opción --checkunique no está soportada por la versión «%s» de amcheck ¿Son compatibles la versión de %s con la de amcheck? Petición de cancelación enviada
 La orden era: % s No se pudo enviar la petición de cancelación:  La consulta era: %s Pruebe «%s --help» para mayor información. Intente con menos trabajos. Empleo:
 índice btree «%s.%s.%s»:
 índice btree «%s.%s.%s»: la función de comprobación de btree devolvió un número inesperado de registros: %d no se puede duplicar un puntero nulo (error interno)
 no se puede especificar un nombre de base de datos al usar --all no se puede especificar al mismo tiempo un nombre de base de datos junto con patrones de bases de datos revisando índice btree «%s.%s.%s» revisando tabla heap «%s.%s.%s» no se pudo conectar a la base de datos %s: memoria agotada no se pudo sincronizar (fsync) archivo «%s»: %m no se pudo buscar el ID de usuario efectivo %ld: %s no se pudo abrir el directorio «%s»: %m no se pudo abrir el archivo «%s»: %m no se pudo leer el directorio «%s»: %m no se pudo renombrar el archivo de «%s» a «%s»: %m no se pudo hacer stat al archivo «%s»: %m no se pudo sincronizar el sistema de archivos para el archivo «%s»: %m base de datos «%s»: %s el nombre de base de datos contiene un salto de línea o retorno de carro: «%s»
 detalle:  bloque final fuera de rango bloque final precede al bloque de inicio error al enviar orden a la base de datos «%s»: %s error:  tabla heap «%s.%s.%s», bloque %s, posición %s, atributo %s:
 tabla heap «%s.%s.%s», bloque %s, posición %s:
 tabla heap «%s.%s.%s», bloque %s:
 tabla heap «%s.%s.%s»:
 consejo:  el nombre no es válido (demasiados puntos): %s el nombre de relación no es válido (demasiados puntos): %s en base de datos «%s»: usando amcheck versión «%s» en esquema «%s» incluyendo base de datos «%s» error interno: se recibió pattern_id de base de datos inesperado (%d) error interno: se recibió pattern_id de relación inesperado (%d) argumento no válido para la opción %s bloque final no válido bloque de inicio no válido el valor «%s» no es válido para la opción %s no hay índices btree para revisar que coincidan con «%s» no hay bases de datos a las que se pueda conectar que coincidan con «%s» no hay bases de datos para revisar no hay tablas heap para revisar que coincidan con «%s» no hay relaciones para revisar no hay relaciones para revisar en esquemas que coincidan con «%s» no hay relaciones para revisar que coincidan con «%s» memoria agotada
 falló el procesamiento de la base de datos «%s»: %s la consulta falló: %s la consulta era: %s
 el argumento de la orden de shell contiene un salto de línea o retorno de carro: «%s»
 omitiendo la base de datos «%s»: amcheck no está instalado descriptor de archivo para socket fuera de rango para select(): %d bloque de inicio fuera de rango esta instalación no soporta el método de sync «%s» demasiados argumentos en la línea de órdenes (el primero es «%s») demasiados procesos para esta plataforma: %d método de sync no reconocido: %s el usuario no existe fallo en la búsqueda de nombre de usuario: código de error %lu precaución:  