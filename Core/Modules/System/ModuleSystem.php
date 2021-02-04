<?php
namespace Core\Modules\System;

/**
 * @file
 * Configuration system that lets administrators modify the workings of the site.
 */

class ModuleSystem {
/**
 * Maximum age of temporary files in seconds.
 */
public $drupal_maximum_temp_file_age = 21600;

/**
 * Default interval for automatic cron executions in seconds.
 */
public $drupal_cron_default_threshold = 10800;

/**
 * New users will be set to the default time zone at registration.
 */
public $drupal_user_timezone_default = 0;

/**
 * New users will get an empty time zone at registration.
 */
public $drupal_user_timezone_empty = 1;

/**
 * New users will select their own timezone at registration.
 */
public $drupal_user_timezone_select = 2;

 /**
 * Disabled option on forms and settings
 */
public $drupal_disabled = 0;

/**
 * Optional option on forms and settings
 */
public $drupal_optional = 1;

/**
 * Required option on forms and settings
 */
public $drupal_required = 2;

/**
 * Maximum number of values in a weight select element.
 *
 * If the number of values is over the maximum, a text field is used instead.
 */
public $drupal_weight_select_max = 100;

/**
 * Return only visible regions.
 *
 * @see system_region_list()
 */
public $regions_visible = 'visible';

/**
 * Return all regions.
 *
 * @see system_region_list()
 */
public $regions_all = 'all';

/**
 * Implements hook_help().
 */
function system_help($path, $arg) {
  global $base_url;

  switch ($path) {
    case 'admin/help#system':
      $output = '';
      $output .= '<h3>' . t('About') . '</h3>';
      $output .= '<p>' . t('The System module is integral to the site, and provides basic but extensible functionality for use by other modules and themes. Some integral elements of Drupal are contained in and managed by the System module, including caching, enabling and disabling modules and themes, preparing and displaying the administrative page, and configuring fundamental site settings. A number of key system maintenance operations are also part of the System module. For more information, see the online handbook entry for <a href="@system">System module</a>.', array('@system' => 'http://drupal.org/documentation/modules/system')) . '</p>';
      $output .= '<h3>' . t('Uses') . '</h3>';
      $output .= '<dl>';
      $output .= '<dt>' . t('Managing modules') . '</dt>';
      $output .= '<dd>' . t('The System module allows users with the appropriate permissions to enable and disable modules on the <a href="@modules">Modules administration page</a>. Drupal comes with a number of core modules, and each module provides a discrete set of features and may be enabled or disabled depending on the needs of the site. Many additional modules contributed by members of the Drupal community are available for download at the <a href="@drupal-modules">Drupal.org module page</a>.', array('@modules' => url('admin/modules'), '@drupal-modules' => 'http://drupal.org/project/modules')) . '</dd>';
      $output .= '<dt>' . t('Managing themes') . '</dt>';
      $output .= '<dd>' . t('The System module allows users with the appropriate permissions to enable and disable themes on the <a href="@themes">Appearance administration page</a>. Themes determine the design and presentation of your site. Drupal comes packaged with several core themes, and additional contributed themes are available at the <a href="@drupal-themes">Drupal.org theme page</a>.', array('@themes' => url('admin/appearance'), '@drupal-themes' => 'http://drupal.org/project/themes')) . '</dd>';
      $output .= '<dt>' . t('Managing caching') . '</dt>';
      $output .= '<dd>' . t("The System module allows users with the appropriate permissions to manage caching on the <a href='@cache-settings'>Performance settings page</a>. Drupal has a robust caching system that allows the efficient re-use of previously-constructed web pages and web page components. Pages requested by anonymous users are stored in a compressed format; depending on your site configuration and the amount of your web traffic tied to anonymous visitors, the caching system may significantly increase the speed of your site.", array('@cache-settings' => url('admin/config/development/performance'))) . '</dd>';
      $output .= '<dt>' . t('Performing system maintenance') . '</dt>';
      $output .= '<dd>' . t('In order for the site and its modules to continue to operate well, a set of routine administrative operations must run on a regular basis. The System module manages this task by making use of a system cron job. You can verify the status of cron tasks by visiting the <a href="@status">Status report page</a>. For more information, see the online handbook entry for <a href="@handbook">configuring cron jobs</a>. You can set up cron job by visiting <a href="@cron">Cron configuration</a> page', array('@status' => url('admin/reports/status'), '@handbook' => 'http://drupal.org/cron', '@cron' => url('admin/config/system/cron'))) . '</dd>';
      $output .= '<dt>' . t('Configuring basic site settings') . '</dt>';
      $output .= '<dd>' . t('The System module also handles basic configuration options for your site, including <a href="@date-time-settings">Date and time settings</a>, <a href="@file-system">File system settings</a>, <a href="@clean-url">Clean URL support</a>, <a href="@site-info">Site name and other information</a>, and a <a href="@maintenance-mode">Maintenance mode</a> for taking your site temporarily offline.', array('@date-time-settings' => url('admin/config/regional/date-time'), '@file-system' => url('admin/config/media/file-system'), '@clean-url' => url('admin/config/search/clean-urls'), '@site-info' => url('admin/config/system/site-information'), '@maintenance-mode' => url('admin/config/development/maintenance'))) . '</dd>';
      $output .= '<dt>' . t('Configuring actions') . '</dt>';
      $output .= '<dd>' . t('Actions are individual tasks that the system can do, such as unpublishing a piece of content or banning a user. Modules, such as the <a href="@trigger-help">Trigger module</a>, can fire these actions when certain system events happen; for example, when a new post is added or when a user logs in. Modules may also provide additional actions. Visit the <a href="@actions">Actions page</a> to configure actions.', array('@trigger-help' => url('admin/help/trigger'), '@actions' => url('admin/config/system/actions'))) . '</dd>';
      $output .= '</dl>';
      return $output;
    case 'admin/index':
      return '<p>' . t('This page shows you all available administration tasks for each module.') . '</p>';
    case 'admin/appearance':
      $output = '<p>' . t('Set and configure the default theme for your website.  Alternative <a href="@themes">themes</a> are available.', array('@themes' => 'http://drupal.org/project/themes')) . '</p>';
      return $output;
    case 'admin/appearance/settings/' . $arg[3]:
      $theme_list = list_themes();
      $theme = $theme_list[$arg[3]];
      return '<p>' . t('These options control the display settings for the %name theme. When your site is displayed using this theme, these settings will be used.', array('%name' => $theme->info['name'])) . '</p>';
    case 'admin/appearance/settings':
      return '<p>' . t('These options control the default display settings for your entire site, across all themes. Unless they have been overridden by a specific theme, these settings will be used.') . '</p>';
    case 'admin/modules':
      $output = '<p>' . t('Download additional <a href="@modules">contributed modules</a> to extend Drupal\'s functionality.', array('@modules' => 'http://drupal.org/project/modules')) . '</p>';
      if (module_exists('update')) {
        if (update_manager_access()) {
          $output .= '<p>' . t('Regularly review and install <a href="@updates">available updates</a> to maintain a secure and current site. Always run the <a href="@update-php">update script</a> each time a module is updated.', array('@update-php' => $base_url . '/update.php', '@updates' => url('admin/reports/updates'))) . '</p>';
        }
        else {
          $output .= '<p>' . t('Regularly review <a href="@updates">available updates</a> to maintain a secure and current site. Always run the <a href="@update-php">update script</a> each time a module is updated.', array('@update-php' => $base_url . '/update.php', '@updates' => url('admin/reports/updates'))) . '</p>';
        }
      }
      else {
        $output .= '<p>' . t('Regularly review available updates to maintain a secure and current site. Always run the <a href="@update-php">update script</a> each time a module is updated. Enable the Update manager module to update and install modules and themes.', array('@update-php' => $base_url . '/update.php')) . '</p>';
      }
      return $output;
    case 'admin/modules/uninstall':
      return '<p>' . t('The uninstall process removes all data related to a module. To uninstall a module, you must first disable it on the main <a href="@modules">Modules page</a>.', array('@modules' => url('admin/modules'))) . '</p>';
    case 'admin/structure/block/manage':
      if ($arg[4] == 'system' && $arg[5] == 'powered-by') {
        return '<p>' . t('The <em>Powered by Drupal</em> block is an optional link to the home page of the Drupal project. While there is absolutely no requirement that sites feature this link, it may be used to show support for Drupal.') . '</p>';
      }
      break;
    case 'admin/config/development/maintenance':
      global $user;
      if ($user->uid == 1) {
        return '<p>' . t('If you are upgrading to a newer version of Drupal or upgrading contributed modules or themes, you may need to run the <a href="@update-php">update script</a>.', array('@update-php' => $base_url . '/update.php')) . '</p>';
      }
      break;
    case 'admin/config/system/actions':
    case 'admin/config/system/actions/manage':
      $output = '';
      $output .= '<p>' . t('There are two types of actions: simple and advanced. Simple actions do not require any additional configuration, and are listed here automatically. Advanced actions need to be created and configured before they can be used, because they have options that need to be specified; for example, sending an e-mail to a specified address, or unpublishing content containing certain words. To create an advanced action, select the action from the drop-down list in the advanced action section below and click the <em>Create</em> button.') . '</p>';
      if (module_exists('trigger')) {
        $output .= '<p>' . t('You may proceed to the <a href="@url">Triggers</a> page to assign these actions to system events.', array('@url' => url('admin/structure/trigger'))) . '</p>';
      }
      return $output;
    case 'admin/config/system/actions/configure':
      return t('An advanced action offers additional configuration options which may be filled out below. Changing the <em>Description</em> field is recommended, in order to better identify the precise action taking place. This description will be displayed in modules such as the Trigger module when assigning actions to system events, so it is best if it is as descriptive as possible (for example, "Send e-mail to Moderation Team" rather than simply "Send e-mail").');
    case 'admin/config/people/ip-blocking':
      return '<p>' . t('IP addresses listed here are blocked from your site. Blocked addresses are completely forbidden from accessing the site and instead see a brief message explaining the situation.') . '</p>';
    case 'admin/reports/status':
      return '<p>' . t("Here you can find a short overview of your site's parameters as well as any problems detected with your installation. It may be useful to copy and paste this information into support requests filed on drupal.org's support forums and project issue queues.") . '</p>';
  }
}

/**
 * Implements hook_theme().
 */
function system_theme() {
  return array_merge(drupal_common_theme(), array(
    'system_themes_page' => array(
      'variables' => array('theme_groups' => NULL),
      'file' => 'system.admin.inc',
    ),
    'system_settings_form' => array(
      'render element' => 'form',
    ),
    'confirm_form' => array(
      'render element' => 'form',
    ),
    'system_modules_fieldset' => array(
      'render element' => 'form',
      'file' => 'system.admin.inc',
    ),
    'system_modules_incompatible' => array(
      'variables' => array('message' => NULL),
      'file' => 'system.admin.inc',
    ),
    'system_modules_uninstall' => array(
      'render element' => 'form',
      'file' => 'system.admin.inc',
    ),
    'status_report' => array(
      'render element' => 'requirements',
      'file' => 'system.admin.inc',
    ),
    'admin_page' => array(
      'variables' => array('blocks' => NULL),
      'file' => 'system.admin.inc',
    ),
    'admin_block' => array(
      'variables' => array('block' => NULL),
      'file' => 'system.admin.inc',
    ),
    'admin_block_content' => array(
      'variables' => array('content' => NULL),
      'file' => 'system.admin.inc',
    ),
    'system_admin_index' => array(
      'variables' => array('menu_items' => NULL),
      'file' => 'system.admin.inc',
    ),
    'system_powered_by' => array(
      'variables' => [],
    ),
    'system_compact_link' => array(
      'variables' => [],
    ),
    'system_date_time_settings' => array(
      'render element' => 'form',
      'file' => 'system.admin.inc',
    ),
  ));
}

/**
 * Implements hook_permission().
 */
function system_permission() {
  return array(
    'administer modules' => array(
      'title' => t('Administer modules'),
    ),
    'administer site configuration' => array(
      'title' => t('Administer site configuration'),
      'restrict access' => TRUE,
    ),
    'administer themes' => array(
      'title' => t('Administer themes'),
    ),
    'administer software updates' => array(
      'title' => t('Administer software updates'),
      'restrict access' => TRUE,
    ),
    'administer actions' => array(
      'title' => t('Administer actions'),
    ),
    'access administration pages' => array(
      'title' => t('Use the administration pages and help'),
    ),
    'access site in maintenance mode' => array(
      'title' => t('Use the site in maintenance mode'),
    ),
    'view the administration theme' => array(
      'title' => t('View the administration theme'),
      'description' => $bootstrap->variable_get('admin_theme') ? '' : t('This is only used when the site is configured to use a separate administration theme on the <a href="@appearance-url">Appearance</a> page.', array('@appearance-url' => url('admin/appearance'))),
    ),
    'access site reports' => array(
      'title' => t('View site reports'),
      'restrict access' => TRUE,
    ),
    'block IP addresses' => array(
      'title' => t('Block IP addresses'),
    ),
  );
}

/**
 * Implements hook_hook_info().
 */
function system_hook_info() {
  $hooks['token_info'] = array(
    'group' => 'tokens',
  );
  $hooks['token_info_alter'] = array(
    'group' => 'tokens',
  );
  $hooks['tokens'] = array(
    'group' => 'tokens',
  );
  $hooks['tokens_alter'] = array(
    'group' => 'tokens',
  );

  return $hooks;
}

/**
 * Implements hook_entity_info().
 */
function system_entity_info() {
  return array(
    'file' => array(
      'label' => t('File'),
      'base table' => 'file_managed',
      'entity keys' => array(
        'id' => 'fid',
        'label' => 'filename',
      ),
      'static cache' => FALSE,
    ),
  );
}

/**
 * Implements hook_element_info().
 */
function system_element_info() {
  // Top level elements.
  $types['form'] = array(
    '#method' => 'post',
    '#action' => request_uri(),
    '#theme_wrappers' => array('form'),
  );
  $types['page'] = array(
    '#show_messages' => TRUE,
    '#theme' => 'page',
    '#theme_wrappers' => array('html'),
  );
  // By default, we don't want Ajax commands being rendered in the context of an
  // HTML page, so we don't provide defaults for #theme or #theme_wrappers.
  // However, modules can set these properties (for example, to provide an HTML
  // debugging page that displays rather than executes Ajax commands).
  $types['ajax'] = array(
    '#header' => TRUE,
    '#commands' => [],
    '#error' => NULL,
  );
  $types['html_tag'] = array(
    '#theme' => 'html_tag',
    '#pre_render' => array('drupal_pre_render_conditional_comments'),
    '#attributes' => [],
    '#value' => NULL,
  );
  $types['styles'] = array(
    '#items' => [],
    '#pre_render' => array('drupal_pre_render_styles'),
    '#group_callback' => 'drupal_group_css',
    '#aggregate_callback' => 'drupal_aggregate_css',
  );
  $types['scripts'] = array(
    '#items' => [],
    '#pre_render' => array('drupal_pre_render_scripts'),
  );

  // Input elements.
  $types['submit'] = array(
    '#input' => TRUE,
    '#name' => 'op',
    '#button_type' => 'submit',
    '#executes_submit_callback' => TRUE,
    '#limit_validation_errors' => FALSE,
    '#process' => array('ajax_process_form'),
    '#theme_wrappers' => array('button'),
  );
  $types['button'] = array(
    '#input' => TRUE,
    '#name' => 'op',
    '#button_type' => 'submit',
    '#executes_submit_callback' => FALSE,
    '#limit_validation_errors' => FALSE,
    '#process' => array('ajax_process_form'),
    '#theme_wrappers' => array('button'),
  );
  $types['image_button'] = array(
    '#input' => TRUE,
    '#button_type' => 'submit',
    '#executes_submit_callback' => TRUE,
    '#limit_validation_errors' => FALSE,
    '#process' => array('ajax_process_form'),
    '#return_value' => TRUE,
    '#has_garbage_value' => TRUE,
    '#src' => NULL,
    '#theme_wrappers' => array('image_button'),
  );
  $types['textfield'] = array(
    '#input' => TRUE,
    '#size' => 60,
    '#maxlength' => 128,
    '#autocomplete_path' => FALSE,
    '#process' => array('form_process_autocomplete', 'ajax_process_form'),
    '#theme' => 'textfield',
    '#theme_wrappers' => array('form_element'),
  );
  $types['machine_name'] = array(
    '#input' => TRUE,
    '#default_value' => NULL,
    '#required' => TRUE,
    '#maxlength' => 64,
    '#size' => 60,
    '#autocomplete_path' => FALSE,
    '#process' => array('form_process_machine_name', 'ajax_process_form'),
    '#element_validate' => array('form_validate_machine_name'),
    '#theme' => 'textfield',
    '#theme_wrappers' => array('form_element'),
    // Use the same value callback as for textfields; this ensures that we only
    // get string values.
    '#value_callback' => 'form_type_textfield_value',
  );
  $types['password'] = array(
    '#input' => TRUE,
    '#size' => 60,
    '#maxlength' => 128,
    '#process' => array('ajax_process_form'),
    '#theme' => 'password',
    '#theme_wrappers' => array('form_element'),
    // Use the same value callback as for textfields; this ensures that we only
    // get string values.
    '#value_callback' => 'form_type_textfield_value',
  );
  $types['password_confirm'] = array(
    '#input' => TRUE,
    '#process' => array('form_process_password_confirm', 'user_form_process_password_confirm'),
    '#theme_wrappers' => array('form_element'),
  );
  $types['textarea'] = array(
    '#input' => TRUE,
    '#cols' => 60,
    '#rows' => 5,
    '#resizable' => TRUE,
    '#process' => array('ajax_process_form'),
    '#theme' => 'textarea',
    '#theme_wrappers' => array('form_element'),
  );
  $types['radios'] = array(
    '#input' => TRUE,
    '#process' => array('form_process_radios'),
    '#theme_wrappers' => array('radios'),
    '#pre_render' => array('form_pre_render_conditional_form_element'),
  );
  $types['radio'] = array(
    '#input' => TRUE,
    '#default_value' => NULL,
    '#process' => array('ajax_process_form'),
    '#theme' => 'radio',
    '#theme_wrappers' => array('form_element'),
    '#title_display' => 'after',
  );
  $types['checkboxes'] = array(
    '#input' => TRUE,
    '#process' => array('form_process_checkboxes'),
    '#theme_wrappers' => array('checkboxes'),
    '#pre_render' => array('form_pre_render_conditional_form_element'),
  );
  $types['checkbox'] = array(
    '#input' => TRUE,
    '#return_value' => 1,
    '#theme' => 'checkbox',
    '#process' => array('form_process_checkbox', 'ajax_process_form'),
    '#theme_wrappers' => array('form_element'),
    '#title_display' => 'after',
  );
  $types['select'] = array(
    '#input' => TRUE,
    '#multiple' => FALSE,
    '#process' => array('form_process_select', 'ajax_process_form'),
    '#theme' => 'select',
    '#theme_wrappers' => array('form_element'),
  );
  $types['weight'] = array(
    '#input' => TRUE,
    '#delta' => 10,
    '#default_value' => 0,
    '#process' => array('form_process_weight', 'ajax_process_form'),
  );
  $types['date'] = array(
    '#input' => TRUE,
    '#element_validate' => array('date_validate'),
    '#process' => array('form_process_date'),
    '#theme' => 'date',
    '#theme_wrappers' => array('form_element'),
  );
  $types['file'] = array(
    '#input' => TRUE,
    '#size' => 60,
    '#theme' => 'file',
    '#theme_wrappers' => array('form_element'),
  );
  $types['tableselect'] = array(
    '#input' => TRUE,
    '#js_select' => TRUE,
    '#multiple' => TRUE,
    '#process' => array('form_process_tableselect'),
    '#options' => [],
    '#empty' => '',
    '#theme' => 'tableselect',
  );

  // Form structure.
  $types['item'] = array(
    '#markup' => '',
    '#pre_render' => array('drupal_pre_render_markup'),
    '#theme_wrappers' => array('form_element'),
  );
  $types['hidden'] = array(
    '#input' => TRUE,
    '#process' => array('ajax_process_form'),
    '#theme' => 'hidden',
  );
  $types['value'] = array(
    '#input' => TRUE,
  );
  $types['markup'] = array(
    '#markup' => '',
    '#pre_render' => array('drupal_pre_render_markup'),
  );
  $types['link'] = array(
    '#pre_render' => array('drupal_pre_render_link', 'drupal_pre_render_markup'),
  );
  $types['fieldset'] = array(
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
    '#value' => NULL,
    '#process' => array('form_process_fieldset', 'ajax_process_form'),
    '#pre_render' => array('form_pre_render_fieldset'),
    '#theme_wrappers' => array('fieldset'),
  );
  $types['vertical_tabs'] = array(
    '#theme_wrappers' => array('vertical_tabs'),
    '#default_tab' => '',
    '#process' => array('form_process_vertical_tabs'),
  );

  $types['container'] = array(
    '#theme_wrappers' => array('container'),
    '#process' => array('form_process_container'),
  );
  $types['actions'] = array(
    '#theme_wrappers' => array('container'),
    '#process' => array('form_process_actions', 'form_process_container'),
    '#weight' => 100,
  );

  $types['token'] = array(
    '#input' => TRUE,
    '#theme' => 'hidden',
  );

  return $types;
}

/**
 * Implements hook_menu().
 */
function system_menu() {
  $items['system/files'] = array(
    'title' => 'File download',
    'page callback' => 'file_download',
    'page arguments' => array('private'),
    'access callback' => TRUE,
    'type' => MENU_CALLBACK,
  );
  $items['system/temporary'] = array(
    'title' => 'Temporary files',
    'page callback' => 'file_download',
    'page arguments' => array('temporary'),
    'access callback' => TRUE,
    'type' => MENU_CALLBACK,
  );
  $items['system/ajax'] = array(
    'title' => 'AHAH callback',
    'page callback' => 'ajax_form_callback',
    'delivery callback' => 'ajax_deliver',
    'access callback' => TRUE,
    'theme callback' => 'ajax_base_page_theme',
    'type' => MENU_CALLBACK,
    'file path' => 'includes',
    'file' => 'form.inc',
  );
  $items['system/timezone'] = array(
    'title' => 'Time zone',
    'page callback' => 'system_timezone',
    'access callback' => TRUE,
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  $items['admin'] = array(
    'title' => 'Administration',
    'access arguments' => array('access administration pages'),
    'page callback' => 'system_admin_menu_block_page',
    'weight' => 9,
    'menu_name' => 'management',
    'file' => 'system.admin.inc',
  );
  $items['admin/compact'] = array(
    'title' => 'Compact mode',
    'page callback' => 'system_admin_compact_page',
    'access arguments' => array('access administration pages'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  $items['admin/tasks'] = array(
    'title' => 'Tasks',
    'type' => MENU_DEFAULT_LOCAL_TASK,
    'weight' => -20,
  );
  $items['admin/index'] = array(
    'title' => 'Index',
    'page callback' => 'system_admin_index',
    'access arguments' => array('access administration pages'),
    'type' => MENU_LOCAL_TASK,
    'weight' => -18,
    'file' => 'system.admin.inc',
  );

  // Menu items that are basically just menu blocks.
  $items['admin/structure'] = array(
    'title' => 'Structure',
    'description' => 'Administer blocks, content types, menus, etc.',
    'position' => 'right',
    'weight' => -8,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  // Appearance.
  $items['admin/appearance'] = array(
    'title' => 'Appearance',
    'description' => 'Select and configure your themes.',
    'page callback' => 'system_themes_page',
    'access arguments' => array('administer themes'),
    'position' => 'left',
    'weight' => -6,
    'file' => 'system.admin.inc',
  );
  $items['admin/appearance/list'] = array(
    'title' => 'List',
    'description' => 'Select and configure your theme',
    'type' => MENU_DEFAULT_LOCAL_TASK,
    'weight' => -1,
    'file' => 'system.admin.inc',
  );
  $items['admin/appearance/enable'] = array(
    'title' => 'Enable theme',
    'page callback' => 'system_theme_enable',
    'access arguments' => array('administer themes'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  $items['admin/appearance/disable'] = array(
    'title' => 'Disable theme',
    'page callback' => 'system_theme_disable',
    'access arguments' => array('administer themes'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  $items['admin/appearance/default'] = array(
    'title' => 'Set default theme',
    'page callback' => 'system_theme_default',
    'access arguments' => array('administer themes'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  $items['admin/appearance/settings'] = array(
    'title' => 'Settings',
    'description' => 'Configure default and theme specific settings.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_theme_settings'),
    'access arguments' => array('administer themes'),
    'type' => MENU_LOCAL_TASK,
    'file' => 'system.admin.inc',
    'weight' => 20,
  );
  // Theme configuration subtabs.
  $items['admin/appearance/settings/global'] = array(
    'title' => 'Global settings',
    'type' => MENU_DEFAULT_LOCAL_TASK,
    'weight' => -1,
  );

  foreach (list_themes() as $theme) {
    $items['admin/appearance/settings/' . $theme->name] = array(
      'title' => $theme->info['name'],
      'page arguments' => array('system_theme_settings', $theme->name),
      'type' => MENU_LOCAL_TASK,
      'access callback' => '_system_themes_access',
      'access arguments' => array($theme),
      'file' => 'system.admin.inc',
    );
  }

  // Modules.
  $items['admin/modules'] = array(
    'title' => 'Modules',
    'description' => 'Extend site functionality.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_modules'),
    'access arguments' => array('administer modules'),
    'file' => 'system.admin.inc',
    'weight' => -2,
  );
  $items['admin/modules/list'] = array(
    'title' => 'List',
    'type' => MENU_DEFAULT_LOCAL_TASK,
  );
  $items['admin/modules/list/confirm'] = array(
    'title' => 'List',
    'access arguments' => array('administer modules'),
    'type' => MENU_VISIBLE_IN_BREADCRUMB,
  );
  $items['admin/modules/uninstall'] = array(
    'title' => 'Uninstall',
    'page arguments' => array('system_modules_uninstall'),
    'access arguments' => array('administer modules'),
    'type' => MENU_LOCAL_TASK,
    'file' => 'system.admin.inc',
    'weight' => 20,
  );
  $items['admin/modules/uninstall/confirm'] = array(
    'title' => 'Uninstall',
    'access arguments' => array('administer modules'),
    'type' => MENU_VISIBLE_IN_BREADCRUMB,
    'file' => 'system.admin.inc',
  );

  // Configuration.
  $items['admin/config'] = array(
    'title' => 'Configuration',
    'description' => 'Administer settings.',
    'page callback' => 'system_admin_config_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );

  // IP address blocking.
  $items['admin/config/people/ip-blocking'] = array(
    'title' => 'IP address blocking',
    'description' => 'Manage blocked IP addresses.',
    'page callback' => 'system_ip_blocking',
    'access arguments' => array('block IP addresses'),
    'file' => 'system.admin.inc',
    'weight' => 10,
  );
  $items['admin/config/people/ip-blocking/delete/%blocked_ip'] = array(
    'title' => 'Delete IP address',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_ip_blocking_delete', 5),
    'access arguments' => array('block IP addresses'),
    'file' => 'system.admin.inc',
  );

  // Media settings.
  $items['admin/config/media'] = array(
    'title' => 'Media',
    'description' => 'Media tools.',
    'position' => 'left',
    'weight' => -10,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/media/file-system'] = array(
    'title' => 'File system',
    'description' => 'Tell Drupal where to store uploaded files and how they are accessed.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_file_system_settings'),
    'access arguments' => array('administer site configuration'),
    'weight' => -10,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/media/image-toolkit'] = array(
    'title' => 'Image toolkit',
    'description' => 'Choose which image toolkit to use if you have installed optional toolkits.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_image_toolkit_settings'),
    'access arguments' => array('administer site configuration'),
    'weight' => 20,
    'file' => 'system.admin.inc',
  );

  // Service settings.
  $items['admin/config/services'] = array(
    'title' => 'Web services',
    'description' => 'Tools related to web services.',
    'position' => 'right',
    'weight' => 0,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/services/rss-publishing'] = array(
    'title' => 'RSS publishing',
    'description' => 'Configure the site description, the number of items per feed and whether feeds should be titles/teasers/full-text.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_rss_feeds_settings'),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
  );

  // Development settings.
  $items['admin/config/development'] = array(
    'title' => 'Development',
    'description' => 'Development tools.',
    'position' => 'right',
    'weight' => -10,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/development/maintenance'] = array(
    'title' => 'Maintenance mode',
    'description' => 'Take the site offline for maintenance or bring it back online.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_site_maintenance_mode'),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
    'weight' => -10,
  );
  $items['admin/config/development/performance'] = array(
    'title' => 'Performance',
    'description' => 'Enable or disable page caching for anonymous users and set CSS and JS bandwidth optimization options.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_performance_settings'),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
    'weight' => -20,
  );
  $items['admin/config/development/logging'] = array(
    'title' => 'Logging and errors',
    'description' => "Settings for logging and alerts modules. Various modules can route Drupal's system events to different destinations, such as syslog, database, email, etc.",
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_logging_settings'),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
    'weight' => -15,
  );

  // Regional and date settings.
  $items['admin/config/regional'] = array(
    'title' => 'Regional and language',
    'description' => 'Regional settings, localization and translation.',
    'position' => 'left',
    'weight' => -5,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/settings'] = array(
    'title' => 'Regional settings',
    'description' => "Settings for the site's default time zone and country.",
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_regional_settings'),
    'access arguments' => array('administer site configuration'),
    'weight' => -20,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time'] = array(
    'title' => 'Date and time',
    'description' => 'Configure display formats for date and time.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_date_time_settings'),
    'access arguments' => array('administer site configuration'),
    'weight' => -15,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/types'] = array(
    'title' => 'Types',
    'description' => 'Configure display formats for date and time.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_date_time_settings'),
    'access arguments' => array('administer site configuration'),
    'type' => MENU_DEFAULT_LOCAL_TASK,
    'weight' => -10,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/types/add'] = array(
    'title' => 'Add date type',
    'description' => 'Add new date type.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_add_date_format_type_form'),
    'access arguments' => array('administer site configuration'),
    'type' => MENU_LOCAL_ACTION,
    'weight' => -10,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/types/%/delete'] = array(
    'title' => 'Delete date type',
    'description' => 'Allow users to delete a configured date type.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_delete_date_format_type_form', 5),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/formats'] = array(
    'title' => 'Formats',
    'description' => 'Configure display format strings for date and time.',
    'page callback' => 'system_date_time_formats',
    'access arguments' => array('administer site configuration'),
    'type' => MENU_LOCAL_TASK,
    'weight' => -9,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/formats/add'] = array(
    'title' => 'Add format',
    'description' => 'Allow users to add additional date formats.',
    'type' => MENU_LOCAL_ACTION,
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_configure_date_formats_form'),
    'access arguments' => array('administer site configuration'),
    'weight' => -10,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/formats/%/edit'] = array(
    'title' => 'Edit date format',
    'description' => 'Allow users to edit a configured date format.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_configure_date_formats_form', 5),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/formats/%/delete'] = array(
    'title' => 'Delete date format',
    'description' => 'Allow users to delete a configured date format.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_date_delete_format_form', 5),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/regional/date-time/formats/lookup'] = array(
    'title' => 'Date and time lookup',
    'page callback' => 'system_date_time_lookup',
    'access arguments' => array('administer site configuration'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );

  // Search settings.
  $items['admin/config/search'] = array(
    'title' => 'Search and metadata',
    'description' => 'Local site search, metadata and SEO.',
    'position' => 'left',
    'weight' => -10,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/search/clean-urls'] = array(
    'title' => 'Clean URLs',
    'description' => 'Enable or disable clean URLs for your site.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_clean_url_settings'),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
    'weight' => 5,
  );
  $items['admin/config/search/clean-urls/check'] = array(
    'title' => 'Clean URL check',
    'page callback' => 'drupal_json_output',
    'page arguments' => array(array('status' => TRUE)),
    'access callback' => TRUE,
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );

  // System settings.
  $items['admin/config/system'] = array(
    'title' => 'System',
    'description' => 'General system related configuration.',
    'position' => 'right',
    'weight' => -20,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/system/actions'] = array(
    'title' => 'Actions',
    'description' => 'Manage the actions defined for your site.',
    'access arguments' => array('administer actions'),
    'page callback' => 'system_actions_manage',
    'file' => 'system.admin.inc',
  );
  $items['admin/config/system/actions/manage'] = array(
    'title' => 'Manage actions',
    'description' => 'Manage the actions defined for your site.',
    'page callback' => 'system_actions_manage',
    'type' => MENU_DEFAULT_LOCAL_TASK,
    'weight' => -2,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/system/actions/configure'] = array(
    'title' => 'Configure an advanced action',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_actions_configure'),
    'access arguments' => array('administer actions'),
    'type' => MENU_VISIBLE_IN_BREADCRUMB,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/system/actions/delete/%actions'] = array(
    'title' => 'Delete action',
    'description' => 'Delete an action.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_actions_delete_form', 5),
    'access arguments' => array('administer actions'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/system/actions/orphan'] = array(
    'title' => 'Remove orphans',
    'page callback' => 'system_actions_remove_orphans',
    'access arguments' => array('administer actions'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  $items['admin/config/system/site-information'] = array(
    'title' => 'Site information',
    'description' => 'Change site name, e-mail address, slogan, default front page, and number of posts per page, error pages.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_site_information_settings'),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
    'weight' => -20,
  );
  $items['admin/config/system/cron'] = array(
    'title' => 'Cron',
    'description' => 'Manage automatic site maintenance tasks.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('system_cron_settings'),
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
    'weight' => 20,
  );
  // Additional categories
  $items['admin/config/user-interface'] = array(
    'title' => 'User interface',
    'description' => 'Tools that enhance the user interface.',
    'position' => 'right',
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
    'weight' => -15,
  );
  $items['admin/config/workflow'] = array(
    'title' => 'Workflow',
    'description' => 'Content workflow, editorial workflow tools.',
    'position' => 'right',
    'weight' => 5,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );
  $items['admin/config/content'] = array(
    'title' => 'Content authoring',
    'description' => 'Settings related to formatting and authoring content.',
    'position' => 'left',
    'weight' => -15,
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access administration pages'),
    'file' => 'system.admin.inc',
  );

  // Reports.
  $items['admin/reports'] = array(
    'title' => 'Reports',
    'description' => 'View reports, updates, and errors.',
    'page callback' => 'system_admin_menu_block_page',
    'access arguments' => array('access site reports'),
    'weight' => 5,
    'position' => 'left',
    'file' => 'system.admin.inc',
  );
  $items['admin/reports/status'] = array(
    'title' => 'Status report',
    'description' => "Get a status report about your site's operation and any detected problems.",
    'page callback' => 'system_status',
    'weight' => -60,
    'access arguments' => array('administer site configuration'),
    'file' => 'system.admin.inc',
  );
  $items['admin/reports/status/run-cron'] = array(
    'title' => 'Run cron',
    'page callback' => 'system_run_cron',
    'access arguments' => array('administer site configuration'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  $items['admin/reports/status/php'] = array(
    'title' => 'PHP',
    'page callback' => 'system_php',
    'access arguments' => array('administer site configuration'),
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );

  // Default page for batch operations.
  $items['batch'] = array(
    'page callback' => 'system_batch_page',
    'access callback' => TRUE,
    'theme callback' => '_system_batch_theme',
    'type' => MENU_CALLBACK,
    'file' => 'system.admin.inc',
  );
  return $items;
}

/**
 * Theme callback for the default batch page.
 */
function _system_batch_theme() {
  // Retrieve the current state of the batch.
  $batch = &batch_get();
  if (!$batch && isset($_REQUEST['id'])) {
    require_once DRUPAL_ROOT . '/includes/batch.inc';
    $batch = batch_load($_REQUEST['id']);
  }
  // Use the same theme as the page that started the batch.
  if (!empty($batch['theme'])) {
    return $batch['theme'];
  }
}

/**
 * Implements hook_library().
 */
function system_library() {
  // Drupal's Ajax framework.
  $libraries['drupal.ajax'] = array(
    'title' => 'Drupal AJAX',
    'website' => 'http://api.drupal.org/api/drupal/includes--ajax.inc/group/ajax/7',
    'version' => VERSION,
    'js' => array(
      'misc/ajax.js' => array('group' => JS_LIBRARY, 'weight' => 2),
    ),
    'dependencies' => array(
      array('system', 'drupal.progress'),
    ),
  );

  // Drupal's batch API.
  $libraries['drupal.batch'] = array(
    'title' => 'Drupal batch API',
    'version' => VERSION,
    'js' => array(
      'misc/batch.js' => array('group' => JS_DEFAULT, 'cache' => FALSE),
    ),
    'dependencies' => array(
      array('system', 'drupal.progress'),
    ),
  );

  // Drupal's progress indicator.
  $libraries['drupal.progress'] = array(
    'title' => 'Drupal progress indicator',
    'version' => VERSION,
    'js' => array(
      'misc/progress.js' => array('group' => JS_DEFAULT),
    ),
  );

  // Drupal's form library.
  $libraries['drupal.form'] = array(
    'title' => 'Drupal form library',
    'version' => VERSION,
    'js' => array(
      'misc/form.js' => array('group' => JS_LIBRARY, 'weight' => 1),
    ),
  );

  // Drupal's states library.
  $libraries['drupal.states'] = array(
    'title' => 'Drupal states',
    'version' => VERSION,
    'js' => array(
      'misc/states.js' => array('group' => JS_LIBRARY, 'weight' => 1),
    ),
  );

  // Drupal's collapsible fieldset.
  $libraries['drupal.collapse'] = array(
    'title' => 'Drupal collapsible fieldset',
    'version' => VERSION,
    'js' => array(
      'misc/collapse.js' => array('group' => JS_DEFAULT),
    ),
    'dependencies' => array(
      // collapse.js relies on drupalGetSummary in form.js
      array('system', 'drupal.form'),
    ),
  );

  // Drupal's resizable textarea.
  $libraries['drupal.textarea'] = array(
    'title' => 'Drupal resizable textarea',
    'version' => VERSION,
    'js' => array(
      'misc/textarea.js' => array('group' => JS_DEFAULT),
    ),
  );

  // Drupal's autocomplete widget.
  $libraries['drupal.autocomplete'] = array(
    'title' => 'Drupal autocomplete',
    'version' => VERSION,
    'js' => array(
      'misc/autocomplete.js' => array('group' => JS_DEFAULT),
    ),
  );

  // jQuery.
  $libraries['jquery'] = array(
    'title' => 'jQuery',
    'website' => 'http://jquery.com',
    'version' => '1.4.4',
    'js' => array(
      'misc/jquery.js' => array('group' => JS_LIBRARY, 'weight' => -20),
      // These include security fixes, so assign a weight that makes them load
      // as soon after jquery.js is loaded as possible.
      'misc/jquery-extend-3.4.0.js' => array('group' => JS_LIBRARY, 'weight' => -19),
      'misc/jquery-html-prefilter-3.5.0-backport.js' => array('group' => JS_LIBRARY, 'weight' => -19),
    ),
  );

  // jQuery Once.
  $libraries['jquery.once'] = array(
    'title' => 'jQuery Once',
    'website' => 'http://plugins.jquery.com/project/once',
    'version' => '1.2',
    'js' => array(
      'misc/jquery.once.js' => array('group' => JS_LIBRARY, 'weight' => -19),
    ),
  );

  // jQuery Form Plugin.
  $libraries['jquery.form'] = array(
    'title' => 'jQuery Form Plugin',
    'website' => 'http://malsup.com/jquery/form/',
    'version' => '2.52',
    'js' => array(
      'misc/jquery.form.js' => [],
    ),
    'dependencies' => array(
      array('system', 'jquery.cookie'),
    ),
  );

  // jQuery BBQ plugin.
  $libraries['jquery.bbq'] = array(
    'title' => 'jQuery BBQ',
    'website' => 'http://benalman.com/projects/jquery-bbq-plugin/',
    'version' => '1.2.1',
    'js' => array(
      'misc/jquery.ba-bbq.js' => [],
    ),
  );

  // Vertical Tabs.
  $libraries['drupal.vertical-tabs'] = array(
    'title' => 'Vertical Tabs',
    'website' => 'http://drupal.org/node/323112',
    'version' => '1.0',
    'js' => array(
      'misc/vertical-tabs.js' => [],
    ),
    'css' => array(
      'misc/vertical-tabs.css' => [],
    ),
    'dependencies' => array(
      // Vertical tabs relies on drupalGetSummary in form.js
      array('system', 'drupal.form'),
    ),
  );

  // Farbtastic.
  $libraries['farbtastic'] = array(
    'title' => 'Farbtastic',
    'website' => 'http://code.google.com/p/farbtastic/',
    'version' => '1.2',
    'js' => array(
      'misc/farbtastic/farbtastic.js' => [],
    ),
    'css' => array(
      'misc/farbtastic/farbtastic.css' => [],
    ),
  );

  // Cookie.
  $libraries['jquery.cookie'] = array(
    'title' => 'Cookie',
    'website' => 'http://plugins.jquery.com/project/cookie',
    'version' => '1.0',
    'js' => array(
      'misc/jquery.cookie.js' => [],
    ),
  );

  // jQuery UI.
  $libraries['ui'] = array(
    'title' => 'jQuery UI: Core',
    'website' => 'http://jqueryui.com',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.core.min.js' => array('group' => JS_LIBRARY, 'weight' => -11),
    ),
    'css' => array(
      'misc/ui/jquery.ui.core.css' => [],
      'misc/ui/jquery.ui.theme.css' => [],
    ),
  );
  $libraries['ui.accordion'] = array(
    'title' => 'jQuery UI: Accordion',
    'website' => 'http://jqueryui.com/demos/accordion/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.accordion.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.accordion.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
    ),
  );
  $libraries['ui.autocomplete'] = array(
    'title' => 'jQuery UI: Autocomplete',
    'website' => 'http://jqueryui.com/demos/autocomplete/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.autocomplete.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.autocomplete.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.position'),
    ),
  );
  $libraries['ui.button'] = array(
    'title' => 'jQuery UI: Button',
    'website' => 'http://jqueryui.com/demos/button/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.button.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.button.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
    ),
  );
  $libraries['ui.datepicker'] = array(
    'title' => 'jQuery UI: Date Picker',
    'website' => 'http://jqueryui.com/demos/datepicker/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.datepicker.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.datepicker.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui'),
    ),
  );
  $libraries['ui.dialog'] = array(
    'title' => 'jQuery UI: Dialog',
    'website' => 'http://jqueryui.com/demos/dialog/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.dialog.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.dialog.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.button'),
      array('system', 'ui.draggable'),
      array('system', 'ui.mouse'),
      array('system', 'ui.position'),
      array('system', 'ui.resizable'),
    ),
  );
  $libraries['ui.draggable'] = array(
    'title' => 'jQuery UI: Draggable',
    'website' => 'http://jqueryui.com/demos/draggable/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.draggable.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.mouse'),
    ),
  );
  $libraries['ui.droppable'] = array(
    'title' => 'jQuery UI: Droppable',
    'website' => 'http://jqueryui.com/demos/droppable/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.droppable.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.mouse'),
      array('system', 'ui.draggable'),
    ),
  );
  $libraries['ui.mouse'] = array(
    'title' => 'jQuery UI: Mouse',
    'website' => 'http://docs.jquery.com/UI/Mouse',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.mouse.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
    ),
  );
  $libraries['ui.position'] = array(
    'title' => 'jQuery UI: Position',
    'website' => 'http://jqueryui.com/demos/position/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.position.min.js' => [],
    ),
  );
  $libraries['ui.progressbar'] = array(
    'title' => 'jQuery UI: Progress Bar',
    'website' => 'http://jqueryui.com/demos/progressbar/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.progressbar.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.progressbar.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
    ),
  );
  $libraries['ui.resizable'] = array(
    'title' => 'jQuery UI: Resizable',
    'website' => 'http://jqueryui.com/demos/resizable/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.resizable.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.resizable.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.mouse'),
    ),
  );
  $libraries['ui.selectable'] = array(
    'title' => 'jQuery UI: Selectable',
    'website' => 'http://jqueryui.com/demos/selectable/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.selectable.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.selectable.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.mouse'),
    ),
  );
  $libraries['ui.slider'] = array(
    'title' => 'jQuery UI: Slider',
    'website' => 'http://jqueryui.com/demos/slider/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.slider.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.slider.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.mouse'),
    ),
  );
  $libraries['ui.sortable'] = array(
    'title' => 'jQuery UI: Sortable',
    'website' => 'http://jqueryui.com/demos/sortable/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.sortable.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
      array('system', 'ui.mouse'),
    ),
  );
  $libraries['ui.tabs'] = array(
    'title' => 'jQuery UI: Tabs',
    'website' => 'http://jqueryui.com/demos/tabs/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.tabs.min.js' => [],
    ),
    'css' => array(
      'misc/ui/jquery.ui.tabs.css' => [],
    ),
    'dependencies' => array(
      array('system', 'ui.widget'),
    ),
  );
  $libraries['ui.widget'] = array(
    'title' => 'jQuery UI: Widget',
    'website' => 'http://docs.jquery.com/UI/Widget',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.ui.widget.min.js' => array('group' => JS_LIBRARY, 'weight' => -10),
    ),
    'dependencies' => array(
      array('system', 'ui'),
    ),
  );
  $libraries['effects'] = array(
    'title' => 'jQuery UI: Effects',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.core.min.js' => array('group' => JS_LIBRARY, 'weight' => -9),
    ),
  );
  $libraries['effects.blind'] = array(
    'title' => 'jQuery UI: Effects Blind',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.blind.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.bounce'] = array(
    'title' => 'jQuery UI: Effects Bounce',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.bounce.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.clip'] = array(
    'title' => 'jQuery UI: Effects Clip',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.clip.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.drop'] = array(
    'title' => 'jQuery UI: Effects Drop',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.drop.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.explode'] = array(
    'title' => 'jQuery UI: Effects Explode',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.explode.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.fade'] = array(
    'title' => 'jQuery UI: Effects Fade',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.fade.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.fold'] = array(
    'title' => 'jQuery UI: Effects Fold',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.fold.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.highlight'] = array(
    'title' => 'jQuery UI: Effects Highlight',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.highlight.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.pulsate'] = array(
    'title' => 'jQuery UI: Effects Pulsate',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.pulsate.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.scale'] = array(
    'title' => 'jQuery UI: Effects Scale',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.scale.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.shake'] = array(
    'title' => 'jQuery UI: Effects Shake',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.shake.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.slide'] = array(
    'title' => 'jQuery UI: Effects Slide',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.slide.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );
  $libraries['effects.transfer'] = array(
    'title' => 'jQuery UI: Effects Transfer',
    'website' => 'http://jqueryui.com/demos/effect/',
    'version' => '1.8.7',
    'js' => array(
      'misc/ui/jquery.effects.transfer.min.js' => [],
    ),
    'dependencies' => array(
      array('system', 'effects'),
    ),
  );

  // These library names are deprecated. Earlier versions of Drupal 7 didn't
  // consistently namespace their libraries, so these names are included for
  // backwards compatibility with those versions.
  $libraries['once'] = &$libraries['jquery.once'];
  $libraries['form'] = &$libraries['jquery.form'];
  $libraries['jquery-bbq'] = &$libraries['jquery.bbq'];
  $libraries['vertical-tabs'] = &$libraries['drupal.vertical-tabs'];
  $libraries['cookie'] = &$libraries['jquery.cookie'];

  return $libraries;
}

/**
 * Implements hook_stream_wrappers().
 */
function system_stream_wrappers() {
  $wrappers = array(
    'public' => array(
      'name' => t('Public files'),
      'class' => 'DrupalPublicStreamWrapper',
      'description' => t('Public local files served by the webserver.'),
      'type' => STREAM_WRAPPERS_LOCAL_NORMAL,
    ),
    'temporary' => array(
      'name' => t('Temporary files'),
      'class' => 'DrupalTemporaryStreamWrapper',
      'description' => t('Temporary local files for upload and previews.'),
      'type' => STREAM_WRAPPERS_LOCAL_HIDDEN,
    ),
  );

  // Only register the private file stream wrapper if a file path has been set.
  if (variable_get('file_private_path', FALSE)) {
    $wrappers['private'] = array(
      'name' => t('Private files'),
      'class' => 'DrupalPrivateStreamWrapper',
      'description' => t('Private local files served by Drupal.'),
      'type' => STREAM_WRAPPERS_LOCAL_NORMAL,
    );
  }

  return $wrappers;
}

/**
 * Retrieve a blocked IP address from the database.
 *
 * @param $iid integer
 *   The ID of the blocked IP address to retrieve.
 *
 * @return
 *   The blocked IP address from the database as an array.
 */
function blocked_ip_load($iid) {
  return db_query("SELECT * FROM {blocked_ips} WHERE iid = :iid", array(':iid' => $iid))->fetchAssoc();
}

/**
 * Menu item access callback - only admin or enabled themes can be accessed.
 */
function _system_themes_access($theme) {
  return user_access('administer themes') && drupal_theme_access($theme);
}

/**
 * @defgroup authorize Authorized operations
 * @{
 * Functions to run operations with elevated privileges via authorize.php.
 *
 * Because of the Update manager functionality included in Drupal core, there
 * is a mechanism for running operations with elevated file system privileges,
 * the top-level authorize.php script. This script runs at a reduced Drupal
 * bootstrap level so that it is not reliant on the entire site being
 * functional. The operations use a FileTransfer class to manipulate code
 * installed on the system as the user that owns the files, not the user that
 * the httpd is running as.
 *
 * The first setup is to define a callback function that should be authorized
 * to run with the elevated privileges. This callback should take a
 * FileTransfer as its first argument, although you can define an array of
 * other arguments it should be invoked with. The callback should be placed in
 * a separate .inc file that will be included by authorize.php.
 *
 * To run the operation, certain data must be saved into the SESSION, and then
 * the flow of control should be redirected to the authorize.php script. There
 * are two ways to do this, either to call system_authorized_run() directly,
 * or to call system_authorized_init() and then redirect to authorize.php,
 * using the URL from system_authorized_get_url(). Redirecting yourself is
 * necessary when your authorized operation is being triggered by a form
 * submit handler, since calling drupal_goto() in a submit handler is a bad
 * idea, and you should instead set $form_state['redirect'].
 *
 * Once the SESSION is setup for the operation and the user is redirected to
 * authorize.php, they will be prompted for their connection credentials (core
 * provides FTP and SSH by default, although other connection classes can be
 * added via contributed modules). With valid credentials, authorize.php will
 * instantiate the appropriate FileTransfer object, and then invoke the
 * desired operation passing in that object. The authorize.php script can act
 * as a Batch API processing page, if the operation requires a batch.
 *
 * @see authorize.php
 * @see FileTransfer
 * @see hook_filetransfer_info()
 */

/**
 * Setup a given callback to run via authorize.php with elevated privileges.
 *
 * To use authorize.php, certain variables must be stashed into $_SESSION. This
 * function sets up all the necessary $_SESSION variables. The calling function
 * should then redirect to authorize.php, using the full path returned by
 * system_authorized_get_url(). That initiates the workflow that will eventually
 * lead to the callback being invoked. The callback will be invoked at a low
 * bootstrap level, without all modules being invoked, so it needs to be careful
 * not to assume any code exists. Example (system_authorized_run()):
 * @code
 *   system_authorized_init($callback, $file, $arguments, $page_title);
 *   drupal_goto(system_authorized_get_url());
 * @endcode
 * Example (update_manager_install_form_submit()):
 * @code
 *  system_authorized_init('update_authorize_run_install',
 *    drupal_get_path('module', 'update') . '/update.authorize.inc',
 *    $arguments, t('Update manager'));
 *  $form_state['redirect'] = system_authorized_get_url();
 * @endcode
 *
 * @param $callback
 *   The name of the function to invoke once the user authorizes the operation.
 * @param $file
 *   The full path to the file where the callback function is implemented.
 * @param $arguments
 *   Optional array of arguments to pass into the callback when it is invoked.
 *   Note that the first argument to the callback is always the FileTransfer
 *   object created by authorize.php when the user authorizes the operation.
 * @param $page_title
 *   Optional string to use as the page title once redirected to authorize.php.
 * @return
 *   Nothing, this function just initializes variables in the user's session.
 */
function system_authorized_init($callback, $file, $arguments = [], $page_title = NULL) {
  // First, figure out what file transfer backends the site supports, and put
  // all of those in the SESSION so that authorize.php has access to all of
  // them via the class autoloader, even without a full bootstrap.
  $_SESSION['authorize_filetransfer_info'] = drupal_get_filetransfer_info();

  // Now, define the callback to invoke.
  $_SESSION['authorize_operation'] = array(
    'callback' => $callback,
    'file' => $file,
    'arguments' => $arguments,
  );

  if (isset($page_title)) {
    $_SESSION['authorize_operation']['page_title'] = $page_title;
  }
}

/**
 * Return the URL for the authorize.php script.
 *
 * @param array $options
 *   Optional array of options to pass to url().
 * @return
 *   The full URL to authorize.php, using HTTPS if available.
 *
 * @see system_authorized_init()
 */
function system_authorized_get_url(array $options = []) {
  global $base_url;
  // Force HTTPS if available, regardless of what the caller specifies.
  $options['https'] = TRUE;
  // We prefix with $base_url so we get a full path even if clean URLs are
  // disabled.
  return url($base_url . '/authorize.php', $options);
}

/**
 * Returns the URL for the authorize.php script when it is processing a batch.
 */
function system_authorized_batch_processing_url() {
  return system_authorized_get_url(array('query' => array('batch' => '1')));
}

/**
 * Setup and invoke an operation using authorize.php.
 *
 * @see system_authorized_init()
 */
function system_authorized_run($callback, $file, $arguments = [], $page_title = NULL) {
  system_authorized_init($callback, $file, $arguments, $page_title);
  drupal_goto(system_authorized_get_url());
}

/**
 * Use authorize.php to run batch_process().
 *
 * @see batch_process()
 */
function system_authorized_batch_process() {
  $finish_url = system_authorized_get_url();
  $process_url = system_authorized_batch_processing_url();
  batch_process($finish_url, $process_url);
}

/**
 * @} End of "defgroup authorize".
 */

/**
 * Implements hook_updater_info().
 */
function system_updater_info() {
  return array(
    'module' => array(
      'class' => 'ModuleUpdater',
      'name' => t('Update modules'),
      'weight' => 0,
    ),
    'theme' => array(
      'class' => 'ThemeUpdater',
      'name' => t('Update themes'),
      'weight' => 0,
    ),
  );
}

/**
 * Implements hook_filetransfer_info().
 */
function system_filetransfer_info() {
  $backends = [];

  // This is the default, will be available on most systems.
  if (function_exists('ftp_connect')) {
    $backends['ftp'] = array(
      'title' => t('FTP'),
      'class' => 'FileTransferFTP',
      'file' => 'ftp.inc',
      'file path' => 'includes/filetransfer',
      'weight' => 0,
    );
  }

  // SSH2 lib connection is only available if the proper PHP extension is
  // installed.
  if (function_exists('ssh2_connect')) {
    $backends['ssh'] = array(
      'title' => t('SSH'),
      'class' => 'FileTransferSSH',
      'file' => 'ssh.inc',
      'file path' => 'includes/filetransfer',
      'weight' => 20,
    );
  }
  return $backends;
}

/**
 * Implements hook_init().
 */
function system_init() {
  $path = drupal_get_path('module', 'system');
  // Add the CSS for this module. These aren't in system.info, because they
  // need to be in the CSS_SYSTEM group rather than the CSS_DEFAULT group.
  drupal_add_css($path . '/system.base.css', array('group' => CSS_SYSTEM, 'every_page' => TRUE));
  if (path_is_admin(current_path())) {
    drupal_add_css($path . '/system.admin.css', array('group' => CSS_SYSTEM));
  }
  drupal_add_css($path . '/system.menus.css', array('group' => CSS_SYSTEM, 'every_page' => TRUE));
  drupal_add_css($path . '/system.messages.css', array('group' => CSS_SYSTEM, 'every_page' => TRUE));
  drupal_add_css($path . '/system.theme.css', array('group' => CSS_SYSTEM, 'every_page' => TRUE));

  // Ignore slave database servers for this request.
  //
  // In Drupal's distributed database structure, new data is written to the
  // master and then propagated to the slave servers.  This means there is a
  // lag between when data is written to the master and when it is available on
  // the slave. At these times, we will want to avoid using a slave server
  // temporarily. For example, if a user posts a new node then we want to
  // disable the slave server for that user temporarily to allow the slave
  // server to catch up. That way, that user will see their changes immediately
  // while for other users we still get the benefits of having a slave server,
  // just with slightly stale data.  Code that wants to disable the slave
  // server should use the db_ignore_slave() function to set
  // $_SESSION['ignore_slave_server'] to the timestamp after which the slave
  // can be re-enabled.
  if (isset($_SESSION['ignore_slave_server'])) {
    if ($_SESSION['ignore_slave_server'] >= REQUEST_TIME) {
      Database::ignoreTarget('default', 'slave');
    }
    else {
      unset($_SESSION['ignore_slave_server']);
    }
  }

  // Add CSS/JS files from module .info files.
  system_add_module_assets();
}

/**
 * Adds CSS and JavaScript files declared in module .info files.
 */
function system_add_module_assets() {
  foreach (system_get_info('module') as $module => $info) {
    if (!empty($info['stylesheets'])) {
      foreach ($info['stylesheets'] as $media => $stylesheets) {
        foreach ($stylesheets as $stylesheet) {
          drupal_add_css($stylesheet, array('every_page' => TRUE, 'media' => $media));
        }
      }
    }
    if (!empty($info['scripts'])) {
      foreach ($info['scripts'] as $script) {
        drupal_add_js($script, array('every_page' => TRUE));
      }
    }
  }
}

/**
 * Implements hook_custom_theme().
 */
function system_custom_theme() {
  if (user_access('view the administration theme') && path_is_admin(current_path())) {
    return $bootstrap->variable_get('admin_theme');
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function system_form_user_profile_form_alter(&$form, &$form_state) {
  if ($form['#user_category'] == 'account') {
    if (variable_get('configurable_timezones', 1)) {
      system_user_timezone($form, $form_state);
    }
    return $form;
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function system_form_user_register_form_alter(&$form, &$form_state) {
  if (variable_get('configurable_timezones', 1)) {
    if (variable_get('user_default_timezone', DRUPAL_USER_TIMEZONE_DEFAULT) == DRUPAL_USER_TIMEZONE_SELECT) {
      system_user_timezone($form, $form_state);
    }
    else {
      $form['account']['timezone'] = array(
        '#type' => 'hidden',
        '#value' => $bootstrap->variable_get('user_default_timezone', DRUPAL_USER_TIMEZONE_DEFAULT) ? '' : $bootstrap->variable_get('date_default_timezone', ''),
      );
    }
    return $form;
  }
}

/**
 * Implements hook_user_login().
 */
function system_user_login(&$edit, $account) {
  // If the user has a NULL time zone, notify them to set a time zone.
  if (!$account->timezone && $bootstrap->variable_get('configurable_timezones', 1) && $bootstrap->variable_get('empty_timezone_message', 0)) {
    drupal_set_message(t('Configure your <a href="@user-edit">account time zone setting</a>.', array('@user-edit' => url("user/$account->uid/edit", array('query' => drupal_get_destination(), 'fragment' => 'edit-timezone')))));
  }
}

/**
 * Add the time zone field to the user edit and register forms.
 */
function system_user_timezone(&$form, &$form_state) {
  global $user;

  $account = $form['#user'];

  $form['timezone'] = array(
    '#type' => 'fieldset',
    '#title' => t('Locale settings'),
    '#weight' => 6,
    '#collapsible' => TRUE,
  );
  $form['timezone']['timezone'] = array(
    '#type' => 'select',
    '#title' => t('Time zone'),
    '#default_value' => isset($account->timezone) ? $account->timezone : ($account->uid == $user->uid ? $bootstrap->variable_get('date_default_timezone', '') : ''),
    '#options' => system_time_zones($account->uid != $user->uid),
    '#description' => t('Select the desired local time and time zone. Dates and times throughout this site will be displayed using this time zone.'),
  );
  if (!isset($account->timezone) && $account->uid == $user->uid && empty($form_state['input']['timezone'])) {
    $form['timezone']['timezone']['#attributes'] = array('class' => array('timezone-detect'));
    drupal_add_js('misc/timezone.js');
  }
}

/**
 * Implements hook_block_info().
 */
function system_block_info() {
  $blocks['main'] = array(
    'info' => t('Main page content'),
     // Cached elsewhere.
    'cache' => DRUPAL_NO_CACHE,
    // Auto-enable in 'content' region by default, which always exists.
    // @see system_themes_page(), drupal_render_page()
    'status' => 1,
    'region' => 'content',
  );
  $blocks['powered-by'] = array(
    'info' => t('Powered by Drupal'),
    'weight' => '10',
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['help'] = array(
    'info' => t('System help'),
    'weight' => '5',
    'cache' => DRUPAL_NO_CACHE,
    // Auto-enable in 'help' region by default, if the theme defines one.
    'status' => 1,
    'region' => 'help',
  );
  // System-defined menu blocks.
  foreach (menu_list_system_menus() as $menu_name => $title) {
    $blocks[$menu_name]['info'] = t($title);
    // Menu blocks can't be cached because each menu item can have
    // a custom access callback. menu.inc manages its own caching.
    $blocks[$menu_name]['cache'] = DRUPAL_NO_CACHE;
  }
  return $blocks;
}

/**
 * Implements hook_block_view().
 *
 * Generate a block with a promotional link to Drupal.org and
 * all system menu blocks.
 */
function system_block_view($delta = '') {
  $block = [];
  switch ($delta) {
    case 'main':
      $block['subject'] = NULL;
      $block['content'] = drupal_set_page_content();
      return $block;
    case 'powered-by':
      $block['subject'] = NULL;
      $block['content'] = theme('system_powered_by');
      return $block;
    case 'help':
      $block['subject'] = NULL;
      $block['content'] = menu_get_active_help();
      return $block;
    default:
      // All system menu blocks.
      $system_menus = menu_list_system_menus();
      if (isset($system_menus[$delta])) {
        $block['subject'] = t($system_menus[$delta]);
        $block['content'] = menu_tree($delta);
        return $block;
      }
      break;
  }
}

/**
 * Implements hook_preprocess_block().
 */
function system_preprocess_block(&$variables) {
  // System menu blocks should get the same class as menu module blocks.
  if ($variables['block']->module == 'system' && in_array($variables['block']->delta, array_keys(menu_list_system_menus()))) {
    $variables['classes_array'][] = 'block-menu';
  }
}

/**
 * Provide a single block on the administration overview page.
 *
 * @param $item
 *   The menu item to be displayed.
 */
function system_admin_menu_block($item) {
  $cache = &drupal_static(__FUNCTION__, []);
  // If we are calling this function for a menu item that corresponds to a
  // local task (for example, admin/tasks), then we want to retrieve the
  // parent item's child links, not this item's (since this item won't have
  // any).
  if ($item['tab_root'] != $item['path']) {
    $item = menu_get_item($item['tab_root_href']);
  }

  if (!isset($item['mlid'])) {
    $item += db_query("SELECT mlid, menu_name FROM {menu_links} ml WHERE ml.router_path = :path AND module = 'system'", array(':path' => $item['path']))->fetchAssoc();
  }

  if (isset($cache[$item['mlid']])) {
    return $cache[$item['mlid']];
  }

  $content = [];
  $query = db_select('menu_links', 'ml', array('fetch' => PDO::FETCH_ASSOC));
  $query->join('menu_router', 'm', 'm.path = ml.router_path');
  $query
    ->fields('ml')
    // Weight should be taken from {menu_links}, not {menu_router}.
    ->fields('m', array_diff(drupal_schema_fields_sql('menu_router'), array('weight')))
    ->condition('ml.plid', $item['mlid'])
    ->condition('ml.menu_name', $item['menu_name'])
    ->condition('ml.hidden', 0);

  foreach ($query->execute() as $link) {
    _menu_link_translate($link);
    if ($link['access']) {
      // The link description, either derived from 'description' in
      // hook_menu() or customized via menu module is used as title attribute.
      if (!empty($link['localized_options']['attributes']['title'])) {
        $link['description'] = $link['localized_options']['attributes']['title'];
        unset($link['localized_options']['attributes']['title']);
      }
      // Prepare for sorting as in function _menu_tree_check_access().
      // The weight is offset so it is always positive, with a uniform 5-digits.
      $key = (50000 + $link['weight']) . ' ' . drupal_strtolower($link['title']) . ' ' . $link['mlid'];
      $content[$key] = $link;
    }
  }
  ksort($content);
  $cache[$item['mlid']] = $content;
  return $content;
}

/**
 * Checks the existence of the directory specified in $form_element.
 *
 * This function is called from the system_settings form to check all core
 * file directories (file_public_path, file_private_path, file_temporary_path).
 *
 * @param $form_element
 *   The form element containing the name of the directory to check.
 */
function system_check_directory($form_element) {
  $directory = $form_element['#value'];
  if (strlen($directory) == 0) {
    return $form_element;
  }

  if (!is_dir($directory) && !drupal_mkdir($directory, NULL, TRUE)) {
    // If the directory does not exists and cannot be created.
    form_set_error($form_element['#parents'][0], t('The directory %directory does not exist and could not be created.', array('%directory' => $directory)));
    watchdog('file system', 'The directory %directory does not exist and could not be created.', array('%directory' => $directory), WATCHDOG_ERROR);
  }

  if (is_dir($directory) && !is_writable($directory) && !drupal_chmod($directory)) {
    // If the directory is not writable and cannot be made so.
    form_set_error($form_element['#parents'][0], t('The directory %directory exists but is not writable and could not be made writable.', array('%directory' => $directory)));
    watchdog('file system', 'The directory %directory exists but is not writable and could not be made writable.', array('%directory' => $directory), WATCHDOG_ERROR);
  }
  elseif (is_dir($directory)) {
    if ($form_element['#name'] == 'file_public_path') {
      // Create public .htaccess file.
      file_create_htaccess($directory, FALSE);
    }
    else {
      // Create private .htaccess file.
      file_create_htaccess($directory);
    }
  }

  return $form_element;
}

/**
 * Retrieves the current status of an array of files in the system table.
 *
 * @param $files
 *   An array of files to check.
 * @param $type
 *   The type of the files.
 */
function system_get_files_database(&$files, $type) {
  // Extract current files from database.
  $result = db_query("SELECT filename, name, type, status, schema_version, weight FROM {system} WHERE type = :type", array(':type' => $type));
  foreach ($result as $file) {
    if (isset($files[$file->name]) && is_object($files[$file->name])) {
      $file->uri = $file->filename;
      foreach ($file as $key => $value) {
        if (!isset($files[$file->name]->$key)) {
          $files[$file->name]->$key = $value;
        }
      }
    }
  }
}

/**
 * Updates the records in the system table based on the files array.
 *
 * @param $files
 *   An array of files.
 * @param $type
 *   The type of the files.
 */
function system_update_files_database(&$files, $type) {
  $result = db_query("SELECT * FROM {system} WHERE type = :type", array(':type' => $type));

  // Add all files that need to be deleted to a DatabaseCondition.
  $delete = db_or();
  foreach ($result as $file) {
    if (isset($files[$file->name]) && is_object($files[$file->name])) {
      // Keep the old filename from the database in case the file has moved.
      $old_filename = $file->filename;

      $updated_fields = [];

      // Handle info specially, compare the serialized value.
      $serialized_info = serialize($files[$file->name]->info);
      if ($serialized_info != $file->info) {
        $updated_fields['info'] = $serialized_info;
      }
      unset($file->info);

      // Scan remaining fields to find only the updated values.
      foreach ($file as $key => $value) {
        if (isset($files[$file->name]->$key) && $files[$file->name]->$key != $value) {
          $updated_fields[$key] = $files[$file->name]->$key;
        }
      }

      // Update the record.
      if (count($updated_fields)) {
        db_update('system')
          ->fields($updated_fields)
          ->condition('filename', $old_filename)
          ->execute();
      }

      // Indicate that the file exists already.
      $files[$file->name]->exists = TRUE;
    }
    else {
      // File is not found in file system, so delete record from the system table.
      $delete->condition('filename', $file->filename);
    }
  }

  if (count($delete) > 0) {
    // Delete all missing files from the system table, but only if the plugin
    // has never been installed.
    db_delete('system')
      ->condition($delete)
      ->condition('schema_version', -1)
      ->execute();
  }

  // All remaining files are not in the system table, so we need to add them.
  $query = db_insert('system')->fields(array('filename', 'name', 'type', 'owner', 'info'));
  foreach ($files as &$file) {
    if (isset($file->exists)) {
      unset($file->exists);
    }
    else {
      $query->values(array(
        'filename' => $file->uri,
        'name' => $file->name,
        'type' => $type,
        'owner' => isset($file->owner) ? $file->owner : '',
        'info' => serialize($file->info),
      ));
      $file->type = $type;
      $file->status = 0;
      $file->schema_version = -1;
    }
  }
  $query->execute();

  // If any module or theme was moved to a new location, we need to reset the
  // system_list() cache or we will continue to load the old copy, look for
  // schema updates in the wrong place, etc.
  system_list_reset();
}

/**
 * Returns an array of information about enabled modules or themes.
 *
 * This function returns the information from the {system} table corresponding
 * to the cached contents of the .info file for each active module or theme.
 *
 * @param $type
 *   Either 'module' or 'theme'.
 * @param $name
 *   (optional) The name of a module or theme whose information shall be
 *   returned. If omitted, all records for the provided $type will be returned.
 *   If $name does not exist in the provided $type or is not enabled, an empty
 *   array will be returned.
 *
 * @return
 *   An associative array of module or theme information keyed by name, or only
 *   information for $name, if given. If no records are available, an empty
 *   array is returned.
 *
 * @see system_rebuild_module_data()
 * @see system_rebuild_theme_data()
 */
function system_get_info($type, $name = NULL) {
  $info = [];
  if ($type == 'module') {
    $type = 'module_enabled';
  }
  $list = system_list($type);
  foreach ($list as $shortname => $item) {
    if (!empty($item->status)) {
      $info[$shortname] = $item->info;
    }
  }
  if (isset($name)) {
    return isset($info[$name]) ? $info[$name] : [];
  }
  return $info;
}

/**
 * Helper function to scan and collect module .info data.
 *
 * @return
 *   An associative array of module information.
 */
function _system_rebuild_module_data() {
  // Find modules
  $modules = drupal_system_listing('/^' . DRUPAL_PHP_FUNCTION_PATTERN . '\.module$/', 'modules', 'name', 0);

  // Include the installation profile in modules that are loaded.
  $profile = drupal_get_profile();
  $modules[$profile] = new stdClass();
  $modules[$profile]->name = $profile;
  $modules[$profile]->uri = 'profiles/' . $profile . '/' . $profile . '.profile';
  $modules[$profile]->filename = $profile . '.profile';

  // Installation profile hooks are always executed last.
  $modules[$profile]->weight = 1000;

  // Set defaults for module info.
  $defaults = array(
    'dependencies' => [],
    'description' => '',
    'package' => 'Other',
    'version' => NULL,
    'php' => DRUPAL_MINIMUM_PHP,
    'files' => [],
    'bootstrap' => 0,
  );

  // Read info files for each module.
  foreach ($modules as $key => $module) {
    // The module system uses the key 'filename' instead of 'uri' so copy the
    // value so it will be used by the modules system.
    $modules[$key]->filename = $module->uri;

    // Look for the info file.
    $module->info = drupal_parse_info_file(dirname($module->uri) . '/' . $module->name . '.info');

    // Skip modules that don't provide info.
    if (empty($module->info)) {
      unset($modules[$key]);
      continue;
    }

    // Add the info file modification time, so it becomes available for
    // contributed modules to use for ordering module lists.
    $module->info['mtime'] = filemtime(dirname($module->uri) . '/' . $module->name . '.info');

    // Merge in defaults and save.
    $modules[$key]->info = $module->info + $defaults;

    // The "name" key is required, but to avoid a fatal error in the menu system
    // we set a reasonable default if it is not provided.
    $modules[$key]->info += array('name' => $key);

    // Prefix stylesheets and scripts with module path.
    $path = dirname($module->uri);
    if (isset($module->info['stylesheets'])) {
      $module->info['stylesheets'] = _system_info_add_path($module->info['stylesheets'], $path);
    }
    if (isset($module->info['scripts'])) {
      $module->info['scripts'] = _system_info_add_path($module->info['scripts'], $path);
    }

    // Installation profiles are hidden by default, unless explicitly specified
    // otherwise in the .info file.
    if ($key == $profile && !isset($modules[$key]->info['hidden'])) {
      $modules[$key]->info['hidden'] = TRUE;
    }

    // Invoke hook_system_info_alter() to give installed modules a chance to
    // modify the data in the .info files if necessary.
    $type = 'module';
    drupal_alter('system_info', $modules[$key]->info, $modules[$key], $type);
  }

  if (isset($modules[$profile])) {
    // The installation profile is required, if it's a valid module.
    $modules[$profile]->info['required'] = TRUE;
    // Add a default distribution name if the profile did not provide one. This
    // matches the default value used in install_profile_info().
    if (!isset($modules[$profile]->info['distribution_name'])) {
      $modules[$profile]->info['distribution_name'] = 'Drupal';
    }
  }

  return $modules;
}

/**
 * Rebuild, save, and return data about all currently available modules.
 *
 * @return
 *   Array of all available modules and their data.
 */
function system_rebuild_module_data() {
  $modules_cache = &drupal_static(__FUNCTION__);
  // Only rebuild once per request. $modules and $modules_cache cannot be
  // combined into one variable, because the $modules_cache variable is reset by
  // reference from system_list_reset() during the rebuild.
  if (!isset($modules_cache)) {
    $modules = _system_rebuild_module_data();
    ksort($modules);
    system_get_files_database($modules, 'module');
    system_update_files_database($modules, 'module');
    $modules = _module_build_dependencies($modules);
    $modules_cache = $modules;
  }
  return $modules_cache;
}

/**
 * Refresh bootstrap column in the system table.
 *
 * This is called internally by module_enable/disable() to flag modules that
 * implement hooks used during bootstrap, such as hook_boot(). These modules
 * are loaded earlier to invoke the hooks.
 */
function _system_update_bootstrap_status() {
  $bootstrap_modules = [];
  foreach (bootstrap_hooks() as $hook) {
    foreach (module_implements($hook) as $module) {
      $bootstrap_modules[] = $module;
    }
  }
  $query = db_update('system')->fields(array('bootstrap' => 0));
  if ($bootstrap_modules) {
    db_update('system')
      ->fields(array('bootstrap' => 1))
      ->condition('name', $bootstrap_modules, 'IN')
      ->execute();
    $query->condition('name', $bootstrap_modules, 'NOT IN');
  }
  $query->execute();
  // Reset the cached list of bootstrap modules.
  system_list_reset();
}

/**
 * Helper function to scan and collect theme .info data and their engines.
 *
 * @return
 *   An associative array of themes information.
 */
function _system_rebuild_theme_data() {
  // Find themes
  $common = new \Core\Includes\Common;
  $bootstrap = new \Core\Includes\Bootstrap;
  $module = new \Core\Includes\Module;
  $themes = $common->drupal_system_listing('/^' . $bootstrap->drupal_php_function_pattern . '\.info$/', 'themes');
  // Allow modules to add further themes.
  if ($module_themes = $module->module_invoke_all('system_theme_info')) {
    foreach ($module_themes as $name => $uri) {
      // @see file_scan_directory()
      $themes[$name] = (object) array(
        'uri' => $uri,
        'filename' => pathinfo($uri, PATHINFO_FILENAME),
        'name' => $name,
      );
    }
  }

  // Find theme engines
  $engines = drupal_system_listing('/^' . DRUPAL_PHP_FUNCTION_PATTERN . '\.engine$/', 'themes/engines');
  // Allow modules to add further theme engines.
  if ($module_engines = module_invoke_all('system_theme_engine_info')) {
    foreach ($module_engines as $name => $theme_engine_path) {
      $engines[$name] = (object) array(
        'uri' => $theme_engine_path,
        'filename' => basename($theme_engine_path),
        'name' => $name,
      );
    }
  }

  // Set defaults for theme info.
  $defaults = array(
    'engine' => 'phptemplate',
    'regions' => array(
      'sidebar_first' => 'Left sidebar',
      'sidebar_second' => 'Right sidebar',
      'content' => 'Content',
      'header' => 'Header',
      'footer' => 'Footer',
      'highlighted' => 'Highlighted',
      'help' => 'Help',
      'page_top' => 'Page top',
      'page_bottom' => 'Page bottom',
    ),
    'description' => '',
    'features' => _system_default_theme_features(),
    'screenshot' => 'screenshot.png',
    'php' => DRUPAL_MINIMUM_PHP,
    'stylesheets' => [],
    'scripts' => [],
  );

  $sub_themes = [];
  // Read info files for each theme
  foreach ($themes as $key => $theme) {
    $themes[$key]->filename = $theme->uri;
    $themes[$key]->info = drupal_parse_info_file($theme->uri) + $defaults;

    // The "name" key is required, but to avoid a fatal error in the menu system
    // we set a reasonable default if it is not provided.
    $themes[$key]->info += array('name' => $key);

    // Add the info file modification time, so it becomes available for
    // contributed modules to use for ordering theme lists.
    $themes[$key]->info['mtime'] = filemtime($theme->uri);

    // Invoke hook_system_info_alter() to give installed modules a chance to
    // modify the data in the .info files if necessary.
    $type = 'theme';
    drupal_alter('system_info', $themes[$key]->info, $themes[$key], $type);

    if (!empty($themes[$key]->info['base theme'])) {
      $sub_themes[] = $key;
    }
    if ($themes[$key]->info['engine'] == 'theme') {
      $filename = dirname($themes[$key]->uri) . '/' . $themes[$key]->name . '.theme';
      if (file_exists($filename)) {
        $themes[$key]->owner = $filename;
        $themes[$key]->prefix = $key;
      }
    }
    else {
      $engine = $themes[$key]->info['engine'];
      if (isset($engines[$engine])) {
        $themes[$key]->owner = $engines[$engine]->uri;
        $themes[$key]->prefix = $engines[$engine]->name;
        $themes[$key]->template = TRUE;
      }
    }

    // Prefix stylesheets and scripts with module path.
    $path = dirname($theme->uri);
    $theme->info['stylesheets'] = _system_info_add_path($theme->info['stylesheets'], $path);
    $theme->info['scripts'] = _system_info_add_path($theme->info['scripts'], $path);

    // Give the screenshot proper path information.
    if (!empty($themes[$key]->info['screenshot'])) {
      $themes[$key]->info['screenshot'] = $path . '/' . $themes[$key]->info['screenshot'];
    }
  }

  // Now that we've established all our master themes, go back and fill in data
  // for subthemes.
  foreach ($sub_themes as $key) {
    $themes[$key]->base_themes = drupal_find_base_themes($themes, $key);
    // Don't proceed if there was a problem with the root base theme.
    if (!current($themes[$key]->base_themes)) {
      continue;
    }
    $base_key = key($themes[$key]->base_themes);
    foreach (array_keys($themes[$key]->base_themes) as $base_theme) {
      $themes[$base_theme]->sub_themes[$key] = $themes[$key]->info['name'];
    }
    // Copy the 'owner' and 'engine' over if the top level theme uses a theme
    // engine.
    if (isset($themes[$base_key]->owner)) {
      if (isset($themes[$base_key]->info['engine'])) {
        $themes[$key]->info['engine'] = $themes[$base_key]->info['engine'];
        $themes[$key]->owner = $themes[$base_key]->owner;
        $themes[$key]->prefix = $themes[$base_key]->prefix;
      }
      else {
        $themes[$key]->prefix = $key;
      }
    }
  }

  return $themes;
}

/**
 * Rebuild, save, and return data about all currently available themes.
 *
 * @return
 *   Array of all available themes and their data.
 */
function system_rebuild_theme_data() {
  $themes = _system_rebuild_theme_data();
  ksort($themes);
  system_get_files_database($themes, 'theme');
  system_update_files_database($themes, 'theme');
  return $themes;
}

/**
 * Prefixes all values in an .info file array with a given path.
 *
 * This helper function is mainly used to prefix all array values of an .info
 * file property with a single given path (to the module or theme); e.g., to
 * prefix all values of the 'stylesheets' or 'scripts' properties with the file
 * path to the defining module/theme.
 *
 * @param $info
 *   A nested array of data of an .info file to be processed.
 * @param $path
 *   A file path to prepend to each value in $info.
 *
 * @return
 *   The $info array with prefixed values.
 *
 * @see _system_rebuild_module_data()
 * @see _system_rebuild_theme_data()
 */
function _system_info_add_path($info, $path) {
  foreach ($info as $key => $value) {
    // Recurse into nested values until we reach the deepest level.
    if (is_array($value)) {
      $info[$key] = _system_info_add_path($info[$key], $path);
    }
    // Unset the original value's key and set the new value with prefix, using
    // the original value as key, so original values can still be looked up.
    else {
      unset($info[$key]);
      $info[$value] = $path . '/' . $value;
    }
  }
  return $info;
}

/**
 * Returns an array of default theme features.
 */
function _system_default_theme_features() {
  return array(
    'logo',
    'favicon',
    'name',
    'slogan',
    'node_user_picture',
    'comment_user_picture',
    'comment_user_verification',
    'main_menu',
    'secondary_menu',
  );
}

/**
 * Find all the base themes for the specified theme.
 *
 * This function has been deprecated in favor of drupal_find_base_themes().
 */
function system_find_base_themes($themes, $key, $used_keys = []) {
  return drupal_find_base_themes($themes, $key, $used_keys);
}

/**
 * Get a list of available regions from a specified theme.
 *
 * @param $theme_key
 *   The name of a theme.
 * @param $show
 *   Possible values: REGIONS_ALL or REGIONS_VISIBLE. Visible excludes hidden
 *   regions.
 * @param bool $labels
 *   (optional) Boolean to specify whether the human readable machine names
 *   should be returned or not. Defaults to TRUE, but calling code can set
 *   this to FALSE for better performance, if it only needs machine names.
 *
 * @return array
 *   An associative array of regions in the form $region['name'] = 'description'
 *   if $labels is set to TRUE, or $region['name'] = 'name', if $labels is set
 *   to FALSE.
 */
function system_region_list($theme_key, $show = REGIONS_ALL, $labels = TRUE) {
  $themes = list_themes();
  if (!isset($themes[$theme_key])) {
    return [];
  }

  $list = [];
  $info = $themes[$theme_key]->info;
  // If requested, suppress hidden regions. See block_admin_display_form().
  foreach ($info['regions'] as $name => $label) {
    if ($show == REGIONS_ALL || !isset($info['regions_hidden']) || !in_array($name, $info['regions_hidden'])) {
      if ($labels) {
        $list[$name] = t($label);
      }
      else {
        $list[$name] = $name;
      }
    }
  }
  return $list;
}

/**
 * Implements hook_system_info_alter().
 */
function system_system_info_alter(&$info, $file, $type) {
  // Remove page-top and page-bottom from the blocks UI since they are reserved for
  // modules to populate from outside the blocks system.
  if ($type == 'theme') {
    $info['regions_hidden'][] = 'page_top';
    $info['regions_hidden'][] = 'page_bottom';
  }
}

/**
 * Get the name of the default region for a given theme.
 *
 * @param $theme
 *   The name of a theme.
 *
 * @return
 *   A string that is the region name.
 */
function system_default_region($theme) {
  $regions = system_region_list($theme, REGIONS_VISIBLE, FALSE);
  return $regions ? reset($regions) : '';
}

/**
 * Sets up a form to save information automatically.
 *
 * This function adds a submit handler and a submit button to a form array. The
 * submit function saves all the data in the form, using variable_set(), to
 * variables named the same as the keys in the form array. Note that this means
 * you should normally prefix your form array keys with your module name, so
 * that they are unique when passed into variable_set().
 *
 * If you need to manipulate the data in a custom manner, you can either put
 * your own submission handler in the form array before calling this function,
 * or just use your own submission handler instead of calling this function.
 *
 * @param $form
 *   An associative array containing the structure of the form.
 *
 * @return
 *   The form structure.
 *
 * @see system_settings_form_submit()
 *
 * @ingroup forms
 */
function system_settings_form($form) {
  $form['actions']['#type'] = 'actions';
  $form['actions']['submit'] = array('#type' => 'submit', '#value' => t('Save configuration'));

  if (!empty($_POST) && form_get_errors()) {
    drupal_set_message(t('The settings have not been saved because of the errors.'), 'error');
  }
  $form['#submit'][] = 'system_settings_form_submit';
  // By default, render the form using theme_system_settings_form().
  if (!isset($form['#theme'])) {
    $form['#theme'] = 'system_settings_form';
  }
  return $form;
}

/**
 * Form submission handler for system_settings_form().
 *
 * If you want node type configure style handling of your checkboxes,
 * add an array_filter value to your form.
 */
function system_settings_form_submit($form, &$form_state) {
  // Exclude unnecessary elements.
  form_state_values_clean($form_state);

  foreach ($form_state['values'] as $key => $value) {
    if (is_array($value) && isset($form_state['values']['array_filter'])) {
      $value = array_keys(array_filter($value));
    }
    variable_set($key, $value);
  }

  drupal_set_message(t('The configuration options have been saved.'));
}

/**
 * Helper function to sort requirements.
 */
function _system_sort_requirements($a, $b) {
  if (!isset($a['weight'])) {
    if (!isset($b['weight'])) {
      return strcasecmp($a['title'], $b['title']);
    }
    return -$b['weight'];
  }
  return isset($b['weight']) ? $a['weight'] - $b['weight'] : $a['weight'];
}

/**
 * Generates a form array for a confirmation form.
 *
 * This function returns a complete form array for confirming an action. The
 * form contains a confirm button as well as a cancellation link that allows a
 * user to abort the action.
 *
 * If the submit handler for a form that implements confirm_form() is invoked,
 * the user successfully confirmed the action. You should never directly
 * inspect $_POST to see if an action was confirmed.
 *
 * Note - if the parameters $question, $description, $yes, or $no could contain
 * any user input (such as node titles or taxonomy terms), it is the
 * responsibility of the code calling confirm_form() to sanitize them first with
 * a function like check_plain() or filter_xss().
 *
 * @param $form
 *   Additional elements to add to the form. These can be regular form elements,
 *   #value elements, etc., and their values will be available to the submit
 *   handler.
 * @param $question
 *   The question to ask the user (e.g. "Are you sure you want to delete the
 *   block <em>foo</em>?"). The page title will be set to this value.
 * @param $path
 *   The page to go to if the user cancels the action. This can be either:
 *   - A string containing a Drupal path.
 *   - An associative array with a 'path' key. Additional array values are
 *     passed as the $options parameter to l().
 *   If the 'destination' query parameter is set in the URL when viewing a
 *   confirmation form, that value will be used instead of $path.
 * @param $description
 *   Additional text to display. Defaults to t('This action cannot be undone.').
 * @param $yes
 *   A caption for the button that confirms the action (e.g. "Delete",
 *   "Replace", ...). Defaults to t('Confirm').
 * @param $no
 *   A caption for the link which cancels the action (e.g. "Cancel"). Defaults
 *   to t('Cancel').
 * @param $name
 *   The internal name used to refer to the confirmation item.
 *
 * @return
 *   The form array.
 */
function confirm_form($form, $question, $path, $description = NULL, $yes = NULL, $no = NULL, $name = 'confirm') {
  $description = isset($description) ? $description : t('This action cannot be undone.');

  // Prepare cancel link.
  if (isset($_GET['destination'])) {
    $options = drupal_parse_url($_GET['destination']);
  }
  elseif (is_array($path)) {
    $options = $path;
  }
  else {
    $options = array('path' => $path);
  }

  drupal_set_title($question, PASS_THROUGH);

  $form['#attributes']['class'][] = 'confirmation';
  $form['description'] = array('#markup' => $description);
  $form[$name] = array('#type' => 'hidden', '#value' => 1);

  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => $yes ? $yes : t('Confirm'),
  );
  $form['actions']['cancel'] = array(
    '#type' => 'link',
    '#title' => $no ? $no : t('Cancel'),
    '#href' => $options['path'],
    '#options' => $options,
  );
  // By default, render the form using theme_confirm_form().
  if (!isset($form['#theme'])) {
    $form['#theme'] = 'confirm_form';
  }
  return $form;
}

/**
 * Determines whether the current user is in compact mode.
 *
 * Compact mode shows certain administration pages with less description text,
 * such as the configuration page and the permissions page.
 *
 * Whether the user is in compact mode is determined by a cookie, which is set
 * for the user by system_admin_compact_page().
 *
 * If the user does not have the cookie, the default value is given by the
 * system variable 'admin_compact_mode', which itself defaults to FALSE. This
 * does not have a user interface to set it: it is a hidden variable which can
 * be set in the settings.php file.
 *
 * @return
 *   TRUE when in compact mode, FALSE when in expanded mode.
 */
function system_admin_compact_mode() {
  // PHP converts dots into underscores in cookie names to avoid problems with
  // its parser, so we use a converted cookie name.
  return isset($_COOKIE['Drupal_visitor_admin_compact_mode']) ? $_COOKIE['Drupal_visitor_admin_compact_mode'] : $bootstrap->variable_get('admin_compact_mode', FALSE);
}

/**
 * Menu callback; Sets whether the admin menu is in compact mode or not.
 *
 * @param $mode
 *   Valid values are 'on' and 'off'.
 */
function system_admin_compact_page($mode = 'off') {
  user_cookie_save(array('admin_compact_mode' => ($mode == 'on')));
  drupal_goto();
}

/**
 * Generate a list of tasks offered by a specified module.
 *
 * @param $module
 *   Module name.
 * @param $info
 *   The module's information, as provided by system_get_info().
 *
 * @return
 *   An array of task links.
 */
function system_get_module_admin_tasks($module, $info) {
  $links = &drupal_static(__FUNCTION__);

  if (!isset($links)) {
    $links = [];
    $query = db_select('menu_links', 'ml', array('fetch' => PDO::FETCH_ASSOC));
    $query->join('menu_router', 'm', 'm.path = ml.router_path');
    $query
      ->fields('ml')
      // Weight should be taken from {menu_links}, not {menu_router}.
      ->fields('m', array_diff(drupal_schema_fields_sql('menu_router'), array('weight')))
      ->condition('ml.link_path', 'admin/%', 'LIKE')
      ->condition('ml.hidden', 0, '>=')
      ->condition('ml.module', 'system')
      ->condition('m.number_parts', 1, '>')
      ->condition('m.page_callback', 'system_admin_menu_block_page', '<>');
    foreach ($query->execute() as $link) {
      _menu_link_translate($link);
      if ($link['access']) {
        $links[$link['router_path']] = $link;
      }
    }
  }

  $admin_tasks = [];
  $titles = [];
  if ($menu = module_invoke($module, 'menu')) {
    foreach ($menu as $path => $item) {
      if (isset($links[$path])) {
        $task = $links[$path];
        // The link description, either derived from 'description' in
        // hook_menu() or customized via menu module is used as title attribute.
        if (!empty($task['localized_options']['attributes']['title'])) {
          $task['description'] = $task['localized_options']['attributes']['title'];
          unset($task['localized_options']['attributes']['title']);
        }

        // Check the admin tasks for duplicate names. If one is found,
        // append the parent menu item's title to differentiate.
        $duplicate_path = array_search($task['title'], $titles);
        if ($duplicate_path !== FALSE) {
          if ($parent = menu_link_load($task['plid'])) {
            // Append the parent item's title to this task's title.
            $task['title'] = t('@original_title (@parent_title)', array('@original_title' => $task['title'], '@parent_title' => $parent['title']));
          }
          if ($parent = menu_link_load($admin_tasks[$duplicate_path]['plid'])) {
            // Append the parent item's title to the duplicated task's title.
            // We use $links[$duplicate_path] in case there are triplicates.
            $admin_tasks[$duplicate_path]['title'] = t('@original_title (@parent_title)', array('@original_title' => $links[$duplicate_path]['title'], '@parent_title' => $parent['title']));
          }
        }
        else {
          $titles[$path] = $task['title'];
        }

        $admin_tasks[$path] = $task;
      }
    }
  }

  // Append link for permissions.
  if (module_hook($module, 'permission')) {
    $item = menu_get_item('admin/people/permissions');
    if (!empty($item['access'])) {
      $item['link_path'] = $item['href'];
      $item['title'] = t('Configure @module permissions', array('@module' => $info['name']));
      unset($item['description']);
      $item['localized_options']['fragment'] = 'module-' . $module;
      $admin_tasks["admin/people/permissions#module-$module"] = $item;
    }
  }

  return $admin_tasks;
}

/**
 * Implements hook_cron().
 *
 * Remove older rows from flood and batch table. Remove old temporary files.
 */
function system_cron() {
  // Cleanup the flood.
  db_delete('flood')
    ->condition('expiration', REQUEST_TIME, '<')
    ->execute();

  // Remove temporary files that are older than DRUPAL_MAXIMUM_TEMP_FILE_AGE.
  // Use separate placeholders for the status to avoid a bug in some versions
  // of PHP. See http://drupal.org/node/352956.
  $result = db_query('SELECT fid FROM {file_managed} WHERE status <> :permanent AND timestamp < :timestamp', array(
    ':permanent' => FILE_STATUS_PERMANENT,
    ':timestamp' => REQUEST_TIME - DRUPAL_MAXIMUM_TEMP_FILE_AGE
  ));
  foreach ($result as $row) {
    if ($file = file_load($row->fid)) {
      $references = file_usage_list($file);
      if (empty($references)) {
        if (!file_delete($file)) {
          watchdog('file system', 'Could not delete temporary file "%path" during garbage collection', array('%path' => $file->uri), WATCHDOG_ERROR);
        }
      }
      else {
        watchdog('file system', 'Did not delete temporary file "%path" during garbage collection, because it is in use by the following modules: %modules.', array('%path' => $file->uri, '%modules' => implode(', ', array_keys($references))), WATCHDOG_INFO);
      }
    }
  }

  // Delete expired cache entries.
  // Avoid invoking hook_flush_cashes() on every cron run because some modules
  // use this hook to perform expensive rebuilding operations (which are only
  // designed to happen on full cache clears), rather than just returning a
  // list of cache tables to be cleared.
  $cache_object = cache_get('system_cache_tables');
  if (empty($cache_object)) {
    $core = array('cache', 'cache_path', 'cache_filter', 'cache_page', 'cache_form', 'cache_menu');
    $cache_tables = array_merge(module_invoke_all('flush_caches'), $core);
    cache_set('system_cache_tables', $cache_tables);
  }
  else {
    $cache_tables = $cache_object->data;
  }
  foreach ($cache_tables as $table) {
    cache_clear_all(NULL, $table);
  }

  // Cleanup the batch table and the queue for failed batches.
  db_delete('batch')
    ->condition('timestamp', REQUEST_TIME - 864000, '<')
    ->execute();
  db_delete('queue')
    ->condition('created', REQUEST_TIME - 864000, '<')
    ->condition('name', 'drupal_batch:%', 'LIKE')
    ->execute();

  // Reset expired items in the default queue implementation table. If that's
  // not used, this will simply be a no-op.
  db_update('queue')
    ->fields(array(
      'expire' => 0,
    ))
    ->condition('expire', 0, '<>')
    ->condition('expire', REQUEST_TIME, '<')
    ->execute();
}

/**
 * Implements hook_flush_caches().
 */
function system_flush_caches() {
  // Rebuild list of date formats.
  system_date_formats_rebuild();
  // Reset the menu static caches.
  menu_reset_static_cache();
}

/**
 * Implements hook_action_info().
 */
function system_action_info() {
  return array(
    'system_message_action' => array(
      'type' => 'system',
      'label' => t('Display a message to the user'),
      'configurable' => TRUE,
      'triggers' => array('any'),
    ),
    'system_send_email_action' => array(
      'type' => 'system',
      'label' => t('Send e-mail'),
      'configurable' => TRUE,
      'triggers' => array('any'),
    ),
    'system_block_ip_action' => array(
      'type' => 'user',
      'label' => t('Ban IP address of current user'),
      'configurable' => FALSE,
      'triggers' => array('any'),
    ),
    'system_goto_action' => array(
      'type' => 'system',
      'label' => t('Redirect to URL'),
      'configurable' => TRUE,
      'triggers' => array('any'),
    ),
  );
}

/**
 * Return a form definition so the Send email action can be configured.
 *
 * @param $context
 *   Default values (if we are editing an existing action instance).
 *
 * @return
 *   Form definition.
 *
 * @see system_send_email_action_validate()
 * @see system_send_email_action_submit()
 */
function system_send_email_action_form($context) {
  // Set default values for form.
  if (!isset($context['recipient'])) {
    $context['recipient'] = '';
  }
  if (!isset($context['subject'])) {
    $context['subject'] = '';
  }
  if (!isset($context['message'])) {
    $context['message'] = '';
  }

  $form['recipient'] = array(
    '#type' => 'textfield',
    '#title' => t('Recipient'),
    '#default_value' => $context['recipient'],
    '#maxlength' => '254',
    '#description' => t('The email address to which the message should be sent OR enter [node:author:mail], [comment:author:mail], etc. if you would like to send an e-mail to the author of the original post.'),
  );
  $form['subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
    '#default_value' => $context['subject'],
    '#maxlength' => '254',
    '#description' => t('The subject of the message.'),
  );
  $form['message'] = array(
    '#type' => 'textarea',
    '#title' => t('Message'),
    '#default_value' => $context['message'],
    '#cols' => '80',
    '#rows' => '20',
    '#description' => t('The message that should be sent. You may include placeholders like [node:title], [user:name], and [comment:body] to represent data that will be different each time message is sent. Not all placeholders will be available in all contexts.'),
  );
  return $form;
}

/**
 * Validate system_send_email_action form submissions.
 */
function system_send_email_action_validate($form, $form_state) {
  $form_values = $form_state['values'];
  // Validate the configuration form.
  if (!valid_email_address($form_values['recipient']) && strpos($form_values['recipient'], ':mail') === FALSE) {
    // We want the literal %author placeholder to be emphasized in the error message.
    form_set_error('recipient', t('Enter a valid email address or use a token e-mail address such as %author.', array('%author' => '[node:author:mail]')));
  }
}

/**
 * Process system_send_email_action form submissions.
 */
function system_send_email_action_submit($form, $form_state) {
  $form_values = $form_state['values'];
  // Process the HTML form to store configuration. The keyed array that
  // we return will be serialized to the database.
  $params = array(
    'recipient' => $form_values['recipient'],
    'subject'   => $form_values['subject'],
    'message'   => $form_values['message'],
  );
  return $params;
}

/**
 * Sends an e-mail message.
 *
 * @param object $entity
 *   An optional node object, which will be added as $context['node'] if
 *   provided.
 * @param array $context
 *   Array with the following elements:
 *   - 'recipient': E-mail message recipient. This will be passed through
 *     token_replace().
 *   - 'subject': The subject of the message. This will be passed through
 *     token_replace().
 *   - 'message': The message to send. This will be passed through
 *     token_replace().
 *   - Other elements will be used as the data for token replacement.
 *
 * @ingroup actions
 */
function system_send_email_action($entity, $context) {
  if (empty($context['node'])) {
    $context['node'] = $entity;
  }

  $recipient = token_replace($context['recipient'], $context);

  // If the recipient is a registered user with a language preference, use
  // the recipient's preferred language. Otherwise, use the system default
  // language.
  $recipient_account = user_load_by_mail($recipient);
  if ($recipient_account) {
    $language = user_preferred_language($recipient_account);
  }
  else {
    $language = language_default();
  }
  $params = array('context' => $context);

  if (drupal_mail('system', 'action_send_email', $recipient, $language, $params)) {
    watchdog('action', 'Sent email to %recipient', array('%recipient' => $recipient));
  }
  else {
    watchdog('error', 'Unable to send email to %recipient', array('%recipient' => $recipient));
  }
}

/**
 * Implements hook_mail().
 */
function system_mail($key, &$message, $params) {
  $context = $params['context'];

  $subject = token_replace($context['subject'], $context);
  $body = token_replace($context['message'], $context);

  $message['subject'] .= str_replace(array("\r", "\n"), '', $subject);
  $message['body'][] = $body;
}

function system_message_action_form($context) {
  $form['message'] = array(
    '#type' => 'textarea',
    '#title' => t('Message'),
    '#default_value' => isset($context['message']) ? $context['message'] : '',
    '#required' => TRUE,
    '#rows' => '8',
    '#description' => t('The message to be displayed to the current user. You may include placeholders like [node:title], [user:name], and [comment:body] to represent data that will be different each time message is sent. Not all placeholders will be available in all contexts.'),
  );
  return $form;
}

function system_message_action_submit($form, $form_state) {
  return array('message' => $form_state['values']['message']);
}

/**
 * Sends a message to the current user's screen.
 *
 * @param object $entity
 *   An optional node object, which will be added as $context['node'] if
 *   provided.
 * @param array $context
 *   Array with the following elements:
 *   - 'message': The message to send. This will be passed through
 *     token_replace().
 *   - Other elements will be used as the data for token replacement in
 *     the message.
 *
 * @ingroup actions
 */
function system_message_action(&$entity, $context = []) {
  if (empty($context['node'])) {
    $context['node'] = $entity;
  }

  $context['message'] = token_replace(filter_xss_admin($context['message']), $context);
  drupal_set_message($context['message']);
}

/**
 * Settings form for system_goto_action().
 */
function system_goto_action_form($context) {
  $form['url'] = array(
    '#type' => 'textfield',
    '#title' => t('URL'),
    '#description' => t('The URL to which the user should be redirected. This can be an internal path like node/1234 or an external URL like http://example.com.'),
    '#default_value' => isset($context['url']) ? $context['url'] : '',
    '#required' => TRUE,
  );
  return $form;
}

function system_goto_action_submit($form, $form_state) {
  return array(
    'url' => $form_state['values']['url']
  );
}

/**
 * Redirects to a different URL.
 *
 * @param $entity
 *   Ignored.
 * @param array $context
 *   Array with the following elements:
 *   - 'url': URL to redirect to. This will be passed through
 *     token_replace().
 *   - Other elements will be used as the data for token replacement.
 *
 * @ingroup actions
 */
function system_goto_action($entity, $context) {
  drupal_goto(token_replace($context['url'], $context));
}

/**
 * Blocks the current user's IP address.
 *
 * @ingroup actions
 */
function system_block_ip_action() {
  $ip = ip_address();
  db_merge('blocked_ips')
    ->key(array('ip' => $ip))
    ->fields(array('ip' => $ip))
    ->execute();
  watchdog('action', 'Banned IP address %ip', array('%ip' => $ip));
}

/**
 * Generate an array of time zones and their local time&date.
 *
 * @param $blank
 *   If evaluates true, prepend an empty time zone option to the array.
 */
function system_time_zones($blank = NULL) {
  $zonelist = timezone_identifiers_list();
  $zones = $blank ? array('' => t('- None selected -')) : [];
  foreach ($zonelist as $zone) {
    // Because many time zones exist in PHP only for backward compatibility
    // reasons and should not be used, the list is filtered by a regular
    // expression.
    if (preg_match('!^((Africa|America|Antarctica|Arctic|Asia|Atlantic|Australia|Europe|Indian|Pacific)/|UTC$)!', $zone)) {
      $zones[$zone] = t('@zone: @date', array('@zone' => t(str_replace('_', ' ', $zone)), '@date' => format_date(REQUEST_TIME, 'custom', $bootstrap->variable_get('date_format_long', 'l, F j, Y - H:i') . ' O', $zone)));
    }
  }
  // Sort the translated time zones alphabetically.
  asort($zones);
  return $zones;
}

/**
 * Checks whether the server is capable of issuing HTTP requests.
 *
 * The function sets the drupal_http_request_fail system variable to TRUE if
 * drupal_http_request() does not work and then the system status report page
 * will contain an error.
 *
 * @return
 *  TRUE if this installation can issue HTTP requests.
 */
function system_check_http_request() {
  // Try to get the content of the front page via drupal_http_request().
  $result = drupal_http_request(url('', array('absolute' => TRUE)), array('max_redirects' => 0));
  // We only care that we get a http response - this means that Drupal
  // can make a http request.
  $works = isset($result->code) && ($result->code >= 100) && ($result->code < 600);
  variable_set('drupal_http_request_fails', !$works);
  return $works;
}

/**
 * Menu callback; Retrieve a JSON object containing a suggested time zone name.
 */
function system_timezone($abbreviation = '', $offset = -1, $is_daylight_saving_time = NULL) {
  // An abbreviation of "0" passed in the callback arguments should be
  // interpreted as the empty string.
  $abbreviation = $abbreviation ? $abbreviation : '';
  $timezone = timezone_name_from_abbr($abbreviation, intval($offset), $is_daylight_saving_time);
  drupal_json_output($timezone);
}

/**
 * Returns HTML for the Powered by Drupal text.
 *
 * @ingroup themeable
 */
function theme_system_powered_by() {
  return '<span>' . t('Powered by <a href="@poweredby">Drupal</a>', array('@poweredby' => 'https://www.drupal.org')) . '</span>';
}

/**
 * Returns HTML for a link to show or hide inline help descriptions.
 *
 * @ingroup themeable
 */
function theme_system_compact_link() {
  $output = '<div class="compact-link">';
  if (system_admin_compact_mode()) {
    $output .= l(t('Show descriptions'), 'admin/compact/off', array('attributes' => array('title' => t('Expand layout to include descriptions.')), 'query' => drupal_get_destination()));
  }
  else {
    $output .= l(t('Hide descriptions'), 'admin/compact/on', array('attributes' => array('title' => t('Compress layout by hiding descriptions.')), 'query' => drupal_get_destination()));
  }
  $output .= '</div>';

  return $output;
}

/**
 * Implements hook_image_toolkits().
 */
function system_image_toolkits() {
  include_once DRUPAL_ROOT . '/' . drupal_get_path('module', 'system') . '/' . 'image.gd.inc';
  return array(
    'gd' => array(
      'title' => t('GD2 image manipulation toolkit'),
      'available' => function_exists('image_gd_check_settings') && image_gd_check_settings(),
    ),
  );
}

/**
 * Attempts to get a file using drupal_http_request and to store it locally.
 *
 * @param string $url
 *   The URL of the file to grab.
 * @param string $destination
 *   Stream wrapper URI specifying where the file should be placed. If a
 *   directory path is provided, the file is saved into that directory under
 *   its original name. If the path contains a filename as well, that one will
 *   be used instead.
 *   If this value is omitted, the site's default files scheme will be used,
 *   usually "public://".
 * @param bool $managed
 *   If this is set to TRUE, the file API hooks will be invoked and the file is
 *   registered in the database.
 * @param int $replace
 *   Replace behavior when the destination file already exists:
 *   - FILE_EXISTS_REPLACE: Replace the existing file.
 *   - FILE_EXISTS_RENAME: Append _{incrementing number} until the filename is
 *     unique.
 *   - FILE_EXISTS_ERROR: Do nothing and return FALSE.
 *
 * @return mixed
 *   One of these possibilities:
 *   - If it succeeds and $managed is FALSE, the location where the file was
 *     saved.
 *   - If it succeeds and $managed is TRUE, a \Drupal\file\FileInterface
 *     object which describes the file.
 *   - If it fails, FALSE.
 */
function system_retrieve_file($url, $destination = NULL, $managed = FALSE, $replace = FILE_EXISTS_RENAME) {
  $parsed_url = parse_url($url);
  if (!isset($destination)) {
    $path = file_build_uri(drupal_basename($parsed_url['path']));
  }
  else {
    if (is_dir(drupal_realpath($destination))) {
      // Prevent URIs with triple slashes when glueing parts together.
      $path = str_replace('///', '//', "$destination/") . drupal_basename($parsed_url['path']);
    }
    else {
      $path = $destination;
    }
  }
  $result = drupal_http_request($url);
  if ($result->code != 200) {
    drupal_set_message(t('HTTP error @errorcode occurred when trying to fetch @remote.', array('@errorcode' => $result->code, '@remote' => $url)), 'error');
    return FALSE;
  }
  $local = $managed ? file_save_data($result->data, $path, $replace) : file_unmanaged_save_data($result->data, $path, $replace);
  if (!$local) {
    drupal_set_message(t('@remote could not be saved to @path.', array('@remote' => $url, '@path' => $path)), 'error');
  }

  return $local;
}

/**
 * Implements hook_page_alter().
 */
function system_page_alter(&$page) {
  // Find all non-empty page regions, and add a theme wrapper function that
  // allows them to be consistently themed.
  foreach (system_region_list($GLOBALS['theme'], REGIONS_ALL, FALSE) as $region) {
    if (!empty($page[$region])) {
      $page[$region]['#theme_wrappers'][] = 'region';
      $page[$region]['#region'] = $region;
    }
  }
}

/**
 * Run the automated cron if enabled.
 */
function system_run_automated_cron() {
  // If the site is not fully installed, suppress the automated cron run.
  // Otherwise it could be triggered prematurely by Ajax requests during
  // installation.
  if (($threshold = $bootstrap->variable_get('cron_safe_threshold', DRUPAL_CRON_DEFAULT_THRESHOLD)) > 0 && $bootstrap->variable_get('install_task') == 'done') {
    $cron_last = $bootstrap->variable_get('cron_last', NULL);
    if (!isset($cron_last) || (REQUEST_TIME - $cron_last > $threshold)) {
      drupal_cron_run();
    }
  }
}

/**
 * Gets the list of available date types and attributes.
 *
 * @param $type
 *   (optional) The date type name.
 *
 * @return
 *   An associative array of date type information keyed by the date type name.
 *   Each date type information array has the following elements:
 *   - type: The machine-readable name of the date type.
 *   - title: The human-readable name of the date type.
 *   - locked: A boolean indicating whether or not this date type should be
 *     configurable from the user interface.
 *   - module: The name of the module that defined this date type in its
 *     hook_date_format_types(). An empty string if the date type was
 *     user-defined.
 *   - is_new: A boolean indicating whether or not this date type is as of yet
 *     unsaved in the database.
 *   If $type was defined, only a single associative array with the above
 *   elements is returned.
 */
function system_get_date_types($type = NULL) {
  $types = &drupal_static(__FUNCTION__);

  if (!isset($types)) {
    $types = _system_date_format_types_build();
  }

  return $type ? (isset($types[$type]) ? $types[$type] : FALSE) : $types;
}

/**
 * Implements hook_date_format_types().
 */
function system_date_format_types() {
  return array(
    'long' => t('Long'),
    'medium' => t('Medium'),
    'short' => t('Short'),
  );
}

/**
 * Implements hook_date_formats().
 */
function system_date_formats() {
  include_once DRUPAL_ROOT . '/includes/date.inc';
  return system_default_date_formats();
}

/**
 * Gets the list of defined date formats and attributes.
 *
 * @param $type
 *   (optional) The date type name.
 *
 * @return
 *   An associative array of date formats. The top-level keys are the names of
 *   the date types that the date formats belong to. The values are in turn
 *   associative arrays keyed by the format string, with the following keys:
 *   - dfid: The date format ID.
 *   - format: The format string.
 *   - type: The machine-readable name of the date type.
 *   - locales: An array of language codes. This can include both 2 character
 *     language codes like 'en and 'fr' and 5 character language codes like
 *     'en-gb' and 'en-us'.
 *   - locked: A boolean indicating whether or not this date type should be
 *     configurable from the user interface.
 *   - module: The name of the module that defined this date format in its
 *     hook_date_formats(). An empty string if the format was user-defined.
 *   - is_new: A boolean indicating whether or not this date type is as of yet
 *     unsaved in the database.
 *   If $type was defined, only the date formats associated with the given date
 *   type are returned, in a single associative array keyed by format string.
 */
function system_get_date_formats($type = NULL) {
  $date_formats = &drupal_static(__FUNCTION__);

  if (!isset($date_formats)) {
    $date_formats = _system_date_formats_build();
  }

  return $type ? (isset($date_formats[$type]) ? $date_formats[$type] : FALSE) : $date_formats;
}

/**
 * Gets the format details for a particular format ID.
 *
 * @param $dfid
 *   A date format ID.
 *
 * @return
 *   A date format object with the following properties:
 *   - dfid: The date format ID.
 *   - format: The date format string.
 *   - type: The name of the date type.
 *   - locked: Whether the date format can be changed or not.
 */
function system_get_date_format($dfid) {
  return db_query('SELECT df.dfid, df.format, df.type, df.locked FROM {date_formats} df WHERE df.dfid = :dfid', array(':dfid' => $dfid))->fetch();
}

/**
 * Resets the database cache of date formats and saves all new date formats.
 */
function system_date_formats_rebuild() {
  drupal_static_reset('system_get_date_formats');
  $date_formats = system_get_date_formats(NULL);

  foreach ($date_formats as $type => $formats) {
    foreach ($formats as $format => $info) {
      system_date_format_save($info);
    }
  }

  // Rebuild configured date formats locale list.
  drupal_static_reset('system_date_format_locale');
  system_date_format_locale();

  _system_date_formats_build();
}

/**
 * Gets the appropriate date format string for a date type and locale.
 *
 * @param $langcode
 *   (optional) Language code for the current locale. This can be a 2 character
 *   language code like 'en' and 'fr' or a 5 character language code like
 *   'en-gb' and 'en-us'.
 * @param $type
 *   (optional) The date type name.
 *
 * @return
 *   If $type and $langcode are specified, returns the corresponding date format
 *   string. If only $langcode is specified, returns an array of all date
 *   format strings for that locale, keyed by the date type. If neither is
 *   specified, or if no matching formats are found, returns FALSE.
 */
function system_date_format_locale($langcode = NULL, $type = NULL) {
  $formats = &drupal_static(__FUNCTION__);

  if (empty($formats)) {
    $formats = [];
    $result = db_query("SELECT format, type, language FROM {date_format_locale}");
    foreach ($result as $record) {
      if (!isset($formats[$record->language])) {
        $formats[$record->language] = [];
      }
      $formats[$record->language][$record->type] = $record->format;
    }
  }

  if ($type && $langcode && !empty($formats[$langcode][$type])) {
    return $formats[$langcode][$type];
  }
  elseif ($langcode && !empty($formats[$langcode])) {
    return $formats[$langcode];
  }

  return FALSE;
}

/**
 * Builds and returns information about available date types.
 *
 * @return
 *   An associative array of date type information keyed by name. Each date type
 *   information array has the following elements:
 *   - type: The machine-readable name of the date type.
 *   - title: The human-readable name of the date type.
 *   - locked: A boolean indicating whether or not this date type should be
 *     configurable from the user interface.
 *   - module: The name of the module that defined this format in its
 *     hook_date_format_types(). An empty string if the format was user-defined.
 *   - is_new: A boolean indicating whether or not this date type is as of yet
 *     unsaved in the database.
 */
function _system_date_format_types_build() {
  $types = [];

  // Get list of modules that implement hook_date_format_types().
  $modules = module_implements('date_format_types');

  foreach ($modules as $module) {
    $module_types = module_invoke($module, 'date_format_types');
    foreach ($module_types as $module_type => $type_title) {
      $type = [];
      $type['module'] = $module;
      $type['type'] = $module_type;
      $type['title'] = $type_title;
      $type['locked'] = 1;
      // Will be over-ridden later if in the db.
      $type['is_new'] = TRUE;
      $types[$module_type] = $type;
    }
  }

  // Get custom formats added to the database by the end user.
  $result = db_query('SELECT dft.type, dft.title, dft.locked FROM {date_format_type} dft ORDER BY dft.title');
  foreach ($result as $record) {
    if (!isset($types[$record->type])) {
      $type = [];
      $type['is_new'] = FALSE;
      $type['module'] = '';
      $type['type'] = $record->type;
      $type['title'] = $record->title;
      $type['locked'] = $record->locked;
      $types[$record->type] = $type;
    }
    else {
      $type = [];
      $type['is_new'] = FALSE;  // Over-riding previous setting.
      $types[$record->type] = array_merge($types[$record->type], $type);
    }
  }

  // Allow other modules to modify these date types.
  drupal_alter('date_format_types', $types);

  return $types;
}

/**
 * Builds and returns information about available date formats.
 *
 * @return
 *   An associative array of date formats. The top-level keys are the names of
 *   the date types that the date formats belong to. The values are in turn
 *   associative arrays keyed by format with the following keys:
 *   - dfid: The date format ID.
 *   - format: The PHP date format string.
 *   - type: The machine-readable name of the date type the format belongs to.
 *   - locales: An array of language codes. This can include both 2 character
 *     language codes like 'en and 'fr' and 5 character language codes like
 *     'en-gb' and 'en-us'.
 *   - locked: A boolean indicating whether or not this date type should be
 *     configurable from the user interface.
 *   - module: The name of the module that defined this format in its
 *     hook_date_formats(). An empty string if the format was user-defined.
 *   - is_new: A boolean indicating whether or not this date type is as of yet
 *     unsaved in the database.
 */
function _system_date_formats_build() {
  $date_formats = [];

  // First handle hook_date_format_types().
  $types = _system_date_format_types_build();
  foreach ($types as $type => $info) {
    system_date_format_type_save($info);
  }

  // Get formats supplied by various contrib modules.
  $module_formats = module_invoke_all('date_formats');

  foreach ($module_formats as $module_format) {
    // System types are locked.
    $module_format['locked'] = 1;
    // If no date type is specified, assign 'custom'.
    if (!isset($module_format['type'])) {
      $module_format['type'] = 'custom';
    }
    if (!in_array($module_format['type'], array_keys($types))) {
      continue;
    }
    if (!isset($date_formats[$module_format['type']])) {
      $date_formats[$module_format['type']] = [];
    }

    // If another module already set this format, merge in the new settings.
    if (isset($date_formats[$module_format['type']][$module_format['format']])) {
      $date_formats[$module_format['type']][$module_format['format']] = array_merge_recursive($date_formats[$module_format['type']][$module_format['format']], $module_format);
    }
    else {
      // This setting will be overridden later if it already exists in the db.
      $module_format['is_new'] = TRUE;
      $date_formats[$module_format['type']][$module_format['format']] = $module_format;
    }
  }

  // Get custom formats added to the database by the end user.
  $result = db_query('SELECT df.dfid, df.format, df.type, df.locked, dfl.language FROM {date_formats} df LEFT JOIN {date_format_locale} dfl ON df.format = dfl.format AND df.type = dfl.type ORDER BY df.type, df.format');
  foreach ($result as $record) {
    // If this date type isn't set, initialise the array.
    if (!isset($date_formats[$record->type])) {
      $date_formats[$record->type] = [];
    }
    $format = (array) $record;
    $format['is_new'] = FALSE; // It's in the db, so override this setting.
    // If this format not already present, add it to the array.
    if (!isset($date_formats[$record->type][$record->format])) {
      $format['module'] = '';
      $format['locales'] = array($record->language);
      $date_formats[$record->type][$record->format] = $format;
    }
    // Format already present, so merge in settings.
    else {
      if (!empty($record->language)) {
        $format['locales'] = array_merge($date_formats[$record->type][$record->format]['locales'], array($record->language));
      }
      $date_formats[$record->type][$record->format] = array_merge($date_formats[$record->type][$record->format], $format);
    }
  }

  // Allow other modules to modify these formats.
  drupal_alter('date_formats', $date_formats);

  return $date_formats;
}

/**
 * Saves a date type to the database.
 *
 * @param $type
 *   A date type array containing the following keys:
 *   - type: The machine-readable name of the date type.
 *   - title: The human-readable name of the date type.
 *   - locked: A boolean indicating whether or not this date type should be
 *     configurable from the user interface.
 *   - is_new: A boolean indicating whether or not this date type is as of yet
 *     unsaved in the database.
 */
function system_date_format_type_save($type) {
  $info = [];
  $info['type'] = $type['type'];
  $info['title'] = $type['title'];
  $info['locked'] = $type['locked'];

  // Update date_format table.
  if (!empty($type['is_new'])) {
    drupal_write_record('date_format_type', $info);
  }
  else {
    drupal_write_record('date_format_type', $info, 'type');
  }
}

/**
 * Deletes a date type from the database.
 *
 * @param $type
 *   The machine-readable name of the date type.
 */
function system_date_format_type_delete($type) {
  db_delete('date_formats')
    ->condition('type', $type)
    ->execute();
  db_delete('date_format_type')
    ->condition('type', $type)
    ->execute();
  db_delete('date_format_locale')
    ->condition('type', $type)
    ->execute();
}

/**
 * Saves a date format to the database.
 *
 * @param $date_format
 *   A date format array containing the following keys:
 *   - type: The name of the date type this format is associated with.
 *   - format: The PHP date format string.
 *   - locked: A boolean indicating whether or not this format should be
 *     configurable from the user interface.
 * @param $dfid
 *   If set, replace the existing date format having this ID with the
 *   information specified in $date_format.
 *
 * @see system_get_date_types()
 * @see http://php.net/date
 */
function system_date_format_save($date_format, $dfid = 0) {
  $info = [];
  $info['dfid'] = $dfid;
  $info['type'] = $date_format['type'];
  $info['format'] = $date_format['format'];
  $info['locked'] = $date_format['locked'];

  // Update date_format table.
  if (!empty($date_format['is_new'])) {
    drupal_write_record('date_formats', $info);
  }
  else {
    $keys = ($dfid ? array('dfid') : array('format', 'type'));
    drupal_write_record('date_formats', $info, $keys);
  }

  // Retrieve an array of language objects for enabled languages.
  $languages = language_list('enabled');
  // This list is keyed off the value of $language->enabled; we want the ones
  // that are enabled (value of 1).
  $languages = $languages[1];

  $locale_format = [];
  $locale_format['type'] = $date_format['type'];
  $locale_format['format'] = $date_format['format'];

  // Check if the suggested language codes are configured and enabled.
  if (!empty($date_format['locales'])) {
    foreach ($date_format['locales'] as $langcode) {
      // Only proceed if language is enabled.
      if (isset($languages[$langcode])) {
        $is_existing = (bool) db_query_range('SELECT 1 FROM {date_format_locale} WHERE type = :type AND language = :language', 0, 1, array(':type' => $date_format['type'], ':language' => $langcode))->fetchField();
        if (!$is_existing) {
          $locale_format['language'] = $langcode;
          drupal_write_record('date_format_locale', $locale_format);
        }
      }
    }
  }
}

/**
 * Deletes a date format from the database.
 *
 * @param $dfid
 *   The date format ID.
 */
function system_date_format_delete($dfid) {
  db_delete('date_formats')
    ->condition('dfid', $dfid)
    ->execute();
}

/**
 * Implements hook_archiver_info().
 */
function system_archiver_info() {
  $archivers['tar'] = array(
    'class' => 'ArchiverTar',
    'extensions' => array('tar', 'tgz', 'tar.gz', 'tar.bz2'),
  );
  if (function_exists('zip_open')) {
    $archivers['zip'] = array(
      'class' => 'ArchiverZip',
      'extensions' => array('zip'),
    );
  }
  return $archivers;
}

/**
 * Returns HTML for a confirmation form.
 *
 * By default this does not alter the appearance of a form at all,
 * but is provided as a convenience for themers.
 *
 * @param $variables
 *   An associative array containing:
 *   - form: A render element representing the form.
 *
 * @ingroup themeable
 */
function theme_confirm_form($variables) {
  return drupal_render_children($variables['form']);
}

/**
 * Returns HTML for a system settings form.
 *
 * By default this does not alter the appearance of a form at all,
 * but is provided as a convenience for themers.
 *
 * @param $variables
 *   An associative array containing:
 *   - form: A render element representing the form.
 *
 * @ingroup themeable
 */
function theme_system_settings_form($variables) {
  return drupal_render_children($variables['form']);
}

/**
 * Returns HTML for an exposed filter form.
 *
 * @param $variables
 *   An associative array containing:
 *   - form: An associative array containing the structure of the form.
 *
 * @return
 *   A string containing an HTML-formatted form.
 *
 * @ingroup themeable
 */
function theme_exposed_filters($variables) {
  $form = $variables['form'];
  $output = '';

  if (isset($form['current'])) {
    $items = [];
    foreach (element_children($form['current']) as $key) {
      $items[] = drupal_render($form['current'][$key]);
    }
    $output .= theme('item_list', array('items' => $items, 'attributes' => array('class' => array('clearfix', 'current-filters'))));
  }

  $output .= drupal_render_children($form);

  return '<div class="exposed-filters">' . $output . '</div>';
}

/**
 * Implements hook_admin_paths().
 */
function system_admin_paths() {
  $paths = array(
    'admin' => TRUE,
    'admin/*' => TRUE,
    'batch' => TRUE,
    // This page should not be treated as administrative since it outputs its
    // own content (outside of any administration theme).
    'admin/reports/status/php' => FALSE,
  );
  return $paths;
}
}