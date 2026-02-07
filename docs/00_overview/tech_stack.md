# 技術選定（Tech Stack）

Status: Draft  
Last Updated: 2026-02-08

---

# 技術選定（MVP）

## フロントエンド

- **HTML / CSS**
- **JavaScript**

理由：

- 学習ログのCRUDが中心
- 複雑なSPAは不要
- 学校環境でも確実に動く

---

## バックエンド

- **PHP : 7.4.1**
- **Apache : Apache/2.4.6 (Red Hat Enterprise Linux)**

理由：

- 学校Webサーバの実行環境

---

## データベース

- **MySQL : 8.0.18 for Linux on x86_64**

理由：

- 学校・Docker両方で使用可能
- 時系列データ（学習ログ）と相性が良い
- インデックス設計の学習にもなる

---

## 開発環境

- **自宅**：Windows + Docker Desktop
    - PHP / MySQL をコンテナで再現
- **学校**：Linux Webサーバ
    - PHP / MySQL（Dockerなし）
- **Git**：ローカルPCで管理（正史）

---

## ディレクトリ構成

- `public/`：公開領域（DocumentRoot）
- `src/`：ビジネスロジック（非公開）

---

## 非採用（MVPでは使わない）

- フレームワーク（Laravel 等）
- フロントエンドFW（React/Vue）
- ORM
- 外部検索エンジン

理由：

- 学習目的では **素の構成の方が理解が深い**
- 学校環境との相性を優先