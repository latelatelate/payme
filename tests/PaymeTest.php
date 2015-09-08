<?php
 
use NM\Payme\Payme;
 
class PaymeTest extends PHPUnit_Framework_TestCase {
 
  public function testNachHasCheese()
  {
    $nacho = new Payme;
    $this->assertTrue($nacho->hasCheese());
  }
 
}
