<?php

// phpunit

// setMethods: Specifies the subset of methods to mock. Default is to mock none of them.
$some = $this->getMockBuilder(Some::class)->setConstructorArgs([$some, 1, null])->getMock();
$some = $this->getMockBuilder(Some::class)->setMethods([])->getMock();
// setMethods
// Are all stubs,
// All return null by default,
// Are easily overridable
$some = $this->getMockBuilder(Some::class)->setMethods(null)->getMock();
// Are all mocks,
// Run the actual code contained within the method when called,
// do not allow you to override the return value

$some = $this->getMockBuilder(Some::class)->setMethods(['some'])->getMock();
// The methods you have identified
// Are all stubs,
// All return null by default,
// Are easily overridable

// Methods you did not identify
// Are all mocks,
// Run the actual code contained within the method when called,
// do not allow you to override the return value


// mockery

$some->shouldReceive('some')->once()->with('some', m::mustBe(1))->andReturn(1);
$some->shouldReceive('first')->once()->andReturnNull();
