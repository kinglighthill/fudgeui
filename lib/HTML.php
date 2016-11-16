<?php
/**
 * Fundamental HTML Page Class
 */
class HTMLPage {
  private $nl = PHP_EOL; // New line character;
  private $title; // The Title of the HTML Document.
  private $cssSheets = array(); // CSS Sheets collection for the html page
  private $jsScripts = array(); // JS Sheets Collection for the html page.
  private $body = array(); // Array to contain html objects to be generated for the body of the page.
  private $lang = "en-US"; // The language of the html page.
  /**
   * [__construct constructor for the html page object.]
   * @param [string] $title [the tile of the html page]
   */
  function __construct ($title) {
      $this->title = $title;
  }
  /**
   * [setLanguage sets the language of the html page]
   * @param [string] $lang [the language to set to e.g. "en-US"]
   */
  function setLanguage($lang) {
    $this->lang = $lang;
  }
  /**
   * [setTitle sets the title of the html page]
   * @param [string] $title [the new title of the html page]
   */
  function setTitle($title) {
      $this->title = $title;
  }
  /**
   * [appendChild adds html objects to the html page body tag or just body...:)]
   * @param  [HTMLObject] $child [html object]
   * @return [null]
   */
  function appendChild($child) {
      $this->body[] = $child;
  }
  /**
   * [getTitle gets the title of the html page]
   * @return [string] [the title of the html page]
   */
  function getTitle() {
      return $this->title;
  }
  /**
   * [addStyleSheet adds a url css link to the head section of the html page
   *                equivalent of "<link rel="stylesheet" href="$css"/>]
   * @param [string] $css [url to css file (can be relative)]
   */
  function addStyleSheet($css) {
      $this->cssSheets[] = $css;
  }
  /**
   * [addJS adds a url to a script tag in a html page
   *        equivalent of <script src="$js"></script>]
   * @param [string] $js [the url to the .js file (can be relative)]
   */
  function addJS($js) {
      $this->jsScripts[] = $js;
  }
  /**
   * [getView outputs the html representation of the html page]
   * @return [null]
   */
  function getView() {
      $html = "<html" . $this->attribute("lang", $this->lang) .  ">$this->nl";
      $html .= "<head>$this->nl";
      $html .= "<title>$this->title</title>$this->nl";
      for ($x = 0; $x < count($this->cssSheets); $x++) {
          $html .= "<link rel=\"stylesheet\" href=\"" . $this->cssSheets[$x] . "\"/>$this->nl";
      }
      for ($x = 0; $x < count($this->jsScripts); $x++) {
          $html .= "<script src=\"" . $this->jsScripts[$x] . "\"></script>$this->nl";
      }
      $html .= "</head>$this->nl";
      $html .= "<body>$this->nl";
      for ($x = 0; $x < count($this->body); $x++) {
          $html .= $this->body[$x]->getView();
      }
      $html .= "</body>$this->nl";
      $html .= "</html>";
      return $html;
  }
  /**
   * [attribute a function that decides wether an attribute is to be added to an html tag
   *            during rendering]
   * @param  [string] $att [attribute name]
   * @param  [string] $val [attribute value]
   * @return [string]      [proper attribute value pair, returns empty string if attribute value
   *                               is empty]
   */
  private function attribute($att, $val) {
    $val = str_replace("\"", "''", $val); // change double quote to single if found in the string
    if ($val != "") {
      return " $att=\"$val\"";
    }
     return "";
  }
}
/**
 * Class for HTML Item that can be used to put in contents into HTMLContainer class
 * Note: Do you not use this class trivially. this class is meant to be used to input
 * either a custon no html text in to a web page or you want to uses html tags or content that
 * is not yet supported.
 */
class HTMLItem {
    private $content; // the content of this uhtml item.
    private $name = "htmlItem";
    /**
     * [__construct initializes the htmlItem with its supposed content]
     * @param [string] $content [content to contain/hold (this is not an array)]
     */
    function __construct($content) {
        $this->content = $content;
    }
    /**
     * [setContent sets the content of the htmlItem. This replaces the old content]
     * @param [string] $content [the new content of the htmlItem]
     */
    function setContent($content) {
        $this->content = $content;
    }
    /**
     * [appendContent appends new content specified to the end of the old content]
     * @param  [string] $content [the new content to append to the old one]
     * @return [null]
     */
    function appendContent($content) {
        $this->content .= $content;
    }
    /**
     * [getTagName gets the supposed tag name of this object, this is a special case as this object
     *             does not ideally reperesent an html tag but this function is here for compatibility reasons.]
     * @return [string] [name of the supposed tag this object represents.. (htmlItem) here which
     *                      is not contained in html.]
     */
    function getTagName() {
        return $this->name;
    }
    /**
     * [getView renders the html of the object]
     * @return [string] [html of the object]
     */
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
class HTMLObject {
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
    function appendChild($child) {
      if (get_parent_class($child) == "Tag") {
        $this->body[] = $child;
      }
    }
    /**
     * [setChild description]
     * @param [type] $child [description]
     */
    function setChild($child) {
        $this->body = array();
        $this->body[] = $child;
    }
}
class DIV extends HTMLObject {
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
class P extends HTMLObject {
  function getView() {
    $html = "<p";
    $html .= $this->attribute("id", $this->id);
    $html .= $this->attribute("class", $this->getClassString());
    $html .= $this->attribute("style", $this->style);
    $html .= ">";
    $c = count($this->body);
    if ($c <= 1 && !is_object($this->body[0])) {
      if ($c != 0) {
        if (strlen($this->body[0]) < 50) {
          $html .= $this->body[0] . "</p>" . PHP_EOL;
        } else {
          $html .= PHP_EOL;
          $html .= $this->body[0] . PHP_EOL;
          $html .= "</p>" . PHP_EOL;
        }
      } else {
        return "";
      }
    } else {
      $html .= PHP_EOL;
      for ($x = 0; $x < count($this->body); $x++) {
        if (is_array($this->body[$x])) {
          $html .= $this->body[$x]->getView();
        } else {
          $html .= $this->body[$x];
        }
      }
      $html .= "</p>" . PHP_EOL;
    }
    return $html;
  }
}
?>
