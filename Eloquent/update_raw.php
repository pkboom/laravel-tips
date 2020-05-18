<?php

User::query()->update([
    'created_at' => DB::raw('DATE_ADD(created_at, INTERVAL -7 YEAR)')
]);
