<?php

// phpunit
$c = $this->getMockBuilder(Some::class)->getMock();
$c->expects($this->once())->method('some')->will($this->returnValue(1));

$some = $this->getMockBuilder(Some::class)->setConstructorArgs([$some, 1, null])->getMock();
$some = $this->getMockBuilder(Some::class)->setMethods([])->getMock();
// setMethods
// all stubs, return null, overridable

$some = $this->getMockBuilder(Some::class)->setMethods(null)->getMock();
// all mocks, run the actual code, not overridable

$some = $this->getMockBuilder(Some::class)->setMethods(['some'])->getMock();
// The methods you have identified
// all stubs, return null, overridable

// Methods you did not identify
// all mocks, run the actual code, not overridable


/**
 * @expectedException \LogicException
 * @expectedExceptionMessage Queueing collections with multiple model types is not supported.
 */
