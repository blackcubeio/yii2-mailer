<?php
/**
 * MailerTest.php
 *
 *  PHP Version 8.3+
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace tests\postmark;

use blackcube\mailer\postmark\Mailer;

/**
 * Test node basic functions
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class MailerTest extends TestCase
{

    public function setUp(): void
    {
        $this->mockApplication([
            'components' => [
                'email' => $this->createTestEmailComponent()
            ]
        ]);
    }

    protected function createTestEmailComponent(): Mailer
    {
        $component = new Mailer();
        $component->token = POSTMARK_TOKEN;
        return $component;
    }

    public function testGetPostmarkMailer(): void
    {
        $mailer = $this->createTestEmailComponent();
        $this->assertInstanceOf(Mailer::class, $mailer);
    }
}
