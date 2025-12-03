<?php
/**
 * Mail.php
 *
 *   PHP Version 8.3+
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\mailer\postmark;


use Postmark\Models\PostmarkException;
use Postmark\PostmarkClient;
use yii\base\InvalidConfigException;
use yii\mail\BaseMailer;
use Yii;

/**
 * This component allow user to send an email
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 * @todo implement batch messages using API
 */
class Mailer extends BaseMailer
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $apiUri;

    /**
     * @var boolean
     */
    public $verifySsl;

    /**
     * @var int
     */
    public $timeOut = 30;
    /**
     * @inheritdoc
     */
    public $messageClass = Message::class;
    /**
     * @param Message $message
     * @since XXX
     * @throws InvalidConfigException
     */
    public function sendMessage($message)
    {
        try {
            if ($this->token === null) {
                throw new InvalidConfigException('Token is missing');
            }
            if ($this->apiUri !== null) {
                PostmarkClient::$BASE_URL = $this->apiUri;
            }
            if ($this->verifySsl !== null) {
                PostmarkClient::$VERIFY_SSL = $this->verifySsl;
            }
            $client = new PostmarkClient($this->token, $this->timeOut);
            $templateId = $message->getTemplateId();
            if ($templateId === null) {
                $sendResult = $client->sendEmail($message->getFrom(), $message->getTo(),
                    $message->getSubject(),
                    $message->getHtmlBody(), $message->getTextBody(),
                    $message->getTag(),
                    $message->getTrackOpens(),
                    $message->getReplyTo(),
                    $message->getCc(),
                    $message->getBcc(),
                    $message->getHeaders(),
                    $message->getAttachments()
                );
            } else {
                $sendResult = $client->sendEmailWithTemplate($message->getFrom(), $message->getTo(),
                    $message->getTemplateId(), $message->getTemplateModel(),
                    $message->getInlineCss(),
                    $message->getTag(),
                    $message->getTrackOpens(),
                    $message->getReplyTo(),
                    $message->getCc(),
                    $message->getBcc(),
                    $message->getHeaders(),
                    $message->getAttachments()
                );
            }
            //TODO: handle error codes and log stuff
            return isset($sendResult['ErrorCode']) ? ($sendResult['ErrorCode'] == 0) : false;
        } catch (PostmarkException $e) {
            throw $e;
        }
    }
}