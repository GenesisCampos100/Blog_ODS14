<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function conectarBaseDatos() {
    $host = "localhost";
    $db   = "login";
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    try {
        return new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function enviarCorreo($para, $codigo) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gcampos10@ucol.mx'; // Tu correo
        $mail->Password = 'ygmb flbn hvye rruv'; // App Password de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('tu_correo@gmail.com', 'Tu Nombre');
        $mail->addAddress($para);
        $mail->Subject = 'Código de recuperación';
       // 🎨 📩 Mensaje con HTML atractivo
        $mensaje = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; background-color: #f8f9fa; padding: 20px; }
                .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
                h2 { color: #008dcf; }
                .codigo { font-size: 24px; font-weight: bold; color: #28a745; }
                .footer { font-size: 14px; color: #666; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>🔒 Recuperación de Contraseña</h2>
                <p>Usa este código para recuperar tu cuenta:</p>
                <p class='codigo'>$codigo</p>
                <p class='footer'>Si no solicitaste este código, ignora este mensaje.</p>
            </div>
        </body>
        </html>";

        $mail->isHTML(true); // Activar formato HTML en el correo
        $mail->Body = $mensaje;

        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar correo: {$mail->ErrorInfo}";
    }
}
?>
