<?php
declare(strict_types=1);

/**
 * src/views/index.php
 *
 * 期待する変数（renderから渡される想定）
 * - $logs        : array
 * - $errors      : array|null
 * - $old         : array|null（POST失敗時のNew Logフォーム復元）
 * - $cond        : array|null（GET検索フォーム復元）
 * - $page        : int|null
 * - $total_pages : int|null
 */

$page_title = 'Logs';
$body_class = 'page-index';
$page_css   = 'index.css';
$page_js    = null;

$logs        = $logs ?? [];
$errors      = $errors ?? [];
$old         = $old ?? [];
$cond        = $cond ?? ['language' => '', 'level' => '', 'status' => ''];
$page        = (int)($page ?? 1);
$total_pages = (int)($total_pages ?? 1);

require __DIR__ . '/../src/components/header.php';
require __DIR__ . '/../src/components/messages.php';

// select候補（バリデと合わせてここは固定）
$langs  = ['PHP', 'Java', 'C++', 'JavaScript', 'Other'];
$levels = ['NOTE', 'QUESTION', 'IMPORTANT'];

$old_lang  = (string)($old['language'] ?? 'PHP');
$old_level = (string)($old['level'] ?? 'NOTE');

// ページャURL生成：condだけを使う（不要なGETが混ざらない）
$build_page_url = function(int $p) use ($cond): string {
    $q = [
        'language' => (string)($cond['language'] ?? ''),
        'level'    => (string)($cond['level'] ?? ''),
        'status'   => (string)($cond['status'] ?? ''),
        'page'     => (string)$p,
    ];
    return './index.php?' . http_build_query($q);
};
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

    <!-- Filters (GET search) -->
    <form class="filters" action="./index.php" method="get">
      <!-- 検索したら常に1ページ目に戻す -->
      <input type="hidden" name="page" value="1">

      <div class="filters-row">
        <label>
          Language
          <select name="language">
            <option value="" <?= (($cond['language'] ?? '') === '') ? 'selected' : '' ?>>All</option>
            <?php foreach ($langs as $v): ?>
              <option value="<?= h($v) ?>" <?= (($cond['language'] ?? '') === $v) ? 'selected' : '' ?>>
                <?= h($v) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>

        <label>
          Level
          <select name="level">
            <option value="" <?= (($cond['level'] ?? '') === '') ? 'selected' : '' ?>>All</option>
            <?php foreach ($levels as $v): ?>
              <option value="<?= h($v) ?>" <?= (($cond['level'] ?? '') === $v) ? 'selected' : '' ?>>
                <?= h($v) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>

        <label>
          Status
          <select name="status">
            <option value=""          <?= (($cond['status'] ?? '') === '') ? 'selected' : '' ?>>All</option>
            <option value="unresolved"<?= (($cond['status'] ?? '') === 'unresolved') ? 'selected' : '' ?>>未解決</option>
            <option value="resolved"  <?= (($cond['status'] ?? '') === 'resolved') ? 'selected' : '' ?>>解決済</option>
            <option value="knowledge" <?= (($cond['status'] ?? '') === 'knowledge') ? 'selected' : '' ?>>ナレッジ</option>
          </select>
        </label>

        <div style="display:flex; gap:10px; justify-content:flex-end; align-items:flex-end;">
          <a class="btn secondary" href="./index.php">Reset</a>
          <button class="btn" type="submit">Search</button>
        </div>
      </div>
    </form>

    <!-- Pager -->
    <div class="pager" style="display:flex; gap:12px; align-items:center; justify-content:flex-end; margin: 10px 0;">
      <?php if ($page > 1): ?>
        <a class="btn secondary" href="<?= h($build_page_url($page - 1)) ?>">Prev</a>
      <?php endif; ?>
      <span><?= h((string)$page) ?> / <?= h((string)$total_pages) ?></span>
      <?php if ($page < $total_pages): ?>
        <a class="btn secondary" href="<?= h($build_page_url($page + 1)) ?>">Next</a>
      <?php endif; ?>
    </div>

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
              <?php if ($is_knowledge): ?>
                <span class="badge knowledge">ナレッジ</span>
              <?php elseif (!$is_resolved): ?>
                <span class="badge unresolved">未解決</span>
              <?php else: ?>
                <span class="badge resolved">解決済</span>
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

    <!-- Pager (bottom) -->
    <div class="pager" style="display:flex; gap:12px; align-items:center; justify-content:flex-end; margin: 10px 0;">
      <?php if ($page > 1): ?>
        <a class="btn secondary" href="<?= h($build_page_url($page - 1)) ?>">Prev</a>
      <?php endif; ?>
      <span><?= h((string)$page) ?> / <?= h((string)$total_pages) ?></span>
      <?php if ($page < $total_pages): ?>
        <a class="btn secondary" href="<?= h($build_page_url($page + 1)) ?>">Next</a>
      <?php endif; ?>
    </div>
  </section>

<?php require __DIR__ . '/../src/components/footer.php'; ?>