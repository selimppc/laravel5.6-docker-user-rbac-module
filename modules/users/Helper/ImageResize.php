<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 11/25/16
 * Time: 4:41 PM
 */

namespace App\Helpers;

use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\Validator;

class ImageResize
{

    /*
     * $newWidth :: image size in width
     * $targetFile :: taget file and location
     * $originalFile  :: original file
     */
    public static function resize($newWidth, $targetFile, $originalFile) {
        $info = getimagesize($originalFile);
        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;
            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;
            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;
            default:
                return false;
        }
        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);
        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        #$image_save_func($tmp, "$targetFile.$new_image_ext"); // using extension as well as case
        $image_save_func($tmp, "$targetFile");
        return true;
    }

}