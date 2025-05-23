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
  ,   !  /   N     ~     �  	   �  �  �  i   y     �  ]   �  !   M  <   o  �   �  D   0  <   u  L   �  @   �  <   @  �   }  :     6   >     u  e   �     �  $     %   :     `     x  1   �  F   �  B     6   J     �     �     �  �   �  1   Y     �  !   �  7   �  �   �  6   �  8   �  B   �     8  *   X  C   �  .   �  ;   �  *   2  8   ]  C   �  ,   �  (     5   0  8   f  *   �  `   �  ;   +   M   g   -   �   U   �   Q   9!  Q   �!     �!  
   �!  	   "  	   "  >   "  )   ["  &   �"  H   �"     �"  .   	#  8  8#  >   q$  +   �$  J   �$  B   '%  ,   j%  $   �%     �%     !      D   
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
the PostgreSQL installation would be incompatible with this data directory. seek failed for block %u in file "%s": %m syncing data directory this build does not support sync method "%s" too many command-line arguments (first is "%s") unrecognized sync method: %s updating control file warning:  Project-Id-Version: PostgreSQL 17
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-07-20 21:25+0000
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
Si aucun répertoire (RÉP_DONNÉES) n'est indiqué, la variable d'environnement
PGDATA est utilisée.

 
Options :
       --sync-method=METHODE  configure la méthode pour synchroniser les fichiers sur disque
   %s [OPTION]... [RÉP_DONNÉES]
   -?, --help                 affiche cette aide puis quitte
   -N, --no-sync              n'attend pas que les modifications soient
                             proprement écrites sur disque
   -P, --progress             affiche la progression de l'opération
   -V, --version              affiche la version puis quitte
   -c, --check                vérifie les sommes de contrôle (par défaut)
   -d, --disable              désactive les sommes de contrôle
   -e, --enable               active les sommes de contrôle
   -f, --filenode=FILENODE    vérifie seulement la relation dont l'identifiant
                             relfilenode est indiqué
   -v, --verbose              affiche des messages verbeux
  [-D, --pgdata=]REP_DONNEES  répertoire des données
 %lld/%lld Mo (%d%%) traités %s active, désactive ou vérifie les sommes de contrôle de données dans
une instance PostgreSQL.

 Page d'accueil de %s : <%s>
 %s doit être compris entre %d et %d Mauvaises sommes de contrôle : %lld
 Blocs parcourus : %lld
 Blocs écrits : %lld
 Opération sur les sommes de contrôle terminée
 Sommes de contrôle sur les données désactivées sur cette instance
 Sommes de contrôle sur les données activées sur cette instance
 Version des sommes de contrôle sur les données : %u
 Fichiers parcourus : %lld
 Fichiers écrits : %lld
 Rapporter les bogues à <%s>.
 L'instance a été initialisée avec une taille de bloc à %u alors que pg_checksums a été compilé avec une taille de bloc à %u. Essayez « %s --help » pour plus d'informations. Usage :
 différence de l'ordre des octets ne peut pas dupliquer un pointeur nul (erreur interne)
 échec de la vérification de la somme de contrôle dans le fichier « %s », bloc %u : somme de contrôle calculée %X, alors que le bloc contient %X sommes de contrôle activées dans le fichier « %s » sommes de contrôle vérifiées dans le fichier « %s » l'instance n'est pas compatible avec cette version de pg_checksums l'instance doit être arrêtée n'a pas pu fermer le fichier « %s » : %m n'a pas pu synchroniser sur disque (fsync) le fichier « %s » : %m n'a pas pu ouvrir le répertoire « %s » : %m n'a pas pu ouvrir le fichier « %s » pour une lecture : %m n'a pas pu ouvrir le fichier « %s » : %m n'a pas pu lire le bloc %u dans le fichier « %s » : %m n'a pas pu lire le bloc %u dans le fichier « %s » : %d lus sur %d n'a pas pu lire le répertoire « %s » : %m n'a pas pu lire le fichier « %s » : %m n'a pas pu lire le fichier « %s » : a lu %d sur %zu n'a pas pu renommer le fichier « %s » en « %s » : %m n'a pas pu tester le fichier « %s » : %m n'a pas pu synchroniser sur disque (fsync) le système de fichiers pour le fichier « %s » : %m n'a pas pu écrire le bloc %u dans le fichier « %s » : %m n'a pas pu écrire le bloc %u du fichier « %s » : a écrit %d octets sur %d impossible d'écrire le fichier « %s » : %m les sommes de contrôle sur les données sont déjà désactivées sur cette instance les sommes de contrôle sur les données sont déjà activées sur cette instance les sommes de contrôle sur les données ne sont pas activées sur cette instance l'instance n'est pas compatible détail :  erreur :  astuce :  numéro de segment %d invalide dans le nom de fichier « %s » valeur « %s » invalide pour l'option %s aucun répertoire de données indiqué l'option « -f/--filenode » peut seulement être utilisée avec --check mémoire épuisée
 la valeur CRC de pg_control n'est pas correcte possible incohérence dans l'ordre des octets
L'ordre des octets utilisé pour enregistrer le fichier pg_control peut ne
pas correspondre à celui utilisé par ce programme. Dans ce cas, les
résultats ci-dessous sont incorrects, et l'installation de PostgreSQL
est incompatible avec ce répertoire des données. n'a pas pu rechercher le bloc %u dans le fichier « %s » : %m synchronisation du répertoire des données cette construction ne supporte pas la méthode de synchronisation « %s » trop d'arguments en ligne de commande (le premier étant « %s ») méthode de synchronisation non reconnu : %s mise à jour du fichier de contrôle attention :  