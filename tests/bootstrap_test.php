<?php
class BootStrapTest extends PHPunit_Framework_Testcase {
  function testFormInput() {
    $fi = new BSFormInput("user", "text", "User Name");
    $r1 = "</div>" . PHP_EOL;
    $this->assertEquals(1, preg_match("/<div id=\"bs-user\" class=\"form-group/", $fi->getView()));
    $this->assertEquals(1, preg_match("/<label for=\"user\">User Name<\/label>/", $fi->getView()));
    $this->assertEquals(1, preg_match("/<input id=\"user\" type=\"text\" class=\"form-control/", $fi->getView()));
    $this->assertEquals(1, preg_match("/<\/div>/", $fi->getView()));
  }
}
?>
