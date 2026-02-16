<?php declare(strict_types=1); ?>
<?php $flash = $flash ?? flash_get_all(); ?>
<?php $errors = $errors ?? []; ?>
<?php $info = $info ?? []; ?>

<?php if (!empty($errors)): ?>
  <div style="padding:12px; background:#ffe6e6; margin: 12px 0;">
    <strong>Errors:</strong>
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= h($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if (!empty($flash)): ?>
  <div style="padding:12px; background:#e6ffe6; margin: 12px 0;">
    <strong>Flash:</strong>
    <ul>
      <?php foreach ($flash as $k => $v): ?>
        <li><?= h($k) ?>: <?= h($v) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if (!empty($info)): ?>
  <div style="padding:12px; background:#eef; margin: 12px 0;">
    <strong>Info:</strong>
    <ul>
      <?php foreach ($info as $i): ?>
        <li><?= h($i) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>