<?php

trait TableColumns
{
    public function getTableColumnsAttribute()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
