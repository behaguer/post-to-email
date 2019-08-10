# post-to-email
Take post data and send a string interpolated HTML email

## Short and Curlys
A class built to send email with string interpolation.

## Description
A simple class that takes the basic elements required to send email and
also a data element. The key / values are taken from data and replaced through
the template selected from the template folder. 
The ./templates folder contains html email templates selectable by name 
and passed to the class by the $template variable.

## Accepts
@param string $to - Who is the email to.\
@param string $from - Who is the email from.\
@param string $subject - Email subject line.\
@param string $template - Filename must exist in ./templates as an .html file.\
@param JSON $data - Json data passed as key / values and used for string interpolation.

## Returns
@return class object with Result added from the send (true for success / false for failed).

## How to use (example)

```php
$sendresult = new PostToEmail($_POST['to'], $_POST['from'], $_POST['subject'], $_POST['template'], $_POST['data']);
```