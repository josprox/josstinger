<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/phpmailer/phpmailer/src/SMTP.php';

// Load .env
require __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '/../../.env');
$dotenv->load();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$ssl = check_http();

$cuerpo = '
    <!DOCTYPE html>
    <html lang="es-MX" >
    <head>
    <meta charset="UTF-8">
    </head>
    <body>
    <!-- partial:index.partial.html -->
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0;">
        <meta name="format-detection" content="telephone=no"/>

        <!-- Responsive Mobile-First Email Template by Konstantin Savchenko, 2015.
        https://github.com/konsav/email-templates/  -->

        <style>
        /* Reset styles */ 
        body { margin: 0; padding: 0; min-width: 100%; width: 100% !important; height: 100% !important;}
        body, table, td, div, p, a { -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse !important; border-spacing: 0; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
        #outlook a { padding: 0; }
        .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; }
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }

        /* Rounded corners for advanced mail clients only */ 
        @media all and (min-width: 560px) {
            .container { border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px; -khtml-border-radius: 8px;}
        }

        /* Set color for auto links (addresses, dates, etc.) */ 
        a, a:hover {
            color: #127DB3;
        }
        .footer a, .footer a:hover {
            color: #999999;
        }

        </style>

        <!-- MESSAGE SUBJECT -->
        <title>'.$asunto.'</title>

    </head>

    <!-- BODY -->
    <!-- Set message background color (twice) and text color (twice) -->
    <body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
        background-color: #F0F0F0;
        color: #000000;"
        bgcolor="#F0F0F0"
        text="#000000">

    <!-- SECTION / BACKGROUND -->
    <!-- Set message background color one again -->
    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background"><tr><td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;"
        bgcolor="#F0F0F0">

    <!-- WRAPPER -->
    <!-- Set wrapper width (twice) -->
    <table border="0" cellpadding="0" cellspacing="0" align="center"
        width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
        max-width: 560px;" class="wrapper">

        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                padding-top: 20px;
                padding-bottom: 20px;">

                <!-- PREHEADER -->
                <!-- Set text color to background color -->
                <div style="display: none; visibility: hidden; overflow: hidden; opacity: 0; font-size: 1px; line-height: 1px; height: 0; max-height: 0; max-width: 0;
                color: #F0F0F0;" class="preheader">
                    Tienes un nuevo mensaje de: '.$nombre.'</div>

                <!-- LOGO -->
                <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2. URL format: http://domain.com/?utm_source={{Campaign-Source}}&utm_medium=email&utm_content=logo&utm_campaign={{Campaign-Name}} -->
            <!--	<a target="_blank" style="text-decoration: none;"
                    href="'.$ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].'"><img border="0" vspace="0" hspace="0"
                    src="https://github.com/josprox/JosSecurity/raw/main/resourses/img/logo%20transparente/cover.png"
                    width="300" 
                    alt="Logo" title="Logo" style="
                    color: #000000;
                    font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;" /></a>-->

            </td>
        </tr>

    <!-- End of WRAPPER -->
    </table>

    <!-- WRAPPER / CONTEINER -->
    <!-- Set conteiner background color -->
    <table border="0" cellpadding="0" cellspacing="0" align="center"
        bgcolor="#FFFFFF"
        width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
        max-width: 560px;" class="container">

        <!-- HEADER -->
        <!-- Set text color and font family ("sans-serif" or "Georgia, serif") -->
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: bold; line-height: 130%;
                padding-top: 25px;
                color: #000000;
                font-family: sans-serif;" class="header">
            </td>
        </tr>
        
        <!-- SUBHEADER -->
        <!-- Set text color and font family ("sans-serif" or "Georgia, serif") -->
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-bottom: 3px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 18px; font-weight: 300; line-height: 150%;
                padding-top: 5px;
                color: #000000;
                font-family: sans-serif;" class="subheader">
        
        <img border="0" vspace="0" hspace="0"
                    src="https://github.com/josprox/JosSecurity/raw/main/resourses/img/logo%20transparente/cover.png"
                    width=300"
                    alt="Logo" title="Logo" style="
                    color: #000000;
                    font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;" />
            </td>
        </tr>
                                                                                                                                                        
                                                                                                                                                        
                                                                                                                                    <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-bottom: 3px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 18px; font-weight: 300; line-height: 150%;
                padding-top: 5px;
                color: #000000;
                font-family: sans-serif;" class="subheader">
        Tienes un mensaje de:
            </td>
        </tr>
                                                    
                                                    <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-bottom: 3px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 18px; font-weight: 300; line-height: 150%;
                padding-top: 5px;
                color: #000000;
                font-family: sans-serif;" class="subheader">
        '.$nombre.' con el siguiente asunto:
            </td>
        </tr>
    
    

        <!-- PARAGRAPH -->
        <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
        <tr>
            <td align="justify" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
                padding-top: 25px; 
                color: #000000;
                font-family: sans-serif;" class="paragraph">
                    '.$contenido.'
            </td>
        </tr>

        <!-- BUTTON -->
        <!-- Set button background color at TD, link/text color at A and TD, font family ("sans-serif" or "Georgia, serif") at TD. For verification codes add "letter-spacing: 5px;". Link format: http://domain.com/?utm_source={{Campaign-Source}}&utm_medium=email&utm_content={{Button-Name}}&utm_campaign={{Campaign-Name}} -->

        <!-- LINE -->
        <!-- Set line color -->
        <tr>	
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                padding-top: 25px;" class="line"><hr
                color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
            </td>
        </tr>

        <!-- LIST -->
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%;" class="list-item"><table align="center" border="0" cellspacing="0" cellpadding="0" style="width: inherit; margin: 0; padding: 0; border-collapse: collapse; border-spacing: 0;">
                
                <!-- LIST ITEM -->
                <tr>

                    <!-- LIST ITEM TEXT -->
                    <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                    <td align="left" valign="top" style="font-size: 12px; font-weight: 400; line-height: 160%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
                        padding-top: 25px;
                        color: #000000;
                        font-family: sans-serif;" class="paragraph">
                            El mensaje se ha mandado desde el siguiente dominio: <span style="font-size:11px;">
                                                                    '.$ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].' </span>
                            
                    </td>

                </tr>

                <!-- LIST ITEM -->
                <tr>



            </table></td>
        </tr>

        <!-- LINE -->
        <!-- Set line color -->
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                padding-top: 25px;" class="line"><hr
                color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
            </td>
        </tr>

        <!-- PARAGRAPH -->
        <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->

    <!-- End of WRAPPER -->
    </table>

    <!-- WRAPPER -->
    <!-- Set wrapper width (twice) -->
    <table border="0" cellpadding="0" cellspacing="0" align="center"
        width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
        max-width: 560px;" class="wrapper">

        <!-- SOCIAL NETWORKS -->
        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->

        <!-- FOOTER -->
        <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                padding-top: 20px;
                padding-bottom: 20px;
                color: #999999;
                font-family: sans-serif;" class="footer">

                                                    
    No responda a este mensaje. Este correo electrónico ha sido enviado a través de un sistema automatizado que no permite dar respuesta a las preguntas enviadas a esta dirección.

                    <!-- ANALYTICS -->
                    <!-- https://www.google-analytics.com/collect?v=1&tid={{UA-Tracking-ID}}&cid={{Client-ID}}&t=event&ec=email&ea=open&cs={{Campaign-Source}}&cm=email&cn={{Campaign-Name}} -->


            </td>
        </tr>

    <!-- End of WRAPPER -->
    </table>

    <!-- End of SECTION / BACKGROUND -->
    </td></tr></table>

    </body>
    </html>
    <!-- partial -->
    
    </body>
    </html>

';

try {
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP(); 
    $mail->Host       = $_ENV['SMTP_SERVER'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USERNAME'];
    $mail->Password   = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $_ENV['SMTP_PORT'];

    //Recipients
    $mail->setFrom($correo, $nombre);
    $mail->addAddress($_ENV['SMTP_USERNAME']);

    //Content
    $mail->isHTML(true);
    $mail->Subject = $asunto;
    $mail-> CharSet = 'UTF-8';
    $mail->Body    = $cuerpo;

    $mail->SMTPAutoTLS = false;
    $mail->SMTPOptions = ['ssl' => ['crypto_method' => STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT]];

    $mail->send();
} catch (Exception) {
    echo "Tuvimos un error, pruebalo mas tarde: {$mail->ErrorInfo}";
}

?>
