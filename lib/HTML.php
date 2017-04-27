<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Parameters start from segment 3 of URL.
 */
class AthenaAPI extends CI_Controller {
  /**
   * [__construct AthenaAPI Constructor]
   */
  function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('AthenaDB');
  }
  /**
   * [index default controller function, not meant to do anything...]
   * @return [string-echo] [You Are Not Welcome Here!!!]
   */
  function index() {
    echo "You Are Not Welcome Here!!!";
  }
  /**
   * [verifyHandle function to verify if handle code exists in the database]
   * @return [string-echo] [1 for true, 0 for false]
   */
  function verifyHandle() {
    // 3 - Handle Code
    $handle = $this->uri->segment('3');
    echo $this->AthenaDB->verifyHandle($handle);
  }
  /**
   * [getStaffInfoByHandle returns a json string of staff record.]
   * @return [string-echo] [json string]
   */
  function getStaffInfoByHandle() {
    // 3 - Handle Code
    $handle = $this->uri->segment('3');
    echo json_encode($this->AthenaDB->getStaffInfoByHandle($handle));
  }
  /**
   * [nullifyHandle remove handle from staffs table and log in used handle table.]
   * @return [type] [description]
   */
  function nullifyHandle() {
    // 3 - Handle Code
    $handle = $this->uri->segment('3');
    $staff = $this->AthenaDB->nullifyHandle($handle);
    /*
    Handle no longer needed here, staff has been verified.
     */
    unset($staff['handle']);
    echo json_encode($staff);
  }
  /**
   * [verifyKey returns 0 or 1 if key macthes uid]
   * @param  [string] $key [25 characters security key]
   * @param  [string] $uid [user id]
   * @return [string]      [0 or 1]
   */
  function verifyKey() {
    $key = $this->uri->segment('3');
    $uid = $this->uri->segment('4');
    echo $this->AthenaDB->verifyKey($key, $uid);
  }
  /**
   * [getTable gets the whole spcified tableand returns them as a json array]
   * @param  [string] $table [name of table]
   * @return [json string]        [rows associative array]
   */
  function getTable() {
    $table = $this->uri->segment('3');
    echo json_encode($this->AthenaDB->getTable($table));
  }
  /**
   * [getVersion returns the version number of the specified table based on
   * records fromthe sync table.]
   * @param  [string] $table [table name]
   * @return [int]        [table version number]
   */
  function getVersion() {
    $table = $this->uri->segment('3');
    echo $this->AthenaDB->getVersion($table);
  }
  function calibrateTable() {
    $table = $this->uri->segment('3');
    if ($this->AthenaDB->incrementVersion($table)) {
      echo "1";
    } else {
      echo "0";
    }
  }
  /**
   * [flagTaken flags the taken column of sync table in the row that matches
   * name of table given.]
   * @return [string] [1 on success and 0 on error.]
   */
  function flagTaken() {
    $table = $this->uri->segment('3');
    $flag = $this->uri->segment('4');
    echo $this->AthenaDB->flagTaken($table, $flag);
  }
  /**
   * [modifyTable controller function for modifying a table row using url
   * commands from the python dsync translator]
   * @return [string] [1 on success, 0 on error]
   */
  function modifyTable() {
    $table = $this->uri->segment(3);
    $action = $this->uri->segment(4);
    $where = array();
    $pointer = 5;
    if ($action == "update") {
      $pointer = 7;
      $where[] = $this->uri->segment(5);
      $where[] = urldecode($this->uri->segment(6));
    }
    $data = array();
    $column = $this->uri->segment($pointer);
    while ($column != "") {
      $data[$column] = urldecode($this->uri->segment(++$pointer));
      ++$pointer;
      $column = $this->uri->segment($pointer);
    }
    if ($action == "add") {
      if ($this->AthenaDB->insertData($table, $data)) {
        echo "1";
      } else {
        echo "0";
      }
    } elseif ($action == "update") {
      if ($this->AthenaDB->updateData($table, $where, $data)) {
        echo "1";
      } else {
        echo "0";
      }
    }
   }
}
?>
