<?php
class FudgeUi {
  function __construct() {
      $ci =& get_instance();
      $ci->load->library("HTML");
      $ci->load->library("Exceptions");
      $ci->load->library("BootStrap");
      $ci->load->library("Controls");
      $ci->load->library("Helper");
      $ci->load->library("CSS");
      $ci->load->library("Layouts");
  }
  static function isAssoc(array $array) {
    return count(array_filter(array_keys($array), 'is_string')) > 0;
  }
}
?>