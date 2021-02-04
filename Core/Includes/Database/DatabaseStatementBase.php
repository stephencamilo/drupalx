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

class DatabaseStatementBase extends \PDOStatement implements DatabaseStatementInterface {

  public $dbh;

  protected function __construct($dbh) {
    $this->dbh = $dbh;
    $this->setFetchMode(PDO::FETCH_OBJ);
  }

  public function execute($args = [], $options = []) {
    if (isset($options['fetch'])) {
      if (is_string($options['fetch'])) {

        $this->setFetchMode(PDO::FETCH_CLASS, $options['fetch']);
      }
      else {
        $this->setFetchMode($options['fetch']);
      }
    }

    $logger = $this->dbh->getLogger();
    if (!empty($logger)) {
      $query_start = microtime(TRUE);
    }

    $return = parent::execute($args);

    if (!empty($logger)) {
      $query_end = microtime(TRUE);
      $logger->log($this, $args, $query_end - $query_start);
    }

    return $return;
  }

  public function getQueryString() {
    return $this->queryString;
  }

  public function fetchCol($index = 0) {
    return $this->fetchAll(PDO::FETCH_COLUMN, $index);
  }

  public function fetchAllAssoc($key, $fetch = NULL) {
    $return = [];
    if (isset($fetch)) {
      if (is_string($fetch)) {
        $this->setFetchMode(PDO::FETCH_CLASS, $fetch);
      }
      else {
        $this->setFetchMode($fetch);
      }
    }

    foreach ($this as $record) {
      $record_key = is_object($record) ? $record->$key : $record[$key];
      $return[$record_key] = $record;
    }

    return $return;
  }

  public function fetchAllKeyed($key_index = 0, $value_index = 1) {
    $return = [];
    $this->setFetchMode(PDO::FETCH_NUM);
    foreach ($this as $record) {
      $return[$record[$key_index]] = $record[$value_index];
    }
    return $return;
  }

  public function fetchField($index = 0) {
    return $this->fetchColumn($index);
  }

  public function fetchAssoc() {
    return $this->fetch(PDO::FETCH_ASSOC);
  }

  function db_query($query, array $args = [], array $options = []) {
    if (empty($options['target'])) {
      $options['target'] = 'default';
    }

    return Database::getConnection($options['target'])->query($query, $args, $options);
  }

  function db_query_range($query, $from, $count, array $args = [], array $options = []) {
    if (empty($options['target'])) {
      $options['target'] = 'default';
    }

    return Database::getConnection($options['target'])->queryRange($query, $from, $count, $args, $options);
  }

  function db_query_temporary($query, array $args = [], array $options = []) {
    if (empty($options['target'])) {
      $options['target'] = 'default';
    }

    return Database::getConnection($options['target'])->queryTemporary($query, $args, $options);
  }

  function db_insert($table, array $options = []) {
    if (empty($options['target']) || $options['target'] == 'slave') {
      $options['target'] = 'default';
    }
    return Database::getConnection($options['target'])->insert($table, $options);
  }

  /**
   * Returns a new MergeQuery object for the active database.
   *
   * @param $table
   *   The table into which to merge.
   * @param $options
   *   An array of options to control how the query operates.
   *
   * @return MergeQuery
   *   A new MergeQuery object for this connection.
   */
  function db_merge($table, array $options = []) {
    if (empty($options['target']) || $options['target'] == 'slave') {
      $options['target'] = 'default';
    }
    return Database::getConnection($options['target'])->merge($table, $options);
  }

  /**
   * Returns a new UpdateQuery object for the active database.
   *
   * @param $table
   *   The table to update.
   * @param $options
   *   An array of options to control how the query operates.
   *
   * @return UpdateQuery
   *   A new UpdateQuery object for this connection.
   */
  function db_update($table, array $options = []) {
    if (empty($options['target']) || $options['target'] == 'slave') {
      $options['target'] = 'default';
    }
    return Database::getConnection($options['target'])->update($table, $options);
  }

  /**
   * Returns a new DeleteQuery object for the active database.
   *
   * @param $table
   *   The table from which to delete.
   * @param $options
   *   An array of options to control how the query operates.
   *
   * @return DeleteQuery
   *   A new DeleteQuery object for this connection.
   */
  function db_delete($table, array $options = []) {
    if (empty($options['target']) || $options['target'] == 'slave') {
      $options['target'] = 'default';
    }
    return Database::getConnection($options['target'])->delete($table, $options);
  }

  /**
   * Returns a new TruncateQuery object for the active database.
   *
   * @param $table
   *   The table from which to delete.
   * @param $options
   *   An array of options to control how the query operates.
   *
   * @return TruncateQuery
   *   A new TruncateQuery object for this connection.
   */
  function db_truncate($table, array $options = []) {
    if (empty($options['target']) || $options['target'] == 'slave') {
      $options['target'] = 'default';
    }
    return Database::getConnection($options['target'])->truncate($table, $options);
  }

  /**
   * Returns a new SelectQuery object for the active database.
   *
   * @param $table
   *   The base table for this query. May be a string or another SelectQuery
   *   object. If a query object is passed, it will be used as a subselect.
   * @param $alias
   *   The alias for the base table of this query.
   * @param $options
   *   An array of options to control how the query operates.
   *
   * @return SelectQuery
   *   A new SelectQuery object for this connection.
   */
  function db_select($table, $alias = NULL, array $options = []) {
    if (empty($options['target'])) {
      $options['target'] = 'default';
    }
    return Database::getConnection($options['target'])->select($table, $alias, $options);
  }

  /**
   * Returns a new transaction object for the active database.
   *
   * @param string $name
   *   Optional name of the transaction.
   * @param array $options
   *   An array of options to control how the transaction operates:
   *   - target: The database target name.
   *
   * @return DatabaseTransaction
   *   A new DatabaseTransaction object for this connection.
   */
  function db_transaction($name = NULL, array $options = []) {
    if (empty($options['target'])) {
      $options['target'] = 'default';
    }
    return Database::getConnection($options['target'])->startTransaction($name);
  }

  /**
   * Sets a new active database.
   *
   * @param $key
   *   The key in the $databases array to set as the default database.
   *
   * @return
   *   The key of the formerly active database.
   */
  function db_set_active($key = 'default') {
    return Database::setActiveConnection($key);
  }

  /**
   * Restricts a dynamic table name to safe characters.
   *
   * Only keeps alphanumeric and underscores.
   *
   * @param $table
   *   The table name to escape.
   *
   * @return
   *   The escaped table name as a string.
   */
  function db_escape_table($table) {
    return Database::getConnection()->escapeTable($table);
  }

  /**
   * Restricts a dynamic column or constraint name to safe characters.
   *
   * Only keeps alphanumeric and underscores.
   *
   * @param $field
   *   The field name to escape.
   *
   * @return
   *   The escaped field name as a string.
   */
  function db_escape_field($field) {
    return Database::getConnection()->escapeField($field);
  }

  /**
   * Escapes characters that work as wildcard characters in a LIKE pattern.
   *
   * The wildcard characters "%" and "_" as well as backslash are prefixed with
   * a backslash. Use this to do a search for a verbatim string without any
   * wildcard behavior.
   *
   * For example, the following does a case-insensitive query for all rows whose
   * name starts with $prefix:
   * @code
   * $result = db_query(
   *   'SELECT * FROM person WHERE name LIKE :pattern',
   *   array(':pattern' => db_like($prefix) . '%')
   * );
   * @endcode
   *
   * Backslash is defined as escape character for LIKE patterns in
   * DatabaseCondition::mapConditionOperator().
   *
   * @param $string
   *   The string to escape.
   *
   * @return
   *   The escaped string.
   */
  function db_like($string) {
    return Database::getConnection()->escapeLike($string);
  }

  /**
   * Retrieves the name of the currently active database driver.
   *
   * @return
   *   The name of the currently active database driver.
   */
  function db_driver() {
    return Database::getConnection()->driver();
  }

  /**
   * Closes the active database connection.
   *
   * @param $options
   *   An array of options to control which connection is closed. Only the target
   *   key has any meaning in this case.
   */
  function db_close(array $options = []) {
    if (empty($options['target'])) {
      $options['target'] = NULL;
    }
    Database::closeConnection($options['target']);
  }

  /**
   * Retrieves a unique id.
   *
   * Use this function if for some reason you can't use a serial field. Using a
   * serial field is preferred, and InsertQuery::execute() returns the value of
   * the last ID inserted.
   *
   * @param $existing_id
   *   After a database import, it might be that the sequences table is behind, so
   *   by passing in a minimum ID, it can be assured that we never issue the same
   *   ID.
   *
   * @return
   *   An integer number larger than any number returned before for this sequence.
   */
  function db_next_id($existing_id = 0) {
    return Database::getConnection()->nextId($existing_id);
  }

  /**
   * Returns a new DatabaseCondition, set to "OR" all conditions together.
   *
   * @return DatabaseCondition
   */
  function db_or() {
    return new DatabaseCondition('OR');
  }

  /**
   * Returns a new DatabaseCondition, set to "AND" all conditions together.
   *
   * @return DatabaseCondition
   */
  function db_and() {
    return new DatabaseCondition('AND');
  }

  /**
   * Returns a new DatabaseCondition, set to "XOR" all conditions together.
   *
   * @return DatabaseCondition
   */
  function db_xor() {
    return new DatabaseCondition('XOR');
  }

  /**
   * Returns a new DatabaseCondition, set to the specified conjunction.
   *
   * Internal API function call.  The db_and(), db_or(), and db_xor()
   * functions are preferred.
   *
   * @param $conjunction
   *   The conjunction to use for query conditions (AND, OR or XOR).
   * @return DatabaseCondition
   */
  function db_condition($conjunction) {
    return new DatabaseCondition($conjunction);
  }

  /**
   * @} End of "defgroup database".
   */


  /**
   * @addtogroup schemaapi
   * @{
   */

  /**
   * Creates a new table from a Drupal table definition.
   *
   * @param $name
   *   The name of the table to create.
   * @param $table
   *   A Schema API table definition array.
   */
  function db_create_table($name, $table) {
    return Database::getConnection()->schema()->createTable($name, $table);
  }

  /**
   * Returns an array of field names from an array of key/index column specifiers.
   *
   * This is usually an identity function but if a key/index uses a column prefix
   * specification, this function extracts just the name.
   *
   * @param $fields
   *   An array of key/index column specifiers.
   *
   * @return
   *   An array of field names.
   */
  function db_field_names($fields) {
    return Database::getConnection()->schema()->fieldNames($fields);
  }

  /**
   * Checks if an index exists in the given table.
   *
   * @param $table
   *   The name of the table in drupal (no prefixing).
   * @param $name
   *   The name of the index in drupal (no prefixing).
   *
   * @return
   *   TRUE if the given index exists, otherwise FALSE.
   */
  function db_index_exists($table, $name) {
    return Database::getConnection()->schema()->indexExists($table, $name);
  }

  /**
   * Checks if a table exists.
   *
   * @param $table
   *   The name of the table in drupal (no prefixing).
   *
   * @return
   *   TRUE if the given table exists, otherwise FALSE.
   */
  function db_table_exists($table) {
    return Database::getConnection()->schema()->tableExists($table);
  }

  /**
   * Checks if a column exists in the given table.
   *
   * @param $table
   *   The name of the table in drupal (no prefixing).
   * @param $field
   *   The name of the field.
   *
   * @return
   *   TRUE if the given column exists, otherwise FALSE.
   */
  function db_field_exists($table, $field) {
    return Database::getConnection()->schema()->fieldExists($table, $field);
  }

  /**
   * Finds all tables that are like the specified base table name.
   *
   * @param $table_expression
   *   An SQL expression, for example "simpletest%" (without the quotes).
   *
   * @return
   *   Array, both the keys and the values are the matching tables.
   */
  function db_find_tables($table_expression) {
    return Database::getConnection()->schema()->findTables($table_expression);
  }

  /**
   * Finds all tables that are like the specified base table name. This is a
   * backport of the change made to db_find_tables in Drupal 8 to work with
   * virtual, un-prefixed table names. The original function is retained for
   * Backwards Compatibility.
   * @see https://www.drupal.org/node/2552435
   *
   * @param $table_expression
   *   An SQL expression, for example "simpletest%" (without the quotes).
   *
   * @return
   *   Array, both the keys and the values are the matching tables.
   */
  function db_find_tables_d8($table_expression) {
    return Database::getConnection()->schema()->findTablesD8($table_expression);
  }

  function _db_create_keys_sql($spec) {
    return Database::getConnection()->schema()->createKeysSql($spec);
  }

  /**
   * Renames a table.
   *
   * @param $table
   *   The current name of the table to be renamed.
   * @param $new_name
   *   The new name for the table.
   */
  function db_rename_table($table, $new_name) {
    return Database::getConnection()->schema()->renameTable($table, $new_name);
  }

  /**
   * Drops a table.
   *
   * @param $table
   *   The table to be dropped.
   */
  function db_drop_table($table) {
    return Database::getConnection()->schema()->dropTable($table);
  }

  /**
   * Adds a new field to a table.
   *
   * @param $table
   *   Name of the table to be altered.
   * @param $field
   *   Name of the field to be added.
   * @param $spec
   *   The field specification array, as taken from a schema definition. The
   *   specification may also contain the key 'initial'; the newly-created field
   *   will be set to the value of the key in all rows. This is most useful for
   *   creating NOT NULL columns with no default value in existing tables.
   * @param $keys_new
   *   (optional) Keys and indexes specification to be created on the table along
   *   with adding the field. The format is the same as a table specification, but
   *   without the 'fields' element. If you are adding a type 'serial' field, you
   *   MUST specify at least one key or index including it in this array. See
   *   db_change_field() for more explanation why.
   *
   * @see db_change_field()
   */
  function db_add_field($table, $field, $spec, $keys_new = []) {
    return Database::getConnection()->schema()->addField($table, $field, $spec, $keys_new);
  }

  /**
   * Drops a field.
   *
   * @param $table
   *   The table to be altered.
   * @param $field
   *   The field to be dropped.
   */
  function db_drop_field($table, $field) {
    return Database::getConnection()->schema()->dropField($table, $field);
  }

  /**
   * Sets the default value for a field.
   *
   * @param $table
   *   The table to be altered.
   * @param $field
   *   The field to be altered.
   * @param $default
   *   Default value to be set. NULL for 'default NULL'.
   */
  function db_field_set_default($table, $field, $default) {
    return Database::getConnection()->schema()->fieldSetDefault($table, $field, $default);
  }

  /**
   * Sets a field to have no default value.
   *
   * @param $table
   *   The table to be altered.
   * @param $field
   *   The field to be altered.
   */
  function db_field_set_no_default($table, $field) {
    return Database::getConnection()->schema()->fieldSetNoDefault($table, $field);
  }

  /**
   * Adds a primary key to a database table.
   *
   * @param $table
   *   Name of the table to be altered.
   * @param $fields
   *   Array of fields for the primary key.
   */
  function db_add_primary_key($table, $fields) {
    return Database::getConnection()->schema()->addPrimaryKey($table, $fields);
  }

  /**
   * Drops the primary key of a database table.
   *
   * @param $table
   *   Name of the table to be altered.
   */
  function db_drop_primary_key($table) {
    return Database::getConnection()->schema()->dropPrimaryKey($table);
  }

  /**
   * Adds a unique key.
   *
   * @param $table
   *   The table to be altered.
   * @param $name
   *   The name of the key.
   * @param $fields
   *   An array of field names.
   */
  function db_add_unique_key($table, $name, $fields) {
    return Database::getConnection()->schema()->addUniqueKey($table, $name, $fields);
  }

  /**
   * Drops a unique key.
   *
   * @param $table
   *   The table to be altered.
   * @param $name
   *   The name of the key.
   */
  function db_drop_unique_key($table, $name) {
    return Database::getConnection()->schema()->dropUniqueKey($table, $name);
  }

  /**
   * Adds an index.
   *
   * @param $table
   *   The table to be altered.
   * @param $name
   *   The name of the index.
   * @param $fields
   *   An array of field names.
   */
  function db_add_index($table, $name, $fields) {
    return Database::getConnection()->schema()->addIndex($table, $name, $fields);
  }

  /**
   * Drops an index.
   *
   * @param $table
   *   The table to be altered.
   * @param $name
   *   The name of the index.
   */
  function db_drop_index($table, $name) {
    return Database::getConnection()->schema()->dropIndex($table, $name);
  }

  /**
   * Changes a field definition.
   *
   * IMPORTANT NOTE: To maintain database portability, you have to explicitly
   * recreate all indices and primary keys that are using the changed field.
   *
   * That means that you have to drop all affected keys and indexes with
   * db_drop_{primary_key,unique_key,index}() before calling db_change_field().
   * To recreate the keys and indices, pass the key definitions as the optional
   * $keys_new argument directly to db_change_field().
   *
   * For example, suppose you have:
   * @code
   * $schema['foo'] = array(
   *   'fields' => array(
   *     'bar' => array('type' => 'int', 'not null' => TRUE)
   *   ),
   *   'primary key' => array('bar')
   * );
   * @endcode
   * and you want to change foo.bar to be type serial, leaving it as the primary
   * key. The correct sequence is:
   * @code
   * db_drop_primary_key('foo');
   * db_change_field('foo', 'bar', 'bar',
   *   array('type' => 'serial', 'not null' => TRUE),
   *   array('primary key' => array('bar')));
   * @endcode
   *
   * The reasons for this are due to the different database engines:
   *
   * On PostgreSQL, changing a field definition involves adding a new field and
   * dropping an old one which causes any indices, primary keys and sequences
   * (from serial-type fields) that use the changed field to be dropped.
   *
   * On MySQL, all type 'serial' fields must be part of at least one key or index
   * as soon as they are created. You cannot use
   * db_add_{primary_key,unique_key,index}() for this purpose because the ALTER
   * TABLE command will fail to add the column without a key or index
   * specification. The solution is to use the optional $keys_new argument to
   * create the key or index at the same time as field.
   *
   * You could use db_add_{primary_key,unique_key,index}() in all cases unless you
   * are converting a field to be type serial. You can use the $keys_new argument
   * in all cases.
   *
   * @param $table
   *   Name of the table.
   * @param $field
   *   Name of the field to change.
   * @param $field_new
   *   New name for the field (set to the same as $field if you don't want to
   *   change the name).
   * @param $spec
   *   The field specification for the new field.
   * @param $keys_new
   *   (optional) Keys and indexes specification to be created on the table along
   *   with changing the field. The format is the same as a table specification
   *   but without the 'fields' element.
   */
  function db_change_field($table, $field, $field_new, $spec, $keys_new = []) {
    return Database::getConnection()->schema()->changeField($table, $field, $field_new, $spec, $keys_new);
  }

  /**
   * @} End of "addtogroup schemaapi".
   */

  /**
   * Sets a session variable specifying the lag time for ignoring a slave server.
   */
  function db_ignore_slave() {
    $connection_info = Database::getConnectionInfo();


    if (count($connection_info) > 1) {



      $duration = $bootstrap->variable_get('maximum_replication_lag', 300);

      $_SESSION['ignore_slave_server'] = REQUEST_TIME + $duration;
    }
  }
}
