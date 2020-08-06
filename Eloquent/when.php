<?php

$query->when(Request::input('sort'), function ($query, $sort) {
    switch ($sort) {
        case 'category': return $query->orderByCategory();
        case 'last_comment': return $query->orderByLastCommentDate();
        case 'status': return $query->orderbyStatus();
        case 'activity': return $query->orderbyActivity();
    }
}, function ($query) {
    $query->orderByName();
});
