<?php

// mockery
$some->shouldReceive('some')->once()->with('some', m::mustBe(1))->andReturn(1);
$some->shouldReceive('some')->andReturnNull();
