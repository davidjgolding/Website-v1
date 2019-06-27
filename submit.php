<?php
    require '../../vendor/autoload.php';

    // Given a string returns true if it is not in the format of an email
    function notAnEmail($str) {
        if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $str)) {
            return false;
        } else {
            return true;
        }
    }

    // Values retrived from the form submission
    $name = htmlspecialchars($_POST["name"]);
    $from = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);
    
    // Value to indicate if error has occured
    $status = 0;

    // Checks that none of the fields are empty
    $submitted = array($name, $from, $message);
    for ($x = 0; $x < count($submitted); $x++) {
        if(empty($submitted[$x]) == true) {
            $status = 1;
            echo $x+1;
        } else {
            echo " ";
        }
    }
   
    // Checks that the email field is of the format of an email
    if (notAnEmail($from)) {
        $status = 1;
        echo "4";
    } else {
        echo " ";
    }

    // If no error occured, compose and send message via sendgrid
    if ($status == 0) {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($from, $name);
        $email->setSubject("[DG Website] Form Submission");
        $email->addTo("david@davidgolding.co.uk", "David Golding");
        $email->addContent("text/html", $message);
        $sendgrid = new \SendGrid(trim(file_get_contents("../../key.txt")));
        try {
           $sendgrid->send($email);
        } catch (Exception $e) {
           exit;
        }
    } 
?>