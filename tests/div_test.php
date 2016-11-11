<?php
class DIVTest extends PHPunit_Framework_Testcase {
  private $logger;
  function __construct() {
    $this->logger = new VLogger("test_logs.txt");
  }
  function testDIVConstructor() {
    $div = new DIV("id");
    $this->assertEquals("id", $div->getID());
    $this->assertEquals("div", $div->getTagName());
  }
  function testDIVAttributesFormatting() {
    $div = new DIV("id");
    $result = strpos($div->getView(), "div id=\"id\">" . PHP_EOL . "</div>") != false;
    $this->logger->log($div->getView());
    $this->assertTrue($result);
    $div->addClass("hello");
    $this->logger->log($div->getView());
    $result = strpos($div->getView(), "div id=\"id\" class=\"hello\">" . PHP_EOL . "</div>") != false;
    $this->assertTrue($result);
  }
}
?>
