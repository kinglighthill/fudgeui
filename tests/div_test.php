<?php
class HTML5Test extends PHPunit_Framework_Testcase {
    function testDIVConstructor() {
        $div = new DIV("id");
        $this->assertEquals("id", $div->getID());
    }
}
?>