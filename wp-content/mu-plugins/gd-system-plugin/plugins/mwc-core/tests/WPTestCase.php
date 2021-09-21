<?php

namespace GoDaddy\WordPress\MWC\Core\Tests;

use GoDaddy\WordPress\MWC\Common\Tests\WPTestCase as CommonTestCase;
use WP_Mock;

class WPTestCase extends CommonTestCase
{
    /**
     * Mocks a WordPress current_user_can call.
     *
     * @since 2.0.0
     *
     * @param string $username
     * @param string $capability
     *
     * @return void
     */
    protected function mockWordPressCapabilitiesFunctions(string $username, string $capability)
    {
        WP_Mock::userFunction('current_user_can')
            ->withArgs([$capability])
            ->andReturn('admin' === $username);
    }

    /**
     * Mock a wordpress get_option call.
     *
     * @param string $option
     * @param null $returnValue
     *
     * @return void
     */
    protected function mockWordPressGetOption(string $option, $returnValue = null)
    {
        WP_Mock::userFunction('get_option')
            ->withArgs([$option])
            ->andReturn($returnValue);
    }

    /**
     * Mock a wordpress Plugin functions.
     *
     * @param string $pluginName
     * @param $returnValue
     *
     * @return void
     */
    protected function mockWordPressPluginFunctions(string $pluginName, $returnValue)
    {
        WP_Mock::userFunction('activate_plugin')
            ->withArgs([$pluginName])
            ->andReturn($returnValue);
    }

    /**
     * Mock wordpress request functions.
     *
     * @param int          $status_code
     * @param string|array $message
     * @param bool         $error
     *
     * @return void
     */
    protected function mockWordPressRequestFunctions(int $status_code = 200, $message = 'success', bool $error = false)
    {
        $this->mockWordPressResponseFunctions($status_code, $message, $error);

        WP_Mock::userFunction('wp_remote_request')->andReturn([
            'headers'  => '',
            'body'     => json_encode(['products' => [
                ['name' => 'test'],
                ['name' => 'WooCommerce test'],
                ['name' => 'test WooCommerce test'],
                ['name' => 'test WooCommerce'],
            ]]),
            'response' => [
                'code'    => $status_code,
                'message' => $message,
            ],
        ]);
    }

    /**
     * Mock a wordpress response functions.
     *
     * @param int          $status_code
     * @param string|array $message
     * @param bool         $error
     *
     * @return void
     */
    protected function mockWordPressResponseFunctions(int $status_code = 200, $message = 'success', bool $error = false)
    {
        WP_Mock::userFunction('is_wp_error')->andReturn($error);
        WP_Mock::userFunction('wp_remote_retrieve_body')->andReturn(json_encode($message));
        WP_Mock::userFunction('wp_remote_retrieve_response_code')->andReturn($status_code);
    }

    /**
     * Mock a wordpress script functions.
     *
     * @return void
     */
    protected function mockWordPressScriptFunctions()
    {
        WP_Mock::userFunction('wp_enqueue_script')->andReturnNull();
        WP_Mock::userFunction('wp_register_script')->andReturnNull();
        WP_Mock::userFunction('wp_add_inline_script')->andReturnNull();
    }

    /**
     * Mock a wordpress transients.
     *
     * @return void
     */
    protected function mockWordPressTransients()
    {
        WP_Mock::userFunction('delete_transient')->andReturnTrue();
        WP_Mock::userFunction('get_transient')->andReturnNull();
        WP_Mock::userFunction('set_transient')->andReturnNull();
    }
}
