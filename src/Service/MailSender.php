<?php
namespace App\Service;

class MailSender
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->setMailer($mailer);
    }

    public function sendMail($senderName, $senderMail, $content)
    {
        $message = new \Swift_Message($senderName . ' cherche à te joindre');
        $message->setSender($senderMail, $senderName)
            ->setReplyTo($senderMail, $senderName)
            ->setTo(['contact@bertrandmalfray.fr' => 'Bertrand Malfray'])
            ->setBody($this->buildBody($senderName, $senderMail, $content));

        $mailer = $this->getMailer();

        $mailer->send($message);
    }

    private function buildBody($senderName, $senderMail, $content)
    {
        return "
Nom : {$senderName}
Mail: {$senderMail}


Contenu: \"{$content}\"
                    ";
    }

    /**
     * @return \Swift_Mailer
     */
    public function getMailer(): \Swift_Mailer
    {
        return $this->mailer;
    }

    /**
     * @param \Swift_Mailer $mailer
     */
    public function setMailer(\Swift_Mailer $mailer): void
    {
        $this->mailer = $mailer;
    }


}