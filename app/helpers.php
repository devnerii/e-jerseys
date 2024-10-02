<?php

function hex2rgb($hexstr)
{
    $hexstr = ltrim($hexstr, '#');
    if (strlen($hexstr) == 3) {
        $hexstr = $hexstr[0].$hexstr[0].$hexstr[1].$hexstr[1].$hexstr[2].$hexstr[2];
    }
    $R = hexdec($hexstr[0].$hexstr[1]);
    $G = hexdec($hexstr[2].$hexstr[3]);
    $B = hexdec($hexstr[4].$hexstr[5]);

    return [$R, $G, $B];
}

function rgb2hex($rgb)
{
    $r = str_pad(dechex($rgb[0]), 2, '0', STR_PAD_LEFT);
    $g = str_pad(dechex($rgb[1]), 2, '0', STR_PAD_LEFT);
    $b = str_pad(dechex($rgb[2]), 2, '0', STR_PAD_LEFT);

    return "#$r$g$b";
}

function rgb2hsl($RGB, $ladj = 0)
{
    // scale the RGB values to 0 to 1 (percentages)
    $r = $RGB[0] / 255;
    $g = $RGB[1] / 255;
    $b = $RGB[2] / 255;
    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    // lightness calculation. 0 to 1 value, scale to 0 to 100% at end
    $l = ($max + $min) / 2;

    // saturation calculation. Also 0 to 1, scale to percent at end.
    $d = $max - $min;
    if ($d == 0) {
        // achromatic (grey) so hue and saturation both zero
        $h = $s = 0;
    } else {
        $s = $d / (1 - abs((2 * $l) - 1));
        // hue (if not grey) This is being calculated directly in degrees (0 to 360)
        switch ($max) {
            case $r:
                $h = 60 * fmod((($g - $b) / $d), 6);
                if ($b > $g) { //will have given a negative value for $h
                    $h += 360;
                }
                break;
            case $g:
                $h = 60 * (($b - $r) / $d + 2);
                break;
            case $b:
                $h = 60 * (($r - $g) / $d + 4);
                break;
        } //end switch
    } //end else
    // make any lightness adjustment required
    if ($ladj > 0) {
        $l += (1 - $l) * $ladj / 100;
    } elseif ($ladj < 0) {
        $l += $l * $ladj / 100;
    }

    //put the values in an array and scale the saturation and lightness to be percentages
    return [round($h), round($s * 100), round($l * 100)];
}

function hsl2rgb($hsl)
{

    $h = $hsl[0];
    $s = $hsl[1] / 100;
    $l = $hsl[2] / 100;

    $c = (1 - abs(2 * $l - 1)) * $s;
    $x = $c * (1 - abs(fmod(($h / 60), 2) - 1));
    $m = $l - ($c / 2);

    if ($h < 60) {
        $r = $c;
        $g = $x;
        $b = 0;
    } elseif ($h < 120) {
        $r = $x;
        $g = $c;
        $b = 0;
    } elseif ($h < 180) {
        $r = 0;
        $g = $c;
        $b = $x;
    } elseif ($h < 240) {
        $r = 0;
        $g = $x;
        $b = $c;
    } elseif ($h < 300) {
        $r = $x;
        $g = 0;
        $b = $c;
    } elseif ($h < 360) {
        $r = $c;
        $g = 0;
        $b = $x;
    } else {
        $r = 0;
        $g = 0;
        $b = 0;
    }
    $r = round(($r + $m) * 255);
    $g = round(($g + $m) * 255);
    $b = round(($b + $m) * 255);

    return [$r, $g, $b];
}

function rgb2str($rgb)
{
    return 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
}
function hsl2str($hsl)
{
    return 'hsl('.$hsl[0].','.$hsl[1].'%,'.$hsl[2].'%)';
}

function hexadj($hex, $adj)
{
    return rgb2hex(hsl2rgb(rgb2hsl(hex2rgb($hex), $adj)));
}
