<?php
/**
* SENDS EMAIL WITH GMAIL
*/

class Email extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('email');
        //for configuration of email head to ci_day3/application/config/email.php
        
        $this->email->from('captainbuggythefifth@gmail.com', 'Gaudencio Teves');
        $this->email->to('captainbuggythefifth@gmail.com');
        $this->email->subject('This is an email test');
        $this->email->message('It is working. Great!');
        
       // $path = $this->config->item('server_root');
       // $file = $path.'/ci_day3/attachments/yourInfo.txt';
        
        //$this->email->attach($file);
        
        if($this->email->send()){
            echo 'Your email was sent, fool.';
        }
        else{
            show_error($this->email->print_debugger());
        }
    }
    
}