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
        $result = (strpos($page->getView(), "<link rel=\"stylesheet\" href=\"http://www.w3schools.com/css/style.css\"/>") != false);
        $this->assertTrue($result);
        $page->addStyleSheet("http://www.maxcdn.com/css/style.css");
        $result = (strpos($page->getView(), "<link rel=\"stylesheet\" href=\"http://www.maxcdn.com/css/style.css\"/>") != false);
        $this->assertTrue($result);
    function testStylesheetsTagsWrappingNicely() {
        $page = new HTMLPage("Title");
        $page->addStyleSheet("http://www.w3schools.com/css/style.css");
        $page->addStyleSheet("http://www.maxcdn.com/css/style.css");
        $result = strpos($page->getView(), "/>" . PHP_EOL . "<link") != false;
        $this->assertTrue($result);
    }
    function testJSFormatting() {
        $page = new HTMLPage("Title");
        $page->addJS("http://www.w3schools.com/css/home.js");
        $result = (strpos($page->getView(), "<script src=\"http://www.w3schools.com/css/home.js\"></script>") != false);
        $this->assertTrue($result);
        $page->addJS("http://www.maxcdn.com/css/king.js");
        $result = (strpos($page->getView(), "<script src=\"http://www.maxcdn.com/css/king.js\"></script>") != false);
        $this->assertTrue($result);
    }
    function testJSTagsWrappingNicely() {
        $page = new HTMLPage("Title");
        $page->addJS("http://www.w3schools.com/css/home.js");
        $page->addJS("http://www.maxcdn.com/css/king.js");
        $result = strpos($page->getView(), "</script>" . PHP_EOL . "<script") != false;
        $this->assertTrue($result);
    }
    function testCSSJSInterJoinNormal() {
        $page = new HTMLPage("Title");
        $page->addStyleSheet("http://www.css.com.style.css");
        $page->addJS("http://www.js.com/memo.js");
        $page->addStyleSheet("http://www.css.com/combo.css");
        $page->addJS("http://www.combo.com/jesuit.js");
        $result = strpos($page->getView(), "/>" . PHP_EOL . "<script src") != false;
        $this->assertTrue($result);
    }
}
?>
