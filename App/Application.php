<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-18
 * Time: 20:09
 */

namespace App;

use App\TextProcessing\KoreanText\TextParser;
use App\TextProcessing\KoreanText\WordPlotters as KoreanWordPlotters;
use App\TextProcessing\RomeText\WordPlotters as RomeWordPlotters;

class Application
{
    private static $instance;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

    protected $stringParam;

    private function __construct()
    {
        $this->stringParam = isset($_GET['str']) ? $_GET['str'] : null;
    }

    public function run()
    {
        if (empty($this->stringParam)) {
            exit(1);
        }

        $parser = new TextParser();
        $this->responseImage($parser->parse($this->stringParam));
        exit(0);
    }

    protected function responseImage($source)
    {
        $font = fontPath('Default');

        $hanPlotters = new KoreanWordPlotters(40, 40);
        $hanPlotters->insertMany($source->stringSplit);
        $romePlotters = new RomeWordPlotters(10, 20);
        $romePlotters->insertMany($source->romeSplit);
        $imageWidth = $hanPlotters->getWidth() > $romePlotters->getWidth() ? $hanPlotters->getWidth() : $romePlotters->getWidth();
        $imageHeight = $hanPlotters->getHeight() + $romePlotters->getHeight() + 10;

        if (defined('DEBUG') && DEBUG == true) {
            print_r($source);
            echo PHP_EOL;
            print_r($font);
            echo PHP_EOL;
            print_r($romePlotters->getPlotters());
            echo PHP_EOL;
            print_r($hanPlotters->getPlotters());
            echo PHP_EOL;
            print_r($imageWidth);
            echo PHP_EOL;
            print_r($imageHeight);
            die();
        }

        // create image resource
        $image = imagecreatetruecolor($imageWidth, $imageHeight);
        // fill image with white background
        imagefilledrectangle($image, 0, 0, $imageWidth, $imageHeight, imagecolorallocate($image, 255, 255, 255));
        foreach ($romePlotters->getPlotters() as $plotter) {
            imagettftext(
                $image,
                $plotter->size,
                0,
                $plotter->x,
                $plotter->y,
                imagecolorallocate($image, $plotter->color[0], $plotter->color[1], $plotter->color[2]),
                $font,
                $plotter->char
            );
        }
        $deltaHeight = $romePlotters->getHeight() + 10;
        foreach ($hanPlotters->getPlotters() as $plotter) {
            imagettftext(
                $image,
                $plotter->size,
                0,
                $plotter->x,
                $plotter->y + $deltaHeight,
                imagecolorallocate($image, $plotter->color[0], $plotter->color[1], $plotter->color[2]),
                $font,
                $plotter->char
            );
        }

        $this->outputImage($image);
    }

    protected function outputImage($image)
    {
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}