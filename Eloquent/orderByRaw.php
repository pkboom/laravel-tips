<?php

class CampaignSort
{
    public function _invoke($query, bool $descending)
    {
        $sortDirection = $descending ? 'DESC' : 'ASC';
        $reverseSortDirection = $descending ? 'ASC' : 'DESC';

        $orderclause = <<<SQL
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

        $query->orderByRaw($orderclause);
    }
}
