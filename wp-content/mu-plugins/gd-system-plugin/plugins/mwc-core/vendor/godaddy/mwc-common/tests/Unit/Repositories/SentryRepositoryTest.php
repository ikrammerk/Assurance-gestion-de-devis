<?php

namespace GoDaddy\WordPress\MWC\Common\Tests\Unit\Repositories;

use GoDaddy\WordPress\MWC\Common\Exceptions\BaseException;
use GoDaddy\WordPress\MWC\Common\Exceptions\SentryException;
use GoDaddy\WordPress\MWC\Common\Repositories\SentryRepository;
use GoDaddy\WordPress\MWC\Common\Tests\TestHelpers;
use GoDaddy\WordPress\MWC\Common\Tests\WPTestCase;
use ReflectionException;
use RuntimeException;
use Sentry\Event;
use Sentry\ExceptionDataBag;

/**
 * @covers \GoDaddy\WordPress\MWC\Common\Repositories\SentryRepository
 */
final class SentryRepositoryTest extends WPTestCase
{
    /**
     * Tests that can determine minimum requirements are met
     *
     * @covers \GoDaddy\WordPress\MWC\Common\Repositories\SentryRepository::hasSystemRequirements()
     *
     * @param string $phpVersion
     * @param bool $expectedResult
     *
     * @dataProvider provideMinimumRequirements
     */
    public function testCanDetermineHasMinimumRequirements(string $phpVersion, bool $expectedResult)
    {
        if (!extension_loaded('runkit')) {
            $this->markTestSkipped('This test requires the runkit extension.');
        }

        runkit_constant_remove('PHP_VERSION');

        define('PHP_VERSION', $phpVersion);

        $this->assertEquals($expectedResult, SentryRepository::hasSystemRequirements());
    }

    /** @see testCanDetermineHasMinimumRequirements */
    public function provideMinimumRequirements() : array
    {
        return [
            ['7.0.0', false],
            ['7.1.0', false],
            ['7.2.0', true],
            ['7.3.0', true],
            ['7.4.0', true],
            ['8.0.0', true],
        ];
    }

    /**
     * Tests that can determine if exceptions stack has a declared sentry exception
     *
     * @covers \GoDaddy\WordPress\MWC\Common\Repositories\SentryRepository::hasSentryException()
     *
     * @param array $exceptionBags
     * @param bool $expectedResult
     * @throws ReflectionException
     *
     * @dataProvider provideExceptionBags
     */
    public function testCanDetermineHasSentryException(array $exceptionBags, bool $expectedResult)
    {
        $class  = new SentryRepository();
        $method = TestHelpers::getInaccessibleMethod($class, 'hasSentryException');
        $sentryEvent = Event::createEvent();

        $sentryEvent->setExceptions($exceptionBags);

        $this->assertEquals($expectedResult, $method->invoke($class, $sentryEvent));
    }

    /** @see testCanDetermineHasSentryException */
    public function provideExceptionBags() : array
    {
        $this->mockWordPressTransients();

        return [
            [[new ExceptionDataBag(new RuntimeException())], false],
            [[new ExceptionDataBag(new BaseException('foo'))], false],
            [[new ExceptionDataBag(new SentryException('foo'))], true],
            [[
                new ExceptionDataBag(new BaseException('foo')),
                new ExceptionDataBag(new SentryException('foo'))
            ], true],
            [[
                new ExceptionDataBag(new BaseException('foo')),
                new ExceptionDataBag(new RuntimeException())
            ], false],
        ];
    }
}
