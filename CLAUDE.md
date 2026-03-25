# Cuttlefish

Minimal PHP web-app framework. Current branch: `refocus`.

## Requirements

- PHP >= 8.3
- Composer

## Development

```bash
devbox shell          # reproducible PHP 8.3 environment
composer install      # install dependencies (includes phpcs)
composer run lint     # syntax check + phpcs
composer run serve    # php -S localhost:5333
```

## Git

- Remote: `git@github.com:svandragt/cuttlefish.git` (SSH)
- Pre-commit hook (husky) runs `composer validate` and `composer run lint`
- `phpcs` is a dev dependency in vendor — no global install needed

## CI

GitHub Actions workflow at `.github/workflows/php.yml`. Uses `actions/checkout@v4` and `actions/cache@v4`.
