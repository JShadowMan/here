<?php
/**
 * InvalidArgument.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions;
use Here\Lib\Abstracts\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


class InvalidArgument extends ExceptionBase {
    use Error;
}
