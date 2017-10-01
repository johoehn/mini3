<?php

namespace Mini\Libs;

use \Mini;

class Mailer
{
    public static function send_mail($to, $subject, $msg, $data)
    {
        $transport = (new \Swift_SmtpTransport(SMTP_HOST, SMTP_PORT))
            ->setUsername(SMTP_USERNAME)
            ->setPassword(SMTP_PASSWORD);
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message($subject));
        $message->setTo($to);
        $message->setFrom($data->from); //from coule be array or string, e.g. ['john@doe.com' => 'John Doe'] or 'john@doe.com

        //set template
        if (!empty($data) && property_exists($data, 'template')) {
            $templateFile = $data->template;
        } else {
            $templateFile = "default";
        }
        ob_start();
        include(ROOT . "assets/templates/mail/" . $templateFile . ".php");
        $replacementsFrom = array('{{message}}', '{{logo}}');
        $replacementsTo = array($msg, 'path/to/logo.png');
        $message->setBody(str_replace($replacementsFrom, $replacementsTo, ob_get_clean()), 'text/html');
        $message->addPart($msg, 'text/plain');


        //set mail meta
        if (property_exists($data, 'cc')) {
            $message->setCc($data->cc);
        }
        if (property_exists($data, 'bcc')) {
            $message->setBcc($data->bcc);
        }
        if (property_exists($data, 'replyto')) {
            $message->setReplyTo($data->replyto);
        }
        if (property_exists($data, 'attach')) {
            //https://swiftmailer.symfony.com/docs/messages.html
            $message->attach(\Swift_Attachment::fromPath('/path/to/image.jpg'));
        }

        return $mailer->send($message);
    }
}
