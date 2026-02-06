# Speaking Session Platform

AI‑assisted speaking practice system designed with **production‑grade architecture** and **Staff‑level engineering principles**.

This project demonstrates how to build, evolve, and govern a real SaaS‑ready learning platform using:

* Evolutionary architecture
* Clear domain ownership
* Asynchronous processing where it matters
* Safe integration with external AI systems
* Observability as a first‑class concern

---

# ✨ Product Vision

The **Speaking Session Platform** enables structured speaking practice through:

1. Guided speaking sessions
2. Audio recording and transcription
3. AI‑driven evaluation and feedback
4. Persistent learning history and progress tracking

The goal is not only to deliver functionality, but to **model real‑world product architecture** suitable for long‑term SaaS evolution.

---

# 🏗️ Architecture Overview

The system architecture is defined by a **C4 Container model**, which serves as the
**architectural source of truth** for the platform.

Key architectural characteristics:

* **BFF as domain orchestrator** for the Speaking Session lifecycle
* **Asynchronous Speech‑to‑Text pipeline** for resilience and scalability
* **LLM integration isolated via Anti‑Corruption Layer (ACL)**
* **Separation of transactional data and long‑term context storage**
* **Observability embedded from day one** (logs, metrics, traces, business signals)

Detailed decisions are documented in:

* [`ADR‑0001`](docs/architecture/adr/ADR-0001-overview.md) — Architectural foundation
* `ADR‑0001A` — Asynchronous STT processing
* `ADR‑0001B` — BFF domain orchestration strategy
* `ADR‑0001C` — LLM integration boundary via ACL

---

# 🧠 Architectural Principles

This repository follows **Staff‑level architectural governance**:

* **Evolutionary architecture over premature microservices**
* **Asynchrony only where latency and failure justify it**
* **Explicit domain lifecycle ownership**
* **Isolation of external AI dependencies**
* **Operational observability from the beginning**

These principles ensure the system is:

* Simple today
* Extractable tomorrow
* Scalable when required

---

# 📦 Repository Structure

```
/docs
  /architecture
    /c4
    /adr

/src
```

* **docs/architecture/c4** → Container diagrams and visual models
* **docs/architecture/adr** → Architectural Decision Records
* **src** → Application source code

---

# 🚀 Engineering Goals

This project is intentionally designed to demonstrate:

* Real **system design thinking**
* Pragmatic **cloud‑ready architecture**
* Safe **AI integration patterns**
* End‑to‑end **operability in production**

It serves as a **reference implementation of modern SaaS architecture** rather than a simple demo application.

---

# 📈 Roadmap

Planned evolution includes:

* Complete STT async pipeline implementation
* Full observability stack and dashboards
* Deployment via CI/CD and Infrastructure as Code
* Progressive domain extraction as complexity grows

All changes will remain **traceable through ADRs** and aligned with the **C4 architectural foundation**.

---

# 📄 License

This project is intended for **educational and architectural reference purposes**.

---

**Author:** Alan Maia
**Focus:** Staff‑level Software Architecture, Cloud, Distributed Systems, and AI‑enabled products.
