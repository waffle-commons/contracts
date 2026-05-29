# Changelog — waffle-commons/contracts

All notable changes to this component are documented in this file.
The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and the project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).
Released in lockstep with the Waffle Commons umbrella tag.

## [Unreleased] — targeting `0.1.0-beta2`

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
