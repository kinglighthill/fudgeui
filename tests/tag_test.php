<?php
class TagTest extends PHPunit_Framework_Testcase {
    function testTagConstructor() {
        $tag = new Tag("id");
        $this->assertEquals("id", $tag->getID());
    }
    function testClassesGetterAndSetter() {
        $tag = new Tag("id");
        $tag->addClass("pointer");
        $result = $tag->getClassString();
        $this->assertEquals("pointer", $result);
        $tag->addClass("w3-card");
        $result = $tag->getClassString();
        $this->assertEquals("pointer w3-card", $result);
        $tag->addClass("IBM");
        $result = $tag->getClassString();
        $this->assertEquals("pointer w3-card IBM", $result);
    }
    function testRemoveClass() {
        $tag = new Tag("id");
        $tag->addClass("pointer");
        $tag->addClass("w3-card");
        $tag->removeClass("pointer");
        $result = $tag->getClassString();
        $this->assertEquals("w3-card", $result);
        $tag->removeClass("yes");
        $result = $tag->getClassString();
        $this->assertEquals("w3-card", $result);
        $tag->addClass("golem");
        $tag->removeClass("");
        $result = $tag->getClassString();
        $this->assertEquals("", $result);
    }
    function testHasClass() {
        $tag = new Tag("id");
        $tag->addClass("hello");
        $this->assertTrue($tag->hasClass("hello"));
        $tag->addClass("world");
        $this->assertTrue($tag->hasClass("hello"));
        $this->assertTrue($tag->hasClass("world"));
        $tag->removeClass("hello");
        $this->assertTrue($tag->hasClass("world"));
        $this->assertFalse($tag->hasClass("hello"));
        $tag->removeClass("");
        $this->assertFalse($tag->hasClass("world"));
    }
}
?>