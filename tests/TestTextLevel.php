<?php

use App\TextLevel;
use PHPUnit\Framework\TestCase;
use DaveChild\TextStatistics as TS;

class TestTextLevel extends TestCase
{
    public function testOnlyString()
    {
        $this->assertFalse(false);
        $textStatistics = new TS\TextStatistics;
        $textStatistics->wordCount(67);
    }

    public function testWord()
    {
        $textStatistics = new TS\TextStatistics;
        $this->assertEquals($textStatistics->wordCount('Je suis une phrase simple'), 5);
    }

    public function testSentence()
    {
        $textStatistics = new TS\TextStatistics;
        $this->assertEquals($textStatistics->sentenceCount('Je suis une phrase simple. Je suis une autre phrase'), 2);
    }

    public function testSyllable()
    {
        $textStatistics = new TS\TextStatistics;
        $this->assertEquals($textStatistics->syllableCount('Banana'), 3);
    }

    public function testLevel()
    {
        $levelReading = new TextLevel();
        $this->assertEquals($levelReading->levelReading(1, 8, 11), 72);
    }
}