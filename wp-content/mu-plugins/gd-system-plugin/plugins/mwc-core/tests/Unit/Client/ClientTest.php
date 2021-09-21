<?php

namespace GoDaddy\WordPress\MWC\Core\Tests\Unit\Client;

use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Repositories\ManagedWooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Tests\TestHelpers;
use GoDaddy\WordPress\MWC\Common\Tests\WPTestCase;
use GoDaddy\WordPress\MWC\Core\Client\Client;
use ReflectionException;
use WP_Mock;

/**
 * @covers \GoDaddy\WordPress\MWC\Core\Client\Client
 */
final class ClientTest extends WPTestCase
{
    /**
     * Runs before each test.
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->mockStaticMethod(ManagedWooCommerceRepository::class, 'hasEcommercePlan')
             ->andReturn(true);
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Core\Client\Client::__construct()
     * @throws ReflectionException
     */
    public function testConstructor()
    {
        Configuration::set('mwc.client.index.url', 'https://example.com');

        $properties = [
            'appHandle' => 'mwcClient',
            'appSource' => 'https://example.com',
        ];

        $client = new Client();

        foreach ($properties as $propertyName => $expectedValue) {
            $property = TestHelpers::getInaccessibleProperty(Client::class, $propertyName);

            $this->assertSame($expectedValue, $property->getValue($client));
        }
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Core\Client\Client::registerAssets()
     * @throws ReflectionException
     */
    public function testRegisterAssets()
    {
        $method = TestHelpers::getInaccessibleMethod(Client::class, 'registerAssets');
        $client = new Client();

        WP_Mock::expectActionAdded('admin_enqueue_scripts', [$client, 'enqueueAssets'], 10, 1);

        $method->invoke($client);

        $this->assertConditionsMet();
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Core\Client\Client::enqueueAssets()
     * @covers \GoDaddy\WordPress\MWC\Core\Client\Client::enqueueApp()
     */
    public function testEnqueueAssets()
    {
        Configuration::set('mwc.client.runtime.url', 'https://example.com/runtime');
        Configuration::set('mwc.client.vendors.url', 'https://example.com/vendors');
        Configuration::set('mwc.client.index.url', 'https://example.com/index');

        $client = new Client();

        WP_Mock::userFunction('wp_register_script', ['times' => 1])->with('mwcClient-runtime', 'https://example.com/runtime', [], null, true);
        WP_Mock::userFunction('wp_enqueue_script', ['times' => 1])->with('mwcClient-runtime');

        WP_Mock::userFunction('wp_register_script', ['times' => 1])->with('mwcClient-vendors', 'https://example.com/vendors', [], null, true);
        WP_Mock::userFunction('wp_enqueue_script', ['times' => 1])->with('mwcClient-vendors');

        WP_Mock::userFunction('wp_register_script', ['times' => 1])->with('mwcClient', 'https://example.com/index', [], null, true);
        WP_Mock::userFunction('wp_enqueue_script', ['times' => 1])->with('mwcClient');
        WP_Mock::userFunction('wp_localize_script', ['times' => 1])->with('mwcClient', 'mwcClient', ['root' => 'https://example.com/rest', 'nonce' => 'nonce']);

        WP_Mock::userFunction('rest_url')->andReturn('https://example.com/rest');
        WP_Mock::userFunction('esc_url_raw')->andReturnArg(0);
        WP_Mock::userFunction('wp_create_nonce')->andReturn('nonce');

        $client->enqueueAssets();

        $this->assertConditionsMet();
    }
}
