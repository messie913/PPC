<?php

    // Vérification de la réponse reCAPTCHA
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        /*echo "Erreur : reCAPTCHA non complété.";
        exit;*/
        $alert = "Erreur : reCAPTCHA non complété. Veuiller confirmer le code captcha.";
        $back= "history.back()";
        echo "<script>alert('$alert');</script>";
        echo "<script>$back</script>";
        exit();
    }

    // Clé secrète reCAPTCHA
    $secretKey = '6Lc-yH8qAAAAAJipTpUjz4XxMcOy6SPFR6UkVyfw';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Validation de la réponse reCAPTCHA auprès des serveurs Google
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded
",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $verifyResponse = file_get_contents($verifyUrl, false, $context);
    $result = json_decode($verifyResponse, true);

    // Vérification du succès de reCAPTCHA
    if (!$result['success']) {
        echo "Erreur : échec de la vérification reCAPTCHA.";
        exit;
        
    }