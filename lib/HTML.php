<?php
class HTML {
    static function getName() {
      return "HTML";
    }
}
class HTMLObject {
    protected $id; // ID of the HMTLObject.
    protected $_class;
    protected $name; // the name of the html tag or object being implemented
    protected $style; // variable for the style attribute.
    protected $body = array(); // The array that conatians html objects that children of the current html object
    protected $title; // popup text.
    protected $onclick;
    protected $attributesString; // a string containing all attribute value pair.
    private $iAttributes = array("id", "title", "class", "style", "onclick"); // Implemented HTML attributes.
    function __construct() {
      $a = func_num_args();
      switch ($a) {
        case 0:
          break;
        case 2:
          $this->appendChild(func_get_arg(1));
        case 1:
          $id = func_get_arg(0);
          $id = str_replace(" ", "", $id);
          $this->id = $id;
          break;
      }
      $this->name = strtolower(get_class($this)); // Sets Tag object Name.
      /*
      The classes that extend the Tag class must have the same name as the corresponding html tag
      being implemented  by the object. (case insensitive but should be neat and uniform).
      Tag Class names follow the rules below.
      3 letters - All Caps.
      >3 Letters - First Cap.
      */
    }
    /**
     * [addCSSRule adds a css rule to the style attribute]
     * **overloaded**
     * {
     * @param array $rules associatie array of css rules
     * }
     * {
     * @param [string] $property [css property]
     * @param [string] $val      [css value]
     * }
     */
    function addCssRule() {
      $a = func_num_args();
      switch($a) {
        case 0:
          throw new InvalidArgsException("No CSS Rule");
        case 1:
          if (is_array(func_get_arg(0))) {
            if (FudgeUI::isAssoc(func_get_arg(0))) {
              $rules = func_get_arg(0);
              $keys = array_keys($rules);
              foreach($keys as $key) {
                $style = "$key:" . $rules[$key] . ";";
                $this->style .= $style;
              }
            } else {
              throw new InvalidArgsException("Associative array Expected");
            }
          } else {
            throw new InvalidArgsException("Associative array Expected");
          }
          break;
        case 2:
          $property = func_get_arg(0);
          $val = func_get_arg(1);
          if (!(is_array($property) && is_array($val))) {
            if ($property != "" && $val != "") {
              $this->style .= "$property:$val;";
            } else {
              if ($property == "") {
                throw new InvalidArgsException("Property not given.");
              } else {
                throw new InvalidArgsException("Value of given property not set.");
              }
            }
          } else {
            throw new InvalidArgsException("Array not Expected");
          }
          break;
        default:
          throw new InvalidArgsException("Invalid Parameters");
      }
    }
    /**
     * [getCSSRules gets all set css rules for the html object. (equvalent of
     *              all rules in style attribute)]
     * @return [string] [css rules]
     */
    function getCssRules() {
      return $this->style;
    }
    /**
     * [setOnClick sets the javascript code that fires when this object is clicked
     * on client side.]
     * **overloaded**
     * {
     * @param [string] $function [the javascript function.]
     * }
     * {
     * @param [string] $functionName [the name of the javascript function to call without
     *                               parenthesis.]
     * @param [{(string|int) array}] $arg [function's argument(s).]
     * }
     */
    function setOnClick() {
      $a = func_num_args();
      switch ($a) {
        case 0:
          throw new InvalidArgsException("Empty Arg");
        case 1:
          $onclick = str_replace("\"", "'", func_get_arg(0));
          if (!_String::endsWith(";", $onclick)) {
            $onclick .= ";";
          }
          $this->onclick = $onclick;
          break;
        case 2:
          $onclick = func_get_arg(0) . "("; // function name.
          $functionArgs = func_get_arg(1); // function args.
          if (!is_array($functionArgs)) {
            if (gettype($functionArgs) == "string") {
              $onclick .= "'" . $functionArgs . "');";
            } elseif (gettype($functionArgs) == "integer") {
              $onclick .= $functionArgs . ");";
            }
          } else {
            for ($x = 0; $x < count($functionArgs); $x++) {
              if (gettype($functionArgs[$x]) == "string") {
                $onclick .= "'" . $functionArgs[$x] . "', ";
              } elseif (gettype($functionArgs[$x]) == "integer") {
                $onclick .= $functionArgs[$x] . ", ";
              }
            }
            $onclick = substr($onclick, 0, strlen($onclick) - 2);
            $onclick .= ");";
          }
          $this->onclick = $onclick;
          break;
        default:
          throw new InvalidArgsException(func_get_arg(1));
      }
    }
    /**
     * [getOnClick returns the value of the 'onclick' attribute of the html object]
     * @return [string] [javascript function, empty string if not set]
     */
    function getOnClick() {
      return $this->onclick;
    }
    /**
     * [setCSSRuleString sets the style attribute]
     * @param [string] $style [css rules]
     */
    function setCSSRuleString($style) {
      $this->style = $style;
    }
    /**
     * [addClass adds/appends a class to the class attribute]
     * @param [string] $class [css class]
     */
    function addClass($class) {
        $this->_class .= $class . " ";
    }
    /**
     * [removeClass removes the specified class from the class attribute]
     * @param  [type] $class [class to remove]
     * @return [null]
     */
    function removeClass($class) {
        if ($class == "") {
            $this->_class = "";
        } else {
            $this->_class = str_replace($class, "", $this->_class);
        }
    }
    /**
     * [hasClass checks existence of the specified class in the class attribute]
     * @param  [type]  $class [css class to check if exists]
     * @return boolean        [true if class exists, flase if not exists]
     */
    function hasClass($class) {
        return (strpos("*" . $this->_class, $class) != false);
    }
    /**
     * [getClassString gets the value of the class attribute]
     * @return [string] [space seperated css classes]
     */
    function getClassString() {
        return trim($this->_class);
    }
    /**
     * [getID gets the id of the html element]
     * @return [string] [id string]
     */
    function getId() {
        return $this->id;
    }
    function setId($id) {
      $this->id = $id;
    }
    /**
     * [getTagName gets the tag name of the html tag]
     * @return [string] [html tag name]
     */
    function getTagName() {
        return $this->name;
    }
    /**
     * [setPopUpText sets the title attribute of the html tag]
     * @param [string] $popup [the value of the title attribute]
     */
    function setPopUpText($popup) {
      $this->title = $popup;
    }
    /**
     * [setAttribute sets attributes of the html object.]
     * @param [string] $att [attribute name.]
     * @param [string] $val [attribute value.]
     */
    function setAttribute($att, $val) {
      if (!in_array($att, $this->iAttributes)) {
        $buffer = $this->attribute($att, $val);
        if (strpos($this->attributesString, $att) != false) {
          $attArray = explode(" ", $this->attributesString);
          for ($x = 0; $x < count ($attArray); $x++) {
            if (preg_match("/$att/", $attArray[$x])) {
              $attArray[$x] = $buffer;
              $this->attributesString = implode(" ", $attArray);
              break;
            }
          }
        } else {
          $this->attributesString .= $buffer;
        }
      }
    }
    /**
     * [getAttribute gets the value of the specified attribute]
     * @param  [string] $att [attribute]
     * @return [string]      [value of the specified attribute, empty string if value is unset]
     */
    function getAttribute($att) {
      $attArray = explode(" ", $this->attributesString);
      for ($x = 0; $x < count ($attArray); $x++) {
        if (preg_match("/$att/", $attArray[$x])) {
          $val = substr(substr($attArray[$x], strpos($attArray[$x], "=") + 1), 1);
          return substr($val, 0, strlen($val) - 1);
        }
      }
      return "";
    }
    /**
     * [attribute a function that decides wether an attribute is to be added to an html tag
     *            during rendering]
     * @param  [string] $att [attribute name]
     * @param  [string] $val [attribute value]
     * @return [string]      [proper attribute value pair, returns empty string if attribute value
     *                               is empty]
     */
    protected function attribute($att, $val) {
      if ($val != "") {
        $val = str_replace("\"", "'", $val);
        return " $att=\"$val\"";
      }
      return "";
    }
    /**
     * [appendChild function to append html object to body of html object.]
     * @param  [string] $child [html object]
     * @return [null]
     */
    function appendChild() {
      $a = func_num_args();
      switch ($a) {
        case 0:
          throw new InvalidArgsException("Null");
        case 1:
          $child = func_get_arg(0);
          if (get_parent_class($child) == "HTMLObject" || get_parent_class($child) == "FormInput" || get_parent_class($child) == "BootStrap" || method_exists($child, "getView")) {
            $this->body[] = $child;
          } else {
            echo get_parent_class($child);
            throw new InvalidArgsException("HTMLObject child expected");
          }
          break;
        case 2:
          if (gettype(func_get_arg(0)) == "integer" && func_get_arg(0) < count($this->body)) {
            $this->body[func_get_arg(0)]->appendChild(func_get_arg(1));
          }
          break;
      }
    }
    function getChild($index) {
      if ($index < count($this->body)) {
        return $this->body[$index];
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
    function clearChildren() {
      $this->body = array();
    }
}
class HTMLItem extends HTMLObject {
    private $content; // the content of this uhtml item.
    private $mode = 0;
    /**
     * [__construct initializes the htmlItem with its supposed content]
     * @param [string] $content [content to contain/hold (this is not an array)]
     */
    function __construct($mode, $content) {
      $this->name = "htmlItem";
      if ((gettype($content) == "string" || get_parent_class($content) == "HTMLObject" || method_exists($content, "getTagName")) && get_class($content) != "HTMLObject"){
        if ($mode == 0) {
          $this->mode = 0;
          $this->content = array($content);
        } elseif ($mode == 1) {
          $this->content = $content;
        } else {
          throw new InvalidModeException($mode);
        }
      } else {
        throw new InvalidArgsException("HTMLItem or HTMLObject expected.");
      }
    }
    /**
     * [setContent sets the content of the htmlItem. This replaces the old content]
     * @param [string] $content [the new content of the htmlItem]
     */
    function setContent($content) {
      if ($mode == 0) {
        $this->content = array($content);
      } else {
        $this->content = $content;
      }
    }
    function setMode($mode) {
      if ($mode == 0) {
        $this->content = array();
      } elseif ($mode == 1) {
        $this->content = "";
      } else {
        throw new InvalidModeException($mode);
      }
      $this->mode = $mode;
    }
    function setTagName($tagName) {
      if ($this->mode == 0) {
        $this->name = $tagName;
      }
    }
    /**
     * [appendContent appends new content specified to the end of the old content]
     * @param  [string] $content [the new content to append to the old one]
     * @return [null]
     */
    function appendContent($content) {
      if ($this->mode == 0) {
        $this->content[] = $content;
      } else {
        $this->content .= $content;
      }
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
    function setAttribute($key, $val) {
      if ($this->mode == 0) {
        parent::setAttribute($key, $val);
      }
    }
    function getView() {
      $html = "";
      if ($this->mode == 0) {
        $html = "<$this->name" . $this->attributesString . ">" . PHP_EOL;
        // TODO add style attribute...
        foreach ($this->content as $obj) {
          $html .= $obj->getView();
        }
        $html .= "</$this->name>";
        return $html;
      }
        return $this->content;
    }
}
class HTMLPage {
  private $nl = PHP_EOL; // New line character;
  private $title; // The Title of the HTML Document.
  private $cssSheets = array(); // CSS Sheets collection for the html page
  private $jsScripts = array(); // JS Sheets Collection for the html page.
  private $body = array(); // Array to contain html objects to be generated for the body of the page.
  private $lang = "en-US"; // The language of the html page.
  private $bg; // Background Image.
  /**
   * [__construct constructor for the html page object.]
   * @param [string] $title [the tile of the html page]
   */
  function __construct ($title) {
    if (is_array($title)) {
      throw new InvalidArgsException("Array not expected here.");
    }
    $this->addJS("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
    $this->addStyleSheet("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
    $this->addStyleSheet("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js");
    $host = $_SERVER["HTTP_HOST"];
    $self = $_SERVER["PHP_SELF"];
    $self = substr($self, 0, strrpos($self, "/"));
    $self .= "/css/ui.css";
    $this->addStyleSheet($host . $self);
    $this->title = $title;
  }
  /**
   * [setLanguage sets the language of the html page]
   * @param [string] $lang [the language to set to e.g. "en-US"]
   */
  function setLanguage($lang) {
    if (!is_array($lang) && gettype($lang) == "string") {
      $this->lang = $lang;
    } else {
      throw new InvalidArgsException("Array not expected here");
    }
  }
  /**
   * [setTitle sets the title of the html page]
   * @param [string] $title [the new title of the html page]
   */
  function setTitle($title) {
    if (gettype($title) == "integer" || gettype($title) == "string") {
      $this->title = $title;
    } else {
      throw new InvalidArgsException("Integer or String accepted");
    }
  }
  /**
   * [appendChild adds html objects to the html page body tag or just body...:)]
   * @param  [HTMLObject] $child [html object]
   * @return [null]
   */
  function appendChild($child) {
    if ((method_exists($child, "getTagName") && method_exists($child, "getView") && get_class($child) != "HTMLObject") || (get_parent_class($child) == "Layout") || (get_parent_class($child) == "BootStrap")){
      $this->body[] = $child;
    } else {
      throw new InvalidArgsException("Invalid Parameter");
    }
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
   * **overloaded **
   * {
   * @param [string] $css [url to css file (can be relative)]
   * }
   * {
   * @param [array(string)] $css [non-associative array of urls]
   * }
   */
  function addStyleSheet($css) {
    if (is_array($css)) {
      if (!FudgeUI::isAssoc($css)) {
        foreach ($css as $url) {
          if (gettype($url) == "string"){
            $this->cssSheets[] = $url;
          } else {
            throw new InvalidArgsException("Strings expected as content of array");
          }
        }
      } else {
        throw new InvalidArgsException("Non associative array expected.");
      }
    } elseif (gettype($css) == "string") {
      $this->cssSheets[] = $css;
    } else {
      throw new InvalidArgsException("String url expected");
    }
  }
  /**
   * [addJS adds a url to a script tag in a html page
   *        equivalent of <script src="$js"></script>]
   * **overloaded**
   * {   *
   * @param [string] $js [the url to the .js file (can be relative)]
   * }
   * {
   * @param [array(string)] $js [the urls to .js files (can be relative)]
   * }
   */
  function addJS($js) {
    if (is_array($js)) {
      if (!FudgeUI::isAssoc($js)) {
        foreach ($js as $url) {
          if (gettype($url) == "string"){
            $this->jsScripts[] = $url;
          } else {
            throw new InvalidArgsException("Strings expected as content of array");
          }
        }
      } else {
        throw new InvalidArgsException("Non associative array expected.");
      }
    } elseif (gettype($js) == "string") {
      $this->jsScripts[] = $js;
    } else {
      throw new InvalidArgsException("String url expected");
    }
  }
  /**
   * [getView outputs the html representation of the html page]
   * @return [null]
   */
  function getView() {
      $html = "<html" . $this->attribute("lang", $this->lang) . ">$this->nl";
      $html .= "<head>$this->nl";
      $html .= "<title>$this->title</title>$this->nl";
      $html .= "<meta charset=\"utf-8\">$this->nl";
      $html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">$this->nl";
      for ($x = 0; $x < count($this->cssSheets); $x++) {
          $html .= "<link rel=\"stylesheet\" href=\"" . $this->cssSheets[$x] . "\"/>$this->nl";
      }
      for ($x = 0; $x < count($this->jsScripts); $x++) {
          $html .= "<script src=\"" . $this->jsScripts[$x] . "\"></script>$this->nl";
      }
      $html .= "</head>$this->nl";
      $html .= "<body";
      if ($this->bg != "") {
        $html .= " style=\"background-image:url($this->bg)\">$this->nl";
      } else {
        $html .= ">$this->nl";
      }
      $html .= "<div class=\"container-fluid\"> " . PHP_EOL;
      for ($x = 0; $x < count($this->body); $x++) {
          $html .= $this->body[$x]->getView();
      }
      $html .= "</div>$this->nl";
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
  function setBackgroundImage($bg) {
    $this->bg = $bg;
  }
}
class HTMLContainer {
    private $contents = array(); // The array that holds all html items.
    /**
     * [appendChild adds htmlObjects to the contents array.]
     * @param  [type] $htmlObject [valid HTMLObject]
     * @return [null]
     */
    function appendChild($htmlObject) {
        if (method_exists($htmlObject, "getTagName") && method_exists($htmlObject, "getView") && get_class($htmlObject) != "HTMLObject"){
            $this->contents[] = $htmlObject;
        }
    }
    /**
     * [getChildCount gets the number of htmlObjects in the contents array.]
     * @return [int] [number of htmlObjects in the contents array.]
     */
    function getChildCount() {
        return count($this->contents);
    }
    /**
     * [getView renders the html form of the htmlObject]
     * @return [string] [html reprsentation of the HTMLContainer and all it's contents.]
     */
    function getView() {
        $html = "";
        for ($x = 0; $x < count($this->contents); $x++) {
            $html .= $this->contents[$x]->getView() . PHP_EOL;
        }
        return $html;
    }
}
interface HTMLView {
  public function getView();
}
/**
 * Header tag (HTML).
 */
class Header extends HTMLObject implements HTMLView {
  function getView() {
    $html = "<header";
    $html .= $this->attribute("id", $this->id);
    $html .= $this->attribute("class", $this->getClassString());
    $html .= $this->attribute("style", $this->style);
    $html .= $this->attribute("title", $this->title);
    $html .= $this->attribute("onclick", $this->onclick);
    $html .= $this->attributesString;
    $html .= ">" . PHP_EOL;
    if (count($this->body) > 0) {
      for ($x = 0; $x < count($this->body); $x++) {
        $html .= $this->body[$x]->getView();
      }
    }
    $html .= "</header>" . PHP_EOL;
    return $html;
  }
}
class IMG extends HTMLObject implements HTMLView {
  private $src;
  function __construct() {
    $a = func_num_args();
    switch ($a) {
      case 0:
        break;
      case 1:
        $this->src = func_get_arg(0);
        break;
      case 2:
        $this->id = func_get_arg(0);
        $this->src = func_get_arg(1);
        break;
    }
  }
  function getView() {
    $html = "<img";
    $html .= $this->attribute("src", $this->src);
    $html .= $this->attribute("id", $this->id);
    $html .= $this->attribute("class", $this->getClassString());
    $html .= $this->attribute("style", $this->style);
    $html .= $this->attribute("title", $this->title);
    $html .= $this->attribute("onclick", $this->onclick);
    $html .= " " . $this->attributesString;
    $html .= "/>" . PHP_EOL;
    return $html;
  }
}
/**
 * DIV tag (HTML).
 */
class DIV extends HTMLObject {
    /**
     * [getView function to generate html equival of the html object.]
     * @return [string] [html representation of object]
     */
    function getView() {
      $html = "<div";
      $html .= $this->attribute("id", $this->id);
      $html .= $this->attribute("class", $this->getClassString());
      $html .= $this->attribute("style", $this->style);
      $html .= $this->attribute("title", $this->title);
      $html .= $this->attribute("onclick", $this->onclick);
      $html .= " " . $this->attributesString;
      $html = trim($html);
      $html .= ">" . PHP_EOL;
      if (count($this->body) > 0) {
        for ($x = 0; $x < count($this->body); $x++) {
          $html .= $this->body[$x]->getView();
        }
      }
      $html .= "</div>" . PHP_EOL;
      return $html;
    }
}
class Span extends HTMLObject {
  function __construct() {
    $a = func_num_args();
    switch($a) {
      case 1:
        $this->body[] = func_get_arg(0);
    }
  }
    /**
     * [getView function to generate html equival of the html object.]
     * @return [string] [html representation of object]
     */
    function getView() {
      $html = "<span";
      $html .= $this->attribute("id", $this->id);
      $html .= $this->attribute("class", $this->getClassString());
      $html .= $this->attribute("style", $this->style);
      $html .= $this->attribute("title", $this->title);
      $html .= $this->attribute("onclick", $this->onclick);
      $html .= " " . $this->attributesString;
      $html = trim($html);
      $html .= ">";
      if (count($this->body) > 0) {
        for ($x = 0; $x < count($this->body); $x++) {
          if (gettype($this->body[$x]) == "string") {
            $html .= $this->body[$x];
          } else {
            $html .= $this->body[$x]->getView();
          }
        }
      }
      $html .= "</span>" . PHP_EOL;
      return $html;
    }
}
/**
 * A tag (HTML)
 */
class A extends HTMLObject {
  function __construct($target, $child) {
    $this->setAttribute("href", $target);
    $this->body[] = $child;
  }
  function setTarget($target) {
    $this->setAttribute("href", $target);
  }
  function setText($text) {
    if (!is_object($text)) {
      $this->body[0] = $text;
    } else {
      throw new InvalidArgsException("Argument supplied not a string.");
    }
  }
  function getView() {
    $html = "<a";
    $html .= $this->attribute("id", $this->id);
    $html .= $this->attribute("class", $this->getClassString());
    $html .= $this->attribute("style", $this->style);
    $html .= $this->attribute("title", $this->title);
    $html .= $this->attribute("onclick", $this->onclick);
    $html .= $this->attributesString;
    $html .= ">";
    $c = count($this->body);
    if ($c <= 1 && !is_object($this->body[0])) {
      if ($c != 0) {
        $html .= $this->body[0];
        $html .= "</a>" . PHP_EOL;
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
      $html .= "</a>" . PHP_EOL;
    }
    return $html;
  }
}
/**
 * Link Object for redundancy of A.
 */
class Link extends A {
}
/**
 * P tag (HTML)
 */
class P extends HTMLObject {
  /**
   * [__construct initializes the P object with its content]
   * @param [html|string] $body [the content of the p object]
   */
  function __construct() {
    $a = func_num_args();
    switch ($a) {
      case 0:
        break;
      case 1:
        $this->body[] = func_get_arg(0);
        break;
      case 2:
        $this->id = func_get_arg(0);
        $this->body[] = func_get_arg(1);
        break;
    }
  }
  /**
   * [getView renders the P object's html]
   * @return [string] [html representation of the object]
   */
  function getView() {
    $html = "<p";
    $html .= $this->attribute("id", $this->id);
    $html .= $this->attribute("class", $this->getClassString());
    $html .= $this->attribute("style", $this->style);
    $html .= $this->attribute("title", $this->title);
    $html .= $this->attribute("onclick", $this->onclick);
    $html .= $this->attributesString;
    $html .= ">";
    $c = count($this->body);
    if ($c <= 1 && !is_object($this->body[0])) {
      if ($c != 0) {
        if (strlen($this->body[0]) < 100) {
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
/**
 * Form tag HTML
 */
class Form extends HTMLObject {
  private $method; // form method.
  private $action;// for action.
  /**
   * [useGET sets the html form method attribute to get]
   * @return [null]
   */
  function useGet() {
    $this->method = "get";
  }
  /**
   * [usePost sets the forms method attribute to post]
   * @return [null]
   */
  function usePost(){
    $this->method = "post";
  }
  /**
   * [setAction sets the action attribute of the html form.]
   * @param [string] $action [url of the remote script to submit the form values to.]
   */
  function setAction($action) {
    $this->action = $action;
  }
  /**
   * [addInput adds a html input to the form body.]
   * @param [string] $placeholder [the default semi-transparent text to be
   *                              displayed inside of the input.]
   * @param [string] $name  [name to associate with the input; this will be the
   *                      key in the $_GET[] associative array on the php side.]
   * @param [string] $type  [html input type]
   */
  function addInput($placeholder, $name, $type) {
    //TODO: to be overloaded.
  }
  function getView() {
    $html = "<form";
    $html .= ($this->action == "") ? "" : " action=\"$this->action\"";
    $html .= ($this->method == "") ? "" : " method=\"$this->method\"";
    $html .= ">" . PHP_EOL;
    foreach($this->body as $item) {
      $html .= $item->getView();
    }
    $html .= "</form>" . PHP_EOL;
    return $html;
  }
}
class Label extends HTMLObject {
  private $text;
  function __construct($for, $text) {
    $this->setAttribute("for", $for);
    $this->text = $text;
  }
  function setText($text) {
    // TODO some string formatting functions here.
    $this->text = $text;
  }
  function getView() {
    return "<label$this->attributesString>$this->text</label>" . PHP_EOL;
  }
  function setFor($for) {
    $this->setAttribute("for", $for);
  }
}
//--section-start-- {Section for html input items}
/**
 * Base Class for HTML form inputs.
 */
class FormInput extends HTMLObject {
  private $keyName; // value of the name attribute.
  protected $placeholder; // value for the placeholder attribute.
  protected $type; // Input type.
  protected $validator; // The HTML Validator Object.
  /**
   * [__construct constructor]
   * @param [string] $name [value of the name tag of the html input]
   */
  function __construct($id) {
    $this->id = $id;
    $this->name = "input";
    //TODO: overload.
  }
  function setPlaceholder($placeholder) {
    $this->placeholder = $placeholder;
  }
  /**
   * [setName sets the name of the html input tag; necessary if you are gount to
   * submit the form via submit action. this uniquely identifies the form values]
   * @param [string] $name [value of the name tag]
   */
  function setName($name) {
    $this->keyName = $name;
  }
  /**
   * [getName get the value of the name tag]
   * @return [string] [value of the name tag]
   */
  function getName() {
    return $this->keyName;
  }
  /**
   * [setType sets the input type of the tag]
   * @param [string] $type [input type]
   */
  function setType($type) {
    if (HTMLValidator::validInputType($type)) {
      $this->type = $type;
    } else {
      throw new InvalidInputTypeException($type);
    }
  }
  /**
   * [getType returns for input type]
   * @return [type] [empty string if not set or a vild html input type if set.]
   */
  function getType() {
    return $this->type;
  }
  function getView() {
    $html = "<input" . $this->attribute("id", $this->id);
    $html .= $this->attribute("type", $this->type);
    $html .= $this->attribute("name", $this->keyName);
    $html .= $this->attribute("placeholder", $this->placeholder);
    $html .= $this->attribute("class", $this->getClassString());
    $html .= $this->attribute("style", $this->style);
    $html .= $this->attribute("title", $this->title);
    $html .= $this->attribute("onclick", $this->onclick);
    $html .= "/>" . PHP_EOL;
    return $html;
  }
}
class TextInput extends FormInput {
  /**
   * [__construct description]
   * **overloaded**
   * {
   * @param string $id the id of the text input.
   * }
   * {
   * @param string $name the value of the name tag of the text input.
   * @param string $placeholder the placeholder of the text input.
   * }
   */
  function __construct() {
    $a = func_num_args();
    switch($a) {
      case 0:
        break;
      case 1:
        if (!is_array(func_get_arg(0))) {
          parent::__construct(func_get_arg(0));
          break;
        }
        throw new InvalidArgsException("Array not expected");
      case 2:
        if (!(is_array(func_get_arg(0)) &&  is_array(func_get_arg(1)))) {
          parent::__construct(func_get_arg(0));
          $this->keyName = func_get_arg(1);
          break;
        }
        throw new InvalidArgsException("Array not expected");
      default:
        throw new InvalidArgsException("Wrong number of arguments given");
    }
  }
  /**
   * [getView gets the html representation of the text input]
   * @return [string] [html]
   */
  function getView() {
    return "<input type=\"$this->type\" $attributesString/>" . PHP_EOL;
  }
  function appendChild() {
    // Overidden and does nothing.
  }
  function getChild($index) {
    // Overidden and does nothing.
  }
  function setChild($child) {
    // Overidden and does nothing.
  }
}
/**
 * The HTML5 Video Tag Eqivalent
 */
class Video extends HMTLObject {
  //TODO.
  private $autoplay;
  private $controls;
  function __construct() {
    $a = func_num_args();
    switch ($a) {
      case 2:
        $this->setAttribute("width", func_get_arg(0));
        $this->setAttribute("height", func_get_arg(1));
        break;
    }
  }
}
class Table extends HTMLObject {
  private $headers;
  private $row;
  function setHeaders($headers) {
    $this->headers = $headers;
  }
  function addRow($row) {
    $this->row = $row;
  }
}
?>
