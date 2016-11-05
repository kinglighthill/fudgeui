<?php
class HTML5Test extends PHPunit_Framework_Testcase {
    public function testConstructor() {
        $page = new HTMLPage("Title");
        $result = $page->getTitle();
        $this->assertEquals("Title", $result);
    }
}
?>