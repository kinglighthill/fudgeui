<?php
class PTest extends PHPunit_Framework_Testcase {
  private $logger;
  function __construct() {
    $this->logger = new VLogger("test_logs.txt");
  }
  function testPBody() {
    $p = new P("id");
    $p->setChild("Hello Madagascar");
    $this->logger->log($p->getView());
    $this->assertEquals("<p id=\"id\">Hello Madagascar</p>" . PHP_EOL, $p->getView());
  }
}
?>
