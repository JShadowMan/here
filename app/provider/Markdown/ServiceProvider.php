<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Markdown;

use Here\Provider\AbstractServiceProvider;
use Parsedown;


/**
 * Class ServiceProvider
 * @package Here\Provider\Markdown
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * The name of the service
     *
     * @var string
     */
    protected $service_name = 'markdown';

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->set($this->service_name, function() {
            return new Parsedown();
        });
    }

}
