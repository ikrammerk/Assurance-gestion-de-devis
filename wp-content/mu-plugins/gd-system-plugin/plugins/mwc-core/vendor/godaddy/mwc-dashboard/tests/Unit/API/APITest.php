<?php

namespace GoDaddy\WordPress\MWC\Dashboard\Tests\Unit\API;

use Composer\Installers\Plugin;
use GoDaddy\WordPress\MWC\Common\Register\Types\RegisterAction;
use GoDaddy\WordPress\MWC\Common\Tests\TestHelpers;
use GoDaddy\WordPress\MWC\Common\Tests\WPTestCase;
use GoDaddy\WordPress\MWC\Dashboard\API\API;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Account;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Extensions;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Plugins;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Shop;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Support;
use function Patchwork\always;
use function Patchwork\redefine;

/**
 * @covers \GoDaddy\WordPress\MWC\Dashboard\API\API
 */
final class APITest extends WPTestCase
{
    /**
     * Tests the constructor calls the setControllers() method.
     *
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\API::__construct()
     * @throws \ReflectionException
     */
    public function testConstructorCallsSetControllers()
    {
        $this->mockRegisterActionCalls();

        $mock = $this->getMockBuilder(API::class)
                     ->enableOriginalConstructor()
                     ->onlyMethods(['setControllers'])
                     ->getMock();
        $mock->expects($this->once())->method('setControllers');

        $mock->__construct();
    }

    /**
     * Tests the setControllers() method.
     *
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\API::setControllers()
     * @throws \ReflectionException
     */
    public function testSetControllers()
    {
        $this->mockRegisterActionCalls();

        $api = new API();

        $controllers = TestHelpers::getInaccessibleProperty($api, 'controllers')->getValue($api);

        $classes = [
            Account::class,
            Extensions::class,
            Messages::class,
            Shop::class,
            Plugins::class,
            Support::class,
        ];

        $this->assertIsArray($controllers);

        foreach ($controllers as $index => $controller) {
            $this->assertInstanceOf($classes[$index], $controller);
        }
    }

    /**
     * Tests the registerRoutes() method.
     *
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\API::registerRoutes()
     * @throws \ReflectionException
     */
    public function testRegisterRoutes()
    {
        $this->mockRegisterActionCalls();

        $mock = $this->getMockBuilder(TestController::class)->getMock();
        $mock->expects($this->once())->method('registerRoutes');

        $api = new API();

        $controllers = TestHelpers::getInaccessibleProperty($api, 'controllers');
        $controllers->setValue($api, [$mock]);

        $api->registerRoutes();
    }

    /**
     * Redefines the RegisterAction::execute() method to avoid calling add_action() without setting an expectation.
     */
    private function mockRegisterActionCalls()
    {
        redefine(RegisterAction::class.'::execute', always(null));
    }
}
