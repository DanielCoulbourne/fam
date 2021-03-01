<?php

namespace Fam\Test\HasMany;

use Fam\Test\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class HasManyBelongsToTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        User::migrate();
        Post::migrate();
    }

    public function test_method_access_returns_correct_query_builder() : void
    {
        $user = User::create();

        $post = Post::create(['user_id' => $user->id]);

        // HasMany Assertions
        $this->assertInstanceOf(Builder::class, $user->posts()->getQuery());

        $this->assertInstanceOf(Collection::class, $user->posts()->get());
        $this->assertCount(1, $user->posts()->get());

        $this->assertInstanceOf(Post::class, $user->posts()->first());
        $this->assertEquals($user->id, $user->posts()->first()->user_id);


        // BelongsTo Assertions
        $this->assertInstanceOf(Builder::class, $post->user()->getQuery());

        $this->assertInstanceOf(Collection::class, $post->user()->get());
        $this->assertCount(1, $post->user()->get());

        $this->assertInstanceOf(User::class, $post->user()->first());
        $this->assertEquals($user->id, $post->user()->first()->user_id);
    }

    public function test_property_access_returns_correct_collection() : void
    {
        $user = User::create();

        Post::create(['user_id' => $user->id]);

        $this->assertInstanceOf(Collection::class, $user->posts);

        $this->assertInstanceOf(Collection::class, $user->posts()->get());
        $this->assertCount(1, $user->posts()->get());

        $this->assertInstanceOf(Post::class, $user->posts()->first());
        $this->assertEquals($user->id, $user->posts()->first()->user_id);
    }
}
