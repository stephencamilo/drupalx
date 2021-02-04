<?php
namespace Core\Includes\Database;

abstract class Database {

  const RETURN_NULL = 0;
  const RETURN_STATEMENT = 1;
  const RETURN_AFFECTED = 2;
  const RETURN_INSERT_ID = 3;

  static protected $connections = [];
  static protected $databaseInfo = NULL;
  static protected $ignoreTargets = [];
  static protected $activeKey = 'default';
  static protected $logs = [];

  final public static function startLog($logging_key, $key = 'default') {
    if (empty(self::$logs[$key])) {
      self::$logs[$key] = new DatabaseLog($key);

      if (!empty(self::$connections[$key])) {
        foreach (self::$connections[$key] as $connection) {
          $connection->setLogger(self::$logs[$key]);
        }
      }
    }

    self::$logs[$key]->start($logging_key);
    return self::$logs[$key];
  }

  final public static function getLog($logging_key, $key = 'default') {
    if (empty(self::$logs[$key])) {
      return NULL;
    }
    $queries = self::$logs[$key]->get($logging_key);
    self::$logs[$key]->end($logging_key);
    return $queries;
  }

  final public static function getConnection($target = 'default', $key = NULL) {
    if (!isset($key)) {
      $key = self::$activeKey;
    }
    if (!empty(self::$ignoreTargets[$key][$target]) || !isset(self::$databaseInfo[$key][$target])) {
      $target = 'default';
    }

    if (!isset(self::$connections[$key][$target])) {
      self::$connections[$key][$target] = self::openConnection($key, $target);
    }
    return self::$connections[$key][$target];
  }

  final public static function isActiveConnection() {
    return !empty(self::$activeKey) && !empty(self::$connections) && !empty(self::$connections[self::$activeKey]);
  }

  final public static function setActiveConnection($key = 'default') {
    if (empty(self::$databaseInfo)) {
      self::parseConnectionInfo();
    }

    if (!empty(self::$databaseInfo[$key])) {
      $old_key = self::$activeKey;
      self::$activeKey = $key;
      return $old_key;
    }
  }

  final public static function parseConnectionInfo() {
    global $databases;

    $database_info = is_array($databases) ? $databases : [];
    foreach ($database_info as $index => $info) {
      foreach ($database_info[$index] as $target => $value) {
        if (empty($value['driver'])) {
          $database_info[$index][$target] = $database_info[$index][$target][mt_rand(0, count($database_info[$index][$target]) - 1)];
        }

        if (!isset($database_info[$index][$target]['prefix'])) {
          $database_info[$index][$target]['prefix'] = array(
            'default' => '',
          );
        }
        elseif (!is_array($database_info[$index][$target]['prefix'])) {
          $database_info[$index][$target]['prefix'] = array(
            'default' => $database_info[$index][$target]['prefix'],
          );
        }
      }
    }

    if (!is_array(self::$databaseInfo)) {
      self::$databaseInfo = $database_info;
    }

    else {
      foreach ($database_info as $database_key => $database_values) {
        foreach ($database_values as $target => $target_values) {
          self::$databaseInfo[$database_key][$target] = $target_values;
        }
      }
    }
  }

  public static function addConnectionInfo($key, $target, $info) {
    if (empty(self::$databaseInfo[$key][$target])) {
      self::$databaseInfo[$key][$target] = $info;
    }
  }

  final public static function getConnectionInfo($key = 'default') {
    if (empty(self::$databaseInfo)) {
      self::parseConnectionInfo();
    }

    if (!empty(self::$databaseInfo[$key])) {
      return self::$databaseInfo[$key];
    }
  }

  final public static function renameConnection($old_key, $new_key) {
    if (empty(self::$databaseInfo)) {
      self::parseConnectionInfo();
    }

    if (!empty(self::$databaseInfo[$old_key]) && empty(self::$databaseInfo[$new_key])) {
      self::$databaseInfo[$new_key] = self::$databaseInfo[$old_key];
      unset(self::$databaseInfo[$old_key]);

      if (isset(self::$connections[$old_key])) {
        self::$connections[$new_key] = self::$connections[$old_key];
        unset(self::$connections[$old_key]);
      }

      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  final public static function removeConnection($key) {
    if (isset(self::$databaseInfo[$key])) {
      self::closeConnection(NULL, $key);
      unset(self::$databaseInfo[$key]);
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  final protected static function openConnection($key, $target) {
    if (empty(self::$databaseInfo)) {
      self::parseConnectionInfo();
    }

    if (!isset(self::$databaseInfo[$key])) {
      throw new DatabaseConnectionNotDefinedException('The specified database connection is not defined: ' . $key);
    }

    if (!$driver = self::$databaseInfo[$key][$target]['driver']) {
      throw new DatabaseDriverNotSpecifiedException('Driver not specified for this database connection: ' . $key);
    }

    $driver_class = 'DatabaseConnection_' . $driver;
    require_once DRUPAL_ROOT . '/includes/database/' . $driver . '/database.inc';
    $new_connection = new $driver_class(self::$databaseInfo[$key][$target]);
    $new_connection->setTarget($target);
    $new_connection->setKey($key);

    if (!empty(self::$logs[$key])) {
      $new_connection->setLogger(self::$logs[$key]);
    }

    return $new_connection;
  }

  public static function closeConnection($target = NULL, $key = NULL) {
    if (!isset($key)) {
      $key = self::$activeKey;
    }

    if (isset($target)) {
      if (isset(self::$connections[$key][$target])) {
        self::$connections[$key][$target]->destroy();
        self::$connections[$key][$target] = NULL;
      }
      unset(self::$connections[$key][$target]);
    }
    else {
      if (isset(self::$connections[$key])) {
        foreach (self::$connections[$key] as $target => $connection) {
          self::$connections[$key][$target]->destroy();
          self::$connections[$key][$target] = NULL;
        }
      }
      unset(self::$connections[$key]);
    }
  }

  public static function ignoreTarget($key, $target) {
    self::$ignoreTargets[$key][$target] = TRUE;
  }

  public static function loadDriverFile($driver, array $files = []) {
    static $base_path;

    if (empty($base_path)) {
      $base_path = dirname(realpath(__FILE__));
    }

    $driver_base_path = "$base_path/$driver";
    foreach ($files as $file) {
      foreach (array("$base_path/$file", "$driver_base_path/$file") as $filename) {
        if (file_exists($filename)) {
          require_once $filename;
        }
      }
    }
  }
}

class DatabaseTransactionNoActiveException extends \Exception { }


class DatabaseTransactionNameNonUniqueException extends \Exception { }


class DatabaseTransactionCommitFailedException extends \Exception { }

class DatabaseTransactionExplicitCommitNotAllowedException extends \Exception { }

class DatabaseTransactionOutOfOrderException extends \Exception { }

class InvalidMergeQueryException extends \Exception {}

class FieldsOverlapException extends \Exception {}

class NoFieldsException extends \Exception {}

class DatabaseConnectionNotDefinedException extends \Exception {}

class DatabaseDriverNotSpecifiedException extends \Exception {}

class DatabaseTransaction {

  protected $connection;

  protected $rolledBack = FALSE;

  protected $name;

  public function __construct(DatabaseConnection $connection, $name = NULL) {
    $this->connection = $connection;
    if (!$depth = $connection->transactionDepth()) {
      $this->name = 'drupal_transaction';
    }
    elseif (!$name) {
      $this->name = 'savepoint_' . $depth;
    }
    else {
      $this->name = $name;
    }
    $this->connection->pushTransaction($this->name);
  }

  public function __destruct() {
    if (!$this->rolledBack) {
      $this->connection->popTransaction($this->name);
    }
  }

  public function name() {
    return $this->name;
  }

  public function rollback() {
    $this->rolledBack = TRUE;
    $this->connection->rollback($this->name);
  }
}

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
