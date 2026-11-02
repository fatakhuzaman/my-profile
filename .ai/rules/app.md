---
paths:
  - 'app/**'
  - 'bootstrap/**'
  - 'config/**'
  - 'database/**'
  - 'routes/**'
  - 'resources/js/**'
  - 'resources/css/**'
---

# App

## Clean, readable, maintainable code
- Descriptive names (`isRegisteredForDiscounts`, not `discount()`); small methods that do one thing.
- One source of truth: reuse existing helpers instead of repeating logic (e.g. `Localization::defaultLocale()`, never `config('app.supported_locales')[0]`).
- No dead code: no commented-out code, unused imports, or empty generated stubs such as an empty `getRelations()`.
- Fixed sets of values are backed enums (`app/Enums`) that own their label, color and icon (Filament `HasLabel`/`HasColor`), not class constants or string literals.

## Comments explain why, never what
- Do not write comments that restate the code or a name; rename or extract a method instead.
- Use PHPDoc for types, array shapes and non-obvious intent; inline `//` comments only for a non-obvious reason or trade-off.
- Laravel's own stub docblocks (e.g. "The attributes that are mass assignable.") are framework convention and stay.

## Follow official and community standards
- Write code the way the official docs of the installed version show it: Laravel 13, PHP 8.5, Filament 5, Livewire 4, spatie/laravel-translatable 6. Check with Boost `search-docs` (or the official docs) before using an API.
- Prefer framework features over hand-rolled ones: Form Requests, Eloquent accessors (`Attribute::get`), scopes, policies, `match`, enums, constructor promotion.
- Style is PSR-12 via Pint: run `"$HOME/.config/herd/bin/php85/php.exe" vendor/bin/pint --dirty --format agent` (plain `vendor/bin/pint` picks XAMPP PHP 8.2).
