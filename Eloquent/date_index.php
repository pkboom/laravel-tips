<?php

use \Carbon\Carbon;

// Using MySQL 'date()' does NOT use an index
User::whereDate('created_at', '=', Carbon::today())->get();

// Using 'between' instead of date()' does use an index
class User
{
    public function scopeDate($query, $column = 'created_at', $date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();

        $query->whereBetween($column, [
            $date->startOfDay()->toDateTimeString(),
            $date->endOfDay() ->toDateTimeString()
        ]);
    }
}

User::date('created_at', Carbon::today())->get();
