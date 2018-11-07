<?php

namespace App\Services;


use App\Repository\InterimRepository;

class MailerService
{
    private $to = "vanessa.fayard@gmail.com";
    private $message = "Votre contrat démarre demain, soyez prêt !";
    private $object = "Rappel début de contrat";


    public function getDataMailer(InterimRepository $interimRepository)
    {
        $interims = $interimRepository->findAll();
        $yesterday = date('Y/m/d', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));



        foreach ($interims as $interim) {
            if($interim['startAt'] === $yesterday) {
                $this->mail_utf8($interim['firstName'], $interim['lastName'], $interim['mail']);
            }
        }
    }

    public function mail_utf8($firstName, $lastName, $email)
    {

        $to = $this->to;
        $name = $firstName . ' ' . $lastName;
        $object = $this->object;
        $message = $this->message;

        $from_user = "=?UTF-8?B?".base64_encode($name)."?=";
        $subject = "=?UTF-8?B?".base64_encode($object)."?=";

        $headers = "From: $from_user <$email>\r\n".
            "MIME-Version: 1.0" . "\r\n" .
            "Content-type: text/html; charset=UTF-8" . "\r\n";


        return mail($to, $subject, $message, $headers);
    }
}