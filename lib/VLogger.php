<?php
class VLogger {
  private $handler;
  function __construct($file) {
    $this->handler = fopen($file, 'a');
  }
  function log($text) {
    fwrite($this->handler, $text . PHP_EOL);
  }
  function dispose() {
    fclose($this->handler);
  }
}
?>
