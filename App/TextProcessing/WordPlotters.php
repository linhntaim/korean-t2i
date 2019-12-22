<?php

/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-19
 * Time: 11:39
 */

namespace App\TextProcessing;

abstract class WordPlotters
{
    protected $widths;

    protected $size;
    protected $width;
    protected $height;
    protected $spacing;

    protected $plotters;

    public function __construct($width, $height)
    {
        $this->widths = 0;
        $this->width = $width;
        $this->size = intval($height / 4 * 3);
        $this->height = $height;
        $this->spacing = intval(0.1 * $this->width);
        $this->plotters = [];
    }

    public function getWidth()
    {
        return $this->widths;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getPlotters()
    {
        return $this->plotters;
    }

    protected function pushToPlotters(WordPlotter $plotter)
    {
        $this->plotters[] = $plotter;
    }

    protected function increaseWidths()
    {
        $this->widths += $this->width + $this->spacing;
    }

    protected function decreaseWidths()
    {
        $this->widths -= ($this->width + $this->spacing);
    }

    public abstract function insertMany(array $listOfWordParts);

    public abstract function insert(array $wordParts);
}