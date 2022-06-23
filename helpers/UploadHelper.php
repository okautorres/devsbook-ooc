<?php
class UploadHelper {
    public function execute($newAvatar, $sizeA, $sizeB)
    {
        if(in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            $imageWidth = $sizeA;
            $imageHeight = $sizeB;
     
            list($widthOrig, $heightOrig) = getimagesize($newAvatar['tmp_name']);
            $ratio = $widthOrig / $heightOrig;
     
            $newWidth = $imageWidth;
            $newHeight = $newWidth / $ratio;
     
            if($newHeight < $imageHeight) {
                $newHeight = $imageHeight;
                $newWidth = $newHeight * $ratio;
            }
     
           $x = $imageWidth - $newWidth;
           $y = $imageHeight - $newHeight;
     
           $x = $x < 0 ? $x/2 : $x;
           $y = $y < 0 ? $y/2 : $y;
     
           $finalImage = imagecreatetruecolor($imageWidth, $imageHeight);
           switch($newAvatar['type']) {
               case 'image/jpeg':
               case 'image/jpg':
                     $image = imagecreatefromjpeg($newAvatar['tmp_name']);
                     break;
               case 'image/png':
                     $image = imagecreatefrompng($newAvatar['tmp_name']);
                     break;
           }
     
           imagecopyresampled(
             $finalImage, $image,
             $x, $y, 0, 0,
             $newWidth, $newHeight, $widthOrig, $heightOrig
           );
     
           return $finalImage;
         }
    }
}