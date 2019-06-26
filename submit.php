<?php
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
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);
    
    // Value to indicate if error has occured
    $status = 0;

    // Checks that none of the fields are empty
    $submitted = array($name, $email, $message);
    for ($x = 0; $x < count($submitted); $x++) {
        if(empty($submitted[$x]) == true) {
            $status = 1;
            echo $x+1;
        } else {
            echo " ";
        }
    }
   
    // Checks that the email field is of the format of an email
    if (notAnEmail($email)) {
        $status = 1;
        echo "4";
    } else {
        echo " ";
    }

    // If no error occured, compose and send message
    if ($status == 0) {
        // Composes HTML email
        $tosend = '
        <html>
        <body>
        ' . $message . '
        </body>
        </html>';

        // MIME headers
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To: David Golding <david@davidgolding.co.uk>';
        $headers[] = 'From: ' . $name . ' <' . $email . '>';
        $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
        
        mail("david@davidgolding.co.uk", "[DG Website] Form Submission",  $tosend, implode("\r\n", $headers));
    } 
   
?>