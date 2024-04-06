<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    if ( empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Пожалуйста, заполните все поля формы.";
        exit;
    }

    $recipient = "EXAMPLE@MAIL.COM";  //ВВЕСТИ АДРЕС ПОЧТЫ ПОЛУЧЕНИЯ
    $email_subject = "Новое сообщение от $name";
    $email_content = "Имя: $name\r\n";
    $email_content .= "Email: $email\r\n";
    $email_content .= "Тема: $subject\r\n";
    $email_content .= "Сообщение:\r\n$message\r\n";

    $email_headers = "From: $name <$email>";
    $email_headers .= "Reply-To: $email";
    $email_headers .= "MIME-Version: 1.0";
    $email_headers .= "Content-Type: text/plain; charset=utf-8";

    if(mail($recipient, $email_subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Спасибо! Ваше сообщение было отправлено.";
    } else {
        http_response_code(500);
        echo "Извините, произошла ошибка при отправке вашего сообщения. Пожалуйста, попробуйте позже.";
    }

} else {
    http_response_code(403);
    echo "Для отправки сообщения требуется использовать POST запрос.";
}

?>
