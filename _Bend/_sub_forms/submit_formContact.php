<?php
    if (isset($_POST['texte'])) {
        require 'verify_recaptcha_server.php';
        //retrieve POST variable
        $name= $_POST['name'];
        $email= $_POST['email'];
        $telephone = $_POST['telephone'];
        $texte = $_POST['texte'];

        //Verify if empty fields
        if(empty($name)){
            header("Location:../../_pages/contact.php?error=noname");
            exit();
        }
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location:../../_pages/contact.php?error=noemail");
            exit();
        }
        if(empty($telephone)){
            header("Location:../../_pages/contact.php?error=nophone");
            exit();
        }
        if(empty($texte)){
            header("Location:../../_pages/contact.php?error=nomessage");
            exit();
        }

        //Set var for email 
         $to = 'bloumoua@hotmail.com';
         $subject = "PPC- Soumission d'un nouveau formulaire par $name";
         $headers = array(
            'From' => 'noreply@ppc.com',
            'Reply-to' => $email
         );

         mail($to,$subject,$texte,$headers);

         header("Location:../../_pages/msg/merci_contactForm.php");
         exit();
    }else{
        header("Location:../../_pages/contact.php?error=enterinfos");
        exit();
    }
    

?>