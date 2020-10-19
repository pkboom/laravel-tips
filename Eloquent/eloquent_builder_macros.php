<?php

use Illuminate\Database\Query\Builder;

class AppServiceProvider
{
    public function boot()
    {
        \Illuminate\Database\Eloquent\Builder::macro('whereOlderThan', function ($date) {
            return $this->whereDate('created_at', '<', $date);
        });
        
        // postgreSql: order by some_column null first/last
        // other sql: ORDER BY some_column IS NOT NULL, birth_date DESC
        // nulls last + desc = IS NOT NULL, DESC
        // nulls last + asc = IS NULL, ASC
        // nulls first + desc = IS NULL, DESC
        // nulls first + asc = IS NOT NULL, ASC
        // https://www.designcise.com/web/tutorial/how-to-order-null-values-first-or-last-in-mysql
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

        Builder::macro('addSubSelect', function ($column, $query) {
            if (is_null($this->columns)) {
                $this->select($this->from.'.*');
            }
            return $this->selectSub($query->limit(1), $column);
        });

        Builder::macro('orderBySub', function ($query, $direction = 'asc', $nullPosition = null) {
            if (!in_array($direction, ['asc', 'desc'])) {
                throw new Exception('Not a valid direction.');
            }
            if (!in_array($nullPosition, [null, 'first', 'last'], true)) {
                throw new Exception('Not a valid null position.');
            }
            return $this->orderByRaw(
                implode('', ['(', $query->limit(1)->toSql(), ') ', $direction, $nullPosition ? ' NULLS '.strtoupper($nullPosition) : null]),
                $query->getBindings()
            );
        });

        Builder::macro('orderBySubAsc', function ($query, $nullPosition = null) {
            return $this->orderBySub($query, 'asc', $nullPosition);
        });

        Builder::macro('orderBySubDesc', function ($query, $nullPosition = null) {
            return $this->orderBySub($query, 'desc', $nullPosition);
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
