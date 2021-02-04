<?php
namespace Core\Includes\Database;

  interface DatabaseStatementInterface extends \Traversable {

  public function execute($args = [], $options = []);

  public function getQueryString();

  public function rowCount();

  public function fetchField($index = 0);

  public function fetchAssoc();

  function fetchAll($mode = NULL, $column_index = NULL, array $constructor_arguments);

  public function fetchCol($index = 0);

  public function fetchAllKeyed($key_index = 0, $value_index = 1);

  public function fetchAllAssoc($key, $fetch = NULL);
}
