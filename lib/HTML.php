<?php
/*Fundamental HTML Page Class*/
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
class Container {
    private $contents = array();
    function addItem($htmlObject) {
        if (method_exists($htmlObject, "getTagName")){
            $this->contents[] = $htmlObject;
        }

    }
}
class Tag {
    private $id;
    private $_class;
    private $name;
    function __construct($id) {
        $id = str_replace(" ", "", $id);
        $this->id = $id;
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
}
class DIV extends Tag {
    private $body;
}
?>