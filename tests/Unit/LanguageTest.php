<?php

namespace Tests\Unit;

use App\Translation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageTest extends TestCase
{

    public function testExample()
    {
        $word = 'الطلب';
        $language = 2;
        $this->assertEquals('ticket',t($word,$language));
    }
}
