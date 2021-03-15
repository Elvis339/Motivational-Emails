<?php
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

$mail = new PHPMailer(true);

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $response = file_get_contents(__DIR__ . "/lines.json");
    $json = json_decode($response);
    $quote = $json[rand(0, count($json))];
    $strQuote = $quote->quote;
    $author = $quote->author;

    $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV["username"];
    $mail->Password = $_ENV["password"];
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->isHTML(true);

    $mail->setFrom($_ENV["username"], $_ENV["recepient"]);
    $mail->addAddress($_ENV["recepient"]);
    $mail->addCC($_ENV["cc"]);
    $mail->Subject = 'Daily motivation for the love of my life';
    $mail->Body = "
          <html>
            <body>
              <h3> $strQuote </h3>
              <h4> $author </h4>
              <div class='float: right;'>
                <span>@Author: Elvis Sabanovic</span> <br>
                <span>@Date: 02.07.2019</span> <br>   
                <span>@License: GNU Lesser General Public License v2.1</span> <br>
              </div>
            </body>
          </html>
        ";
    $mail->send();
} catch (Exception $e) {
    error_log($e->errorMessage(), 3, "error.log");
}