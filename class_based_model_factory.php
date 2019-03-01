<?php

// app/LeagueFactory.php
class LeagueFactory
{
    public $invitesCount = 0;
    public $membersCount = 0;
    public $user = null;
    public $season = null;

    public function withInvitations($count)
    {
        $this->invitesCount = $count;
        return $this;
    }

    public function withMembers($count)
    {
        $this->membersCount = $count;
        return $this;
    }

    public function ownedBy(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function forSeason(Season $season)
    {
        $this->season = $season;
        return $this;
    }

    public function create()
    {
        $league = factory(League::class)->create([
            'user_id' => $this->user ?? factory(User::class),
            'season_id' => $this->season ?? factory(Season::class),
        ]);

        factory(LeagueInvitation::class, $this->invitesCount)->create([
            'league_id' => $league->id,
        ]);

        factory(LeagueMember::class, $this->membersCount)->create([
            'league_id' => $league->id,
        ]);

        return $league;
    }
}


class SeasonFactory
{
    public $contestantsCount = 0;

    public function withContestants($count)
    {
        $this->contestantsCount = $count;
        return $this;
    }

    public function create()
    {
        $season = factory(Season::class)->create();

        factory(Contestant::class, $this->contestantsCount)->create([
            'season_id' => $season->id,
        ]);

        return $season;
    }
}

class LeagueTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function the_combined_total_of_members_and_invitations_for_a_league_cannot_exceed_the_number_of_contestants()
    {
        $season = app(SeasonFactory::class)->withContestants(20)->create();

        $user = factory(User::class)->create();
        
        $league = app(LeagueFactory::class)
            ->ownedBy($user)
            ->forSeason($season)
            ->withInvitations(10)
            ->withMembers(10)
            ->create();

        $this->actingAs($user)
            ->post("/leagues/{$league->getRouteKey()}/invitations")
            ->assertStatus(403);
    }
}
