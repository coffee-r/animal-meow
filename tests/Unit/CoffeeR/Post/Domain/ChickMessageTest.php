<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\CoffeeR\Post\Domain\ChickMessage;
use Doctrine\Common\Cache\Psr6\InvalidArgument;

class ChickMessageTest extends TestCase
{
    public function test_blank_message()
    {
        $this->expectException(\InvalidArgumentException::class);
        $chickMessage = new ChickMessage('');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_message_length_limit_within()
    {
        $message = '';
        for ($i=0;$i<120;$i++) {
            $message .= 'ピ';
        }

        $chickMessage = new ChickMessage($message);
    }

    public function test_message_length_limit_over()
    {
        $message = '';
        for ($i=0;$i<121;$i++) {
            $message .= 'ピ';
        }

        $this->expectException(\InvalidArgumentException::class);
        $chickMessage = new ChickMessage($message);
    }

    public function test_only_space_message()
    {
        $message = ' 　';

        $this->expectException(\InvalidArgumentException::class);
        $chickMessage = new ChickMessage($message);
    }

    public function test_non_available_message()
    {
        $message = 'あ';

        $this->expectException(\InvalidArgumentException::class);
        $chickMessage = new ChickMessage($message);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_available_emoji_message()
    {
        $message = '🐥';

        $chickMessage = new ChickMessage($message);
    }

    /**
     * 正常系
     */
    public function test_normal_message()
    {
        $message = 'ぴよピヨ 🐥';
        $chickMessage = new ChickMessage($message);
        $this->assertEquals('ぴよピヨ 🐥', $chickMessage->toString());
    }
}
