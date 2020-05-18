<?php

$customers = Customer::whereExists(fn ($query) 
    $query->select('id')
        ->from('region')
        ->where('regions.name', 'The Prairies')
        ->whereRaw('ST_Contains(
            regions.geometry::geometry,
            customers.location::geometry
        )')
)->get();

///////////////////////////////////////////////

$coordinates = Auth::user()->only('longitude'. 'latitude');

$stores = Store::query()
            ->selectDistanceTo($coordinates)
            ->withinDistnaceTo($coordinates, 10000) // 10km
            ->orderByDistanceTo($coordinates)
            ->paginate();

class Store extends Model
{
    public function scopeOrderByDistanceTo($query, array $coordinates)
    {
        $query->orderRaw('ST_Distance(
            ST_MakePoint(longtitude, latitude)::geography,
            ST_MakePoint(?, ?)::geography
        )', $coordinates);
    }
}
