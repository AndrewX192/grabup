<?php
/**
 * Uploads files into the working directory.
 * NOTE: This script places files in the current working directory,
 * addition measures may be required to ensure the security of your server.
 *
 * Grabup for Linux.
 * @author Andrew Sorensen <andrew@localcoast.net>
 *
 * Distribution or modification of this file is premitted so long as
 * This header remains intact
 */

// === CONFIGURATION OPTIONS ===

$allowedIPAdresses = array(
    '198.51.100.5',
);

$allowedFileTypes = array(
    'png',
    'jpg',
);

define('REDIRECT_URL', 'http://www.example.com');

// === END CONFIGURATION OPTIONS ===

if (!in_array($_SERVER['HTTP_X_REAL_IP'], $allowedIPAdresses, true)) {
    redirect();
}

if ($_FILES['file']) {
    $fileParts = pathinfo($_FILES['file']['name']);

    if (in_array($fileParts['extension'], $allowedFileTypes, true)) {
        move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name']);
    } else {
        redirect();
    }
} else {
    redirect();
}

/**
 * Redrirects to a predefined URL.
 */
function redirect()
{
    header('Location: ' . REDIRECT_URL);
    exit;
}

