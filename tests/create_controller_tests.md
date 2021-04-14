# Create controller tests

find app/Http/Controllers -type f -name '\*Controller.php' -exec bash -c 'php artisan make:test $(dirname "${1:21}")/$(basename "$1" .php)Test' bash {} \;

# Create job tests

find app/Jobs -type f -name '\*.php' -exec bash -c 'php artisan make:test $(dirname "${1:4}")/$(basename "$1" .php)Test' bash {} \;

# Create actions tests

find app/Actions -type f -name '\*.php' -exec bash -c 'php artisan make:test $(dirname "${1:4}")/$(basename "$1" .php)Test' bash {} \;
