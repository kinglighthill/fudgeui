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
    function testHTMLObjectInheritanceOnAttributes() {
      $div = new DIV("id");
      $div->setAttribute("name", "hello");
      $div->setAttribute("title", "world");
      $div->setAttribute("newAttribute", "newValue");
      $result = preg_match("/<div id=\"id\"/", $div->getView()) == 1;
      $this->assertTrue($result);
      $result = preg_match("/newAttribute=\"newValue\"/", $div->getView()) == 1;
      $this->assertTrue($result);
      $result = preg_match("/<div title=\"world\"/", $div->getView()) == 0;
      $this->assertTrue($result);
    }
    function testHTMLObjectAppendChild() {
      $div = new DIV("id");
      $div2 = new DIV("id3");
      $div->appendChild($div2);
      $p = new P("otg");
      $div->appendChild($p);
      $html = $div->getView();
      $result = preg_match("/<div id=\"id3\"/", $html);
      $this->assertEquals(1, $result);
      $result = preg_match("/<p>otg<\/p>/", $html);
      $this->assertEquals(1, $result);
    }
    function testSetOnClick() {
      $div = new DIV("id");
      $div->setOnClick("foo()");
      $this->assertEquals("foo();", $div->getOnClick());
      $div->setOnClick("foo", 67);
      $this->assertEquals("foo(67);", $div->getOnClick());
      $div->setOnClick("foo", array("hello", 78, "bar"));
      $this->assertEquals("foo('hello', 78, 'bar');", $div->getOnClick());
    }
}
?>
