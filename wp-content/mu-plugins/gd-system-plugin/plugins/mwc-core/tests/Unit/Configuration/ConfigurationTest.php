<?php

namespace GoDaddy\WordPress\MWC\Core\Tests\Unit\Configuration;

use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Tests\WPTestCase;

/**
 * Tests the integrity of the configuration files under /configurations.
 */
class ConfigurationTest extends WPTestCase
{
    /**
     * Tests that important configuration values are set in configurations/mwc.php.
     *
     * @covers configurations/mwc.php
     */
    public function testManagedWooCommerceConfigurationFile()
    {
        Configuration::initialize([
            StringHelper::trailingSlash(StringHelper::before(__DIR__, 'tests').'configurations'),
        ]);

        $this->assertSame('https://cdn4.mwc.secureserver.net/vendors.js', Configuration::get('mwc.client.vendors.url'));
        $this->assertSame('https://cdn4.mwc.secureserver.net/runtime.js', Configuration::get('mwc.client.runtime.url'));
        $this->assertSame('https://cdn4.mwc.secureserver.net/index.js', Configuration::get('mwc.client.index.url'));
    }
}
