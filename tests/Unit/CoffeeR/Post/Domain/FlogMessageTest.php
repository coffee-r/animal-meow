<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\CoffeeR\Post\Domain\FlogMessage;
use Doctrine\Common\Cache\Psr6\InvalidArgument;

class FlogMessageTest extends TestCase
{
    public function test_blank_message()
    {
        $this->expectException(\InvalidArgumentException::class);
        $flogMessage = new FlogMessage('');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_message_length_limit_within()
    {
        $message = '';
        for ($i=0;$i<120;$i++) {
            $message .= 'け';
        }

        $flogMessage = new FlogMessage($message);
    }

    public function test_message_length_limit_over()
    {
        $message = '';
        for ($i=0;$i<121;$i++) {
            $message .= 'け';
        }

        $this->expectException(\InvalidArgumentException::class);
        $flogMessage = new FlogMessage($message);
    }

    public function test_only_space_message()
    {
        $message = ' 　';

        $this->expectException(\InvalidArgumentException::class);
        $flogMessage = new FlogMessage($message);
    }

    public function test_non_available_message()
    {
        $message = 'あ';

        $this->expectException(\InvalidArgumentException::class);
        $flogMessage = new FlogMessage($message);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_available_emoji_message()
    {
        $message = '🐸';

        $flogMessage = new FlogMessage($message);
    }

    /**
     * 正常系
     */
    public function test_normal_message()
    {
        $message = 'ケロケロ〜ン🐸';
        $flogMessage = new FlogMessage($message);
        $this->assertEquals('ケロケロ〜ン🐸', $flogMessage->toString());
    }
}
