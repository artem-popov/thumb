<?php

use \thumb\Thumb;

class ThumbTest extends PHPUnit_Framework_TestCase {

   protected function resize($fileName, $strategy) {
      $thumbFullPath = __DIR__ . "/../../fixtures/results/" . $fileName;
      $img = new Thumb(__DIR__ . "/../../fixtures/origin/" . $fileName);
      $img->create(300, __DIR__ . "/../../fixtures/results/", null, $strategy);
      $data = getimagesize($thumbFullPath);
      $this->assertEquals(300, $data[$strategy - 1]);
   }

   protected function resizeAndRenaming($fileName, $thumbName, $strategy) {
      $thumbFullPath = __DIR__ . "/../../fixtures/results/" . $thumbName;
      $img = new Thumb(__DIR__ . "/../../fixtures/origin/" . $fileName);
      $img->create(100, __DIR__ . "/../../fixtures/results/", $thumbName, $strategy);
      $data = getimagesize($thumbFullPath);
      $this->assertEquals(100, $data[$strategy - 1]);
   }

   public function setUp() {
      
   }

   public function tearDown() {
      emptyDir(__DIR__ . "/../../fixtures/results/");
   }

   /**
    * @expectedException \RuntimeException
    */
   public function testInstantiation() {
      new Thumb("no-way.jpg");
   }

   public function testThumbNameKeepsTheCase() {
      $this->resize("DOG-UPPERCASE.JPG", Thumb::WIDTH);
      $this->assertTrue(file_exists(__DIR__ . "/../../fixtures/results/DOG-UPPERCASE.JPG"));
   }

   public function testResizing_JPG_Width() {
      $this->resize("dog.jpg", Thumb::WIDTH);
   }

   public function testResizing_GIF_Width() {
      $this->resize("dog.gif", Thumb::WIDTH);
   }

   public function testResizing_PNG_Width() {
      $this->resize("dog.png", Thumb::WIDTH);
   }

   public function testResizing_JPG_Height() {
      $this->resize("dog.jpg", Thumb::HEIGHT);
   }

   public function testResizing_GIF_Height() {
      $this->resize("dog.gif", Thumb::HEIGHT);
   }

   public function testResizing_PNG_Height() {
      $this->resize("dog.png", Thumb::HEIGHT);
   }

   public function testResizingAndRenaming_JPG_Width() {
      $this->resizeAndRenaming("dog.jpg", "thumb.jpg", Thumb::WIDTH);
   }

   public function testResizingAndRenaming_GIF_Width() {
      $this->resizeAndRenaming("dog.gif", "thumb.gif", Thumb::WIDTH);
   }

   public function testResizingAndRenaming_PNG_Width() {
      $this->resizeAndRenaming("dog.png", "thumb.png", Thumb::WIDTH);
   }

   public function testResizingAndRenaming_JPG_Height() {
      $this->resizeAndRenaming("dog.jpg", "thumb.jpg", Thumb::HEIGHT);
   }

   public function testResizingAndRenaming_GIF_Height() {
      $this->resizeAndRenaming("dog.gif", "thumb.gif", Thumb::HEIGHT);
   }

   public function testResizingAndRenaming_PNG_Height() {
      $this->resizeAndRenaming("dog.png", "thumb.png", Thumb::HEIGHT);
   }
}