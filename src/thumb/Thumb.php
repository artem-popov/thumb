<?php

namespace thumb;

use \RuntimeException;

class Thumb {

   const WIDTH = 1;
   const HEIGHT = 2;

   protected $originalFileName = null;
   protected $fileNameOnly = null;

   protected function extractExtension($fileName) {
      $pathBits = explode(DIRECTORY_SEPARATOR, $fileName);
      $fileName = $pathBits[count($pathBits) - 1];
      $fileNameBits = explode(".", $fileName);
      return strtolower($fileNameBits[count($fileNameBits) - 1]);
   }

   protected function isAllowedFileExtension($extension) {
      return in_array($extension, array("jpg", "jpeg", "gif", "png"));
   }

   protected function freeMemory(array $files) {
      foreach ($files as $file) {
         imagedestroy($file);
      }
   }

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

   protected function createImage($filePath, $fileName) {
      switch ($this->originalFileExtension) {
         case "jpg":
            return imagecreatefromjpeg($filePath);
            break;
         case "jpeg":
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
      $destination = $folder . "/" . $fileName;
      switch ($this->originalFileExtension) {
         case "jpg":
            imagejpeg($img, $destination, 100);
            break;
         case "jpeg":
            imagejpeg($img, $destination, 100);
            break;
         case "gif":
            imagegif($img, $destination);
            break;
         case "png":
            imagepng($img, $destination, 9);
            break;
      }
   }

   /**
    * @param string $originalFilePath The full path of the image we want to manipulate (it will comprise path on disk + the name of the file itself)
    * @throws RuntimeException
    */
   public function __construct($originalFilePath) {
      $this->originalFilePath = $originalFilePath;
      $this->originalFileExtension = $this->extractExtension($originalFilePath);
      if (!file_exists($this->originalFilePath)) {
         throw new RuntimeException("The file " . $this->originalFilePath . " does not exist!");
      }
      if ($this->isAllowedFileExtension($this->originalFileExtension) === false) {
         throw new RuntimeException("This type of image [" . $this->originalFileExtension . "] is not supported!");
      }
      $bits = explode("/", $this->originalFilePath);
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
      if ($fileName === null) {
         $fileName = $this->fileNameOnly;
      }
      $src = $this->createImage($this->originalFilePath, $fileName);
      $dimensions = $this->getNewDimensions($strategy, $newDimension);
      $tmp = imagecreatetruecolor($dimensions["newWidth"], $dimensions["newHeight"]);
      // this does the image resizing by copying the original image into the $tmp image!
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $dimensions["newWidth"], $dimensions["newHeight"], $dimensions["originalWidth"], $dimensions["originalHeight"]);
      $this->saveImage($tmp, $destinationFolder, $fileName);
      $this->freeMemory(array($src, $tmp));
   }
}
