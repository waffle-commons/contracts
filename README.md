[![demo](https://img.shields.io/discord/755288001592033391?logo=discord)](https://discord.gg/eKgywnfXr2)
[![PHP Version Require](http://poser.pugx.org/waffle-commons/contracts/require/php)](https://packagist.org/packages/waffle-commons/contracts)
[![PHP CI](https://github.com/waffle-commons/contracts/actions/workflows/main.yml/badge.svg)](https://github.com/waffle-commons/contracts/actions/workflows/main.yml)
[![codecov](https://codecov.io/gh/waffle-commons/contracts/graph/badge.svg?token=d74ac62a-7872-4035-8b8b-bcc3af1991e0)](https://codecov.io/gh/waffle-commons/contracts)
[![Latest Stable Version](http://poser.pugx.org/waffle-commons/contracts/v)](https://packagist.org/packages/waffle-commons/contracts)
[![Latest Unstable Version](http://poser.pugx.org/waffle-commons/contracts/v/unstable)](https://packagist.org/packages/waffle-commons/contracts)
[![Total Downloads](https://img.shields.io/packagist/dt/waffle-commons/contracts.svg)](https://packagist.org/packages/waffle-commons/contracts)
[![Packagist License](https://img.shields.io/packagist/l/waffle-commons/contracts)](https://github.com/waffle-commons/contracts/blob/main/LICENSE.md)

Waffle Contracts Component
==========================

> **Release:** `0.1.0-beta3` &nbsp;|&nbsp; [`CHANGELOG.md`](./CHANGELOG.md)

The Waffle Framework's central contract package. Every other `waffle-commons/*` component depends **only** on this package and on its declared PSR interfaces. No component may depend on a sibling's concrete implementation — `contracts` is the line that keeps the ecosystem decoupled.

This package contains interfaces, attributes, enums, exception interfaces, typed constants, and the small set of concrete routing exceptions (`RouteNotFoundException`, `MethodNotAllowedException`) shared across components. No business logic ever ships from here.

## 🆕 Beta-2 highlights — HTTP method correctness

- **NEW** — `Waffle\Commons\Contracts\Routing\Exception\MethodNotAllowedException` (concrete `final` class) and its `MethodNotAllowedExceptionInterface` marker. Carries the allowed-methods list so downstream renderers can emit the RFC 7231 `Allow` header on `405` responses.
- **NEW** — `Waffle\Commons\Contracts\Routing\Constant`: HTTP-method string constants (`METHOD_GET`, `METHOD_POST`, `METHOD_PUT`, `METHOD_PATCH`, `METHOD_DELETE`, `METHOD_HEAD`, `METHOD_OPTIONS`).
- **CHANGED** — `Waffle\Commons\Contracts\Routing\Attribute\Route` (relocated from `waffle-commons/routing` in Beta-2): gained the `array $methods = ['GET']` parameter for method filtering and route overloading. Constructor argument order normalised so `$path` precedes `$methods`. Empty `methods` array means "any method".
- **NEW** — `Waffle\Commons\Contracts\Exception\WaffleExceptionInterface`: explicit base interface for the framework's exception hierarchy.

## Beta-1 inheritance

The Beta-1 line introduced the security and HTTP-correctness foundations this package still carries:

- **BREAKING (Beta-1)** — `CsrfTokenManagerInterface::issue()`, `validate()`, `refresh()` take a `$sessionId` argument. The HMAC binds tokens to the per-browser `WAFFLE_SID` cookie issued by `AnonymousSessionMiddleware`.
- **NEW (Beta-1)** — `Waffle\Commons\Contracts\Security\Attribute\PublicAccess` — explicit opt-out for the fail-closed ABAC default. Without `#[Voter]` and without `#[PublicAccess]`, `SecureContainer::analyze()` denies with HTTP `403`.
- **NEW (Beta-1)** — `Waffle\Commons\Contracts\Routing\Exception\RouteNotFoundException` — concrete `final` class implementing `RouteNotFoundExceptionInterface`. Thrown by `CoreRoutingMiddleware` so missing routes render as `404` instead of `500`.
- **NEW (Beta-1)** — CSRF binding constants on `Waffle\Commons\Contracts\Security\Csrf\Constant`: `SESSION_COOKIE_NAME` (`WAFFLE_SID`), `SESSION_ID_BYTES` (`32`), `SESSION_REQUEST_ATTRIBUTE` (`_anon_sid`), `SESSION_COOKIE_MAX_AGE` (`2_592_000`), plus `MIN_SECRET_BYTES` (`32`) and `SECRET_ENV_KEY` (`WAFFLE_CSRF_SECRET`).

## 📦 Installation

```bash
composer require waffle-commons/contracts
```

## 🧱 What's inside

| Namespace | Purpose |
| :--- | :--- |
| `Waffle\Commons\Contracts\Attribute` | Marker attributes (`#[Dto]`) consumed by the framework's argument resolver. |
| `Waffle\Commons\Contracts\Cache` | PSR-6 + PSR-16 extension interfaces (`CacheInterface`, `CacheItemPoolInterface`, `StampedeProtectionInterface`). |
| `Waffle\Commons\Contracts\Config` | `ConfigInterface` typed getters (`getInt`, `getString`, `getArray`, `getBool`). |
| `Waffle\Commons\Contracts\Console` | `ConsoleApplicationInterface`, `CommandInterface`, `InputInterface`, `OutputInterface`. |
| `Waffle\Commons\Contracts\Constant\Constant` | Ecosystem-wide typed constants (env names, security levels, attribute keys). |
| `Waffle\Commons\Contracts\Container` | `ContainerInterface` extending PSR-11 + `ResettableInterface` for worker-mode resets. |
| `Waffle\Commons\Contracts\Controller` | `BaseControllerInterface`. |
| `Waffle\Commons\Contracts\Core` | `KernelInterface` — the heart of the request lifecycle. |
| `Waffle\Commons\Contracts\Enum` | Framework-wide enums (e.g. `Failsafe`). |
| `Waffle\Commons\Contracts\ErrorHandler` | `ErrorRendererInterface` for content-negotiated error rendering. |
| `Waffle\Commons\Contracts\EventDispatcher` | `EventDispatcherInterface`, `ListenerProviderInterface` (PSR-14 extension). |
| `Waffle\Commons\Contracts\Exception` | Root exception interfaces (`ValidationExceptionInterface`, etc.). |
| `Waffle\Commons\Contracts\Handler` | `ArgumentResolverInterface`, `ResponseConverterInterface`. |
| `Waffle\Commons\Contracts\Http` | Framework-specific HTTP factories on top of PSR-7/17 (`ResponseEmitterInterface`, `ServerRequestFactoryInterface`). |
| `Waffle\Commons\Contracts\Parser` | `YamlParserInterface`. |
| `Waffle\Commons\Contracts\Pipeline` | `MiddlewareStackInterface` (PSR-15 stack). |
| `Waffle\Commons\Contracts\Routing` | `RouterInterface` + routing exception interfaces. |
| `Waffle\Commons\Contracts\Runtime` | `RuntimeInterface` for FrankenPHP / classic SAPI bootstrap. |
| `Waffle\Commons\Contracts\Security` | `SecurityInterface`, `SecurityRuleInterface`, `VoterInterface` + `#[Voter]` / `#[Rule]` attributes + CSRF attributes. |
| `Waffle\Commons\Contracts\Service` | `ResettableInterface` — implemented by any service that needs reset between FrankenPHP worker requests. |
| `Waffle\Commons\Contracts\System` | `SystemInterface`. |
| `Waffle\Commons\Contracts\Validation` | `ValidatorInterface`, `ValidationResultInterface`, `ViolationInterface`. |

## 🐘 PHP 8.5 surface

The contracts package is the canonical reference for the framework's PHP 8.5 contract style:

- **Typed constants** everywhere — `public const string EVENT_NAME = '...';`, `public const int SECURITY_LEVEL10 = 10;`.
- **Marker attributes** with `Attribute::TARGET_*` declarations (`#[Dto]`, `#[Voter]`, `#[Rule]`).
- **`final readonly class`** for value-object attributes.
- All return types and parameter types are explicit; no `mixed` in the public surface except where PSR-11 mandates it (`ContainerInterface::get(): mixed`).

## 📐 Sample interfaces

`KernelInterface` — the heart of the framework:

```php
namespace Waffle\Commons\Contracts\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface KernelInterface
{
    public function boot(): static;
    public function configure(): void;
    public function handle(ServerRequestInterface $request): ResponseInterface;
    public function reset(): void;
}
```

`ConfigInterface` — typed config access:

```php
namespace Waffle\Commons\Contracts\Config;

interface ConfigInterface
{
    public function getInt(string $key, ?int $default = null): ?int;
    public function getString(string $key, ?string $default = null): ?string;
    public function getArray(string $key, ?array $default = null): ?array;
    public function getBool(string $key, ?bool $default = null): ?bool;
}
```

`#[Dto]` — marker attribute for auto-hydrated DTOs:

```php
namespace Waffle\Commons\Contracts\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Dto {}
```

A DTO consumer in your controller:

```php
use Waffle\Commons\Contracts\Attribute\Dto;
use Waffle\Commons\Contracts\Exception\Validation\ValidationExceptionInterface;

#[Dto]
final readonly class UserLoginDto
{
    public string $email {
        set(string $value) {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                throw new \DomainException('Invalid email');
            }
            $this->email = $value;
        }
    }
}
```

## 🤝 Decoupling rule

Every concrete waffle-commons component **must** depend on `waffle-commons/contracts` and on nothing else from the `waffle-commons/*` namespace, unless explicitly declared in its own `composer.json require`. This rule is enforced at build time by `mago guard` perimeters in every component.

## 🧭 Architectural boundary (`mago guard`)

`contracts` is the **root** of the ecosystem, so its own perimeter (enforced by `vendor/bin/mago guard`, bundled into `composer mago`, zero baselines — see [`mago.toml`](./mago.toml) `[guard.perimeter]`) is the strictest of all: production code under `Waffle\Commons\Contracts` may depend **only** on:

- `Waffle\Commons\Contracts\**` — itself
- `Psr\**` — PSR interfaces
- `@global` + `Psl\**` — PHP core and the PHP Standard Library

It depends on **no other `waffle-commons/*` package** — that is what lets every other component depend on it without creating a cycle. Test code under `WaffleTests\Commons\Contracts` is unrestricted (`@all`).

Structural rules are guarded too: interfaces must be named `*Interface`, `Exception\**` classes must end in `*Exception`, and any `Enum\**` namespace may hold only `enum` declarations (see the [Decoupling rule](#-decoupling-rule) above for the ecosystem-wide counterpart).

## 🧪 Testing

```bash
docker exec -w /waffle-commons/contracts waffle-dev composer tests
```

## 📄 License

MIT — see [LICENSE.md](./LICENSE.md).
