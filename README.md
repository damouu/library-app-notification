# Library App Notification Service / 通知サービス

Distributed Library System — Notification Service

分散型図書館システム — 通知サービス

---

## Overview / 概要

The Notification Service is an asynchronous event-driven microservice responsible for delivering user-facing notifications across the distributed library platform.

It consumes domain events published by upstream services through Kafka and generates notification workflows without impacting transactional services.

The service currently processes user registration, borrowing, and return events, allowing business services to remain decoupled from notification concerns.

Unlike traditional Laravel web applications, this service operates as a background worker and Kafka consumer. It does not expose public REST APIs and runs on a lightweight PHP CLI runtime optimized for event processing.

---

Notification Service は分散型図書館システムにおける非同期通知サービスです。

Kafka を通じて配信されるドメインイベントを購読し、ユーザー向け通知処理を実行します。

本サービスはユーザー登録、貸出、返却イベントを処理し、通知機能を他サービスから分離することで疎結合なアーキテクチャを実現しています。

また、一般的な Laravel Web アプリケーションとは異なり、本サービスは REST API を提供せず、Kafka Consumer として PHP CLI 上で動作します。

---

## Service Boundaries / サービス境界

### Provides

* Notification event processing
* Kafka event consumption
* User registration notifications
* Borrow notifications
* Return notifications
* Notification workflow orchestration
* Asynchronous processing
* Event-driven integration

### Does Not Handle

* User authentication
* User account management
* Borrow transaction processing
* Inventory management
* Analytics aggregation
* Catalog management
* Search indexing

---

## Responsibilities / 責務

### English

* Consume domain events
* Process notification workflows
* Send registration notifications
* Send borrow notifications
* Send return notifications
* Maintain asynchronous communication
* Decouple notification concerns from business services

### 日本語

* ドメインイベント購読
* 通知処理実行
* ユーザー登録通知
* 貸出通知
* 返却通知
* 非同期通信管理
* 通知機能の疎結合化

---

## Technology Stack / 技術スタック

| Category         | Technology          |
| ---------------- | ------------------- |
| Runtime          | PHP 8.2             |
| Framework        | Laravel 12          |
| Messaging        | Kafka               |
| Kafka Client     | Laravel Kafka       |
| Persistence      | Stateless Consumer  |
| Serialization    | Spatie Laravel Data |
| Monitoring       | OpenTelemetry       |
| Containerization | Docker              |
| Runtime Type     | PHP CLI             |
| CI/CD            | GitHub Actions      |

---

## Event Processing / イベント処理

### Consumed Kafka Topics

| Topic             | Description              |
| ----------------- | ------------------------ |
| library.borrow.v1 | Borrow creation events   |
| library.return.v1 | Return completion events |
| auth-create-topic | User registration events |

---

### Borrow Notification Flow

Borrow Event

↓

Kafka Consumer

↓

BookBorrowedHandler

↓

Notification Generation

↓

Email Delivery

---

### Return Notification Flow

Return Event

↓

Kafka Consumer

↓

BookReturnedHandler

↓

Notification Generation

↓

Email Delivery

---

### User Registration Flow

User Created Event

↓

Kafka Consumer

↓

KafkaUserHandler

↓

Welcome Notification

↓

Email Delivery

---

## Runtime Architecture / 実行アーキテクチャ

Unlike a traditional Laravel application, this service does not expose HTTP endpoints.

It runs exclusively as Kafka consumers inside lightweight PHP CLI containers.

---

本サービスは HTTP API を提供しません。

軽量な PHP CLI コンテナ上で Kafka Consumer として動作します。

---

## API Endpoints / API エンドポイント

This service does not expose public REST APIs.

本サービスは REST API を公開していません。

---

## Local Development / ローカル開発

### Requirements

* PHP 8.2
* Composer
* Docker
* Kafka

---

### Run

```bash
docker compose up --build
```

---

## Testing / テスト

```bash
composer test
```

### Includes

* Unit tests
* Kafka consumer tests
* Handler tests
* Event processing tests
* Integration tests

---

### 日本語

含まれるテスト:

* ユニットテスト
* Kafka Consumer テスト
* Handler テスト
* イベント処理テスト
* 統合テスト

---

## Build Quality / 品質保証

The CI pipeline enforces:

* Automated test execution
* Consumer validation
* Event contract verification
* Pull request validation
* Docker image publication

---

### 日本語

CI パイプラインでは以下を保証します:

* 自動テスト実行
* Consumer 検証
* イベント契約検証
* Pull Request 検証
* Docker イメージ配布

---

## Configuration / 設定

```env
KAFKA_BROKERS=
KAFKA_CONSUMER_GROUP_ID=

OTEL_EXPORTER_OTLP_ENDPOINT=
```

Environment-driven configuration.

環境変数ベースで構成されています。

---

## Monitoring / モニタリング

OpenTelemetry tracing is enabled for event processing observability.

イベント処理の可観測性向上のため OpenTelemetry を利用しています。

---

## Architectural Role / アーキテクチャ上の役割

The Notification Service represents the asynchronous communication layer of the distributed library system.

It allows transactional services to remain focused on business logic while notification concerns are processed independently through Kafka-based event consumption.

---

Notification Service は分散型図書館システムの非同期通知レイヤーとして機能します。

トランザクションサービスはビジネスロジックに集中し、通知処理は Kafka を介して独立して実行されます。

---

## License / ライセンス

MIT
