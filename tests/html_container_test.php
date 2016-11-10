<?php
class HTMLContainerTest extends PHPunit_Framework_Testcase {
    function testAddItemWithString() {
        $container = new HTMLContainer();
        $container->addItem("hello");
        $this->assertEquals(0, $container->getItemCount());
    }
    function testAddItemWithTagObject() {
        $container = new HTMLContainer();
        $tag = new Tag("id");
        $container->addItem($tag);
        $this->assertEquals(0, $container->getItemCount());
    }
}
?>