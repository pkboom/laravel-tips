<?php
namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_calculates_the_completion_rate()
    {
        $this->signIn();

        $skill = factory(Skill::class)->create(['name' => 'Laravel']);

        $series = factory(Series::class)->create(['episode_count' => 1, 'skill_id' => $skill->id]);

        // If we setRelation on 'skill' with 'series'
        // Then $skill->series returns whatever $series contains.
        // However without setRelation, $skill->series will query on 'skill' to get 'series'.
        // In this case we already have 'series' so no need to query.
        // So just setRelation is enough.
        // Especially in a testing environment, setRelation is useful.
        $skill->setRelation('series', $series);

        $episode = factory(Video::class)->create(['series_id' => $series[0]->id]);

        auth()->user()->complete($episode);

        $this->assertEquals(33, $skill->completionRate());
    }
}
