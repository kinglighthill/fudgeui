<?php
class HTMLItemTest extends PHPunit_Framework_Testcase {
  function testHTML() {
    $item = new HTMLItem(0, new DIV("hoho"));
    $item->setTagName("hugo");
    $item->setAttribute("color", "#A44532");
    $this->assertEquals(1, preg_match("/<hugo color=\"#A44532\">/", $item->getView()));
    $this->assertEquals(1, preg_match("/<div id=\"hoho\">/", $item->getView()));
    $this->assertEquals(1, preg_match("/<\/div>/", $item->getView()));
    $this->assertEquals(1, preg_match("/<\/hugo>/", $item->getView()));
  }
}
?>
