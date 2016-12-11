<?php
class TableLayoutTest extends PHPunit_Framework_Testcase {
  function testColumnCreationandChildAppending() {
    $table = new TableLayout(3);
    $table->appendChild(0, new P("Hello there first column."));
    $table->appendChild(1, new P("Hello there second column."));
    $table->appendChild(2, new P("Hello there third column."));
    $table->appendChild(2, new P("Hello there third column."));
    $table->appendChild(1, new P("Hello there second column."));
    $result  = $table->getView();
    $logger = new VLogger("test_logs.txt");
    $logger->log($table->getView());
  }
}
?>
