# 設計ドキュメント

このリポジトリの設計ドキュメントは docs/ 配下で管理する（設計の正）。

## 図と表
- テーブル設計・データ辞書：Excel（docs/ 配下に配置）
- ER図：diagrams.net（.drawio を正、PNGは参照用）
- シーケンス図・画面遷移図：Mermaid（Markdown内を正）
- Notion：裏ログ（思考・作業メモ）

## ディレクトリ方針
- docs/00_overview/：要件・前提（上流）
- docs/01_ui/：画面仕様（項目定義・バリデーション等）
- docs/02_db/：DB設計（Excel/ER図）
- docs/03_api_flow/：URL/HTTP、ユースケース→SQL、シーケンス（Mermaid）
- docs/04_program/：プログラム設計・ファイル構成
- docs/05_test/：テスト仕様
- docs/backup/：DBダンプ置き場（Git管理しない）

# 設計書一覧（Learning Log System）

---

## 00_overview

- システム概要
- 目的
- 技術構成

---

## 01_ui

- 画面構成
- ワイヤーフレーム
- 画面遷移図

---

## 02_db

- テーブル設計書
- データ辞書
- DDL
- インデックス設計

---

## 03_api_flow

- ルーティング定義
- I/F定義
- 処理フロー

---

## 04_program

### バリデーション仕様
- validation_spec.md

### View/Edit状態仕様
- view_edit_state_spec.md

### メッセージ一覧
- message_list.md

### シーケンス図
- sequence/sequence_uc05_create.md
- sequence/sequence_uc02_search.md
- sequence/sequence_uc06_detail.md
- sequence/sequence_uc08_update.md

---

## 05_test

- テスト観点
- テストケース
- 確認ログ

---

## 補足

- 本システムは PRG（Post-Redirect-Get）を採用
- 1ページ10件固定
- 並び順：
  sort_priority ASC,
  occurred_at DESC,
  updated_at DESC