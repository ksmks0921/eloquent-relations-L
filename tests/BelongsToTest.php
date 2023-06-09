<?php

namespace Tests;

use Tests\Models\Comment;
use Tests\Models\User;

class BelongsToTest extends TestCase
{
    public function testLazyLoading()
    {
        $locale = User::first()->locale;

        $this->assertEquals(11, $locale->id);
    }

    public function testEagerLoading()
    {
        $users = User::with('locale')->get();

        $this->assertEquals(11, $users[0]->locale->id);
    }

    public function testLazyEagerLoading()
    {
        $users = User::all()->load('locale');

        $this->assertEquals(11, $users[0]->locale->id);
    }

    public function testExistenceQuery()
    {
        $users = User::has('locale')->get();

        $this->assertEquals([21], $users->pluck('id')->all());
    }

    public function testExistenceQueryForSelfRelation()
    {
        $comments = Comment::has('parent')->get();

        $this->assertEquals([42], $comments->pluck('id')->all());
    }

    public function testAssociate()
    {
        $user = (new User())->locale()->associate(11);

        $this->assertEquals(11, $user->locale->id);
    }

    public function testDissociate()
    {
        $user = User::first()->locale()->dissociate();

        $this->assertNull($user->locale);
    }
}
