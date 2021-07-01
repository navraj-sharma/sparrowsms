<?php

namespace NavrajSharma\SparrowSMS;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery;
use PHPUnit\Framework\TestCase;

class SparrowSMSChannelTest extends TestCase
{
    /**
     * @var Notification|Mockery\MockInterface
     */
    protected $testNotification;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function it_can_be_instantiate()
    {
        $testConfig = [
            'token' => 'TEST_LOGIN',
            'from' => 'infoText',
            'api_endpoint' => 'http://api.sparrowsms.com/v2/',
            'sender' => 'TEST_SENDER',
            'debug' => true,
            'sandbox' => true,
        ];
        $instance = new SparrowSMSChannel($testConfig);

        $this->assertInstanceOf(SparrowSMSChannel::class, $instance);
    }

    /** @test */
    public function it_sends_a_notification()
    {
        $testConfig = [
            'token' => 'TEST_LOGIN',
            'from' => 'infoText',
            'api_endpoint' => 'http://api.sparrowsms.com/v2/',
            'sender' => 'TEST_SENDER',
            'debug' => true,
            'sandbox' => true,
        ];

        $testChannel = Mockery::mock(SparrowSMSChannel::class, [$testConfig])->makePartial()->shouldAllowMockingProtectedMethods();
        $this->assertIsArray($testChannel->send(new TestNotifiable(), new TestNotification()));
    }
}


class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForSparrowSMS()
    {
        return 'TEST_RECIPIENT';
    }
}

class TestNotification extends Notification
{
    public function toSparrowSMS($notifiable)
    {
        return new SparrowSMSMessage('TEST_BODY');
    }
}