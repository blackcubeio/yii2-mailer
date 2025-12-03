<?php
/**
 * Message.php
 *
 * PHP Version 8.3+
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\mailer\mailjet;

use yii\base\NotSupportedException;
use yii\mail\BaseMessage;

/**
 * This component allow user to send an email
 *
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class
Message extends BaseMessage
{
    protected string|array|null $from = null;

    protected string|array|null $sender = null;

    protected array $to = [];

    protected string|array|null $replyTo = null;

    protected array $cc = [];

    protected array $bcc = [];

    protected ?string $subject = null;

    protected ?string $textBody = null;

    protected ?string $htmlBody = null;

    protected array $attachments = [];

    protected ?string $tag = null;

    protected string $trackOpens = 'account_default';

    protected string $trackClicks = 'account_default';

    protected array $headers = [];

    protected ?int $templateId = null;

    protected ?bool $templateLanguage = null;

    protected array $templateModel = [];

    protected bool $inlineCss = true;

    protected string $charset = 'utf-8';

    /**
     * {@inheritdoc}
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * {@inheritdoc}
     */
    public function setCharset($charset): never
    {
        throw new NotSupportedException();
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom(): ?string
    {
        return self::stringifyEmails($this->from);
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($from): static
    {
        $this->from = $from;
        return $this;
    }

    public function getSender(): string|array|null
    {
        return $this->sender;
    }

    public function setSender(string|array $sender): static
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * {@inheritdoc}
     */
    public function setTo($to): static
    {
        if (is_string($to) === true) {
            $to = [$to];
        }
        $this->to = $to;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReplyTo(): ?string
    {
        return self::stringifyEmails($this->replyTo);
    }

    /**
     * {@inheritdoc}
     */
    public function setReplyTo($replyTo): static
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * {@inheritdoc}
     */
    public function setCc($cc): static
    {
        if (is_string($cc) === true) {
            $cc = [$cc];
        }
        $this->cc = $cc;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    /**
     * {@inheritdoc}
     */
    public function setBcc($bcc): static
    {
        if (is_string($bcc) === true) {
            $bcc = [$bcc];
        }
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function getTextBody(): ?string
    {
        return $this->textBody;
    }

    /**
     * {@inheritdoc}
     */
    public function setTextBody($text): static
    {
        $this->textBody = $text;
        return $this;
    }

    public function getHtmlBody(): ?string
    {
        return $this->htmlBody;
    }

    /**
     * {@inheritdoc}
     */
    public function setHtmlBody($html): static
    {
        $this->htmlBody = $html;
        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;
        return $this;
    }

    public function setTrackOpens(string $trackOpens): static
    {
        $this->trackOpens = $trackOpens;
        return $this;
    }

    public function getTrackOpens(): string
    {
        return $this->trackOpens;
    }

    public function setTrackClicks(string $trackClicks): static
    {
        $this->trackClicks = $trackClicks;
        return $this;
    }

    public function getTrackClicks(): string
    {
        return $this->trackClicks;
    }

    public function setTemplateId(int $templateId): static
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function getTemplateId(): ?int
    {
        return $this->templateId;
    }

    public function setTemplateLanguage(bool $processLanguage): static
    {
        $this->templateLanguage = $processLanguage;
        return $this;
    }

    public function getTemplateLanguage(): ?bool
    {
        return $this->templateLanguage;
    }

    public function setTemplateModel(array $templateModel): static
    {
        $this->templateModel = $templateModel;
        if (empty($this->templateModel) === false) {
            $this->templateLanguage = true;
        }
        return $this;
    }

    public function getTemplateModel(): array
    {
        return $this->templateModel;
    }

    public function setInlineCss(bool $inlineCss): static
    {
        $this->inlineCss = $inlineCss;
        return $this;
    }

    public function getInlineCss(): bool
    {
        return $this->inlineCss;
    }

    public function addHeader(string $headerName, string $headerValue): static
    {
        $this->headers[$headerName] = $headerValue;
        return $this;
    }

    public function getHeaders(): array
    {
        return empty($this->headers) ? [] : $this->headers;
    }

    public function getAttachments(): ?array
    {
        if (empty($this->attachments) === true) {
            return null;
        } else {
            $attachments = array_map(function($attachment) {
                $item = [
                    'ContentType' => $attachment['ContentType'],
                    'Filename' => $attachment['Name'],
                    'Base64Content' => $attachment['Content'],
                ];
                if (isset($attachment['ContentID']) === true) {
                    $item['ContentID'] = $attachment['ContentID'];
                }
                return $item;
            }, $this->attachments);
            return $attachments;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attach($fileName, array $options = []): static
    {
        $attachment = [
            'Content' => base64_encode(file_get_contents($fileName))
        ];
        if (!empty($options['fileName'])) {
            $attachment['Name'] = $options['fileName'];
        } else {
            $attachment['Name'] = pathinfo($fileName, PATHINFO_BASENAME);
        }
        if (!empty($options['contentType'])) {
            $attachment['ContentType'] = $options['contentType'];
        } else {
            $attachment['ContentType'] = 'application/octet-stream';
        }
        $this->attachments[] = $attachment;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function attachContent($content, array $options = []): static
    {
        $attachment = [
            'Content' => base64_encode($content)
        ];
        if (!empty($options['fileName'])) {
            $attachment['Name'] = $options['fileName'];
        } else {
            throw new \InvalidArgumentException('Filename is missing');
        }
        if (!empty($options['contentType'])) {
            $attachment['ContentType'] = $options['contentType'];
        } else {
            $attachment['ContentType'] = 'application/octet-stream';
        }
        $this->attachments[] = $attachment;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function embed($fileName, array $options = []): string
    {
        $embed = [
            'Content' => base64_encode(file_get_contents($fileName))
        ];
        if (!empty($options['fileName'])) {
            $embed['Name'] = $options['fileName'];
        } else {
            $embed['Name'] = pathinfo($fileName, PATHINFO_BASENAME);
        }
        if (!empty($options['contentType'])) {
            $embed['ContentType'] = $options['contentType'];
        } else {
            $embed['ContentType'] = 'application/octet-stream';
        }
        $embed['ContentID'] = 'cid:' . uniqid();
        $this->attachments[] = $embed;
        return $embed['ContentID'];
    }

    /**
     * {@inheritdoc}
     */
    public function embedContent($content, array $options = []): string
    {
        $embed = [
            'Content' => base64_encode($content)
        ];
        if (!empty($options['fileName'])) {
            $embed['Name'] = $options['fileName'];
        } else {
            throw new \InvalidArgumentException('Filename is missing');
        }
        if (!empty($options['contentType'])) {
            $embed['ContentType'] = $options['contentType'];
        } else {
            $embed['ContentType'] = 'application/octet-stream';
        }
        $embed['ContentID'] = 'cid:' . uniqid();
        $this->attachments[] = $embed;
        return $embed['ContentID'];
    }

    /**
     * {@inheritdoc}
     * @todo make real serialization to make message compliant with MailjetAPI
     */
    public function toString(): string
    {
        return serialize($this);
    }


    public static function stringifyEmails(string|array|null $emailsData): ?string
    {
        $emails = null;
        if (empty($emailsData) === false) {
            if (is_array($emailsData) === true) {
                foreach ($emailsData as $key => $email) {
                    if (is_int($key) === true) {
                        $emails[] = $email;
                    } else {
                        if (preg_match('/[.,:]/', $email) > 0) {
                            $email = '"'. $email .'"';
                        }
                        $emails[] = $email . ' ' . '<' . $key . '>';
                    }
                }
                $emails = implode(', ', $emails);
            } elseif (is_string($emailsData) === true) {
                $emails = $emailsData;
            }
        }
        return $emails;
    }

    public static function convertEmails(string|array|null $emailsData): array
    {
        $emails = [];
        if (empty($emailsData) === false) {
            if (is_array($emailsData) === true) {
                foreach ($emailsData as $key => $email) {
                    if (is_int($key) === true) {
                        $emails[] = [
                            'Email' => $email,
                        ];
                    } else {
                        /*if (preg_match('/[.,:]/', $email) > 0) {
                            $email = '"'. $email .'"';
                        }*/
                        $emails[] = [
                            'Email' => $key,
                            'Name' => $email,
                        ];
                    }
                }
            } elseif (is_string($emailsData) === true) {
                // "Test, Le" <email@plop.com>
                if (preg_match('/"([^"]+)"\s<([^>]+)>/', $emailsData, $matches) > 0) {
                    $emails[] = [
                        'Email' => $matches[2],
                        'Name' => $matches[1],
                    ];
                } else {
                    $emails[] = [
                        'Email' => $emailsData,
                    ];
                }
            }
        }
        return $emails;
    }
}