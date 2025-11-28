[![PHP Version Require](http://poser.pugx.org/waffle-commons/contracts/require/php)](https://packagist.org/packages/waffle-commons/contracts)
[![PHP CI](https://github.com/waffle-commons/contracts/actions/workflows/main.yml/badge.svg)](https://github.com/waffle-commons/contracts/actions/workflows/main.yml)
[![codecov](https://codecov.io/gh/waffle-commons/contracts/graph/badge.svg?token=d74ac62a-7872-4035-8b8b-bcc3af1991e0)](https://codecov.io/gh/waffle-commons/contracts)
[![Latest Stable Version](http://poser.pugx.org/waffle-commons/contracts/v)](https://packagist.org/packages/waffle-commons/contracts)
[![Latest Unstable Version](http://poser.pugx.org/waffle-commons/contracts/v/unstable)](https://packagist.org/packages/waffle-commons/contracts)
[![Total Downloads](https://img.shields.io/packagist/dt/waffle-commons/contracts.svg)](https://packagist.org/packages/waffle-commons/contracts)
[![Packagist License](https://img.shields.io/packagist/l/waffle-commons/contracts)](https://github.com/waffle-commons/contracts/blob/main/LICENSE.md)

Waffle Contracts Component
==========================

A collection of shared interfaces and abstractions for the Waffle Framework ecosystem. This package ensures decoupling and interoperability between components.

## 📦 Installation

```bash
composer require waffle-commons/contracts
```

## 📖 Contents

This package provides interfaces for:

*   **Config:** `ConfigInterface`
*   **Container:** `ContainerInterface` (extends PSR-11)
*   **Http:** `RequestFactoryInterface`, `ResponseFactoryInterface`
*   **Routing:** `RouterInterface`
*   **Security:** `SecurityInterface`
*   **View:** `ViewInterface`

It is primarily used by library authors building extensions for Waffle.
