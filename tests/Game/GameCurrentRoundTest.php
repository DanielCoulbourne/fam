<?php

namespace Fam\Test\Game;

use Fam\FamRelation;
use Fam\Test\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use function now;

class GameCurrentRoundTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();

		Game::migrate();
		Round::migrate();
	}

	public function test_the_current_round_works_as_a_relationship() : void
	{
        $game = Game::create();

        $round1 = $game->rounds()->create([
            'started_at' => now()->subMinutes(2),
            'round_number' => 1
        ]);

        $round2 = $game->rounds()->create([
            'started_at' => now()->subMinute(),
            'round_number' => 2
        ]);

        $round3 = $game->rounds()->create([
            'started_at' => null,
            'round_number' => 3
        ]);

        $this->assertInstanceOf(FamRelation::class, $game->currentRound());
        $this->assertEquals(2, $game->currentRound()->first()->round_number);

        $this->assertInstanceOf(Round::class, $game->currentRound);
        $this->assertEquals(2, $game->currentRound->round_number);
	}

    public function test_eager_loading_works()
    {
        $game1 = Game::create();

        $round1_1 = $game1->rounds()->create([
            'started_at' => now()->subMinutes(2),
            'round_number' => 1
        ]);

        $round1_2 = $game1->rounds()->create([
            'started_at' => now()->subMinutes(1),
            'round_number' => 2
        ]);

        $round1_3 = $game1->rounds()->create([
            'started_at' => null,
            'round_number' => 3
        ]);

        $game2 = Game::create();

        $round2_1 = $game2->rounds()->create([
            'started_at' => now()->subMinutes(2),
            'round_number' => 1
        ]);

        $round2_2 = $game2->rounds()->create([
            'started_at' => now()->subMinutes(1),
            'round_number' => 2
        ]);

        $round2_3 = $game2->rounds()->create([
            'started_at' => null,
            'round_number' => 3
        ]);

        $eagerGames = Game::whereIn('id', [$game1->id, $game2->id])->with('eagerCurrentRound')->get();

        $this->assertEquals($round1_2->round_number, $eagerGames[0]->eagerCurrentRound->round_number);
        $this->assertEquals($round2_2->round_number, $eagerGames[1]->eagerCurrentRound->round_number);
	}

}
