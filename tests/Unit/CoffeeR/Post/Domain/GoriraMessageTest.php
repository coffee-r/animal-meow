<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\CoffeeR\Post\Domain\goriraMessage;
use Doctrine\Common\Cache\Psr6\InvalidArgument;

class goriraMessageTest extends TestCase
{
    public function test_blank_message()
    {
        $this->expectException(\InvalidArgumentException::class);
        $goriraMessage = new GoriraMessage('');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_message_length_limit_within()
    {
        $message = '';
        for($i=0;$i<120;$i++){
            $message .= 'う';
        }
        
        $goriraMessage = new GoriraMessage($message);
    }

    public function test_message_length_limit_over()
    {
        $message = '';
        for($i=0;$i<121;$i++){
            $message .= 'う';
        }

        $this->expectException(\InvalidArgumentException::class);
        $goriraMessage = new GoriraMessage($message);
    }

    public function test_only_space_message()
    {
        $message = ' 　';

        $this->expectException(\InvalidArgumentException::class);
        $goriraMessage = new GoriraMessage($message);
    }

    public function test_non_available_message()
    {
        $message = 'ば';

        $this->expectException(\InvalidArgumentException::class);
        $goriraMessage = new GoriraMessage($message);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_available_emoji_message()
    {
        $message = '🦍🍌';

        $goriraMessage = new GoriraMessage($message);
    }

    /**
     * 正常系
     */
    public function test_normal_message()
    {
        $message = 'ウッホー 🦍🍌';
        $goriraMessage = new GoriraMessage($message);
        $this->assertEquals('ウッホー 🦍🍌', $goriraMessage->toString());
    }
}
