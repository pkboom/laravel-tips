<?php

namespace Image\Filters;

use Intervention\Image\Facades\Image as Img;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class MergeFilter implements FilterInterface
{
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function applyFilter(Image $baseImage)
    {
        $canvasY = $baseImage->height() + $this->image->height();

        $baseImageWidth = $baseImage->width();
        $imageWdith = $this->image->width();
        $canvasX = $baseImageWidth > $imageWdith ? $baseImageWidth : $imageWdith;

        $canvas = Img::canvas($canvasX, $canvasY, '#ffffff');

        $canvas->insert($baseImage, 'top-left');
        $canvas->insert($this->image, 'top-left', 0, $baseImageY);

        return $canvas;
    }
}
