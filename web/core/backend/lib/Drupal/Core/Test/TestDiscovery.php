<?php

namespace Drupal\Core\Test;

use Doctrine\Common\Reflection\StaticReflectionParser;
use Drupal\Component\Annotation\Reflection\MockFileFinder;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Extension\ExtensionDiscovery;
use Drupal\Core\Test\Exception\MissingGroupException;
use Drupal\TestTools\PhpUnitCompatibility\PhpUnit8\ClassWriter;
use PHPUnit\Util\Test;

/**
 * Discovers available tests.
 */
class TestDiscovery {

  /**
   * The class loader.
   *
   * @var \Composer\Autoload\ClassLoader
   */
  protected $classLoader;

  /**
   * Statically cached list of test classes.
   *
   * @var array
   */
  protected $testClasses;

  /**
   * Cached map of all test namespaces to respective directories.
   *
   * @var array
   */
  protected $testNamespaces;

  /**
   * Cached list of all available extension names, keyed by extension type.
   *
   * @var array
   */
  protected $availableExtensions;

  /**
   * The app root.
   *
   * @var string
   */
  protected $root;

  /**
   * Constructs a new test discovery.
   *
   * @param string $root
   *   The app root.
   * @param $class_loader
   *   The class loader. Normally Composer's ClassLoader, as included by the
   *   front controller, but may also be decorated; e.g.,
   *   \Symfony\Component\ClassLoader\ApcClassLoader.
   */
  public function __construct($root, $class_loader) {
    $this->root = $root;
    $this->classLoader = $class_loader;
  }

  /**
   * Registers test namespaces of all extensions and core test classes.
   *
   * @return array
   *   An associative array whose keys are PSR-4 namespace prefixes and whose
   *   values are directory names.
   */
  public function registerTestNamespaces() {
    if (isset($this->testNamespaces)) {
      return $this->testNamespaces;
    }
    $this->testNamespaces = [];

    $existing = $this->classLoader->getPrefixesPsr4();

    // Add PHPUnit test namespaces of Drupal core.
    $this->testNamespaces['Drupal\\Tests\\'] = [$this->root . '/core/tests/Drupal/Tests'];
    $this->testNamespaces['Drupal\\BuildTests\\'] = [$this->root . '/core/tests/Drupal/BuildTests'];
    $this->testNamespaces['Drupal\\KernelTests\\'] = [$this->root . '/core/tests/Drupal/KernelTests'];
    $this->testNamespaces['Drupal\\FunctionalTests\\'] = [$this->root . '/core/tests/Drupal/FunctionalTests'];
    $this->testNamespaces['Drupal\\FunctionalJavascriptTests\\'] = [$this->root . '/core/tests/Drupal/FunctionalJavascriptTests'];
    $this->testNamespaces['Drupal\\TestTools\\'] = [$this->root . '/core/tests/Drupal/TestTools'];

    $this->availableExtensions = [];
    foreach ($this->getExtensions() as $name => $extension) {
      $this->availableExtensions[$extension->getType()][$name] = $name;

      $base_path = $this->root . '/' . $extension->getPath();

      // Add namespace of disabled/uninstalled extensions.
      if (!isset($existing["Drupal\\$name\\"])) {
        $this->classLoader->addPsr4("Drupal\\$name\\", "$base_path/src");
      }
      // Add Simpletest test namespace.
      $this->testNamespaces["Drupal\\$name\\Tests\\"][] = "$base_path/src/Tests";

      // Add PHPUnit test namespaces.
      $this->testNamespaces["Drupal\\Tests\\$name\\Unit\\"][] = "$base_path/tests/src/Unit";
      $this->testNamespaces["Drupal\\Tests\\$name\\Kernel\\"][] = "$base_path/tests/src/Kernel";
      $this->testNamespaces["Drupal\\Tests\\$name\\Functional\\"][] = "$base_path/tests/src/Functional";
      $this->testNamespaces["Drupal\\Tests\\$name\\Build\\"][] = "$base_path/tests/src/Build";
      $this->testNamespaces["Drupal\\Tests\\$name\\FunctionalJavascript\\"][] = "$base_path/tests/src/FunctionalJavascript";

      // Add discovery for traits which are shared between different test
      // suites.
      $this->testNamespaces["Drupal\\Tests\\$name\\Traits\\"][] = "$base_path/tests/src/Traits";
    }

    foreach ($this->testNamespaces as $prefix => $paths) {
      $this->classLoader->addPsr4($prefix, $paths);
    }

    $loader = require __DIR__ . '/../../../../../autoload.php';
    // Ensure we have a valid TestCase class.
    ClassWriter::mutateTestBase($loader);

    return $this->testNamespaces;
  }

  /**
   * Discovers all available tests in all extensions.
   *
   * @param string $extension
   *   (optional) The name of an extension to limit discovery to; e.g., 'node'.
   * @param string[] $types
   *   An array of included test types.
   *
   * @return array
   *   An array of tests keyed by the group name. If a test is annotated to
   *   belong to multiple groups, it will appear under all group keys it belongs
   *   to.
   * @code
   *     $groups['block'] => array(
   *       'Drupal\Tests\block\Functional\BlockTest' => array(
   *         'name' => 'Drupal\Tests\block\Functional\BlockTest',
   *         'description' => 'Tests block UI CRUD functionality.',
   *         'group' => 'block',
   *         'groups' => ['block', 'group2', 'group3'],
   *       ),
   *     );
   * @endcode
   *
   * @todo Remove singular grouping; retain list of groups in 'group' key.
   * @see https://www.drupal.org/node/2296615
   */
  public function getTestClasses($extension = NULL, array $types = []) {
    if (!isset($extension) && empty($types)) {
      if (!empty($this->testClasses)) {
        return $this->testClasses;
      }
    }
    $list = [];

    $classmap = $this->findAllClassFiles($extension);

    // Prevent expensive class loader lookups for each reflected test class by
    // registering the complete classmap of test classes to the class loader.
    // This also ensures that test classes are loaded from the discovered
    // pathnames; a namespace/classname mismatch will throw an exception.
    $this->classLoader->addClassMap($classmap);

    foreach ($classmap as $classname => $pathname) {
      $finder = MockFileFinder::create($pathname);
      $parser = new StaticReflectionParser($classname, $finder, TRUE);
      try {
        $info = static::getTestInfo($classname, $parser->getDocComment());
      }
      catch (MissingGroupException $e) {
        // If the class name ends in Test and is not a migrate table dump.
        if (preg_match('/Test$/', $classname) && strpos($classname, 'migrate_drupal\Tests\Table') === FALSE) {
          throw $e;
        }
        // If the class is @group annotation just skip it. Most likely it is an
        // abstract class, trait or test fixture.
        continue;
      }
      // Skip this test class if it is a Simpletest-based test and requires
      // unavailable modules. TestDiscovery should not filter out module
      // requirements for PHPUnit-based test classes.
      // @todo Move this behavior to \Drupal\simpletest\TestBase so tests can be
      //       marked as skipped, instead.
      // @see https://www.drupal.org/node/1273478
      if ($info['type'] == 'Simpletest') {
        if (!empty($info['requires']['module'])) {
          if (array_diff($info['requires']['module'], $this->availableExtensions['module'])) {
            continue;
          }
        }
      }

      foreach ($info['groups'] as $group) {
        $list[$group][$classname] = $info;
      }
    }

    // Sort the groups and tests within the groups by name.
    uksort($list, 'strnatcasecmp');
    foreach ($list as &$tests) {
      uksort($tests, 'strnatcasecmp');
    }

    if (!isset($extension) && empty($types)) {
      $this->testClasses = $list;
    }

    if ($types) {
      $list = NestedArray::filter($list, function ($element) use ($types) {
        return !(is_array($element) && isset($element['type']) && !in_array($element['type'], $types));
      });
    }

    return $list;
  }

  /**
   * Discovers all class files in all available extensions.
   *
   * @param string $extension
   *   (optional) The name of an extension to limit discovery to; e.g., 'node'.
   *
   * @return array
   *   A classmap containing all discovered class files; i.e., a map of
   *   fully-qualified classnames to pathnames.
   */
  public function findAllClassFiles($extension = NULL) {
    $classmap = [];
    $namespaces = $this->registerTestNamespaces();
    if (isset($extension)) {
      // Include tests in the \Drupal\Tests\{$extension} namespace.
      $pattern = "/Drupal\\\(Tests\\\)?$extension\\\/";
      $namespaces = array_intersect_key($namespaces, array_flip(preg_grep($pattern, array_keys($namespaces))));
    }
    foreach ($namespaces as $namespace => $paths) {
      foreach ($paths as $path) {
        if (!is_dir($path)) {
          continue;
        }
        $classmap += static::scanDirectory($namespace, $path);
      }
    }
    return $classmap;
  }

  /**
   * Scans a given directory for class files.
   *
   * @param string $namespace_prefix
   *   The namespace prefix to use for discovered classes. Must contain a
   *   trailing namespace separator (backslash).
   *   For example: 'Drupal\\node\\Tests\\'
   * @param string $path
   *   The directory path to scan.
   *   For example: '/path/to/drupal/core/backend/modules/node/tests/src'
   *
   * @return array
   *   An associative array whose keys are fully-qualified class names and whose
   *   values are corresponding filesystem pathnames.
   *
   * @throws \InvalidArgumentException
   *   If $namespace_prefix does not end in a namespace separator (backslash).
   *
   * @todo Limit to '*Test.php' files (~10% less files to reflect/introspect).
   * @see https://www.drupal.org/node/2296635
   */
  public static function scanDirectory($namespace_prefix, $path) {
    if (substr($namespace_prefix, -1) !== '\\') {
      throw new \InvalidArgumentException("Namespace prefix for $path must contain a trailing namespace separator.");
    }
    $flags = \FilesystemIterator::UNIX_PATHS;
    $flags |= \FilesystemIterator::SKIP_DOTS;
    $flags |= \FilesystemIterator::FOLLOW_SYMLINKS;
    $flags |= \FilesystemIterator::CURRENT_AS_SELF;
    $flags |= \FilesystemIterator::KEY_AS_FILENAME;

    $iterator = new \RecursiveDirectoryIterator($path, $flags);
    $filter = new \RecursiveCallbackFilterIterator($iterator, function ($current, $file_name, $iterator) {
      if ($iterator->hasChildren()) {
        return TRUE;
      }
      // We don't want to discover abstract TestBase classes, traits or
      // interfaces. They can be deprecated and will call @trigger_error()
      // during discovery.
      return substr($file_name, -4) === '.php' &&
        substr($file_name, -12) !== 'TestBase.php' &&
        substr($file_name, -9) !== 'Trait.php' &&
        substr($file_name, -13) !== 'Interface.php';
    });
    $files = new \RecursiveIteratorIterator($filter);
    $classes = [];
    foreach ($files as $fileinfo) {
      $class = $namespace_prefix;
      if ('' !== $subpath = $fileinfo->getSubPath()) {
        $class .= strtr($subpath, '/', '\\') . '\\';
      }
      $class .= $fileinfo->getBasename('.php');
      $classes[$class] = $fileinfo->getPathname();
    }
    return $classes;
  }

  /**
   * Retrieves information about a test class for UI purposes.
   *
   * @param string $classname
   *   The test classname.
   * @param string $doc_comment
   *   (optional) The class PHPDoc comment. If not passed in reflection will be
   *   used but this is very expensive when parsing all the test classes.
   *
   * @return array
   *   An associative array containing:
   *   - name: The test class name.
   *   - description: The test (PHPDoc) summary.
   *   - group: The test's first @group (parsed from PHPDoc annotations).
   *   - groups: All of the test's @group annotations, as an array (parsed from
   *     PHPDoc annotations).
   *   - requires: An associative array containing test requirements parsed from
   *     PHPDoc annotations:
   *     - module: List of Drupal module extension names the test depends on.
   *
   * @throws \Drupal\simpletest\Exception\MissingGroupException
   *   If the class does not have a @group annotation.
   */
  public static function getTestInfo($classname, $doc_comment = NULL) {
    if ($doc_comment === NULL) {
      $reflection = new \ReflectionClass($classname);
      $doc_comment = $reflection->getDocComment();
    }
    $info = [
      'name' => $classname,
    ];
    $annotations = [];
    // Look for annotations, allow an arbitrary amount of spaces before the
    // * but nothing else.
    preg_match_all('/^[ ]*\* \@([^\s]*) (.*$)/m', $doc_comment, $matches);
    if (isset($matches[1])) {
      foreach ($matches[1] as $key => $annotation) {
        // For historical reasons, there is a single-value 'group' result key
        // and a 'groups' key as an array.
        if ($annotation === 'group') {
          $annotations['groups'][] = $matches[2][$key];
        }
        if (!empty($annotations[$annotation])) {
          // Only @group is allowed to have more than one annotation, in the
          // 'groups' key. Other annotations only have one value per key.
          continue;
        }
        $annotations[$annotation] = $matches[2][$key];
      }
    }

    if (empty($annotations['group'])) {
      // Concrete tests must have a group.
      throw new MissingGroupException(sprintf('Missing @group annotation in %s', $classname));
    }
    $info['group'] = $annotations['group'];
    $info['groups'] = $annotations['groups'];

    // Sort out PHPUnit-runnable tests by type.
    if ($testsuite = static::getPhpunitTestSuite($classname)) {
      $info['type'] = 'PHPUnit-' . $testsuite;
    }
    else {
      $info['type'] = 'Simpletest';
    }

    if (!empty($annotations['coversDefaultClass'])) {
      $info['description'] = 'Tests ' . $annotations['coversDefaultClass'] . '.';
    }
    else {
      $info['description'] = static::parseTestClassSummary($doc_comment);
    }
    if (isset($annotations['dependencies'])) {
      $info['requires']['module'] = array_map('trim', explode(',', $annotations['dependencies']));
    }

    return $info;
  }

  /**
   * Parses the phpDoc summary line of a test class.
   *
   * @param string $doc_comment
   *
   * @return string
   *   The parsed phpDoc summary line. An empty string is returned if no summary
   *   line can be parsed.
   */
  public static function parseTestClassSummary($doc_comment) {
    // Normalize line endings.
    $doc_comment = preg_replace('/\r\n|\r/', '\n', $doc_comment);
    // Strip leading and trailing doc block lines.
    $doc_comment = substr($doc_comment, 4, -4);

    $lines = explode("\n", $doc_comment);
    $summary = [];
    // Add every line to the summary until the first empty line or annotation
    // is found.
    foreach ($lines as $line) {
      if (preg_match('/^[ ]*\*$/', $line) || preg_match('/^[ ]*\* \@/', $line)) {
        break;
      }
      $summary[] = trim($line, ' *');
    }
    return implode(' ', $summary);
  }

  /**
   * Parses annotations in the phpDoc of a test class.
   *
   * @param \ReflectionClass $class
   *   The reflected test class.
   *
   * @return array
   *   An associative array that contains all annotations on the test class;
   *   typically including:
   *   - group: A list of @group values.
   *   - requires: An associative array of @requires values; e.g.:
   *     - module: A list of Drupal module dependencies that are required to
   *       exist.
   *
   * @see \PHPUnit\Util\Test::parseTestMethodAnnotations()
   * @see http://phpunit.de/manual/current/en/incomplete-and-skipped-tests.html#incomplete-and-skipped-tests.skipping-tests-using-requires
   */
  public static function parseTestClassAnnotations(\ReflectionClass $class) {
    $annotations = Test::parseTestMethodAnnotations($class->getName())['class'];

    // @todo Enhance PHPUnit upstream to allow for custom @requires identifiers.
    // @see \PHPUnit\Util\Test::getRequirements()
    // @todo Add support for 'PHP', 'OS', 'function', 'extension'.
    // @see https://www.drupal.org/node/1273478
    if (isset($annotations['requires'])) {
      foreach ($annotations['requires'] as $i => $value) {
        list($type, $value) = explode(' ', $value, 2);
        if ($type === 'module') {
          $annotations['requires']['module'][$value] = $value;
          unset($annotations['requires'][$i]);
        }
      }
    }
    return $annotations;
  }

  /**
   * Determines the phpunit testsuite for a given classname, based on namespace.
   *
   * @param string $classname
   *   The test classname.
   *
   * @return string|false
   *   The testsuite name or FALSE if its not a phpunit test.
   */
  public static function getPhpunitTestSuite($classname) {
    if (preg_match('/Drupal\\\\Tests\\\\(\w+)\\\\(\w+)/', $classname, $matches)) {
      // This could be an extension test, in which case the first match will be
      // the extension name. We assume that lower-case strings are module names.
      if (strtolower($matches[1]) == $matches[1]) {
        return $matches[2];
      }
      return 'Unit';
    }
    // Core tests.
    elseif (preg_match('/Drupal\\\\(\w*)Tests\\\\/', $classname, $matches)) {
      if ($matches[1] == '') {
        return 'Unit';
      }
      return $matches[1];
    }
    return FALSE;
  }

  /**
   * Returns all available extensions.
   *
   * @return \Drupal\Core\Extension\Extension[]
   *   An array of Extension objects, keyed by extension name.
   */
  protected function getExtensions() {
    $listing = new ExtensionDiscovery($this->root);
    // Ensure that tests in all profiles are discovered.
    $listing->setProfileDirectories([]);
    $extensions = $listing->scan('module', TRUE);
    $extensions += $listing->scan('profile', TRUE);
    $extensions += $listing->scan('theme', TRUE);
    return $extensions;
  }

}
