<?php

$array = [];

if (! $array) {
    echo 'empty bro';
}
if ($array) {
    echo 'not empty bro';
}

$array = [null];

if (! $array) {
    echo 'empty bro';
}
if ($array) {
    echo 'not empty bro';
}
