# Seatbelt

[![Tests](https://github.com/Hashane/Seatbelt/actions/workflows/tests.yml/badge.svg)](https://github.com/Hashane/Seatbelt/actions/workflows/tests.yml)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-%5E8.3-777BB4?logo=php&logoColor=white)](composer.json)
[![Laravel Version](https://img.shields.io/badge/Laravel-%5E12%20%7C%20%5E13-FF2D20?logo=laravel&logoColor=white)](composer.json)
![Buckle Up](.github/badges/buckle-up.svg)

Opinionated, production-ready Laravel standards — active the moment it's installed, no config publishing or provider wiring required. Also bootstraps a fresh project's tooling (Pint, PHPStan/Larastan, Rector) via a single install command.

## Installation

```bash
composer require judehashane/seatbelt
```

To see or change the defaults, publish the config:

```bash
php artisan vendor:publish --tag=seatbelt-config
```

## What it does

Each row is its own `Configuration` class, listed in `config/seatbelt.php`. Remove an entry to disable it entirely, or keep it and use its config key to toggle it. All are on by default.

| Configuration | Active when | Config key(s) | What it does |
|---|---|---|---|
| `ProhibitDestructiveCommands` | production | `prohibit_destructive_commands` | Blocks `db:wipe`, `migrate:fresh/reset/refresh/rollback` — even with `--force`. |
| `DefaultPasswordRules` | production | `password.*` | Strong `Password::defaults()` rule — length, character classes, breach check. |
| `StrictModels` | outside production | `enforce_strict_models` | `Model::shouldBeStrict()` — throws on lazy loading, mass-assignment, and missing-attribute violations. |
| `ForceHttpsScheme` | production | `force_https_scheme` | `URL::forceScheme('https')` for all generated URLs. |
| `DatabaseMonitoring` | outside production | `database.*` | Logs a warning when a query exceeds the configured time budget. |
| `AutomaticEagerLoading` | production | `automatically_eager_load_relationships` | `Model::automaticallyEagerLoadRelationships()` — auto-resolves N+1s that slip past `StrictModels` in dev. |
| `ViteAggressivePrefetching` | production | `vite_aggressive_prefetching` | `Vite::useAggressivePrefetching()` — prefetches built JS/CSS in the background. |
| `PreventStrayRequests` | test suite only | `prevent_stray_requests` | `Http::preventStrayRequests()` — un-faked HTTP calls throw. |
| `PreventStrayProcesses` | test suite only | `prevent_stray_processes` | `Process::preventStrayProcesses()` — un-faked shell calls throw once something fakes. |
| `QueueFailedJobLogging` | production | `queue_failed_job_logging` | `Queue::failing()` — logs connection, queue, job class, and exception on failure. |
| `ImmutableDates` | always | `immutable_dates` | `Date::use(CarbonImmutable::class)` — dates are immutable everywhere. |

A few are gated in opposite directions on purpose: `StrictModels` and `DatabaseMonitoring` are noisy-by-design dev feedback, so they're off in production; `ProhibitDestructiveCommands`, `ForceHttpsScheme`, and `AutomaticEagerLoading` are production safety nets that would just get in the way locally; `PreventStrayRequests`/`PreventStrayProcesses` are test-only, since enabling them elsewhere would break real requests and shell commands.

## Tooling bootstrap

```bash
php artisan seatbelt:install
```

Publishes `config/seatbelt.php`, `pint.json`, `phpstan.neon`, and `rector.php`. These are config files, not the tools — install what they expect:

```bash
composer require --dev larastan/larastan mrpunyapal/peststan rector/rector driftingly/rector-laravel mrpunyapal/rector-pest
```

`phpstan.neon`/`rector.php` reference Seatbelt's rules live from `vendor/judehashane/seatbelt`, so `composer update` picks up rule changes with no re-publishing. `pint.json` is a static copy — re-publish with `--force` if it changes.

```bash
php artisan seatbelt:install --force
```

## Testing

```bash
composer test       # Pest only
composer quality     # Rector dry-run, Pint, PHPStan, Pest
```

## Contributing

PRs welcome — see [CONTRIBUTING.md](CONTRIBUTING.md).