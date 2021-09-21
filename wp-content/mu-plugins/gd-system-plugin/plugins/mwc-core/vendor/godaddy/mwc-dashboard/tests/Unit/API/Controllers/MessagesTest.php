<?php

namespace GoDaddy\WordPress\MWC\Dashboard\Tests\Unit\API\Controllers;

use DateTime;
use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Tests\TestHelpers;
use GoDaddy\WordPress\MWC\Common\Tests\WPTestCase;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages;
use GoDaddy\WordPress\MWC\Dashboard\Message\Message;
use GoDaddy\WordPress\MWC\Dashboard\Message\MessageStatus;
use GoDaddy\WordPress\MWC\Dashboard\Tests\TestHelpers as DashboardTestHelpers;
use Mockery;
use Mockery\MockInterface;
use ReflectionException;
use WP_Mock;
use WP_REST_Request;

/**
 * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages
 */
final class MessagesTest extends WPTestCase
{
    /**
     * Tests the constructor.
     *
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::__construct()
     *
     * @throws ReflectionException
     */
    public function testConstructor()
    {
        $controller = new Messages();
        $route = TestHelpers::getInaccessibleProperty($controller, 'route');
        $this->assertSame('messages', $route->getValue($controller));
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::registerRoutes()
     */
    public function testCanRegisterRoutes()
    {
        WP_Mock::userFunction('__');

        WP_Mock::userFunction('register_rest_route', ['times' => 1])
            ->with('godaddy/mwc/v1', '/messages', Mockery::any());

        WP_Mock::userFunction('register_rest_route', ['times' => 1])
            ->with('godaddy/mwc/v1', '/messages/bulk', Mockery::any());

        WP_Mock::userFunction('register_rest_route', ['times' => 2])
            ->with('godaddy/mwc/v1', '/messages/(?P<id>[a-zA-Z0-9-]+)', Mockery::any());

        WP_Mock::userFunction('register_rest_route', ['times' => 2])
            ->with('godaddy/mwc/v1', '/messages/opt-in', Mockery::any());

        (new Messages)->registerRoutes();

        $this->assertConditionsMet();
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::optIn()
     */
    public function testCanOptIn()
    {
        $userId = 1;
        WP_Mock::userFunction('sanitize_text_field')->andReturnArg(0);

        // set the current user for the test
        DashboardTestHelpers::mockWordPressRepositoryUser(DashboardTestHelpers::getMockWordPressUser($userId));

        // let's make sure the method returns the result of calling rest_ensure_response()
        $response = (object) ['response' => true];

        WP_Mock::userFunction('rest_ensure_response')
            ->with([
                'userId' => $userId,
                'optedIn' => true,
            ])
            ->andReturn($response);

        DashboardTestHelpers::mockUserMetaDoesNotExists($userId, '_mwc_dashboard_messages_opted_in');
        DashboardTestHelpers::expectUserMetaSaved($userId, '_mwc_dashboard_messages_opted_in', true);

        $this->assertSame($response, (new Messages())->optIn());
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::getItems()
     */
    public function testCanGetItems()
    {
        $message = Mockery::mock(Message::class);
        $expiredMessage = Mockery::mock(Message::class);
        $deletedMessage = Mockery::mock(Message::class);
        $deletedMessageStatus = Mockery::mock(MessageStatus::class);
        $messageStatus = Mockery::mock(MessageStatus::class);

        $messageStatus->shouldReceive('isDeleted')->andReturnFalse();
        $deletedMessageStatus->shouldReceive('isDeleted')->andReturnTrue();

        $message->shouldReceive([
            'getId' => 'test-message',
            'isExpired' => false,
            'status' => $messageStatus,
        ]);

        $expiredMessage->shouldReceive([
            'getId' => 'expired-message',
            'isExpired' => true,
            'status' => $messageStatus,
        ]);

        $deletedMessage->shouldReceive([
            'getId' => 'deleted-message',
            'isExpired' => false,
            'status' => $deletedMessageStatus,
        ]);

        /** @var Messages|MockInterface */
        $controller = Mockery::mock(Messages::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $controller->shouldReceive('getItems')->once()->andReturn(
            ['messages' => [$message, $expiredMessage, $deletedMessage]]
        );

        WP_Mock::passthruFunction('rest_ensure_response');
        /** @var Message[] because rest_ensure_response() will pass through the array of messages */
        $items = ArrayHelper::get($controller->getItems(), 'messages');

        $this->assertIsArray($items);
        $this->assertCount(3, $items);
        $this->assertContainsOnlyInstancesOf(Message::class, $items);
        $this->assertSame($message->getId(), current($items)->getId());
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::removeExpiredMessages()
     * @throws ReflectionException
     */
    public function testCanRemoveExpiredMessages()
    {
        /** @var Messages|MockInterface */
        $controller = Mockery::mock(Messages::class)
                             ->makePartial()
                             ->shouldAllowMockingProtectedMethods();

        $message = Mockery::mock(Message::class);
        $expiredMessage = Mockery::mock(Message::class);
        $deletedMessage = Mockery::mock(Message::class);

        $deletedMessageStatus = Mockery::mock(MessageStatus::class);
        $messageStatus = Mockery::mock(MessageStatus::class);

        $messageStatus->shouldReceive('isDeleted')->andReturnFalse();
        $deletedMessageStatus->shouldReceive('isDeleted')->andReturnTrue();

        $message->shouldReceive([
            'getId' => 'test-message',
            'isExpired' => false,
            'status' => $messageStatus,
        ]);

        $expiredMessage->shouldReceive([
            'getId' => 'expired-message',
            'isExpired' => true,
            'status' => $messageStatus,
        ]);

        $deletedMessage->shouldReceive([
            'getId' => 'deleted-message',
            'isExpired' => false,
            'status' => $deletedMessageStatus,
        ]);

        $method = TestHelpers::getInaccessibleMethod(Messages::class, 'removeExpiredMessages');

        $allMessages = [$message, $expiredMessage, $deletedMessage];
        $messages = $method->invokeArgs($controller, [$allMessages]);

        $this->assertIsArray($messages);
        $this->assertCount(2, $messages);
        $this->assertContainsOnlyInstancesOf(Message::class, $messages);
        $this->assertEquals([$message, $deletedMessage], array_values($messages));
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::removeDeletedMessages()
     * @throws ReflectionException
     */
    public function testCanRemoveDeletedMessages()
    {
        /** @var Messages|MockInterface */
        $controller = Mockery::mock(Messages::class)
                             ->makePartial()
                             ->shouldAllowMockingProtectedMethods();

        $message = Mockery::mock(Message::class);
        $expiredMessage = Mockery::mock(Message::class);
        $deletedMessage = Mockery::mock(Message::class);

        $deletedMessageStatus = Mockery::mock(MessageStatus::class);
        $messageStatus = Mockery::mock(MessageStatus::class);

        $messageStatus->shouldReceive('isDeleted')->andReturnFalse();
        $deletedMessageStatus->shouldReceive('isDeleted')->andReturnTrue();

        $message->shouldReceive([
            'getId' => 'test-message',
            'isExpired' => false,
            'status' => $messageStatus,
        ]);

        $expiredMessage->shouldReceive([
            'getId' => 'expired-message',
            'isExpired' => true,
            'status' => $messageStatus,
        ]);

        $deletedMessage->shouldReceive([
            'getId' => 'deleted-message',
            'isExpired' => false,
            'status' => $deletedMessageStatus,
        ]);

        $method = TestHelpers::getInaccessibleMethod(Messages::class, 'removeDeletedMessages');

        $allMessages = [$message, $expiredMessage, $deletedMessage];
        $messages = $method->invokeArgs($controller, [$allMessages]);

        $this->assertIsArray($messages);
        $this->assertCount(2, $messages);
        $this->assertContainsOnlyInstancesOf(Message::class, $messages);
        $this->assertEquals([$message, $expiredMessage], array_values($messages));
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::getAllMessages()
     * @throws ReflectionException
     */
    public function testCanGetAllMessages()
    {
        /** @var Messages|MockInterface */
        $controller = Mockery::mock(Messages::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $controller->shouldReceive('getMessagesData')
            ->once()
            ->andReturn($this->getTestMessagesData());

        $method = TestHelpers::getInaccessibleMethod(Messages::class, 'getAllMessages');

        $messages = $method->invoke($controller);

        $this->assertCount(1, $messages);
        $this->assertContainsOnlyInstancesOf(Message::class, $messages);
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::getMessagesData()
     * @throws ReflectionException
     * @throws Exception
     */
    public function testCanGetMessagesData()
    {
        $url = 'https://example.org/messages';

        Configuration::set('messages.api.url', $url);

        $data = ['messages' => $this->getTestMessagesData()];

        $this->mockWordPressRequestFunctionsWithArgs([
            'url' => $url,
            'response' => [
                'code' => 200,
                'body' => $data,
            ],
        ]);

        $method = TestHelpers::getInaccessibleMethod(Messages::class, 'getMessagesData');

        $this->assertSame($data['messages'], $method->invoke((new Messages())));
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::getMessagesUrl()
     * @throws ReflectionException
     * @throws Exception
     */
    public function testCanGetMessageUrl()
    {
        $url = 'https://example.org/messages';

        Configuration::set('messages.api.url', $url);

        $method = TestHelpers::getInaccessibleMethod(Messages::class, 'getMessagesUrl');

        $this->assertSame($url, $method->invoke(new Messages()));
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::buildMessage()
     * @throws ReflectionException
     */
    public function testCanBuildMessage()
    {
        $method = TestHelpers::getInaccessibleMethod(Messages::class, 'buildMessage');

        $message = $method->invoke(new Messages(), ArrayHelper::get($this->getTestMessagesData(), 0));

        $this->assertInstanceOf(Message::class, $message);
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::getMatchingMessageById()
     * @throws ReflectionException
     */
    public function testCanGetMatchingMessageById()
    {
        $messages = new Messages();
        $buildMessageMethod = TestHelpers::getInaccessibleMethod(Messages::class, 'buildMessage');
        $getMatchMethod = TestHelpers::getInaccessibleMethod(Messages::class, 'getMatchingMessageById');

        $message = $buildMessageMethod->invoke($messages, ArrayHelper::get($this->getTestMessagesData(), 0));

        $this->assertInstanceOf(Message::class, $message);

        $this->assertSame($message, $getMatchMethod->invoke($messages, [$message], 'test-message'));
        $this->assertNull($getMatchMethod->invoke($messages, [$message], 'another-message'));
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::prepareItem()
     * @throws ReflectionException
     */
    public function testCanPrepareItem()
    {
        $messages = new Messages();
        $buildMessageMethod = TestHelpers::getInaccessibleMethod(Messages::class, 'buildMessage');
        $prepareItemMethod = TestHelpers::getInaccessibleMethod(Messages::class, 'prepareItem');

        $this->mockGetMessageStatus(1, 'test-message', MessageStatus::STATUS_DELETED);

        $message = $buildMessageMethod->invoke($messages, ArrayHelper::get($this->getTestMessagesData(), 0));
        $messageData = $prepareItemMethod->invoke($messages, $message);

        $this->assertIsArray($messageData);
        $this->assertArrayHasKey('id', $messageData);
        $this->assertArrayHasKey('status', $messageData);
    }

    /**
     * @param int    $userId
     * @param string $messageId
     * @param string $status
     */
    private function mockGetMessageStatus(int $userId, string $messageId, string $status)
    {
        TestHelpers::mockWordPressRepositoryUser(TestHelpers::getMockWordPressUser($userId));
        TestHelpers::mockUserMetaDoesExists($userId, '_mwc_dashboard_message_status_'.$messageId);
        WP_Mock::userFunction('get_user_meta')
            ->with($userId, '_mwc_dashboard_message_status_'.$messageId, true)
            ->andReturn($status);
    }

    /**
     * @param int    $userId
     * @param string $messageId
     * @param string $status
     */
    private function mockUpdateMessageStatus(int $userId, string $messageId, string $status)
    {
        DashboardTestHelpers::mockUserMetaDoesNotExists($userId, "_mwc_dashboard_message_status_{$messageId}");
        DashboardTestHelpers::expectUserMetaSaved($userId, "_mwc_dashboard_message_status_{$messageId}", $status);
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::updateItem()
     * @throws ReflectionException
     */
    public function testCanUpdateItem()
    {
        WP_Mock::userFunction('sanitize_text_field')->andReturnArg(0);

        $userId = 1;
        $messageId = 'test-message';
        $status = MessageStatus::STATUS_DELETED;

        $this->mockGetMessageStatus($userId, $messageId, $status);

        // mock the request parameters
        $request = Mockery::mock('WP_REST_Request');
        $request->shouldReceive('get_param')->with('id')->andReturn($messageId);
        $request->shouldReceive('get_param')->with('status')->andReturn($status);

        Configuration::set('messages.api.url', 'https://example.org/messages');

        /** @var Messages|MockInterface */
        $controller = Mockery::mock(Messages::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $controller->shouldReceive('getMessagesData')
            ->once()
            ->andReturn($this->getTestMessagesData());

        $this->mockUpdateMessageStatus($userId, $messageId, $status);

        $prepareItemMethod = TestHelpers::getInaccessibleMethod(Messages::class, 'prepareItem');
        $buildMessageMethod = TestHelpers::getInaccessibleMethod(Messages::class, 'buildMessage');

        // let's make sure the method returns the result of calling rest_ensure_response()
        $message = $prepareItemMethod->invoke(
            $controller,
            $buildMessageMethod->invoke($controller, ArrayHelper::get($this->getTestMessagesData(), 0))
        );

        WP_Mock::userFunction('rest_ensure_response')
            ->with($message)
            ->andReturn($message);

        $this->assertSame($message, $controller->updateItem($request));
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::deleteItem()
     */
    public function testCanDeleteItem()
    {
        $userId = '101';
        $messageId = '202';

        WP_Mock::userFunction('sanitize_text_field')->andReturnArg(0);

        // mocks the WordPress user
        $user = Mockery::mock('WP_User');
        $user->ID = $userId;

        DashboardTestHelpers::mockWordPressRepositoryUser($user);

        // mocks the request parameters
        $request = Mockery::mock('WP_REST_Request');
        $request->shouldReceive('get_param')->with('id')->andReturn($messageId);

        // mocks a WP_REST_Response object
        $expectedResponse = new class {
            public $status;

            public function set_status($status)
            {
                $this->status = $status;
            }
        };

        WP_Mock::userFunction('rest_ensure_response')
            ->with([
                'id' => $messageId,
                'status' => MessageStatus::STATUS_DELETED,
            ])
            ->andReturn($expectedResponse);

        DashboardTestHelpers::mockUserMetaDoesNotExists($userId, "_mwc_dashboard_message_status_{$messageId}");
        DashboardTestHelpers::expectUserMetaSaved($userId, "_mwc_dashboard_message_status_{$messageId}",
            MessageStatus::STATUS_DELETED);

        $response = (new Messages())->deleteItem($request);

        $this->assertSame($expectedResponse, $response);
        $this->assertEquals(204, $response->status);
    }

    /**
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::optOut
     */
    public function testCanOptOut()
    {
        $userId = 1;

        // set the current user for the test
        DashboardTestHelpers::mockWordPressRepositoryUser(DashboardTestHelpers::getMockWordPressUser($userId));

        // let's make sure the method returns the result of calling rest_ensure_response()
        $response = (object) ['response' => true];

        WP_Mock::userFunction('rest_ensure_response')
            ->with([
                'userId' => $userId,
                'optedIn' => false,
            ])
            ->andReturn($response);

        DashboardTestHelpers::mockUserMetaDoesNotExists($userId, '_mwc_dashboard_messages_opted_in');
        DashboardTestHelpers::expectUserMetaSaved($userId, '_mwc_dashboard_messages_opted_in', false);

        $this->assertSame($response, (new Messages())->optOut());
    }

    /**
     * Tests the getItemSchema() method.
     *
     * @covers \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::getItemSchema()
     */
    public function testGetItemSchema()
    {
        WP_Mock::userFunction('__');

        $controller = new Messages();

        $this->assertIsArray($controller->getItemSchema());
    }

    /**
     * @covers       \GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Messages::updateItems()
     *
     * @param string $userId user ID
     * @param array  $messageIds message IDs for the messages to update
     * @param string $status new message status
     *
     * @dataProvider provideUpdateItemsTestData
     */
    public function testCanUpdateItems(string $userId, array $messageIds, string $status)
    {
        WP_Mock::userFunction('sanitize_text_field')->andReturnArg(0);

        // set the current user for the test
        $user = Mockery::mock('WP_User');
        $user->ID = $userId;

        DashboardTestHelpers::mockWordPressRepositoryUser($user);

        // mock the request parameters
        $request = Mockery::mock('WP_REST_Request');
        $request->shouldReceive('get_param')->with('ids')->andReturn($messageIds);
        $request->shouldReceive('get_param')->with('status')->andReturn($status);

        // let's make sure the method returns the result of calling rest_ensure_response()
        $response = (object) ['response' => true];

        WP_Mock::userFunction('rest_ensure_response')
            ->with([
                'ids' => $messageIds,
                'status' => $status,
            ])
            ->andReturn($response);

        foreach ($messageIds as $messageId) {
            DashboardTestHelpers::mockUserMetaDoesNotExists($userId, "_mwc_dashboard_message_status_{$messageId}");
            DashboardTestHelpers::expectUserMetaSaved($userId, "_mwc_dashboard_message_status_{$messageId}", $status);
        }

        $this->assertSame($response, (new Messages())->updateItems($request));
    }

    /**
     * @see testCanUpdateItems()
     */
    public function provideUpdateItemsTestData() : array
    {
        return [
            ['101', ['123', '456'], MessageStatus::STATUS_UNREAD],
            ['101', ['123', '456'], MessageStatus::STATUS_READ],
            ['101', ['123', '456'], MessageStatus::STATUS_DELETED],
        ];
    }

    /**
     * Gets an array of messages data for testing.
     *
     * @return array
     */
    private function getTestMessagesData() : array
    {
        return [
            [
                'id' => 'test-message',
                'subject' => 'Test Message',
                'body' => 'This is clearly a test.',
                'publishedAt' => (new DateTime('yesterday'))->format(DATE_ATOM),
                'expiredAt' => (new DateTime('+1 week'))->format(DATE_ATOM),
                'actions' => [
                    [
                        'text' => 'Sign me up!',
                        'href' => 'https://example.org/sign-in',
                        'type' => 'button',
                    ],
                ],
                'rules' => [
                    [
                        'label' => 'WooCommerce version',
                        'name' => 'wcVersion',
                        'type' => 'version',
                        'rel' => 'system',
                        'comparator' => 'environment/version',
                        'operator' => 'greaterThan',
                        'value' => '4.2.0',
                    ],
                ],
                'links' => [],
            ],
        ];
    }
}
