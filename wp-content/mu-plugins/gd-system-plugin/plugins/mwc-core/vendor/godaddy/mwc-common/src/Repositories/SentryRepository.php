<?php

namespace GoDaddy\WordPress\MWC\Common\Repositories;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Exceptions\SentryException;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use Sentry\Event as SentryEvent;
use function Sentry\init as InitializeSentry;

class SentryRepository
{
    /**
     * Retrieves the current WooCommerce access token.
     *
     * @since x.y.z
     *
     * @return string|null
     * @throws Exception
     */
    public static function initialize()
    {
        if (! ($dsn = Configuration::get('reporting.sentry.dsn')) || ! static::hasSystemRequirements() || ! Configuration::get('reporting.sentry.enabled')) {
            return;
        }

        InitializeSentry([
            'dsn'             => $dsn,
            'environment'     => ManagedWooCommerceRepository::getEnvironment(),
            'max_breadcrumbs' => 50, // Amount of trace breadcrumbs -- default is 100
            'release'         => Configuration::get('mwc.version'), // @TODO: Replace version with commit hash {JO 2021-03-03}
            'sample_rate'     => 1, // Percentage of error events to send -- random selection
            'before_send'     => function (SentryEvent $event) {
                if (static::hasSentryException($event)) {
                    return $event;
                }

                return null;
            },
        ]);
    }

    /**
     * Checks if exception is explicitly declared as a reportable Sentry Exception.
     *
     * @NOTE If exceptions do not extend the base sentry exception they are not considered reportable.
     *
     * @since x.y.z
     *
     * @param SentryEvent $event
     * @return bool
     */
    protected static function hasSentryException(SentryEvent $event) : bool
    {
        foreach (ArrayHelper::wrap($event->getExceptions()) as $exceptionBag) {
            // @NOTE: Only send Exceptions intended for Sentry {JO 2021-03-03}
            if (is_a($exceptionBag->getType(), SentryException::class, true)) {
                return true;
            }
        }

        return false;

    }

    /**
     * Checks if the server instance meets the system requirements for Sentry.
     *
     * @NOTE: The sentry SDK Require PHP 7.2 or higher so we should check before loading any classes.
     *
     * @since x.y.z
     *
     * @return bool
     */
    public static function hasSystemRequirements() : bool
    {
        if (version_compare(PHP_VERSION, '7.2.0') >= 0) {
            return true;
        }

        return false;
    }
}
