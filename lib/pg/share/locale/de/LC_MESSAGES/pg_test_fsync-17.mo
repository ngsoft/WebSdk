��    &      L  5   |      P  1   Q  2   �  /   �     �  8        :     T     o     �     �     �     �  (   �  U     [   f  M   �  c        t  .   �  F   �  E     %   K  +   q  /   �  !   �     �     
               (     /     N     R     W  /   f  	   �     �  �  �  F   i
  K   �
  <   �
  %   9  @   _     �     �     �     �          7     V  *   ]  k   �  h   �  W   ]  k   �     !  9   ?  S   y  R   �  7      ,   X  2   �  '   �  !   �                    )  #   0     T     Z     a  7   x  	   �     �     $          
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
 too many command-line arguments (first is "%s") warning:  write failed Project-Id-Version: pg_test_fsync (PostgreSQL) 15
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2024-06-16 07:54+0000
PO-Revision-Date: 2024-05-26 22:03+0200
Last-Translator: Peter Eisentraut <peter@eisentraut.org>
Language-Team: German <pgsql-translators@postgresql.org>
Language: de
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
 
Vergleich von Datei-Sync-Methoden bei einem Schreibvorgang aus %dkB:
 
Vergleich von Datei-Sync-Methoden bei zwei Schreibvorgängen aus je %dkB:
 
Vergleich von open_sync mit verschiedenen Schreibgrößen:
 
Nicht gesynctes Schreiben von %dkB:
 
Probe ob fsync auf einem anderen Dateideskriptor funktioniert:
  1 * 16kB open_sync schreiben  2 *  8kB open_sync schreiben  4 *  4kB open_sync schreiben  8 *  2kB open_sync schreiben   %13.3f Op./s  %6.0f µs/Op.
 %s muss im Bereich %u..%u sein %s: %m %u Sekunde pro Test
 %u Sekunden pro Test
 (Wenn die Zeiten ähnlich sind, dann kann fsync() auf einem anderen Deskriptor
geschriebene Daten syncen.)
 (Damit werden die Kosten für das Schreiben von 16kB in verschieden Größen mit
open_sync verglichen.)
 (in Rangordnung von »wal_sync_method«, außer dass fdatasync auf Linux Standard ist)
 * Dieses Dateisystem und die Mount-Optionen unterstützen kein Direct-I/O,
  z.B. ext4 im Journaled-Modus.
 16 *  1kB open_sync schreiben Direct-I/O wird auf dieser Plattform nicht unterstützt.
 F_NOCACHE wird auf dieser Plattform für open_datasync und open_sync unterstützt.
 O_DIRECT wird auf dieser Plattform für open_datasync und open_sync unterstützt.
 Versuchen Sie »%s --help« für weitere Informationen. Aufruf: %s [-f DATEINAME] [-s SEK-PRO-TEST]
 kann NULL-Zeiger nicht kopieren (interner Fehler)
 konnte Thread für Alarm nicht erzeugen konnte Ausgabedatei nicht öffnen Detail:  Fehler:  fsync fehlgeschlagen Tipp:  ungültiges Argument für Option %s entf. entf.* Speicher aufgebraucht
 zu viele Kommandozeilenargumente (das erste ist »%s«) Warnung:  Schreiben fehlgeschlagen 