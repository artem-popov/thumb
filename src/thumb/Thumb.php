<?php

namespace thumb;

use \RuntimeException;

class Thumb {

   const WIDTH = 1;
   const HEIGHT = 2;

   protected $originalFileName = null;
   protected $fileNameOnly = null;

   protected function getNewDimensions($strategy, $newDimension) {
      list($width, $height) = getimagesize($this->originalFilePath);
      if ($strategy === self::WIDTH) {
         return array(
            "originalWidth" => $width,
            "originalHeight" => $height,
            "newWidth" => $newDimension,
            "newHeight" => ($height / $width) * $newDimension
         );
      } else if (self::HEIGHT) {
         return array(
            "originalWidth" => $width,
            "originalHeight" => $height,
            "newWidth" => ($width / $height) * $newDimension,
            "newHeight" => $newDimension
         );
      } else {
         throw new RuntimeException("Non-existing resizing strategy :(");
      }
   }

   protected function extractExtension($fileName) {
      $bits = explode(".", $fileName);
      return strtolower($bits[count($bits) - 1]);
   }

   protected function freeMemory(array $files) {
      foreach ($files as $file) {
         imagedestroy($file);
      }
   }

   protected function createImage($filePath, $fileName) {
      $extension = $this->extractExtension($fileName);
      switch ($extension) {
         case "jpg":
            return imagecreatefromjpeg($filePath);
            break;
         case "gif":
            return imagecreatefromgif($filePath);
            break;
         case "png":
            return imagecreatefrompng($filePath);
            break;
      }
   }

   protected function saveImage($img, $folder, $fileName) {
      $extension = $this->extractExtension($fileName);
      $destination = $folder . "/" . $fileName;
      switch ($extension) {
         case "jpg":
            imagejpeg($img, $destination, 100);
            break;
         case "gif":
            imagegif($img, $destination);
            break;
         case "png":
            imagepng($img, $destination, 100);
            break;
      }
   }

   /**
    * @param string $originalFilePath The full path of the image we want to manipulate (it will comprise path on disk + the name of the file itself)
    * @throws RuntimeException
    */
   public function __construct($originalFilePath) {
      $this->originalFilePath = $originalFilePath;
      if (!file_exists($this->originalFilePath)) {
         throw new RuntimeException("The file " . $this->originalFilePath . " does not exist");
      }
      $bits = split("/", $originalFilePath);
      $this->fileNameOnly = $bits[count($bits) - 1];
   }

   /**
    * Create the thumb file on disk.
    * 
    * @param integer $newDimension The new dimensions, either width or height
    * @param string $destinationFolder The path of the folder where the thumb will be put
    * @param string $fileName The name of the thumb file
    * @param integer $strategy Whether to resize considering $newDimension as the width or the height of the thumb
    */
   public function create($newDimension, $destinationFolder, $fileName = null, $strategy = self::WIDTH) {
      if ($fileName == null) {
         $fileName = $this->fileNameOnly;
      }
      $src = $this->createImage($this->originalFilePath, $fileName);
      $dimensions = $this->getNewDimensions($strategy, $newDimension);
      $tmp = imagecreatetruecolor($dimensions["newWidth"], $dimensions["newHeight"]);
      // this does the image resizing by copying the original image into the $tmp image!
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $dimensions["newWidth"], $dimensions["newWidth"], $dimensions["originalWidth"], $dimensions["originalHeight"]);
      $this->saveImage($tmp, $destinationFolder, $fileName);
      $this->freeMemory(array($src, $tmp));
   }
}