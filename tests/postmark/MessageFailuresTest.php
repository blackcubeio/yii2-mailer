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

namespace tests\postmark;

use blackcube\mailer\postmark\Mailer;
use blackcube\mailer\postmark\Message;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Test message failures
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class MessageFailuresTest extends TestCase
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
        return new Mailer();
    }

    protected function createTestMessage(): Message
    {
        return $this->createTestEmailComponent()->compose();
    }

    public function testBasicSend(): void
    {
        $message = $this->createTestMessage();
        $message->setFrom(POSTMARK_FROM);
        $message->setTo(POSTMARK_TO);
        $message->setSubject('Yii postmark test message');
        $message->setTextBody('Yii postmark test body');
        $this->expectException(InvalidConfigException::class);
        $message->send();
    }

    public function testTemplateSend(): void
    {
        $message = $this->createTestMessage();
        $message->setFrom(POSTMARK_FROM)
            ->setTo(POSTMARK_TO)
            ->setTemplateId(POSTMARK_TEMPLATE)
            ->setTemplateModel([
                'templateName' => 'test',
                'userName' => 'Mr test'
            ]);
        $this->expectException(InvalidConfigException::class);
        $message->send();
    }
}
