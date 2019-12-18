<?php

Alert::where('team_id', $event->alert->team_id)
    ->whereNotIn('id', function ($query) use ($event) {
        $query->select('id')->fromSub(
            Alert::select('id')
                ->where('team_id', $event->alert->team_id)
                ->orderBy('id', 'desc')
                ->limit(100)
                ->toBase(),
            'team_alerts_temp'
        );
    })->delete();
