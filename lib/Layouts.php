<?php
class Layout {

}
class HeaderLayout extends Layout {
  private $image;
  private $text;
  private $tc; // Text Color.
  private $bg; // Background Color.
  private $lw; // Logo width.
  private $lh; // Logo Height.
  function __construct($image, $text) {
    $this->image = $image;
    $this->text = $text;
  }
  function setTextColor($color) {
    $this->tc = $color;
  }
  function setBackgroundColor($color) {
    $this->bg = $color;
  }
  function getView() {
    $header = new Header();
    if ($this->bg != "") {
      $header->addCSSRule("background-color", $this->bg);
    }
    $div = new DIV();
    $img = new IMG($this->image);
    $this->lw == 0 ? $img->setAttribute("width", "250") : $img->setAttribute("width", $this->lw);
    $div->appendChild($img);
    if ($this->text != "") {
      $text = new P($this->text);
      $text->addClass("text-capitalize h1");
      $rules = array("vertical-align"=>"middle","display"=>"inline");
      if ($this->tc != "") {
        $rules['color'] = $this->tc;
      }
      $text->addCSSRule($rules);
      $div->appendChild($text);
    }
    $header->appendChild($div);
    return $header->getView();
  }
}
?>
