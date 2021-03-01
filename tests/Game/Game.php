<?php

namespace Fam\Test\Game;

use Fam\FamRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Game extends Model
{
    protected $guarded = [];

    public static function migrate()
    {
        Schema::create('games', function(Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function currentRound()
    {
        return $this
            ->rounds()  // where game_id === $game->id
            ->started() // where started_at isPast
            ->orderByDesc('round_number') // orderBy
            ->limit(1)  // limit
            ->asRelationship();

        $wheres = [
            game_id === $game->id,
            started_at <= isPast
        ]
    }

    public function eagerCurrentRound()
    {
        return $this
            ->rounds()
            ->started()
            ->orderByDesc('round_number')
            ->limit(1)
            ->asRelationship()
            ->eagerMatch('rounds.game_id', 'games.id');





            ->whenEager(function($query, $parents) {
                $ids = Game::whereIn('id', collect($parents)->pluck('id'))
                    ->selectSub(Round::select('id')
                    ->whereColumn('game_id', 'games.id')
                    ->where('started_at', '<=', now())
                    ->orderByDesc('round_number')
                    ->limit(1)
                    , 'current_game_id')
                    ->pluck('current_game_id');

                $query->whereIn('id', $ids);
            });
    }

    public function scopeWithCurrentRound($query)
    {
        $query->addSelect([
            'current_round_id' => Round::select('id')
                ->whereColumn('game_id', 'games.id')
                ->where('started_at', '<=', now())
                ->latest('round_number')
                ->take(1),
        ]);
    }
}
