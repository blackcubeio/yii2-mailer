<?php
/**
 * MailerTest.php
 *
 * PHP Version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2024
 * @license https://www.blackcube.io/license license
 * @version XXX
 * @link https://www.blackcube.io
 * @package tests\unit
 */

namespace tests\unit;

use blackcube\mailjet\Mailer;

/**
 * Test node basic functions
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2024
 * @license https://www.blackcube.io/license license
 * @version XXX
 * @link https://www.blackcube.io
 * @package tests\unit
 * @since XXX
 */
class MailerTest extends TestCase
{

    public function setUp() :void
    {
        $this->mockApplication([
            'components' => [
                'email' => $this->createTestEmailComponent()
            ]
        ]);
    }

    protected function createTestEmailComponent()
    {
        $component = new Mailer();
        $component->apiKey = MAILJET_KEY;
        $component->apiSecret = MAILJET_SECRET;
        return $component;
    }

    public function testGetMailjetMailer()
    {
        $mailer = $this->createTestEmailComponent();
        $this->assertInstanceOf(Mailer::className(), $mailer);
    }
}
