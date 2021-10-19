<?php
define("DB_HOST", __DIR__ . "/../");
define("DB_FILENAME", DB_HOST . "/database/database.sqlite");
define("DB_ATTRIB", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));