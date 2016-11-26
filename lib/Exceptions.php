<?php
class InvalidInputTypeException extends Exception {
  public function message() {
    $errorMsg = "Invalid input type given on line " . $this->getLine() . " in " . $this->getFile() . "; <b>" . $this->getMessage() . "</b>";
    return $errorMsg;
  }
}
?>
