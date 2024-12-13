Mailjet Yii2 integration
=========================
[![Release](https://code.redcat.io/blackcube/yii2-mailjet/-/badges/release.svg)](https://code.redcat.io/blackcube/yii2-mailjet/-/releases)
[![Pipeline](https://code.redcat.io/blackcube/yii2-mailjet/badges/devel/pipeline.svg)](https://code.redcat.io/blackcube/yii2-mailjet/-/pipelines)

[![État de la Barrière Qualité](https://sonarqube.redcat.io/api/project_badges/measure?project=Mailjet&metric=alert_status&token=sqb_d6f644043dc6c1fbfd4006a57d466c22852ab8c0)](https://sonarqube.redcat.io/dashboard?id=Mailjet)
[![Couverture (TU)](https://sonarqube.redcat.io/api/project_badges/measure?project=Mailjet&metric=coverage&token=sqb_d6f644043dc6c1fbfd4006a57d466c22852ab8c0)](https://sonarqube.redcat.io/dashboard?id=Mailjet)
[![Maintenabilité](https://sonarqube.redcat.io/api/project_badges/measure?project=Mailjet&metric=sqale_rating&token=sqb_d6f644043dc6c1fbfd4006a57d466c22852ab8c0)](https://sonarqube.redcat.io/dashboard?id=Mailjet)
[![Fiabilité](https://sonarqube.redcat.io/api/project_badges/measure?project=Mailjet&metric=reliability_rating&token=sqb_d6f644043dc6c1fbfd4006a57d466c22852ab8c0)](https://sonarqube.redcat.io/dashboard?id=Mailjet)
[![Sécurité](https://sonarqube.redcat.io/api/project_badges/measure?project=Mailjet&metric=security_rating&token=sqb_d6f644043dc6c1fbfd4006a57d466c22852ab8c0)](https://sonarqube.redcat.io/dashboard?id=Mailjet)
[![Dette Technique](https://sonarqube.redcat.io/api/project_badges/measure?project=Mailjet&metric=sqale_index&token=sqb_d6f644043dc6c1fbfd4006a57d466c22852ab8c0)](https://sonarqube.redcat.io/dashboard?id=Mailjet)


This extension allow the developper to use [Mailjet](https://www.mailjet.com/) as an email transport.


Installation
------------

If you use Packagist for installing packages, then you can update your composer.json like this :

``` json
{
    "require": {
        "blackcube/yii2-mailjet": "*"
    }
}
```

Howto use it
------------

Add extension to your configuration

``` php
return [
    //....
    'components' => [
        'mailer' => [
            'class' => 'blackcube\mailjet\Mailer',
            'token' => '<your mailjet token>',
        ],
    ],
];
```

You can send email as follow (using mailjet templates)

``` php
Yii::$app->mailer->compose('contact/html')
     ->setFrom('from@domain.com')
     ->setTo($form->email)
     ->setSubject($form->subject)
     ->setTemplateId(12345)
     ->setTemplateModel([
         'firstname' => $form->firstname,
         'lastname' => $form->lastname,
     ->send();

```

For further instructions refer to the [related section in the Yii Definitive Guide](http://www.yiiframework.com/doc-2.0/guide-tutorial-mailing.html)


Running the tests
-----------------

Before running the tests, you should edit the file tests/_bootstrap.php and change the defines :

``` php
// ...
define('MAILJET_FROM', '<sender>');
define('MAILJET_KEY', '<key>');
define('MAILJET_SECRET', '<secret>');
define('MAILJET_TO', '<target>');
define('MAILJET_TEMPLATE', 218932);

define('MAILJET_TEST_SEND', false);
// ...

```

to match your [Mailjet](https://www.mailjet.com/) configuration.

Contributing
------------

All code contributions - including those of people having commit access -
must go through a pull request and approved by a core developer before being
merged. This is to ensure proper review of all the code.

Fork the project, create a [feature branch ](http://nvie.com/posts/a-successful-git-branching-model/), and send us a pull request.