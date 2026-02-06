# ADR-0001C — LLM Integration Boundary via Anti‑Corruption Layer (ACL)

* **Status:** Accepted
* **Date:** 2026-02-06
* **Decision Makers:** Architecture Owner
* **Context:** Speaking Session Platform

---

# 1. Context

The *Speaking Session Platform* relies on an external **Large Language Model (LLM)** to:

* Evaluate speaking responses
* Generate structured feedback
* Provide improved reference answers

Direct coupling between the domain and an LLM provider would introduce:

* Vendor lock‑in
* Prompt scattering across the codebase
* Lack of cost and usage governance
* Difficulty testing domain behavior independently of AI services

Therefore, an architectural boundary is required between the
**core domain** and **LLM providers**.

---

# 2. Decision

## 2.1 Introduce an Anti‑Corruption Layer (ACL) for LLM integration

All communication with external LLM providers will occur through a
**dedicated ACL component** responsible for:

* Translating domain requests into prompt structures
* Normalizing provider responses into domain‑safe models
* Isolating provider‑specific SDKs and APIs
* Enabling provider substitution without domain impact

The domain and BFF must **never call an LLM provider directly**.

---

## 2.2 Keep LLM evaluation synchronous at the current stage

LLM evaluation will remain **synchronous** while:

* Response latency is acceptable for user experience
* Evaluation complexity remains single‑stage
* Cost control does not require batching or background processing

This preserves **system simplicity** while still enabling future evolution.

---

# 3. Rationale

Using an ACL provides:

* Clear separation between **AI infrastructure** and **business domain**
* Centralized prompt governance and versioning
* Easier experimentation with different models or providers
* Testability through mocked or simulated AI responses

This pattern aligns with modern **AI‑enabled production architectures**.

---

# 4. Consequences

## Positive

* Reduced vendor lock‑in risk
* Controlled prompt evolution
* Improved observability of AI cost and latency
* Safer long‑term architectural evolution

## Trade‑offs

* Additional abstraction layer to maintain
* Slight increase in implementation complexity

These trade‑offs are **accepted** due to long‑term strategic value.

---

# 5. Alternatives Considered

## Direct LLM calls from BFF — Rejected

Rejected because it would:

* Spread prompt logic across layers
* Increase vendor coupling
* Reduce testability

---

## Fully asynchronous AI evaluation — Deferred

Deferred until:

* Multi‑stage evaluation pipelines emerge
* Cost batching or heavy processing is required

At present, synchronous evaluation remains the **simplest correct design**.

---

# 6. Architectural Principles Reinforced

* Explicit boundaries around external AI systems
* Evolutionary architecture prepared for provider change
* Governance of prompts, cost, and latency
* Pragmatic simplicity over premature complexity

These characteristics are consistent with **Staff‑level architectural thinking**.

---

**End of ADR‑0001C**
    