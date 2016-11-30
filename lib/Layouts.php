<?php
class TableLayout {
  private $columns; // number of columns.
  private $body; // the html objects nested.
  function __construct($columns) {
    if ($columns > 0) {
      $this->columns = $columns;
      for ($x =0; $x < $columns; $x++) {
        $this->body[] = array();
      }
    } else {
      throw new InvalidArgsException("Columns must be greater than zero.");
    }
  }
  function appendChild($position, $child){
    //TODO: add the $child variable to the specified column.
  }
}
?>
