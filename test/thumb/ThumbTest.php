<?php

use \thumb\Thumb;

class ThumbTest extends PHPUnit_Framework_TestCase {

   protected function resize($fileName, $strategy) {
      $thumbFullPath = __DIR__ . "/../../fixtures/results/" . $fileName;
      $img = new Thumb(__DIR__ . "/../../fixtures/origin/" . $fileName);
      $img->create(100, __DIR__ . "/../../fixtures/results/", null, $strategy);
      $this->assertTrue(file_exists($thumbFullPath));
      $data = getimagesize($thumbFullPath);
      $this->assertEquals(100, $data[$strategy - 1]);
   }

   protected function resizeAndRenaming($fileName, $thumbName, $strategy) {
      $thumbFullPath = __DIR__ . "/../../fixtures/results/" . $thumbName;
      $img = new Thumb(__DIR__ . "/../../fixtures/origin/" . $fileName);
      $img->create(100, __DIR__ . "/../../fixtures/results/", $thumbName, $strategy);
      $this->assertTrue(file_exists($thumbFullPath));
      $data = getimagesize($thumbFullPath);
      $this->assertEquals(100, $data[$strategy - 1]);
   }

   public function setUp() {
      
   }

   public function tearDown() {
      emptyDir(__DIR__ . "/../../fixtures/results/");
   }

   public function testResizingJPG_Width() {
      $this->resize("dog.jpg", Thumb::WIDTH);
   }

   public function testResizingGIF_Width() {
      $this->resize("dog.gif", Thumb::WIDTH);
   }

   public function testResizingPNG_Width() {
      $this->resize("dog.png", Thumb::WIDTH);
   }

   public function testResizingJPG_Height() {
      $this->resize("dog.jpg", Thumb::HEIGHT);
   }

   public function testResizingGIF_Height() {
      $this->resize("dog.gif", Thumb::HEIGHT);
   }

   public function testResizingPNG_Height() {
      $this->resize("dog.png", Thumb::HEIGHT);
   }

   public function testResizingAndRenamingJPG_Width() {
      $this->resizeAndRenaming("dog.jpg", "thumb.jpg", Thumb::WIDTH);
   }

   public function testResizingAndRenamingGIF_Width() {
      $this->resizeAndRenaming("dog.gif", "thumb.gif", Thumb::WIDTH);
   }

   public function testResizingAndRenamingPNG_Width() {
      $this->resizeAndRenaming("dog.png", "thumb.png", Thumb::WIDTH);
   }

   public function testResizingAndRenamingJPG_Height() {
      $this->resizeAndRenaming("dog.jpg", "thumb.jpg", Thumb::HEIGHT);
   }

   public function testResizingAndRenamingGIF_Height() {
      $this->resizeAndRenaming("dog.gif", "thumb.gif", Thumb::HEIGHT);
   }

   public function testResizingAndRenamingPNG_Height() {
      $this->resizeAndRenaming("dog.png", "thumb.png", Thumb::HEIGHT);
   }
}