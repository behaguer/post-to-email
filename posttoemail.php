<?php

if ( ! class_exists( 'PostToEmail' ) ) :

 /**
  * 
  * A class built to send email with string interpolation.
  *
  * A simple class that takes the basic elements required to send email and
  * also a data element. The key / values are taken from data and replaced through
  * the template selected from the template folder. 
  *
  * The ./templates folder contains html email templates selectable by name 
  * and passed to the class by the $template variable.
  *
  * @param string $to - Who is the email to.
  * @param string $from - Who is the email from.
  * @param string $subject - Email subject line.
  * @param string $template - Filename must exist in ./templates as an .html file.
  * @param JSON $data - Json data passed as key / values and used for string interpolation.
  *
  * @return class object with Result added from the send (true for success / false for failed).
  *
  */
class PostToEmail
{
    public function __construct($to, $from, $subject, $template, $data) 
    {

        $this->to = $to;
        $this->from = $from;
        $this->subject = $subject;
        $this->template = $template;
        $this->data = $data;
        $this->templatesFolder = 'templates';
        $this->result = '';

        $this->init();
    }

    /**
     * init - initiate the class
     *
     * @return void
     */
    public function init() 
    {
        
        $this->sendEmail();

    }

    /**
     * loadTemplate - loads the templated file
     *
     * @return processedFile
     */
    public function loadTemplate() 
    {

        $processFile = mb_convert_encoding(file_get_contents($this->templatesFolder.DIRECTORY_SEPARATOR.$this->template), "HTML-ENTITIES", "UTF-8" );

        $thedata = json_decode($this->data);
        
        $i = 0;

        foreach ($thedata as $k => $v) {

            if (strpos($processFile, '{{'.$k.'}}') !== false) { // If the template contains the key value in {{ }}'s

                $processedFile = ($i == 0 ) ? str_replace('{{'.$k.'}}',$v,$processFile) : str_replace('{{'.$k.'}}',$v,$processedFile);

            }

            $i++;

        }

        return $processedFile;

    }

    /**
     * sendEmail sends the email and sets the result of the send
     *
     * @return void
     */
    public function sendEmail()
    {

        $to = filter_var($this->to, FILTER_SANITIZE_EMAIL);
        $from = filter_var($this->from, FILTER_SANITIZE_EMAIL);

        $subject = $this->subject;

        $message = $this->loadTemplate($this->template);

        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $from . "\r\n";
        
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $result = mail($to,$subject,$message,$headers);

        $this->result = $result;
    }

}
endif;

$sendresult = new PostToEmail($_POST['to'], $_POST['from'], $_POST['subject'], $_POST['template'], $_POST['data']);