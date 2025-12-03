Yii2 Mailer
===========

This extension allows the developer to use [Mailjet](https://www.mailjet.com/), [Postmark](https://postmarkapp.com/) or [SendGrid](https://sendgrid.com/) as an email transport.

[![License](https://poser.pugx.org/blackcube/yii2-mailer/license)](https://packagist.org/packages/blackcube/yii2-mailer)

Requirements
------------

- PHP 8.3+
- Yii2 2.0.x

Installation
------------

If you use Packagist for installing packages, then you can update your composer.json like this:

``` json
{
    "require": {
        "blackcube/yii2-mailer": "~2.0.0"
    }
}
```

Configuration
-------------

### Mailjet

``` php
return [
    //...
    'components' => [
        'mailer' => [
            'class' => blackcube\mailer\mailjet\Mailer::class,
            'apiKey' => '<your mailjet api key>',
            'apiSecret' => '<your mailjet api secret>',
        ],
    ],
];
```

### Postmark

``` php
return [
    //...
    'components' => [
        'mailer' => [
            'class' => blackcube\mailer\postmark\Mailer::class,
            'token' => '<your postmark server token>',
        ],
    ],
];
```

### SendGrid

``` php
return [
    //...
    'components' => [
        'mailer' => [
            'class' => blackcube\mailer\sendgrid\Mailer::class,
            'token' => '<your sendgrid api key>',
        ],
    ],
];
```

Usage
-----

### Send a simple email

``` php
Yii::$app->mailer->compose()
     ->setFrom('from@domain.com')
     ->setTo('to@domain.com')
     ->setSubject('Test email')
     ->setTextBody('This is the text body')
     ->setHtmlBody('<p>This is the <b>HTML</b> body</p>')
     ->send();
```

### Send an email using templates

``` php
Yii::$app->mailer->compose()
     ->setFrom('from@domain.com')
     ->setTo($form->email)
     ->setTemplateId(12345)
     ->setTemplateModel([
         'firstname' => $form->firstname,
         'lastname' => $form->lastname,
     ])
     ->send();
```

For further instructions refer to the [related section in the Yii Definitive Guide](https://www.yiiframework.com/doc-2.0/guide-tutorial-mailing.html)

Running the tests
-----------------

Before running the tests, you should edit the file `tests/_bootstrap.php` and configure the credentials for each service you want to test:

``` php
// Mailjet
define('MAILJET_FROM', '<sender>');
define('MAILJET_KEY', '<key>');
define('MAILJET_SECRET', '<secret>');
define('MAILJET_TO', '<target>');
define('MAILJET_TEMPLATE', 218932);
define('MAILJET_TEST_SEND', false);

// Postmark
define('POSTMARK_FROM', '<sender>');
define('POSTMARK_TOKEN', '<token>');
define('POSTMARK_TO', '<target>');
define('POSTMARK_TEMPLATE', 218932);
define('POSTMARK_TEST_SEND', false);

// SendGrid
define('SENDGRID_FROM', '<sender>');
define('SENDGRID_KEY', '<key>');
define('SENDGRID_TO', '<target>');
define('SENDGRID_TEMPLATE', 'd-xxxxxx');
define('SENDGRID_TEST_SEND', false);
```

Then run:

``` bash
# Run all tests
vendor/bin/codecept run

# Run tests for a specific provider
vendor/bin/codecept run mailjet
vendor/bin/codecept run postmark
vendor/bin/codecept run sendgrid
```

Contributing
------------

All code contributions - including those of people having commit access -
must go through a pull request and approved by a core developer before being
merged. This is to ensure proper review of all the code.

Fork the project, create a [feature branch](http://nvie.com/posts/a-successful-git-branching-model/), and send us a pull request.
