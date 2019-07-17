<?php

use Illuminate\Database\Query\Builder;

class AppServiceProvider
{
    public function boot()
    {
        \Illuminate\Database\Eloquent\Builder::macro('whereOlderThan', function ($date) {
            return $this->whereDate('created_at', '<', $date);
        });
        
        // postgreSql: order by null first/last
        // other sql: ORDER BY birth_date IS NOT NULL, birth_date DESC
        // nulls last + desc = IS NOT NULL, DESC
        // nulls last + asc = IS NULL, ASC
        // nulls first + desc = IS NULL, DESC
        // nulls first + asc = IS NOT NULL, ASC
        Builder::macro('orderByNulls', function ($column, $direction = 'asc', $nulls = 'last', $bindings = []) {
            $column = $this->getGrammar()->wrap($column);
            $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';
            $nulls = strtolower($nulls) === 'first' ? 'NULLS FIRST' : 'NULLS  LAST';
    
            return $this->orderByRaw("$column $direction $nulls", $bindings);
        });
    
        Builder::macro('orderByNullsLast', function ($column, $direction = 'asc', $bindings = []) {
            return $this->orderByNulls($column, $direction, 'last', $bindings);
        });
    
        Builder::macro('orderByNullsFirstr', function ($column, $direction = 'asc', $bindings = []) {
            return $this->orderByNulls($column, $direction, 'first', $bindings);
        });
    }
}

class Post extends Model
{
    public function whereOlderThan()
    {
        return Post::whereOlderThan(Carbon::parse('1 year ago'));
    }
}
