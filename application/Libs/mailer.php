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

        //set template
        if (!empty($data) && property_exists($data, 'template')) {
            $templateFile = $data->template;
        } else {
            $templateFile = "default";
        }

        ob_start();
        include(APP . "view/templates/mail/" . $templateFile . ".php");
        $msg_template = ob_get_clean();

        $replacementsFrom = array('{{ message }}', '{{ logo }}');
        $replacementsTo = array($msg, Url::get_host().'/img/holzschmiede-logo.png');
        $message->setBody(str_replace($replacementsFrom, $replacementsTo, $msg_template), 'text/html');
        $message->addPart($msg, 'text/plain');

        //set mail meta
        if(property_exists($data, 'from')) {
            $message->setFrom($data->from); //from coule be array or string, e.g. ['john@doe.com' => 'John Doe'] or 'john@doe.com
        }
        else {
            $message->setFrom(EMAIL_FROM);
        }
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
            $message->attach(\Swift_Attachment::fromPath($data->attach));
        }
        $mailer->send($message);
        return true;
    }
}
