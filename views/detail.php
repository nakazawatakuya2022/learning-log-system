<?php declare(strict_types=1); ?>
<?php if (empty($log)): ?>
  <p>not found</p>
<?php else: ?>
  <p><a href="/index.php">← Back</a></p>

  <h1>Detail #<?= (int)$log['id'] ?></h1>
  <p>occurred_at: <strong><?= h((string)$log['occurred_at']) ?></strong>（更新不可）</p>

  <form method="post" action="/detail.php">
    <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
    <input type="hidden" name="id" value="<?= (int)$log['id'] ?>">

    <div>language: <input name="language" value="<?= h((string)$log['language']) ?>"></div>
    <div>level: <input name="level" value="<?= h((string)$log['level']) ?>"></div>
    <div>title*: <input name="title" value="<?= h((string)$log['title']) ?>" style="width: 100%;"></div>
    <div>message*: <textarea name="message" rows="6" style="width: 100%;"><?= h((string)$log['message']) ?></textarea></div>
    <div>solution: <textarea name="solution" rows="4" style="width: 100%;"><?= h((string)($log['solution'] ?? '')) ?></textarea></div>
    <div>
      <label><input type="checkbox" name="is_resolved" <?= !empty($log['is_resolved']) ? 'checked' : '' ?>> resolved</label>
      <label><input type="checkbox" name="is_knowledge" <?= !empty($log['is_knowledge']) ? 'checked' : '' ?>> knowledge</label>
    </div>

    <button type="submit">Update</button>
  </form>
<?php endif; ?>