<?php
declare(strict_types=1);

/**
 * 期待する変数（renderから渡される想定）
 * - $logs   : array
 * - $errors : array|null
 * - $old    : array|null（POST失敗時のフォーム復元）
 */
$page_title = 'Logs';
$body_class = 'page-index';
$page_css   = 'index.css';
$page_js    = null;

$logs = $logs ?? [];
$errors = $errors ?? [];
$old = $old ?? [];

require __DIR__ . '/../src/components/header.php';
require __DIR__ . '/../src/components/messages.php';

// select候補（バリデと合わせてここは固定）
$langs  = ['PHP', 'Java', 'C++', 'JavaScript', 'Other'];
$levels = ['NOTE', 'QUESTION', 'IMPORTANT'];

$old_lang  = (string)($old['language'] ?? 'PHP');
$old_level = (string)($old['level'] ?? 'NOTE');
?>
  <div class="rule"></div>
  <h1>Logs</h1>
  <div class="rule"></div>

  <!-- New Log -->
  <section class="section">
    <h2>[ New Log ]</h2>

    <form class="form" action="./index.php" method="post">
      <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">

      <label>
        Date <span class="req">* required</span>
        <input
          type="date"
          name="occurred_at"
          required
          value="<?= h((string)($old['occurred_at'] ?? date('Y-m-d'))) ?>"
        />
      </label>

      <label>
        Language <span class="req">* required</span>
        <select name="language" required>
          <?php foreach ($langs as $v): ?>
            <option value="<?= h($v) ?>" <?= $old_lang === $v ? 'selected' : '' ?>>
              <?= h($v) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>

      <label>
        Level <span class="req">* required</span>
        <select name="level" required>
          <?php foreach ($levels as $v): ?>
            <option value="<?= h($v) ?>" <?= $old_level === $v ? 'selected' : '' ?>>
              <?= h($v) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>

      <label>
        Title <span class="req">* required</span>
        <input
          type="text"
          name="title"
          placeholder="例：PDO接続エラー"
          required
          value="<?= h((string)($old['title'] ?? '')) ?>"
        />
      </label>

      <label>
        Message <span class="req">* required</span>
        <textarea
          name="message"
          placeholder="問題 / エラー / 試したこと"
          required
        ><?= h((string)($old['message'] ?? '')) ?></textarea>
      </label>

      <!-- 仕様に合わせて残す（不要ならこのlabelごと削除OK） -->
      <label>
        Solution <span class="req">optional</span>
        <textarea
          name="solution"
          placeholder="【原因】 【解決】 【学び】"
        ><?= h((string)($old['solution'] ?? '')) ?></textarea>
      </label>

      <div class="check">
        <label>
          <input type="checkbox" name="is_resolved" <?= !empty($old['is_resolved']) ? 'checked' : '' ?>>
          解決済
        </label>
        <label>
          <input type="checkbox" name="is_knowledge" <?= !empty($old['is_knowledge']) ? 'checked' : '' ?>>
          ナレッジ
        </label>
      </div>

      <button class="btn" type="submit">Save</button>
    </form>
  </section>

  <div class="rule"></div>

  <!-- Logs List -->
  <section class="section">
    <h2>[ Logs List ]</h2>

    <!-- Filters (UI only / 後でGET検索実装) -->
    <form class="filters" action="./index.php" method="get">
      <div class="filters-row">
        <label>
          From
          <input type="date" name="from" value="<?= h((string)($_GET['from'] ?? '')) ?>">
        </label>

        <label>
          To
          <input type="date" name="to" value="<?= h((string)($_GET['to'] ?? '')) ?>">
        </label>

        <label>
          Language
          <?php $glang = (string)($_GET['language'] ?? ''); ?>
          <select name="language">
            <option value="" <?= $glang === '' ? 'selected' : '' ?>>All</option>
            <?php foreach ($langs as $v): ?>
              <option value="<?= h($v) ?>" <?= $glang === $v ? 'selected' : '' ?>>
                <?= h($v) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>

        <label>
          Level
          <?php $glevel = (string)($_GET['level'] ?? ''); ?>
          <select name="level">
            <option value="" <?= $glevel === '' ? 'selected' : '' ?>>All</option>
            <?php foreach ($levels as $v): ?>
              <option value="<?= h($v) ?>" <?= $glevel === $v ? 'selected' : '' ?>>
                <?= h($v) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>
      </div>

      <div class="filters-row small">
        <div class="check">
          <label><input type="checkbox" name="unresolved" <?= isset($_GET['unresolved']) ? 'checked' : '' ?>> 未解決</label>
          <label><input type="checkbox" name="resolved" <?= isset($_GET['resolved']) ? 'checked' : '' ?>> 解決済</label>
          <label><input type="checkbox" name="knowledge" <?= isset($_GET['knowledge']) ? 'checked' : '' ?>> ナレッジ</label>
        </div>

        <div style="display:flex; gap:10px; justify-content:flex-end">
          <button class="btn secondary" type="reset">Reset</button>
          <button class="btn" type="submit">Search</button>
        </div>
      </div>
    </form>

    <!-- List header -->
    <div class="row head">
      <div>Date</div>
      <div>Language</div>
      <div>Level</div>
      <div>Status</div>
      <div>Title</div>
    </div>

    <div class="list">
      <?php if (empty($logs)): ?>
        <p>No logs.</p>
      <?php else: ?>
        <?php foreach ($logs as $row): ?>
          <?php
            $is_resolved  = (int)($row['is_resolved'] ?? 0) === 1;
            $is_knowledge = (int)($row['is_knowledge'] ?? 0) === 1;
          ?>
          <div class="row">
            <div class="meta"><?= h((string)($row['occurred_at'] ?? '')) ?></div>
            <div class="meta"><?= h((string)($row['language'] ?? '')) ?></div>
            <div class="meta"><?= h((string)($row['level'] ?? '')) ?></div>

            <div class="badges">
              <?php if (!$is_resolved): ?>
                <span class="badge unresolved">未解決</span>
              <?php else: ?>
                <span class="badge resolved">解決済</span>
              <?php endif; ?>
              <?php if ($is_knowledge): ?>
                <span class="badge knowledge">ナレッジ</span>
              <?php endif; ?>
            </div>

            <div class="title">
              <a href="./detail.php?id=<?= (int)($row['id'] ?? 0) ?>">
                <?= h((string)($row['title'] ?? '')) ?>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

<?php require __DIR__ . '/../src/components/footer.php'; ?>
