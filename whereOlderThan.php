<?php

class Post extends Model
{
    public function whereOlderThan()
    {
        // Post::whereDate('created_at', '<', Carbon::parse('1 year ago'));
        return Post::whereOlderThan(Carbon::parse('1 year ago'));
    }
}

// app/Providers/AppServiceProvider.php
class AppServiceProvider
{
    public function boot()
    {
        \Illuminate\Database\Eloquent\Builder::macro('whereOlderThan', function ($date) {
            return $this->whereDate('created_at', '<', $date);
        });
    }
}
