<?php
namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function asserting_a_model()
    {
        $currentUser = auth()->user();
        // Before
        $this->assertEquals($user->id, $currentUser->id);
        // After
        // Checks ids, tables, connections, and won't error if $currentUser is null
        $this->assertTrue($user->is($currentUser));
    }
}
