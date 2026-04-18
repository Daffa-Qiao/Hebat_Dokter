<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    /**
     * Generate a simple math CAPTCHA image and store the answer in session.
     */
    public function generate(Request $request)
    {
        $num1   = random_int(1, 9);
        $num2   = random_int(1, 9);
        $answer = $num1 + $num2;

        $request->session()->put('captcha_answer', $answer);

        $width  = 160;
        $height = 50;

        $image = imagecreatetruecolor($width, $height);

        // Colors
        $bg      = imagecolorallocate($image, 240, 248, 240);
        $border  = imagecolorallocate($image, 21, 115, 71);
        $noise   = imagecolorallocate($image, 180, 210, 180);
        $text    = imagecolorallocate($image, 10, 80, 40);

        // Fill background
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        imagerectangle($image, 0, 0, $width - 1, $height - 1, $border);

        // Add noise lines
        for ($i = 0; $i < 5; $i++) {
            imageline($image, random_int(0, $width), random_int(0, $height),
                              random_int(0, $width), random_int(0, $height), $noise);
        }

        // Add noise dots
        for ($i = 0; $i < 40; $i++) {
            imagesetpixel($image, random_int(0, $width), random_int(0, $height), $noise);
        }

        // Draw the math question
        $label = "{$num1}  +  {$num2}  = ?";
        $fontSize = 5; // built-in font size (1–5)
        $charW  = imagefontwidth($fontSize);
        $charH  = imagefontheight($fontSize);
        $textW  = strlen($label) * $charW;
        $x = (int)(($width  - $textW)  / 2);
        $y = (int)(($height - $charH) / 2);

        imagestring($image, $fontSize, $x, $y, $label, $text);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return response($imageData, 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }
}
