<?php
class HTML5Test extends PHPunit_Framework_Testcase {
    function testConstructor() {
        $page = new HTMLPage("Title");
        $result = $page->getTitle();
        $this->assertEquals("Title", $result);
    }
    function testStyleSheetFormatting() {      
        $page = new HTMLPage("Title");
        $page->addStyleSheet("http://www.w3schools.com/css/style.css");
        $result = (strpos($page->getView(), "<link rel=\"stylesheet\" href=\"http://www.w3schools.com/css/style.css\">") != -1);
        $this->assertTrue($result);
    }
}
?>