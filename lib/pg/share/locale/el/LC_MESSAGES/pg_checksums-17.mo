��    <      �  S   �      (  X   )  
   �     �  5   �  P   �  5   0  A   f  :   �  2   �  1     G   H  3   �  *   �     �  T        a     u     �     �     �     �     �     	     .	     I	     `	     v	  j   �	  %   �	     
  a   %
     �
     �
  ;   �
       !        >  (   [  3   �     �  )   �  5   �  .   5  -   d  )   �  "   �     �     �     �  +   �      #     D  2   `  !   �  )   �     �  /   �     &  	   <  �  F  �   �       #   �  ~   �  ~   6  R   �  x     v   �  t   �  p   m  k   �  R   J  A   �  .   �  �     #   �  F     =   L  $   �  #   �  ^   �  ~   2  \   �  7     %   F  $   l  B   �  �   �  X   �     �  �   �  [   �  W   @  c   �  :   �  U   7  Q   �  d   �     D  T   �  [     r   u  �   �  �   m  �   �  R   o      �      �      �   a   �   B   _!  =   �!  t   �!  :   U"  U   �"  @   �"  �   '#  4   �#     �#     &          %   ,                   *   :            )   7                            8           0   .   1      5                                       3      /          <   #      ;      4         "      '          $   2       	   !          6   9       -          
   +                     (        
If no data directory (DATADIR) is specified, the environment variable PGDATA
is used.

 
Options:
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
 checksum verification failed in file "%s", block %u: calculated checksum %X but block contains %X checksums enabled in file "%s" checksums verified in file "%s" cluster is not compatible with this version of pg_checksums cluster must be shut down could not open directory "%s": %m could not open file "%s": %m could not read block %u in file "%s": %m could not read block %u in file "%s": read %d of %d could not stat file "%s": %m could not write block %u in file "%s": %m could not write block %u in file "%s": wrote %d of %d data checksums are already disabled in cluster data checksums are already enabled in cluster data checksums are not enabled in cluster database cluster is not compatible detail:  error:  hint:  invalid segment number %d in file name "%s" invalid value "%s" for option %s no data directory specified option -f/--filenode can only be used with --check pg_control CRC value is incorrect seek failed for block %u in file "%s": %m syncing data directory too many command-line arguments (first is "%s") updating control file warning:  Project-Id-Version: pg_checksums (PostgreSQL) 15
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2023-04-14 09:21+0000
PO-Revision-Date: 2023-04-14 13:01+0200
Last-Translator: Georgios Kokolatos <gkokolatos@pm.me>
Language-Team: 
Language: el
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: Poedit 3.2.2
 
Εάν δεν έχει καθοριστεί κατάλογος δεδομένων (DATADIR), χρησιμοποιείται η
μεταβλητή περιβάλλοντος PGDATA.

 
Επιλογές:
   %s [ΕΠΙΛΟΓΗ]... [DATADIR]
   -?, --help               εμφάνισε αυτό το μήνυμα βοήθειας, στη συνέχεια έξοδος
   -N, --no-sync            να μην αναμένει την ασφαλή εγγραφή αλλαγών στον δίσκο
   -P, --progress           εμφάνισε πληροφορίες προόδου
   -V, --version            εμφάνισε πληροφορίες έκδοσης, στη συνέχεια έξοδος
   -c, --check              έλεγξε αθροίσματα ελέγχου δεδομένων (προεπιλογή)
   -d, --disable            απενεργοποίησε τα αθροίσματα ελέγχου δεδομένων
   -e, --enable             ενεργοποίησε τα αθροίσματα ελέγχου δεδομένων
   -f, --filenode=FILENODE  έλεγξε μόνο τη σχέση με το καθορισμένο filenode
   -v, --verbose            περιφραστικά μηνύματα εξόδου
  [-D, --pgdata=]DATADIR    κατάλογος δεδομένων
 %lld/%lld ΜΒ (%d%%) υπολογισμένο %s ενεργοποιεί, απενεργοποιεί ή επαληθεύει τα αθροίσματα ελέγχου δεδομένων σε μία συστάδα βάσεων δεδομένων PostgreSQL.

 %s αρχική σελίδα: <%s>
 %s πρέπει να βρίσκεται εντός εύρους %d..%d Εσφαλμένα αθροίσματα ελέγχου: %lld
 Σαρωμένα μπλοκ:   %lld
 Γραμμένα μπλοκ:  %lld
 Ολοκληρώθηκε η λειτουργία του αθροίσματος ελέγχου
 Τα αθροίσματα ελέγχου δεδομένων είναι απενεργοποιημένα στη συστάδα
 Ενεργοποίηση των αθροισμάτων ελέγχου στη συστάδα
 Έκδοση αθροισμάτων ελέγχου: %u
 Σαρωμένα αρχεία:  %lld
 Γραμμένα αρχεία: %lld
 Υποβάλετε αναφορές σφάλματων σε <%s>.
 Η συστάδα βάσεων δεδομένων αρχικοποιήθηκε με μέγεθος μπλοκ %u, αλλά το pg_checksums συντάχθηκε με μέγεθος μπλοκ %u. Δοκιμάστε «%s --help» για περισσότερες πληροφορίες. Χρήση:
 επαλήθευση του αθροίσματος ελέγχου απέτυχε στο αρχείο «%s», μπλοκ %u: υπολογισμένο άθροισμα ελέγχου %X αλλά το μπλοκ περιέχει %X ενεργοποιημένα αθροίσματα ελέγχου στο αρχείο «%s» επαληθευμένα αθροίσματα ελέγχου στο αρχείο «%s» η συστάδα δεν είναι συμβατή με αυτήν την έκδοση pg_checksums η συστάδα πρέπει να τερματιστεί δεν ήταν δυνατό το άνοιγμα του καταλόγου «%s»: %m δεν ήταν δυνατό το άνοιγμα του αρχείου «%s»: %m δεν ήταν δυνατή η ανάγνωση του μπλοκ %u στο αρχείο «%s»: %m δεν ήταν δυνατή η ανάγνωση του μπλοκ %u στο αρχείο «%s»: ανάγνωσε %d από %d δεν ήταν δυνατή η εκτέλεση stat στο αρχείο «%s»: %m δεν ήταν δυνατή η εγγραφή μπλοκ %u στο αρχείο «%s»: %m δεν ήταν δυνατή η εγγραφή μπλοκ %u στο αρχείο «%s»: έγραψε %d από %d τα αθροίσματα ελέγχου δεδομένων είναι ήδη απενεργοποιημένα στη συστάδα τα αθροίσματα ελέγχου δεδομένων είναι ήδη ενεργοποιημένα στη συστάδα τα αθροίσματα ελέγχου δεδομένων δεν είναι ενεργοποιημένα στη συστάδα η συστάδα βάσεων δεδομένων δεν είναι συμβατή λεπτομέρεια:  σφάλμα:  υπόδειξη:  μη έγκυρος αριθμός τμήματος %d στο αρχείο με όνομα «%s» μη έγκυρη τιμή  «%s» για την επιλογή %s δεν ορίστηκε κατάλογος δεδομένων η επιλογή -f/--filenode μπορεί να χρησιμοποιηθεί μόνο μαζί με την --check η τιμή pg_control CRC είναι λανθασμένη αναζήτηση απέτυχε για μπλοκ %u στο αρχείο «%s»: %m συγχρονίζεται κατάλογος δεδομένων πάρα πολλές παράμετροι εισόδου από την γραμμή εντολών (η πρώτη είναι η «%s») ενημερώνεται αρχείο ελέγχου προειδοποίηση:  