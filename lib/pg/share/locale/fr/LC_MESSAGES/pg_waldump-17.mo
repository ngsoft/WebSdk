��    n      �  �   �      P	  
   Q	     \	  %   s	  6   �	  3   �	  P   
  �   U
  P   �
  ?   0  I   p  =   �  A   �  6   :  �   q  D   Y  �   �  >   <  �   {  B     C   D  ~   �       D   
     O     c  9   ~  4   �  2   �  ;      @   \  R   �     �  :     B   K  %   �     �  �   �  P   C  Q   �  /   �        #   7     [  #   y  -   �  )   �     �          .     L  6   k  !   �     �     �  !   �       '   9  ,   a  7   �  &   �  T   �  I   B  @   �  =   �       3   (     \  +   z     �  &   �  .   �           &  z   .     �  ;   �     �  h        p     �  5   �     �     �  >     A   M  <   �  <   �  $   	  '   .  *   V      �  \   �     �       ,   2     _  6   n  !   �  Q   �  .     #   H  $   l  0   �  $   �  ,   �  /     A   D  $   �  	   �  �  �     s!     !  '   �!  L   �!  ?   "  �   T"  �   �"  �   �#  ?   U$  �   �$  �   %  �   �%  E   $&  f  j&  M   �'  3  (  �   S)  �   �)  �   �*  �   ;+  �   �+     �,  R   �,     �,  $   -  O   1-  A   �-  H   �-  S   .  J   `.  ]   �.  "   	/  :   ,/  V   g/  1   �/     �/  �   �/  b   �0  g   1  7   ~1  %   �1  0   �1  *   2  .   82  2   g2  8   �2  &   �2  +   �2  C   &3  *   j3  L   �3  .   �3  %   4  *   74  ,   b4  (   �4  4   �4  @   �4  J   .5  8   y5  g   �5  T   6  G   o6  E   �6  *   �6  `   (7  -   �7  A   �7  
   �7  2   8  e   78  G   �8  	   �8  �   �8  	   �9  b   �9  $   �9  �   :  #   �:     �:  :   �:     &;     F;  Q   d;  M   �;  O   <  P   T<  .   �<  >   �<  ?   =  )   S=  k   }=     �=  =   >  5   A>     w>  \   �>  !   �>  h   
?  6   s?  ,   �?  3   �?  h   @  .   t@  J   �@  B   �@  S   1A  )   �A     �A         b      8               ,   	                   S      
   R      6   '   J          G          [      T   .   \   k   ?      e   *       j   A                  a      /   f                       H       )                X       K   U   Z   =   c   #               Y   C           O   2   "       3   N       m       :   <   ;      $   &          _   +   E          %       0   ^   -   !       L   P      W   h   M   F      Q   1             (      `         D   g          V   d      l      9          i   I   B       n   ]   >          @      7       4   5    
Options:
 
Report bugs to <%s>.
   %s [OPTION]... [STARTSEG [ENDSEG]]
   --save-fullpage=DIR    save full page images to DIR
   -?, --help             show this help, then exit
   -B, --block=N          with --relation, only show records that modify block N
   -F, --fork=FORK        only show records that modify blocks in fork FORK;
                         valid names are main, fsm, vm, init
   -R, --relation=T/D/R   only show records that modify blocks in relation T/D/R
   -V, --version          output version information, then exit
   -b, --bkp-details      output detailed information about backup blocks
   -e, --end=RECPTR       stop reading at WAL location RECPTR
   -f, --follow           keep retrying after reaching end of WAL
   -n, --limit=N          number of records to display
   -p, --path=PATH        directory in which to find WAL segment files or a
                         directory with a ./pg_wal that contains such files
                         (default: current directory, ./pg_wal, $PGDATA/pg_wal)
   -q, --quiet            do not print any output, except for errors
   -r, --rmgr=RMGR        only show records generated by resource manager RMGR;
                         use --rmgr=list to list valid resource manager names
   -s, --start=RECPTR     start reading at WAL location RECPTR
   -t, --timeline=TLI     timeline from which to read WAL records
                         (default: 1 or the value used in STARTSEG)
   -w, --fullpage         only show records with a full page write
   -x, --xid=XID          only show records with transaction ID XID
   -z, --stats[=record]   show statistics instead of records
                         (optionally, show per-record statistics)
 %s %s decodes and displays PostgreSQL write-ahead logs for debugging.

 %s home page: <%s>
 %s must be in range %u..%u BKPBLOCK_HAS_DATA not set, but data length is %u at %X/%X BKPBLOCK_HAS_DATA set, but no data included at %X/%X BKPBLOCK_SAME_REL set but no previous rel at %X/%X BKPIMAGE_COMPRESSED set, but block image length %u at %X/%X BKPIMAGE_HAS_HOLE not set, but hole offset %u length %u at %X/%X BKPIMAGE_HAS_HOLE set, but hole offset %u length %u block image length %u at %X/%X ENDSEG %s is before STARTSEG %s Expecting "tablespace OID/database OID/relation filenode". The WAL segment size must be a power of two between 1 MB and 1 GB. Try "%s --help" for more information. Usage:
 WAL file is from different database system: WAL file database system identifier is %llu, pg_control database system identifier is %llu WAL file is from different database system: incorrect XLOG_BLCKSZ in page header WAL file is from different database system: incorrect segment size in page header cannot duplicate null pointer (internal error)
 contrecord is requested by %X/%X could not access directory "%s": %m could not close file "%s": %m could not create directory "%s": %m could not decompress image at %X/%X, block %d could not find a valid record after %X/%X could not find any WAL file could not find file "%s": %m could not fsync file "%s": %m could not locate WAL file "%s" could not locate backup block with ID %d in WAL record could not open directory "%s": %m could not open file "%s" could not open file "%s": %m could not read directory "%s": %m could not read file "%s": %m could not read file "%s": read %d of %d could not read from file "%s", offset %d: %m could not read from file "%s", offset %d: read %d of %d could not rename file "%s" to "%s": %m could not restore image at %X/%X compressed with %s not supported by build, block %d could not restore image at %X/%X compressed with unknown method, block %d could not restore image at %X/%X with invalid block %d specified could not restore image at %X/%X with invalid state, block %d could not stat file "%s": %m could not synchronize file system for file "%s": %m could not write file "%s": %m custom resource manager "%s" does not exist detail:  directory "%s" exists but is not empty end WAL location %X/%X is not inside file "%s" error in WAL record at %X/%X: %s error:  first record is after %X/%X, at %X/%X, skipping over %u byte first record is after %X/%X, at %X/%X, skipping over %u bytes hint:  incorrect resource manager data checksum in record at %X/%X invalid WAL location: "%s" invalid WAL segment size in WAL file "%s" (%d byte) invalid WAL segment size in WAL file "%s" (%d bytes) invalid block number: "%s" invalid block_id %u at %X/%X invalid contrecord length %u (expected %lld) at %X/%X invalid fork name: "%s" invalid fork number: %u invalid info bits %04X in WAL segment %s, LSN %X/%X, offset %u invalid magic number %04X in WAL segment %s, LSN %X/%X, offset %u invalid record length at %X/%X: expected at least %u, got %u invalid record offset at %X/%X: expected at least %u, got %u invalid relation specification: "%s" invalid resource manager ID %u at %X/%X invalid transaction ID specification: "%s" invalid value "%s" for option %s neither BKPIMAGE_HAS_HOLE nor BKPIMAGE_COMPRESSED set, but block image length is %u at %X/%X no arguments specified no start WAL location given option %s requires option %s to be specified out of memory
 out of memory while allocating a WAL reading processor out-of-order block_id %u at %X/%X out-of-sequence timeline ID %u (after %u) in WAL segment %s, LSN %X/%X, offset %u record with incorrect prev-link %X/%X at %X/%X record with invalid length at %X/%X resource manager "%s" does not exist start WAL location %X/%X is not inside file "%s" there is no contrecord flag at %X/%X this build does not support sync method "%s" too many command-line arguments (first is "%s") unexpected pageaddr %X/%X in WAL segment %s, LSN %X/%X, offset %u unrecognized value for option %s: %s warning:  Project-Id-Version: PostgreSQL 17
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-08-22 10:19+0000
PO-Revision-Date: 2024-09-16 16:28+0200
Last-Translator: Guillaume Lelarge <guillaume@lelarge.info>
Language-Team: French <guillaume@lelarge.info>
Language: fr
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=(n > 1);
X-Generator: Poedit 3.5
 
Options :
 
Rapporter les bogues à <%s>.
   %s [OPTION]... [SEG_DEBUT [SEG_FIN]]
   --save-fullpage=RÉP           sauvegarde les images complètes dans RÉP
   -?, --help                    affiche cette aide puis quitte
   -B, --block=N                 avec --relation, affiche seulement les enregistrements
                                qui modifient le bloc N
   -F, --fork=FORK               affiche seulement les enregistrements qui modifient
                                des blocs dans le fork FORK ;
                                les noms valides sont main, fsm, vm, init
   -R, --relation=T/D/R          affiche seulement les enregistrements qui modifient
                                les blocs de la relation T/D/R
   -V, --version                 affiche la version puis quitte
   -b, --bkp-details             affiche des informations détaillées sur les
                                blocs de sauvegarde
   -e, --end=RECPTR              arrête la lecture des journaux de transactions à
                                l'emplacement RECPTR
   -f, --follow                  continue après avoir atteint la fin des journaux
                                de transactions
   -n, --limit=N                 nombre d'enregistrements à afficher
   -p, --path=CHEMIN             répertoire où trouver les fichiers des segments
                                de journaux de transactions ou un répertoire
                                avec ./pg_wal qui contient ces fichiers (par
                                défaut : répertoire courant, ./pg_wal,
                                $PGDATA/pg_wal)
   -q, --quiet                   n'écrit aucun message, sauf en cas d'erreur
   -r, --rmgr=RMGR               affiche seulement les enregistrements générés
                                par le gestionnaire de ressources RMGR, utilisez
                                --rmgr=list pour avoir une liste des noms valides
                                de gestionnaires de ressources
   -s, --start=RECPTR            commence à lire à l'emplacement RECPTR des
                                journaux de transactions
   -t, --timeline=TLI            timeline à partir de laquelle lire les
                                enregistrements des journaux (par défaut : 1 ou
                                la valeur utilisée dans SEG_DÉBUT)
   -w, --fullpage                affiche seulement les enregistrements avec
                                un bloc complet (FPW)
   -x, --xid=XID                 affiche seulement des enregistrements avec
                                l'identifiant de transaction XID
   -z, --stats[=enregistrement]  affiche des statistiques à la place
                                d'enregistrements (en option, affiche des
                                statistiques par enregistrement)
 %s %s décode et affiche les journaux de transactions PostgreSQL pour du
débogage.

 Page d'accueil de %s : <%s>
 %s doit être compris entre %u et %u BKPBLOCK_HAS_DATA non configuré, mais la longueur des données est %u à %X/%X BKPBLOCK_HAS_DATA configuré, mais aucune donnée inclus à %X/%X BKPBLOCK_SAME_REL configuré, mais pas de relation précédente à %X/%X BKPIMAGE_COMPRESSED configuré, mais la longueur de l'image du bloc est %u à %X/%X BKPIMAGE_HAS_HOLE désactivé, mais décalage trou %u longueur %u à %X/%X BKPIMAGE_HAS_HOLE activé, mais décalage trou %u longueur %u longueur image bloc %u à %X/%X SEG_FIN %s est avant SEG_DÉBUT %s Attendait « OID tablespace/OID base/filenode relation ». La taille du segment WAL doit être une puissance de deux comprise entre 1 Mo et 1 Go. Essayez « %s --help » pour plus d'informations. Usage :
 Le fichier WAL provient d'une instance différente : l'identifiant système de la base dans le fichier WAL est %llu, alors que l'identifiant système de la base dans pg_control est %llu Le fichier WAL provient d'une instance différente : XLOG_BLCKSZ incorrect dans l'en-tête de page Le fichier WAL provient d'une instance différente : taille invalide du segment dans l'en-tête de page ne peut pas dupliquer un pointeur nul (erreur interne)
 « contrecord » est requis par %X/%X n'a pas pu accéder au répertoire « %s » : %m n'a pas pu fermer le fichier « %s » : %m n'a pas pu créer le répertoire « %s » : %m n'a pas pu décompresser l'image à %X/%X, bloc %d n'a pas pu trouver un enregistrement valide après %X/%X n'a pas pu trouver un seul fichier WAL n'a pas pu trouver le fichier « %s » : %m n'a pas pu synchroniser sur disque (fsync) le fichier « %s » : %m n'a pas pu trouver le fichier WAL « %s » n'a pas pu localiser le bloc de sauvegarde d'ID %d dans l'enregistrement WAL n'a pas pu ouvrir le répertoire « %s » : %m n'a pas pu ouvrir le fichier « %s » n'a pas pu ouvrir le fichier « %s » : %m n'a pas pu lire le répertoire « %s » : %m n'a pas pu lire le fichier « %s » : %m n'a pas pu lire le fichier « %s » : a lu %d sur %d n'a pas pu lire à partir du fichier « %s », décalage %d : %m n'a pas pu lire à partir du fichier « %s », décalage %d : %d lu sur %d n'a pas pu renommer le fichier « %s » en « %s » : %m n'a pas pu restaurer l'image à %X/%X compressé avec %s, qui est non supporté par le serveur, bloc %d n'a pas pu restaurer l'image à %X/%X compressé avec une méthode inconnue, bloc %d n'a pas pu restaurer l'image à %X/%X avec le bloc invalide %d indiqué n'a pas pu restaurer l'image à %X/%X avec un état invalide, bloc %d n'a pas pu tester le fichier « %s » : %m n'a pas pu synchroniser sur disque (fsync) le système de fichiers pour le fichier « %s » : %m impossible d'écrire le fichier « %s » : %m le gestionnaire de ressources personnalisé « %s » n'existe pas détail :  le répertoire « %s » existe mais n'est pas vide l'emplacement de fin des journaux de transactions %X/%X n'est pas à l'intérieur du fichier « %s » erreur dans l'enregistrement des journaux de transactions à %X/%X : %s erreur :  le premier enregistrement se trouve après %X/%X, à %X/%X, ignore %u octet le premier enregistrement se trouve après %X/%X, à %X/%X, ignore %u octets astuce :  somme de contrôle des données du gestionnaire de ressources incorrecte à
l'enregistrement %X/%X emplacement WAL invalide :  « %s » taille invalide du segment WAL dans le fichier WAL « %s » (%d octet) taille invalide du segment WAL dans le fichier WAL « %s » (%d octets) numéro de bloc invalide : « %s » block_id %u invalide à %X/%X longueur %u invalide du contrecord (%lld attendu) à %X/%X nom du fork invalide : « %s » numéro du fork invalide : %u bits d'information %04X invalides dans le segment WAL %s, LSN %X/%X, décalage %u numéro magique invalide %04X dans le segment WAL %s, LSN %X/%X, décalage %u longueur invalide de l'enregistrement à %X/%X : attendait au moins %u, a eu %u décalage invalide de l'enregistrement à %X/%X : attendait au moins %u, a eu %u spécification de relation invalide : « %s » identifiant du gestionnaire de ressources invalide %u à %X/%X spécification d'identifiant de transaction invalide : « %s » valeur « %s » invalide pour l'option %s ni BKPIMAGE_HAS_HOLE ni BKPIMAGE_COMPRESSED configuré, mais la longueur de l'image du bloc est %u à %X/%X aucun argument spécifié pas d'emplacement donné de début du journal de transactions l'option %s requiert la spécification de l'option %s mémoire épuisée
 plus de mémoire lors de l'allocation d'un processeur de lecture de journaux de transactions block_id %u désordonné à %X/%X identifiant timeline %u hors de la séquence (après %u) dans le segment WAL %s, LSN %X/%X, décalage %u enregistrement avec prev-link %X/%X incorrect à %X/%X enregistrement de longueur invalide à %X/%X le gestionnaire de ressources « %s » n'existe pas l'emplacement de début des journaux de transactions %X/%X n'est pas à l'intérieur du fichier « %s » il n'existe pas de drapeau contrecord à %X/%X cette construction ne supporte pas la méthode de synchronisation « %s » trop d'arguments en ligne de commande (le premier étant « %s ») pageaddr %X/%X inattendue dans le journal de transactions %s, LSN %X/%X, segment %u valeur non reconnue pour l'option %s : %s attention :  