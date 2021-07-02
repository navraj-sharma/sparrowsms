<?php

namespace NavrajSharma\SparrowSMS;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Exceptions\SparrowSMSError;

class SparrowSMSChannel
{


    /**
     * Token generated from sparrow sms website.
     *
     * @var string
     */
    protected $token;


    /**
     * It should be the identity provided by sparrow sms website.
     *
     * @var string
     */
    protected $from;


    /**
     * It should be the URL provided by sparrow sms website.
     *
     * @var string
     */
    protected $api_endpoint;

    protected $methods;
    /**
     * Debug flag. If true, messages send/result wil be stored in Laravel log.
     *
     * @var bool
     */

    protected $debug;


    protected $sandbox;


    public function __construct(array $config = [])
    {
        $this->token = Arr::get($config, 'token');
        $this->from = Arr::get($config, 'from');
        $this->api_endpoint = Arr::get($config, 'api_endpoint');
        $this->methods = Arr::get($config, 'methods');

        $this->debug = Arr::get($config, 'debug', false);
        $this->sandbox = Arr::get($config, 'sandbox', false);

    }


    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     *
     * @param Notification $notification
     * @return String
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {

        $url = $this->getSendUrl();
        $to = $notifiable->routeNotificationForSparrowSMS();

        $message = $notification->toSparrowSMS($notifiable);
        if (is_string($message)) {
            $message = new SparrowSMSMessage($message);
        }

        $sms = [
            'token' => $this->token,
            'from' => $this->from,
            'to' => $to,
            'text' => $message->body
        ];

        if ($this->debug) {
            Log::info('SparrowSMS sandbox '.print_r($this->sandbox, true));
            Log::info('SparrowSMS sending message to url '.print_r($url, true));
            Log::info('SparrowSMS sending message as '.print_r($sms, true));
        }

        if ($this->sandbox) {
            return;
        }

        try {

            $client = new Client();
            $request = $client->get( $url, [
                'query' => [
                    'token' => $this->token,
                    'from' => $this->from,
                    'to' => $this->sanitizeMobileNumber($to),
                    'text' => $message->body
                ],
                'http_errors' => true
            ]);

            $response = $request->getBody();

        }
        catch (ClientException $exception) {
            throw SparrowSMSError::SparrowSMSConnectionError($exception);
        }

        if ($this->debug) {
            Log::info('SparrowSMS sent result as '.print_r($response, true));
        }

        return $response;

    }



    protected function getSendUrl() {
        return $this->api_endpoint.$this->methods['send'];
    }

}
