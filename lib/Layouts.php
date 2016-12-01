<?php
class TableLayout {
  private $columns; // number of columns.
  private $body; // the html objects nested.
  function __construct() {
    $id = "";
    $columns = "";
    $a = func_num_args();
    switch ($a) {
      case 0:
        throw new InvalidArgsException("No argument supplied.");
      case 1:
        $columns = func_get_arg(0);
        break;
      case 2:
        $id = func_get_arg(0);
        $columns = func_get_arg(1);
        break;
    }
    if ($columns > 0) {
      $this->columns = $columns;
      $layout = new DIV($id);
      $layout->addClass("table-wrapper");
      $table = new DIV();
      $table->addClass("table-layout");
      for ($x = 0; $x < $columns; $x++) {
        $col = new DIV("fc-$id-$x");
        $col->addClass("table-row");
        $table->appendChild($col);
      }
      $layout->appendChild($table);
      $this->body = $layout;
    } else {
      throw new InvalidArgsException("Columns must be greater than zero.");
    }
  }
  function appendChild($position, $child){
    if ($position < $this->$columns) {
      $this->body->appendChild($position, $child);
    } else {
      throw new InvalidIndexException($position);
    }
  }
}
?>
