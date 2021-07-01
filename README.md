# SparrowSMS Notifications Channel for Laravel

This package makes it easy to send notifications using [SparrowSMS](https://sparrowsms.readthedocs.io) with Laravel 5.5+, 6.0 and 7.0

## Contents

- [Installation](#installation)
	- [Setting up the SparrowSMS service](#setting-up-the-SparrowSMS-service)
- [Usage](#usage)
	- [ On-Demand Notifications](#on-demand-notifications)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:
``` bash
composer require navraj/sparrowsms
```

### Setting up the SparrowSMS service

Add your SparrowSMS configurations to your config/sparrowsms.php:

```php
// config/sparrowsms.php
...
    return [
    'token' => env('SPARROWSMS_TOKEN'), 
    'from' => env('SPARROWSMS_FROM'),
    'api_endpoint' => env('SPARROWSMS_API_ENDPOINT', 'http://api.sparrowsms.com/v2/'),
    'sanndbox' =>  env('SPARROWSMS_SANDBOX', false),
    
    'methods' => [
        'send' => 'sms/',
        'credit' => 'credit/'
    ],

    'debug' =>  env('APP_DEBUG', false),
]
...
```

## Usage

You can use the channel in your via() method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NavrajSharma\SparrowSMS\SparrowSMSMessage;

class SendSMS extends Notification
{
    public function via($notifiable)
    {
        return ["sparrowsms"];
    }

    public function toSparrowSMS($notifiable)
    {
        return (new SparrowSMSMessage("SMS Sent Via SparrowSMS Service"));       
    }
}
```

In your notifiable model, make sure to include a routeNotificationForSparrowSMS() method, which returns a phone number or an array of phone numbers.

```php
public function routeNotificationForSparrowSMS()
{
    return $this->mobile;
}
```

### On-Demand Notifications
Sometimes you may need to send a notification to someone who is not stored as a "user" of your application. Using the Notification::route method, you may specify ad-hoc notification routing information before sending the notification:

```php
Notification::route('sparrowsms', '9801110000')                      
            ->notify(new SendSMS());
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email info@navraj.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Niranjan Udas](https://github.com/niranjan)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
