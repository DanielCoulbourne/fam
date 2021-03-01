<?php

namespace Fam\Test\Game;

use Fam\FamRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Round extends Model
{
	protected $guarded = [];

	public static function migrate()
	{
		Schema::create('rounds', function(Blueprint $table) {
			$table->id();
			$table->timestamp('started_at')->nullable();
			$table->integer('round_number');
			$table->foreignIdFor(Game::class);
			$table->timestamps();
		});
	}

	public function game()
	{
		return $this->belongsTo(Game::class);
	}

    public function scopeStarted($query)
    {
        return $query->where('started_at', '<=', now());
	}
}
