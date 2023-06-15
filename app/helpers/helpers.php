<?php

/**
 * Include Laravel default helpers
 */

require __DIR__.'/laravel_helpers.php';

function meta()
{
    return app(App\Services\MetaDataService::class);
}

function carbon($time = null, $tz = null)
{
    return new \Carbon\Carbon($time, $tz);
}

function flash($message, $type = 'info')
{
    if ($type == 'error') {
        $type = 'danger';
    }

    if (!in_array($type, ['success', 'info', 'warning', 'danger'])) {
        $type = 'info';
    }

    app('session')->flash('flash_message', [
        'type'    => $type,
        'message' => $message,
    ]);
}

function asset_cdn($path)
{
    return asset($path);
}

function human_size($bytes, $decimals = 2)
{
    $bytes = (int)$bytes;
    $size = [' B', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB'];
    $factor = (int)floor((strlen($bytes) - 1) / 3);

    return number_format(($bytes / pow(1024, $factor)), $decimals) . @$size[$factor];
}

function computer_size($number, $size = null)
{
    if (!$size) {
        preg_match('/([0-9.]{0,9})\s?([bkmgtpezy]{1,2})/i', $number, $guess_size);
        if (isset($guess_size[1]) && isset($guess_size[2])) {
            $number = $guess_size[1];
            $size = $guess_size[2];
        }
    }

    $size = strtolower($size);
    $bytes = (float)$number;
    $factors = ['b' => 0, 'kb' => 1, 'mb' => 2, 'gb' => 3, 'tb' => 4, 'pb' => 5, 'eb' => 6, 'zb' => 7, 'yb' => 8];

    if (isset($factors[$size])) {
        return (float)number_format($bytes * pow(1024, $factors[$size]), 2, '.', '');
    }

    return $bytes;
}

function image_embed_codes($images, $type = null)
{
    $embed = '';
    if (!($images instanceof \Illuminate\Support\Collection)) {
        $images = [$images];
    }

    foreach ($images as $image) {
        $thumb_url = asset_cdn('t/' . $image->hash . '.' . $image->image_extension);
        $image_url = asset_cdn('i/' . $image->hash . '.' . $image->image_extension);
        if ($type == 'html') {
            $embed .= '<a href="' . $image_url . '"><img src="' . $thumb_url . '"' . '></a>';
        } elseif ($type == 'bbcode') {
            $embed .= '[url=' . $image_url . '][img]' . $thumb_url . '[/img][/url]';
        } else {
            $embed .= $image_url . "\n";
        }
    }

    $embed = rtrim($embed, "\n");

    return $embed;
}

function mime_to_extension($mime)
{
    try {
        $extension = \Hoa\Mime\Mime::getExtensionsFromMime($mime);
    } catch (\Exception $e) {
    }

    if (!empty($extension) && is_array($extension)) {
        if ($extension[0] == 'jpeg') {
            return 'jpg';
        }

        return $extension[0];
    }

    return null;
}

function extension_to_mime($extension)
{
    return \Hoa\Mime\Mime::getMimeFromExtension($extension);
}

/**
 * Converts a string to UTF-8 encoding.
 *
 * @param   $string
 *
 * @return string
 */
function convert_to_utf8($string)
{
    if (is_string($string) && !check_if_utf8($string)) {
        if (function_exists('mb_convert_encoding')) {
            $string = mb_convert_encoding($string, 'UTF-8',
                mb_detect_encoding($string, 'UTF-8, ISO-8859-1, ISO-8859-15'));
        } else {
            $string = utf8_encode($string);
        }
    }

    return $string;
}

/**
 * Checks a string for UTF-8 encoding.
 *
 * @param string $string
 *
 * @return bool
 */
function check_if_utf8($string)
{
    $length = strlen($string);

    for ($i = 0; $i < $length; ++$i) {
        if (ord($string[$i]) < 0x80) {
            $n = 0;
        } elseif ((ord($string[$i]) & 0xE0) == 0xC0) {
            $n = 1;
        } elseif ((ord($string[$i]) & 0xF0) == 0xE0) {
            $n = 2;
        } elseif ((ord($string[$i]) & 0xF0) == 0xF0) {
            $n = 3;
        } else {
            return false;
        }

        for ($j = 0; $j < $n; ++$j) {
            if ((++$i == $length) || ((ord($string[$i]) & 0xC0) != 0x80)) {
                return false;
            }
        }
    }

    return true;
}
