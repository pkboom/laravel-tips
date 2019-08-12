<?php

$totals = DB::table('subscribers')
    ->selectRaw('count(*) as total')
    ->selectRaw("count(case when status = 'confirmed' then 1 end) as confirmed")
    ->selectRaw("count(case when status = 'unconfirmed' then 1 end) as unconfirmed")
    ->selectRaw("count(case when status = 'cancelled' then 1 end) as cancelled")
    ->selectRaw("count(case when status = 'bounced' then 1 end) as bounced")
    ->first();

$totals->total;
$totals->confirmed;
$totals->unconfirmed;
$totals->cancelled;
$totals->bounced;

$totals = DB::table('subscribers')
    ->selectRaw('count(*) as total')
    ->selectRaw('count(is_admin or null) as admins')
    ->selectRaw('count(is_treasurer or null) as treasurers')
    ->selectRaw('count(is_editor or null) as editors')
    ->selectRaw('count(is_manager or null) as managers')
    ->first();

// This works since the count aggregate ignores null columns. Unlike in PHP where false or null returns false,
// in SQL (and JavaScript for that matter) it returns null. Basically, A or B returns the value A
// if A can be coerced into true; otherwise, it returns B.

// postgres
$totals = DB::table('subscribers')
    ->selectRaw('count(*) as total')
    ->selectRaw('count(*) filter (where is_admin) as admins')
    ->selectRaw('count(*) filter (where is_treasurer) as treasurers')
    ->selectRaw('count(*) filter (where is_editor) as editors')
    ->selectRaw('count(*) filter (where is_manager) as managers')
    ->first();


    https://reinink.ca/articles/calculating-totals-in-laravel-using-conditional-aggregates
