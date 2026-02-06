# ADR-0001 — Asynchronous Speech‑to‑Text Processing and BFF Domain Orchestration

* **Status:** Accepted
* **Date:** 2026-02-06
* **Decision Makers:** Architecture Owner
* **Context:** Speaking Session Platform

---

# 1. Context

The *Speaking Session Platform* is an AI‑assisted speaking practice system where users:

1. Start a speaking session
2. Record audio responses
3. Receive transcription
4. Obtain AI‑driven evaluation and feedback
5. Persist session history and learning progress

The architecture must:

* Remain **simple enough for a single‑developer system**
* Demonstrate **production‑grade engineering practices**
* Support **future evolution to SaaS scale**
* Avoid **premature microservice decomposition**

Two critical architectural concerns emerged:

1. **Speech‑to‑Text (STT) latency, reliability, and cost variability**
2. **Domain orchestration responsibility between BFF and a potential Application Core service**

---

# 2. Decision

## 2.1 STT processing will be asynchronous

Speech‑to‑Text operations will be executed through an **event‑driven asynchronous pipeline** composed of:

* Audio submission → **STT Queue**
* Worker → **STT Processing Service**
* Completion event → **Result Delivery Service**
* User notification via **SSE / polling**

### Rationale

STT workloads exhibit:

* High and unpredictable latency
* External provider instability
* Non‑deterministic processing time
* Potential cost amplification under retries

Asynchronous execution provides:

* Failure isolation
* Retry capability
* Back‑pressure handling
* Cost‑aware processing
* Improved user experience through non‑blocking UI

Therefore, **STT must not run in synchronous request/response flows**.

---

## 2.2 LLM evaluation will remain synchronous (for now)

AI evaluation through the **LLM ACL boundary** will initially remain **synchronous**.

### Rationale

* Evaluation latency is typically **shorter than STT latency**
* User experience benefits from **immediate feedback after transcription**
* System complexity is reduced by avoiding unnecessary async orchestration

### Future evolution trigger

LLM evaluation may become asynchronous if:

* Multi‑stage scoring pipelines are introduced
* Heavy rubric analysis or embeddings are required
* Cost‑based batching becomes necessary

Until then, **synchronous evaluation is the simplest correct solution**.

---

## 2.3 Domain orchestration will remain inside the BFF

The **BFF (Backend‑for‑Frontend)** will orchestrate the **Speaking Session lifecycle**:

* Session start
* Audio submission
* Transcription state tracking
* Evaluation request
* Feedback persistence
* Session history management

No separate **Application Core service** will be created at this stage.

### Rationale

* The system currently has **a single bounded context**
* There is **no third‑party consumption requirement**
* Extracting a domain service now would introduce **premature complexity**
* The BFF can safely host orchestration **while maintaining internal logical boundaries**

This follows the principle:

> **Design for extraction, not for today.**

Internal modularization inside the BFF preserves future evolution without immediate operational cost.

---

# 3. Consequences

## 3.1 Positive

* Non‑blocking user experience for audio processing
* Operational resilience against STT provider instability
* Clear domain ownership through the Speaking Session lifecycle
* Minimal architectural complexity for early‑stage product
* Strong alignment with **pragmatic Staff‑level design principles**

## 3.2 Negative / Trade‑offs

* Increased infrastructure complexity due to queues and workers
* Eventual consistency between transcription and evaluation
* Future refactor required if domain complexity grows significantly

These trade‑offs are **accepted** given current product maturity.

---

# 4. Alternatives Considered

## 4.1 Fully synchronous STT

**Rejected** because:

* High latency would block user interaction
* Increased timeout and failure probability
* Poor scalability characteristics

---

## 4.2 Immediate Application Core microservice

**Rejected** because:

* No current multi‑domain complexity
* No external consumers
* Operational overhead without clear benefit

Planned instead: **logical separation inside the BFF** with future extraction capability.

---

## 4.3 Fully asynchronous LLM pipeline

**Rejected (for now)** because:

* Adds orchestration complexity
* Provides limited user‑visible benefit at current scale

May be revisited when **AI processing becomes multi‑stage or cost‑sensitive**.

---

# 5. Architectural Principles Reinforced

This decision aligns the platform with the following principles:

* **Pragmatic simplicity over premature distribution**
* **Asynchrony only where latency and failure demand it**
* **Explicit domain lifecycle ownership**
* **Evolutionary architecture prepared for future extraction**
* **Cost‑aware AI system design**

These are core characteristics of **Staff‑level engineering decisions**.

---

# 6. Next Steps

* Implement STT queue + worker pipeline
* Introduce Speaking Session persistence model
* Add observability for:

  * STT latency
  * transcription success rate
  * AI evaluation cost per session
* Reassess need for Application Core after domain expansion

---

**End of ADR‑0001**
