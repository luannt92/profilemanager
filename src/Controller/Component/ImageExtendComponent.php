<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class ImageExtendComponent extends Component
{
    public $image;

    public $width;

    public $height;

    public $imageResized;

    /*
     * @param $action - the conversion type: resize (default) @param $src -
     * source image path @param $destFolder - the folder where the image is
     * @param $newWidth - the max width or crop width @param $newHeight - the
     * max height or crop height @param $params
     */
    function makeImage(
        $action = 'resize',
        $src,
        $dest,
        $newWidth = false,
        $newHeight = false,
        $params = array()
    ) {
        // default param for action
        $default = array(
            'degree' => 90,
            'startX' => 0,
            'startY' => 0,
        );
        $default = array_merge($default, $params);

        if ( ! file_exists($src)) {
            return false;
        }
        // *** Open up the file
        $this->image = $this->openImage($src);
        // *** Get width and height
        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);

        switch ($action) {
            // Maintains the aspect ration of the image and makes sure that it
            // fits
            // within the maxW(newWidth) and maxH(newHeight) (thus some side
            // will be smaller)
            case 'resizeWithRatio':
                $this->resizeImage($newWidth, $newHeight, 'auto');
                break;
            case 'resizeCrop':
                if (isset($params['left']) && isset($params['top'])
                    && isset($params['width'])
                    && isset($params['height'])
                ) {
                    $startX             = intval(round($params['left']
                        * $this->width / $params['width']));
                    $startY             = intval(round($params['top']
                        * $this->height / $params['height']));
                    $oldWidth           = intval(round($newWidth * $this->width
                        / $params['width']));
                    $oldHeight          = intval(round($newHeight
                        * $this->height / $params['height']));
                    $this->imageResized = imagecreatetruecolor($newWidth,
                        $newHeight);
                    imagealphablending($this->imageResized, false);
                    imagesavealpha($this->imageResized, true);
                    imagecopyresampled($this->imageResized, $this->image, 0, 0,
                        $startX, $startY, $newWidth, $newHeight, $oldWidth,
                        $oldHeight);
                } else {
                    $this->resizeImage($newWidth, $newHeight, 'crop');
                }
                break;
            case 'crop':
                $this->crop($newWidth, $newHeight, $newWidth, $newHeight,
                    $params);
                break;
            // Resize image with fixed size
            case 'resize':
            default:
                if ( ! $newWidth) {
                    $newWidth = $this->width;
                }
                if ( ! $newHeight) {
                    $newHeight = $this->height;
                }
                $this->resizeImage($newWidth, $newHeight);
        }

        // put old image on top of new image
        switch ($action) {
            case 'rotate':
                if (isset($params['degree'])) {
                    $degree = $params['degree'];
                } else {
                    $degree = 90;
                }
                $this->imageResized = imagerotate($this->imageResized,
                    $default['degree'], 0);
                break;
            case 'sepia':
                $percent = '80';
                imagefilter($this->imageResized, IMG_FILTER_GRAYSCALE);
                imagefilter($this->imageResized, IMG_FILTER_BRIGHTNESS, -30);
                imagefilter($this->imageResized, IMG_FILTER_COLORIZE, 90, 55,
                    30);
                break;
            case 'monochrome':
                for ($c = 0; $c < 256; $c++) {
                    $palette[$c] = imagecolorallocate($this->imageResized, $c,
                        $c, $c);
                }
                // Reads the origonal colors pixel by pixel
                for ($y = 0; $y < $newHeight; $y++) {
                    for ($x = 0; $x < $newWidth; $x++) {
                        $rgb = imagecolorat($this->image, $x, $y);
                        $r   = ($rgb >> 16) & 0xFF;
                        $g   = ($rgb >> 8) & 0xFF;
                        $b   = $rgb & 0xFF;

                        // This is where we actually use yiq to modify our rbg
                        // values, and then convert them to our grayscale
                        // palette
                        $gs = ($r * 0.299) + ($g * 0.587) + ($b * 0.114);
                        imagesetpixel($this->imageResized, $x, $y,
                            $palette[$gs]);
                    }
                }
                break;
        }

        $this->saveImage($dest);

        return true;
    }

    /**
     * @param $file
     *
     * @return bool|resource
     */
    private function openImage($file)
    {
        // *** Get extension
        $extension = strtolower(strrchr($file, '.'));
        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($file);
                break;
            case '.gif':
                $img = @imagecreatefromgif($file);
                break;
            case '.png':
                $img = @imagecreatefrompng($file);
                break;
            default:
                $img = false;
                break;
        }

        return $img;
    }

    /**
     * @param        $newWidth
     * @param        $newHeight
     * @param string $action
     */
    public function resizeImage($newWidth, $newHeight, $action = 'exact')
    {
        // *** Get optimal width and height - based on $action
        $optionArray   = $this->getDimensions($newWidth, $newHeight,
            strtolower($action));
        $optimalWidth  = $optionArray['optimalWidth'];
        $optimalHeight = $optionArray['optimalHeight'];
        // *** Resample - create image canvas of x, y size
        $this->imageResized = imagecreatetruecolor($optimalWidth,
            $optimalHeight);
        imagealphablending($this->imageResized, false);
        imagesavealpha($this->imageResized, true);
        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0,
            $optimalWidth, $optimalHeight, $this->width, $this->height);
        // *** if action is 'crop', then crop too
        if ($action == 'crop') {
            $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        }
    }

    /**
     * @param $newWidth
     * @param $newHeight
     * @param $action
     *
     * @return array
     */
    private function getDimensions($newWidth, $newHeight, $action)
    {
        switch ($action) {
            case 'exact':
                $optimalWidth  = $newWidth;
                $optimalHeight = $newHeight;
                break;
            case 'portrait':
                $optimalWidth  = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
                break;
            case 'landscape':
                $optimalWidth  = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
                break;
            case 'auto':
                $optionArray   = $this->getSizeByAuto($newWidth, $newHeight);
                $optimalWidth  = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray   = $this->getOptimalCrop($newWidth, $newHeight);
                $optimalWidth  = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
        }

        return array(
            'optimalWidth'  => $optimalWidth,
            'optimalHeight' => $optimalHeight,
        );
    }

    /**
     * @param $newHeight
     *
     * @return mixed
     */
    private function getSizeByFixedHeight($newHeight)
    {
        $ratio    = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;

        return $newWidth;
    }

    /**
     * @param $newWidth
     *
     * @return mixed
     */
    private function getSizeByFixedWidth($newWidth)
    {
        $ratio     = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;

        return $newHeight;
    }

    /**
     * @param $newWidth
     * @param $newHeight
     *
     * @return array
     */
    private function getSizeByAuto($newWidth, $newHeight)
    {
        if (($newWidth && ! $newHeight) || ($this->height < $this->width)) {
            // *** Image to be resized is wider (landscape)
            $optimalWidth  = $newWidth;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth);
        } elseif (( ! $newWidth && $newHeight)
            || ($this->height > $this->width)
        ) {
            // *** Image to be resized is taller (portrait)
            $optimalWidth  = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight = $newHeight;
        } else {
            // *** Image to be resizerd is a square
            if ($newHeight < $newWidth) {
                $optimalWidth  = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            } else if ($newHeight > $newWidth) {
                $optimalWidth  = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
            } else {
                // *** Sqaure being resized to a square
                $optimalWidth  = $newWidth;
                $optimalHeight = $newHeight;
            }
        }

        return array(
            'optimalWidth'  => $optimalWidth,
            'optimalHeight' => $optimalHeight,
        );
    }

    /**
     * @param $newWidth
     * @param $newHeight
     *
     * @return array
     */
    private function getOptimalCrop($newWidth, $newHeight)
    {
        $heightRatio = $this->height / $newHeight;
        $widthRatio  = $this->width / $newWidth;
        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }
        $optimalHeight = $this->height / $optimalRatio;
        $optimalWidth  = $this->width / $optimalRatio;

        return array(
            'optimalWidth'  => $optimalWidth,
            'optimalHeight' => $optimalHeight,
        );
    }

    /**
     * @param       $optimalWidth
     * @param       $optimalHeight
     * @param       $newWidth
     * @param       $newHeight
     * @param array $params
     */
    private function crop(
        $optimalWidth,
        $optimalHeight,
        $newWidth,
        $newHeight,
        $params = array()
    ) {
        // *** Crop from exact position of image.
        if ( ! empty($params) && isset($params['startX'])
            && isset($params['startY'])
        ) {
            $cropStartX = $params['startX'];
            $cropStartY = $params['startY'];
            $crop       = $this->image;
        } else {
            // *** Default crop from center after resize
            $cropStartX = ($optimalWidth / 2) - ($newWidth / 2);
            $cropStartY = ($optimalHeight / 2) - ($newHeight / 2);
            $crop       = $this->imageResized;
        }

        $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($this->imageResized, false);
        imagesavealpha($this->imageResized, true);
        imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX,
            $cropStartY, $newWidth, $newHeight, $newWidth, $newHeight);
    }

    /**
     * @param        $savePath
     * @param string $imageQuality
     */
    public function saveImage($savePath, $imageQuality = "100")
    {
        // *** Get extension
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);
        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                }
                break;
            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                }
                break;
            case '.png':
                // *** Scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality / 100) * 9);
                // *** Invert quality setting as 0 is best, not 9
                $invertScaleQuality = 9 - $scaleQuality;
                if (imagetypes() & IMG_PNG) {
                    imagepng($this->imageResized, $savePath,
                        $invertScaleQuality);
                }
                break;
            // ... etc
            default:
                // *** No extension - No save.
                break;
        }
        imagedestroy($this->imageResized);
    }
}

?>