<?php

namespace GoDaddy\WordPress\MWC\Common\Tests\Unit\Tests\Helpers\Http;

use Exception;
use GoDaddy\WordPress\MWC\Common\Http\Request;
use GoDaddy\WordPress\MWC\Common\Http\Response;
use GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper;
use GoDaddy\WordPress\MWC\Common\Tests\WPTestCase;

/**
 * @covers \GoDaddy\WordPress\MWC\Common\Repositories\WordPressRepository
 */
final class RequestHelperTest extends WPTestCase
{
    /**
     * Tests that can override the return of a request for testing scenarios
     *
     * @covers \GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper::fake()
     * @throws Exception
     */
    public function testCanOverrideRequestSendReturn()
    {
        $this->mockWordPressTransients();

        RequestHelper::fake(function() {
            return (new Response())
                ->status(519);
        });

        $response = (new Request())->send();

        $this->assertEquals(519, $response->getStatus());
    }

    /**
     * Tests that fake a requests typically returned response object with mimicked body
     *
     * @covers \GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper::fake()
     * @throws Exception
     */
    public function testCanReturnExpectedResponse()
    {
        $this->mockWordPressTransients();

        RequestHelper::fake();

        $response = (new Request())
            ->headers(['FOO' => 'BAR'])
            ->body(['key' => 'value'])
            ->setMethod('post')
            ->timeout(100)
            ->send();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(['key' => 'value'], $response->getBody());
    }

    /**
     * Tests that fake can properly track call counts
     *
     * @covers \GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper::assertSent()
     * @covers \GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper::assertSentTimes()
     * @covers \GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper::assertNotSent()
     * @throws Exception
     */
    public function testCanDetermineResponseCounts()
    {
        RequestHelper::fake();

        RequestHelper::assertNotSent();

        $request = (new Request());

        $request->send();

        RequestHelper::assertSent();

        $request->send();

        RequestHelper::assertSentTimes(2);
    }

    /**
     * Tests that can assert a request is to a given url
     *
     * @covers \GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper::assertSentTo()
     * @throws Exception
     */
    public function testCanAssertSentToUrl()
    {
        RequestHelper::fake();

        (new Request())->url('foobar')->send();

        RequestHelper::assertSentTo('foobar');
    }

    /**
     * Tests that can assert the query params used in the request match a given array of params
     *
     * @covers \GoDaddy\WordPress\MWC\Common\Tests\Helpers\Http\RequestHelper::assertHasQueryParams()
     * @throws Exception
     */
    public function testCanAssertQueryParamsUsed()
    {
        RequestHelper::fake();

        (new Request())->query(['foo' => 'bar', 'test' => 'second'])->send();

        RequestHelper::assertHasQueryParams(['foo' => 'bar', 'test' => 'second']);
    }
}
