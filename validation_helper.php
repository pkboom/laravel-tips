<?php

function validate($fields, $rules)
{
    if (! is_array($fields)) {
        $fields = ['default' => $fields];
    }

    if (! is_array($rules)) {
        $rules = ['default' => $rules];
    }

    return Validator::make($fields, $rules)->passes();
}
