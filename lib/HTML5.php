<?php
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
    function getView() {
        $html = "<html>$this->nl";
        $html .= "<head>$this->nl";
        $html .= "<title>$this->title</title>$this->nl";
        for ($x = 0; $x < count($this->cssSheets); $x++) {
            $html .= "<link";
        }
    }
}
?>