<?php declare(strict_types=1); ?>
<!-- HEADER_LOADED -->
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h((string)($page_title ?? 'Learning Logs')) ?></title>
  <?php require __DIR__ . '/assets.php'; ?>
</head>
<body class="<?= h((string)($body_class ?? '')) ?>">
<main class="wrap">
