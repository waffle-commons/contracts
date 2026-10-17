# Changelog — waffle-commons/contracts

All notable changes to this component are documented in this file.
The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and the project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).
Released in lockstep with the Waffle Commons umbrella tag.

## [Unreleased]

### Added
- `Core\KernelInterface::$container` — a readable `public ContainerInterface $container { get; }`, so a test bridge (`waffle-commons/testing`, TEST-01) can swap in test doubles between `boot()` and `configure()` without importing the kernel's concrete classes (CARRY-04). **BC for direct implementers:** a class that implements `KernelInterface` itself must now expose a public readable `$container`; `waffle`'s `AbstractKernel` already does, so kernels that extend it are unaffected.
- `psr/clock` (PSR-20) joins the requirements, so the whole ecosystem shares one clock contract; new beta7 code takes the clock by injection (CARRY-04).
- `Attribute\ListOf` — declares the element type of a list-typed DTO member: `#[ListOf(OrderLine::class)]` for a `#[Dto]` class or a backed enum, `#[ListOf('string')]` for a scalar. PHP has no generics, so the build-time DTO-shape reader in `waffle-commons/utils` reads it, and the serializer and the OpenAPI generator agree on what a list holds (API-01/API-02, RFC-016).
- **`Queue\` — background processing contracts (QUEUE-01, RFC-015):**
  - `MessageInterface` — a job: a strictly typed DTO that crosses the queue as JSON and is rebuilt through its constructor; delivery is at least once.
  - `Envelope` — the message plus what delivery needs: a stable id (handlers de-duplicate on it), the queue, `availableAt`, the failed `attempts`, the W3C trace context of the dispatcher, and the transport's receipt of the current delivery. Immutable from outside (`private(set)`, validating hooks); `withReceipt()` and `withNextAttempt()` return copies.
  - `QueueDispatcherInterface::dispatch()`, with an optional queue and `availableAt` for delayed work.
  - `QueueConsumerInterface` — `receive()` with a bounded wait, then `acknowledge()` or `release()`; an unsettled delivery is reclaimed, never lost.
  - `FailedMessageStoreInterface` and `FailedMessage` — the dead-letter store: the full envelope, the failure reason and the instant. The envelope is kept as it would be delivered again, so its attempts count every failed delivery, the last one included.
  - `Exception\QueueExceptionInterface` — transport failures.
- `Queue\MessageHandlerInterface` (QUEUE-02) — a worker's handler: `handles()` names the message class, `handle()`
  receives the message and its envelope; throwing fails the delivery. The handled classes double as the only
  classes a consumer rebuilds from a queue.
- **`Serializer\` — the serializer seam (API-02):** `DtoSerializerInterface` (`supports`, `denormalize`,
  `deserialize`, `serialize`) lets the controller argument resolver, the response converter and a queue driver
  use the serializer without importing it; `Exception\SerializerExceptionInterface` marks its failures (the
  exception code is the HTTP status).
- **`Mailer\` — the mailer contract (QUEUE-03):** `MailerInterface::send()`, the `Email` DTO and `Exception\MailerExceptionInterface`. `Email` is a `#[Dto]` and a queue message, so transactional mail is dispatched to a worker. Its hooks validate every address and keep CR/LF out of the subject (no header injection). SMTP and API transports stay post-v1.
- **`Health\` — health and readiness probes (OPS-01, RFC-023):** `HealthCheckInterface` (`name()`, `isCritical()`, `check()`), the binary `HealthResult` (`up()`, `down()`, a detail for the private report only) and `Enum\HealthStatus`. A probe never throws and does not time itself: the probe middleware measures every check and exports the durations to `/waffle-metrics` (RFC-023 §5).
- **`RateLimit\` — rate limiting (NET-01, RFC-017 §3.1):** `RateLimiterInterface::consume()` (a configured limiter; a storage outage never surfaces as an exception, the limiter applies its `on_storage_failure` mode), `LimiterStateStorageInterface` (an atomic refill-and-take on a shared token bucket, so concurrent workers never over-admit — a PSR-16 cache cannot do that), the `TokenBucket` and `RateLimitDecision` DTOs (the `RateLimit-*` and `Retry-After` values, validated by hooks) and `Exception\StateStorageExceptionInterface`.
- `Http\ClientIpResolverInterface` (NET-01) — the client address behind trusted proxies: the right-most `X-Forwarded-For` hop that is not an allow-listed proxy, so a client cannot choose its own rate-limit key.

### Fixed
- `psr/http-factory` ^1.1 is now a declared requirement. `Http\ServerRequestFactoryInterface` and `Handler\ResponseFactoryAwareInterface` use the PSR-17 interfaces, which were only installed through a development tool, so an install without development dependencies loaded interfaces whose parents were missing.

## [0.1.0-beta6] — 2026-09

**Theme: stabilisation — object-level ABAC seam.**

### Added
- `Security\SubjectResolverInterface` — resolves the domain subject a route parameter identifies, so voters can express object-level (anti-IDOR) rules. Resolution is lazy, voter-gated and fail-closed at the consumer (SEC-05).

### Fixed
- `#[PublicAccess]` is restricted to `Attribute::TARGET_METHOD`. Class-level placement silently exempted every method of a controller, including ones added later (Beta6 audit SEC-05).

### Changed
- **Worker-safety audit coverage.** This component was never audited by `wfl igor`: it had no `igor-php/igor-php` in `require-dev`, so the ecosystem runner silently skipped it for four releases. It now ships `igor.json`, the `composer igor` script, and the dev dependency, and is part of the 0-KO gate.

### Documentation
- The README now links into the central Diátaxis documentation tree (DOC-02).

## [0.1.0-beta5] — 2026-07-08

**Theme: Beta5 contract surface — telemetry, async & context-aware authorization.**

### Added
- **Telemetry / observability (OBS-01 · RFC-005)** — contract-first tracing surface, SDK-free: `Telemetry\TracerInterface` (start/activate a span, expose the active context), `Telemetry\SpanInterface`, `Telemetry\SpanContextInterface` (immutable W3C Trace Context — `traceId` / `spanId` / `traceFlags` / `traceState` / `toTraceparent`), `Telemetry\TextMapPropagatorInterface` (inject/extract across a header carrier), plus the `Telemetry\Enum\{SpanKind, SpanStatus}` enums. Ships zero-overhead no-op defaults so the core depends only on the contract: `Telemetry\{NullTracer, NullSpan, NullSpanContext, NullTextMapPropagator}`. The real OpenTelemetry binding lives in `waffle-commons/telemetry-otel` — the SDK never enters the contracts perimeter.
- **Metrics ports (OBS-01 · RFC-005)** — `Telemetry\Metrics\MetricsRegistryInterface` (`increment` / `observe` / `gauge`, worker-state-out-of-heap mandate), `Telemetry\Metrics\MetricsCollectorInterface` (stateless scrape-time sampling), `Telemetry\Metrics\PoolStatsInterface` (live connection-pool utilisation for `/waffle-metrics`), the `Telemetry\Metrics\MetricSample` value object and `Telemetry\Metrics\Enum\MetricType` enum (counter / gauge / histogram), plus the no-op `Telemetry\Metrics\NullMetricsRegistry` default.
- **Async finish-request deferral (ASYNC-01 · RFC-015)** — `Async\TaskRunnerInterface` (extends `ResettableInterface`: `defer` / `run` / `pending` — bounded per-request budget, Fiber-isolated drain at finish-request), `Async\DeferredTaskInterface` (a self-contained, bounded unit of post-response work), and the deferral exception markers `Async\Exception\AsyncExceptionInterface` and `Async\Exception\DeferralBudgetExceededExceptionInterface` (the explicit "move it to a real queue" signal, exposing `budget()`).
- **Concurrent HTTP client / promises (ASYNC-02)** — `HttpClient\ConcurrentClientInterface` (parallel `sendRequests` batch + non-blocking `promise`), `HttpClient\PromiseInterface` (`then` / `catch` settle callbacks + blocking `wait`), and the `HttpClient\Enum\PromiseState` enum (pending / fulfilled / rejected).
- **Connection-pool ports (DBAL-01/02 · RFC-022)** — backend-neutral pooling: `Data\Connection\ConnectionPoolInterface` (heal-on-lease `acquire` / `release`), `Data\Connection\ConnectionInterface` (`kind` / `isAlive` / `id`), the narrowed `Data\Connection\RelationalConnectionPoolInterface` (typed `PdoConnectionInterface` acquire + request-scoped `beginRequestScope` / `endRequestScope` for one-transaction-per-request) and `Data\Connection\RedisConnectionPoolInterface`, plus the typed handle accessors `Data\Connection\{PdoConnectionInterface, RedisConnectionInterface}`.
- **Reactive broadcast ports (REACTIVE-01 · RFC-018)** — the `#[Reactive\Attribute\Broadcast]` property attribute, `Reactive\BroadcastBufferInterface` (extends `ResettableInterface`: request-scoped, I/O-free `record` + finish-request `drain`), `Reactive\BroadcastTransportInterface` (SSE / Mercure sink — `push` / `pushBatch`), and the immutable `Reactive\MutationRecord` value object.
- **WebAuthn / passkeys (AUTH-01 · RFC-021)** — `Auth\WebAuthn\WebAuthnVerifierInterface` (stateless attestation/assertion verification wrapping `web-auth/webauthn-lib`) with its supporting surface: `Auth\WebAuthn\{WebAuthnUserInterface, CredentialRepositoryInterface, RegisteredCredentialInterface, RegistrationOptionsInterface, AssertionOptionsInterface}` and the exception markers `Auth\WebAuthn\Exception\{WebAuthnExceptionInterface, InvalidWebAuthnRegistrationExceptionInterface, InvalidWebAuthnAssertionExceptionInterface}`.
- **AOT container (AOT-01 · RFC-019)** — `Container\CompiledContainerInterface` (extends `ContainerInterface`): marker for the build-time, reflection-free compiled container that must produce a service graph identical to the runtime container and remains a drop-in fallback.

### Changed
- **Context-aware authorization (AUTHZ-01)** — `Security\VoterInterface::decide()` now takes a request-scoped `Auth\SecurityContextInterface $ctx` (identity, roles, client IP) plus an optional `mixed $subject` (the resource under decision, or the PSR-7 request), replacing the prior context-free signature. This unlocks ownership / IDOR / ABAC rules expressed against the authenticated identity. Voters MUST remain stateless — read everything from `$ctx` / `$subject` — and the fail-closed deny-by-default contract is preserved.

### Dependencies
- Lockstep version bump; `composer.lock` refreshed with the beta-5 dependency wave.

## [0.1.0-beta4] — 2026-06-13

**Theme: security hardening, worker-mode diagnostics & DX (RC-readiness groundwork).**

### Added
- `Validation\SelfValidatingInterface` — opt-in `assertValid()` contract behind the injectable, mockable validator (DX-05).
- `Data\Connection\ConnectionTrackerInterface` (extends `ResettableInterface`) and the `Data\Connection\ConnectionKind` enum — the orphaned-connection tracer port (DIAG-03).
- `Handler\ResponseFactoryAwareInterface` — interface-based response-factory injection for controllers (ARCH-05).
- `Http\GlobalsFactoryInterface` — the "build a PSR-7 request from the ambient SAPI/superglobals" port, letting `runtime` depend on the abstraction instead of `http`'s concrete `GlobalsFactory` (perimeter remediation).

### Changed
- Worker-safety migration to igor-php 0.7 (`#[WorkerSafe]`).

## [0.1.0-beta3] — 2026-06-07

**Theme: identity federation & stateless persistence (RFC-021 / RFC-022 contract surface).**

### Added
- **Auth (RFC-021)** — `Auth\Assertion\{UserAssertionInterface, AssertionSignerInterface, AssertionVerifierInterface}` formalising the Gateway Assertion Protocol (`X-Wfl-Assert-User`), plus the dedicated auth exception marker interfaces consumed by the RFC 7807 error handler.
- **Data / SQR (RFC-022)** — `Data\Enum\{Direction, Operator}`, the `Data\Query\{ComparisonInterface, OrderInterface}` predicate contracts, the repository surface — `Data\Repository\RepositoryInterface` (reads: `find` / `findOne` / `stream`) and `Data\Repository\WritableRepositoryInterface` (CRUD writes: `save` / `delete` / `findById`) — the pure `Data\Mapper\DataMapperInterface` (entity ⇄ storage-row mapping, no Active Record), and the data-layer exception interfaces (`DatabaseExceptionInterface`, `SecurityPathViolationExceptionInterface`, `UnauthenticatedAccessExceptionInterface`).
- `Data\Warmup\DataWarmerInterface` — CLI-side artifact warmer behind the new `data:warmup` console command: pre-compiles SQR trees / routing tables into OPcache shared memory; implementations must be stateless and idempotent.
- `Runtime\AuditRunnerInterface` — contract for running an external audit script and streaming its output line-by-line (`run(string $scriptPath, string $workingDirectory, array $arguments, Closure $onLine): int`). Backs the new `igor:audit` console command; the concrete `ProcessAuditRunner` lives in `waffle-commons/runtime`, so `console` gains no dependency edge (mirrors the `MigrationRunnerInterface` arrangement).
- `Core\TerminableInterface` — post-response teardown hook implemented by the kernel for FrankenPHP worker-loop hygiene.

### Changed
- Lockstep version bump; `composer.lock` refreshed with the beta-3 dependency wave.

## [0.1.0-beta2.1] — 2026-05-30

### Changed
- Lockstep re-tag of `0.1.0-beta2` (umbrella housekeeping patch) — no source changes in this component.

## [0.1.0-beta2] — 2026-05-29

**Theme: HTTP correctness — typed contracts for 405 Method Not Allowed.**

### Added
- `Waffle\Commons\Contracts\Routing\Exception\MethodNotAllowedException` (concrete `final` class) and its `MethodNotAllowedExceptionInterface` marker. Carries the list of allowed methods so downstream renderers can emit the RFC 7231 `Allow` header.
- `Waffle\Commons\Contracts\Routing\Attribute\Route`: gained a `$methods` array parameter (`['GET']` by default; empty array means "any"). Constructor parameter order normalised so `$path` precedes `$methods`.
- `Waffle\Commons\Contracts\Routing\Constant`: HTTP method string constants (`METHOD_GET`, `METHOD_POST`, `METHOD_PUT`, `METHOD_PATCH`, `METHOD_DELETE`, `METHOD_HEAD`, `METHOD_OPTIONS`).
- `Waffle\Commons\Contracts\Routing\MatchedRoute`: minor refinement (additional metadata fields).
- `Waffle\Commons\Contracts\Exception\WaffleExceptionInterface`: explicit base interface for the framework's exception hierarchy.

### Changed
- `Route` attribute constructor parameter order reordered (`$path` first, `$methods` second); pre-existing call sites already used named arguments, so no source-level breakage in the ecosystem.
- `MethodNotAllowedException`'s default English exception message (previous default was French — unified with the ecosystem language policy).

### Fixed
- Trailing-newline normalisation in `src/Security/Csrf/Constant.php`.

### Tests
- `RouteTest`: 56 lines added, covering new `methods` parameter shape and edge cases.
- `MethodNotAllowedExceptionTest`: 51 lines added, covering allowed-methods payload + 405 status code.

### Dependencies
- `composer.lock` refreshed (PHPUnit, Symfony polyfills).

## [0.1.0-beta1]

See the umbrella [CHANGELOG](../CHANGELOG.md#010-beta1) for the full Beta-1 narrative — the cross-component framing belongs there.
