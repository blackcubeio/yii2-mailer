<?php
/**
 * MailerTest.php
 *
 * PHP Version 8.3+
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace tests\mailjet;

use blackcube\mailer\mailjet\Mailer;

/**
 * Test basic functions
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class MailerTest extends TestCase
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

    protected function createTestEmailComponent(): Mailer
    {
        $component = new Mailer();
        $component->apiKey = constant('MAILJET_KEY');
        $component->apiSecret = constant('MAILJET_SECRET');
        return $component;
    }

    public function testGetMailjetMailer(): void
    {
        $mailer = $this->createTestEmailComponent();
        $this->assertInstanceOf(Mailer::class, $mailer);
    }
}
