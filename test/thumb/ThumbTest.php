<?php

use \thumb\Thumb;

class ThumbTest extends PHPUnit_Framework_TestCase {

   protected function emptyDir($dir, $deleteMe = false) {

      if (!$dh = @opendir($dir)) {
         return;
      } else {
         while (false !== ($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..') {
               continue;
            }
            if (!unlink($dir . '/' . $obj)) {
               $this->emptyDir($dir . '/' . $obj, true);
            }
         }
         closedir($dh);
         if ($deleteMe) {
            rmdir($dir);
         }
      }
   }

   protected function resize($fileName) {
      $thumbLocation = __DIR__ . "/../../fixtures/results/" . $fileName;
      $jpg = new Thumb(__DIR__ . "/../../fixtures/origin/" . $fileName);
      $jpg->create(100, __DIR__ . "/../../fixtures/results/");
      $this->assertTrue(file_exists($thumbLocation));
      $data = getimagesize($thumbLocation);
      $this->assertEquals(100, $data[0]);
   }

   public function setUp() {
      
   }

   public function tearDown() {
      $this->emptyDir(__DIR__ . "/../../fixtures/results/");
   }

   public function testResizingJPG() {
      $this->resize("dog.jpg");
   }

   public function testResizingGIF() {
      $this->resize("dog.gif");
   }

   public function testResizingPNG() {
      $this->resize("dog.png");
   }
}