<?php

use Illuminate\Database\Eloquent\Builder;

// @link: https://stackoverflow.com/questions/26782561/how-does-work-sql-with-order-by-0
class CampaignSort
{
    public function _invoke(Builder $query, bool $descending)
    {
        $sortDirection = $descending ? 'DESC' : 'ASC';
        $reverseSortDirection = $descending ? 'ASC' : 'DESC';

        $orderClause = <<<SQL
            CASE
                WHEN status = 'draft' AND scheduled_at IS NULL THEN O
                ELSE 1 
            END $reverseSortDirection,
            CASE
                WHEN scheduled_at IS NOT NULL THEN scheduled_at 
                WHEN sent_at IS NOT NULL THEN sent_at
                ELSE last_modified_at
            END $sortDirection 
        SQL;

        $query->orderByRaw($orderClause);
    }
}
