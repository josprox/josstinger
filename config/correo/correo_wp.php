<?php
  // Incluir la librería de PHPMailer

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    function mi_mail_v2( $to, $subject, $message, $headers = '', $attachments  = [] ) {
    require __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/phpmailer/phpmailer/src/Exception.php';
      require __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
      require __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    // Crear una nueva instancia de PHPMailer
    $mail = new PHPMailer(true);

    // Configurar el servidor SMTP y el puerto
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_SERVER'];
    $mail->SMTPAuth   = true;
    $mail->Port = $_ENV['SMTP_PORT'];

    // Configurar el nombre de usuario y la contraseña para autenticar la conexión
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom( $_ENV['SMTP_USERNAME'], \NOMBRE_APP);

    // Configurar el destinatario, el asunto y el mensaje
    $mail->addAddress( $to );
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail-> CharSet = 'UTF-8';
    $mail->Body = $message;

    // Cambios de headers
    if ( ! empty( $headers ) ) {
        $mail->addCustomHeader( $headers );
    }
    // Adjuntar cada archivo del arreglo de rutas de archivo
    if ( ! is_array( $attachments ) ) {
        $attachments = explode( "\n", str_replace( "\r\n", "\n", (string) $attachments ) );
    }
    if ( ! empty( $attachments ) ) {
        foreach ( $attachments as $attachment ) {
        $mail->addAttachment( $attachment );
        }
    }

    //Configuración SSL/TLS

    $mail->SMTPAutoTLS = false;
    $mail->SMTPOptions = ['ssl' => ['crypto_method' => STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT]];

    // Enviar el correo y devolver el resultado
    return $mail->send();
}