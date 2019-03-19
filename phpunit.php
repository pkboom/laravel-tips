<?php

// phpunit
$some = $this->getMockBuilder(Some::class)->setConstructorArgs([$some, 1, null])->getMock();
$some->expects($this->once())->method('some')->with('some', 1)->will($this->returnValue(1));
$some->expects($this->never())->method('some');

$some = $this->getMockBuilder(Some::class)->getMock();
$some = $this->getMockBuilder(Some::class)->setMethods([])->getMock();
// setMethods
// all stubs, return null, overridable

$some = $this->getMockBuilder(Some::class)->setMethods(null)->getMock();
// all mocks, run the actual code, not overridable

$some = $this->getMockBuilder(Some::class)->setMethods(['some'])->getMock();
// Methods you identified: all stubs, return null, overridable
// Methods you didn't identify: all mocks, run the actual code, not overridable


/**
 * @expectedException \LogicException
 * @expectedExceptionMessage Queueing collections with multiple model types is not supported.
 */

 class SomeTest
 {
     public function setUp()
     {
         $this->p = new Some(1, 2);
     }
     
     public function tearDown()
     {
         unset($this->p);
     }
 }
