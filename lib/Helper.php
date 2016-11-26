<?php
/**
 *
 */
class HTMLValidator {
/**
 * [validInputType checks if the provided input type is a valid html input type.]
 * @param  [string] $input [html input type]
 * @return [boolean]        [true if valid, false if not valid]
 */
  static function validInputType($input) {
    return in_array($input, HTMLRef::getValidInputTypes());
  }
}
/**
 *
 */
class HTMLRef {
  /**
   * [getValidInputTypes description]
   * @return [type] [description]
   */
  static function getValidInputTypes() {
    return array("text", "file", "password", "submit", "reset", "checkbox",
                 "button", "number", "date", "color", "range", "month","week",
                 "time", "datetime-local", "email", "search", "tel", "url");
  }
}
?>
