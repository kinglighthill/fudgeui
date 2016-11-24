<?php
class FormInputTest extends PHPunit_Framework_Testcase {
  /**
   * [testSetInputType checks to see if the validation within the setInputType
   * funtion works as expected. throwing of exceptions are tested as well]
   * @return [null]
   */
  function testSetInputType() {
    $input = new FormInput("name");
    $input->setType("date");
    $this->assertEquals("date", $input->getType());
    $input->setType("yolo");
    $this->assertEquals("date", $input->getType());
  }
}
?>
