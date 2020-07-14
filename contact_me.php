<?php

// for debugging
$env = 'prod';
if ($_SERVER['HTTP_HOST'] == 'localhost')
    $env = 'dev';

if ($env === 'dev'){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// get post body
$data = $_POST;

// require
require './vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

try {
    // read settings file
    $read = '';
    $file = fopen('./private/config/config.json', 'r');
    while($line = fgets($file)){
        $read .= $line;
    }
    fclose($file);

    $settings = json_decode($read, true);

    sendEmail($data, $settings);
} catch (\Throwable $th) {
    $message = urlencode('Some unexpected error orrured, please try emailing me directly');
    header("Location: ./?message=" . $message);
}


function sendEmail($data, $settings) {
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = 'smtp.mail.yahoo.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Username = $settings["email"]; 
    $mail->Password = $settings["emailPass"];
    $mail->Port = 465;

    $mail->setFrom($settings["email"], "Steven's Profile Server"); 
    $mail->addAddress($settings["receiverEmailAddress"], $settings["receiverName"]);

    $mail->Subject = 'Someone Messaged You on Your Portfolio';
    $mail->isHTML(true);


    $mailContent = formHtmlBody($data);

    $mail->Body = $mailContent;

    if($mail->send()){
        $message = urlencode('Thank you, I will be in touch');
        header("Location: ./?message=" . $message);
    }else{
        $message = urlencode('Some unexpected error orrured, please try emailing me directly');
        header("Location: ./?message=" . $message);
    }
}

function formHtmlBody($data) {
    return '
    <div style="background: whitesmoke;">
    <div style="background: #0c3a5f; width: 100%; height: 300px; display: flex; justify-content: center; overflow: hidden;">
        <h1>Steven\'s Portfolio</h1>
    </div>
    <div style="padding:10px; padding-bottom: 20px;">
        <h3>Hi Steven</h3>
        <p>A visitor to your website has just messaged you.</p>
        <p>Their message reads:</p>
            <blockquote style="background: white; width:fit-content; padding: 20px; border-radius: 10px;">
                <q>' . $data["inputMessage"] . '</q>
                <br />
                <br />
                - ' . $data["inputName"] . '
                <br />
                <a href="mailto:' . $data["inputEmail"] . '">' . $data["inputEmail"] . '</a>
            </blockquote>
    <p>Thier contact details are listed above.</p>
    <p>Steven\'s Portfolio Server</p>
    </div>
</div>';
}

?>
