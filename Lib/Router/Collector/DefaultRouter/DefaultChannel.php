<?php
/**
 * DefaultChannel.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\DefaultRouter;
use Here\Lib\Router\RouterRequest;


/**
 * Trait DefaultChannel
 * @package Here\Lib\Router\Collector\Channel
 */
trait DefaultChannel {
    /**
     * @routerChannel
     * @addMethods GET
     * @addUrl /
     * @addUrl /index[:\.(html|php)?]
     */
    final public function index(): void {
        var_dump('index');
    }

    /**
     * @routerChannel
     * @addLogger DashBoard
     * @addMethods GET
     * @addUrl /&dashboard
     * @addUrl /&dashboard/{path:RS2}
     * @addMiddleware authorization
     */
    final public function dashboard(): void {
        var_dump('dashboard');
        var_dump(RouterRequest::get_pair_value('path'));
    }

    /**
     * @routerChannel
     * @addMethods GET
     * @addUrl /article/<article_title:[\w\-]+>
     */
    final public function article(): void {
        var_dump('article');
        var_dump(RouterRequest::get_pair_value('article_title'));
    }

    /**
     * @routerChannel
     * @addMethods GET, POST
     * @addUrl /user/profile/[user_id:\d+]
     */
    final public function user_profile(): void {
        var_dump('user_profile');
        var_dump(RouterRequest::get_pair_value('user_id', '@self'));
    }

    /**
     * @routerChannel
     * @addMethods GET
     * @addUrl /static/<theme_name:\w+>/{resource_path:R}
     */
    final public function resources(): void {
        var_dump('dashboard');
        var_dump(RouterRequest::get_pair_value('theme_name'));
        var_dump(RouterRequest::get_pair_value('resource_path'));
    }

    /**
     * @routerChannel
     * @addLogger ApiLogger
     * @addMethods GET, POST
     * @addUrl /api/v<api_version:\d{1,2}>/<module:\w+>/<action:\w+>
     */
    final public function api(): void {
        var_dump('api');
        var_dump(RouterRequest::get_pair_value('api_version'));
        var_dump(RouterRequest::get_pair_value('module'));
        var_dump(RouterRequest::get_pair_value('action'));
    }
}
