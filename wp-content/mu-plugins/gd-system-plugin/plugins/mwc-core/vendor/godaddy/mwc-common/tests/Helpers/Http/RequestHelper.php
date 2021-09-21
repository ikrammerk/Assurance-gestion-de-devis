<?php

namespace GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http;

use Exception;
use GoDaddy\WordPress\MWC\Common\Http\Request;
use GoDaddy\WordPress\MWC\Common\Http\Response;
use PHPUnit\Framework\Assert;
use function Patchwork\redefine;

/**
 * Test helper class for faking requests
 */
class RequestHelper
{
    use HasHttpAssertionsTrait;

    /** @var Request Must override so static instance is specific to this class */
    protected static $httpItemInstance;

    /** @var int Must override so that static count is kept specifically on this class */
    protected static $httpItemCalledCount = 0;

    /**
     * Register listeners that will intercept requests and return responses.
     *
     * @param callable|null $callback
     *
     * @return void
     * @throws Exception
     */
    public static function fake(callable $callback = null)
    {
        \WP_Mock::userFunction('is_wp_error')->andReturnFalse();
        \WP_Mock::userFunction('wp_remote_retrieve_response_code')->andReturn(200);

        static::$httpItemInstance      = new Request();
        static::$httpItemCalledCount   = 0;

        $instance = &static::$httpItemInstance;
        $count    = &static::$httpItemCalledCount;

        redefine(Request::class.'::send', function() use ($callback, &$instance, &$count) {
            // @NOTE: Strict comparison will only compare the class name where we want the full object values compared
            if ($instance != $this) {
                $instance = $this;
                $count    = 0;
            }

            $count++;

            if (is_null($callback)) {
                return new Response([
                    'body' => $this->body ? json_encode($this->body) : null,
                    'headers' => $this->headers,
                    'method' => $this->method,
                    'sslverify' => $this->sslVerify,
                    'timeout' => $this->timeout,
                ]);
            }

            return $callback();
        });
	}

    /**
     * Custom assertion to check the request is to a given url
     *
     * @param string $expectedUrl
     * @param string|null $message
     * @return void
     */
    public static function assertSentTo(string $expectedUrl, string $message = '')
    {
        Assert::assertEquals($expectedUrl, static::$httpItemInstance->url, $message);
    }

    /**
     * Custom assertion to check the request has a set of query parameters
     *
     * @param array $expectedParams
     * @param string|null $message
     * @return void
     */
    public static function assertHasQueryParams(array $expectedParams, string $message = '')
    {
        Assert::assertEquals($expectedParams, static::$httpItemInstance->query, $message);
    }
}
