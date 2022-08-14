<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\CoffeeR\Post\Domain\DogMessage;
use Doctrine\Common\Cache\Psr6\InvalidArgument;

class DogMessageTest extends TestCase
{
    public function test_blank_message()
    {
        $this->expectException(\InvalidArgumentException::class);
        $dogMessage = new DogMessage('');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_message_length_limit_within()
    {
        $message = '';
        for($i=0;$i<120;$i++){
            $message .= 'わ';
        }
        
        $dogMessage = new DogMessage($message);
    }

    public function test_message_length_limit_over()
    {
        $message = '';
        for($i=0;$i<121;$i++){
            $message .= 'わ';
        }

        $this->expectException(\InvalidArgumentException::class);
        $dogMessage = new DogMessage($message);
    }

    public function test_only_space_message()
    {
        $message = ' 　';

        $this->expectException(\InvalidArgumentException::class);
        $dogMessage = new DogMessage($message);
    }

    public function test_non_available_message()
    {
        $message = 'が';

        $this->expectException(\InvalidArgumentException::class);
        $dogMessage = new DogMessage($message);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_available_emoji_message()
    {
        $message = '🐶';

        $dogMessage = new DogMessage($message);
    }

    /**
     * 正常系
     */
    public function test_normal_message()
    {
        $message = 'わんわんお！ 🐶';
        $dogMessage = new DogMessage($message);
        $this->assertEquals('わんわんお！ 🐶', $dogMessage->toString());
    }
}
