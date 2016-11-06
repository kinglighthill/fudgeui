<?php
class HTML5Test extends PHPunit_Framework_Testcase {
    function testTagConstructor() {
        $tag = new Tag("id");
        $this->assertEquals("id", $tag->getID());
    }
}
?>