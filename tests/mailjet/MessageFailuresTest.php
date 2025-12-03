<?php
/**
 * MessageFailuresTest.php
 *
 * PHP Version 8.3+
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace tests\mailjet;

use blackcube\mailer\mailjet\Mailer;
use blackcube\mailer\mailjet\Message;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Test node basic functions
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class MessageFailuresTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
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
        // create component with token
        $component = new Mailer([
        ]);
        return $component;
    }

    protected function getTestFilePath(): string
    {
        return Yii::getAlias('@test/runtime') . DIRECTORY_SEPARATOR . basename(get_class($this)) . '_' . getmypid();
    }

    protected function createTestMessage(): Message
    {
        return $this->createTestEmailComponent()->compose();
    }

    public function testBasicSend(): void
    {
        $message = $this->createTestMessage();
        $message->setFrom(MAILJET_FROM);
        $message->setTo(MAILJET_TO);
        $message->setSubject('Yii MailJet test message');
        $message->setTextBody('Yii MailJet test body');
        $this->expectException(InvalidConfigException::class);
        $message->send();
    }

    public function testTemplateSend(): void
    {
        $message = $this->createTestMessage();
        $message->setFrom(MAILJET_FROM)
            ->setTo(MAILJET_TO)
            ->setTemplateId(MAILJET_TEMPLATE)
            ->setTemplateModel([
                'templateName' => 'test',
                'userName' => 'Mr test'
            ]);
        $this->expectException(InvalidConfigException::class);
        $message->send();
    }
}
