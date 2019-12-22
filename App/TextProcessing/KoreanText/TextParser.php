<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-18
 * Time: 19:37
 */

namespace App\TextProcessing\KoreanText;

class TextParser
{
    protected static $arrFirst = ['ㄱ', 'ㄲ', 'ㄴ', 'ㄷ', 'ㄸ', 'ㄹ', 'ㅁ', 'ㅂ', 'ㅃ', 'ㅅ', 'ㅆ', 'ㅇ', 'ㅈ', 'ㅉ', 'ㅊ', 'ㅋ', 'ㅌ', 'ㅍ', 'ㅎ'];
    protected static $arrFirstT = ['g', 'kk', 'n', 'd', 'tt', 'r', 'm', 'b', 'pp', 's', 'ss', '', 'j', 'jj', 'ch', 'k', 't', 'p', 'h'];
    protected static $arrSecond = ['ㅏ', 'ㅐ', 'ㅑ', 'ㅒ', 'ㅓ', 'ㅔ', 'ㅕ', 'ㅖ', 'ㅗ', 'ㅘ', 'ㅙ', 'ㅚ', 'ㅛ', 'ㅜ', 'ㅝ', 'ㅞ', 'ㅟ', 'ㅠ', 'ㅡ', 'ㅢ', 'ㅣ'];
    protected static $arrSecondT = ['a', 'ae', 'ya', 'yae', 'eo', 'e', 'yeo', 'ye', 'o', 'wa', 'wae', 'oe', 'yo', 'u', 'wo', 'we', 'wo', 'yu', 'eu', 'ui', 'i'];
    protected static $arrThird = ['', 'ㄱ', 'ㄲ', 'ㄳ', 'ㄴ', 'ㄵ', 'ㄶ', 'ㄷ', 'ㄹ', 'ㄺ', 'ㄻ', 'ㄼ', 'ㄽ', 'ㄾ', 'ㄿ', 'ㅀ', 'ㅁ', 'ㅂ', 'ㅄ', 'ㅅ', 'ㅆ', 'ㅇ', 'ㅈ', 'ㅊ', 'ㅋ', 'ㅌ', 'ㅍ', 'ㅎ'];
    protected static $arrThirdT = ['', 'k', 'ㄲ', 'k', 'n', 'n', 'n', 't', 'l', 'k', 'm', 'p', 's', 'l', 'l', 'l', 'm', 'p', 'p', 't', 't', 'ng', 't', 't', 'k', 't', 'p', 'ng'];

    public function parse($string)
    {
        $stringSplit = $this->splitString($string);

        $stW = ['', '', ''];;
        $romeSplit = [];
        for ($i = 0, $m = count($stringSplit); $i < $m; $i++) {
            $cuW = $stringSplit[$i];
            $edW = isset($stringSplit[$i + 1]) ? $stringSplit[$i + 1] : null;
            if (count($cuW) == 3) {
                $cuR = $this->splitRome($cuW, $stW, $edW);
            } else {
                $cuR = $cuW;
            }
            $stW = $cuW;
            $romeSplit[] = $cuR;
        }

        return $this->composeResult($string, $romeSplit, $stringSplit);
    }

    protected function composeResult($originalString, $romeSplit, $stringSplit)
    {
        $result = new \stdClass();
        $result->original = $originalString;
        $result->romeSplit = $romeSplit;
        $result->stringSplit = $stringSplit;
        return $result;
    }

    protected function splitString($string)
    {
        $stringSplit = [];
        for ($i = 0, $m = $this->strLen($string); $i < $m; $i++) {
            $stringSplit[] = $this->splitHan($this->charAt($string, $i));
        }
        return $stringSplit;
    }

    protected function splitRome($cuW, $stW, $edW)
    {
        if (empty($edW)) {
            $edW = ['', '', ''];
        }
        $thW = ['', '', ''];
        $thW[0] = $this->splitRomeFirstWord($cuW[0], $stW[2]);
        $thW[1] = $this->splitRomeSecondWord($cuW[1]);
        $thW[2] = $this->splitRomeThirdWord($cuW[2], $edW[0]);
        return implode('', $thW);
    }

    protected function splitRomeFirstWord($cuW, $stW)
    {
//        if ($cu_w == 'ㄱ') {
//            if ($st_w == '') {
//                return 'g';
//            } else {
//                return 'k';
//            }
//        }
        if ($cuW == 'ㄷ') {
            if (empty($stW)) {
                return 'd';
            } else {
                return 't';
            }
        } else if ($cuW == 'ㅂ') {
            if (empty($stW)) {
                return 'b';
            } else {
                return 'p';
            }
        } else if ($cuW == 'ㄹ') {
            if ($stW == 'ㄹ') {
                return 'l';
            } else {
                return 'r';
            }
        }
        for ($i = 0; $i < 19; $i++) {
            if ($cuW == self::$arrFirst[$i]) {
                return self::$arrFirstT[$i];
            }
        }
        return false;
    }

    protected function splitRomeSecondWord($cuW)
    {
        for ($i = 0; $i < 21; $i++) {
            if ($cuW == self::$arrSecond[$i]) return self::$arrSecondT[$i];
        }
        return false;
    }

    protected function splitRomeThirdWord($cuW, $edW)
    {
        if ($cuW == 'ㄺ') {
            if ($edW != 'ㄱ') {
                return 'k';
            } else {
                return 'l';
            }
        }
        for ($i = 0; $i < 28; $i++) {
            if ($cuW == self::$arrThird[$i]) return self::$arrThirdT[$i];
        }
        return false;
    }

    protected function splitHan($char)
    {
        $arr = $this->splitInt($char);
        if ($arr !== false) {
            return [self::$arrFirst[$arr[0]], self::$arrSecond[$arr[1]], self::$arrThird[$arr[2]]];
        } else {
            return $char;
        }
    }

    protected function splitInt($char)
    {
        $charSt = 44032;
        $charEd = 55203;
        if ($this->strLen($char) > 2) {
            $char = $this->charAt($char, 0);
        }
        $uniNum = $this->ord($this->charAt($char, 0));
        if ($uniNum < $charSt || $uniNum > $charEd) return false;
        $uniNum2 = $uniNum - $charSt;
        $arrFirstV = floor($uniNum2 / 588);
        $uniNum2 = $uniNum2 % 588;
        $arrSecondV = floor($uniNum2 / 28);
        $uniNum2 = $uniNum2 % 28;
        $arrThirdV = $uniNum2;
        return [$arrFirstV, $arrSecondV, $arrThirdV];
    }

    protected function charAt($string, $index)
    {
        return mb_substr($string, $index, 1, 'UTF-8');
    }

    protected function strLen($string)
    {
        return mb_strlen($string, 'UTF-8');
    }

    protected function ord($char)
    {
        $len = strlen($char);
        if ($len <= 0) return false;
        $h = ord($char{0});
        if ($h <= 0x7F) return $h;
        if ($h < 0xC2) return false;
        if ($h <= 0xDF && $len > 1) return ($h & 0x1F) << 6 | (ord($char{1}) & 0x3F);
        if ($h <= 0xEF && $len > 2) return ($h & 0x0F) << 12 | (ord($char{1}) & 0x3F) << 6 | (ord($char{2}) & 0x3F);
        if ($h <= 0xF4 && $len > 3) return ($h & 0x0F) << 18 | (ord($char{1}) & 0x3F) << 12 | (ord($char{2}) & 0x3F) << 6 | (ord($char{3}) & 0x3F);
        return false;
    }
}