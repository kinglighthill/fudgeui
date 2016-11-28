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
class String {
  static function startsWith($needle, $haystack) {
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
  static function endsWith($needle, $haystack) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
  }
}
class FudgeUI {
  static function isAssoc(array $array) {
    return count(array_filter(array_keys($array), 'is_string')) > 0;
  }
}
?>
