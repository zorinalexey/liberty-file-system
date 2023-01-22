<?php

use Liberty\FileSystem\FileSystemException;

    if (!defined('SEP')) {
        define('SEP', DIRECTORY_SEPARATOR);
    }

    if (!defined('TMP')) {
        define('ROOT', dirname(__DIR__, 4) . SEP);
    }

    if (!defined('TMP')) {
        define('TMP', ROOT . 'TMP' . SEP);
    }

