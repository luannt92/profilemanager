<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * MyLib component
 */
class MyLibComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * rand_string method
     *
     * @param $length
     *
     * @return null|string
     */
    public function randString($length)
    {
        $str   = null;
        $chars = "0123456789";
        $size  = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }

        return $str;
    }

    /**
     * randPassword method
     *
     * @param $length
     *
     * @return null|string
     */
    public function randPassword($length)
    {
        $str  = null;
        $chars
              = "0123456789ABCDEFGHIKLMNOPQRSTUVXYZWabcdefghiklmnopqrstuvxyzw*&^%$#@!()";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }

        return $str;
    }

    /**
     * encript_md5 method
     *
     * @param $str
     *
     * @return string
     */
    public function encriptCode($str)
    {
        $str = md5($str);
        $str = substr($str, 2, 6);

        return md5($str);
    }

    /**
     * createCode method
     *
     * @param null $code
     */
    public function createCode($code = null)
    {
        $captcha    = $this->encriptCode($code);
        $captcha    = substr($captcha, 0, 4);
        $captcha    = strtoupper($captcha);
        $code_name  = '84' . ' ' . $code . ' ' . $captcha;
        $width      = 172;
        $height     = 68;
        $height_col = $height - 20;

        $image = imagecreate($width, $height); // create image
        // create color
        $white = imagecolorallocate($image, 0, 0, 0);
        $black = imagecolorallocate($image, 255, 255, 255);
        $grey  = imagecolorallocate($image, 0, 0, 0);

        imagefill($image, 0, 0, $black); // background
        imagestring($image, 7, 3, $height_col + 2, $code_name,
            $white); // insert code into image
        imagerectangle($image, 0, 0, $width - 1, $height - 1,
            $grey); // create img

        // create code country
        for ($i = 2; $i < 22; $i++) {
            if ($i % 2 == 0) {
                imageline($image, $i, 0, $i, $height_col, $grey);
            }
            if ($i % 8 == 0) {
                $i++;
                imageline($image, $i, 0, $i, $height_col, $grey);
            }
        }
        $i++;
        imageline($image, $i, 0, $i, $height_col + 15, $grey);
        $i++;
        imageline($image, $i, 0, $i, $height_col + 15, $grey);
        $i++;
        // code name: code invoice
        $for = $i + 100;
        for ($i; $i < $for; $i++) {
            if ($i % 3 == 0) {
                imageline($image, $i, 0, $i, $height_col, $grey);
            } else if ($i % 8 == 0) {
                imageline($image, $i, 0, $i, $height_col, $grey);
            }
        }
        imageline($image, $i, 0, $i, $height_col + 15, $grey);
        $i++;
        imageline($image, $i, 0, $i, $height_col + 15, $grey);
        $i++;
        for ($i; $i <= 168; $i++) {
            if ($i % 3 == 0 || $i % 5 == 0 || $i % 7 == 0) {
                imageline($image, $i, 0, $i, $height_col, $grey);
            }
        }
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }
}
