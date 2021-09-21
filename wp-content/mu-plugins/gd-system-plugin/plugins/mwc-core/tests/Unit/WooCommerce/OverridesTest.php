<?php

namespace GoDaddy\WordPress\MWC\Core\Tests\Unit\WooCommerce;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Repositories\WordPressRepository;
use GoDaddy\WordPress\MWC\Core\Tests\Traits\CanMockExtensionsRequestFunctions;
use GoDaddy\WordPress\MWC\Core\Tests\WPTestCase;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Overrides;
use ReflectionClass;
use ReflectionException;
use WP_Mock;

/**
 * Provides tests for the Overrides class.
 */
class OverridesTest extends WPTestCase
{
    use CanMockExtensionsRequestFunctions;

    /**
     * Runs before each test.
     */
    public function setUp(): void
    {
        // Register::filter()->execute() is called from the constructor of
        // Overrides and requires add_filter to be defined
        WP_Mock::userFunction('add_filter')->andReturnTrue();
    }

    /**
     * Tests that the authentication headers are set when making a request to the Extensions API.
     *
     * @covers \GoDaddy\WordPress\MWC\Core\WooCommerce\Overrides::addExtensionsApiAuthenticationHeaders()
     *
     * @param bool $isAdmin
     * @param bool $isApiRequest
     * @param string $url
     * @param array $expectedArgs
     *
     * @throws Exception
     * @dataProvider dataProviderAddExtensionsApiAuthenticationHeaders
     */
    public function testAddExtensionsApiAuthenticationHeaders(bool $isAdmin, bool $isApiRequest, string $url, array $expectedArgs)
    {
	    WP_Mock::userFunction('is_admin')->andReturn($isAdmin);

	    $this->mockStaticMethod(WordPressRepository::class, 'isApiRequest')->andReturn($isApiRequest);

	    Configuration::set('mwc.extensions.api.url', 'https://extensions.api.url');
	    Configuration::set('godaddy.site.token', 'abcdef');
	    Configuration::set('godaddy.account.uid', '1234');

        $this->assertEquals($expectedArgs, (new Overrides())->addExtensionsApiAuthenticationHeaders([], $url));
    }

	/** @see testAddExtensionsApiAuthenticationHeaders */
	public function dataProviderAddExtensionsApiAuthenticationHeaders() : array
	{
		return [
			[false, false, 'https://any.other.url', []],
			[true, false, 'https://any.other.url', []],
			[false, true, 'https://any.other.url', []],
			[false, false, 'https://extensions.api.url', []],
			[false, false, 'https://extensions.api.url/xyz', []],
			[true, false, 'https://extensions.api.url', [
				'headers' => [
					'X-Site-Token' => 'abcdef',
					'X-Account-UID' => '1234',
				],
			]],
			[false, true, 'https://extensions.api.url', [
				'headers' => [
					'X-Site-Token' => 'abcdef',
					'X-Account-UID' => '1234',
				],
			]],
			[true, true, 'https://extensions.api.url', [
				'headers' => [
					'X-Site-Token' => 'abcdef',
					'X-Account-UID' => '1234',
				],
			]],
			[true, false, 'https://extensions.api.url/xyz', [
				'headers' => [
					'X-Site-Token' => 'abcdef',
					'X-Account-UID' => '1234',
				],
			]],
			[false, true, 'https://extensions.api.url/xyz', [
				'headers' => [
					'X-Site-Token' => 'abcdef',
					'X-Account-UID' => '1234',
				],
			]],
			[true, true, 'https://extensions.api.url/xyz', [
				'headers' => [
					'X-Site-Token' => 'abcdef',
					'X-Account-UID' => '1234',
				],
			]],
		];
	}

    /**
     * Tests that the SSL default option is set.
     *
     * @covers \GoDaddy\WordPress\MWC\Core\WooCommerce\Overrides::maybeSetForceSsl()
     * @throws Exception
     */
    public function testSetsSslDefault()
    {
        Configuration::set('godaddy.account.uid', '1234');
        Configuration::set('godaddy.temporary_domain', '/');

        $this->assertEquals('yes', (new Overrides())->maybeSetForceSsl(false));

        Configuration::set('godaddy.temporary_domain', 'fail');

        $this->assertFalse((new Overrides())->maybeSetForceSsl(false));
    }

    /**
     * Tests if the expected filters are being registered on the class constructor.
     *
     * @covers       \GoDaddy\WordPress\MWC\Core\WooCommerce\Overrides::registerFilters()
     *
     * @param string $filterName
     * @param string $callback
     * @param int $priority
     * @param int $args
     * @param bool $isMwp
     * @param bool $isMwpEcommercePlan
     * @param bool $shouldRegister
     *
     * @throws ReflectionException
     * @throws Exception
     * @dataProvider dataProviderIsRegisteringFilter
     */
    public function testIsRegisteringFilter(string $filterName, string $callback, int $priority, int $args, bool $isMwp, bool $isMwpEcommercePlan, bool $shouldRegister) : void
    {
        Configuration::set('godaddy.account.uid', $isMwp ? '1234' : null);
        Configuration::set('godaddy.account.plan.name', $isMwpEcommercePlan ? Configuration::get('mwc.plan_name') : null);

        $wooCommerceOverrides = new Overrides();
        $reflectionInstance = new ReflectionClass($wooCommerceOverrides);

        if ($shouldRegister) {
            WP_Mock::expectFilterAdded($filterName, [$wooCommerceOverrides, $callback], $priority, $args);
        } else {
            WP_Mock::expectFilterNotAdded($filterName, [$wooCommerceOverrides, $callback]);
        }

        $registerFilters = $reflectionInstance->getMethod('registerFilters');
        $registerFilters->setAccessible(true);
        $registerFilters->invoke($wooCommerceOverrides);

        $this->assertConditionsMet();
    }

    /** @see testIsRegisteringFilter */
    public function dataProviderIsRegisteringFilter() : array
    {
        return [
            ['wc_pdf_product_vouchers_admin_hide_low_memory_notice', 'hidePdfProductVouchersLowMemoryNotice', 10, 1, true, true, true],
            ['wc_pdf_product_vouchers_admin_hide_low_memory_notice', 'hidePdfProductVouchersLowMemoryNotice', 10, 1, false, true, false],
            ['wc_pdf_product_vouchers_admin_hide_sucuri_notice', 'hidePdfProductVouchersSucuriNotice', 10, 1, true, true, true],
            ['wc_pdf_product_vouchers_admin_hide_sucuri_notice', 'hidePdfProductVouchersSucuriNotice', 10, 1, false, true, false],
            ['woocommerce_show_admin_notice', 'suppressNotices', 10, 2, true, true, true],
            ['woocommerce_helper_suppress_connect_notice', 'suppressConnectNotice', PHP_INT_MAX, 1, true, true, true],
            ['http_request_args', 'addExtensionsApiAuthenticationHeaders', 10, 2, true, true, true],
            ['http_request_args', 'addExtensionsApiAuthenticationHeaders', 10, 2, false, false, false],
            ['pre_option_woocommerce_force_ssl_checkout', 'maybeSetForceSsl', 10, 1, true, true, true],
            ['pre_option_woocommerce_force_ssl_checkout', 'maybeSetForceSsl', 10, 1, true, false, false],
        ];
    }
}
