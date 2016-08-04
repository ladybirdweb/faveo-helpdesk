# Bus

This package provides an implementation of the `Illuminate\Contracts\Bus\Dispatcher` interface that matches the Laravel 5.1.x implementation with separate commands and handlers.

## Installation

- Remove `Illuminate\Bus\BusServiceProvider` from your `app.php` configuration file.
- Add `Collective\Bus\BusServiceProvider` to your `app.php` configuration file.

If you are type-hinting `Illuminate\Bus\Dispatcher`, you should now type-hint `Collective\Bus\Dispatcher`.
