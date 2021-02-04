<?php
namespace Core\Includes\Database;

use Core\Includes\Database\DatabaseStatementInterface;

class DatabaseStatementEmpty implements \Iterator, DatabaseStatementInterface {

  public function execute($args = [], $options = []) {
    return FALSE;
  }

  public function getQueryString() {
    return '';
  }

  public function rowCount() {
    return 0;
  }

  public function setFetchMode($mode, $a1 = NULL, $a2 = []) {
    return;
  }

  public function fetch($mode = NULL, $cursor_orientation = NULL, $cursor_offset = NULL) {
    return NULL;
  }

  public function fetchField($index = 0) {
    return NULL;
  }

  public function fetchObject() {
    return NULL;
  }

  public function fetchAssoc() {
    return NULL;
  }

  function fetchAll($mode = NULL, $column_index = NULL, array $constructor_arguments = []) {
    return [];
  }

  public function fetchCol($index = 0) {
    return [];
  }

  public function fetchAllKeyed($key_index = 0, $value_index = 1) {
    return [];
  }

  public function fetchAllAssoc($key, $fetch = NULL) {
    return [];
  }

  /* Implementations of Iterator. */

  public function current() {
    return NULL;
  }

  public function key() {
    return NULL;
  }

  public function rewind() {

  }

  public function next() {

  }

  public function valid() {
    return FALSE;
  }
}
