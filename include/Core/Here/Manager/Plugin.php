<?php
/**
 *
 * @author ShadowMan
 */

if (!defined('__HERE_ROOT_DIRECTORY__')) {
    die('Permission Denied');
}

class Manager_Plugin extends Abstract_Widget {
    /**
     * store all plugins information
     * 
     * @var array
     */
    private static $_plugins = array();

    /**
     * store active plugins
     * 
     * @var array
     */
    private static $_activePlugins = array();

    /**
     * hook list and callback function
     * 
     * @var array
     */
    private static $_hooks = array();

    /**
     * absolute plugins path
     * 
     * @var string
     */
    private static $_absolutePath = null;

    public static function init() {
        if (self::$_absolutePath == null) {
            self::$_absolutePath = __HERE_ROOT_DIRECTORY__ . __HERE_PLUGINS_DIRECTORY__;
        }

        # Collect All Plugins
        $directory = dir(self::$_absolutePath);
        while (($entry = $directory->read()) !== false) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            if (is_dir(self::$_absolutePath . DIRECTORY_SEPARATOR . $entry) && is_file(self::$_absolutePath . DIRECTORY_SEPARATOR . $entry . DIRECTORY_SEPARATOR . 'Plugin.php')) {
                self::$_plugins[$entry . '_Plugin'] = self::_createPlugin(self::$_absolutePath . DIRECTORY_SEPARATOR . $entry . DIRECTORY_SEPARATOR . 'Plugin.php');
            }
        }

        # From Database Getting Active Plugins & Plugins Information
        $pluginDb = new Db();
        $pluginDb->query($pluginDb->select()->from('table.options')->where('name', Db::OP_EQUAL, 'activePlugins'));
        self::$_activePlugins = unserialize($pluginDb->fetchAssoc('value'));
        foreach (array_keys(self::$_activePlugins) as $plugin) {
            if (!array_key_exists($plugin, self::$_plugins)) {
                unset($_activePlugins[$plugin]);
                self::$_plugins[$plugin]['valid'] = false;
            }
        }

        # Setting Active Plugins Resource
        foreach (array_keys(self::$_activePlugins) as $plugin) {
            $source = self::_valueFilter(call_user_func(array($plugin, 'resource')));

            if (array_key_exists('stylesheet', $source)) {
                Widget_Theme_Renderer_Header::pluginStylesheet($source['stylesheet'], $plugin);
            }

            if (array_key_exists('javascript', $source)) {
                Widget_Theme_Renderer_Header::pluginJavascript($source['javascript'], $plugin);
            }
        }
    }

    public static function hook($hook) {
        
    }

    public static function activate($plugin) {
        
    }

    public static function registerStylesheet() {
        return array('stylesheet' => func_get_args());;
    }

    public static function registerJavascript() {
        return array('javascript' => func_get_args());
    }

    private static function _createPlugin($name, $author = null, $version = null, $license = null, $link = null) {
        $information = array();

        if (array_key_exists($name, self::$_plugins)) {
            return null;
        } else {
            $information = array_merge($information, self::_pluginFinder($name));
        }

        return $information;
    }

    private static function _pluginFinder($pluginPath) {
        $plugin  = array();

        if (is_file($pluginPath)) {
            $contents = file_get_contents($pluginPath);

            preg_match_all('/^\s*\*\s*\@(author|version|license|link)\s*(.*)$/m', $contents, $result);
            for ($length = count($result[1]), $index = 0; $index < $length; ++$index) {
                $plugin[$result[1][$index]] = trim($result[2][$index]);
            }
            $plugin['path'] = $pluginPath;
            $plugin['valid'] = true;
        } else if (is_file(self::$_absolutePath . DIRECTORY_SEPARATOR . $pluginPath . DIRECTORY_SEPARATOR . 'Plugin.php')) {
            return self::_pluginFinder(self::$_absolutePath . DIRECTORY_SEPARATOR . $pluginPath . DIRECTORY_SEPARATOR . 'Plugin.php');
        } else {
            return array();
        }

        return $plugin;
    }

    private static function _valueFilter($array) {
        if (!is_array($array)) {
            return array();
        }

        return array_filter(array_map(function($value) {
            if (is_string($value)) {
                return $value;
            } else if (is_array($value)) {
                return self::_valueFilter($value);
            }
        }, $array));
    }
}
