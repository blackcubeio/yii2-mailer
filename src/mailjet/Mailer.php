<?php
/**
 * Mailer.php
 *
 *  PHP Version 8.3+
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\mailer\mailjet;


use Mailjet\Client;
use Mailjet\Resources;
use yii\base\InvalidConfigException;
use yii\mail\BaseMailer;
use Exception;

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
    public ?string $apiKey = null;

    public ?string $apiSecret = null;

    public bool $enable = true;

    public string $apiVersion = 'v3.1';

    public ?string $apiUrl = null;

    public bool $secured = true;

    /**
     * @inheritdoc
     */
    public $messageClass = Message::class;
    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    protected function sendMessage($message): bool
    {
        try {
            if ($this->apiKey === null) {
                throw new InvalidConfigException('API Key is missing');
            }
            if ($this->apiSecret === null) {
                throw new InvalidConfigException('API Secret is missing');
            }
            $settings = [
                'secured' => $this->secured,
                'version' => $this->apiVersion,
            ];

            if ($this->apiUrl !== null) {
                $settings['url'] = $this->apiUrl;
            }

            $client = new Client($this->apiKey, $this->apiSecret, $this->enable, $settings);

            $fromEmails = Message::convertEmails($message->getFrom());
            $toEmails = Message::convertEmails($message->getTo());

            $mailJetMessage = [
                // 'FromEmail' => $fromEmails[0]['Email'],
                'From' => $fromEmails[0],
                'To' => $toEmails,
            ];
            /*
            if (isset($fromEmails[0]['Name']) === true) {
                $mailJetMessage['FromName'] = $fromEmails[0]['Name'];
            }
            */

            /*
            $sender = $message->getSender();
            if (empty($sender) === false) {
                $sender = Message::convertEmails($sender);
                $mailJetMessage['Sender'] = $sender[0];
            }
            */


            $cc = $message->getCc();
            if (empty($cc) === false) {
                $cc = Message::convertEmails($cc);
                $mailJetMessage['Cc'] = $cc;
            }

            $bcc = $message->getBcc();
            if (empty($bcc) === false) {
                $bcc = Message::convertEmails($bcc);
                $mailJetMessage['Bcc'] = $bcc;
            }

            $attachments = $message->getAttachments();
            if ($attachments !== null) {
                $mailJetMessage['Attachments'] = $attachments;
            }

            $headers = $message->getHeaders();
            if (empty($headers) === false) {
                $mailJetMessage['Headers'] = $headers;
            }
            $mailJetMessage['TrackOpens'] = $message->getTrackOpens();
            $mailJetMessage['TrackClicks'] = $message->getTrackClicks();

            $templateModel = $message->getTemplateModel();
            if (empty($templateModel) === false) {
                $mailJetMessage['Variables'] = $templateModel;
            }

            $templateId = $message->getTemplateId();
            if ($templateId === null) {
                $mailJetMessage['Subject'] = $message->getSubject();
                $textBody = $message->getTextBody();
                if (empty($textBody) === false) {
                    $mailJetMessage['TextPart'] = $textBody;
                }
                $htmlBody = $message->getHtmlBody();
                if (empty($htmlBody) === false) {
                    $mailJetMessage['HTMLPart'] = $htmlBody;
                }
                $sendResult = $client->post(Resources::$Email, [
                    'body' => [
                        'Messages' => [
                            $mailJetMessage,
                        ]
                    ]
                ]);
            } else {
                $mailJetMessage['TemplateID'] = $templateId;
                $processLanguage = $message->getTemplateLanguage();
                if ($processLanguage === true) {
                    $mailJetMessage['TemplateLanguage'] = $processLanguage;
                }
                $sendResult = $client->post(Resources::$Email, [
                    'body' => [
                        'Messages' => [
                            $mailJetMessage,
                        ]
                    ]
                ]);
            }
            //TODO: handle error codes and log stuff
            return $sendResult->success();
        } catch (Exception $e) {
            throw $e;
        }
    }



}