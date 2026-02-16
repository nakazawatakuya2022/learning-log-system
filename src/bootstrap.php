<?php
declare(strict_types=1);

session_start();
date_default_timezone_set('Asia/Tokyo');

require __DIR__ . '/config/env.php';
load_env(__DIR__ . '/../.env');

require __DIR__ . '/config/db.php';
require __DIR__ . '/lib/helpers.php';
require __DIR__ . '/lib/flash.php';
require __DIR__ . '/lib/csrf.php';
require __DIR__ . '/repo/logs_repo.php';