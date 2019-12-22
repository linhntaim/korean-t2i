<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-18
 * Time: 22:32
 */

namespace App\TextProcessing\KoreanText;


class WordAnalyzer
{
    const TYPE_H_2 = 0;
    const TYPE_V_2 = 1;
    const TYPE_H_3 = 2;
    const TYPE_V_3 = 3;

    protected static $horizontalVowel = ['ㅏ', 'ㅑ', 'ㅓ', 'ㅕ', 'ㅣ', 'ㅔ',];
    protected static $verticalVowel = ['ㅗ', 'ㅛ', 'ㅠ', 'ㅜ', 'ㅡ',];

    public function process(array $wordParts)
    {
        $countWordParts = count($wordParts);
        if ($countWordParts == 2 || $countWordParts == 3) {
            if ($countWordParts == 3 && empty($wordParts[2])) {
                unset($wordParts[2]);
                $countWordParts = 2;
            }
            if (in_array($wordParts[1], self::$horizontalVowel)) {
                return $countWordParts == 2 ? self::TYPE_H_2 : self::TYPE_H_3;
            } elseif (in_array($wordParts[1], self::$verticalVowel)) {
                return $countWordParts == 2 ? self::TYPE_V_2 : self::TYPE_V_3;
            }
        }
        return false;
    }
}