<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-18
 * Time: 23:15
 */

namespace App\TextProcessing;


class WordPlotter
{
    public $size;
    public $x;
    public $y;
    public $char;
    public $color;

    public function __construct()
    {
        $this->color = [rand(0, 255), rand(0, 255), rand(0, 255)];
    }
}