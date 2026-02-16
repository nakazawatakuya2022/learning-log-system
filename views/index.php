<?php declare(strict_types=1); ?>
<h1>Logs</h1>

<section style="border:1px solid #ccc; padding:12px; margin:12px 0;">
  <h2>New</h2>
  <form method="post" action="./index.php">
    <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">

    <div>occurred_at: <input name="occurred_at" type="date" value="<?= h(($old['occurred_at'] ?? date('Y-m-d'))) ?>"></div>
    <div>language: <input name="language" value="<?= h($old['language'] ?? '') ?>"></div>
    <div>level: <input name="level" value="<?= h($old['level'] ?? 'NOTE') ?>"></div>
    <div>title*: <input name="title" value="<?= h($old['title'] ?? '') ?>" style="width: 100%;"></div>
    <div>message*: <textarea name="message" rows="4" style="width: 100%;"><?= h($old['message'] ?? '') ?></textarea></div>
    <div>solution: <textarea name="solution" rows="3" style="width: 100%;"><?= h($old['solution'] ?? '') ?></textarea></div>
    <div>
      <label><input type="checkbox" name="is_resolved" <?= !empty($old['is_resolved']) ? 'checked' : '' ?>> resolved</label>
      <label><input type="checkbox" name="is_knowledge" <?= !empty($old['is_knowledge']) ? 'checked' : '' ?>> knowledge</label>
    </div>

    <button type="submit">Save</button>
  </form>
</section>

<section>
  <h2>List (latest 10)</h2>
  <?php if (empty($logs)): ?>
    <p>No logs.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($logs as $row): ?>
        <li>
          <a href="./detail.php?id=<?= (int)$row['id'] ?>">
            #<?= (int)$row['id'] ?> <?= h($row['occurred_at']) ?> <?= h($row['title']) ?>
          </a>
          (<?= h($row['language']) ?> / <?= h($row['level']) ?>)
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>