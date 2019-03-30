<?php

// Usage:

// Before
@if ($errors->has('email'))
    <span>{{ $errors->first('email') }}</span>
@endif
  
// After:
@error('email')
    <span>{{ $message }}</span>
@enderror

// Include the following in your "app/Providers/AppServiceProvider.php":

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('error', function ($expression) {
            return <<<EOT
<?php
if (\$errors->has({$expression})) :
    if (isset(\$message)) { \$messageCache = \$message; }

    \$message = \$errors->first({$expression});
?>
EOT;
        });

        Blade::directive('enderror', function () {
            return <<<EOT
<?php
    unset(\$message);
    if (isset(\$messageCache)) { \$message = \$messageCache; }
endif;
?>
EOT;
        });
    }