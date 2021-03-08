<?php


namespace App\Exchange\Utility;


use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;


/**
 * Creating and Verifying Captcha
 */
class Captcha
{

    public static function Build()
    {

        $width = 200;
        $height = 50;
        $char_number = 6;
        $phraseBuilder = new PhraseBuilder($char_number, '0123456789');
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($width,$height);
        session()->put('captcha',$builder->getPhrase());
        return $builder->inline();
    }
    public static function Verify($input)
    {
        if (!session()->has('captcha')) {
            return false;
        }
        if (session()->get('captcha') !== $input) {
            return false;
        }
        return true;
    }
}
