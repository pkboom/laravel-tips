```
find app/Http/Controllers -type f -name '*Controller.php' -exec bash -c 'php artisan make:test $(dirname "${1:19}")/$(basename "$1" .php)Test' bash {} \;
```

```
find . -exec grep chrome {} \;
find . -exec grep chrome {} +
```

find will substitute {} with the filename(s) found. The difference between ; and + is that with ; a single grep command for each file is executed whereas with + as many files as possible are given as parameters to grep at once.
