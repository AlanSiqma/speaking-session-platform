# ADR-0001B — BFF as Domain Orchestrator and Strategy for Future Extraction

* **Status:** Accepted
* **Date:** 2026-02-06
* **Decision Makers:** Architecture Owner
* **Context:** Speaking Session Platform

---

# 1. Context

The platform contains a **single bounded context** centered on the
**Speaking Session lifecycle**:

* Session start
* Audio submission
* Transcription state tracking
* AI evaluation
* Feedback persistence
* Learning history

A design question emerged:

> Should a dedicated **Application Core service** be introduced now,
> or should orchestration remain inside the **BFF**?

The system currently:

* Has no external consumers
* Has a single domain context
* Must stay operationally simple

---

# 2. Decision

## 2.1 Domain orchestration will remain inside the BFF

The **BFF** will orchestrate the **Speaking Session lifecycle**, including:

* Session management
* State transitions
* Coordination with STT and LLM services
* Persistence of evaluations and history

No standalone **Application Core microservice** will be created at this stage.

---

## 2.2 Internal logical boundaries will be preserved

Even without a separate service, the BFF must maintain:

* Clear application‑layer modules
* Explicit domain services
* Isolation of orchestration logic from transport concerns

This enables **future extraction without refactoring chaos**.

---

# 3. Rationale

Creating an Application Core service now would introduce:

* Premature distribution complexity
* Additional deployment and operational overhead
* No immediate architectural benefit

Keeping orchestration in the BFF provides:

* Faster delivery
* Lower infrastructure cost
* Simpler debugging and observability

This follows the principle:

> **Design for extraction, not for today.**

---

# 4. Consequences

## Positive

* Minimal operational complexity
* Clear ownership of the Speaking Session lifecycle
* Evolutionary path toward service extraction

## Trade‑offs

* Future refactor required if domain complexity grows
* Risk of BFF becoming overloaded if boundaries are ignored

These risks are **accepted and monitored**.

---

# 5. Future Extraction Triggers

A dedicated Application Core service should be introduced if:

* Multiple bounded contexts emerge
* External consumers require domain APIs
* Session orchestration complexity increases significantly
* Independent scaling becomes necessary

---

# 6. Architectural Principles Reinforced

* Pragmatic simplicity over premature microservices
* Explicit domain lifecycle ownership
* Evolutionary architecture
* Cost‑aware engineering decisions

These characteristics align with **Staff‑level architectural thinking**.

---

**End of ADR‑0001B**
