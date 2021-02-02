<?php

namespace Core\Includes;

class Bootstrap {
  /**
   * @file
   * Functions that need to be loaded on every Drupal request.
   */

  /**
   * The current system version.
   */
  static $version = '7.78';

  /**
   * Core API compatibility.
   */
  static $drupal_core_compatibility = '7.x';

  /**
   * Minimum supported version of PHP.
   */
  static $drupal_minimum_php = '5.2.4';

  /**
   * Minimum recommended value of PHP memory_limit.
   */
  static $drupal_minimum_php_memory_limit = '32M';

  /**
   * Error reporting level: display no errors.
   */
  static $error_reporting_hide = 0;

  /**
   * Error reporting level: display errors and warnings.
   */
  static $error_reporting_display_some = 1;

  /**
   * Error reporting level: display all messages.
   */
  static $error_reporting_display_all = 2;

  /**
   * Indicates that the item should never be removed unless explicitly selected.
   *
   * The item may be removed using cache_clear_all() with a cache ID.
   */
  static $cache_permanent = 0;

  /**
   * Indicates that the item should be removed at the next general cache wipe.
   */
  static $cache_temporary = -1;

  /**
   * @defgroup logging_severity_levels Logging severity levels
   * @{
   * Logging severity levels as defined in RFC 3164.
   *
   * The WATCHDOG_* constant definitions correspond to the logging severity levels
   * defined in RFC 3164, section 4.1.1. PHP supplies predefined LOG_* constants
   * for use in the syslog() function, but their values on Windows builds do not
   * correspond to RFC 3164. The associated PHP bug report was closed with the
   * comment, "And it's also not a bug, as Windows just have less log levels,"
   * and "So the behavior you're seeing is perfectly normal."
   *
   * @see http://www.faqs.org/rfcs/rfc3164.html
   * @see http://bugs.php.net/bug.php?id=18090
   * @see http://php.net/manual/function.syslog.php
   * @see http://php.net/manual/network.constants.php
   * @see watchdog()
   * @see watchdog_severity_levels()
   */

  /**
   * Log message severity -- Emergency: system is unusable.
   */
  static $watchdog_emergency = 0;

  /**
   * Log message severity -- Alert: action must be taken immediately.
   */
  static $watchdog_alert = 1;

  /**
   * Log message severity -- Critical conditions.
   */
  static $watchdog_critical = 2;

  /**
   * Log message severity -- Error conditions.
   */
  static $watchdog_error = 3;

  /**
   * Log message severity -- Warning conditions.
   */
  static $watchdog_warning = 4;

  /**
   * Log message severity -- Normal but significant conditions.
   */
  static $watchdog_notice = 5;

  /**
   * Log message severity -- Informational messages.
   */
  static $watchdog_info = 6;

  /**
   * Log message severity -- Debug-level messages.
   */
  static $watchdog_debug = 7;

  /**
   * @} End of "defgroup logging_severity_levels".
   */

  /**
   * First bootstrap phase: initialize configuration.
   */
  static $drupal_bootstrap_configuration = 0;

  /**
   * Second bootstrap phase: try to serve a cached page.
   */
  static $drupal_bootstrap_page_cache = 1;

  /**
   * Third bootstrap phase: initialize database layer.
   */
  static $drupal_bootstrap_database = 2;

  /**
   * Fourth bootstrap phase: initialize the variable system.
   */
  static $drupal_bootstrap_variables = 3;

  /**
   * Fifth bootstrap phase: initialize session handling.
   */
  static $drupal_bootstrap_session = 4;

  /**
   * Sixth bootstrap phase: set up the page header.
   */
  static $drupal_bootstrap_page_header = 5;

  /**
   * Seventh bootstrap phase: find out language of the page.
   */
  static $drupal_bootstrap_language = 6;

  /**
   * Final bootstrap phase: Drupal is fully loaded; validate and fix input data.
   */
  static $drupal_bootstrap_full = 7;

  /**
   * Role ID for anonymous users; should match what's in the "role" table.
   */
  static $drupal_anonymous_rid = 1;

  /**
   * Role ID for authenticated users; should match what's in the "role" table.
   */
  static $drupal_authenticated_rid = 2;

  /**
   * The number of bytes in a kilobyte.
   *
   * For more information, visit http://en.wikipedia.org/wiki/Kilobyte.
   */
  static $drupal_kilobyte = 1024;

  /**
   * The language code used when no language is explicitly assigned.
   *
   * Defined by ISO639-2 for "Undetermined".
   */
  static $language_none = 'und';

  /**
   * The type of language used to define the content language.
   */
  static $language_type_content = 'language_content';

  /**
   * The type of language used to select the user interface.
   */
  static $language_type_interface = 'language';

  /**
   * The type of language used for URLs.
   */
  static $language_type_url = 'language_url';

  /**
   * Language written left to right. Possible value of $language->direction.
   */
  static $language_ltr = 0;

  /**
   * Language written right to left. Possible value of $language->direction.
   */
  static $language_rtl = 1;

  /**
   * Time of the current request in seconds elapsed since the Unix Epoch.
   *
   * This differs from $_SERVER['REQUEST_TIME'], which is stored as a float
   * since PHP 5.4.0. Float timestamps confuse most PHP functions
   * (including date_create()).
   *
   * @see http://php.net/manual/reserved.variables.server.php
   * @see http://php.net/manual/function.time.php
   */
  static $request_time = 1;

  /**
   * Flag used to indicate that text is not sanitized, so run check_plain().
   *
   * @see drupal_set_title()
   */
  static $check_plain = 0;

  /**
   * Flag used to indicate that text has already been sanitized.
   *
   * @see drupal_set_title()
   */
  static $pass_through = -1;

  /**
   * Signals that the registry lookup cache should be reset.
   */
  static $registry_reset_lookup_cache = 1;

  /**
   * Signals that the registry lookup cache should be written to storage.
   */
  static $registry_write_lookup_cache = 2;

  /**
   * Regular expression to match PHP function names.
   *
   * @see http://php.net/manual/language.functions.php
   */
  static $drupal_php_function_pattern = '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*';

  /**
   * A RFC7231 Compliant date.
   *
   * http://tools.ietf.org/html/rfc7231#section-7.1.1.1
   *
   * Example: Sun, 06 Nov 1994 08:49:37 GMT
   *
   * This constant was introduced in PHP 7.0.19 and PHP 7.1.5 but needs to be
   * defined by Drupal for earlier PHP versions.
   */
  
  static $date_rfc7231 = 'D, d M Y H:i:s \G\M\T';

  function __construct(){
    $this->errors = new Errors;
  }

  /**
   * Starts the timer with the specified name.
   *
   * If you start and stop the same timer multiple times, the measured intervals
   * will be accumulated.
   *
   * @param $name
   *   The name of the timer.
   */
  function timer_start($name) {
    global $timers;

    $timers[$name]['start'] = microtime(TRUE);
    $timers[$name]['count'] = isset($timers[$name]['count']) ? ++$timers[$name]['count'] : 1;
  }

  /**
   * Reads the current timer value without stopping the timer.
   *
   * @param $name
   *   The name of the timer.
   *
   * @return
   *   The current timer value in ms.
   */
  function timer_read($name) {
    global $timers;

    if (isset($timers[$name]['start'])) {
      $stop = microtime(TRUE);
      $diff = round(($stop - $timers[$name]['start']) * 1000, 2);

      if (isset($timers[$name]['time'])) {
        $diff += $timers[$name]['time'];
      }
      return $diff;
    }
    return $timers[$name]['time'];
  }

  /**
   * Stops the timer with the specified name.
   *
   * @param $name
   *   The name of the timer.
   *
   * @return
   *   A timer array. The array contains the number of times the timer has been
   *   started and stopped (count) and the accumulated timer value in ms (time).
   */
  function timer_stop($name) {
    global $timers;

    if (isset($timers[$name]['start'])) {
      $stop = microtime(TRUE);
      $diff = round(($stop - $timers[$name]['start']) * 1000, 2);
      if (isset($timers[$name]['time'])) {
        $timers[$name]['time'] += $diff;
      }
      else {
        $timers[$name]['time'] = $diff;
      }
      unset($timers[$name]['start']);
    }

    return $timers[$name];
  }

  /**
   * Returns the appropriate configuration directory.
   *
   * Returns the configuration path based on the site's hostname, port, and
   * pathname. See default.settings.php for examples on how the URL is converted
   * to a directory.
   *
   * @param bool $require_settings
   *   Only configuration directories with an existing settings.php file
   *   will be recognized. Defaults to TRUE. During initial installation,
   *   this is set to FALSE so that Drupal can detect a matching directory,
   *   then create a new settings.php file in it.
   * @param bool $reset
   *   Force a full search for matching directories even if one had been
   *   found previously. Defaults to FALSE.
   *
   * @return
   *   The path of the matching directory.
   *
   * @see default.settings.php
   */
  function conf_path($require_settings = TRUE, $reset = FALSE) {
    $conf = &drupal_static(__FUNCTION__, '');

    if ($conf && !$reset) {
      return $conf;
    }

    $confdir = 'sites';

    $sites = [];
    if (file_exists(DRUPAL_ROOT . '/' . $confdir . '/sites.php')) {
      // This will overwrite $sites with the desired mappings.
      include(DRUPAL_ROOT . '/' . $confdir . '/sites.php');
    }

    $uri = explode('/', $_SERVER['SCRIPT_NAME'] ? $_SERVER['SCRIPT_NAME'] : $_SERVER['SCRIPT_FILENAME']);
    $server = explode('.', implode('.', array_reverse(explode(':', rtrim($_SERVER['HTTP_HOST'], '.')))));
    for ($i = count($uri) - 1; $i > 0; $i--) {
      for ($j = count($server); $j > 0; $j--) {
        $dir = implode('.', array_slice($server, -$j)) . implode('.', array_slice($uri, 0, $i));
        if (isset($sites[$dir]) && file_exists(DRUPAL_ROOT . '/' . $confdir . '/' . $sites[$dir])) {
          $dir = $sites[$dir];
        }
        if (file_exists(DRUPAL_ROOT . '/' . $confdir . '/' . $dir . '/settings.php') || (!$require_settings && file_exists(DRUPAL_ROOT . '/' . $confdir . '/' . $dir))) {
          $conf = "$confdir/$dir";
          return $conf;
        }
      }
    }
    $conf = "$confdir/default";
    return $conf;
  }

  /**
   * Sets appropriate server variables needed for command line scripts to work.
   *
   * This function can be called by command line scripts before bootstrapping
   * Drupal, to ensure that the page loads with the desired server parameters.
   * This is because many parts of Drupal assume that they are running in a web
   * browser and therefore use information from the global PHP $_SERVER variable
   * that does not get set when Drupal is run from the command line.
   *
   * In many cases, the default way in which this function populates the $_SERVER
   * variable is sufficient, and it can therefore be called without passing in
   * any input. However, command line scripts running on a multisite installation
   * (or on any installation that has settings.php stored somewhere other than
   * the sites/default folder) need to pass in the URL of the site to allow
   * Drupal to detect the correct location of the settings.php file. Passing in
   * the 'url' parameter is also required for functions like request_uri() to
   * return the expected values.
   *
   * Most other parameters do not need to be passed in, but may be necessary in
   * some cases; for example, if Drupal's ip_address() function needs to return
   * anything but the standard localhost value ('127.0.0.1'), the command line
   * script should pass in the desired value via the 'REMOTE_ADDR' key.
   *
   * @param $variables
   *   (optional) An associative array of variables within $_SERVER that should
   *   be replaced. If the special element 'url' is provided in this array, it
   *   will be used to populate some of the server defaults; it should be set to
   *   the URL of the current page request, excluding any $_GET request but
   *   including the script name (e.g., http://www.example.com/mysite/index.php).
   *
   * @see conf_path()
   * @see request_uri()
   * @see ip_address()
   */
  function drupal_override_server_variables($variables = []) {
    // Allow the provided URL to override any existing values in $_SERVER.
    if (isset($variables['url'])) {
      $url = parse_url($variables['url']);
      if (isset($url['host'])) {
        $_SERVER['HTTP_HOST'] = $url['host'];
      }
      if (isset($url['path'])) {
        $_SERVER['SCRIPT_NAME'] = $url['path'];
      }
      unset($variables['url']);
    }
    // Define default values for $_SERVER keys. These will be used if $_SERVER
    // does not already define them and no other values are passed in to this
    // function.
    $defaults = array(
      'HTTP_HOST' => 'localhost',
      'SCRIPT_NAME' => NULL,
      'REMOTE_ADDR' => '127.0.0.1',
      'REQUEST_METHOD' => 'GET',
      'SERVER_NAME' => NULL,
      'SERVER_SOFTWARE' => NULL,
      'HTTP_USER_AGENT' => NULL,
    );
    // Replace elements of the $_SERVER array, as appropriate.
    $_SERVER = $variables + $_SERVER + $defaults;
  }

  /**
   * Initializes the PHP environment.
   */
  function drupal_environment_initialize() {
    if (!isset($_SERVER['HTTP_REFERER'])) {
      $_SERVER['HTTP_REFERER'] = '';
    }
    if (!isset($_SERVER['SERVER_PROTOCOL']) || ($_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.0' && $_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.1')) {
      $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
    }

    if (isset($_SERVER['HTTP_HOST'])) {
      // As HTTP_HOST is user input, ensure it only contains characters allowed
      // in hostnames. See RFC 952 (and RFC 2181).
      // $_SERVER['HTTP_HOST'] is lowercased here per specifications.
      $_SERVER['HTTP_HOST'] = strtolower($_SERVER['HTTP_HOST']);
      if (!drupal_valid_http_host($_SERVER['HTTP_HOST'])) {
        // HTTP_HOST is invalid, e.g. if containing slashes it may be an attack.
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        exit;
      }
    }
    else {
      // Some pre-HTTP/1.1 clients will not send a Host header. Ensure the key is
      // defined for E_ALL compliance.
      $_SERVER['HTTP_HOST'] = '';
    }

    // When clean URLs are enabled, emulate ?q=foo/bar using REQUEST_URI. It is
    // not possible to append the query string using mod_rewrite without the B
    // flag (this was added in Apache 2.2.8), because mod_rewrite unescapes the
    // path before passing it on to PHP. This is a problem when the path contains
    // e.g. "&" or "%" that have special meanings in URLs and must be encoded.
    $_GET['q'] = request_path();

    // Enforce E_ALL, but allow users to set levels not part of E_ALL.
    error_reporting(E_ALL | error_reporting());

    // Override PHP settings required for Drupal to work properly.
    // sites/default/default.settings.php contains more runtime settings.
    // The .htaccess file contains settings that cannot be changed at runtime.

    // Don't escape quotes when reading files from the database, disk, etc.
    ini_set('magic_quotes_runtime', '0');
    // Use session cookies, not transparent sessions that puts the session id in
    // the query string.
    ini_set('session.use_cookies', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    // Don't send HTTP headers using PHP's session handler.
    // An empty string is used here to disable the cache limiter.
    ini_set('session.cache_limiter', '');
    // Use httponly session cookies.
    ini_set('session.cookie_httponly', '1');

    // Set sane locale settings, to ensure consistent string, dates, times and
    // numbers handling.
    setlocale(LC_ALL, 'C');

    // PHP's built-in phar:// stream wrapper is not sufficiently secure. Override
    // it with a more secure one, which requires PHP 5.3.3. For lower versions,
    // unregister the built-in one without replacing it. Sites needing phar
    // support for lower PHP versions must implement hook_stream_wrappers() to
    // register their desired implementation.
    if (in_array('phar', stream_get_wrappers(), TRUE)) {
      stream_wrapper_unregister('phar');
      if (version_compare(PHP_VERSION, '5.3.3', '>=')) {
        include_once DRUPAL_ROOT . '/includes/file.phar.inc';
        file_register_phar_wrapper();
      }
    }
  }

  /**
   * Validates that a hostname (for example $_SERVER['HTTP_HOST']) is safe.
   *
   * @return
   *  TRUE if only containing valid characters, or FALSE otherwise.
   */
  function drupal_valid_http_host($host) {
    // Limit the length of the host name to 1000 bytes to prevent DoS attacks with
    // long host names.
    return strlen($host) <= 1000
      // Limit the number of subdomains and port separators to prevent DoS attacks
      // in conf_path().
      && substr_count($host, '.') <= 100
      && substr_count($host, ':') <= 100
      && preg_match('/^\[?(?:[a-zA-Z0-9-:\]_]+\.?)+$/', $host);
  }

  /**
   * Checks whether an HTTPS request is being served.
   *
   * @return bool
   *   TRUE if the request is HTTPS, FALSE otherwise.
   */
  function drupal_is_https() {
    return isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on';
  }

  /**
   * Sets the base URL, cookie domain, and session name from configuration.
   */
  function drupal_settings_initialize() {
    global $base_url, $base_path, $base_root;

    // Export these settings.php variables to the global namespace.
    global $databases, $cookie_domain, $conf, $installed_profile, $update_free_access, $db_url, $db_prefix, $drupal_hash_salt, $is_https, $base_secure_url, $base_insecure_url;
    $conf = [];

    if (file_exists(DRUPAL_ROOT . '/' . conf_path() . '/settings.php')) {
      include_once DRUPAL_ROOT . '/' . conf_path() . '/settings.php';
    }
    $is_https = drupal_is_https();

    if (isset($base_url)) {
      // Parse fixed base URL from settings.php.
      $parts = parse_url($base_url);
      if (!isset($parts['path'])) {
        $parts['path'] = '';
      }
      $base_path = $parts['path'] . '/';
      // Build $base_root (everything until first slash after "scheme://").
      $base_root = substr($base_url, 0, strlen($base_url) - strlen($parts['path']));
    }
    else {
      // Create base URL.
      $http_protocol = $is_https ? 'https' : 'http';
      $base_root = $http_protocol . '://' . $_SERVER['HTTP_HOST'];

      $base_url = $base_root;

      // $_SERVER['SCRIPT_NAME'] can, in contrast to $_SERVER['PHP_SELF'], not
      // be modified by a visitor.
      if ($dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/')) {
        $base_path = $dir;
        $base_url .= $base_path;
        $base_path .= '/';
      }
      else {
        $base_path = '/';
      }
    }
    $base_secure_url = str_replace('http://', 'https://', $base_url);
    $base_insecure_url = str_replace('https://', 'http://', $base_url);

    if ($cookie_domain) {
      // If the user specifies the cookie domain, also use it for session name.
      $session_name = $cookie_domain;
    }
    else {
      // Otherwise use $base_url as session name, without the protocol
      // to use the same session identifiers across HTTP and HTTPS.
      list( , $session_name) = explode('://', $base_url, 2);
      // HTTP_HOST can be modified by a visitor, but we already sanitized it
      // in drupal_settings_initialize().
      if (!empty($_SERVER['HTTP_HOST'])) {
        $cookie_domain = $_SERVER['HTTP_HOST'];
        // Strip leading periods, www., and port numbers from cookie domain.
        $cookie_domain = ltrim($cookie_domain, '.');
        if (strpos($cookie_domain, 'www.') === 0) {
          $cookie_domain = substr($cookie_domain, 4);
        }
        $cookie_domain = explode(':', $cookie_domain);
        $cookie_domain = '.' . $cookie_domain[0];
      }
    }
    // Per RFC 2109, cookie domains must contain at least one dot other than the
    // first. For hosts such as 'localhost' or IP Addresses we don't set a cookie domain.
    if (count(explode('.', $cookie_domain)) > 2 && !is_numeric(str_replace('.', '', $cookie_domain))) {
      ini_set('session.cookie_domain', $cookie_domain);
    }
    // To prevent session cookies from being hijacked, a user can configure the
    // SSL version of their website to only transfer session cookies via SSL by
    // using PHP's session.cookie_secure setting. The browser will then use two
    // separate session cookies for the HTTPS and HTTP versions of the site. So we
    // must use different session identifiers for HTTPS and HTTP to prevent a
    // cookie collision.
    if ($is_https) {
      ini_set('session.cookie_secure', TRUE);
    }
    $prefix = ini_get('session.cookie_secure') ? 'SSESS' : 'SESS';
    session_name($prefix . substr(hash('sha256', $session_name), 0, 32));
  }

  /**
   * Returns and optionally sets the filename for a system resource.
   *
   * The filename, whether provided, cached, or retrieved from the database, is
   * only returned if the file exists.
   *
   * This function plays a key role in allowing Drupal's resources (modules
   * and themes) to be located in different places depending on a site's
   * configuration. For example, a module 'foo' may legally be located
   * in any of these three places:
   *
   * modules/foo/foo.module
   * sites/all/modules/foo/foo.module
   * sites/example.com/modules/foo/foo.module
   *
   * Calling drupal_get_filename('module', 'foo') will give you one of
   * the above, depending on where the module is located.
   *
   * @param $type
   *   The type of the item (theme, theme_engine, module, profile).
   * @param $name
   *   The name of the item for which the filename is requested.
   * @param $filename
   *   The filename of the item if it is to be set explicitly rather
   *   than by consulting the database.
   * @param bool $trigger_error
   *   Whether to trigger an error when a file is missing or has unexpectedly
   *   moved. This defaults to TRUE, but can be set to FALSE by calling code that
   *   merely wants to check whether an item exists in the filesystem.
   *
   * @return
   *   The filename of the requested item or NULL if the item is not found.
   */
  function drupal_get_filename($type, $name, $filename = NULL, $trigger_error = TRUE) {
    // The $files static variable will hold the locations of all requested files.
    // We can be sure that any file listed in this static variable actually
    // exists as all additions have gone through a file_exists() check.
    // The location of files will not change during the request, so do not use
    // drupal_static().
    static $files = [];

    // Profiles are a special case: they have a fixed location and naming.
    if ($type == 'profile') {
      $profile_filename = "profiles/$name/$name.profile";
      $files[$type][$name] = file_exists($profile_filename) ? $profile_filename : FALSE;
    }
    if (!isset($files[$type])) {
      $files[$type] = [];
    }

    if (!empty($filename) && file_exists($filename)) {
      // Prime the static cache with the provided filename.
      $files[$type][$name] = $filename;
    }
    elseif (isset($files[$type][$name])) {
      // This item had already been found earlier in the request, either through
      // priming of the static cache (for example, in system_list()), through a
      // lookup in the {system} table, or through a file scan (cached or not). Do
      // nothing.
    }
    else {
      // Look for the filename listed in the {system} table. Verify that we have
      // an active database connection before doing so, since this function is
      // called both before we have a database connection (i.e. during
      // installation) and when a database connection fails.
      $database_unavailable = TRUE;
      try {
        if (function_exists('db_query')) {
          $file = db_query("SELECT filename FROM {system} WHERE name = :name AND type = :type", array(':name' => $name, ':type' => $type))->fetchField();
          if ($file !== FALSE && file_exists(DRUPAL_ROOT . '/' . $file)) {
            $files[$type][$name] = $file;
          }
          $database_unavailable = FALSE;
        }
      }
      catch (Exception $e) {
        // The database table may not exist because Drupal is not yet installed,
        // the database might be down, or we may have done a non-database cache
        // flush while $conf['page_cache_without_database'] = TRUE and
        // $conf['page_cache_invoke_hooks'] = TRUE. We have a fallback for these
        // cases so we hide the error completely.
      }
      // Fall back to searching the filesystem if the database could not find the
      // file or the file does not exist at the path returned by the database.
      if (!isset($files[$type][$name])) {
        $files[$type][$name] = _drupal_get_filename_fallback($type, $name, $trigger_error, $database_unavailable);
      }
    }

    if (isset($files[$type][$name])) {
      return $files[$type][$name];
    }
  }

  /**
   * Performs a cached file system scan as a fallback when searching for a file.
   *
   * This function looks for the requested file by triggering a file scan,
   * caching the new location if the file has moved and caching the miss
   * if the file is missing. If a file had been marked as missing in a previous
   * file scan, or if it has been marked as moved and is still in the last known
   * location, no new file scan will be performed.
   *
   * @param string $type
   *   The type of the item (theme, theme_engine, module, profile).
   * @param string $name
   *   The name of the item for which the filename is requested.
   * @param bool $trigger_error
   *   Whether to trigger an error when a file is missing or has unexpectedly
   *   moved.
   * @param bool $database_unavailable
   *   Whether this function is being called because the Drupal database could
   *   not be queried for the file's location.
   *
   * @return
   *   The filename of the requested item or NULL if the item is not found.
   *
   * @see drupal_get_filename()
   */
  function _drupal_get_filename_fallback($type, $name, $trigger_error, $database_unavailable) {
    $file_scans = &_drupal_file_scan_cache();
    $filename = NULL;

    // If the cache indicates that the item is missing, or we can verify that the
    // item exists in the location the cache says it exists in, use that.
    if (isset($file_scans[$type][$name]) && ($file_scans[$type][$name] === FALSE || file_exists($file_scans[$type][$name]))) {
      $filename = $file_scans[$type][$name];
    }
    // Otherwise, perform a new file scan to find the item.
    else {
      $filename = _drupal_get_filename_perform_file_scan($type, $name);
      // Update the static cache, and mark the persistent cache for updating at
      // the end of the page request. See drupal_file_scan_write_cache().
      $file_scans[$type][$name] = $filename;
      $file_scans['#write_cache'] = TRUE;
    }

    // If requested, trigger a user-level warning about the missing or
    // unexpectedly moved file. If the database was unavailable, do not trigger a
    // warning in the latter case, though, since if the {system} table could not
    // be queried there is no way to know if the location found here was
    // "unexpected" or not.
    if ($trigger_error) {
      $error_type = $filename === FALSE ? 'missing' : 'moved';
      if ($error_type == 'missing' || !$database_unavailable) {
        _drupal_get_filename_fallback_trigger_error($type, $name, $error_type);
      }
    }

    // The cache stores FALSE for files that aren't found (to be able to
    // distinguish them from files that have not yet been searched for), but
    // drupal_get_filename() expects NULL for these instead, so convert to NULL
    // before returning.
    if ($filename === FALSE) {
      $filename = NULL;
    }
    return $filename;
  }

  /**
   * Returns the current list of cached file system scan results.
   *
   * @return
   *   An associative array tracking the most recent file scan results for all
   *   files that have had scans performed. The keys are the type and name of the
   *   item that was searched for, and the values can be either:
   *   - Boolean FALSE if the item was not found in the file system.
   *   - A string pointing to the location where the item was found.
   */
  function &_drupal_file_scan_cache() {
    $file_scans = &drupal_static(__FUNCTION__, []);

    // The file scan results are stored in a persistent cache (in addition to the
    // static cache) but because this function can be called before the
    // persistent cache is available, we must merge any items that were found
    // earlier in the page request into the results from the persistent cache.
    if (!isset($file_scans['#cache_merge_done'])) {
      try {
        if (function_exists('cache_get')) {
          $cache = cache_get('_drupal_file_scan_cache', 'cache_bootstrap');
          if (!empty($cache->data)) {
            // File scan results from the current request should take precedence
            // over the results from the persistent cache, since they are newer.
            $file_scans = drupal_array_merge_deep($cache->data, $file_scans);
          }
          // Set a flag to indicate that the persistent cache does not need to be
          // merged again.
          $file_scans['#cache_merge_done'] = TRUE;
        }
      }
      catch (Exception $e) {
        // Hide the error.
      }
    }

    return $file_scans;
  }

  /**
   * Performs a file system scan to search for a system resource.
   *
   * @param $type
   *   The type of the item (theme, theme_engine, module, profile).
   * @param $name
   *   The name of the item for which the filename is requested.
   *
   * @return
   *   The filename of the requested item or FALSE if the item is not found.
   *
   * @see drupal_get_filename()
   * @see _drupal_get_filename_fallback()
   */
  function _drupal_get_filename_perform_file_scan($type, $name) {
    // The location of files will not change during the request, so do not use
    // drupal_static().
    static $dirs = [], $files = [];

    // We have a consistent directory naming: modules, themes...
    $dir = $type . 's';
    if ($type == 'theme_engine') {
      $dir = 'themes/engines';
      $extension = 'engine';
    }
    elseif ($type == 'theme') {
      $extension = 'info';
    }
    else {
      $extension = $type;
    }

    // Check if we had already scanned this directory/extension combination.
    if (!isset($dirs[$dir][$extension])) {
      // Log that we have now scanned this directory/extension combination
      // into a static variable so as to prevent unnecessary file scans.
      $dirs[$dir][$extension] = TRUE;
      if (!function_exists('drupal_system_listing')) {
        require_once DRUPAL_ROOT . '/includes/common.inc';
      }
      // Scan the appropriate directories for all files with the requested
      // extension, not just the file we are currently looking for. This
      // prevents unnecessary scans from being repeated when this function is
      // called more than once in the same page request.
      $matches = drupal_system_listing("/^" . DRUPAL_PHP_FUNCTION_PATTERN . "\.$extension$/", $dir, 'name', 0);
      foreach ($matches as $matched_name => $file) {
        // Log the locations found in the file scan into a static variable.
        $files[$type][$matched_name] = $file->uri;
      }
    }

    // Return the results of the file system scan, or FALSE to indicate the file
    // was not found.
    return isset($files[$type][$name]) ? $files[$type][$name] : FALSE;
  }

  /**
   * Triggers a user-level warning for missing or unexpectedly moved files.
   *
   * @param $type
   *   The type of the item (theme, theme_engine, module, profile).
   * @param $name
   *   The name of the item for which the filename is requested.
   * @param $error_type
   *   The type of the error ('missing' or 'moved').
   *
   * @see drupal_get_filename()
   * @see _drupal_get_filename_fallback()
   */
  function _drupal_get_filename_fallback_trigger_error($type, $name, $error_type) {
    // Hide messages due to known bugs that will appear on a lot of sites.
    // @todo Remove this in https://www.drupal.org/node/2383823
    if (empty($name)) {
      return;
    }

    // Make sure we only show any missing or moved file errors only once per
    // request.
    static $errors_triggered = [];
    if (empty($errors_triggered[$type][$name][$error_type])) {
      // Use _drupal_trigger_error_with_delayed_logging() here since these are
      // triggered during low-level operations that cannot necessarily be
      // interrupted by a watchdog() call.
      if ($error_type == 'missing') {
        _drupal_trigger_error_with_delayed_logging(format_string('The following @type is missing from the file system: %name. For information about how to fix this, see <a href="@documentation">the documentation page</a>.', array('@type' => $type, '%name' => $name, '@documentation' => 'https://www.drupal.org/node/2487215')), E_USER_WARNING);
      }
      elseif ($error_type == 'moved') {
        _drupal_trigger_error_with_delayed_logging(format_string('The following @type has moved within the file system: %name. In order to fix this, clear caches or put the @type back in its original location. For more information, see <a href="@documentation">the documentation page</a>.', array('@type' => $type, '%name' => $name, '@documentation' => 'https://www.drupal.org/node/2487215')), E_USER_WARNING);
      }
      $errors_triggered[$type][$name][$error_type] = TRUE;
    }
  }

  /**
   * Invokes trigger_error() with logging delayed until the end of the request.
   *
   * This is an alternative to PHP's trigger_error() function which can be used
   * during low-level Drupal core operations that need to avoid being interrupted
   * by a watchdog() call.
   *
   * Normally, Drupal's error handler calls watchdog() in response to a
   * trigger_error() call. However, this invokes hook_watchdog() which can run
   * arbitrary code. If the trigger_error() happens in the middle of an
   * operation such as a rebuild operation which should not be interrupted by
   * arbitrary code, that could potentially break or trigger the rebuild again.
   * This function protects against that by delaying the watchdog() call until
   * the end of the current page request.
   *
   * This is an internal function which should only be called by low-level Drupal
   * core functions. It may be removed in a future Drupal 7 release.
   *
   * @param string $error_msg
   *   The error message to trigger. As with trigger_error() itself, this is
   *   limited to 1024 bytes; additional characters beyond that will be removed.
   * @param int $error_type
   *   (optional) The type of error. This should be one of the E_USER family of
   *   constants. As with trigger_error() itself, this defaults to E_USER_NOTICE
   *   if not provided.
   *
   * @see _drupal_log_error()
   */
  function _drupal_trigger_error_with_delayed_logging($error_msg, $error_type = E_USER_NOTICE) {
    $delay_logging = &drupal_static(__FUNCTION__, FALSE);
    $delay_logging = TRUE;
    trigger_error($error_msg, $error_type);
    $delay_logging = FALSE;
  }

  /**
   * Writes the file scan cache to the persistent cache.
   *
   * This cache stores all files marked as missing or moved after a file scan
   * to prevent unnecessary file scans in subsequent requests. This cache is
   * cleared in system_list_reset() (i.e. after a module/theme rebuild).
   */
  function drupal_file_scan_write_cache() {
    // Only write to the persistent cache if requested, and if we know that any
    // data previously in the cache was successfully loaded and merged in by
    // _drupal_file_scan_cache().
    $file_scans = &_drupal_file_scan_cache();
    if (isset($file_scans['#write_cache']) && isset($file_scans['#cache_merge_done'])) {
      unset($file_scans['#write_cache']);
      cache_set('_drupal_file_scan_cache', $file_scans, 'cache_bootstrap');
    }
  }

  /**
   * Loads the persistent variable table.
   *
   * The variable table is composed of values that have been saved in the table
   * with variable_set() as well as those explicitly specified in the
   * configuration file.
   */
  function variable_initialize($conf = []) {
    // NOTE: caching the variables improves performance by 20% when serving
    // cached pages.
    if ($cached = cache_get('variables', 'cache_bootstrap')) {
      $variables = $cached->data;
    }
    else {
      // Cache miss. Avoid a stampede by acquiring a lock. If the lock fails to
      // acquire, optionally just continue with uncached processing.
      $name = 'variable_init';
      $lock_acquired = lock_acquire($name, 1);
      if (!$lock_acquired && variable_get('variable_initialize_wait_for_lock', FALSE)) {
        lock_wait($name);
        return variable_initialize($conf);
      }
      else {
        // Load the variables from the table.
        $variables = array_map('unserialize', db_query('SELECT name, value FROM {variable}')->fetchAllKeyed());
        if ($lock_acquired) {
          cache_set('variables', $variables, 'cache_bootstrap');
          lock_release($name);
        }
      }
    }

    foreach ($conf as $name => $value) {
      $variables[$name] = $value;
    }

    return $variables;
  }

  /**
   * Returns a persistent variable.
   *
   * Case-sensitivity of the variable_* functions depends on the database
   * collation used. To avoid problems, always use lower case for persistent
   * variable names.
   *
   * @param $name
   *   The name of the variable to return.
   * @param $default
   *   The default value to use if this variable has never been set.
   *
   * @return
   *   The value of the variable. Unserialization is taken care of as necessary.
   *
   * @see variable_del()
   * @see variable_set()
   */
  function variable_get($name, $default = NULL) {
    global $conf;

    return isset($conf[$name]) ? $conf[$name] : $default;
  }

  /**
   * Sets a persistent variable.
   *
   * Case-sensitivity of the variable_* functions depends on the database
   * collation used. To avoid problems, always use lower case for persistent
   * variable names.
   *
   * @param $name
   *   The name of the variable to set.
   * @param $value
   *   The value to set. This can be any PHP data type; these functions take care
   *   of serialization as necessary.
   *
   * @see variable_del()
   * @see variable_get()
   */
  function variable_set($name, $value) {
    global $conf;

    db_merge('variable')->key(array('name' => $name))->fields(array('value' => serialize($value)))->execute();

    cache_clear_all('variables', 'cache_bootstrap');

    $conf[$name] = $value;
  }

  /**
   * Unsets a persistent variable.
   *
   * Case-sensitivity of the variable_* functions depends on the database
   * collation used. To avoid problems, always use lower case for persistent
   * variable names.
   *
   * @param $name
   *   The name of the variable to undefine.
   *
   * @see variable_get()
   * @see variable_set()
   */
  function variable_del($name) {
    global $conf;

    db_delete('variable')
      ->condition('name', $name)
      ->execute();
    cache_clear_all('variables', 'cache_bootstrap');

    unset($conf[$name]);
  }

  /**
   * Retrieves the current page from the cache.
   *
   * Note: we do not serve cached pages to authenticated users, or to anonymous
   * users when $_SESSION is non-empty. $_SESSION may contain status messages
   * from a form submission, the contents of a shopping cart, or other user-
   * specific content that should not be cached and displayed to other users.
   *
   * @param $check_only
   *   (optional) Set to TRUE to only return whether a previous call found a
   *   cache entry.
   *
   * @return
   *   The cache object, if the page was found in the cache, NULL otherwise.
   */
  function drupal_page_get_cache($check_only = FALSE) {
    global $base_root;
    static $cache_hit = FALSE;

    if ($check_only) {
      return $cache_hit;
    }

    if (drupal_page_is_cacheable()) {
      $cache = cache_get($base_root . request_uri(), 'cache_page');
      if ($cache !== FALSE) {
        $cache_hit = TRUE;
      }
      return $cache;
    }
  }

  /**
   * Determines the cacheability of the current page.
   *
   * @param $allow_caching
   *   Set to FALSE if you want to prevent this page from being cached.
   *
   * @return
   *   TRUE if the current page can be cached, FALSE otherwise.
   */
  function drupal_page_is_cacheable($allow_caching = NULL) {
    $allow_caching_static = &$this->drupal_static(__FUNCTION__, TRUE);
    if (isset($allow_caching)) {
      $allow_caching_static = $allow_caching;
    }

    return $allow_caching_static && ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'HEAD')
      && !drupal_is_cli();
  }

  /**
   * Invokes a bootstrap hook in all bootstrap modules that implement it.
   *
   * @param $hook
   *   The name of the bootstrap hook to invoke.
   *
   * @see bootstrap_hooks()
   */
  function bootstrap_invoke_all($hook) {
    // Bootstrap modules should have been loaded when this function is called, so
    // we don't need to tell module_list() to reset its internal list (and we
    // therefore leave the first parameter at its default value of FALSE). We
    // still pass in TRUE for the second parameter, though; in case this is the
    // first time during the bootstrap that module_list() is called, we want to
    // make sure that its internal cache is primed with the bootstrap modules
    // only.
    foreach (module_list(FALSE, TRUE) as $module) {
      drupal_load('module', $module);
      module_invoke($module, $hook);
    }
  }

  /**
   * Includes a file with the provided type and name.
   *
   * This prevents including a theme, engine, module, etc., more than once.
   *
   * @param $type
   *   The type of item to load (i.e. theme, theme_engine, module).
   * @param $name
   *   The name of the item to load.
   *
   * @return
   *   TRUE if the item is loaded or has already been loaded.
   */
  function drupal_load($type, $name) {
    // Once a file is included this can't be reversed during a request so do not
    // use drupal_static() here.
    static $files = [];

    if (isset($files[$type][$name])) {
      return TRUE;
    }

    $filename = drupal_get_filename($type, $name);

    if ($filename) {
      include_once DRUPAL_ROOT . '/' . $filename;
      $files[$type][$name] = TRUE;

      return TRUE;
    }

    return FALSE;
  }

  /**
   * Sets an HTTP response header for the current page.
   *
   * Note: When sending a Content-Type header, always include a 'charset' type,
   * too. This is necessary to avoid security bugs (e.g. UTF-7 XSS).
   *
   * @param $name
   *   The HTTP header name, or the special 'Status' header name.
   * @param $value
   *   The HTTP header value; if equal to FALSE, the specified header is unset.
   *   If $name is 'Status', this is expected to be a status code followed by a
   *   reason phrase, e.g. "404 Not Found".
   * @param $append
   *   Whether to append the value to an existing header or to replace it.
   */
  function drupal_add_http_header($name, $value, $append = FALSE) {
    // The headers as name/value pairs.
    $headers = &drupal_static('drupal_http_headers', []);

    $name_lower = strtolower($name);
    _drupal_set_preferred_header_name($name);

    if ($value === FALSE) {
      $headers[$name_lower] = FALSE;
    }
    elseif (isset($headers[$name_lower]) && $append) {
      // Multiple headers with identical names may be combined using comma (RFC
      // 2616, section 4.2).
      $headers[$name_lower] .= ',' . $value;
    }
    else {
      $headers[$name_lower] = $value;
    }
    drupal_send_headers(array($name => $headers[$name_lower]), TRUE);
  }

  /**
   * Gets the HTTP response headers for the current page.
   *
   * @param $name
   *   An HTTP header name. If omitted, all headers are returned as name/value
   *   pairs. If an array value is FALSE, the header has been unset.
   *
   * @return
   *   A string containing the header value, or FALSE if the header has been set,
   *   or NULL if the header has not been set.
   */
  function drupal_get_http_header($name = NULL) {
    $headers = &drupal_static('drupal_http_headers', []);
    if (isset($name)) {
      $name = strtolower($name);
      return isset($headers[$name]) ? $headers[$name] : NULL;
    }
    else {
      return $headers;
    }
  }

  /**
   * Sets the preferred name for the HTTP header.
   *
   * Header names are case-insensitive, but for maximum compatibility they should
   * follow "common form" (see RFC 2617, section 4.2).
   */
  function _drupal_set_preferred_header_name($name = NULL) {
    static $header_names = [];

    if (!isset($name)) {
      return $header_names;
    }
    $header_names[strtolower($name)] = $name;
  }

  /**
   * Sends the HTTP response headers that were previously set, adding defaults.
   *
   * Headers are set in drupal_add_http_header(). Default headers are not set
   * if they have been replaced or unset using drupal_add_http_header().
   *
   * @param array $default_headers
   *   (optional) An array of headers as name/value pairs.
   * @param bool $only_default
   *   (optional) If TRUE and headers have already been sent, send only the
   *   specified headers.
   */
  function drupal_send_headers($default_headers = [], $only_default = FALSE) {
    $headers_sent = &drupal_static(__FUNCTION__, FALSE);
    $headers = drupal_get_http_header();
    if ($only_default && $headers_sent) {
      $headers = [];
    }
    $headers_sent = TRUE;

    $header_names = _drupal_set_preferred_header_name();
    foreach ($default_headers as $name => $value) {
      $name_lower = strtolower($name);
      if (!isset($headers[$name_lower])) {
        $headers[$name_lower] = $value;
        $header_names[$name_lower] = $name;
      }
    }
    foreach ($headers as $name_lower => $value) {
      if ($name_lower == 'status') {
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $value);
      }
      // Skip headers that have been unset.
      elseif ($value !== FALSE) {
        header($header_names[$name_lower] . ': ' . $value);
      }
    }
  }

  /**
   * Sets HTTP headers in preparation for a page response.
   *
   * Authenticated users are always given a 'no-cache' header, and will fetch a
   * fresh page on every request. This prevents authenticated users from seeing
   * locally cached pages.
   *
   * ETag and Last-Modified headers are not set per default for authenticated
   * users so that browsers do not send If-Modified-Since headers from
   * authenticated user pages. drupal_serve_page_from_cache() will set appropriate
   * ETag and Last-Modified headers for cached pages.
   *
   * @see drupal_page_set_cache()
   */
  function drupal_page_header() {
    $headers_sent = &drupal_static(__FUNCTION__, FALSE);
    if ($headers_sent) {
      return TRUE;
    }
    $headers_sent = TRUE;

    $default_headers = array(
      'Expires' => 'Sun, 19 Nov 1978 05:00:00 GMT',
      'Cache-Control' => 'no-cache, must-revalidate',
      // Prevent browsers from sniffing a response and picking a MIME type
      // different from the declared content-type, since that can lead to
      // XSS and other vulnerabilities.
      'X-Content-Type-Options' => 'nosniff',
    );
    drupal_send_headers($default_headers);
  }

  /**
   * Sets HTTP headers in preparation for a cached page response.
   *
   * The headers allow as much as possible in proxies and browsers without any
   * particular knowledge about the pages. Modules can override these headers
   * using drupal_add_http_header().
   *
   * If the request is conditional (using If-Modified-Since and If-None-Match),
   * and the conditions match those currently in the cache, a 304 Not Modified
   * response is sent.
   */
  function drupal_serve_page_from_cache(stdClass $cache) {
    // Negotiate whether to use compression.
    $page_compression = !empty($cache->data['page_compressed']);
    $return_compressed = $page_compression && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE;

    // Get headers set in hook_boot(). Keys are lower-case.
    $hook_boot_headers = drupal_get_http_header();

    // Headers generated in this function, that may be replaced or unset using
    // drupal_add_http_headers(). Keys are mixed-case.
    $default_headers = [];

    foreach ($cache->data['headers'] as $name => $value) {
      // In the case of a 304 response, certain headers must be sent, and the
      // remaining may not (see RFC 2616, section 10.3.5). Do not override
      // headers set in hook_boot().
      $name_lower = strtolower($name);
      if (in_array($name_lower, array('content-location', 'expires', 'cache-control', 'vary')) && !isset($hook_boot_headers[$name_lower])) {
        drupal_add_http_header($name, $value);
        unset($cache->data['headers'][$name]);
      }
    }

    // If the client sent a session cookie, a cached copy will only be served
    // to that one particular client due to Vary: Cookie. Thus, do not set
    // max-age > 0, allowing the page to be cached by external proxies, when a
    // session cookie is present unless the Vary header has been replaced or
    // unset in hook_boot().
    $max_age = !isset($_COOKIE[session_name()]) || isset($hook_boot_headers['vary']) ? variable_get('page_cache_maximum_age', 0) : 0;
    $default_headers['Cache-Control'] = 'public, max-age=' . $max_age;

    // Entity tag should change if the output changes.
    $etag = '"' . $cache->created . '-' . intval($return_compressed) . '"';
    header('Etag: ' . $etag);

    // See if the client has provided the required HTTP headers.
    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : FALSE;
    $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : FALSE;

    if ($if_modified_since && $if_none_match
        && $if_none_match == $etag // etag must match
        && $if_modified_since == $cache->created) {  // if-modified-since must match
      header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
      drupal_send_headers($default_headers);
      return;
    }

    // Send the remaining headers.
    foreach ($cache->data['headers'] as $name => $value) {
      drupal_add_http_header($name, $value);
    }

    $default_headers['Last-Modified'] = gmdate(DATE_RFC7231, $cache->created);

    // HTTP/1.0 proxies does not support the Vary header, so prevent any caching
    // by sending an Expires date in the past. HTTP/1.1 clients ignores the
    // Expires header if a Cache-Control: max-age= directive is specified (see RFC
    // 2616, section 14.9.3).
    $default_headers['Expires'] = 'Sun, 19 Nov 1978 05:00:00 GMT';

    drupal_send_headers($default_headers);

    // Allow HTTP proxies to cache pages for anonymous users without a session
    // cookie. The Vary header is used to indicates the set of request-header
    // fields that fully determines whether a cache is permitted to use the
    // response to reply to a subsequent request for a given URL without
    // revalidation. If a Vary header has been set in hook_boot(), it is assumed
    // that the module knows how to cache the page.
    if (!isset($hook_boot_headers['vary']) && !variable_get('omit_vary_cookie')) {
      header('Vary: Cookie');
    }

    if ($page_compression) {
      header('Vary: Accept-Encoding', FALSE);
      // If page_compression is enabled, the cache contains gzipped data.
      if ($return_compressed) {
        // $cache->data['body'] is already gzip'ed, so make sure
        // zlib.output_compression does not compress it once more.
        ini_set('zlib.output_compression', '0');
        header('Content-Encoding: gzip');
      }
      else {
        // The client does not support compression, so unzip the data in the
        // cache. Strip the gzip header and run uncompress.
        $cache->data['body'] = gzinflate(substr(substr($cache->data['body'], 10), 0, -8));
      }
    }

    // Print the page.
    print $cache->data['body'];
  }

  /**
   * Defines the critical hooks that force modules to always be loaded.
   */
  function bootstrap_hooks() {
    return array('boot', 'exit', 'watchdog', 'language_init');
  }

  /**
   * Unserializes and appends elements from a serialized string.
   *
   * @param $obj
   *   The object to which the elements are appended.
   * @param $field
   *   The attribute of $obj whose value should be unserialized.
   */
  function drupal_unpack($obj, $field = 'data') {
    if ($obj->$field && $data = unserialize($obj->$field)) {
      foreach ($data as $key => $value) {
        if (!empty($key) && !isset($obj->$key)) {
          $obj->$key = $value;
        }
      }
    }
    return $obj;
  }

  /**
   * Translates a string to the current language or to a given language.
   *
   * The t() function serves two purposes. First, at run-time it translates
   * user-visible text into the appropriate language. Second, various mechanisms
   * that figure out what text needs to be translated work off t() -- the text
   * inside t() calls is added to the database of strings to be translated.
   * These strings are expected to be in English, so the first argument should
   * always be in English. To enable a fully-translatable site, it is important
   * that all human-readable text that will be displayed on the site or sent to
   * a user is passed through the t() function, or a related function. See the
   * @link http://drupal.org/node/322729 Localization API @endlink pages for
   * more information, including recommendations on how to break up or not
   * break up strings for translation.
   *
   * @section sec_translating_vars Translating Variables
   * You should never use t() to translate variables, such as calling
   * @code t($text); @endcode, unless the text that the variable holds has been
   * passed through t() elsewhere (e.g., $text is one of several translated
   * literal strings in an array). It is especially important never to call
   * @code t($user_text); @endcode, where $user_text is some text that a user
   * entered - doing that can lead to cross-site scripting and other security
   * problems. However, you can use variable substitution in your string, to put
   * variable text such as user names or link URLs into translated text. Variable
   * substitution looks like this:
   * @code
   * $text = t("@name's blog", array('@name' => format_username($account)));
   * @endcode
   * Basically, you can put variables like @name into your string, and t() will
   * substitute their sanitized values at translation time. (See the
   * Localization API pages referenced above and the documentation of
   * format_string() for details about how to define variables in your string.)
   * Translators can then rearrange the string as necessary for the language
   * (e.g., in Spanish, it might be "blog de @name").
   *
   * @section sec_alt_funcs_install Use During Installation Phase
   * During the Drupal installation phase, some resources used by t() wil not be
   * available to code that needs localization. See st() and get_t() for
   * alternatives.
   *
   * @section sec_context String context
   * Matching source strings are normally only translated once, and the same
   * translation is used everywhere that has a matching string. However, in some
   * cases, a certain English source string needs to have multiple translations.
   * One example of this is the string "May", which could be used as either a
   * full month name or a 3-letter abbreviated month. In other languages where
   * the month name for May has more than 3 letters, you would need to provide
   * two different translations (one for the full name and one abbreviated), and
   * the correct form would need to be chosen, depending on how "May" is being
   * used. To facilitate this, the "May" string should be provided with two
   * different contexts in the $options parameter when calling t(). For example:
   * @code
   * t('May', [], array('context' => 'Long month name')
   * t('May', [], array('context' => 'Abbreviated month name')
   * @endcode
   * See https://localize.drupal.org/node/2109 for more information.
   *
   * @param $string
   *   A string containing the English string to translate.
   * @param $args
   *   An associative array of replacements to make after translation. Based
   *   on the first character of the key, the value is escaped and/or themed.
   *   See format_string() for details.
   * @param $options
   *   An associative array of additional options, with the following elements:
   *   - 'langcode' (defaults to the current language): The language code to
   *     translate to a language other than what is used to display the page.
   *   - 'context' (defaults to the empty context): A string giving the context
   *     that the source string belongs to. See @ref sec_context above for more
   *     information.
   *
   * @return
   *   The translated string.
   *
   * @see st()
   * @see get_t()
   * @see format_string()
   * @ingroup sanitization
   */
  function t($string, array $args = [], array $options = []) {
    global $language;
    static $custom_strings;

    // Merge in default.
    if (empty($options['langcode'])) {
      $options['langcode'] = isset($language->language) ? $language->language : 'en';
    }
    if (empty($options['context'])) {
      $options['context'] = '';
    }

    // First, check for an array of customized strings. If present, use the array
    // *instead of* database lookups. This is a high performance way to provide a
    // handful of string replacements. See settings.php for examples.
    // Cache the $custom_strings variable to improve performance.
    if (!isset($custom_strings[$options['langcode']])) {
      $custom_strings[$options['langcode']] = $this->variable_get('locale_custom_strings_' . $options['langcode'], []);
    }
    // Custom strings work for English too, even if locale module is disabled.
    if (isset($custom_strings[$options['langcode']][$options['context']][$string])) {
      $string = $custom_strings[$options['langcode']][$options['context']][$string];
    }
    // Translate with locale module if enabled.
    elseif ($options['langcode'] != 'en' && function_exists('locale')) {
      $string = locale($string, $options['context'], $options['langcode']);
    }
    if (empty($args)) {
      return $string;
    }
    else {
      return $this->format_string($string, $args);
    }
  }

  /**
   * Formats a string for HTML display by replacing variable placeholders.
   *
   * This function replaces variable placeholders in a string with the requested
   * values and escapes the values so they can be safely displayed as HTML. It
   * should be used on any unknown text that is intended to be printed to an HTML
   * page (especially text that may have come from untrusted users, since in that
   * case it prevents cross-site scripting and other security problems).
   *
   * In most cases, you should use t() rather than calling this function
   * directly, since it will translate the text (on non-English-only sites) in
   * addition to formatting it.
   *
   * @param $string
   *   A string containing placeholders.
   * @param $args
   *   An associative array of replacements to make. Occurrences in $string of
   *   any key in $args are replaced with the corresponding value, after optional
   *   sanitization and formatting. The type of sanitization and formatting
   *   depends on the first character of the key:
   *   - @variable: Escaped to HTML using check_plain(). Use this as the default
   *     choice for anything displayed on a page on the site.
   *   - %variable: Escaped to HTML and formatted using drupal_placeholder(),
   *     which makes it display as <em>emphasized</em> text.
   *   - !variable: Inserted as is, with no sanitization or formatting. Only use
   *     this for text that has already been prepared for HTML display (for
   *     example, user-supplied text that has already been run through
   *     check_plain() previously, or is expected to contain some limited HTML
   *     tags and has already been run through filter_xss() previously).
   *
   * @see t()
   * @ingroup sanitization
   */
  function format_string($string, array $args = []) {
    // Transform arguments before inserting them.
    foreach ($args as $key => $value) {
      switch ($key[0]) {
        case '@':
          // Escaped only.
          $args[$key] = check_plain($value);
          break;

        case '%':
        default:
          // Escaped and placeholder.
          $args[$key] = $this->drupal_placeholder($value);
          break;

        case '!':
          // Pass-through.
      }
    }
    return strtr($string, $args);
  }

  /**
   * Encodes special characters in a plain-text string for display as HTML.
   *
   * Also validates strings as UTF-8 to prevent cross site scripting attacks on
   * Internet Explorer 6.
   *
   * @param string $text
   *   The text to be checked or processed.
   *
   * @return string
   *   An HTML safe version of $text. If $text is not valid UTF-8, an empty string
   *   is returned and, on PHP < 5.4, a warning may be issued depending on server
   *   configuration (see @link https://bugs.php.net/bug.php?id=47494 @endlink).
   *
   * @see drupal_validate_utf8()
   * @ingroup sanitization
   */
  function check_plain($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }

  /**
   * Checks whether a string is valid UTF-8.
   *
   * All functions designed to filter input should use drupal_validate_utf8
   * to ensure they operate on valid UTF-8 strings to prevent bypass of the
   * filter.
   *
   * When text containing an invalid UTF-8 lead byte (0xC0 - 0xFF) is presented
   * as UTF-8 to Internet Explorer 6, the program may misinterpret subsequent
   * bytes. When these subsequent bytes are HTML control characters such as
   * quotes or angle brackets, parts of the text that were deemed safe by filters
   * end up in locations that are potentially unsafe; An onerror attribute that
   * is outside of a tag, and thus deemed safe by a filter, can be interpreted
   * by the browser as if it were inside the tag.
   *
   * The function does not return FALSE for strings containing character codes
   * above U+10FFFF, even though these are prohibited by RFC 3629.
   *
   * @param $text
   *   The text to check.
   *
   * @return
   *   TRUE if the text is valid UTF-8, FALSE if not.
   */
  function drupal_validate_utf8($text) {
    if (strlen($text) == 0) {
      return TRUE;
    }
    // With the PCRE_UTF8 modifier 'u', preg_match() fails silently on strings
    // containing invalid UTF-8 byte sequences. It does not reject character
    // codes above U+10FFFF (represented by 4 or more octets), though.
    return (preg_match('/^./us', $text) == 1);
  }

  /**
   * Returns the equivalent of Apache's $_SERVER['REQUEST_URI'] variable.
   *
   * Because $_SERVER['REQUEST_URI'] is only available on Apache, we generate an
   * equivalent using other environment variables.
   */
  function request_uri() {
    if (isset($_SERVER['REQUEST_URI'])) {
      $uri = $_SERVER['REQUEST_URI'];
    }
    else {
      if (isset($_SERVER['argv'])) {
        $uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['argv'][0];
      }
      elseif (isset($_SERVER['QUERY_STRING'])) {
        $uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
      }
      else {
        $uri = $_SERVER['SCRIPT_NAME'];
      }
    }
    // Prevent multiple slashes to avoid cross site requests via the Form API.
    $uri = '/' . ltrim($uri, '/');

    return $uri;
  }

  /**
   * Logs an exception.
   *
   * This is a wrapper function for watchdog() which automatically decodes an
   * exception.
   *
   * @param $type
   *   The category to which this message belongs.
   * @param $exception
   *   The exception that is going to be logged.
   * @param $message
   *   The message to store in the log. If empty, a text that contains all useful
   *   information about the passed-in exception is used.
   * @param $variables
   *   Array of variables to replace in the message on display. Defaults to the
   *   return value of _drupal_decode_exception().
   * @param $severity
   *   The severity of the message, as per RFC 3164.
   * @param $link
   *   A link to associate with the message.
   *
   * @see watchdog()
   * @see _drupal_decode_exception()
   */
  function watchdog_exception($type, Exception $exception, $message = NULL, $variables = [], $severity = self::watchdog_error, $link = NULL) {

    // Use a default value if $message is not set.
    if (empty($message)) {
      // The exception message is run through check_plain() by _drupal_decode_exception().
      $message = '%type: !message in %function (line %line of %file).';
    }

    // $variables must be an array so that we can add the exception information.
    if (!is_array($variables)) {
      $variables = [];
    }

    require_once DRUPAL_ROOT . '/includes/errors.inc';
    $variables += _drupal_decode_exception($exception);
    watchdog($type, $message, $variables, $severity, $link);
  }

  /**
   * Logs a system message.
   *
   * @param $type
   *   The category to which this message belongs. Can be any string, but the
   *   general practice is to use the name of the module calling watchdog().
   * @param $message
   *   The message to store in the log. Keep $message translatable
   *   by not concatenating dynamic values into it! Variables in the
   *   message should be added by using placeholder strings alongside
   *   the variables argument to declare the value of the placeholders.
   *   See t() for documentation on how $message and $variables interact.
   * @param $variables
   *   Array of variables to replace in the message on display or
   *   NULL if message is already translated or not possible to
   *   translate.
   * @param $severity
   *   The severity of the message; one of the following values as defined in
   *   @link http://www.faqs.org/rfcs/rfc3164.html RFC 3164: @endlink
   *   - WATCHDOG_EMERGENCY: Emergency, system is unusable.
   *   - WATCHDOG_ALERT: Alert, action must be taken immediately.
   *   - WATCHDOG_CRITICAL: Critical conditions.
   *   - WATCHDOG_ERROR: Error conditions.
   *   - WATCHDOG_WARNING: Warning conditions.
   *   - WATCHDOG_NOTICE: (default) Normal but significant conditions.
   *   - WATCHDOG_INFO: Informational messages.
   *   - WATCHDOG_DEBUG: Debug-level messages.
   * @param $link
   *   A link to associate with the message.
   *
   * @see watchdog_severity_levels()
   * @see hook_watchdog()
   */
  function watchdog($type, $message, $variables = [], $severity = WATCHDOG_NOTICE, $link = NULL) {
    global $user, $base_root;

    static $in_error_state = FALSE;

    // It is possible that the error handling will itself trigger an error. In that case, we could
    // end up in an infinite loop. To avoid that, we implement a simple static semaphore.
    if (!$in_error_state && function_exists('module_invoke_all')) {
      $in_error_state = TRUE;

      // The user object may not exist in all conditions, so 0 is substituted if needed.
      $user_uid = isset($user->uid) ? $user->uid : 0;

      // Prepare the fields to be logged
      $log_entry = array(
        'type'        => $type,
        'message'     => $message,
        'variables'   => $variables,
        'severity'    => $severity,
        'link'        => $link,
        'user'        => $user,
        'uid'         => $user_uid,
        'request_uri' => $base_root . request_uri(),
        'referer'     => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
        'ip'          => ip_address(),
        // Request time isn't accurate for long processes, use time() instead.
        'timestamp'   => time(),
      );

      // Call the logging hooks to log/process the message
      module_invoke_all('watchdog', $log_entry);

      // It is critical that the semaphore is only cleared here, in the parent
      // watchdog() call (not outside the loop), to prevent recursive execution.
      $in_error_state = FALSE;
    }
  }

  /**
   * Sets a message to display to the user.
   *
   * Messages are stored in a session variable and displayed in page.tpl.php via
   * the $messages theme variable.
   *
   * Example usage:
   * @code
   * drupal_set_message(t('An error occurred and processing did not complete.'), 'error');
   * @endcode
   *
   * @param string $message
   *   (optional) The translated message to be displayed to the user. For
   *   consistency with other messages, it should begin with a capital letter and
   *   end with a period.
   * @param string $type
   *   (optional) The message's type. Defaults to 'status'. These values are
   *   supported:
   *   - 'status'
   *   - 'warning'
   *   - 'error'
   * @param bool $repeat
   *   (optional) If this is FALSE and the message is already set, then the
   *   message won't be repeated. Defaults to TRUE.
   *
   * @return array|null
   *   A multidimensional array with keys corresponding to the set message types.
   *   The indexed array values of each contain the set messages for that type.
   *   Or, if there are no messages set, the function returns NULL.
   *
   * @see drupal_get_messages()
   * @see theme_status_messages()
   */
  function drupal_set_message($message = NULL, $type = 'status', $repeat = TRUE) {
    if ($message || $message === '0' || $message === 0) {
      if (!isset($_SESSION['messages'][$type])) {
        $_SESSION['messages'][$type] = [];
      }

      if ($repeat || !in_array($message, $_SESSION['messages'][$type])) {
        $_SESSION['messages'][$type][] = $message;
      }

      // Mark this page as being uncacheable.
      $this->drupal_page_is_cacheable(FALSE);
    }

    // Messages not set when DB connection fails.
    return isset($_SESSION['messages']) ? $_SESSION['messages'] : NULL;
  }

  /**
   * Returns all messages that have been set with drupal_set_message().
   *
   * @param string $type
   *   (optional) Limit the messages returned by type. Defaults to NULL, meaning
   *   all types. These values are supported:
   *   - NULL
   *   - 'status'
   *   - 'warning'
   *   - 'error'
   * @param bool $clear_queue
   *   (optional) If this is TRUE, the queue will be cleared of messages of the
   *   type specified in the $type parameter. Otherwise the queue will be left
   *   intact. Defaults to TRUE.
   *
   * @return array
   *   A multidimensional array with keys corresponding to the set message types.
   *   The indexed array values of each contain the set messages for that type.
   *   The messages returned are limited to the type specified in the $type
   *   parameter. If there are no messages of the specified type, an empty array
   *   is returned.
   *
   * @see drupal_set_message()
   * @see theme_status_messages()
   */
  function drupal_get_messages($type = NULL, $clear_queue = TRUE) {
    if ($messages = drupal_set_message()) {
      if ($type) {
        if ($clear_queue) {
          unset($_SESSION['messages'][$type]);
        }
        if (isset($messages[$type])) {
          return array($type => $messages[$type]);
        }
      }
      else {
        if ($clear_queue) {
          unset($_SESSION['messages']);
        }
        return $messages;
      }
    }
    return [];
  }

  /**
   * Gets the title of the current page.
   *
   * The title is displayed on the page and in the title bar.
   *
   * @return
   *   The current page's title.
   */
  function drupal_get_title() {
    $title = drupal_set_title();

    // During a bootstrap, menu.inc is not included and thus we cannot provide a title.
    if (!isset($title) && function_exists('menu_get_active_title')) {
      $title = check_plain(menu_get_active_title());
    }

    return $title;
  }

  /**
   * Sets the title of the current page.
   *
   * The title is displayed on the page and in the title bar.
   *
   * @param $title
   *   Optional string value to assign to the page title; or if set to NULL
   *   (default), leaves the current title unchanged.
   * @param $output
   *   Optional flag - normally should be left as CHECK_PLAIN. Only set to
   *   PASS_THROUGH if you have already removed any possibly dangerous code
   *   from $title using a function like check_plain() or filter_xss(). With this
   *   flag the string will be passed through unchanged.
   *
   * @return
   *   The updated title of the current page.
   */
  function drupal_set_title($title = NULL, $output = CHECK_PLAIN) {
    $stored_title = &drupal_static(__FUNCTION__);

    if (isset($title)) {
      $stored_title = ($output == PASS_THROUGH) ? $title : check_plain($title);
    }

    return $stored_title;
  }

  /**
   * Checks to see if an IP address has been blocked.
   *
   * Blocked IP addresses are stored in the database by default. However for
   * performance reasons we allow an override in settings.php. This allows us
   * to avoid querying the database at this critical stage of the bootstrap if
   * an administrative interface for IP address blocking is not required.
   *
   * @param $ip
   *   IP address to check.
   *
   * @return bool
   *   TRUE if access is denied, FALSE if access is allowed.
   */
  function drupal_is_denied($ip) {
    // Because this function is called on every page request, we first check
    // for an array of IP addresses in settings.php before querying the
    // database.
    $blocked_ips = variable_get('blocked_ips');
    $denied = FALSE;
    if (isset($blocked_ips) && is_array($blocked_ips)) {
      $denied = in_array($ip, $blocked_ips);
    }
    // Only check if database.inc is loaded already. If
    // $conf['page_cache_without_database'] = TRUE; is set in settings.php,
    // then the database won't be loaded here so the IPs in the database
    // won't be denied. However the user asked explicitly not to use the
    // database and also in this case it's quite likely that the user relies
    // on higher performance solutions like a firewall.
    elseif (class_exists('Database', FALSE)) {
      $denied = (bool)db_query("SELECT 1 FROM {blocked_ips} WHERE ip = :ip", array(':ip' => $ip))->fetchField();
    }
    return $denied;
  }

  /**
   * Handles denied users.
   *
   * @param $ip
   *   IP address to check. Prints a message and exits if access is denied.
   */
  function drupal_block_denied($ip) {
    // Deny access to blocked IP addresses - t() is not yet available.
    if (drupal_is_denied($ip)) {
      header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
      print 'Sorry, ' . check_plain(ip_address()) . ' has been banned.';
      exit();
    }
  }

  /**
   * Returns a URL-safe, base64 encoded string of highly randomized bytes (over the full 8-bit range).
   *
   * @param $byte_count
   *   The number of random bytes to fetch and base64 encode.
   *
   * @return string
   *   The base64 encoded result will have a length of up to 4 * $byte_count.
   */
  function drupal_random_key($byte_count = 32) {
    return drupal_base64_encode(drupal_random_bytes($byte_count));
  }

  /**
   * Returns a URL-safe, base64 encoded version of the supplied string.
   *
   * @param $string
   *   The string to convert to base64.
   *
   * @return string
   */
  function drupal_base64_encode($string) {
    $data = base64_encode($string);
    // Modify the output so it's safe to use in URLs.
    return strtr($data, array('+' => '-', '/' => '_', '=' => ''));
  }

  /**
   * Returns a string of highly randomized bytes (over the full 8-bit range).
   *
   * This function is better than simply calling mt_rand() or any other built-in
   * PHP function because it can return a long string of bytes (compared to < 4
   * bytes normally from mt_rand()) and uses the best available pseudo-random
   * source.
   *
   * @param $count
   *   The number of characters (bytes) to return in the string.
   */
  function drupal_random_bytes($count)  {
    // $random_state does not use drupal_static as it stores random bytes.
    static $random_state, $bytes, $has_openssl;

    $missing_bytes = $count - strlen($bytes);

    if ($missing_bytes > 0) {
      // PHP versions prior 5.3.4 experienced openssl_random_pseudo_bytes()
      // locking on Windows and rendered it unusable.
      if (!isset($has_openssl)) {
        $has_openssl = version_compare(PHP_VERSION, '5.3.4', '>=') && function_exists('openssl_random_pseudo_bytes');
      }

      // openssl_random_pseudo_bytes() will find entropy in a system-dependent
      // way.
      if ($has_openssl) {
        $bytes .= openssl_random_pseudo_bytes($missing_bytes);
      }

      // Else, read directly from /dev/urandom, which is available on many *nix
      // systems and is considered cryptographically secure.
      elseif ($fh = @fopen('/dev/urandom', 'rb')) {
        // PHP only performs buffered reads, so in reality it will always read
        // at least 4096 bytes. Thus, it costs nothing extra to read and store
        // that much so as to speed any additional invocations.
        $bytes .= fread($fh, max(4096, $missing_bytes));
        fclose($fh);
      }

      // If we couldn't get enough entropy, this simple hash-based PRNG will
      // generate a good set of pseudo-random bytes on any system.
      // Note that it may be important that our $random_state is passed
      // through hash() prior to being rolled into $output, that the two hash()
      // invocations are different, and that the extra input into the first one -
      // the microtime() - is prepended rather than appended. This is to avoid
      // directly leaking $random_state via the $output stream, which could
      // allow for trivial prediction of further "random" numbers.
      if (strlen($bytes) < $count) {
        // Initialize on the first call. The contents of $_SERVER includes a mix of
        // user-specific and system information that varies a little with each page.
        if (!isset($random_state)) {
          $random_state = print_r($_SERVER, TRUE);
          if (function_exists('getmypid')) {
            // Further initialize with the somewhat random PHP process ID.
            $random_state .= getmypid();
          }
          $bytes = '';
        }

        do {
          $random_state = hash('sha256', microtime() . mt_rand() . $random_state);
          $bytes .= hash('sha256', mt_rand() . $random_state, TRUE);
        }
        while (strlen($bytes) < $count);
      }
    }
    $output = substr($bytes, 0, $count);
    $bytes = substr($bytes, $count);
    return $output;
  }

  /**
   * Calculates a base-64 encoded, URL-safe sha-256 hmac.
   *
   * @param string $data
   *   String to be validated with the hmac.
   * @param string $key
   *   A secret string key.
   *
   * @return string
   *   A base-64 encoded sha-256 hmac, with + replaced with -, / with _ and
   *   any = padding characters removed.
   */
  function drupal_hmac_base64($data, $key) {
    // Casting $data and $key to strings here is necessary to avoid empty string
    // results of the hash function if they are not scalar values. As this
    // function is used in security-critical contexts like token validation it is
    // important that it never returns an empty string.
    $hmac = base64_encode(hash_hmac('sha256', (string) $data, (string) $key, TRUE));
    // Modify the hmac so it's safe to use in URLs.
    return strtr($hmac, array('+' => '-', '/' => '_', '=' => ''));
  }

  /**
   * Calculates a base-64 encoded, URL-safe sha-256 hash.
   *
   * @param $data
   *   String to be hashed.
   *
   * @return
   *   A base-64 encoded sha-256 hash, with + replaced with -, / with _ and
   *   any = padding characters removed.
   */
  function drupal_hash_base64($data) {
    $hash = base64_encode(hash('sha256', $data, TRUE));
    // Modify the hash so it's safe to use in URLs.
    return strtr($hash, array('+' => '-', '/' => '_', '=' => ''));
  }

  /**
   * Merges multiple arrays, recursively, and returns the merged array.
   *
   * This function is similar to PHP's array_merge_recursive() function, but it
   * handles non-array values differently. When merging values that are not both
   * arrays, the latter value replaces the former rather than merging with it.
   *
   * Example:
   * @code
   * $link_options_1 = array('fragment' => 'x', 'attributes' => array('title' => t('X'), 'class' => array('a', 'b')));
   * $link_options_2 = array('fragment' => 'y', 'attributes' => array('title' => t('Y'), 'class' => array('c', 'd')));
   *
   * // This results in array('fragment' => array('x', 'y'), 'attributes' => array('title' => array(t('X'), t('Y')), 'class' => array('a', 'b', 'c', 'd'))).
   * $incorrect = array_merge_recursive($link_options_1, $link_options_2);
   *
   * // This results in array('fragment' => 'y', 'attributes' => array('title' => t('Y'), 'class' => array('a', 'b', 'c', 'd'))).
   * $correct = drupal_array_merge_deep($link_options_1, $link_options_2);
   * @endcode
   *
   * @param ...
   *   Arrays to merge.
   *
   * @return
   *   The merged array.
   *
   * @see drupal_array_merge_deep_[]
   */
  function drupal_array_merge_deep() {
    $args = func_get_args();
    return drupal_array_merge_deep_array($args);
  }

  /**
   * Merges multiple arrays, recursively, and returns the merged array.
   *
   * This function is equivalent to drupal_array_merge_deep(), except the
   * input arrays are passed as a single array parameter rather than a variable
   * parameter list.
   *
   * The following are equivalent:
   * - drupal_array_merge_deep($a, $b);
   * - drupal_array_merge_deep_array(array($a, $b));
   *
   * The following are also equivalent:
   * - call_user_func_array('drupal_array_merge_deep', $arrays_to_merge);
   * - drupal_array_merge_deep_array($arrays_to_merge);
   *
   * @see drupal_array_merge_deep()
   */
  function drupal_array_merge_deep_array($arrays) {
    $result = [];

    foreach ($arrays as $array) {
      foreach ($array as $key => $value) {
        // Renumber integer keys as array_merge_recursive() does. Note that PHP
        // automatically converts array keys that are integer strings (e.g., '1')
        // to integers.
        if (is_integer($key)) {
          $result[] = $value;
        }
        // Recurse when both values are arrays.
        elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
          $result[$key] = drupal_array_merge_deep_array(array($result[$key], $value));
        }
        // Otherwise, use the latter value, overriding any previous value.
        else {
          $result[$key] = $value;
        }
      }
    }

    return $result;
  }

  /**
   * Generates a default anonymous $user object.
   *
   * @return Object - the user object.
   */
  function drupal_anonymous_user() {
    $user = variable_get('drupal_anonymous_user_object', new stdClass);
    $user->uid = 0;
    $user->hostname = ip_address();
    $user->roles = [];
    $user->roles[DRUPAL_ANONYMOUS_RID] = 'anonymous user';
    $user->cache = 0;
    return $user;
  }

  /**
   * Ensures Drupal is bootstrapped to the specified phase.
   *
   * In order to bootstrap Drupal from another PHP script, you can use this code:
   * @code
   *   const DRUPAL_ROOT', '/path/to/drupal');
   *   require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
   *   drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
   * @endcode
   *
   * @param int $phase
   *   A constant telling which phase to bootstrap to. When you bootstrap to a
   *   particular phase, all earlier phases are run automatically. Possible
   *   values:
   *   - DRUPAL_BOOTSTRAP_CONFIGURATION: Initializes configuration.
   *   - DRUPAL_BOOTSTRAP_PAGE_CACHE: Tries to serve a cached page.
   *   - DRUPAL_BOOTSTRAP_DATABASE: Initializes the database layer.
   *   - DRUPAL_BOOTSTRAP_VARIABLES: Initializes the variable system.
   *   - DRUPAL_BOOTSTRAP_SESSION: Initializes session handling.
   *   - DRUPAL_BOOTSTRAP_PAGE_HEADER: Sets up the page header.
   *   - DRUPAL_BOOTSTRAP_LANGUAGE: Finds out the language of the page.
   *   - DRUPAL_BOOTSTRAP_FULL: Fully loads Drupal. Validates and fixes input
   *     data.
   * @param boolean $new_phase
   *   A boolean, set to FALSE if calling drupal_bootstrap from inside a
   *   function called from drupal_bootstrap (recursion).
   *
   * @return int
   *   The most recently completed phase.
   */
  function drupal_bootstrap($phase = NULL, $new_phase = TRUE) {
    // Not drupal_static(), because does not depend on any run-time information.
    $phases = array(
      self::$drupal_bootstrap_configuration,
      self::$drupal_bootstrap_page_cache,
      self::$drupal_bootstrap_database,
      self::$drupal_bootstrap_variables,
      self::$drupal_bootstrap_session,
      self::$drupal_bootstrap_page_header,
      self::$drupal_bootstrap_language,
      self::$drupal_bootstrap_full,
    );
    // Not drupal_static(), because the only legitimate API to control this is to
    // call drupal_bootstrap() with a new phase parameter.
    static $final_phase;
    // Not drupal_static(), because it's impossible to roll back to an earlier
    // bootstrap state.
    static $stored_phase = -1;

    if (isset($phase)) {
      // When not recursing, store the phase name so it's not forgotten while
      // recursing but take care of not going backwards.
      if ($new_phase && $phase >= $stored_phase) {
        $final_phase = $phase;
      }

      // Call a phase if it has not been called before and is below the requested
      // phase.
      while ($phases && $phase > $stored_phase && $final_phase > $stored_phase) {
        $current_phase = array_shift($phases);

        // This function is re-entrant. Only update the completed phase when the
        // current call actually resulted in a progress in the bootstrap process.
        if ($current_phase > $stored_phase) {
          $stored_phase = $current_phase;
        }

        switch ($current_phase) {
          case self::$drupal_bootstrap_configuration:
            $this->_drupal_bootstrap_configuration();
            break;

          case DRUPAL_BOOTSTRAP_PAGE_CACHE:
            _drupal_bootstrap_page_cache();
            break;

          case DRUPAL_BOOTSTRAP_DATABASE:
            _drupal_bootstrap_database();
            break;

          case DRUPAL_BOOTSTRAP_VARIABLES:
            _drupal_bootstrap_variables();
            break;

          case DRUPAL_BOOTSTRAP_SESSION:
            require_once DRUPAL_ROOT . '/' . variable_get('session_inc', 'includes/session.inc');
            drupal_session_initialize();
            break;

          case DRUPAL_BOOTSTRAP_PAGE_HEADER:
            _drupal_bootstrap_page_header();
            break;

          case DRUPAL_BOOTSTRAP_LANGUAGE:
            drupal_language_initialize();
            break;

          case DRUPAL_BOOTSTRAP_FULL:
            require_once DRUPAL_ROOT . '/includes/common.inc';
            _drupal_bootstrap_full();
            break;
        }
      }
    }
    return $stored_phase;
  }

  /**
   * Returns the time zone of the current user.
   */
  function drupal_get_user_timezone() {
    global $user;
    if (variable_get('configurable_timezones', 1) && $user->uid && $user->timezone) {
      return $user->timezone;
    }
    else {
      // Ignore PHP strict notice if time zone has not yet been set in the php.ini
      // configuration.
      return variable_get('date_default_timezone', @date_default_timezone_get());
    }
  }

  /**
   * Gets a salt useful for hardening against SQL injection.
   *
   * @return
   *   A salt based on information in settings.php, not in the database.
   */
  function drupal_get_hash_salt() {
    global $drupal_hash_salt, $databases;
    // If the $drupal_hash_salt variable is empty, a hash of the serialized
    // database credentials is used as a fallback salt.
    return empty($drupal_hash_salt) ? hash('sha256', serialize($databases)) : $drupal_hash_salt;
  }

  /**
   * Provides custom PHP error handling.
   *
   * @param $error_level
   *   The level of the error raised.
   * @param $message
   *   The error message.
   * @param $filename
   *   The filename that the error was raised in.
   * @param $line
   *   The line number the error was raised at.
   * @param $context
   *   An array that points to the active symbol table at the point the error
   *   occurred.
   * function _drupal_error_handler($error_level, $message, $filename, $line, $context) {
   *  _drupal_error_handler_real($error_level, $message, $filename, $line, $context);
   * }
   */
  function _drupal_error_handler($error_level, $message, $filename, $line) {
    $this->errors->_drupal_error_handler_real($error_level, $message, $filename, $line);
  }

  /**
   * Provides custom PHP exception handling.
   *
   * Uncaught exceptions are those not enclosed in a try/catch block. They are
   * always fatal: the execution of the script will stop as soon as the exception
   * handler exits.
   *
   * @param $exception
   *   The exception object that was thrown.
   */
  function _drupal_exception_handler($exception) {
    try {
      // Log the message to the watchdog and return an error page to the user.
      $this->errors->_drupal_log_error($this->errors->_drupal_decode_exception($exception), TRUE);
    }
    catch (Exception $exception2) {
      // Add a 500 status code in case an exception was thrown before the 500
      // status could be set (e.g. while loading a maintenance theme from cache).
      drupal_add_http_header('Status', '500 Internal Server Error');

      // Another uncaught exception was thrown while handling the first one.
      // If we are displaying errors, then do so with no possibility of a further uncaught exception being thrown.
      if (error_displayable()) {
        print '<h1>Additional uncaught exception thrown while handling exception.</h1>';
        print '<h2>Original</h2><p>' . _drupal_render_exception_safe($exception) . '</p>';
        print '<h2>Additional</h2><p>' . _drupal_render_exception_safe($exception2) . '</p><hr />';
      }
    }
  }

  /**
   * Sets up the script environment and loads settings.php.
   */
  function _drupal_bootstrap_configuration() {
    // Set the Drupal custom error handler.
    set_error_handler([$this, '_drupal_error_handler']);
    set_exception_handler([$this, '_drupal_exception_handler']);

    drupal_environment_initialize();
    // Start a page timer:
    timer_start('page');
    // Initialize the configuration, including variables from settings.php.
    drupal_settings_initialize();

    // Sanitize unsafe keys from the request.
    DrupalRequestSanitizer::sanitize();
  }

  /**
   * Attempts to serve a page from the cache.
   */
  function _drupal_bootstrap_page_cache() {
    global $user;

    // Allow specifying special cache handlers in settings.php, like
    // using memcached or files for storing cache information.
    require_once DRUPAL_ROOT . '/includes/cache.inc';
    foreach (variable_get('cache_backends', []) as $include) {
      require_once DRUPAL_ROOT . '/' . $include;
    }
    // Check for a cache mode force from settings.php.
    if (variable_get('page_cache_without_database')) {
      $cache_enabled = TRUE;
    }
    else {
      drupal_bootstrap(DRUPAL_BOOTSTRAP_VARIABLES, FALSE);
      $cache_enabled = variable_get('cache');
    }
    drupal_block_denied(ip_address());
    // If there is no session cookie and cache is enabled (or forced), try
    // to serve a cached page.
    if (!isset($_COOKIE[session_name()]) && $cache_enabled) {
      // Make sure there is a user object because its timestamp will be
      // checked, hook_boot might check for anonymous user etc.
      $user = drupal_anonymous_user();
      // Get the page from the cache.
      $cache = drupal_page_get_cache();
      // If there is a cached page, display it.
      if (is_object($cache)) {
        header('X-Drupal-Cache: HIT');
        // Restore the metadata cached with the page.
        $_GET['q'] = $cache->data['path'];
        drupal_set_title($cache->data['title'], PASS_THROUGH);
        date_default_timezone_set(drupal_get_user_timezone());
        // If the skipping of the bootstrap hooks is not enforced, call
        // hook_boot.
        if (variable_get('page_cache_invoke_hooks', TRUE)) {
          bootstrap_invoke_all('boot');
        }
        drupal_serve_page_from_cache($cache);
        // If the skipping of the bootstrap hooks is not enforced, call
        // hook_exit.
        if (variable_get('page_cache_invoke_hooks', TRUE)) {
          bootstrap_invoke_all('exit');
        }
        // We are done.
        exit;
      }
      else {
        header('X-Drupal-Cache: MISS');
      }
    }
  }

  /**
   * Initializes the database system and registers autoload functions.
   */
  function _drupal_bootstrap_database() {
    // Redirect the user to the installation script if Drupal has not been
    // installed yet (i.e., if no $databases array has been defined in the
    // settings.php file) and we are not already installing.
    if (empty($GLOBALS['databases']) && !drupal_installation_attempted()) {
      include_once DRUPAL_ROOT . '/includes/install.inc';
      install_goto('install.php');
    }

    // The user agent header is used to pass a database prefix in the request when
    // running tests. However, for security reasons, it is imperative that we
    // validate we ourselves made the request.
    if ($test_prefix = drupal_valid_test_ua()) {
      // Set the test run id for use in other parts of Drupal.
      $test_info = &$GLOBALS['drupal_test_info'];
      $test_info['test_run_id'] = $test_prefix;
      $test_info['in_child_site'] = TRUE;

      foreach ($GLOBALS['databases']['default'] as &$value) {
        // Extract the current default database prefix.
        if (!isset($value['prefix'])) {
          $current_prefix = '';
        }
        elseif (is_array($value['prefix'])) {
          $current_prefix = $value['prefix']['default'];
        }
        else {
          $current_prefix = $value['prefix'];
        }

        // Remove the current database prefix and replace it by our own.
        $value['prefix'] = array(
          'default' => $current_prefix . $test_prefix,
        );
      }
    }

    // Initialize the database system. Note that the connection
    // won't be initialized until it is actually requested.
    require_once DRUPAL_ROOT . '/includes/database/database.inc';

    // Register autoload functions so that we can access classes and interfaces.
    // The database autoload routine comes first so that we can load the database
    // system without hitting the database. That is especially important during
    // the install or upgrade process.
    spl_autoload_register('drupal_autoload_class');
    spl_autoload_register('drupal_autoload_interface');
    if (version_compare(PHP_VERSION, '5.4') >= 0) {
      spl_autoload_register('drupal_autoload_trait');
    }
  }

  /**
   * Loads system variables and all enabled bootstrap modules.
   */
  function _drupal_bootstrap_variables() {
    global $conf;

    // Initialize the lock system.
    require_once DRUPAL_ROOT . '/' . variable_get('lock_inc', 'includes/lock.inc');
    lock_initialize();

    // Load variables from the database, but do not overwrite variables set in settings.php.
    $conf = variable_initialize(isset($conf) ? $conf : []);
    // Load bootstrap modules.
    require_once DRUPAL_ROOT . '/includes/module.inc';
    module_load_all(TRUE);

    // Sanitize the destination parameter (which is often used for redirects) to
    // prevent open redirect attacks leading to other domains. Sanitize both
    // $_GET['destination'] and $_REQUEST['destination'] to protect code that
    // relies on either, but do not sanitize $_POST to avoid interfering with
    // unrelated form submissions. The sanitization happens here because
    // url_is_external() requires the variable system to be available.
    if (isset($_GET['destination']) || isset($_REQUEST['destination'])) {
      require_once DRUPAL_ROOT . '/includes/common.inc';
      // If the destination is an external URL, remove it.
      if (isset($_GET['destination']) && url_is_external($_GET['destination'])) {
        unset($_GET['destination']);
        unset($_REQUEST['destination']);
      }
      // Use the DrupalRequestSanitizer to ensure that the destination's query
      // parameters are not dangerous.
      if (isset($_GET['destination'])) {
        DrupalRequestSanitizer::cleanDestination();
      }
      // If there's still something in $_REQUEST['destination'] that didn't come
      // from $_GET, check it too.
      if (isset($_REQUEST['destination']) && (!isset($_GET['destination']) || $_REQUEST['destination'] != $_GET['destination']) && url_is_external($_REQUEST['destination'])) {
        unset($_REQUEST['destination']);
      }
    }
  }

  /**
   * Invokes hook_boot(), initializes locking system, and sends HTTP headers.
   */
  function _drupal_bootstrap_page_header() {
    bootstrap_invoke_all('boot');

    if (!drupal_is_cli()) {
      ob_start();
      drupal_page_header();
    }
  }

  /**
   * Returns the current bootstrap phase for this Drupal process.
   *
   * The current phase is the one most recently completed by drupal_bootstrap().
   *
   * @see drupal_bootstrap()
   */
  function drupal_get_bootstrap_phase() {
    return $this->drupal_bootstrap(NULL, FALSE);
  }

  /**
   * Returns the test prefix if this is an internal request from SimpleTest.
   *
   * @return
   *   Either the simpletest prefix (the string "simpletest" followed by any
   *   number of digits) or FALSE if the user agent does not contain a valid
   *   HMAC and timestamp.
   */
  function drupal_valid_test_ua() {
    // No reason to reset this.
    static $test_prefix;

    if (isset($test_prefix)) {
      return $test_prefix;
    }

    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/^(simpletest\d+);(.+);(.+);(.+)$/", $_SERVER['HTTP_USER_AGENT'], $matches)) {
      list(, $prefix, $time, $salt, $hmac) = $matches;
      $check_string =  $prefix . ';' . $time . ';' . $salt;
      // We use the salt from settings.php to make the HMAC key, since
      // the database is not yet initialized and we can't access any Drupal variables.
      // The file properties add more entropy not easily accessible to others.
      $key = drupal_get_hash_salt() . filectime(__FILE__) . fileinode(__FILE__);
      $time_diff = REQUEST_TIME - $time;
      // Since we are making a local request a 5 second time window is allowed,
      // and the HMAC must match.
      if ($time_diff >= 0 && $time_diff <= 5 && $hmac == drupal_hmac_base64($check_string, $key)) {
        $test_prefix = $prefix;
        return $test_prefix;
      }
    }

    $test_prefix = FALSE;
    return $test_prefix;
  }

  /**
   * Generates a user agent string with a HMAC and timestamp for simpletest.
   */
  function drupal_generate_test_ua($prefix) {
    static $key;

    if (!isset($key)) {
      // We use the salt from settings.php to make the HMAC key, since
      // the database is not yet initialized and we can't access any Drupal variables.
      // The file properties add more entropy not easily accessible to others.
      $key = drupal_get_hash_salt() . filectime(__FILE__) . fileinode(__FILE__);
    }
    // Generate a moderately secure HMAC based on the database credentials.
    $salt = uniqid('', TRUE);
    $check_string = $prefix . ';' . time() . ';' . $salt;
    return $check_string . ';' . drupal_hmac_base64($check_string, $key);
  }

  /**
   * Enables use of the theme system without requiring database access.
   *
   * Loads and initializes the theme system for site installs, updates and when
   * the site is in maintenance mode. This also applies when the database fails.
   *
   * @see _drupal_maintenance_theme()
   */
  function drupal_maintenance_theme() {
    require_once DRUPAL_ROOT . '/includes/theme.maintenance.inc';
    _drupal_maintenance_theme();
  }

  /**
   * Returns a simple 404 Not Found page.
   *
   * If fast 404 pages are enabled, and this is a matching page then print a
   * simple 404 page and exit.
   *
   * This function is called from drupal_deliver_html_page() at the time when a
   * a normal 404 page is generated, but it can also optionally be called directly
   * from settings.php to prevent a Drupal bootstrap on these pages. See
   * documentation in settings.php for the benefits and drawbacks of using this.
   *
   * Paths to dynamically-generated content, such as image styles, should also be
   * accounted for in this function.
   */
  function drupal_fast_404() {
    $exclude_paths = variable_get('404_fast_paths_exclude', FALSE);
    if ($exclude_paths && !preg_match($exclude_paths, $_GET['q'])) {
      $fast_paths = variable_get('404_fast_paths', FALSE);
      if ($fast_paths && preg_match($fast_paths, $_GET['q'])) {
        drupal_add_http_header('Status', '404 Not Found');
        $fast_404_html = variable_get('404_fast_html', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>');
        // Replace @path in the variable with the page path.
        print strtr($fast_404_html, array('@path' => check_plain(request_uri())));
        exit;
      }
    }
  }

  /**
   * Returns TRUE if a Drupal installation is currently being attempted.
   */
  function drupal_installation_attempted() {
    return defined('MAINTENANCE_MODE') && MAINTENANCE_MODE == 'install';
  }

  /**
   * Returns the name of the proper localization function.
   *
   * get_t() exists to support localization for code that might run during
   * the installation phase, when some elements of the system might not have
   * loaded.
   *
   * This would include implementations of hook_install(), which could run
   * during the Drupal installation phase, and might also be run during
   * non-installation time, such as while installing the module from the
   * module administration page.
   *
   * Example usage:
   * @code
   *   $t = get_t();
   *   $translated = $t('translate this');
   * @endcode
   *
   * Use t() if your code will never run during the Drupal installation phase.
   * Use st() if your code will only run during installation and never any other
   * time. Use get_t() if your code could run in either circumstance.
   *
   * @see t()
   * @see st()
   * @ingroup sanitization
   */
  function get_t() {
    static $t;
    // This is not converted to drupal_static because there is no point in
    // resetting this as it can not change in the course of a request.
    if (!isset($t)) {
      $t = drupal_installation_attempted() ? 'st' : 't';
    }
    return $t;
  }

  /**
   * Initializes all the defined language types.
   */
  function drupal_language_initialize() {
    $types = language_types();

    // Ensure the language is correctly returned, even without multilanguage
    // support. Also make sure we have a $language fallback, in case a language
    // negotiation callback needs to do a full bootstrap.
    // Useful for eg. XML/HTML 'lang' attributes.
    $default = language_default();
    foreach ($types as $type) {
      $GLOBALS[$type] = $default;
    }
    if (drupal_multilingual()) {
      include_once DRUPAL_ROOT . '/includes/language.inc';
      foreach ($types as $type) {
        $GLOBALS[$type] = language_initialize($type);
      }
      // Allow modules to react on language system initialization in multilingual
      // environments.
      bootstrap_invoke_all('language_init');
    }
  }

  /**
   * Returns a list of the built-in language types.
   *
   * @return
   *   An array of key-values pairs where the key is the language type and the
   *   value is its configurability.
   */
  function drupal_language_types() {
    return array(
      LANGUAGE_TYPE_INTERFACE => TRUE,
      LANGUAGE_TYPE_CONTENT => FALSE,
      LANGUAGE_TYPE_URL => FALSE,
    );
  }

  /**
   * Returns TRUE if there is more than one language enabled.
   *
   * @return
   *   TRUE if more than one language is enabled.
   */
  function drupal_multilingual() {
    // The "language_count" variable stores the number of enabled languages to
    // avoid unnecessarily querying the database when building the list of
    // enabled languages on monolingual sites.
    return variable_get('language_count', 1) > 1;
  }

  /**
   * Returns an array of the available language types.
   *
   * @return
   *   An array of all language types where the keys of each are the language type
   *   name and its value is its configurability (TRUE/FALSE).
   */
  function language_types() {
    return array_keys(variable_get('language_types', drupal_language_types()));
  }

  /**
   * Returns a list of installed languages, indexed by the specified key.
   *
   * @param $field
   *   (optional) The field to index the list with.
   *
   * @return
   *   An associative array, keyed on the values of $field.
   *   - If $field is 'weight' or 'enabled', the array is nested, with the outer
   *     array's values each being associative arrays with language codes as
   *     keys and language objects as values.
   *   - For all other values of $field, the array is only one level deep, and
   *     the array's values are language objects.
   */
  function language_list($field = 'language') {
    $languages = &drupal_static(__FUNCTION__);
    // Init language list
    if (!isset($languages)) {
      if (drupal_multilingual() || module_exists('locale')) {
        $languages['language'] = db_query('SELECT * FROM {languages} ORDER BY weight ASC, name ASC')->fetchAllAssoc('language');
        // Users cannot uninstall the native English language. However, we allow
        // it to be hidden from the installed languages. Therefore, at least one
        // other language must be enabled then.
        if (!$languages['language']['en']->enabled && !variable_get('language_native_enabled', TRUE)) {
          unset($languages['language']['en']);
        }
      }
      else {
        // No locale module, so use the default language only.
        $default = language_default();
        $languages['language'][$default->language] = $default;
      }
    }

    // Return the array indexed by the right field
    if (!isset($languages[$field])) {
      $languages[$field] = [];
      foreach ($languages['language'] as $lang) {
        // Some values should be collected into an array
        if (in_array($field, array('enabled', 'weight'))) {
          $languages[$field][$lang->$field][$lang->language] = $lang;
        }
        else {
          $languages[$field][$lang->$field] = $lang;
        }
      }
    }
    return $languages[$field];
  }

  /**
   * Returns the default language, as an object, or one of its properties.
   *
   * @param $property
   *   (optional) The property of the language object to return.
   *
   * @return
   *   Either the language object for the default language used on the site,
   *   or the property of that object named in the $property parameter.
   */
  function language_default($property = NULL) {
    $language = variable_get('language_default', (object) array('language' => 'en', 'name' => 'English', 'native' => 'English', 'direction' => 0, 'enabled' => 1, 'plurals' => 0, 'formula' => '', 'domain' => '', 'prefix' => '', 'weight' => 0, 'javascript' => ''));
    return $property ? $language->$property : $language;
  }

  /**
   * Returns the requested URL path of the page being viewed.
   *
   * Examples:
   * - http://example.com/node/306 returns "node/306".
   * - http://example.com/drupalfolder/node/306 returns "node/306" while
   *   base_path() returns "/drupalfolder/".
   * - http://example.com/path/alias (which is a path alias for node/306) returns
   *   "path/alias" as opposed to the internal path.
   * - http://example.com/index.php returns an empty string (meaning: front page).
   * - http://example.com/index.php?page=1 returns an empty string.
   *
   * @return
   *   The requested Drupal URL path.
   *
   * @see current_path()
   */
  function request_path() {
    static $path;

    if (isset($path)) {
      return $path;
    }

    if (isset($_GET['q']) && is_string($_GET['q'])) {
      // This is a request with a ?q=foo/bar query string. $_GET['q'] is
      // overwritten in drupal_path_initialize(), but request_path() is called
      // very early in the bootstrap process, so the original value is saved in
      // $path and returned in later calls.
      $path = $_GET['q'];
    }
    elseif (isset($_SERVER['REQUEST_URI'])) {
      // This request is either a clean URL, or 'index.php', or nonsense.
      // Extract the path from REQUEST_URI.
      $request_path = strtok($_SERVER['REQUEST_URI'], '?');
      $base_path_len = strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/'));
      // Unescape and strip $base_path prefix, leaving q without a leading slash.
      $path = substr(urldecode($request_path), $base_path_len + 1);
      // If the path equals the script filename, either because 'index.php' was
      // explicitly provided in the URL, or because the server added it to
      // $_SERVER['REQUEST_URI'] even when it wasn't provided in the URL (some
      // versions of Microsoft IIS do this), the front page should be served.
      if ($path == basename($_SERVER['PHP_SELF'])) {
        $path = '';
      }
    }
    else {
      // This is the front page.
      $path = '';
    }

    // Under certain conditions Apache's RewriteRule directive prepends the value
    // assigned to $_GET['q'] with a slash. Moreover we can always have a trailing
    // slash in place, hence we need to normalize $_GET['q'].
    $path = trim($path, '/');

    return $path;
  }

  /**
   * Returns a component of the current Drupal path.
   *
   * When viewing a page at the path "admin/structure/types", for example, arg(0)
   * returns "admin", arg(1) returns "structure", and arg(2) returns "types".
   *
   * Avoid use of this function where possible, as resulting code is hard to
   * read. In menu callback functions, attempt to use named arguments. See the
   * explanation in menu.inc for how to construct callbacks that take arguments.
   * When attempting to use this function to load an element from the current
   * path, e.g. loading the node on a node page, use menu_get_object() instead.
   *
   * @param $index
   *   The index of the component, where each component is separated by a '/'
   *   (forward-slash), and where the first component has an index of 0 (zero).
   * @param $path
   *   A path to break into components. Defaults to the path of the current page.
   *
   * @return
   *   The component specified by $index, or NULL if the specified component was
   *   not found. If called without arguments, it returns an array containing all
   *   the components of the current path.
   */
  function arg($index = NULL, $path = NULL) {
    // Even though $arguments doesn't need to be resettable for any functional
    // reasons (the result of explode() does not depend on any run-time
    // information), it should be resettable anyway in case a module needs to
    // free up the memory used by it.
    // Use the advanced drupal_static() pattern, since this is called very often.
    static $drupal_static_fast;
    if (!isset($drupal_static_fast)) {
      $drupal_static_fast['arguments'] = &drupal_static(__FUNCTION__);
    }
    $arguments = &$drupal_static_fast['arguments'];

    if (!isset($path)) {
      $path = $_GET['q'];
    }
    if (!isset($arguments[$path])) {
      $arguments[$path] = explode('/', $path);
    }
    if (!isset($index)) {
      return $arguments[$path];
    }
    if (isset($arguments[$path][$index])) {
      return $arguments[$path][$index];
    }
  }

  /**
   * Returns the IP address of the client machine.
   *
   * If Drupal is behind a reverse proxy, we use the X-Forwarded-For header
   * instead of $_SERVER['REMOTE_ADDR'], which would be the IP address of
   * the proxy server, and not the client's. The actual header name can be
   * configured by the reverse_proxy_header variable.
   *
   * @return
   *   IP address of client machine, adjusted for reverse proxy and/or cluster
   *   environments.
   */
  function ip_address() {
    $ip_address = &drupal_static(__FUNCTION__);

    if (!isset($ip_address)) {
      $ip_address = $_SERVER['REMOTE_ADDR'];

      if (variable_get('reverse_proxy', 0)) {
        $reverse_proxy_header = variable_get('reverse_proxy_header', 'HTTP_X_FORWARDED_FOR');
        if (!empty($_SERVER[$reverse_proxy_header])) {
          // If an array of known reverse proxy IPs is provided, then trust
          // the XFF header if request really comes from one of them.
          $reverse_proxy_addresses = variable_get('reverse_proxy_addresses', []);

          // Turn XFF header into an array.
          $forwarded = explode(',', $_SERVER[$reverse_proxy_header]);

          // Trim the forwarded IPs; they may have been delimited by commas and spaces.
          $forwarded = array_map('trim', $forwarded);

          // Tack direct client IP onto end of forwarded array.
          $forwarded[] = $ip_address;

          // Eliminate all trusted IPs.
          $untrusted = array_diff($forwarded, $reverse_proxy_addresses);

          if (!empty($untrusted)) {
            // The right-most IP is the most specific we can trust.
            $ip_address = array_pop($untrusted);
          }
          else {
            // All IP addresses in the forwarded array are configured proxy IPs
            // (and thus trusted). We take the leftmost IP.
            $ip_address = array_shift($forwarded);
          }
        }
      }
    }

    return $ip_address;
  }

  /**
   * @addtogroup schemaapi
   * @{
   */

  /**
   * Gets the schema definition of a table, or the whole database schema.
   *
   * The returned schema will include any modifications made by any
   * module that implements hook_schema_alter(). To get the schema without
   * modifications, use drupal_get_schema_unprocessed().
   *
   *
   * @param $table
   *   The name of the table. If not given, the schema of all tables is returned.
   * @param $rebuild
   *   If true, the schema will be rebuilt instead of retrieved from the cache.
   */
  function drupal_get_schema($table = NULL, $rebuild = FALSE) {
    static $schema;

    if ($rebuild || !isset($table)) {
      $schema = drupal_get_complete_schema($rebuild);
    }
    elseif (!isset($schema)) {
      $schema = new SchemaCache();
    }

    if (!isset($table)) {
      return $schema;
    }
    if (isset($schema[$table])) {
      return $schema[$table];
    }
    else {
      return FALSE;
    }
  }

  /**
   * Gets the whole database schema.
   *
   * The returned schema will include any modifications made by any
   * module that implements hook_schema_alter().
   *
   * @param $rebuild
   *   If true, the schema will be rebuilt instead of retrieved from the cache.
   */
  function drupal_get_complete_schema($rebuild = FALSE) {
    static $schema = [];

    if (empty($schema) || $rebuild) {
      // Try to load the schema from cache.
      if (!$rebuild && $cached = cache_get('schema')) {
        $schema = $cached->data;
      }
      // Otherwise, rebuild the schema cache.
      else {
        $schema = [];
        // Load the .install files to get hook_schema.
        // On some databases this function may be called before bootstrap has
        // been completed, so we force the functions we need to load just in case.
        if (function_exists('module_load_all_includes')) {
          // This function can be called very early in the bootstrap process, so
          // we force the module_list() cache to be refreshed to ensure that it
          // contains the complete list of modules before we go on to call
          // module_load_all_includes().
          module_list(TRUE);
          module_load_all_includes('install');
        }

        require_once DRUPAL_ROOT . '/includes/common.inc';
        // Invoke hook_schema for all modules.
        foreach (module_implements('schema') as $module) {
          // Cast the result of hook_schema() to an array, as a NULL return value
          // would cause array_merge() to set the $schema variable to NULL as well.
          // That would break modules which use $schema further down the line.
          $current = (array) module_invoke($module, 'schema');
          // Set 'module' and 'name' keys for each table, and remove descriptions,
          // as they needlessly slow down cache_get() for every single request.
          _drupal_schema_initialize($current, $module);
          $schema = array_merge($schema, $current);
        }

        drupal_alter('schema', $schema);
        // If the schema is empty, avoid saving it: some database engines require
        // the schema to perform queries, and this could lead to infinite loops.
        if (!empty($schema) && (drupal_get_bootstrap_phase() == DRUPAL_BOOTSTRAP_FULL)) {
          cache_set('schema', $schema);
        }
        if ($rebuild) {
          cache_clear_all('schema:', 'cache', TRUE);
        }
      }
    }

    return $schema;
  }

  /**
   * @} End of "addtogroup schemaapi".
   */


  /**
   * @addtogroup registry
   * @{
   */

  /**
   * Confirms that an interface is available.
   *
   * This function is rarely called directly. Instead, it is registered as an
   * spl_autoload()  handler, and PHP calls it for us when necessary.
   *
   * @param $interface
   *   The name of the interface to check or load.
   *
   * @return
   *   TRUE if the interface is currently available, FALSE otherwise.
   */
  function drupal_autoload_interface($interface) {
    return _registry_check_code('interface', $interface);
  }

  /**
   * Confirms that a class is available.
   *
   * This function is rarely called directly. Instead, it is registered as an
   * spl_autoload()  handler, and PHP calls it for us when necessary.
   *
   * @param $class
   *   The name of the class to check or load.
   *
   * @return
   *   TRUE if the class is currently available, FALSE otherwise.
   */
  function drupal_autoload_class($class) {
    return _registry_check_code('class', $class);
  }

  /**
   * Confirms that a trait is available.
   *
   * This function is rarely called directly. Instead, it is registered as an
   * spl_autoload() handler, and PHP calls it for us when necessary.
   *
   * @param string $trait
   *   The name of the trait to check or load.
   *
   * @return bool
   *   TRUE if the trait is currently available, FALSE otherwise.
   */
  function drupal_autoload_trait($trait) {
    return _registry_check_code('trait', $trait);
  }

  /**
   * Checks for a resource in the registry.
   *
   * @param $type
   *   The type of resource we are looking up, or one of the constants
   *   REGISTRY_RESET_LOOKUP_CACHE or REGISTRY_WRITE_LOOKUP_CACHE, which
   *   signal that we should reset or write the cache, respectively.
   * @param $name
   *   The name of the resource, or NULL if either of the REGISTRY_* constants
   *   is passed in.
   *
   * @return
   *   TRUE if the resource was found, FALSE if not.
   *   NULL if either of the REGISTRY_* constants is passed in as $type.
   */
  function _registry_check_code($type, $name = NULL) {
    static $lookup_cache, $cache_update_needed;

    if ($type == 'class' && class_exists($name) || $type == 'interface' && interface_exists($name) || $type == 'trait' && trait_exists($name)) {
      return TRUE;
    }

    if (!isset($lookup_cache)) {
      $lookup_cache = [];
      if ($cache = cache_get('lookup_cache', 'cache_bootstrap')) {
        $lookup_cache = $cache->data;
      }
    }

    // When we rebuild the registry, we need to reset this cache so
    // we don't keep lookups for resources that changed during the rebuild.
    if ($type == REGISTRY_RESET_LOOKUP_CACHE) {
      $cache_update_needed = TRUE;
      $lookup_cache = NULL;
      return;
    }

    // Called from drupal_page_footer, we write to permanent storage if there
    // changes to the lookup cache for this request.
    if ($type == REGISTRY_WRITE_LOOKUP_CACHE) {
      if ($cache_update_needed) {
        cache_set('lookup_cache', $lookup_cache, 'cache_bootstrap');
      }
      return;
    }

    // $type is either 'interface' or 'class', so we only need the first letter to
    // keep the cache key unique.
    $cache_key = $type[0] . $name;
    if (isset($lookup_cache[$cache_key])) {
      if ($lookup_cache[$cache_key]) {
        include_once DRUPAL_ROOT . '/' . $lookup_cache[$cache_key];
      }
      return (bool) $lookup_cache[$cache_key];
    }

    // This function may get called when the default database is not active, but
    // there is no reason we'd ever want to not use the default database for
    // this query.
    $file = Database::getConnection('default', 'default')
      ->select('registry', 'r', array('target' => 'default'))
      ->fields('r', array('filename'))
      // Use LIKE here to make the query case-insensitive.
      ->condition('r.name', db_like($name), 'LIKE')
      ->condition('r.type', $type)
      ->execute()
      ->fetchField();

    // Flag that we've run a lookup query and need to update the cache.
    $cache_update_needed = TRUE;

    // Misses are valuable information worth caching, so cache even if
    // $file is FALSE.
    $lookup_cache[$cache_key] = $file;

    if ($file) {
      include_once DRUPAL_ROOT . '/' . $file;
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Rescans all enabled modules and rebuilds the registry.
   *
   * Rescans all code in modules or includes directories, storing the location of
   * each interface or class in the database.
   */
  function registry_rebuild() {
    system_rebuild_module_data();
    registry_update();
  }

  /**
   * Updates the registry based on the latest files listed in the database.
   *
   * This function should be used when system_rebuild_module_data() does not need
   * to be called, because it is already known that the list of files in the
   * {system} table matches those in the file system.
   *
   * @return
   *   TRUE if the registry was rebuilt, FALSE if another thread was rebuilding
   *   in parallel and the current thread just waited for completion.
   *
   * @see registry_rebuild()
   */
  function registry_update() {
    // install_system_module() calls module_enable() which calls into this
    // function during initial system installation, so the lock system is neither
    // loaded nor does its storage exist yet.
    $in_installer = drupal_installation_attempted();
    if (!$in_installer && !lock_acquire(__FUNCTION__)) {
      // Another request got the lock, wait for it to finish.
      lock_wait(__FUNCTION__);
      return FALSE;
    }

    require_once DRUPAL_ROOT . '/includes/registry.inc';
    _registry_update();

    if (!$in_installer) {
      lock_release(__FUNCTION__);
    }
    return TRUE;
  }

  /**
   * @} End of "addtogroup registry".
   */

  /**
   * Provides central static variable storage.
   *
   * All functions requiring a static variable to persist or cache data within
   * a single page request are encouraged to use this function unless it is
   * absolutely certain that the static variable will not need to be reset during
   * the page request. By centralizing static variable storage through this
   * function, other functions can rely on a consistent API for resetting any
   * other function's static variables.
   *
   * Example:
   * @code
   * function language_list($field = 'language') {
   *   $languages = &drupal_static(__FUNCTION__);
   *   if (!isset($languages)) {
   *     // If this function is being called for the first time after a reset,
   *     // query the database and execute any other code needed to retrieve
   *     // information about the supported languages.
   *     ...
   *   }
   *   if (!isset($languages[$field])) {
   *     // If this function is being called for the first time for a particular
   *     // index field, then execute code needed to index the information already
   *     // available in $languages by the desired field.
   *     ...
   *   }
   *   // Subsequent invocations of this function for a particular index field
   *   // skip the above two code blocks and quickly return the already indexed
   *   // information.
   *   return $languages[$field];
   * }
   * function locale_translate_overview_screen() {
   *   // When building the content for the translations overview page, make
   *   // sure to get completely fresh information about the supported languages.
   *   drupal_static_reset('language_list');
   *   ...
   * }
   * @endcode
   *
   * In a few cases, a function can have certainty that there is no legitimate
   * use-case for resetting that function's static variable. This is rare,
   * because when writing a function, it's hard to forecast all the situations in
   * which it will be used. A guideline is that if a function's static variable
   * does not depend on any information outside of the function that might change
   * during a single page request, then it's ok to use the "static" keyword
   * instead of the drupal_static() function.
   *
   * Example:
   * @code
   * function actions_do(...) {
   *   // $stack tracks the number of recursive calls.
   *   static $stack;
   *   $stack++;
   *   if ($stack > variable_get('actions_max_stack', 35)) {
   *     ...
   *     return;
   *   }
   *   ...
   *   $stack--;
   * }
   * @endcode
   *
   * In a few cases, a function needs a resettable static variable, but the
   * function is called many times (100+) during a single page request, so
   * every microsecond of execution time that can be removed from the function
   * counts. These functions can use a more cumbersome, but faster variant of
   * calling drupal_static(). It works by storing the reference returned by
   * drupal_static() in the calling function's own static variable, thereby
   * removing the need to call drupal_static() for each iteration of the function.
   * Conceptually, it replaces:
   * @code
   * $foo = &drupal_static(__FUNCTION__);
   * @endcode
   * with:
   * @code
   * // Unfortunately, this does not work.
   * static $foo = &drupal_static(__FUNCTION__);
   * @endcode
   * However, the above line of code does not work, because PHP only allows static
   * variables to be initializied by literal values, and does not allow static
   * variables to be assigned to references.
   * - http://php.net/manual/language.variables.scope.php#language.variables.scope.static
   * - http://php.net/manual/language.variables.scope.php#language.variables.scope.references
   * The example below shows the syntax needed to work around both limitations.
   * For benchmarks and more information, see http://drupal.org/node/619666.
   *
   * Example:
   * @code
   * function user_access($string, $account = NULL) {
   *   // Use the advanced drupal_static() pattern, since this is called very often.
   *   static $drupal_static_fast;
   *   if (!isset($drupal_static_fast)) {
   *     $drupal_static_fast['perm'] = &drupal_static(__FUNCTION__);
   *   }
   *   $perm = &$drupal_static_fast['perm'];
   *   ...
   * }
   * @endcode
   *
   * @param $name
   *   Globally unique name for the variable. For a function with only one static,
   *   variable, the function name (e.g. via the PHP magic __FUNCTION__ constant)
   *   is recommended. For a function with multiple static variables add a
   *   distinguishing suffix to the function name for each one.
   * @param $default_value
   *   Optional default value.
   * @param $reset
   *   TRUE to reset one or all variables(s). This parameter is only used
   *   internally and should not be passed in; use drupal_static_reset() instead.
   *   (This function's return value should not be used when TRUE is passed in.)
   *
   * @return
   *   Returns a variable by reference.
   *
   * @see drupal_static_reset()
   */
  function &drupal_static($name, $default_value = NULL, $reset = FALSE) {
    static $data = [], $default = [];
    // First check if dealing with a previously defined static variable.
    if (isset($data[$name]) || array_key_exists($name, $data)) {
      // Non-NULL $name and both $data[$name] and $default[$name] statics exist.
      if ($reset) {
        // Reset pre-existing static variable to its default value.
        $data[$name] = $default[$name];
      }
      return $data[$name];
    }
    // Neither $data[$name] nor $default[$name] static variables exist.
    if (isset($name)) {
      if ($reset) {
        // Reset was called before a default is set and yet a variable must be
        // returned.
        return $data;
      }
      // First call with new non-NULL $name. Initialize a new static variable.
      $default[$name] = $data[$name] = $default_value;
      return $data[$name];
    }
    // Reset all: ($name == NULL). This needs to be done one at a time so that
    // references returned by earlier invocations of drupal_static() also get
    // reset.
    foreach ($default as $name => $value) {
      $data[$name] = $value;
    }
    // As the function returns a reference, the return should always be a
    // variable.
    return $data;
  }

  /**
   * Resets one or all centrally stored static variable(s).
   *
   * @param $name
   *   Name of the static variable to reset. Omit to reset all variables.
   *   Resetting all variables should only be used, for example, for running unit
   *   tests with a clean environment.
   */
  function drupal_static_reset($name = NULL) {
    drupal_static($name, NULL, TRUE);
  }

  /**
   * Detects whether the current script is running in a command-line environment.
   */
  function drupal_is_cli() {
    return (!isset($_SERVER['SERVER_SOFTWARE']) && (php_sapi_name() == 'cli' || (is_numeric($_SERVER['argc']) && $_SERVER['argc'] > 0)));
  }

  /**
   * Formats text for emphasized display in a placeholder inside a sentence.
   *
   * Used automatically by format_string().
   *
   * @param $text
   *   The text to format (plain-text).
   *
   * @return
   *   The formatted text (html).
   */
  function drupal_placeholder($text) {
    return '<em class="placeholder">' . $this->check_plain($text) . '</em>';
  }

  /**
   * Registers a function for execution on shutdown.
   *
   * Wrapper for register_shutdown_function() that catches thrown exceptions to
   * avoid "Exception thrown without a stack frame in Unknown".
   *
   * @param $callback
   *   The shutdown function to register.
   * @param ...
   *   Additional arguments to pass to the shutdown function.
   *
   * @return
   *   Array of shutdown functions to be executed.
   *
   * @see register_shutdown_function()
   * @ingroup php_wrappers
   */
  function &drupal_register_shutdown_function($callback = NULL) {
    // We cannot use drupal_static() here because the static cache is reset during
    // batch processing, which breaks batch handling.
    static $callbacks = [];

    if (isset($callback)) {
      // Only register the internal shutdown function once.
      if (empty($callbacks)) {
        register_shutdown_function('_drupal_shutdown_function');
      }
      $args = func_get_args();
      array_shift($args);
      // Save callback and arguments
      $callbacks[] = array('callback' => $callback, 'arguments' => $args);
    }
    return $callbacks;
  }

  /**
   * Executes registered shutdown functions.
   */
  function _drupal_shutdown_function() {
    $callbacks = &drupal_register_shutdown_function();

    // Set the CWD to DRUPAL_ROOT as it is not guaranteed to be the same as it
    // was in the normal context of execution.
    chdir(DRUPAL_ROOT);

    try {
      // Manually iterate over the array instead of using a foreach loop.
      // A foreach operates on a copy of the array, so any shutdown functions that
      // were added from other shutdown functions would never be called.
      while ($callback = current($callbacks)) {
        call_user_func_array($callback['callback'], $callback['arguments']);
        next($callbacks);
      }
    }
    catch (Exception $exception) {
      // If we are displaying errors, then do so with no possibility of a further uncaught exception being thrown.
    require_once DRUPAL_ROOT . '/includes/errors.inc';
    if (error_displayable()) {
        print '<h1>Uncaught exception thrown in shutdown function.</h1>';
        print '<p>' . _drupal_render_exception_safe($exception) . '</p><hr />';
      }
    }
  }

  /**
   * Compares the memory required for an operation to the available memory.
   *
   * @param $required
   *   The memory required for the operation, expressed as a number of bytes with
   *   optional SI or IEC binary unit prefix (e.g. 2, 3K, 5MB, 10G, 6GiB, 8bytes,
   *   9mbytes).
   * @param $memory_limit
   *   (optional) The memory limit for the operation, expressed as a number of
   *   bytes with optional SI or IEC binary unit prefix (e.g. 2, 3K, 5MB, 10G,
   *   6GiB, 8bytes, 9mbytes). If no value is passed, the current PHP
   *   memory_limit will be used. Defaults to NULL.
   *
   * @return
   *   TRUE if there is sufficient memory to allow the operation, or FALSE
   *   otherwise.
   */
  function drupal_check_memory_limit($required, $memory_limit = NULL) {
    if (!isset($memory_limit)) {
      $memory_limit = ini_get('memory_limit');
    }

    // There is sufficient memory if:
    // - No memory limit is set.
    // - The memory limit is set to unlimited (-1).
    // - The memory limit is greater than the memory required for the operation.
    return ((!$memory_limit) || ($memory_limit == -1) || (parse_size($memory_limit) >= parse_size($required)));
  }

  /**
   * Invalidates a PHP file from any active opcode caches.
   *
   * If the opcode cache does not support the invalidation of individual files,
   * the entire cache will be flushed.
   *
   * @param string $filepath
   *   The absolute path of the PHP file to invalidate.
   */
  function drupal_clear_opcode_cache($filepath) {
    if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300) {
      // Below PHP 5.3, clearstatcache does not accept any function parameters.
      clearstatcache();
    }
    else {
      clearstatcache(TRUE, $filepath);
    }

    // Zend OPcache.
    if (function_exists('opcache_invalidate')) {
      opcache_invalidate($filepath, TRUE);
    }
    // APC.
    if (function_exists('apc_delete_file')) {
      // apc_delete_file() throws a PHP warning in case the specified file was
      // not compiled yet.
      // @see http://php.net/apc-delete-file
      @apc_delete_file($filepath);
    }
  }
}