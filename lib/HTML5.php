<?php
class HTMLPage {
    private $title; // The Title of the HTML Document.
    private $cssSheets = array(); // CSS Sheets collection for the html page
    private $jsScripts = array(); // JS Sheets Collection for the html page.
    private $body = array(); // Array to contain html objects to be generated for the body of the page.
    function HTMLPage($title) {
        $this->title = $title;
    }
    function setTitle($title) {
        $this->title = $title;
    }
    function appendChild($child) {
        $this->body[] = $child;
    }
}
?>