<?php
 include 'class.phpmailer.php';
$msg = '
    <html>
        <head></head>
        <body>
            <header style="background: #ab24ec;">
                <p style="display:inline-block; vertical-align:bottom; margin-left: 10px; margin-right: 20px;">
                    <a href="http://localhost/stalnom/accueil.html">
                        <img src="http://localhost/stalnom/img/logo/logoX128.png" alt="Stalnom\'s Traces" title="Stalnom\'s Traces" />
                    </a>
                </p>
                <h1 style="display:inline-block; vertical-align:bottom; margin-right: 10px;">
                    <a href="http://localhost/stalnom/accueil.html" style="color: black; text-decoration: none;">Stalnom\'s Traces</a>
                </h1>
            </header>
            <section style="background: #a9adda; margin: 10px 0; padding: 10px 0; width: 100%">
                <aside style="float: left; margin: 0 10px; vertical-align: top;">
                    <p style="margin: 0; text-align: center;">
                        <img src="http://localhost/stalnom/img/users/Taleia/avatar.png" alt="Taleia"/><br />
                        Pseudo<br />
                        Role
                    </p>
                </aside>
                <article style="overflow: auto; margin-right: 10px; background: rgba(255, 0, 0, 0.3);">
                    <div style="margin: 0;">
                        <h1 style="margin: 0; padding: 10px; background: #fa987a;">Titre</h1>
                        <p style="margin: 0; padding: 0 10px; background: #a789af;">Message</p>
                    </div>
                </article>
                <div style="clear:both;"></div>
            </section>
            <footer style="text-align: center; background: #fa3f4d;">
                <p style="margin: 0;">
                    Site du serveur minecraft Stalnom\'s Traces - Taleia NOSSET & Lanscel Thaledric -
                    Tous droits réservés sur le site, le serveur et leurs composantes.
                </p>
            </footer>
        </body>
    </html>
';

$mail = new PHPmailer();
$mail->IsSMTP();
$mail->IsHTML(true);
$mail->Host='smtp.free.fr:25';
$mail->From='jm.quetelart@free.fr';
$mail->AddAddress('jm.quetelart@free.fr');
$mail->Subject='test';
$mail->Body=$msg;
if(!$mail->Send()){ //Teste le return code de la fonction
    echo $mail->ErrorInfo; //Affiche le message d'erreur (ATTENTION:voir section 7)
}
else{
    echo 'Mail envoyé avec succès';
}
$mail->SmtpClose();
unset($mail);

?>