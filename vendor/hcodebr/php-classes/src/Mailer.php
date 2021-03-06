<?php

namespace Hcode;

use PHPMailer as GlobalPHPMailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Rain\Tpl;

class Mailer {
    
    const USERNAME = "contato.virtuesimports@gmail.com";
    const PASSWORD = "*Virtues.com";
    const NAME_FROM = "Virtues Importações";

    private $mail;

    public function __construct($toAdress, $toName, $subject, $tplName, $data = array())
    
    {
        
        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]. "/views-cache/",
            "debug"         => false


        );

        tpl::configure( $config );

        $tpl = new Tpl;

        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);

        }
        
        $html = $tpl->draw($tplName, true);


        $this->mail = new PHPmailer(true);

        $this->mail->isSMTP();
        
        $this->mail->SMTPOptions = array(

            "ssl"=> array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
                'allow_self_signed'=>true
            )

        );

        $this->mail->SMTPDebug = 0;
        
        $this->mail->Host = 'smtp.gmail.com';
        
        $this->mail->Port = 587;
        
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
        $this->mail->SMTPAuth = true;
        
        $this->mail->Username = Mailer::USERNAME;
        
        $this->mail->Password = Mailer::PASSWORD;
        
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
        
        $this->mail->addAddress($toAdress, $toName);
        
        $this->mail->Subject = $subject;
        
        $this->mail->msgHTML($html);
        
        $this->mail->AltBody = 'Esse é um Plano de Mensagem Contextual.';
        
       

        
    }

    public function send()
    {
        return $this->mail->send();
    }

}



 ?>