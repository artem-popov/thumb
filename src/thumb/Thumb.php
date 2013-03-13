<?php

namespace thumb;

use \RuntimeException;

class Thumb {

   protected $originalFileName = null;
   protected $fileNameOnly = null;

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
    * @param string $originalFilePath The full path of the image we want to manipulate. It will comprise path on disk + the name of the file itself.
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

   public function create($newWidth, $destinationFolder, $fileName = null) {
      if ($fileName == null) {
         $fileName = $this->fileNameOnly;
      }
      $src = $this->createImage($this->originalFilePath, $fileName);
      list($width, $height) = getimagesize($this->originalFilePath);
      $newHeight = ($height / $width) * $newWidth;
      $tmp = imagecreatetruecolor($newWidth, $newHeight);
      // this does the image resizing by copying the original image into the $tmp image!
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
      $this->saveImage($tmp, $destinationFolder, $this->fileNameOnly);
      $this->freeMemory(array($src, $tmp));
   }
}