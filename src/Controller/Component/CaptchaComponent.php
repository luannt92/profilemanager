<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * Captcha component
 */
class CaptchaComponent extends Component
{
    public $font = 'fonts/monofont.ttf';
    public $controller = null;
    public $session = null;

    public function initialize(array $config)
    {
        $this->controller = $this->getController();
        $this->session = $this->controller->request->getSession();
    }

    /**
     * @param $characters
     *
     * @return string
     */
    public function generateCode($characters)
    {
        /*
         * list all possible characters, similar looking characters and vowels
         * have been removed
         */
        $possible = '23456789bcdfghjkmnpqrstvwxyz';
        $code     = '';
        $i        = 0;
        while ($i < $characters) {
            $code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            $i++;
        }

        return $code;
    }

    /**
     * @param $captchaId
     */
    public function create($captchaId)
    {
        $width      = '120';
        $height     = '40';
        $characters = '6';
        $code       = $this->generateCode($characters);
        /* font size will be 75% of the image height */
        $font_size = $height * 0.80;
        $image = @imagecreate($width, $height) or
        die('Cannot initialize new GD image stream');
        /* set the colours */
        $background_color = imagecolorallocate($image, 255, 255, 255);
        $text_color       = imagecolorallocate($image, 0, 0, 0);
        $noise_color      = imagecolorallocate($image, 0, 0, 0);
        /* generate random dots in background */
//        for ($i = 0; $i < ($width * $height) / 3; $i++) {
//            imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height),
//                1, 1, $noise_color);
//        }
        /* generate random lines in background */
        for ($i = 0; $i < ($width * $height) / 150; $i++) {
            imageline($image, mt_rand(0, $width), mt_rand(0, $height),
                mt_rand(0, $width), mt_rand(0, $height), $noise_color);
        }
        /* create textbox and add text */
        $textbox = imagettfbbox($font_size, 0, $this->font, $code) or
        die('Error in imagettfbbox function');
        $x = ($width - $textbox[4]) / 2;
        $y = ($height - $textbox[5]) / 2;
        $y -= 5;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font,
            $code) or die('Error in imagettftext function');
        /* output captcha image to browser */
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
        $this->session->write('Captcha.' . $captchaId, $code);
    }

    /**
     * @param $captchaId
     *
     * @return mixed
     */
    public function getCaptchaCode($captchaId)
    {
        return $this->session->read('Captcha.' . $captchaId);
    }
}
