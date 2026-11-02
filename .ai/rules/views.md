---
paths:
  - 'resources/views/**'
---

# Views

## Keep logic out of Blade
- Views only display data. Formatting and decisions live in models (accessors), enums or controllers, e.g. `$plan->formatted_price`, `$type->icon()`.
- A short `@php` block may hold a `@var` hint or name a value used more than once; no queries, `match` tables or business rules.
- Reuse the `x-site.*` components instead of duplicating markup.
