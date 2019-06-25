<?php

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
}

////////////////////////////////////////////////////////////////////////////

Blade::directive('error_class', function($expression) {
    $args = explode(', ', $expression);

    if (count($args) > 1) {
        $args[1] = str_replace("'", '', args[1]);
    } else {
        $args[1] = 'border-red-500';
    }

    return '
        <?php if ($errors->has('.$args[0].')) : ?>
            <?php echo echo "'.$args[1].'"; ?>
        <?php endif; ?>
    ';
});

<input type="text" class="@error_class('name') w-full block">

@error('name')
    <p class="mt-3 text-red-500 text-sm font-bold">{{ $message }}</p>
@enderror

@error_class('name', 'form-danger')