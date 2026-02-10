# ER図（MVP）

```mermaid
erDiagram
  logs {
    BIGINT id PK
    DATE occurred_at
    VARCHAR language "NULL可"
    VARCHAR level "DEFAULT NOTE"
    VARCHAR title
    TEXT message
    TEXT solution "NULL可"
    TINYINT is_resolved "0/1"
    TINYINT is_knowledge "0/1"
    DATETIME created_at
    DATETIME updated_at
    TINYINT sort_priority "GENERATED STORED"
  }
