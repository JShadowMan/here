<?php
/**
 * @author ShadowMan 
 * @package Core.Request
 */
if (!defined('__HERE_ROOT_DIRECTORY__')) {
    exit;
}

class Request {
    /**
     * url prefix
     * @var string
     */
    private static $_urlPrefix = null;

    /**
     * GET POST PUT PATCH DELETE params
     * @var array
     */
    private static $_params = array();

    /**
     * RESTful API params
     * @var Config
     */
    private static $_RESTful = null;

    # Params form
    const REST = 1;

    public static function r($key, $mode = null) {
        if (empty(self::$_params) || self::$_RESTful == null) {
            if (self::$_RESTful == null) {
                // from PUT PATCH method
                self::$_RESTful = Config::factory(file_get_contents('php://input'));
            }
            self::$_params = array_merge(self::$_params, $_GET, $_POST, Config::export(self::$_RESTful));
        }
        if ($mode == null) {
            if (array_key_exists($key, self::$_params)) {
                return self::$_params[$key];
            } else {
                return null;
            }
        } else {
            return self::$_RESTful->{$key};
        }
    }

    public static function rs() {
        $result = array();
        $params = func_get_args();

        foreach ($params as $key) {
            $result[$key] = self::r($key);
        }

        return $result;
    }

    public static function s($key, $val, $mode = null) {
        if ($mode == null) {
            self::$_params[$key] = $val;
        } else {
            if (self::$_RESTful == null) {
                self::$_RESTful = Config::factory(file_get_contents('php://input'));
            }
            self::$_RESTful->{$key} = $val;
        }
    }

    public static function getFullUrl($path = null) {
        return self::getUrlPrefix() . $path;
    }

    private static function getUrlPrefix() {
        if (empty(self::$_urlPrefix)) {
            self::$_urlPrefix = (self::isSecure() ? 'https' : 'http') . '://'
                . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'])
                . (isset($_SERVER['HTTP_HOST']) && in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : $_SERVER['SERVER_PORT']));
        }
        return self::$_urlPrefix;
    }

    private static function isSecure() {
        return (
            (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ||
            (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
        );
    }
}

?>