<?php

use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;

return [
    /*
     *--------------------------------------------------------------------------
     * Managed WooCommerce General Settings
     *--------------------------------------------------------------------------
     *
     * The following configuration items are general settings or high level
     * configurations for Managed WooCommerce
     *
     */

    /**
     * GoDaddy managed hosting config file path
     */
    'mwp_settings' => is_readable('/web/conf/gd-wordpress.conf')
        ? parse_ini_file('/web/conf/gd-wordpress.conf', true)
        : [],

    /**
     * Should the instance display debugging information
     */
    'debug' => defined('WP_DEBUG') ? WP_DEBUG : false,

    /**
     * Determine if Managed WooCommerce is running in CLI mode or not
     */
    'mode' => defined('WP_CLI') && WP_CLI ? 'cli' : 'web',

    /**
     * eCommerce Plan Name for Managed WooCommerce
     */
    'plan_name' => 'eCommerce Managed WordPress',

    /**
     * Managed WooCommerce Plugin URL
     */
    'url' => defined('MWC_CORE_PLUGIN_URL') ? MWC_CORE_PLUGIN_URL : null,

    /**
     * Managed WooCommerce Version
     */
    'version' => defined('MWC_CORE_VERSION') ? MWC_CORE_VERSION : null,

    /*
     *--------------------------------------------------------------------------
     * Information related to extensions
     *--------------------------------------------------------------------------
     */
    'extensions' => [

        /*
         * API configurations
         */
        'api' => [
            'url' => defined('MWC_EXTENSIONS_API_URL') ? MWC_EXTENSIONS_API_URL : 'https://api.mwc.secureserver.net/v1',
            'settings' => [
                'reseller' => [
                    'endpoint' => 'settings/resellers',
                ],
            ],
        ],
    ],
];
