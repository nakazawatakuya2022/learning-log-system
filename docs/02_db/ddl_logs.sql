CREATE TABLE logs (
  id BIGINT NOT NULL AUTO_INCREMENT COMMENT '学習ログID',

  occurred_at DATE NOT NULL COMMENT '学習日',
  language VARCHAR(50) NULL COMMENT '言語（PHP / Java / SQL など）',

  level VARCHAR(20) NOT NULL DEFAULT 'NOTE'
    COMMENT '分類（NOTE / QUESTION / IMPORTANT）',

  title VARCHAR(255) NOT NULL COMMENT 'タイトル（学習内容の要約）',
  message TEXT NOT NULL COMMENT '学習過程・問題点',
  solution TEXT NULL COMMENT '解決内容（未解決時はNULL）',

  is_resolved TINYINT NOT NULL DEFAULT 0
    COMMENT '解決済みフラグ（0:未解決 / 1:解決）',
  is_knowledge TINYINT NOT NULL DEFAULT 0
    COMMENT 'ナレッジ化フラグ（再利用価値あり）',

  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    COMMENT '作成日時',
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
    COMMENT '更新日時',

  sort_priority TINYINT AS (
    CASE
      WHEN is_resolved = 0 THEN 0
      WHEN is_knowledge = 1 THEN 2
      ELSE 1
    END
  ) STORED COMMENT '表示優先度（未解決→解決→ナレッジ）',

  PRIMARY KEY (id),

  INDEX idx_logs_priority_occurred_updated
    (sort_priority, occurred_at, updated_at),
  INDEX idx_logs_resolved_occurred
    (is_resolved, occurred_at),
  INDEX idx_logs_language_occurred
    (language, occurred_at),
  INDEX idx_logs_level_occurred
    (level, occurred_at)
) COMMENT='学習ログ管理テーブル';
