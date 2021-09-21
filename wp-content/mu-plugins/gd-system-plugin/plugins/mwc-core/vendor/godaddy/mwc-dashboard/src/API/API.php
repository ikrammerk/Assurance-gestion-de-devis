<?php

namespace GoDaddy\WordPress\MWC\Dashboard\API;

use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Account;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Extensions;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Plugins;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Shop;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Support;

class API
{
    /**
     * All available API controllers.
     *
     * @var array
     */
    protected $controllers;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->setControllers();

        Register::action()
            ->setGroup('rest_api_init')
            ->setHandler([$this, 'registerRoutes'])
            ->execute();
    }

    /**
     * Registers all available API controllers.
     */
    protected function setControllers()
    {
        $this->controllers = [
            new Account(),
            new Extensions(),
            new Messages(),
            new Shop(),
            new Plugins(),
            new Support(),
        ];
    }

    /**
     * Registers the routes for all available API controllers.
     */
    public function registerRoutes()
    {
        foreach ($this->controllers as $controller) {
            $controller->registerRoutes();
        }
    }
}
