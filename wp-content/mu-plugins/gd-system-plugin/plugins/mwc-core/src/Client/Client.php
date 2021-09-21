<?php

namespace GoDaddy\WordPress\MWC\Core\Client;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Enqueue\Enqueue;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\ManagedWooCommerceRepository;

/**
 * MWC Client class.
 *
 * @since x.y.z
 */
class Client
{
    /** @var string the app source, normally a URL */
    protected $appSource;

    /** @var string the identifier of the application */
    protected $appHandle;

    /**
     * MWC Client constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        if (! ManagedWooCommerceRepository::hasEcommercePlan()) {
            return;
        }

        $this->appHandle = 'mwcClient';
        $this->appSource = Configuration::get('mwc.client.index.url');

        $this->registerAssets();
    }

    /**
     * Registers the client assets.
     *
     * @since x.y.z
     *
     * @return self
     */
    protected function registerAssets() : self
    {
        try {
            Register::action()
                    ->setGroup('admin_enqueue_scripts')
                    ->setHandler([$this, 'enqueueAssets'])
                    ->execute();
        } catch (Exception $exception) {
            // TODO: log an error using a wrapper for WC_Logger {WV 2021-02-15}
            // throw new Exception('Cannot register assets: '.$exception->getMessage());
        }

        return $this;
    }

    /**
     * Enqueues/loads registered assets.
     *
     * @since x.y.z
     *
     * @throws Exception
     */
    public function enqueueAssets()
    {
        Enqueue::script()
               ->setHandle("{$this->appHandle}-runtime")
               ->setSource(Configuration::get('mwc.client.runtime.url'))
               ->setDeferred(true)
               ->execute();

        Enqueue::script()
               ->setHandle("{$this->appHandle}-vendors")
               ->setSource(Configuration::get('mwc.client.vendors.url'))
               ->setDeferred(true)
               ->execute();

        $this->enqueueApp();
    }

    /**
     * Enqueues the single page application script.
     *
     * @since x.y.z
     *
     * @throws Exception
     */
    protected function enqueueApp()
    {
        $script = Enqueue::script()
                         ->setHandle($this->appHandle)
                         ->setSource($this->appSource)
                         ->setDeferred(true);

        $inlineScriptVariables = $this->getInlineScriptVariables();

        if (!empty($inlineScriptVariables)) {
            $script->attachInlineScriptObject($this->appHandle)
                   ->attachInlineScriptVariables($inlineScriptVariables);
        }

        $script->execute();
    }

    /**
     * Gets inline script variables.
     *
     * @since x.y.z
     *
     * @return array
     */
    protected function getInlineScriptVariables() : array
    {
        return [
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
        ];
    }
}
