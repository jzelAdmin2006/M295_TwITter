<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class I5Test extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /*public function test_endpoint_get_users_top_there_is_no_n1_problem(): void
    {

        DB::enableQueryLog();

        $this->get('/api/users/top');

        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()), 'There is a N+1 problem present, too many queries are executed.');
    }

    public function test_endpoint_get_users_new_there_is_no_n1_problem(): void
    {

        DB::enableQueryLog();

        $this->get('/api/users/new');

        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()), 'There is a N+1 problem present, too many queries are executed.');
    }*/ // todo: fix this test
}
