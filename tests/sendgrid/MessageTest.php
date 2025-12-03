<?php
/**
 * MessageTest.php
 *
 * PHP Version 8.3+
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace tests\sendgrid;

use blackcube\mailer\sendgrid\Mailer;
use blackcube\mailer\sendgrid\Message;
use Yii;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;

/**
 * Test message functions
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class MessageTest extends TestCase
{
    public function setUp(): void
    {
        $this->mockApplication([
            'components' => [
                'email' => $this->createTestEmailComponent()
            ]
        ]);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    protected function createTestEmailComponent(): Mailer
    {
        $component = new Mailer([
            'token' => SENDGRID_KEY
        ]);
        return $component;
    }

    protected function createTestMessage(): Message
    {
        return Yii::$app->get('mailer')->compose();
    }

    public function testMailerConfigured(): void
    {
        $mailComponent = $this->createTestEmailComponent();
        $this->assertNotNull($mailComponent->token);
    }

    public function testGetSendgridMessage(): void
    {
        $message = new Message();
        $this->assertInstanceOf(Message::class, $message);
    }

    public function testSetCharsetException(): void
    {
        $message = new Message();
        $this->expectException(NotSupportedException::class);
        $message->setCharset('utf-8');
    }

    public function testGetCharsetException(): void
    {
        $message = new Message();
        $this->expectException(NotSupportedException::class);
        $charset = $message->getCharset();
    }

    public function testGettersSetters(): void
    {
        $message = new Message();
        $message->setFrom('test@email.com');
        $this->assertEquals('test@email.com', $message->getFrom());

        $message->setTo('test@email.com');
        $this->assertIsArray($message->getTo());

        $message->setSubject('Subject');
        $this->assertEquals('Subject', $message->getSubject());

        $message->setTextBody('Body stuff');
        $this->assertEquals('Body stuff', $message->getTextBody());

        $message->setHtmlBody('Body stuff');
        $this->assertEquals('Body stuff', $message->getHtmlBody());

        $message->setTemplateId('d-xxxxx');
        $this->assertEquals('d-xxxxx', $message->getTemplateId());

        $message->setTemplateModel(['a' => 'b']);
        $this->assertArrayHasKey('{a}', $message->getTemplateModel());
        $this->assertEquals(['b'], $message->getTemplateModel()['{a}']);
    }

    public function testAttachException(): void
    {
        $message = new Message();
        $this->expectException(InvalidParamException::class);
        $message->attachContent('plop');
    }

    public function testEmbedException(): void
    {
        $message = new Message();
        $this->expectException(InvalidParamException::class);
        $message->embedContent('plop');
    }

    public function testBasicSend(): void
    {
        if (SENDGRID_TEST_SEND === true) {
            $message = $this->createTestMessage();
            $message->setFrom(SENDGRID_FROM);
            $message->setTo(SENDGRID_TO);
            $message->setSubject('Yii sendgrid test message');
            $message->setTextBody('Yii sendgrid test body');
            $this->assertTrue($message->send());
        }
    }

    public function testTemplateSend(): void
    {
        if (SENDGRID_TEST_SEND === true) {
            $message = $this->createTestMessage();
            $message->setFrom(SENDGRID_FROM)
                ->setTo(SENDGRID_TO)
                ->setTemplateId(SENDGRID_TEMPLATE)
                ->setTemplateModel([
                    'templateName' => 'test',
                    'userName' => 'Mr test'
                ]);
            $this->assertTrue($message->send());
        }
    }
}
