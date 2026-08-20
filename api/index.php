<?php

// Prepare SQLite database in /tmp for Vercel Serverless environment
$dbSource = __DIR__ . '/../database/database.sqlite';
$dbTarget = '/tmp/database.sqlite';

if (file_exists($dbSource) && (!file_exists($dbTarget) || filesize($dbTarget) < 1000)) {
    @copy($dbSource, $dbTarget);
}

// Forward request to Laravel public index
require __DIR__ . '/../public/index.php';
