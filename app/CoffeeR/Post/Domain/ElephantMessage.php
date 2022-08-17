<?php

namespace App\CoffeeR\Post\Domain;

/**
 * ぞうのメッセージ
 */
class ElephantMessage implements AnimalMessageInterface
{
    private string $value;

    public const AVAILABLE_WORDS = [
        'ぱ',
        'お',
        'ぉ',
        'ん',
        'っ',
        'パ',
        'オ',
        'ォ',
        'ン',
        'ッ',
        '〜',
        'ー',
        '！',
        '？',
        '🐘',
        ' ',
    ];

    public function __construct(string $value)
    {
        // ブランク文字は許容しない
        if (mb_strlen($value) === 0) {
            throw new \InvalidArgumentException();
        }

        // 120文字を超える文字は許容しない
        if (mb_strlen($value) > 120) {
            throw new \InvalidArgumentException();
        }

        // 空白文字は許容しない
        if (ctype_space($value) === true) {
            throw new \InvalidArgumentException();
        }

        // 入力された文字列を1文字ずつに分割
        $splited_words = mb_str_split($value);

        // 利用できる文字以外は許容しない
        foreach ($splited_words as $key => $word) {
            if (in_array($word, self::AVAILABLE_WORDS, true) === false) {
                throw new \InvalidArgumentException();
            }
        }

        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
