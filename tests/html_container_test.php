<?php
class HTMLContainerTest extends PHPunit_Framework_Testcase {
    function testAppendChildWithString() {
        $container = new HTMLContainer();
        $container->appendChild("hello");
        $this->assertEquals(0, $container->getChildCount());
    }
    function testAppendChildWithTagObject() {
        $container = new HTMLContainer();
        $tag = new Tag("id");
        $container->appendChild($tag);
        $this->assertEquals(0, $container->getChildCount());
    }
    function testAppendChildWithProperObject() {
        $container = new HTMLContainer();
        $div = new DIV("id");
        $container->appendChild($div);
        $this->assertEquals(1, $container->getChildCount()); // Will Fail Unitil DIV class is properly implemented.
    }
    // MoreTests to come.
}
?>