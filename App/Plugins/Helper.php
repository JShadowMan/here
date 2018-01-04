<?php
/**
 * Here Plugin Helper
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/** Class Plugins_Helper
 *
 * Plugin helper
 */
class Plugins_Helper extends Here_Abstracts_Widget {
    /**
     * Plugins_Helper constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->set_widget_name('Plugin Helper');
    }

    /**
     * register a callback to hook pointer
     *
     * @param string $hook_name
     * @param callable $callback
     * @param array|null $options
     */
    public static function register($hook_name, $callback, $options = null) {

    }
}
