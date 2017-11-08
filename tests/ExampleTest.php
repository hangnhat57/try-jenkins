<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Loravel');
    }

    public function testFeatureB()
    {
        $this->visit('/')
             ->see('Feature B');
    }

    public function testFeatureA()
    {
        $this->visit('/')
             ->see('Go to Google');
    }

    public function testFeature6()
    {
        $this->visit('/')
             ->see('Changed by feature 6');
    }
}
