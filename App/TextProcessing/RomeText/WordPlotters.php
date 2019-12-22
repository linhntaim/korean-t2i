<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-19
 * Time: 11:43
 */

namespace App\TextProcessing\RomeText;

use App\TextProcessing\WordPlotter;
use App\TextProcessing\WordPlotters as BaseWordPlotters;

class WordPlotters extends BaseWordPlotters
{
    public function insertMany(array $listOfWordParts)
    {
        foreach ($listOfWordParts as $wordPart) {
            $this->insert(str_split($wordPart));
            $this->increaseWidths();
        }
        $this->decreaseWidths();
    }

    public function insert(array $wordParts)
    {
        foreach ($wordParts as $wordPart) {
            $this->pushToPlotters($this->createBlock($wordPart));
            $this->increaseWidths();
        }
    }

    public function createBlock($char)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = $this->height;
        $plotter->char = $char;
        return $plotter;
    }
}