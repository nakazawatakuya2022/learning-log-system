# DB設計

## この配下の正
- テーブル設計：Excel（logs_table.xlsx）
- データ辞書：data_dictionary.md
- ER図：er_diagram.drawio（正） / er_diagram.png（参照）

## ファイル一覧
- logs_table.xlsx：テーブル設計書（正）
- data_dictionary.md：データ辞書
- table_design.md：補足ルール（保存方針・並び順など）
- er_diagram.drawio / er_diagram.png：ER図

## 設計ステータス

- logs テーブル：確定
- インデックス設計：確定（MVP）
- 並び順仕様：確定（sort_priority）
- 本ドキュメント以降の変更は「実装フェーズでの差分」として扱う

※ 本DDLを変更する場合は、必ず Git 管理下で差分を残すこと