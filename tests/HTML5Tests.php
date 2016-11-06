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
    function testMultipleStyleSheets() {
        $page = new HTMLPage("Title");
        $page->addStyleSheet("http://www.w3schools.com/css/style.css");
        $page->addStyleSheet("http://www.maxcdn.com/css/style.css");
        $page->addStyleSheet("http://www.webf.com/css/style.css");
        $result = (strpos($page->getView(), "<link rel=\"stylesheet\" href=\"http://www.w3schools.com/css/style.css\">") != -1);
        $this->assertTrue($result);
        $result = (strpos($page->getView(), "http://www.maxcdn.com/css/style.css"));
        $this->assertTrue($result);
        $result = (strpos($page->getView(), "http://www.web.com/css/style.css"));
        $this->assertTrue($result);
    }
}
?>