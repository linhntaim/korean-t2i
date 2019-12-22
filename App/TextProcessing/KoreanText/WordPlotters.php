<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-18
 * Time: 23:06
 */

namespace App\TextProcessing\KoreanText;

use App\TextProcessing\WordPlotter;
use App\TextProcessing\WordPlotters as BaseWordPlotters;

class WordPlotters extends BaseWordPlotters
{
    protected $analyzer;

    public function __construct($width, $height)
    {
        parent::__construct($width, $height);

        $this->analyzer = new WordAnalyzer();
    }

    public function insertMany(array $listOfWordParts)
    {
        foreach ($listOfWordParts as $wordPart) {
            $this->insert($wordPart);
        }
    }

    public function insert(array $wordParts)
    {
        $result = $this->analyzer->process($wordParts);
        if ($result !== false) {
            switch ($result) {
                case WordAnalyzer::TYPE_H_2:
                    $this->plotters[] = $this->createBlock1($wordParts);
                    $this->plotters[] = $this->createBlock2($wordParts);
                    break;
                case WordAnalyzer::TYPE_H_3:
                    $this->plotters[] = $this->createBlock5($wordParts);
                    $this->plotters[] = $this->createBlock6($wordParts);
                    $this->plotters[] = $this->createBlock7($wordParts);
                    break;
                case WordAnalyzer::TYPE_V_2:
                    $this->plotters[] = $this->createBlock3($wordParts);
                    $this->plotters[] = $this->createBlock4($wordParts);
                    break;
                case WordAnalyzer::TYPE_V_3:
                    $this->plotters[] = $this->createBlock8($wordParts);
                    $this->plotters[] = $this->createBlock9($wordParts);
                    $this->plotters[] = $this->createBlock10($wordParts);
                    break;
            }
            $this->increaseWidths();
        }
    }

    public function createBlock1(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = $this->height;
        $plotter->char = $wordParts[0];
        return $plotter;
    }

    public function createBlock2(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = intval($this->widths + $this->width / 2);
        $plotter->y = $this->height;
        $plotter->char = $wordParts[1];
        return $plotter;
    }

    public function createBlock3(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = intval($this->height - $this->size / 5);
        $plotter->char = $wordParts[0];
        return $plotter;
    }

    public function createBlock4(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = intval($this->height + $this->size / 5);
        $plotter->char = $wordParts[1];
        return $plotter;
    }

    public function createBlock5(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = intval($this->height - $this->size / 3);
        $plotter->char = $wordParts[0];
        return $plotter;
    }

    public function createBlock6(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = intval($this->widths + $this->width / 2);
        $plotter->y = intval($this->height - $this->size / 3);
        $plotter->char = $wordParts[1];
        return $plotter;
    }

    public function createBlock7(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = intval($this->height + $this->size / 5);
        $plotter->char = $wordParts[2];
        return $plotter;
    }

    public function createBlock8(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = intval($this->height - $this->size / 2);
        $plotter->char = $wordParts[0];
        return $plotter;
    }

    public function createBlock9(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = $this->height;
        $plotter->char = $wordParts[1];
        return $plotter;
    }

    public function createBlock10(array $wordParts)
    {
        $plotter = new WordPlotter();
        $plotter->size = $this->size;
        $plotter->x = $this->widths;
        $plotter->y = intval($this->height + $this->size / 5);
        $plotter->char = $wordParts[2];
        return $plotter;
    }
}