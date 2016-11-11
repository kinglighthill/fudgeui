<?php
/**
 * Fundamental HTML Page Class
 */
class HTMLPage {
  private $nl = PHP_EOL;
  private $title; // The Title of the HTML Document.
  private $cssSheets = array(); // CSS Sheets collection for the html page
  private $jsScripts = array(); // JS Sheets Collection for the html page.
  private $body = array(); // Array to contain html objects to be generated for the body of the page.
  function __construct ($title) {
      $this->title = $title;
  }
  function setTitle($title) {
      $this->title = $title;
  }
  function appendChild($child) {
      $this->body[] = $child;
  }
  function getTitle() {
      return $this->title;
  }
  function addStyleSheet($css) {
      $this->cssSheets[] = $css;
  }
  function addJS($js) {
      $this->jsScripts[] = $js;
  }
  function getView() {
      $html = "<html>$this->nl";
      $html .= "<head>$this->nl";
      $html .= "<title>$this->title</title>$this->nl";
      for ($x = 0; $x < count($this->cssSheets); $x++) {
          $html .= "<link rel=\"stylesheet\" href=\"" . $this->cssSheets[$x] . "\"/>$this->nl";
      }
      for ($x = 0; $x < count($this->jsScripts); $x++) {
          $html .= "<script src=\"" . $this->jsScripts[$x] . "\"></script>$this->nl";
      }
      $html .= "</head>$this->nl";
      for ($x = 0; $x < count($this->body); $x++) {
          $html .= $this->body[$x]->getView();
      }
      $html .= "</body>$this->nl";
      $html .= "</html>";
      return $html;
  }
}
class HTMLItem {
    private $content;
    private $name = "htmlItem";
    function __construct($content) {
        $this->content = $content;
    }
    function setContent($content) {
        $this->content = $content;
    }
    function appendContent($content) {
        $this->content .= $content;
    }
    function getTagName() {
        return $this->name;
    }
    function getView() {
        return $this->content;
    }
}
class HTMLContainer {
    private $contents = array();
    function appendChild($htmlObject) {
        if (method_exists($htmlObject, "getTagName") && method_exists($htmlObject, "getView") && get_class($htmlObject) != "Tag"){
            $this->contents[] = $htmlObject;
        }
    }
    function getChildCount() {
        return count($this->contents);
    }
    function getView() {
        $html = "";
        for ($x = 0; $x < count($this->contents); $x++) {
            $html .= $this->contents[$x]->getView() . PHP_EOL;
        }
        return $html;
    }
}
class Tag {
    protected $id;
    protected $_class;
    protected $name;
    protected $style;
    protected $body;
    function __construct($id) {
        $id = str_replace(" ", "", $id);
        $this->id = $id;
        $this->name = strtolower(get_class($this)); // Sets Tag object Name.
        /*
        The classes that extend the Tag class must have the same name as the corresponding html tag
        being implemented  by the object. (case insensitive but should be neat and uniform).
        Tag Class names follow the rules below.
        3 letters - All Caps.
        >3 Letters - First Cap.
        */
    }
    function addCSSRule($property, $val) {
      if ($property != "" && $val != "") {
        $this->style .= "$property:$val;";
      }
    }
    function getCSSRules() {
      return $this->style;
    }
    function setCSSRuleString($style) {
      $this->style = $style;
    }
    function addClass($class) {
        $this->_class .= $class . " ";
    }
    function removeClass($class) {
        if ($class == "") {
            $this->_class = "";
        } else {
            $this->_class = str_replace($class, "", $this->_class);
        }
    }
    function hasClass($class) {
        return (strpos("*" . $this->_class, $class) != false);
    }
    function getClassString() {
        return trim($this->_class);
    }
    function getID() {
        return $this->id;
    }
    function getTagName() {
        return $this->name;
    }
    protected function attribute($att, $val) {
      // TODO: Validate for cases where the attribute value can contain double quotes and format differently.
      if ($val != "") {
        return " $att=\"$val\"";
      }
       return "";
    }
    /**
     * [appendChild function to append html object to body of html object.]
     * @param  [string] $child [html object]
     * @return [null]
     */
    protected function appendChild($child) {
      if (get_parent_class($child) == "Tag") {
        $this->body[] = $child;
      }
    }
}
class DIV extends Tag {
    function setChild($child) {
        $this->body = array();
    }
    /**
     * [getView function to generate html equival of the html object.]
     * @return [string] [html rep. of object]
     */
    function getView() {
      $html = "<div";
      $html .= $this->attribute("id", $this->id);
      $html .= $this->attribute("class", $this->getClassString());
      $html .= $this->attribute("style", $this->style);
      $html .= ">" . PHP_EOL;
      if (count($this->body) > 0) {
        for ($x = 0; $x < count($this->body); $x++) {
          $html .= $this->body[$x]->getView() . PHP_EOL;
        }
      }
      $html = trim($html) . PHP_EOL . "</div>" . PHP_EOL;
      return $html;
    }
}
class P extends Tag {
}
?>
