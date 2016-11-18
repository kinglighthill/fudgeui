<?php
class HTMLObjectTest extends PHPunit_Framework_Testcase {
    function testHTMLObjectConstructor() {
        $HTMLObject = new HTMLObject("id");
        $this->assertEquals("id", $HTMLObject->getID());
    }
    function testClassesGetterAndSetter() {
        $HTMLObject = new HTMLObject("id");
        $HTMLObject->addClass("pointer");
        $result = $HTMLObject->getClassString();
        $this->assertEquals("pointer", $result);
        $HTMLObject->addClass("w3-card");
        $result = $HTMLObject->getClassString();
        $this->assertEquals("pointer w3-card", $result);
        $HTMLObject->addClass("IBM");
        $result = $HTMLObject->getClassString();
        $this->assertEquals("pointer w3-card IBM", $result);
    }
    function testRemoveClass() {
        $HTMLObject = new HTMLObject("id");
        $HTMLObject->addClass("pointer");
        $HTMLObject->addClass("w3-card");
        $HTMLObject->removeClass("pointer");
        $result = $HTMLObject->getClassString();
        $this->assertEquals("w3-card", $result);
        $HTMLObject->removeClass("yes");
        $result = $HTMLObject->getClassString();
        $this->assertEquals("w3-card", $result);
        $HTMLObject->addClass("golem");
        $HTMLObject->removeClass("");
        $result = $HTMLObject->getClassString();
        $this->assertEquals("", $result);
    }
    function testHasClass() {
        $HTMLObject = new HTMLObject("id");
        $HTMLObject->addClass("hello");
        $this->assertTrue($HTMLObject->hasClass("hello"));
        $HTMLObject->addClass("world");
        $this->assertTrue($HTMLObject->hasClass("hello"));
        $this->assertTrue($HTMLObject->hasClass("world"));
        $HTMLObject->removeClass("hello");
        $this->assertTrue($HTMLObject->hasClass("world"));
        $this->assertFalse($HTMLObject->hasClass("hello"));
        $HTMLObject->removeClass("");
        $this->assertFalse($HTMLObject->hasClass("world"));
    }
    function testCSSStyleAttributes() {
      $HTMLObject = new HTMLObject("id");
      $HTMLObject->addCSSRule("color", "black");
      $this->assertEquals("color:black;", $HTMLObject->getCSSRules());
    }
    function testAttribution() {
      $obj = new HTMLObject("id");
      $obj->setAttribute("href", "hello");
      $obj->setAttribute("href", "world");
      $this->assertEquals("world", $obj->getAttribute("href"));
    }
}
?>
