<?php
class PTest extends PHPunit_Framework_Testcase {
  private $logger;
  function __construct() {
    $this->logger = new VLogger("test_logs.txt");
  }
  function testPConstructor() {
    $p = new P("Hello World");
    $this->assertEquals(1, preg_match("/<p>Hello World<\/p>/", $p->getView()));
    $p = new P("id3", "Hello World");
    $this->assertEquals(1, preg_match("/<p id=\"id3\">Hello World<\/p>/", $p->getView()));
  }
  function testPBody() {
    $p = new P("Hello Madagascar");
    $this->logger->log($p->getView());
    $this->assertEquals("<p>Hello Madagascar</p>" . PHP_EOL, $p->getView());
  }
}
?>
