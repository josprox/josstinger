<?php
    namespace GranMail;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class NewMail{
        // Se asignan los métodos.
        public string $metodo = "test";
        public string $nombre = "JosSecurity";
        public string $asunto = "Correo de prueba";
        public string $contenido;
        public string $correo;
        public string $headers;
        public array $attachments = [];
        protected $ssl;

        public function __construct() {
            $this->ssl = check_http();
        }

        // Checa la configuración del sistema de manera interna.
        private function check_config(){
            if(!isset($_ENV['SMTP_ACTIVE']) || $_ENV['SMTP_ACTIVE'] != 1){
                $status = [
                    "Mensaje" => "Error, el sistema no tiene configurado el modo SMTP.",
                    "Estado" => 400
                ];
            }else{
                $status = [
                    "Mensaje" => "Completado, el sistema puede hacer uso de SMTP.",
                    "Estado" => 200
                ];
            }
            return $status;
        }

        // Envía los mensajes necesarios.
        public function send(){
            //Comprobar con la funcion check_config el return donde si "Estado" es 200, continua con la función, si no, retorna automáticamente el sistema un error 400.
            $config_status = $this->check_config();
            if($config_status['Estado'] == 200){
                $mail = new PHPMailer(true);
                //Configuración del servidor con los datos del sitema.
                $mail->SMTPDebug = 0;
                $mail->isSMTP(); 
                $mail->Host       = $_ENV['SMTP_SERVER'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['SMTP_USERNAME'];
                $mail->Password   = $_ENV['SMTP_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = $_ENV['SMTP_PORT'];
                
                //Recipients
                $mail->setFrom( $_ENV['SMTP_USERNAME'], $this->nombre);
                $mail->addAddress($this->correo);
                
                // Analiza el método de uso.
                switch ($this->metodo){
                    case "test":
                        $cuerpo = '
                            <!DOCTYPE html>
                            <html lang="es-MX" >
                            <head>
                            <meta charset="UTF-8">
                            <title>Recuperar contraseña</title>
                            

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
                                <title>Correo de prueba</title>

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
                                            Gracias por usar JosSecurity, si te llegó este correo es porque tu sistema funciona correctamente.</div>

                                        <!-- LOGO -->
                                        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2. URL format: http://domain.com/?utm_source={{Campaign-Source}}&utm_medium=email&utm_content=logo&utm_campaign={{Campaign-Name}} -->
                                    <!--	<a target="_blank" style="text-decoration: none;"
                                            href="'.$this->ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].'"><img border="0" vspace="0" hspace="0"
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
                                Felicidades!!
                                    </td>
                                </tr>
                                                                            
                                                                            <tr>
                                </tr>
                            
                            

                                <!-- PARAGRAPH -->
                                <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
                                        padding-top: 25px; 
                                        color: #000000;
                                        font-family: sans-serif;" class="paragraph">
                                            Muchas felicidades, el correo de prueba funciona correctamente.
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
                                                                                            '.$this->ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].' </span>
                                                    
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
                    break;
                    case "basic":
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
                                <title>'.$this->asunto.'</title>

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
                                            Hola, tienes un mensaje de '.$this ->nombre.'!!</div>

                                        <!-- LOGO -->
                                        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2. URL format: http://domain.com/?utm_source={{Campaign-Source}}&utm_medium=email&utm_content=logo&utm_campaign={{Campaign-Name}} -->
                                    <!--	<a target="_blank" style="text-decoration: none;"
                                            href="'.$this->ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].'"><img border="0" vspace="0" hspace="0"
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
                            Tienes un nuevo mensaje de '.$this->nombre.'. <br>Con el asunto: '.$this->asunto.'. <br> A continuación, se mostrará el mensaje:
                                    </td>
                                </tr>
                                                                            
                                                                            <tr>
                                </tr>
                            
                            

                                <!-- PARAGRAPH -->
                                <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                                <tr>
                                    <td align="justify" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
                                        padding-top: 25px; 
                                        color: #000000;
                                        font-family: sans-serif;" class="paragraph">
                                            '.$this->contenido.'
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
                                                                                            '.$this->ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].' </span>
                                                    
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
                    break;
                    case "WordPress":
                        $cuerpo = $this->contenido;
                    
                        // Cambios de headers
                        if (!empty($this->headers)) {
                            $mail->addCustomHeader($this->headers);
                        }
                    
                        // Adjuntar cada archivo del arreglo de rutas de archivo
                        if (!empty($this->attachments) && is_array($this->attachments)) {
                            foreach ($this->attachments as $attachment) {
                                if (file_exists($attachment)) {
                                    $mail->addAttachment($attachment);
                                }
                            }
                        }
                    break;
                    case "recibir":

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
                                <title>'.$this->asunto.'</title>

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
                                            Hola, tienes un mensaje de '.$this->nombre.'!!</div>

                                        <!-- LOGO -->
                                        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2. URL format: http://domain.com/?utm_source={{Campaign-Source}}&utm_medium=email&utm_content=logo&utm_campaign={{Campaign-Name}} -->
                                    <!--	<a target="_blank" style="text-decoration: none;"
                                            href="'.$this->ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].'"><img border="0" vspace="0" hspace="0"
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
                            Tienes un nuevo mensaje de '.$this->nombre.'. <br>Con el asunto: '.$this->asunto.'. <br> A continuación, se mostrará el mensaje:
                                    </td>
                                </tr>
                                                                            
                                                                            <tr>
                                </tr>
                            
                            

                                <!-- PARAGRAPH -->
                                <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                                <tr>
                                    <td align="justify" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
                                        padding-top: 25px; 
                                        color: #000000;
                                        font-family: sans-serif;" class="paragraph">
                                            '.$this->contenido.'
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
                                                                                            '.$this->ssl.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].' </span>
                                                    
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
                        $mail->setFrom( $this->correo , $this->nombre);
                        $mail->addAddress( $_ENV['SMTP_USERNAME']);
                    break;
                }
                
                //Content
                $mail->isHTML(true);
                $mail->Subject = $this->asunto;
                $mail-> CharSet = 'UTF-8';
                $mail->Body    = $cuerpo;

                $mail->send();

                $mensaje = [
                    "Mensaje" => "Correo enviado correctamente.",
                    "Estado" => 200
                ];
                $status = json_encode($mensaje);
            }else{
                $status = json_encode($config_status);
            }
            return $status;
        }
    }
?>