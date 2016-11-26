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
<<<<<<< HEAD
=======
  function testFormInputConstructor() {
      $input = new FormInput("id");
      $this->assertEquals("id", $input->getID());
  }
  function testClassesGetterAndSetter() {
      $input = new FormInput("id");
      $input->addClass("pointer");
      $result = $input->getClassString();
      $this->assertEquals("pointer", $result);
      $input->addClass("w3-card");
      $result = $input->getClassString();
      $this->assertEquals("pointer w3-card", $result);
      $input->addClass("IBM");
      $result = $input->getClassString();
      $this->assertEquals("pointer w3-card IBM", $result);
  }
  function testRemoveClass() {
      $input = new FormInput("id");
      $input->addClass("pointer");
      $input->addClass("w3-card");
      $input->removeClass("pointer");
      $result = $input->getClassString();
      $this->assertEquals("w3-card", $result);
      $input->removeClass("yes");
      $result = $input->getClassString();
      $this->assertEquals("w3-card", $result);
      $input->addClass("golem");
      $input->removeClass("");
      $result = $input->getClassString();
      $this->assertEquals("", $result);
  }
  function testHasClass() {
      $input = new FormInput("id");
      $input->addClass("hello");
      $this->assertTrue($input->hasClass("hello"));
      $input->addClass("world");
      $this->assertTrue($input->hasClass("hello"));
      $this->assertTrue($input->hasClass("world"));
      $input->removeClass("hello");
      $this->assertTrue($input->hasClass("world"));
      $this->assertFalse($input->hasClass("hello"));
      $input->removeClass("");
      $this->assertFalse($input->hasClass("world"));
  }
  function testCSSStyleAttributes() {
    $input = new FormInput("id");
    $input->addCSSRule("color", "black");
    $this->assertEquals("color:black;", $input->getCSSRules());
  }
  function testAttribution() {
    $input = new FormInput("id");
    $input->setAttribute("href", "hello");
    $input->setAttribute("href", "world");
    $this->assertEquals("world", $input->getAttribute("href"));
  }
>>>>>>> html-input-types
}
?>
