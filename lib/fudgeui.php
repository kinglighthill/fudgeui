<?php
// Auto-Loading.
require_once("HTML.php");
require_once("Helper.php");
require_once("Exceptions.php");
require_once("VLogger.php");
require_once("Layouts.php");
require_once("Bootstrap.php");
// Class Fudge UI.
class FudgeUI {
  static function isAssoc(array $array) {
    return count(array_filter(array_keys($array), 'is_string')) > 0;
  }
}
?>
