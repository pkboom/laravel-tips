<?php

use Mockery as m;

$mock = m::mock(Some::class);

$mock->shouldReceive('some')->once()->andReturn(1);
$mock->shouldReceive('some')->once()->andReturnSelf();
$mock->shouldReceive('some')->with('foo', m::type(Some::class))->andReturnNull();
$mock->shouldReceive('some')->andReturnUsing(function ($array = []) {
    return new Some($array);
});
$mock->shouldReceive('some')->andThrow(InvalidArgumentException::class);
