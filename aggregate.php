<?php

https://reinink.ca/articles/calculating-totals-in-laravel-using-conditional-aggregates

// select
//   count(*) as total,
//   count(case when status = 'confirmed' then 1 end) as confirmed,
//   count(case when status = 'unconfirmed' then 1 end) as unconfirmed,
//   count(case when status = 'cancelled' then 1 end) as cancelled,
//   count(case when status = 'bounced' then 1 end) as bounced
// from subscribers

$totals = DB::table('subscribers')
    ->selectRaw('count(*) as total')
    ->selectRaw("count(case when status = 'confirmed' then 1 end) as confirmed")
    ->selectRaw("count(case when status = 'unconfirmed' then 1 end) as unconfirmed")
    ->selectRaw("count(case when status = 'cancelled' then 1 end) as cancelled")
    ->selectRaw("count(case when status = 'bounced' then 1 end) as bounced")
    ->first();

$totals = DB::table('subscribers')
    ->selectRaw('count(*) as total')
    ->selectRaw('count(is_admin or null) as admins')
    ->selectRaw('count(is_treasurer or null) as treasurers')
    ->selectRaw('count(is_editor or null) as editors')
    ->selectRaw('count(is_manager or null) as managers')
    ->first();
?>

<div>Total: {{ $totals->total }}</div>
<div>Confirmed: {{ $totals->confirmed }}</div>
<div>Unconfirmed: {{ $totals->unconfirmed }}</div>
<div>Cancelled: {{ $totals->cancelled }}</div>
<div>Bounced: {{ $totals->bounced }}</div>