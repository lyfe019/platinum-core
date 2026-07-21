# Platinum Core

> A modular monolith application framework that runs inside WordPress.

---

## Vision

Platinum Core is a lightweight application framework designed to transform WordPress into a hosting runtime for enterprise-grade modular monolith applications.

Rather than building business logic directly inside WordPress themes and plugins, Platinum Core provides its own application runtime while allowing WordPress to continue handling content management, authentication, media, and plugin integration.

WordPress becomes the host.

Platinum Core becomes the application runtime.

Applications are composed of independent bounded contexts that encapsulate business capabilities without depending directly on one another.

---

## Philosophy

The framework itself contains **no business logic**.

It knows nothing about:

- Engineering
- Financial
- Proposal
- Customer
- Sales
- Operations

These belong to applications built on the framework—not to the framework itself.

---

## Architecture

```
WordPress
        │
        ▼
Platinum Core Framework
        │
        ▼
Application Runtime
        │
        ▼
Bounded Context Loader
        │
        ▼
Business Application
```

---

## Core Capabilities

The framework will provide:

- Boot lifecycle
- Application lifecycle
- Configuration management
- Dependency Injection Container
- Event Bus
- HTTP Routing
- Middleware Pipeline
- Identity abstraction
- Persistence abstraction
- View rendering
- Scheduling
- Logging
- Testing infrastructure

---

## Project Status

Current Phase:

**Phase 0 — Repository Foundation**

---

## License

To be determined.