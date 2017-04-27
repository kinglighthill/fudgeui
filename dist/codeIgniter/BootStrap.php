<?php
// Instance Values.
$controls = -1; // for unique identifying of bootstrap controls without given id's.
class BootStrap {
  static function generateControlNumber() {
    ++$GLOBALS['controls'];
    return $GLOBALS['controls'];
  }
  static function getLastControlNumber() {
    return $GLOBALS['controls'];
  }
}
class BSJumbotron extends BootStrap {
  private $top;
  private $bottom;
  private $jumbo;
  function __construct() {
    $this->jumbo = new DIV();
    $a = func_num_args();
    switch ($a) {
      case 0:
        break;
      case 1:
        $this->jumbo-setId(func_get_arg(0));
        break;
      default:
        throw new InvalidArgsException("Wrong Argument Count");
    }
    $this->jumbo->addClass("jumbotron");
  }
  function setTopContent($top) {
    $this->top = $top;
  }
  function setTopText($text) {
    $this->top = new P($text); // Supposed to be Header
  }
  function setBottomContent($bottom) {
    $this->bottom = $bottom;
  }
  function setBottomText($text) {
    $this->bottom = new P($text);
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
  private $padding; // Column padding.
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
  function setPadding($padding) {
    $this->padding = $padding;
  }
  function getColumn() {
    $column = new DIV();
    if ($this->padding != 0) {
      $column->addCssRule("padding", $this->padding);
    }
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
class BSFormInput extends BootStrap {
  private $root;
  private $label;
  protected $input;
  function __construct() {
    // (0)id, (1)type, (2)label
    // (0)id, (1)type, (2)label, (3)name
    // (0)id, (1)type, (2)label, (3)name, (4)placeholder
    $a = func_num_args();
    if ($a >= 3) {
      $this->root = new DIV("bs-" . (func_get_arg(0) == "" ? BootStrap::generateControlNumber() : func_get_arg(0)));
      $this->label = new Label((func_get_arg(0) == "" ? BootStrap::getLastControlNumber() : func_get_arg(0)), func_get_arg(2));
      $this->input = new FormInput((func_get_arg(0) == "" ? BootStrap::getLastControlNumber() : func_get_arg(0)));
    }
    switch ($a) {
      case 0:
        break;
      case 5:
        $this->input->setPlaceholder(func_get_arg(4));
      case 4:
        $this->input->setName(func_get_arg(3));
      case 3:
        $this->input->setType(func_get_arg(1));
        break;
      default:
        throw new InvalidArgsException("Wrong argument count");
    }
  }
  function setId($id) {
    $this->root == null ? $this->root = new DIV("bs-$id") : $this->root->setId("bs-$id");
    $this->input == null ? $this->input = new FormInput($id) : $this->input->setId($id);
    $this->label == null ? $this->label = new Label($id, "") : $this->label->setFor($id);
  }
  function setLabel($text) {
    $this->label == null ? $this->label = new Label("", $text) : $this->label->setText($text);
  }
  function setType($type) {
    if ($this->input == null) {
      $this->input = new FormInput("");
      $this->input->setType($type);
    } else {
      $this->input->setType($type);
    }
  }
  function setName($name) {
    $this->input->setName($name);
  }
  function setPlaceholder($placeholder) {
    $this->input->setPlaceholder($placeholder);
  }
  function getView() {
    if ($this->input != null) {
      $this->root->addClass("form-group");
      $this->root->appendChild($this->label);
      $this->input->addClass("form-control");
      $this->root->appendChild($this->input);
      return $this->root->getView();
    }
    return "";
  }
}
class BSEmailInput extends BSFormInput {
  function __construct() {
    // (0)id, (1)label
    // (0)id, (1)label, (2)name
    // (0)id, (1)label, (2)name, (3)placeholder
    $a = func_num_args();
    switch ($a) {
      case 2:
        parent::__construct(func_get_arg(0), "email", func_get_arg(1));
        break;
    }
    if ($a >= 2) {
      $this->root = new DIV("bs-" . (func_get_arg(0) == "" ? BootStrap::generateControlNumber() : func_get_arg(0)));
      $this->label = new Label((func_get_arg(0) == "" ? BootStrap::getLastControlNumber() : func_get_arg(0)), func_get_arg(1));
      //$this->input = new BSFormInput((func_get_arg(0) == "" ? BootStrap::getLastControlNumber() : func_get_arg(0)));
      $this->input->setType("email");
    }
    switch ($a) {
      case 0:
        break;
      case 4:
        $this->input->setPlaceholder(func_get_arg(3));
      case 3:
        $this->input->setName(func_get_arg(2));
        break;
      case 2:
        break;
      default:
        throw new InvalidArgsException("Wrong argument count");
    }
    return $this;
  }
  function setType($type) {
    // No Action Here.
  }
}
class BSForm extends BootStrap {
  private $form;
  function __construct() {
    $this->form = new Form();
  }
  function useGet() {
    $this->form->useGet();
  }
  function usePost() {
    $this->form->usePost();
  }
  function setAction($action) {
    $this->form->setAction($action);
  }
  function addInput() {
    // TODO overload
    $a = func_num_args();
    switch($a) {
      case 1:
        $this->form->appendChild(func_get_arg(0));
        break;
      case 3:
      // type, name, placeholder.
      case 4:
        // type, id, name, placeholder.
    }
  }
  function appendChild() {

  }
  function getView() {
    return $this->form->getView();
  }
}
/**
 * BootStrap Progress Bar
 */
class BSProgressBar extends BootStrap {
  private $text; // Text to show within ptogress bar.
  private $showValue; // boolean value to show progress value or not.
  private $value;// the progress value.
  private $id; // id of progress bar.
  private $screenReaderText;
  /**
   * [__construct BootStrap Progress Bar Constructor]
   */
  function __construct() {
    //(0)value
    //(0)id, (1)value
    //(0)id, (1)value (2)showValue
    //(0)id, (1)value, (2)showValue, (3)text
    $a = func_num_args();
    switch($a) {
      case 4:
        $this->text = func_get_arg(3);
      case 3:
        $this->showValue = func_get_arg(2);
      case 2:
        $this->value = func_get_arg(1);
        $this->id = func_get_arg(0);
        break;
      case 1:
        $this->value = func_get_arg(0);
        break;
      default:
        throw new InvalidArgsException("No Arguments");
    }
  }
  function getView() {
    $bar = new DIV("bs-" . ($this->id == "" ? BootStrap::generateControlNumber() : $this->id));
    $bar->addClass("progress");
    $realBar = new DIV();
    $realBar->addClass("progress-bar");
    $realBar->setAttribute("role", "progressbar");
    $realBar->setAttribute("aria-valuenow", $this->value);
    $realBar->setAttribute("aria-valuemin", 0);
    $realBar->setAttribute("aria-valuemax", 100);
    $realBar->addCssRule("width", $this->value . "%");
    if ($this->screenReaderText != "") {
      $label = new Span($this->screenReaderText);
      $label->addClass("sr-only");
      $realBar->appendChild($label);
    }
    if ($this->showValue) {
      $label = new Span($this->value . "%");
      $realBar->appendChild($label);
    }
    $bar->appendChild($realBar);
    return $bar->getView();
  }
}
?>
