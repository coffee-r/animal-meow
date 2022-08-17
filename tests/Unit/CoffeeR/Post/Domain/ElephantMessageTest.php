<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\CoffeeR\Post\Domain\ElephantMessage;
use Doctrine\Common\Cache\Psr6\InvalidArgument;

class ElephantMessageTest extends TestCase
{
    public function test_blank_message()
    {
        $this->expectException(\InvalidArgumentException::class);
        $elephantMessage = new ElephantMessage('');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_message_length_limit_within()
    {
        $message = '';
        for ($i=0;$i<120;$i++) {
            $message .= 'ぱ';
        }

        $elephantMessage = new ElephantMessage($message);
    }

    public function test_message_length_limit_over()
    {
        $message = '';
        for ($i=0;$i<121;$i++) {
            $message .= 'ぱ';
        }

        $this->expectException(\InvalidArgumentException::class);
        $elephantMessage = new ElephantMessage($message);
    }

    public function test_only_space_message()
    {
        $message = ' 　';

        $this->expectException(\InvalidArgumentException::class);
        $elephantMessage = new ElephantMessage($message);
    }

    public function test_non_available_message()
    {
        $message = 'あ';

        $this->expectException(\InvalidArgumentException::class);
        $elephantMessage = new ElephantMessage($message);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_available_emoji_message()
    {
        $message = '🐘';

        $elephantMessage = new ElephantMessage($message);
    }

    /**
     * 正常系
     */
    public function test_normal_message()
    {
        $message = 'ぱお〜ん 🐘';
        $elephantMessage = new ElephantMessage($message);
        $this->assertEquals('ぱお〜ん 🐘', $elephantMessage->toString());
    }
}
