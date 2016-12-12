<?php
class BootStrap {

}
class BSJumbotron extends BootStrap {
  private $top;
  private $bottom;
  private $jumbo;
  function __construct() {
    $this->jumbo = new DIV();
    $this->jumbo->addClass("jumbotron");
  }
  function setTopContent($top) {
    $this->top = $top;
  }
  function setBottomContent($bottom) {
    $this->bottom = $bottom;
  }
  function addCSSRule($rule, $val) {
    $this->jumbo->addCssRule($rule, $val);
  }
  function getView() {
    if ($this->top != null || $this->bottom != null) {
      $this->top == null ? "" : $this->jumbo->appendChild($this->top);
      $this->bottom == null ? "" : $this->jumbo->appendChild($this->bottom);
      return $this->jumbo->getView();
    }
    return "";
  }
}
class BSColumn extends BootStrap {
  private $devices = array("md");
  private $span;
  private $view; // The HTML Object in the column.
  function __construct($span) {
    $this->span = $span;
  }
  function setSpan($span) {
    $this->span = $span;
  }
  function getSpan() {
    return $this->span;
  }
  function setDeviceConfig($device) {
    $this->devices = array($device);
  }
  function addDeviceConfig($device) {
    $this->devices[] = $device;
  }
  function setContent($content) {
    $this->view = $content;
  }
  function getColumn() {
    $column = new DIV();
    if (count($this->devices) > 1) {
      foreach ($this->devices as $device) {
        $column->addClass("col-$device-$this->span");
      }
    } else {
      $column->addClass("col-" . $this->devices[0] . "-$this->span");
    }
    $this->view == null ? "" : $column->appendChild($this->view);
    return $column;
  }
}
class BSRow extends BootStrap {
  private $devices = array("md");
  private $columns = array();
  function addColumn($column) {
    if (count($this->columns) > 0) {
      $x = 0;
      foreach ($this->columns as $col) {
        $x += $col->getSpan();
      }
      if ($x > 12) {
        throw new BSSpanLimitException($x);
      }
    } elseif ($column->getSpan() > 12) {
      throw new BSSpanLimitException($column->getSpan());
    }
    $this->columns[] = $column;
  }
  function getView() {
    $row = new DIV();
    $row->addClass("row");
    foreach ($this->columns as $column) {
      $row->appendChild($column->getColumn());
    }
    return $row->getView();
  }
}
?>
