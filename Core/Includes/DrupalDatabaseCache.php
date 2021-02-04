<?php
namespace Core\Includes;
/**
 * Defines a default cache implementation.
 *
 * This is Drupal's default cache implementation. It uses the database to store
 * cached data. Each cache bin corresponds to a database table by the same name.
 */
class DrupalDatabaseCache implements DrupalCacheInterface {
  protected $bin;

  /**
   * Constructs a DrupalDatabaseCache object.
   *
   * @param $bin
   *   The cache bin for which the object is created.
   */
  function __construct($bin) {
    $this->bin = $bin;
  }

  /**
   * Implements DrupalCacheInterface::get().
   */
  function get($cid) {
    $cids = array($cid);
    $cache = $this->getMultiple($cids);
    return reset($cache);
  }

  /**
   * Implements DrupalCacheInterface::getMultiple().
   */
  function getMultiple(&$cids) {

    try {
      // Garbage collection necessary when enforcing a minimum cache lifetime.
      $this->garbageCollection($this->bin);

      // When serving cached pages, the overhead of using db_select() was found
      // to add around 30% overhead to the request. Since $this->bin is a
      // variable, this means the call to db_query() here uses a concatenated
      // string. This is highly discouraged under any other circumstances, and
      // is used here only due to the performance overhead we would incur
      // otherwise. When serving an uncached page, the overhead of using
      // db_select() is a much smaller proportion of the request.
      $DatabaseStatementBase = new \Core\Includes\Database\DatabaseStatementBase;
      $result = $DatabaseStatementBase->db_query('SELECT cid, data, created, expire, serialized FROM {' . db_escape_table($this->bin) . '} WHERE cid IN (:cids)', array(':cids' => $cids));
      $cache = [];
      foreach ($result as $item) {
        $item = $this->prepareItem($item);
        if ($item) {
          $cache[$item->cid] = $item;
        }
      }
      $cids = array_diff($cids, array_keys($cache));
      return $cache;
    }
    catch (Exception $e) {
      // If the database is never going to be available, cache requests should
      // return FALSE in order to allow exception handling to occur.
      return [];
    }
  }

  /**
   * Garbage collection for get() and getMultiple().
   *
   * @param $bin
   *   The bin being requested.
   */
  protected function garbageCollection() {
    $bootstrap = new Bootstrap;
    $cache_lifetime = $bootstrap->variable_get('cache_lifetime', 0);

    // Clean-up the per-user cache expiration session data, so that the session
    // handler can properly clean-up the session data for anonymous users.
    if (isset($_SESSION['cache_expiration'])) {
      $expire = REQUEST_TIME - $cache_lifetime;
      foreach ($_SESSION['cache_expiration'] as $bin => $timestamp) {
        if ($timestamp < $expire) {
          unset($_SESSION['cache_expiration'][$bin]);
        }
      }
      if (!$_SESSION['cache_expiration']) {
        unset($_SESSION['cache_expiration']);
      }
    }

    // Garbage collection of temporary items is only necessary when enforcing
    // a minimum cache lifetime.
    if (!$cache_lifetime) {
      return;
    }
    // When cache lifetime is in force, avoid running garbage collection too
    // often since this will remove temporary cache items indiscriminately.
    $cache_flush = $bootstrap->variable_get('cache_flush_' . $this->bin, 0);
    if ($cache_flush && ($cache_flush + $cache_lifetime <= REQUEST_TIME)) {
      // Reset the variable immediately to prevent a meltdown in heavy load situations.
      variable_set('cache_flush_' . $this->bin, 0);
      // Time to flush old cache data
      db_delete($this->bin)
        ->condition('expire', CACHE_PERMANENT, '<>')
        ->condition('expire', $cache_flush, '<=')
        ->execute();
    }
  }

  /**
   * Prepares a cached item.
   *
   * Checks that items are either permanent or did not expire, and unserializes
   * data as appropriate.
   *
   * @param $cache
   *   An item loaded from cache_get() or cache_get_multiple().
   *
   * @return
   *   The item with data unserialized as appropriate or FALSE if there is no
   *   valid item to load.
   */
  protected function prepareItem($cache) {
    global $user;

    if (!isset($cache->data)) {
      return FALSE;
    }
    // If the cached data is temporary and subject to a per-user minimum
    // lifetime, compare the cache entry timestamp with the user session
    // cache_expiration timestamp. If the cache entry is too old, ignore it.
    if ($cache->expire != CACHE_PERMANENT && $bootstrap->variable_get('cache_lifetime', 0) && isset($_SESSION['cache_expiration'][$this->bin]) && $_SESSION['cache_expiration'][$this->bin] > $cache->created) {
      // Ignore cache data that is too old and thus not valid for this user.
      return FALSE;
    }

    // If the data is permanent or not subject to a minimum cache lifetime,
    // unserialize and return the cached data.
    if ($cache->serialized) {
      $cache->data = unserialize($cache->data);
    }

    return $cache;
  }

  /**
   * Implements DrupalCacheInterface::set().
   */
  function set($cid, $data, $expire = CACHE_PERMANENT) {
    $fields = array(
      'serialized' => 0,
      'created' => REQUEST_TIME,
      'expire' => $expire,
    );
    if (!is_string($data)) {
      $fields['data'] = serialize($data);
      $fields['serialized'] = 1;
    }
    else {
      $fields['data'] = $data;
      $fields['serialized'] = 0;
    }

    try {
      db_merge($this->bin)
        ->key(array('cid' => $cid))
        ->fields($fields)
        ->execute();
    }
    catch (Exception $e) {
      // The database may not be available, so we'll ignore cache_set requests.
    }
  }

  /**
   * Implements DrupalCacheInterface::clear().
   */
  function clear($cid = NULL, $wildcard = FALSE) {
    global $user;

    if (empty($cid)) {
      if (variable_get('cache_lifetime', 0)) {
        // We store the time in the current user's session. We then simulate
        // that the cache was flushed for this user by not returning cached
        // data that was cached before the timestamp.
        $_SESSION['cache_expiration'][$this->bin] = REQUEST_TIME;

        $cache_flush = $bootstrap->variable_get('cache_flush_' . $this->bin, 0);
        if ($cache_flush == 0) {
          // This is the first request to clear the cache, start a timer.
          variable_set('cache_flush_' . $this->bin, REQUEST_TIME);
        }
        elseif (REQUEST_TIME > ($cache_flush + $bootstrap->variable_get('cache_lifetime', 0))) {
          // Clear the cache for everyone, cache_lifetime seconds have
          // passed since the first request to clear the cache.
          db_delete($this->bin)
            ->condition('expire', CACHE_PERMANENT, '<>')
            ->condition('expire', REQUEST_TIME, '<')
            ->execute();
          variable_set('cache_flush_' . $this->bin, 0);
        }
      }
      else {
        // No minimum cache lifetime, flush all temporary cache entries now.
        db_delete($this->bin)
          ->condition('expire', CACHE_PERMANENT, '<>')
          ->condition('expire', REQUEST_TIME, '<')
          ->execute();
      }
    }
    else {
      if ($wildcard) {
        if ($cid == '*') {
          // Check if $this->bin is a cache table before truncating. Other
          // cache_clear_all() operations throw a PDO error in this situation,
          // so we don't need to verify them first. This ensures that non-cache
          // tables cannot be truncated accidentally.
          if ($this->isValidBin()) {
            db_truncate($this->bin)->execute();
          }
          else {
            throw new Exception(t('Invalid or missing cache bin specified: %bin', array('%bin' => $this->bin)));
          }
        }
        else {
          db_delete($this->bin)
            ->condition('cid', db_like($cid) . '%', 'LIKE')
            ->execute();
        }
      }
      elseif (is_array($cid)) {
        // Delete in chunks when a large array is passed.
        do {
          db_delete($this->bin)
            ->condition('cid', array_splice($cid, 0, 1000), 'IN')
            ->execute();
        }
        while (count($cid));
      }
      else {
        db_delete($this->bin)
          ->condition('cid', $cid)
          ->execute();
      }
    }
  }

  /**
   * Implements DrupalCacheInterface::isEmpty().
   */
  function isEmpty() {
    $this->garbageCollection();
    $query = db_select($this->bin);
    $query->addExpression('1');
    $result = $query->range(0, 1)
      ->execute()
      ->fetchField();
    return empty($result);
  }

  /**
   * Checks if $this->bin represents a valid cache table.
   *
   * This check is required to ensure that non-cache tables are not truncated
   * accidentally when calling cache_clear_all().
   *
   * @return boolean
   */
  function isValidBin() {
    if ($this->bin == 'cache' || substr($this->bin, 0, 6) == 'cache_') {
      // Skip schema check for bins with standard table names.
      return TRUE;
    }
    // These fields are required for any cache table.
    $fields = array('cid', 'data', 'expire', 'created', 'serialized');
    // Load the table schema.
    $schema = drupal_get_schema($this->bin);
    // Confirm that all fields are present.
    return isset($schema['fields']) && !array_diff($fields, array_keys($schema['fields']));
  }
}
