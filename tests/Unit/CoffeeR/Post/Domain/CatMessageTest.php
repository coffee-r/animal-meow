<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\CoffeeR\Post\Domain\CatMessage;
use Doctrine\Common\Cache\Psr6\InvalidArgument;

class CatMessageTest extends TestCase
{
    public function test_blank_message()
    {
        $this->expectException(\InvalidArgumentException::class);
        $catMessage = new CatMessage('');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_message_length_limit_within()
    {
        $message = '';
        for ($i=0;$i<120;$i++) {
            $message .= 'に';
        }

        $catMessage = new CatMessage($message);
    }

    public function test_message_length_limit_over()
    {
        $message = '';
        for ($i=0;$i<121;$i++) {
            $message .= 'に';
        }

        $this->expectException(\InvalidArgumentException::class);
        $catMessage = new CatMessage($message);
    }

    public function test_only_space_message()
    {
        $message = ' 　';

        $this->expectException(\InvalidArgumentException::class);
        $catMessage = new CatMessage($message);
    }

    public function test_non_available_message()
    {
        $message = 'あ';

        $this->expectException(\InvalidArgumentException::class);
        $catMessage = new CatMessage($message);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_available_emoji_message()
    {
        $message = '🐱';

        $catMessage = new CatMessage($message);
    }

    /**
     * 正常系
     */
    public function test_normal_message()
    {
        $message = 'にゃ〜ん！ 🐱';
        $catMessage = new CatMessage($message);
        $this->assertEquals('にゃ〜ん！ 🐱', $catMessage->toString());
    }
}
