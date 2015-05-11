Pigeon
===============
A more flexible email message builder for Laravel 5 including chained methods, reusable message type configurations, and email layout and template view management.

## Installation

Add `larablocks/pigeon` as a requirement to `composer.json`:

```javascript
{
    "require": {
        "larablocks/pigeon": "1.*"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

## Laravel Integration

To wire this up in your Laravel project you need to add the service provider. Open `app.php`, and add a new item to the providers array.

```php
'Larablocks\Pigeon\PigeonServiceProvider',
```

Then, add a Facade for more convenient usage. In your `app.php` config file add the following line to the `aliases` array:

```php
'Pigeon' => 'Larablocks\Pigeon\Pigeon',
```
Note: The facade will still load automatically if you wish to not add it to your `app.php`.

To publish the default config file to `config/pigeon.php` use the artisan command `vendor:publish --vendor=""`.



Define multiple entries in your `twilio` config to make use of this feature.

### Usage

Creating a Twilio object. This object implements the `Aloha\Twilio\TwilioInterface`.

```php
$twilio = new Aloha\Twilio\Twilio($accountId, $token, $fromNumber);
```

Sending a text message:

```php
$twilio->message('+18085551212', 'Pink Elephants and Happy Rainbows');
```

Creating a call:

```php
$twilio->call('+18085551212', 'http://foo.com/call.xml');
```

Generating a call and building the message in one go:

```php
$twilio->call('+18085551212', function ($message) {
    $message->say('Hello');
    $message->play('https://api.twilio.com/cowbell.mp3', ['loop' => 5]);
});
```

Generating TwiML:

```php
$twiml = $twilio->twiml(function($message) {
    $message->say('Hello');
    $message->play('https://api.twilio.com/cowbell.mp3', array('loop' => 5));
});

print $twiml;
```

### License

Pigeon is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)