<?php namespace Larablocks\Pigeon\Tests;

use Illuminate\Support\Facades\Config;
use Larablocks\Pigeon\SwiftMailer;
use Mockery;
use PHPUnit_Framework_TestCase;

class SwiftMailerTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function testPretend()
    {
        $layout = Mockery::mock('Larablocks\Pigeon\MessageLayout');
        $swiftmailer = new SwiftMailer($layout);

        $this->assertEquals($swiftmailer, $swiftmailer->pretend());
        $this->assertEquals($swiftmailer, $swiftmailer->pretend(false));
        $this->assertFalse($swiftmailer->pretend(2));
    }

    protected function mockPigeonInterface()
    {
        $pigeon = Mockery::mock('Larablocks\Pigeon\PigeonInterface');
        return $pigeon;
    }



}