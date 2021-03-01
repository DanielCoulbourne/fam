<?php

namespace Fam\Test\HasMany;

use Fam\FamRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Post extends Model
{
    protected $guarded = [];

    public static function migrate()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    public function user()
    {
        return FamRelation::fromBuilder(User::where('id', $this->user_id), $this);
    }
}
