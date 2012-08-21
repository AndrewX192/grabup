<?php
/**
 * Deletes files not modified XOR accessed within a given time.
 * NOTE: This script works off the current working directory, and should be
 * placed on a crontab as need sees.
 *
 * Grabup for Linux.
 * @author Andrew Sorensen <andrew@localcoast.net>
 *
 * Distribution or modification of this file is premitted so long as
 * This header remains intact
 */

// === CONFIGURATION OPTIONS ===

$deleteTime     = time() - (86400 * 30.5);
$fileTypes      = array('png', 'jpg');

// === END CONFIGURATION OPTIONS ===

$deleteCount    = 0;

foreach ($fileTypes as $type) {
    foreach (glob('*.' . $type) as $filename) {
        if ($deleteTime > filemtime($filename)) {
            echo $filename . PHP_EOL;
            unlink ($filename);
            $deleteCount++;
        }
    }
}

if (0 != $deleteCount) {
    echo 'Removed ' . $deleteCount . ' files.' . PHP_EOL;
}
