<?php

namespace App\Controllers;
use CodeIgniter\Api\ResponseTrait;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Home extends BaseController
{
    public function index()
    {
        echo view('templates/header');
        echo view('home/index');
        echo view('templates/footer');
    }

    public function contact_form(){
        if(trim($this->request->getPost('contact_email')) != '' && trim($this->request->getPost('contact_message')) != '' && $this->request->getPost('action') == 'send_message'){
            $mail = new PHPMailer(true);  
            try {
                $mail->isSMTP();  
                $mail->Host         = getenv('email.SMTPHostSSL');
                $mail->SMTPAuth     = true;     
                $mail->Username     = getenv('email.SMTPUser');  
                $mail->Password     = getenv('email.SMTPPass');
                $mail->SMTPSecure   = 'tls';  
                $mail->Port         = 587;  
                $mail->CharSet      = 'UTF-8';
                $mail->Encoding     = 'base64';
                $mail->Subject      = 'Nowa wiadomość page-code.pl';
                $mail->Body         = '<h1>Nowa wiadomość page-code.pl</h1><br/><ul><li><b>E-mail: '.$this->request->getVar('contact_email').'</b></li><li><b>Message:</b> '.$this->request->getVar('contact_message').'</li></ul>';
                $mail->isHTML(true);      

                $mail->setFrom('kontakt@page-code.pl', 'Page-code');
                $mail->addAddress('kontakt@page-code.pl');  
                
                if(!$mail->send()) {
                    return redirect()->to('/email_error')->with('from_email', 1);
                }
                else {
                    return redirect()->to('/thank_you')->with('from_email', 1);
                }
            } catch (Exception $e) {
                return redirect()->to('/email_error')->with('from_email', 1);
            }
        }
    }

    public function email_error(){
        if(session()->getFlashdata('from_email') == 1){
            echo view('templates/header');
            echo view('home/email_error');
            echo view('templates/footer');
        }else{
            return redirect()->to('/');
        }
    }
    public function thank_you(){
       if(session()->getFlashdata('from_email') == 1){
           echo view('templates/header');
           echo view('home/thank_you');
           echo view('templates/footer');
       }else{
        return redirect()->to('/');
       }
    }
}
