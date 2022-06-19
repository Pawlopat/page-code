<?php

namespace App\Controllers;
use CodeIgniter\Api\ResponseTrait;
use CodeIgniter\Controller;
class Home extends BaseController
{
    public function index()
    {
        echo view('templates/header');
        echo view('home/index');
        echo view('templates/footer');
    }

    public function contact_form(){
        date_default_timezone_set('Europe/Warsaw');
        if(trim($this->request->getPost('contact_email')) != '' && trim($this->request->getPost('contact_message')) != ''){
            $email = \Config\Services::email();
            $config['SMTPHost'] = getenv('email.SMTPHostSSL');
            $config['SMTPUser'] = getenv('email.SMTPUser');
            $config['SMTPPass'] = getenv('email.SMTPPass');
          /*   $config['protocol'] = 'smtp';
            $config['smtp_port'] = '587';
            $config['mailtype'] = "html";
            $config['crlf'] = "\r\n";
            $config['newline'] = "\r\n"; */
            
            echo "<pre>";
            print_r ($config);
            echo "</pre>";
            
            //$config['smtp_port '] = 'sendmail';
            $email->initialize($config);
            $email->setFrom('kontakt@page-code.pl', 'Pagecode');
            $email->setTo('ppawlowski96@gmail.com');
            $email->setSubject('Nowa wiadomość page-code.pl');
            $email->setMessage('<h1>Nowa wiadomość page-code.pl</h1><br/><ul><li><b>E-mail: '.$this->request->getVar('contact_email').'</b></li><li><b>Message:</b> '.$this->request->getVar('contact_message').'</li></ul>');
            if(!$email->send()){
                echo $email->printDebugger();
                //return redirect()->to('/email_error');
            }else{
                return redirect()->to('/thank_you');
            }
        }
    }
}
