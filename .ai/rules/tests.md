---
paths:
  - 'tests/**'
---

# Tests

## Every behavior change is tested
- New or moved behavior gets a PHPUnit feature test (factories + their states, data providers for variants).
- Run the narrowest tests with Herd PHP, then the full suite before committing.
