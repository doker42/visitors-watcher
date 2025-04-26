# VisitorsWatcher

📈 Laravel-пакет для отслеживания посещений на сайте.

## Установка

Добавьте репозиторий в `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/doker42/visitors-watcher"
    }
]

-- composer require doker42/visitors-watcher

-- php artisan vendor:publish --provider="Doker42\VisitorsWatcher\VisitorsWatcherServiceProvider"