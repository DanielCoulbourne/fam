<?php

namespace Fam\Test\HasMany;

use Fam\FamRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Model
{
    protected $guarded = [];

    public static function migrate()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    public function posts()
    {
        return FamRelation::fromBuilder(Post::where('user_id', $this->id), $this);
    }
}
