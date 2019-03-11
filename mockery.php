<?php

use Mockery as m;

m::mock(Some::class);

$some->shouldReceive('some')->once()->andReturn(1);
$some->shouldReceive('some')->with('foo', m::type(Some::class))->andReturnNull();
$some->shouldReceive('some')->andReturnUsing(function ($array = []) {
    return new Some($array);
});
