# ADR-0001A — Asynchronous Speech-to-Text Processing

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

Speech‑to‑Text (STT) processing introduces:

* High and unpredictable latency
* External provider instability
* Non‑deterministic processing time
* Potential cost amplification under retries

The architecture must remain **simple for a single‑developer system** while still demonstrating **production‑grade resilience**.

---

# 2. Decision

## 2.1 STT processing will be asynchronous

Speech‑to‑Text operations will be executed through an **event‑driven asynchronous pipeline**:

* Audio submission → **STT Queue**
* Worker → **STT Processing Service**
* Completion event → **Result Delivery Service**
* User notification via **SSE or polling**

### Rationale

Asynchronous execution provides:

* Failure isolation
* Retry capability
* Back‑pressure handling
* Cost‑aware processing
* Non‑blocking user experience

Therefore, **STT must not run in synchronous request/response flows**.

---

# 3. Consequences

## Positive

* Improved user experience
* Operational resilience against STT provider instability
* Scalable audio processing model

## Trade‑offs

* Added infrastructure complexity (queue + worker)
* Eventual consistency between upload and transcription result

These trade‑offs are **accepted** given current product maturity.

---

# 4. Alternatives Considered

## Fully synchronous STT — Rejected

Rejected due to:

* Blocking latency
* Higher timeout probability
* Poor scalability

---

# 5. Next Steps

* Implement STT queue and worker pipeline
* Add observability for STT latency and success rate

---

**End of ADR‑0001A**
