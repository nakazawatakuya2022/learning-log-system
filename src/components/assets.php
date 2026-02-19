<?php declare(strict_types=1);
echo "<!-- page_css=" . htmlspecialchars((string)($page_css ?? ''), ENT_QUOTES, 'UTF-8') . " -->\n";


$ver = '20260219'; // 適当でOK（更新のたびに変える）

echo '<link rel="stylesheet" href="./assets/css/base.css?v=' . h($ver) . '">' . PHP_EOL;

if (!empty($page_css)) {
    echo '<link rel="stylesheet" href="./assets/css/' . h(basename((string)$page_css)) . '?v=' . h($ver) . '">' . PHP_EOL;
}

if (!empty($page_js)) {
    echo '<script src="./assets/js/' . h(basename((string)$page_js)) . '?v=' . h($ver) . '" defer></script>' . PHP_EOL;
}
