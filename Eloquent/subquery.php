<?php

// https://reinink.ca/articles/dynamic-relationships-in-laravel-using-subqueries

$lastLogin = Login::select('created_at')
    ->whereColumn('user_id', 'users.id')
    ->latest()
    ->limit(1)
    ->getQuery();

$users = User::select('users.*')
    ->selectSub($lastLogin, 'last_login_at')
    ->get();

//////////////////////////////////////////////////////////////////


use Illuminate\Database\Query\Builder;

Builder::macro('addSubSelect', function ($column, $query) {
    if (is_null($this->columns)) {
        $this->select($this->from.'.*');
    }

    return $this->selectSub($query->limit(1), $column);
});

$users = User::addSubSelect(
    'last_login_at',
    Login::select('created_at')
    ->whereColumn('user_id', 'users.id')
    ->latest()
)->get();

////////////////////////////////////////////////////////////////////


class User extends Model
{
    public function scopeWithLastLoginDate($query)
    {
        $query->addSubSelect(
            'last_login_at',
            Login::select('created_at')
            ->whereColumn('user_id', 'users.id')
            ->latest()
        );
    }
}

$users = User::withLastLoginDate()->get();


///////////////////////////////////////////////////////////////////////

class User extends Model
{
    public function lastLogin()
    {
        return $this->belongsTo(Login::class);
    }

    public function scopeWithLastLogin($query)
    {
        $query->addSubSelect(
            'last_login_id',
            Login::select('id')
            ->whereColumn('user_id', 'users.id')
            ->latest()
        )->with('lastLogin');
    }
}

$users = User::withLastLogin()->get();
