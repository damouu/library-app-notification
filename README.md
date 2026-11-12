# Library App Notification Service

Distributed Library System — Notification Service

---

## Overview

The Notification Service is an asynchronous event-driven microservice responsible for delivering user-facing notifications across the distributed library platform.

It consumes domain events published by upstream services through Kafka and generates notification workflows without impacting transactional services.

The service currently processes user registration, borrowing, and return events, allowing business services to remain decoupled from notification concerns.

Unlike traditional Laravel web applications, this service operates as a background worker and Kafka consumer. It does not expose public REST APIs and runs on a lightweight PHP CLI runtime optimized for event processing.

---

## Service Boundaries

### Provides

- Notification event processing
- Kafka event consumption
- User registration notifications
- Borrow notifications
- Return notifications
- Notification workflow orchestration
- Asynchronous processing
- Event-driven integration

### Does Not Handle

- User authentication
- User account management
- Borrow transaction processing
- Inventory management
- Analytics aggregation
- Catalog management
- Search indexing

---

## Responsibilities

- Consume domain events
- Process notification workflows
- Send registration notifications
- Send borrow notifications
- Send return notifications
- Maintain asynchronous communication
- Decouple notification concerns from business services

---

## Technology Stack

| Category         | Technology          |
|------------------|---------------------|
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

## Event Processing

### Consumed Kafka Topics

| Topic             | Description              |
|-------------------|--------------------------|
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

## Runtime Architecture

Unlike a traditional Laravel application, this service does not expose HTTP endpoints.

It runs exclusively as Kafka consumers inside lightweight PHP CLI containers.

---

## API Endpoints

This service does not expose public REST APIs.

---

## Build Quality

The CI pipeline enforces:

- Automated test execution
- Consumer validation
- Event contract verification
- Pull request validation
- Docker image publication

---

## Configuration

```env
KAFKA_BROKERS=
KAFKA_CONSUMER_GROUP_ID=

OTEL_EXPORTER_OTLP_ENDPOINT=
```

Environment-driven configuration.

---

## Monitoring

OpenTelemetry tracing is enabled for event processing observability.

---

## Architectural Role

The Notification Service represents the asynchronous communication layer of the distributed library system.

It allows transactional services to remain focused on business logic while notification concerns are processed independently through Kafka-based event consumption.

---

## License

MIT
