<?php

use \thumb\Thumb;

class ThumbTest extends PHPUnit_Framework_TestCase {

   public function setUp() {
      
   }

   public function tearDown() {
      
   }

   public function testResizeJPG() {
      echo __DIR__;
      $jpg = new Thumb(__DIR__ . "/../../fixtures/origin/dog.jpg");
   }
}