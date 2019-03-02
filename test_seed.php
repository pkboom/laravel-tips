<?php

class ExampleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->seed('SomeDatabaseSeeder');
    }

    public function testSome()
    {
        // given, when, then
    }
}
