<?php
// use \vendor\PHPMailer\PHPMailer\PHPMailer;
// use \vendor\PHPMailer\PHPMailer;
// require 'vendor/autoload.php';
// require_once 'C:\Users\Yosep\Downloads\Xampp\htdocs\panas\vendor\autoload.php';
require_once '/xampp/htdocs/panas/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
class Email{
    public $error;
    public $mailer;
    public function __construct(){
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.mailtrap.io';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Port = 2525;
        $this->mailer->Username = '3d452ac8f12ceb';
        $this->mailer->Password = '6be1d5e42d6905';
    }
    private function prepareEmail(){
        $this->mailer->setFrom('info@mailtrap.io', 'Mailtrap');
        $this->mailer->addReplyTo('info@mailtrap.io', 'Mailtrap');
        $this->mailer->addAddress('recipient1@mailtrap.io', 'Tim');
    }
    public function SendWelcomeEmail($name){
        $this->prepareEmail();
        $this->mailer->Subject = 'Welcome to Panas';
        $this->mailer->Body = 'Hello, ' .$name. ' we are happy to have you with us.';
        if($this->mailer->send()){
            echo 'Message has been sent.';
        }else{
            echo 'Message could not be sent.' . '</br>';
            echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
        }
    } 
    public function SendAuthEmail($name, $code){
        $this->prepareEmail();
        $this->mailer->Subject = 'Panas Confirmation Code';
        $this->mailer->Body = 'Hello, ' .$name. ' we are happy to have you with us. Your confirmation code is: ' .$code;
        if($this->mailer->send()){
            echo 'Message has been sent.';
            return True;
        }else{
            echo 'Message could not be sent.' . '</br>';
            echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
        }
    }
    public function SendMeetingConfirmation($meeting){
        $this->prepareEmail();
        $this->mailer->Subject = 'New Meeting';
        $this->mailer->isHTML(true);
        $this->mailer->Body = "<p> Meeting Date: $meeting->date</p>";
        $this->mailer->Body = "<a href='http://localhost/panas/editmeeting.php?id=$meeting->id&session=1'>Edit Meeting (Tutor)</a>"; //DevSkim: ignore DS137138 until 2022-12-12 
        if($this->mailer->send()){
            echo 'Message has been sent.';
            echo "\r";
            return true;
        }else{
            echo 'Message could not be sent.' . "\r";
            echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
            return false;
        }
    }
        public function SendTutorMeetingConfirmation($meeting){
        $this->prepareEmail();
        $this->mailer->Subject = 'New Meeting';
        $this->mailer->isHTML(true);
        $this->mailer->Body = "<p> Meeting Date: $meeting->date</p>";
        $this->mailer->Body = "<a href='http://localhost/panas/editmeeting.php?id=$meeting->id'>Edit Meeting</a>"; //DevSkim: ignore DS137138 until 2022-12-12 
        if($this->mailer->send()){
            echo 'Message has been sent.';
            echo "\r";
            return true;
        }else{
            echo 'Message could not be sent.' . "\r";
            echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
            return false;
        }
    }
}