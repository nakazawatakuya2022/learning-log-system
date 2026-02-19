<?php
declare(strict_types=1);

/**
 * 期待する変数（renderから渡される想定）
 * - $log    : array|null
 * - $errors : array|null
 * - $mode   : 'view'|'edit'（POSTバリデ失敗時は edit 推奨）
 */
$page_title = 'Log Detail';
$body_class = 'page-detail';
$page_css   = 'detail.css';
$page_js    = 'detail.js';

$log = $log ?? null;
$errors = $errors ?? [];
$mode = (string)($mode ?? 'view');

require __DIR__ . '/../src/components/header.php';
require __DIR__ . '/../src/components/messages.php';
?>

<?php if (empty($log)): ?>
  <p>not found</p>
  <?php require __DIR__ . '/../src/components/footer.php'; ?>
  <?php exit; ?>
<?php endif; ?>

<?php
$isEdit = ($mode === 'edit') || !empty($errors);

$is_resolved  = (int)($log['is_resolved'] ?? 0) === 1;
$is_knowledge = (int)($log['is_knowledge'] ?? 0) === 1;

$meta = h((string)($log['language'] ?? '')) . ' / ' .
        h((string)($log['occurred_at'] ?? '')) . ' / ' .
        h((string)($log['level'] ?? ''));

$updatedAt = (string)($log['updated_at'] ?? '');
$solution  = (string)($log['solution'] ?? '');
?>

<a href="./index.php" class="back">← Back</a>

<h1 id="titleView"><?= h((string)($log['title'] ?? '')) ?></h1>
<div class="meta"><?= $meta ?></div>
<div class="updated">Last updated: <?= h($updatedAt) ?></div>

<div class="actions">
  <button id="btnEdit" class="secondary<?= $isEdit ? ' hidden' : '' ?>" type="button">Edit</button>
  <button id="btnCancel" class="secondary<?= $isEdit ? '' : ' hidden' ?>" type="button">Cancel</button>

  <!-- フォーム外submit（HTML設計通り） -->
  <button id="btnSave" class="<?= $isEdit ? '' : ' hidden' ?>" type="submit" form="editMode">Save</button>
</div>

<div id="editNotice" class="notice<?= $isEdit ? '' : ' hidden' ?>">
  編集モードです。Cancelで元に戻せます。
</div>

<div class="rule"></div>

<!-- VIEW MODE -->
<div id="viewMode"<?= $isEdit ? ' class="hidden"' : '' ?>>
  <div class="section-title">Status / Knowledge</div>

  <div class="row">
    <div class="label">Status</div>
    <div class="box" id="resolvedView"><?= $is_resolved ? 'Resolved' : 'Unresolved' ?></div>
  </div>

  <div class="row">
    <div class="label">Knowledge</div>
    <div class="box" id="knowledgeView"><?= $is_knowledge ? 'ON' : 'OFF' ?></div>
  </div>

  <div class="rule"></div>

  <div class="section-title">Message（学習過程）</div>
  <div class="box" id="messageView"><?= h((string)($log['message'] ?? '')) ?></div>

  <div class="rule"></div>

  <div class="section-title">Solution（解決・ナレッジ）</div>
  <div class="box" id="solutionView"><?= $solution === '' ? '（未記入）' : h($solution) ?></div>

  <p class="muted">※ 解決状態は is_resolved で管理します（solutionの有無では判定しない）</p>
</div>

<!-- EDIT MODE -->
<form
  id="editMode"
  action="./detail.php"
  method="post"
  <?= $isEdit ? '' : ' class="hidden"' ?>
>
  <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
  <input type="hidden" name="id" value="<?= (int)($log['id'] ?? 0) ?>">

  <div class="section-title">Edit</div>

  <div class="row">
    <div class="label">Title</div>
    <input id="titleInput" name="title" type="text" required value="<?= h((string)($log['title'] ?? '')) ?>">
  </div>

  <div class="row">
    <div class="label">Status</div>
    <label class="toggle">
      <input id="resolvedToggle" name="is_resolved" type="checkbox" <?= $is_resolved ? 'checked' : '' ?>>
      <span>Resolved</span>
    </label>
    <span class="muted">（ON=解決済み / OFF=未解決）</span>
  </div>

  <div class="row">
    <div class="label">Knowledge</div>
    <label class="toggle">
      <input id="knowledgeToggle" name="is_knowledge" type="checkbox" <?= $is_knowledge ? 'checked' : '' ?>>
      <span>ON</span>
    </label>
  </div>

  <div class="rule"></div>

  <div class="section-title">Message</div>
  <textarea id="messageTextarea" name="message" required><?= h((string)($log['message'] ?? '')) ?></textarea>

  <div class="rule"></div>

  <div class="section-title">Solution</div>
  <textarea
    id="solutionTextarea"
    name="solution"
    placeholder="【原因】　【解決】　【学び】"
  ><?= h((string)($log['solution'] ?? '')) ?></textarea>

  <p class="muted">※ solution は本文。解決状態は is_resolved を切り替える。</p>
</form>

<?php require __DIR__ . '/../src/components/footer.php'; ?>
