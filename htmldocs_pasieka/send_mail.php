<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['submit'])) {
        // Function for validate text in input
        function test_input($inputData) {
            $inputData = trim($inputData);
            $inputData = stripslashes($inputData);
            $inputData = htmlspecialchars($inputData);
            return $inputData;
        }
        // Initialization of boolean flag
        $isValid = true;
        $errors = [];

        // Checking name input
        if(empty($_POST['name'])) {
            $isValid = false;
            $errors['errName'] = 'To pole jest wymagane';
        } else {
            $fromName = test_input($_POST['name']);
            $_SESSION['preName'] = $fromName;
        }

        // Checking email input
        if(empty($_POST['email'])) {
            $isValid = false;
            $errors['errEmail'] = 'To pole jest wymagane';
        } else {
            $fromEmail = test_input($_POST['email']);
            $fromEmailSanitized = filter_var($fromEmail, FILTER_SANITIZE_EMAIL);

            if((filter_var($fromEmailSanitized, FILTER_VALIDATE_EMAIL) == false) || ($fromEmailSanitized != $fromEmail)) {
                $isValid = false;
                $errors['errEmail'] = 'Niepoprawny adres e-mail';
            }
        }

        // Checking message input
        if(empty($_POST['message'])) {
            $isValid = false;
            $errors['errMessage'] = 'To pole jest wymagane';
        } else {
            $message = test_input($_POST['message']);
        }

        // Checking RODO checkbox
        if(empty($_POST['rodo'])) {
            $isValid = false;
            $errors['errRODO'] = 'To pole jest wymagane';
        }

        // Checking reCaptcha
        $secretCaptchaKey = '6LdKtTcUAAAAAHvwYoFXhdTPkZHB9uqvp8YQ9GQN';     //reCaptcha secretKey
        $checkCaptchaKey = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretCaptchaKey.'&response='.$_POST['g-recaptcha-response']);
        $captchaResponse = json_decode($checkCaptchaKey);
        if($captchaResponse->success == false) {
            $isValid = false;
            $errors['errCaptcha'] = 'To pole jest wymagane';
        }

        // Checking boolean flag - if true set and send mail
        if($isValid) {

            require '../phpmailer/src/PHPMailer.php';
            require '../phpmailer/src/Exception.php';
            require '../phpmailer/src/SMTP.php';
            require '../phpmailer/src/OAuth.php';

            $mail = new PHPMailer();                              // Passing `true` enables exceptions

            $mail->CharSet = 'UTF-8';
            //Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'kontakt.pasieka@gmail.com';                 // SMTP username
            $mail->Password = 'pasiekazhp';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('kontakt.pasieka@gmail.com', 'Kontakt');
            $mail->addAddress('pasieka.zhp@gmail.com', 'Szczep Pasieka');     // Add a recipient
            $mail->addReplyTo($fromEmail, $fromName);

            //Content
            $mail->Subject = 'Nowa wiadomo???? od: '.$fromName.' <'.$fromEmail.'> ze strony shpasieka.org';
            $mail->Body    = $message;
            $mail->AltBody = $message;

            if($mail->send()) {
                $sendSuccessMsg = 'Wiadomo???? zosta??a pomy??lnie wys??ana.';
            } else {
                $sendErrorMsg = 'Wiadomo???? nie mog??a zosta?? wys??ana.<br/>'.$mail->ErrorInfo;
            }
        }
    }
    ?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="description" content="Strona Szczepu Harcerskiego Pasieka">

    <title>Kontakt | Szczep Harcerski Pasieka</title>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../styles/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Roboto:400,500,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="../../fonts/museo_500/font-museo_500.css">
    <link rel="stylesheet" href="../../fonts/museo_300/font-museo_300.css">
    <script src="https://use.fontawesome.com/2127fd32bd.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="../../styles/main.css">
    <link rel="stylesheet" href="../../styles/kontakt.css">
    <link rel="stylesheet" href="../../styles/contact-link-tiles.css">
</head>

<body>
    <!-- HEADER START -->
    <header>
        <!-- NAVBAR START -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand d-inline-flex align-items-center pl-3 pl-lg-0" href="../../">
                    <img src="../../assets/logotypes_teams/pasieka_logo_white.svg" class="d-inline-block" alt="">
                    <h1 class="site-heading d-inline-flex flex-column">Szczep Harcerski<span class="site-subheading">Pasieka</span></h1>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../../"><img src="../../assets/tent_icon.svg" alt=""></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../aktualnosci/">Aktualno??ci</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../dokumenty/">Dokumenty</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../galeria/">Galeria</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../wesprzyj-nas/">1<small>%</small></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="../">Kontakt <span class="sr-only">(aktulny)</span></a>
                        </li>
                    </ul>
                </div>
            </div>
          </nav>
          <!-- NAVBAR END -->
    </header>
    <!-- HEADER END -->

    <!-- SLIDEOUT WIDGET START -->
    <div class="slideout-widget-container d-none d-md-flex flex-column">
        <a href="../../2ldh/" class="widget-item d-flex align-items-center">
            <img src="../../assets/hexagons_teams/hexagon_2ldh.svg" alt="Czarny sze??ciok??t z logiem II ??DH-rzy">
            <div class="widget-item-text">II ??DH-rzy</div>
        </a>
        <a href="../../22ldh/" class="widget-item d-flex align-items-center">
            <img src="../../assets/hexagons_teams/hexagon_22ldh.svg" alt="Czarny sze??ciok??t z logiem 22 ??DH-ek">
            <div class="widget-item-text">22 ??DH-ek "Watra"</div>
        </a>
        <a href="../../zuchy/" class="widget-item d-flex align-items-center">
            <img src="../../assets/hexagons_teams/hexagon_lgzpp.svg" alt="Czarny sze??ciok??t z logiem ??GZ Pracowite Pszcz????ki">
            <div class="widget-item-text">??GZ "Pracowite Pszcz????ki"</div>
        </a>
    </div>
    <!-- SLIDEOUT WIDGET END -->

    <!-- CARDBAR START -->
    <div class="cardbar">
        <div class="container d-flex align-items-center">
            <span class="card-title">Kontakt</span>
            <ul class="subpages-list">
                <a href="#"><li>Komenda</li></a>
                <a href="#"><li>Napisz do nas</li></a>
                <a href="#"><li>Znajd?? nas</li></a>
            </ul>
        </div>
    </div>
    <!-- CARDBAR END -->

    <!-- BREADCRUMBS START -->
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../">Szczep Pasieka</a></li>
            <li class="breadcrumb-item active">Kontakt</li>
        </ol>
    </div>
    <!-- BREADCRUMBS END -->

    <!-- MAIN CONTENT START -->
    <main>
        <div class="container">
            <div class="row">
                <section class="col-md-6 meeting-place-info mb-20">
                    <h2 class="text-uppercase">Harc??wka</h2>
                    <p>
                        ul. ??ubardzka 3
                        <br>
                        91-022 ????d??
                    </p>
                    <p>
                        Pawilon, I pi??tro, ??ciana po??udniowa (wej??cie od KSERO).
                    </p>

                    <h3 class="text-uppercase">Zbi??rki harcerek i harcerzy</h3>
                    <p>
                        Zbi??rki 22 ??DH-ek odbywaj?? si?? co drugi tydzie?? w <span class="meeting-info">PI??TKI&nbsp;o&nbsp;godz.&nbsp;17:30</span>.
                        <br>
                        Dodatkowo w tygodniach, w kt??rych nie ma zbi??rki dru??yny, odbywaj?? si?? zbi??rki zast??p??w w terminach ustalonych przez zast??py.
                        <br><br>
                        Zbi??rki II ??DH-rzy odbywaj?? si?? w <span class="meeting-info">CZWARTKI&nbsp;o&nbsp;godz.&nbsp;17:30</span>.
                        <br>
                        Dodatkowo raz w miesi??cu odbywa si?? zbi??rka zast??pu starszoharcerskiego.
                        <br><br>
                        Miejscem zbi??rek dru??yn harcerskich jest <span class="meeting-info">HARC??WKA</span>.
                        <br>
                        Je??eli miejsce spotkania b??dzie inne, taka informacja pojawi si?? na stronie.
                    </p>
                </section>

                <section class="col-md-6 meeting-place-info mb-20">
                    <h2 class="text-uppercase">Szko??a Podstawowa nr 56</h2>
                    <p>
                        ul. Turoszowska 10
                        <br>
                        91-025 ????d??
                    </p>
                    <p>
                        Korytarz, I pi??tro.
                    </p>

                    <h3 class="text-uppercase">Zbi??rki zuch??w</h3>
                    <p>
                        Zbi??rki ??GZ "Pracowite Pszcz????ki" odbywaj?? si?? w ka??dy <span class="meeting-info">PI??TEK&nbsp;o&nbsp;godz.&nbsp;17:30</span>.
                        <br>
                        Miejscem zbi??rek jest <span class="meeting-info">SZKO??A PODSTAWOWA nr 56</span>.
                    </p>
                </section>
            </div>

            <section id="komenda mb-30">
                <h2 class="text-uppercase">Komenda szczepu</h2>
                <div class="row">
                    <div class="business-card col-lg-6 d-flex flex-column">
                        <div class="top-bar"></div>
                        <div class="business-card-content">
                            <div class="person-info">
                                <div class="name">pwd. Marta Ko??laga HO</div>
                                <div class="function">Komendant Szczepu</div>
                                <div class="mail">marta.koslaga@zhp.net.pl</div>
                                <div class="phone">tel. 794 393 341</div>
                            </div>
                            <img src="../assets/site_team/pasieka/Marta.png" alt="">
                        </div>
                        <div class="bottom-bar"></div>
                    </div>
                    
                    <div class="business-card col-lg-6 d-flex flex-column">
                        <div class="top-bar"></div>
                        <div class="business-card-content">
                            <div class="person-info">
                                <div class="name">??w. Mateusz K??oa</div>
                                <div class="function">Z-ca Komendanta Szczepu</div>
                                <div class="mail">mateusz.kepa@zhp.net.pl</div>
                                <div class="phone">tel. 667 160 771</div>
                            </div>
                            <img src="../assets/site_team/pasieka/Mateusz.png" alt="">
                        </div>
                        <div class="bottom-bar"></div>
                    </div>
                </div>
            </section>

            <div class="row">
                <section class="col-lg-6">
                    <h2 class="text-uppercase">Przejd?? do kontaktu z jednostkami</h2>
                    <div class="contact-links-tiles">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                    viewBox="0 0 587.3 258.8" style="enable-background:new 0 0 587.3 258.8;" xml:space="preserve">

                            <g id="kontakt">
                                <a xlink:href="../22ldh/kontakt/" id="x22ldh-contact-link-tile">
                                    <polygon id="hexagon_22ldh-ek" class="st0 hexagon" points="254,103.7 194.3,103.7 164.5,155.3 194.3,207 254,207 283.8,155.3 	"/>
                                    <g id="x22ldh-ek_logo">
                                        <polygon class="st1" points="206.5,143.7 223.2,182.3 223.2,111.4 		"/>
                                        <polygon class="st1" points="205.3,149.1 206.1,169.8 219.7,182.4 		"/>
                                        <polygon class="st1" points="244.4,162.5 226.3,114.9 226.4,176.6 226.4,176.6 226.3,178.8 226.3,178.8 226.3,182.6 229.5,178.8 
                                            229.5,178.8 232.8,175.2 232.8,175.2 		"/>
                                        <path class="st2" d="M221.6,185.1"/>
                                        <path class="st2" d="M203.5,143.5"/>
                                        <polygon class="st1" points="232.1,196.4 236.1,194.9 239.6,191.1 228.8,185.7 226.2,188.5 		"/>
                                        <polygon class="st1" points="223.3,200.4 223.3,185.7 221.5,186.4 218.1,194.7 218.1,198.4 		"/>
                                        <polygon class="st1" points="206.9,193.1 219.6,186.9 218.6,185.7 205.1,184.5 205.1,188.7 		"/>
                                    </g>
                                    <path id="x22ldh-ek_title_bg" class="st0 title-bg" d="M147,170.3H3c-1.7,0-3-1.3-3-3v-24c0-1.7,1.3-3,3-3h147v27
                                        C150,169,148.7,170.3,147,170.3z"/>
                                    <g id="x22ldh-ek_title">
                                        <path class="st1" d="M15.2,159.7c0.2,0,0.3,0,0.4,0.1c0.1,0.1,0.1,0.2,0.1,0.3v0.8H8v-0.5c0-0.1,0-0.2,0.1-0.3
                                            c0-0.1,0.1-0.2,0.2-0.3l3.7-3.6c0.3-0.3,0.6-0.6,0.8-0.9c0.3-0.3,0.5-0.6,0.6-0.8c0.2-0.3,0.3-0.6,0.4-0.9
                                            c0.1-0.3,0.1-0.6,0.1-0.9s-0.1-0.6-0.2-0.9c-0.1-0.2-0.3-0.4-0.4-0.6c-0.2-0.2-0.4-0.3-0.7-0.4c-0.3-0.1-0.5-0.1-0.8-0.1
                                            s-0.6,0-0.8,0.1c-0.2,0.1-0.5,0.2-0.7,0.3c-0.2,0.1-0.3,0.3-0.5,0.5c-0.1,0.2-0.2,0.4-0.3,0.7c-0.1,0.2-0.2,0.3-0.3,0.4
                                            s-0.3,0.1-0.5,0.1L8,152.7c0.1-0.5,0.2-1,0.4-1.3c0.2-0.4,0.5-0.7,0.8-1c0.3-0.3,0.7-0.5,1.1-0.6c0.4-0.1,0.9-0.2,1.4-0.2
                                            s0.9,0.1,1.4,0.2c0.4,0.1,0.8,0.3,1.1,0.6c0.3,0.3,0.6,0.6,0.7,1c0.2,0.4,0.3,0.8,0.3,1.3c0,0.4-0.1,0.8-0.2,1.2
                                            c-0.1,0.4-0.3,0.7-0.5,1c-0.2,0.3-0.5,0.6-0.8,0.9s-0.6,0.6-0.9,0.9l-3,3c0.2-0.1,0.4-0.1,0.6-0.1s0.4-0.1,0.6-0.1h4.2V159.7z"/>
                                        <path class="st1" d="M24.5,159.7c0.2,0,0.3,0,0.4,0.1c0.1,0.1,0.1,0.2,0.1,0.3v0.8h-7.7v-0.5c0-0.1,0-0.2,0.1-0.3
                                            c0-0.1,0.1-0.2,0.2-0.3l3.7-3.6c0.3-0.3,0.6-0.6,0.8-0.9c0.3-0.3,0.5-0.6,0.6-0.8s0.3-0.6,0.4-0.9s0.1-0.6,0.1-0.9
                                            s-0.1-0.6-0.2-0.9c-0.1-0.2-0.3-0.4-0.4-0.6c-0.2-0.2-0.4-0.3-0.7-0.4c-0.3-0.1-0.5-0.1-0.8-0.1s-0.6,0-0.8,0.1
                                            c-0.2,0.1-0.5,0.2-0.7,0.3c-0.2,0.1-0.3,0.3-0.5,0.5c-0.1,0.2-0.2,0.4-0.3,0.7c-0.1,0.2-0.2,0.3-0.3,0.4c-0.1,0.1-0.3,0.1-0.5,0.1
                                            l-0.7-0.1c0.1-0.5,0.2-1,0.4-1.3c0.2-0.4,0.5-0.7,0.8-1c0.3-0.3,0.7-0.5,1.1-0.6c0.4-0.1,0.9-0.2,1.4-0.2s0.9,0.1,1.4,0.2
                                            c0.4,0.1,0.8,0.3,1.1,0.6c0.3,0.3,0.6,0.6,0.7,1c0.2,0.4,0.3,0.8,0.3,1.3c0,0.4-0.1,0.8-0.2,1.2c-0.1,0.4-0.3,0.7-0.5,1
                                            c-0.2,0.3-0.5,0.6-0.8,0.9s-0.6,0.6-0.9,0.9l-3,3c0.2-0.1,0.4-0.1,0.6-0.1s0.4-0.1,0.6-0.1h4.2V159.7z"/>
                                        <path class="st1" d="M38,159.8v1.3h-6.5v-4.3l-1.5,0.7v-1c0-0.1,0.1-0.2,0.2-0.3l1.3-0.7v-5.6H33v4.9l3.1-1.5v1
                                            c0,0.2-0.1,0.3-0.2,0.3l-2.9,1.5v3.7H38z"/>
                                        <path class="st1" d="M49.7,155.5c0,0.8-0.1,1.6-0.4,2.3c-0.3,0.7-0.7,1.3-1.2,1.8s-1.1,0.9-1.8,1.1c-0.7,0.3-1.5,0.4-2.3,0.4h-4.3
                                            v-11.2H44c0.8,0,1.6,0.1,2.3,0.4s1.3,0.6,1.8,1.1s0.9,1.1,1.2,1.8C49.5,153.9,49.7,154.7,49.7,155.5z M48.1,155.5
                                            c0-0.7-0.1-1.3-0.3-1.8s-0.5-1-0.8-1.4c-0.4-0.4-0.8-0.7-1.3-0.9c-0.5-0.2-1.1-0.3-1.7-0.3h-2.7v8.7H44c0.6,0,1.2-0.1,1.7-0.3
                                            s0.9-0.5,1.3-0.9c0.4-0.4,0.6-0.8,0.8-1.4C48,156.8,48.1,156.2,48.1,155.5z"/>
                                        <path class="st1" d="M61.2,149.9V161h-1.6v-5.1h-6.2v5.1h-1.6v-11.1h1.6v5h6.2v-5H61.2z"/>
                                        <path class="st1" d="M63.7,155.8h4v1.2h-4C63.7,157,63.7,155.8,63.7,155.8z"/>
                                        <path class="st1" d="M76.4,159.9c-0.2,0.2-0.4,0.4-0.6,0.5c-0.2,0.2-0.5,0.3-0.8,0.4s-0.6,0.2-0.9,0.2s-0.6,0.1-0.9,0.1
                                            c-0.6,0-1.1-0.1-1.6-0.3s-0.9-0.5-1.2-0.8c-0.3-0.4-0.6-0.8-0.8-1.3c-0.2-0.5-0.3-1.1-0.3-1.8c0-0.5,0.1-1.1,0.3-1.5
                                            c0.2-0.5,0.4-0.9,0.7-1.2c0.3-0.3,0.7-0.6,1.2-0.8s1-0.3,1.6-0.3c0.5,0,0.9,0.1,1.4,0.2c0.4,0.2,0.8,0.4,1.1,0.7
                                            c0.3,0.3,0.5,0.7,0.7,1.1c0.2,0.4,0.3,0.9,0.3,1.5c0,0.2,0,0.4-0.1,0.4c0,0.1-0.1,0.1-0.3,0.1h-5.4c0,0.5,0.1,0.9,0.2,1.3
                                            s0.3,0.7,0.5,0.9c0.2,0.2,0.5,0.4,0.8,0.6c0.3,0.1,0.7,0.2,1,0.2c0.4,0,0.7,0,0.9-0.1c0.3-0.1,0.5-0.2,0.7-0.3
                                            c0.2-0.1,0.3-0.2,0.5-0.3c0.2-0.1,0.2-0.1,0.3-0.1c0.1,0,0.2,0,0.3,0.1L76.4,159.9z M75.2,156.3c0-0.3,0-0.6-0.1-0.9
                                            c-0.1-0.3-0.2-0.5-0.4-0.7c-0.2-0.2-0.4-0.3-0.7-0.5c-0.3-0.1-0.5-0.2-0.9-0.2c-0.7,0-1.2,0.2-1.6,0.6c-0.4,0.4-0.6,0.9-0.7,1.6
                                            h4.4C75.2,156.2,75.2,156.3,75.2,156.3z"/>
                                        <path class="st1" d="M79.7,149.6v6.7H80c0.1,0,0.2,0,0.3,0c0.1,0,0.1-0.1,0.2-0.2l2.6-2.7c0.1-0.1,0.2-0.2,0.2-0.2
                                            c0.1,0,0.2-0.1,0.3-0.1H85l-3,3.1c-0.1,0.2-0.3,0.3-0.5,0.4c0.1,0.1,0.2,0.1,0.3,0.2c0.1,0.1,0.2,0.2,0.2,0.3l3.2,3.9h-1.3
                                            c-0.1,0-0.2,0-0.3-0.1c-0.1,0-0.2-0.1-0.2-0.2l-2.7-3.2c-0.1-0.1-0.2-0.2-0.2-0.2c-0.1,0-0.2-0.1-0.4-0.1h-0.4v3.8h-1.4v-11.4
                                            H79.7z"/>
                                        <path class="st1" d="M90.7,153.7c-0.2-0.4-0.4-0.8-0.5-1.2c-0.1-0.4-0.1-0.8,0-1.2c0.1-0.4,0.2-0.8,0.4-1.1c0.2-0.4,0.5-0.7,0.8-1
                                            l0.4,0.3c0.2,0,0.2,0,0.2,0.1c0,0.1,0,0.1-0.1,0.2c-0.1,0.2-0.3,0.4-0.4,0.6c-0.1,0.2-0.2,0.5-0.2,0.8s0,0.6,0,0.8
                                            c0.1,0.3,0.2,0.6,0.3,0.8c0.1,0.1,0.1,0.2,0.1,0.3c0,0.1-0.1,0.1-0.2,0.2L90.7,153.7z M93.1,153.7c-0.2-0.4-0.4-0.8-0.5-1.2
                                            c-0.1-0.4-0.1-0.8,0-1.2c0.1-0.4,0.2-0.8,0.4-1.1c0.2-0.3,0.5-0.7,0.8-1l0.4,0.3c0.1,0.1,0.1,0.1,0.1,0.2c0,0.1,0,0.1-0.1,0.2
                                            c-0.1,0.2-0.3,0.4-0.4,0.6s-0.2,0.5-0.2,0.8s0,0.6,0,0.8c0.1,0.3,0.2,0.6,0.3,0.8c0.1,0.1,0.1,0.2,0.1,0.3c0,0.1-0.1,0.1-0.2,0.2
                                            L93.1,153.7z"/>
                                        <path class="st1" d="M111.6,149.9L108,161h-1.4l-2.9-8.5c0-0.1-0.1-0.2-0.1-0.3c0-0.1,0-0.2-0.1-0.3c0,0.1-0.1,0.2-0.1,0.3
                                            c0,0.1-0.1,0.2-0.1,0.3l-2.9,8.5H99l-3.6-11.1h1.3c0.1,0,0.3,0,0.3,0.1c0.1,0.1,0.2,0.2,0.2,0.3l2.4,7.7c0,0.1,0.1,0.3,0.1,0.5
                                            s0.1,0.3,0.1,0.5c0-0.2,0.1-0.4,0.1-0.5c0-0.1,0.1-0.3,0.1-0.4l2.7-7.7c0-0.1,0.1-0.2,0.2-0.2c0.1-0.1,0.2-0.1,0.3-0.1h0.4
                                            c0.1,0,0.3,0,0.3,0.1c0.1,0.1,0.1,0.2,0.2,0.3l2.7,7.7c0,0.1,0.1,0.3,0.1,0.4c0,0.2,0.1,0.3,0.1,0.5c0-0.2,0.1-0.3,0.1-0.5
                                            c0-0.2,0.1-0.3,0.1-0.4l2.4-7.7c0-0.1,0.1-0.2,0.2-0.2c0.1-0.1,0.2-0.1,0.3-0.1h1.5C111.6,150.2,111.6,149.9,111.6,149.9z"/>
                                        <path class="st1" d="M111.8,154.3c0.4-0.4,0.9-0.7,1.5-0.9c0.5-0.2,1.1-0.3,1.7-0.3c0.5,0,0.9,0.1,1.2,0.2
                                            c0.4,0.1,0.6,0.3,0.9,0.6c0.2,0.3,0.4,0.6,0.5,0.9c0.1,0.4,0.2,0.8,0.2,1.2v5h-0.6c-0.1,0-0.2,0-0.3-0.1c-0.1,0-0.1-0.1-0.2-0.3
                                            l-0.2-0.7c-0.2,0.2-0.4,0.4-0.6,0.5c-0.2,0.1-0.4,0.3-0.6,0.4s-0.5,0.2-0.7,0.2c-0.3,0.1-0.5,0.1-0.8,0.1s-0.6,0-0.9-0.1
                                            c-0.3-0.1-0.5-0.2-0.7-0.4s-0.4-0.4-0.5-0.6c-0.1-0.3-0.2-0.6-0.2-0.9s0.1-0.6,0.3-0.9c0.2-0.3,0.5-0.5,0.9-0.8
                                            c0.4-0.2,0.9-0.4,1.5-0.5c0.6-0.1,1.4-0.2,2.3-0.2v-0.6c0-0.6-0.1-1.1-0.4-1.4c-0.3-0.3-0.7-0.5-1.2-0.5c-0.4,0-0.6,0-0.9,0.1
                                            c-0.2,0.1-0.4,0.2-0.6,0.3c-0.2,0.1-0.3,0.2-0.4,0.3c-0.1,0.1-0.2,0.1-0.4,0.1c-0.1,0-0.2,0-0.2-0.1c-0.1,0-0.1-0.1-0.2-0.2
                                            L111.8,154.3z M116.4,157.5c-0.7,0-1.2,0.1-1.7,0.2c-0.5,0.1-0.8,0.2-1.1,0.3c-0.3,0.1-0.5,0.3-0.6,0.5s-0.2,0.4-0.2,0.6
                                            s0,0.4,0.1,0.5c0.1,0.2,0.2,0.3,0.3,0.4c0.1,0.1,0.3,0.2,0.4,0.2c0.2,0,0.3,0.1,0.5,0.1c0.3,0,0.5,0,0.7-0.1
                                            c0.2,0,0.4-0.1,0.6-0.2c0.2-0.1,0.4-0.2,0.5-0.3c0.2-0.1,0.3-0.3,0.5-0.4C116.4,159.3,116.4,157.5,116.4,157.5z"/>
                                        <path class="st1" d="M122.4,161.2c-0.6,0-1.1-0.2-1.5-0.5c-0.3-0.3-0.5-0.8-0.5-1.5v-4.8h-1c-0.1,0-0.2,0-0.2-0.1
                                            c-0.1,0-0.1-0.1-0.1-0.2v-0.6l1.3-0.2l0.3-2.4c0-0.1,0.1-0.1,0.1-0.2c0.1,0,0.1-0.1,0.2-0.1h0.7v2.7h2.3v1h-2.3v4.7
                                            c0,0.3,0.1,0.6,0.2,0.7c0.2,0.2,0.4,0.2,0.6,0.2c0.1,0,0.3,0,0.4-0.1c0.1,0,0.2-0.1,0.3-0.1s0.1-0.1,0.2-0.1s0.1-0.1,0.1-0.1
                                            c0.1,0,0.1,0,0.2,0.1l0.4,0.7c-0.2,0.2-0.5,0.4-0.9,0.5C123.1,161.1,122.8,161.2,122.4,161.2z"/>
                                        <path class="st1" d="M127,154.8c0.3-0.5,0.6-1,0.9-1.3c0.4-0.3,0.8-0.5,1.4-0.5c0.2,0,0.3,0,0.5,0.1c0.2,0,0.3,0.1,0.4,0.2l-0.1,1
                                            c0,0.1-0.1,0.2-0.2,0.2c-0.1,0-0.2,0-0.3,0s-0.3,0-0.5,0c-0.3,0-0.5,0-0.7,0.1c-0.2,0.1-0.4,0.2-0.5,0.3c-0.2,0.1-0.3,0.3-0.4,0.5
                                            c-0.1,0.2-0.2,0.4-0.3,0.7v5h-1.4v-7.9h0.8c0.2,0,0.3,0,0.3,0.1c0.1,0.1,0.1,0.2,0.1,0.3L127,154.8z"/>
                                        <path class="st1" d="M131.1,154.3c0.4-0.4,0.9-0.7,1.5-0.9c0.5-0.2,1.1-0.3,1.7-0.3c0.5,0,0.9,0.1,1.2,0.2
                                            c0.4,0.1,0.6,0.3,0.9,0.6c0.2,0.3,0.4,0.6,0.5,0.9c0.1,0.4,0.2,0.8,0.2,1.2v5h-0.6c-0.1,0-0.2,0-0.3-0.1c-0.1,0-0.1-0.1-0.2-0.3
                                            l-0.2-0.7c-0.2,0.2-0.4,0.4-0.6,0.5c-0.2,0.1-0.4,0.3-0.6,0.4c-0.2,0.1-0.5,0.2-0.7,0.2c-0.3,0.1-0.5,0.1-0.8,0.1s-0.6,0-0.9-0.1
                                            c-0.3-0.1-0.5-0.2-0.7-0.4s-0.4-0.4-0.5-0.6c-0.1-0.3-0.2-0.6-0.2-0.9s0.1-0.6,0.3-0.9c0.2-0.3,0.5-0.5,0.9-0.8
                                            c0.4-0.2,0.9-0.4,1.5-0.5c0.6-0.1,1.4-0.2,2.3-0.2v-0.6c0-0.6-0.1-1.1-0.4-1.4c-0.3-0.3-0.7-0.5-1.2-0.5c-0.4,0-0.6,0-0.9,0.1
                                            c-0.2,0.1-0.4,0.2-0.6,0.3c-0.2,0.1-0.3,0.2-0.4,0.3c-0.1,0.1-0.2,0.1-0.4,0.1c-0.1,0-0.2,0-0.2-0.1c-0.1,0-0.1-0.1-0.2-0.2
                                            L131.1,154.3z M135.7,157.5c-0.7,0-1.2,0.1-1.7,0.2c-0.5,0.1-0.8,0.2-1.1,0.3c-0.3,0.1-0.5,0.3-0.6,0.5s-0.2,0.4-0.2,0.6
                                            s0,0.4,0.1,0.5c0.1,0.2,0.2,0.3,0.3,0.4s0.3,0.2,0.4,0.2c0.2,0,0.3,0.1,0.5,0.1c0.3,0,0.5,0,0.7-0.1c0.2,0,0.4-0.1,0.6-0.2
                                            c0.2-0.1,0.4-0.2,0.5-0.3c0.2-0.1,0.3-0.3,0.5-0.4V157.5z"/>
                                        <path class="st1" d="M140,149.2c0.2,0.4,0.4,0.8,0.5,1.2c0.1,0.4,0.1,0.8,0,1.2c-0.1,0.4-0.2,0.8-0.4,1.1c-0.2,0.4-0.5,0.7-0.8,1
                                            l-0.4-0.3c-0.1,0-0.1-0.1-0.1-0.2c0-0.1,0-0.1,0.1-0.2c0.1-0.2,0.3-0.4,0.4-0.6c0.1-0.2,0.2-0.5,0.2-0.8s0-0.6,0-0.8
                                            c-0.1-0.3-0.2-0.6-0.3-0.8c-0.1-0.1-0.1-0.2-0.1-0.3c0-0.1,0.1-0.1,0.2-0.2L140,149.2z M142.5,149.2c0.2,0.4,0.4,0.8,0.5,1.2
                                            c0.1,0.4,0.1,0.8,0,1.2c-0.1,0.4-0.2,0.8-0.4,1.1c-0.2,0.4-0.5,0.7-0.8,1l-0.4-0.3c-0.1,0-0.1-0.1-0.1-0.2c0-0.1,0-0.1,0.1-0.2
                                            c0.1-0.2,0.3-0.4,0.4-0.6c0.1-0.2,0.2-0.5,0.2-0.8s0-0.6,0-0.8c-0.1-0.3-0.2-0.6-0.3-0.8c-0.1-0.1-0.1-0.2-0.1-0.3
                                            c0-0.1,0.1-0.1,0.2-0.2L142.5,149.2z"/>
                                    </g>
                                </a>

                                <a xlink:href="../2ldh/kontakt/" id="x2ldh-contact-link-tile">
                                    <polygon id="hexagon_2ldh" class="st0 hexagon" points="254,0 194.3,0 164.5,51.7 194.3,103.3 254,103.3 283.8,51.7 	"/>
                                    <g id="x2ldh_logo">
                                        <polygon id="cross" class="st1" points="248.5,78.4 251.2,75.7 226.2,51.2 251.2,27.4 248.5,24.7 223.5,48.9 198.5,24.7 
                                            195.7,27.4 220.5,51.4 195.7,75.7 198.3,78.4 223.5,54.2 		"/>
                                        <rect id="i_left" x="219.3" y="22.1" class="st1" width="2.8" height="13.2"/>
                                        <rect id="i_right" x="225" y="22.1" class="st1" width="3" height="13.2"/>
                                        <polygon id="h_letter" class="st1" points="241.8,44.8 241.8,58.1 244.5,58.1 244.5,52.8 250,52.8 250,58.1 253,58.1 253,44.8 
                                            250,44.8 250,50.1 244.5,50.1 244.5,44.8 		"/>
                                        <polygon id="l_letter" class="st1" points="193.9,44.8 193.9,58.1 204.8,58.1 204.8,55.6 198.7,55.4 203.6,50.7 201.6,48.7 
                                            196.7,53.6 196.5,44.8 		"/>
                                        <path id="d_letter" class="st1" d="M222.5,70.9c0.8,0,3.5,0.4,3.3,3.3c0,3-2.8,3.3-3.9,3.5h-0.4v-6.9h1 M222.7,67.6h-4.5v13.6h3.9
                                            c0,0,7.1-0.2,7.1-6.7C229.4,67.8,222.7,67.6,222.7,67.6L222.7,67.6z"/>
                                    </g>
                                    <path id="x2ldh_title_bg" class="st0 title-bg" d="M381.6,66.4h-81c-1.7,0-3-1.3-3-3v-24c0-1.7,1.3-3,3-3h84v27
                                        C384.6,65.2,383.3,66.4,381.6,66.4z"/>
                                    <g id="x2ldh_title">
                                        <path class="st1" d="M306.7,56.1h-1.6V44h1.6V56.1z"/>
                                        <path class="st1" d="M311.2,56.1h-1.6V44h1.6V56.1z"/>
                                        <path class="st1" d="M324.9,54.8v1.4h-6.6v-4.7l-1.5,0.8v-1.1c0-0.2,0.1-0.3,0.2-0.3l1.3-0.7v-6h1.6v5.3l3.1-1.7V49
                                            c0,0.2-0.1,0.3-0.2,0.4l-2.9,1.6v4h5V54.8z"/>
                                        <path class="st1" d="M336.7,50.1c0,0.9-0.1,1.7-0.4,2.5c-0.3,0.7-0.7,1.4-1.2,1.9s-1.1,0.9-1.8,1.2c-0.7,0.3-1.5,0.4-2.3,0.4h-4.3
                                            V44h4.3c0.8,0,1.6,0.1,2.3,0.4c0.7,0.3,1.3,0.7,1.8,1.2s0.9,1.2,1.2,1.9C336.5,48.4,336.7,49.2,336.7,50.1z M335.1,50.1
                                            c0-0.7-0.1-1.4-0.3-2c-0.2-0.6-0.5-1.1-0.8-1.5c-0.4-0.4-0.8-0.7-1.3-0.9c-0.5-0.2-1.1-0.3-1.7-0.3h-2.8v9.5h2.8
                                            c0.6,0,1.2-0.1,1.7-0.3c0.5-0.2,0.9-0.5,1.3-0.9s0.6-0.9,0.8-1.5C335,51.5,335.1,50.8,335.1,50.1z"/>
                                        <path class="st1" d="M348.3,44v12.1h-1.6v-5.5h-6.2v5.5h-1.6V44h1.6v5.4h6.2V44H348.3z"/>
                                        <path class="st1" d="M350.8,50.4h4v1.3h-4V50.4z"/>
                                        <path class="st1" d="M358.3,49.3c0.3-0.6,0.6-1,1-1.4s0.8-0.5,1.4-0.5c0.2,0,0.3,0,0.5,0.1c0.2,0,0.3,0.1,0.4,0.2l-0.1,1.1
                                            c0,0.1-0.1,0.2-0.2,0.2s-0.2,0-0.3-0.1c-0.1,0-0.3-0.1-0.5-0.1c-0.3,0-0.5,0-0.7,0.1s-0.4,0.2-0.5,0.4c-0.2,0.2-0.3,0.3-0.4,0.6
                                            c-0.1,0.2-0.2,0.5-0.3,0.8v5.4h-1.4v-8.6h0.8c0.2,0,0.3,0,0.3,0.1c0.1,0.1,0.1,0.2,0.1,0.3L358.3,49.3z"/>
                                        <path class="st1" d="M368.4,48.2c0,0.1,0,0.2-0.1,0.3c0,0.1-0.1,0.2-0.1,0.3l-4.4,6.2h4.5v1.2h-6.2v-0.6c0-0.1,0-0.2,0-0.3
                                            c0-0.1,0.1-0.2,0.1-0.3l4.5-6.2h-4.4v-1.2h6.1L368.4,48.2L368.4,48.2z"/>
                                        <path class="st1" d="M377.1,47.6l-4.6,11.1c0,0.1-0.1,0.2-0.2,0.3c-0.1,0.1-0.2,0.1-0.3,0.1h-1.1l1.5-3.4l-3.4-8.1h1.2
                                            c0.1,0,0.2,0,0.3,0.1c0.1,0.1,0.1,0.1,0.1,0.2l2.2,5.4c0.1,0.2,0.2,0.5,0.2,0.7c0.1-0.3,0.2-0.5,0.2-0.8l2.1-5.4
                                            c0-0.1,0.1-0.2,0.2-0.2c0.1-0.1,0.2-0.1,0.3-0.1h1.3L377.1,47.6L377.1,47.6z"/>
                                    </g>
                                </a>

                                <a xlink:href="../zuchy/kontakt/" id="xlgzpp-contact-link-tile">
                                    <polygon id="hexagon_lgzpp" class="st0 hexagon" points="343.9,155.5 284.2,155.5 254.4,207.2 284.2,258.8 343.9,258.8 373.7,207.2 	"/>
                                    <g id="lgzpp_logo">
                                        <polygon class="st3" points="304.6,182.7 304.6,194 314.4,199.7 324.2,194 324.2,182.7 314.4,177 		"/>
                                        <polygon class="st4" points="287.7,199.7 287.7,215.1 301,222.8 314.4,215.1 314.4,199.7 301,192 		"/>
                                        <polygon class="st4" points="314.4,199.7 314.4,215.1 327.8,222.8 341.1,215.1 341.1,199.7 327.8,192 		"/>
                                        <g>
                                            <g>
                                                <polygon class="st1" points="314.4,213.6 299.8,222.1 299.8,228.4 314.4,220 329,228.4 329,222.1 				"/>
                                            </g>
                                            <g>
                                                <polygon class="st5" points="314.4,220 299.8,228.4 299.8,234.8 314.4,226.3 329,234.8 329,228.4 				"/>
                                            </g>
                                            <g>
                                                <polygon class="st1" points="314.4,226.3 299.8,234.8 299.8,239 301.6,240.1 314.4,232.7 325.3,239 327.2,240.1 329,239 
                                                    329,234.8 				"/>
                                            </g>
                                            <g>
                                                <polygon class="st5" points="314.4,232.7 301.6,240.1 307.1,243.2 307.1,243.2 307.1,243.2 307.5,243 307.5,243 307.5,243 
                                                    314.4,239 321.7,243.2 327.2,240.1 				"/>
                                            </g>
                                            <g>
                                                <polygon class="st1" points="314.4,247.4 321.7,243.2 314.4,239 307.1,243.2 				"/>
                                            </g>
                                        </g>
                                        <rect x="299.8" y="169.2" transform="matrix(0.5 -0.866 0.866 0.5 -2.3846 349.0372)" class="st1" width="2.5" height="14.7"/>
                                        <rect x="292" y="171.3" transform="matrix(0.5 0.866 -0.866 0.5 297.7275 -166.7236)" class="st1" width="2.5" height="6.3"/>
                                        <rect x="326.4" y="169.3" transform="matrix(-0.5 -0.866 0.866 -0.5 338.5179 548.6679)" class="st1" width="2.5" height="14.7"/>
                                        <rect x="334.2" y="171.4" transform="matrix(-0.5 0.866 -0.866 -0.5 654.3436 -28.7729)" class="st1" width="2.5" height="6.3"/>
                                    </g>
                                    <path id="lgzpp_title_bg" class="st0 title-bg" d="M579.7,222.2H391.6c-1.8,0-3.1-1.3-3.1-3v-24c0-1.7,1.3-3,3.1-3h191.2v27
                                        C582.8,220.8,581.4,222.2,579.7,222.2z"/>
                                    <g id="lgzpp_title">
                                        <path class="st1" d="M403.9,211.4v1.4h-6.5v-4.3l-1.5,0.7V208c0-0.2,0.1-0.3,0.2-0.3l1.2-0.7v-5.6h1.7v4.9l3-1.5v1.1
                                            c0,0.2-0.1,0.3-0.2,0.4l-2.8,1.4v3.7L403.9,211.4L403.9,211.4z"/>
                                        <path class="st1" d="M414.3,207.3v4.4c-0.6,0.4-1.2,0.7-1.8,0.9s-1.4,0.3-2.1,0.3c-0.9,0-1.7-0.1-2.5-0.4
                                            c-0.7-0.3-1.4-0.7-1.9-1.2s-0.9-1.1-1.2-1.8c-0.3-0.7-0.4-1.5-0.4-2.3c0-0.9,0.1-1.6,0.4-2.4c0.3-0.7,0.7-1.3,1.2-1.8
                                            s1.1-0.9,1.8-1.2c0.7-0.3,1.5-0.4,2.4-0.4c0.5,0,0.9,0,1.3,0.1s0.7,0.2,1.1,0.3c0.3,0.1,0.6,0.3,0.9,0.5s0.5,0.4,0.8,0.6l-0.5,0.8
                                            c-0.1,0.1-0.2,0.2-0.3,0.2c-0.1,0-0.3,0-0.4-0.1s-0.3-0.2-0.5-0.3s-0.4-0.2-0.6-0.3s-0.5-0.2-0.8-0.2c-0.3-0.1-0.7-0.1-1.1-0.1
                                            c-0.6,0-1.2,0.1-1.7,0.3s-0.9,0.5-1.3,0.9s-0.6,0.8-0.8,1.4c-0.2,0.5-0.3,1.1-0.3,1.8s0.1,1.3,0.3,1.9c0.2,0.6,0.5,1,0.9,1.4
                                            s0.8,0.7,1.3,0.9s1.1,0.3,1.8,0.3c0.3,0,0.5,0,0.7,0s0.4-0.1,0.6-0.1s0.4-0.1,0.6-0.2s0.4-0.2,0.6-0.3v-2.4h-1.7
                                            c-0.1,0-0.2,0-0.3-0.1c-0.1-0.1-0.1-0.1-0.1-0.2v-1h3.6V207.3z"/>
                                        <path class="st1" d="M424.3,202c0,0.2-0.1,0.4-0.2,0.5l-6.3,8.8h6.3v1.4h-8.5V212c0-0.1,0-0.2,0-0.3s0.1-0.2,0.1-0.2l6.3-8.8h-6.1
                                            v-1.4h8.3v0.7H424.3z"/>
                                        <path class="st1" d="M430.1,205.3c-0.2-0.4-0.4-0.8-0.5-1.2s-0.1-0.8,0-1.3c0.1-0.4,0.2-0.8,0.4-1.2c0.2-0.4,0.5-0.7,0.8-1
                                            l0.5,0.3c0.1,0.1,0.1,0.1,0.1,0.2c0,0.1,0,0.1-0.1,0.2c-0.1,0.2-0.2,0.4-0.3,0.6s-0.2,0.5-0.2,0.8s0,0.6,0,0.9s0.2,0.6,0.3,0.9
                                            c0.1,0.1,0.1,0.2,0.1,0.3s-0.1,0.2-0.2,0.2L430.1,205.3z M432.5,205.3c-0.2-0.4-0.4-0.8-0.5-1.2s-0.1-0.8,0-1.3
                                            c0.1-0.4,0.2-0.8,0.4-1.2c0.2-0.4,0.5-0.7,0.8-1l0.5,0.3c0.1,0.1,0.1,0.1,0.1,0.2c0,0.1,0,0.1-0.1,0.2c-0.1,0.2-0.2,0.4-0.3,0.6
                                            c-0.1,0.2-0.2,0.5-0.2,0.8s0,0.6,0,0.9c0.1,0.3,0.2,0.6,0.3,0.9c0.1,0.1,0.1,0.2,0.1,0.3s-0.1,0.2-0.2,0.2L432.5,205.3z"/>
                                        <path class="st1" d="M439.4,201.4c0.7,0,1.4,0.1,1.9,0.3s1,0.4,1.3,0.7c0.4,0.3,0.6,0.7,0.8,1.1c0.2,0.4,0.3,0.9,0.3,1.5
                                            c0,0.5-0.1,1-0.3,1.5c-0.2,0.4-0.5,0.8-0.8,1.2c-0.4,0.3-0.8,0.6-1.3,0.7c-0.5,0.2-1.2,0.3-1.8,0.3h-1.8v4.2H436v-11.4h3.4V201.4z
                                            M439.4,207.3c0.4,0,0.8-0.1,1.1-0.2c0.3-0.1,0.6-0.3,0.8-0.5s0.4-0.4,0.5-0.7s0.2-0.6,0.2-0.9c0-0.7-0.2-1.2-0.6-1.6
                                            c-0.4-0.4-1.1-0.6-2-0.6h-1.8v4.5H439.4z"/>
                                        <path class="st1" d="M446.6,206.3c0.3-0.5,0.6-0.9,0.9-1.2c0.4-0.3,0.8-0.5,1.3-0.5c0.2,0,0.3,0,0.5,0.1c0.2,0,0.3,0.1,0.4,0.2
                                            l-0.1,1.2c0,0.1-0.1,0.2-0.3,0.2c-0.1,0-0.2,0-0.3,0s-0.3,0-0.5,0s-0.5,0-0.7,0.1s-0.4,0.2-0.5,0.3s-0.3,0.3-0.4,0.5
                                            s-0.2,0.4-0.3,0.7v5h-1.5v-8h0.9c0.2,0,0.3,0,0.3,0.1s0.1,0.2,0.1,0.3L446.6,206.3z"/>
                                        <path class="st1" d="M450.6,205.9c0.4-0.4,0.9-0.7,1.5-1c0.5-0.2,1.1-0.3,1.7-0.3c0.5,0,0.9,0.1,1.2,0.2c0.4,0.1,0.7,0.4,0.9,0.6
                                            c0.2,0.3,0.4,0.6,0.5,1s0.2,0.8,0.2,1.2v5.1h-0.7c-0.2,0-0.3,0-0.3-0.1s-0.1-0.1-0.2-0.3l-0.2-0.7c-0.2,0.2-0.4,0.4-0.6,0.5
                                            s-0.4,0.3-0.6,0.4c-0.2,0.1-0.5,0.2-0.7,0.2c-0.2,0.1-0.5,0.1-0.8,0.1s-0.6,0-0.9-0.1s-0.5-0.2-0.7-0.4s-0.4-0.4-0.5-0.7
                                            s-0.2-0.6-0.2-0.9c0-0.3,0.1-0.6,0.3-0.9c0.2-0.3,0.5-0.6,0.8-0.8c0.4-0.2,0.9-0.4,1.5-0.6c0.6-0.1,1.4-0.2,2.3-0.3v-0.6
                                            c0-0.6-0.1-1.1-0.4-1.4c-0.3-0.3-0.6-0.5-1.1-0.5c-0.3,0-0.6,0-0.8,0.1c-0.2,0.1-0.4,0.2-0.6,0.3s-0.3,0.2-0.4,0.3
                                            s-0.3,0.1-0.4,0.1s-0.2,0-0.3-0.1c-0.1-0.1-0.1-0.1-0.2-0.2L450.6,205.9z M455.1,209.2c-0.6,0-1.2,0.1-1.6,0.1
                                            c-0.4,0.1-0.8,0.2-1.1,0.3c-0.3,0.1-0.5,0.3-0.6,0.4c-0.1,0.2-0.2,0.4-0.2,0.6c0,0.2,0,0.4,0.1,0.5s0.2,0.3,0.3,0.4
                                            c0.1,0.1,0.2,0.2,0.4,0.2c0.2,0,0.3,0.1,0.5,0.1s0.5,0,0.7-0.1c0.2,0,0.4-0.1,0.6-0.2s0.3-0.2,0.5-0.3s0.3-0.3,0.5-0.4
                                            L455.1,209.2L455.1,209.2z"/>
                                        <path class="st1" d="M464.3,206.2c0,0.1-0.1,0.1-0.1,0.1s-0.1,0.1-0.2,0.1s-0.2,0-0.3-0.1c-0.1-0.1-0.2-0.1-0.3-0.2
                                            c-0.1-0.1-0.3-0.1-0.5-0.2c-0.2-0.1-0.4-0.1-0.7-0.1c-0.4,0-0.7,0.1-1,0.2c-0.3,0.1-0.5,0.3-0.7,0.6s-0.3,0.6-0.4,0.9
                                            c-0.1,0.4-0.2,0.8-0.2,1.2c0,0.5,0.1,0.9,0.2,1.3s0.3,0.7,0.5,0.9c0.2,0.3,0.4,0.4,0.7,0.6c0.3,0.1,0.6,0.2,0.9,0.2s0.6,0,0.8-0.1
                                            c0.2-0.1,0.4-0.2,0.5-0.3s0.3-0.2,0.4-0.3s0.2-0.1,0.3-0.1c0.1,0,0.2,0,0.3,0.1l0.4,0.6c-0.2,0.2-0.4,0.4-0.6,0.6
                                            c-0.2,0.2-0.5,0.3-0.7,0.4c-0.3,0.1-0.5,0.2-0.8,0.2s-0.6,0.1-0.9,0.1c-0.5,0-1-0.1-1.4-0.3s-0.8-0.5-1.1-0.8
                                            c-0.3-0.4-0.6-0.8-0.8-1.3s-0.3-1.1-0.3-1.8c0-0.6,0.1-1.1,0.2-1.7c0.2-0.5,0.4-0.9,0.7-1.3c0.3-0.4,0.7-0.7,1.2-0.9
                                            s1-0.3,1.6-0.3s1.1,0.1,1.5,0.3s0.8,0.4,1.2,0.8L464.3,206.2z"/>
                                        <path class="st1" d="M469.5,204.6c0.6,0,1.1,0.1,1.6,0.3s0.9,0.5,1.2,0.8c0.3,0.4,0.6,0.8,0.8,1.3c0.2,0.5,0.3,1.1,0.3,1.7
                                            c0,0.6-0.1,1.2-0.3,1.7c-0.2,0.5-0.4,0.9-0.8,1.3c-0.3,0.4-0.7,0.6-1.2,0.8s-1,0.3-1.6,0.3s-1.1-0.1-1.6-0.3s-0.9-0.5-1.2-0.8
                                            c-0.3-0.4-0.6-0.8-0.8-1.3c-0.2-0.5-0.3-1.1-0.3-1.7c0-0.6,0.1-1.2,0.3-1.7s0.4-0.9,0.8-1.3c0.3-0.4,0.7-0.6,1.2-0.8
                                            C468.4,204.7,468.9,204.6,469.5,204.6z M469.5,211.7c0.8,0,1.3-0.3,1.7-0.8c0.4-0.5,0.6-1.2,0.6-2.2s-0.2-1.6-0.6-2.2
                                            c-0.4-0.5-0.9-0.8-1.7-0.8c-0.8,0-1.3,0.3-1.7,0.8c-0.4,0.5-0.6,1.2-0.6,2.2s0.2,1.6,0.6,2.2C468.2,211.4,468.8,211.7,469.5,211.7
                                            z"/>
                                        <path class="st1" d="M486.2,204.7l-2.6,8h-1.2c-0.1,0-0.2-0.1-0.3-0.3l-1.7-5.2c0-0.1-0.1-0.3-0.1-0.4c0-0.1-0.1-0.3-0.1-0.4
                                            c0,0.3-0.1,0.5-0.2,0.8l-1.7,5.2c-0.1,0.2-0.2,0.3-0.3,0.3h-1.2l-2.6-8h1.2c0.1,0,0.2,0,0.3,0.1c0.1,0.1,0.1,0.1,0.2,0.2l1.4,4.9
                                            c0,0.2,0.1,0.4,0.1,0.6c0,0.2,0.1,0.4,0.1,0.6c0-0.2,0.1-0.4,0.2-0.6s0.1-0.4,0.2-0.6l1.6-5c0-0.1,0.1-0.2,0.1-0.2
                                            c0.1-0.1,0.2-0.1,0.3-0.1h0.7c0.1,0,0.2,0,0.3,0.1c0.1,0.1,0.1,0.1,0.2,0.2l1.6,5c0.1,0.2,0.1,0.4,0.2,0.6
                                            c0.1,0.2,0.1,0.4,0.1,0.6c0-0.2,0.1-0.4,0.1-0.6c0-0.2,0.1-0.4,0.1-0.6l1.5-4.9c0-0.1,0.1-0.2,0.2-0.2c0.1-0.1,0.2-0.1,0.3-0.1
                                            L486.2,204.7L486.2,204.7z"/>
                                        <path class="st1" d="M489.4,202.3c0,0.1,0,0.3-0.1,0.4c-0.1,0.1-0.1,0.2-0.2,0.3s-0.2,0.2-0.3,0.2c-0.1,0.1-0.3,0.1-0.4,0.1
                                            s-0.3,0-0.4-0.1s-0.2-0.1-0.3-0.2c-0.1-0.1-0.2-0.2-0.2-0.3c-0.1-0.1-0.1-0.3-0.1-0.4c0-0.1,0-0.3,0.1-0.4
                                            c0.1-0.1,0.1-0.2,0.2-0.3s0.2-0.2,0.3-0.2c0.1-0.1,0.3-0.1,0.4-0.1s0.3,0,0.4,0.1s0.2,0.1,0.3,0.2c0.1,0.1,0.2,0.2,0.2,0.3
                                            C489.4,202,489.4,202.1,489.4,202.3z M489.1,204.7v8h-1.5v-8H489.1z"/>
                                        <path class="st1" d="M493.8,212.9c-0.6,0-1.1-0.2-1.5-0.5c-0.4-0.4-0.5-0.9-0.5-1.6V206h-0.9c-0.1,0-0.2,0-0.2-0.1
                                            s-0.1-0.1-0.1-0.2V205l1.3-0.2l0.3-2.4c0-0.1,0.1-0.2,0.1-0.2s0.1-0.1,0.2-0.1h0.8v2.7h2.3v1.1h-2.3v4.7c0,0.3,0.1,0.6,0.2,0.7
                                            s0.4,0.2,0.6,0.2c0.1,0,0.3,0,0.4-0.1c0.1,0,0.2-0.1,0.3-0.1s0.1-0.1,0.2-0.1s0.1-0.1,0.1-0.1c0.1,0,0.1,0,0.1,0l0.1,0.1l0.5,0.7
                                            c-0.3,0.2-0.6,0.4-0.9,0.5C494.6,212.8,494.2,212.9,493.8,212.9z"/>
                                        <path class="st1" d="M503.6,211.6c-0.2,0.2-0.4,0.4-0.7,0.6s-0.5,0.3-0.8,0.4c-0.3,0.1-0.6,0.2-0.9,0.2s-0.6,0.1-0.9,0.1
                                            c-0.6,0-1.1-0.1-1.5-0.3c-0.5-0.2-0.9-0.5-1.2-0.8s-0.6-0.8-0.8-1.3c-0.2-0.5-0.3-1.2-0.3-1.8s0.1-1.1,0.3-1.6s0.4-0.9,0.7-1.3
                                            s0.7-0.6,1.2-0.8s1-0.3,1.6-0.3c0.5,0,0.9,0.1,1.4,0.2c0.4,0.2,0.8,0.4,1.1,0.7c0.3,0.3,0.5,0.7,0.7,1.1c0.2,0.4,0.3,1,0.3,1.5
                                            c0,0.2,0,0.4-0.1,0.5s-0.1,0.1-0.3,0.1h-5.3c0,0.5,0.1,0.9,0.2,1.3s0.3,0.7,0.5,0.9s0.5,0.4,0.8,0.5s0.6,0.2,1,0.2
                                            c0.3,0,0.6,0,0.9-0.1s0.5-0.2,0.6-0.3c0.2-0.1,0.3-0.2,0.5-0.3s0.2-0.1,0.3-0.1c0.1,0,0.2,0,0.3,0.1L503.6,211.6z M502.3,207.9
                                            c0-0.3,0-0.6-0.1-0.8c-0.1-0.3-0.2-0.5-0.4-0.7c-0.2-0.2-0.4-0.3-0.6-0.4c-0.2-0.1-0.5-0.2-0.8-0.2c-0.6,0-1.2,0.2-1.5,0.6
                                            c-0.4,0.4-0.6,0.9-0.7,1.6h4.1V207.9z"/>
                                        <path class="st1" d="M513.1,201.4c0.7,0,1.4,0.1,1.9,0.3s1,0.4,1.3,0.7c0.4,0.3,0.6,0.7,0.8,1.1c0.2,0.4,0.3,0.9,0.3,1.5
                                            c0,0.5-0.1,1-0.3,1.5c-0.2,0.4-0.5,0.8-0.8,1.2c-0.4,0.3-0.8,0.6-1.3,0.7c-0.5,0.2-1.2,0.3-1.8,0.3h-1.8v4.2h-1.7v-11.4h3.4
                                            L513.1,201.4L513.1,201.4z M513.1,207.3c0.4,0,0.8-0.1,1.1-0.2c0.3-0.1,0.6-0.3,0.8-0.5s0.4-0.4,0.5-0.7s0.2-0.6,0.2-0.9
                                            c0-0.7-0.2-1.2-0.6-1.6c-0.4-0.4-1.1-0.6-2-0.6h-1.8v4.5H513.1z"/>
                                        <path class="st1" d="M523.5,206.1c0,0.1-0.1,0.1-0.1,0.1s-0.1,0-0.2,0c-0.1,0-0.2,0-0.3-0.1s-0.2-0.1-0.4-0.2
                                            c-0.1-0.1-0.3-0.1-0.5-0.2c-0.2-0.1-0.4-0.1-0.7-0.1c-0.2,0-0.4,0-0.6,0.1s-0.3,0.1-0.5,0.2c-0.1,0.1-0.2,0.2-0.3,0.3
                                            s-0.1,0.3-0.1,0.4c0,0.2,0.1,0.4,0.2,0.5c0.1,0.1,0.3,0.2,0.5,0.3s0.4,0.2,0.7,0.3s0.5,0.2,0.8,0.2s0.5,0.2,0.8,0.3
                                            c0.2,0.1,0.5,0.2,0.7,0.4s0.3,0.4,0.5,0.6c0.1,0.2,0.2,0.5,0.2,0.8c0,0.4-0.1,0.7-0.2,1c-0.1,0.3-0.3,0.6-0.6,0.8s-0.6,0.4-1,0.5
                                            s-0.8,0.2-1.3,0.2c-0.6,0-1.1-0.1-1.5-0.3c-0.5-0.2-0.9-0.4-1.2-0.7l0.4-0.6c0-0.1,0.1-0.1,0.2-0.2c0.1,0,0.1-0.1,0.3-0.1
                                            c0.1,0,0.2,0,0.3,0.1s0.2,0.2,0.4,0.2s0.3,0.2,0.5,0.2c0.2,0.1,0.5,0.1,0.8,0.1s0.5,0,0.7-0.1s0.4-0.2,0.5-0.3s0.2-0.2,0.3-0.4
                                            s0.1-0.3,0.1-0.5s-0.1-0.4-0.2-0.5c-0.1-0.1-0.3-0.3-0.5-0.4c-0.2-0.1-0.4-0.2-0.7-0.3s-0.5-0.2-0.8-0.2c-0.3-0.1-0.5-0.2-0.8-0.3
                                            c-0.2-0.1-0.5-0.2-0.7-0.4s-0.3-0.4-0.5-0.6c-0.1-0.2-0.2-0.5-0.2-0.9c0-0.3,0.1-0.6,0.2-0.9s0.3-0.5,0.6-0.8s0.5-0.4,0.9-0.5
                                            s0.8-0.2,1.2-0.2c0.5,0,1,0.1,1.4,0.3s0.8,0.4,1.1,0.7L523.5,206.1z"/>
                                        <path class="st1" d="M531.2,205.4c0,0.1,0,0.2-0.1,0.3c0,0.1-0.1,0.2-0.2,0.3l-4.2,5.6h4.3v1.2h-6v-0.6c0-0.1,0-0.2,0.1-0.3
                                            s0.1-0.2,0.2-0.3l4.2-5.6h-4.2v-1.2h6L531.2,205.4L531.2,205.4z"/>
                                        <path class="st1" d="M538.3,206.2c0,0.1-0.1,0.1-0.1,0.1s-0.1,0.1-0.2,0.1s-0.2,0-0.3-0.1s-0.2-0.1-0.3-0.2
                                            c-0.1-0.1-0.3-0.1-0.5-0.2c-0.2-0.1-0.4-0.1-0.7-0.1c-0.4,0-0.7,0.1-1,0.2c-0.3,0.1-0.5,0.3-0.7,0.6s-0.3,0.6-0.4,0.9
                                            c-0.1,0.4-0.2,0.8-0.2,1.2c0,0.5,0.1,0.9,0.2,1.3s0.3,0.7,0.5,0.9c0.2,0.3,0.4,0.4,0.7,0.6c0.3,0.1,0.6,0.2,0.9,0.2
                                            c0.3,0,0.6,0,0.8-0.1s0.4-0.2,0.5-0.3s0.3-0.2,0.4-0.3s0.2-0.1,0.3-0.1s0.2,0,0.3,0.1l0.4,0.6c-0.2,0.2-0.4,0.4-0.6,0.6
                                            c-0.2,0.2-0.5,0.3-0.7,0.4c-0.3,0.1-0.5,0.2-0.8,0.2s-0.6,0.1-0.9,0.1c-0.5,0-1-0.1-1.4-0.3s-0.8-0.5-1.1-0.8
                                            c-0.3-0.4-0.6-0.8-0.8-1.3s-0.3-1.1-0.3-1.8c0-0.6,0.1-1.1,0.2-1.7c0.2-0.5,0.4-0.9,0.7-1.3c0.3-0.4,0.7-0.7,1.2-0.9
                                            s1-0.3,1.6-0.3s1.1,0.1,1.5,0.3s0.8,0.4,1.2,0.8L538.3,206.2z"/>
                                        <path class="st1" d="M545.8,205.4c0,0.1,0,0.2-0.1,0.3c0,0.1-0.1,0.2-0.2,0.3l-4.2,5.6h4.3v1.2h-6.1v-0.6c0-0.1,0-0.2,0.1-0.3
                                            s0.1-0.2,0.2-0.3l4.2-5.6h-4.2v-1.2h6V205.4z"/>
                                        <path class="st1" d="M550.7,204.6c0.6,0,1.1,0.1,1.6,0.3s0.9,0.5,1.2,0.8c0.3,0.4,0.6,0.8,0.8,1.3s0.3,1.1,0.3,1.7
                                            c0,0.6-0.1,1.2-0.3,1.7s-0.4,0.9-0.8,1.3c-0.3,0.4-0.7,0.6-1.2,0.8s-1,0.3-1.6,0.3s-1.1-0.1-1.6-0.3s-0.9-0.5-1.2-0.8
                                            c-0.3-0.4-0.6-0.8-0.8-1.3s-0.3-1.1-0.3-1.7c0-0.6,0.1-1.2,0.3-1.7s0.4-0.9,0.8-1.3c0.3-0.4,0.7-0.6,1.2-0.8
                                            C549.5,204.7,550.1,204.6,550.7,204.6z M550.7,211.7c0.8,0,1.3-0.3,1.7-0.8s0.6-1.2,0.6-2.2s-0.2-1.6-0.6-2.2
                                            c-0.4-0.5-0.9-0.8-1.7-0.8s-1.3,0.3-1.7,0.8s-0.6,1.2-0.6,2.2s0.2,1.6,0.6,2.2C549.3,211.4,549.9,211.7,550.7,211.7z M553.1,201.3
                                            l-1.9,2c-0.1,0.1-0.2,0.2-0.2,0.2s-0.2,0.1-0.3,0.1h-0.9l1.2-1.9c0.1-0.1,0.2-0.2,0.2-0.3s0.2-0.1,0.4-0.1H553.1z"/>
                                        <path class="st1" d="M559.9,204.8v0.9c0,0.2-0.1,0.3-0.2,0.4l-1.2,0.5v6.2H557v-5.7l-1.4,0.6v-0.9c0-0.2,0.1-0.3,0.2-0.3l1.2-0.5
                                            v-4.8h1.5v4.3L559.9,204.8z"/>
                                        <path class="st1" d="M562.7,201.1v6.8h0.4c0.1,0,0.2,0,0.3,0s0.2-0.1,0.2-0.2l2.4-2.6c0.1-0.1,0.2-0.2,0.2-0.2
                                            c0.1-0.1,0.2-0.1,0.3-0.1h1.4l-2.8,3.1c-0.2,0.2-0.3,0.3-0.5,0.5c0.1,0.1,0.2,0.1,0.3,0.2s0.2,0.2,0.2,0.3l3,3.9h-1.4
                                            c-0.1,0-0.2,0-0.3-0.1c-0.1,0-0.2-0.1-0.2-0.2l-2.5-3.2c-0.1-0.1-0.2-0.2-0.2-0.2c-0.1,0-0.2-0.1-0.4-0.1h-0.4v3.8h-1.5v-11.7
                                            H562.7z"/>
                                        <path class="st1" d="M571.2,202.3c0,0.1,0,0.3-0.1,0.4c-0.1,0.1-0.1,0.2-0.2,0.3c-0.1,0.1-0.2,0.2-0.3,0.2
                                            c-0.1,0.1-0.3,0.1-0.4,0.1c-0.1,0-0.3,0-0.4-0.1c-0.1-0.1-0.2-0.1-0.3-0.2c-0.1-0.1-0.2-0.2-0.2-0.3c-0.1-0.1-0.1-0.3-0.1-0.4
                                            c0-0.1,0-0.3,0.1-0.4c0.1-0.1,0.1-0.2,0.2-0.3s0.2-0.2,0.3-0.2c0.1-0.1,0.3-0.1,0.4-0.1c0.1,0,0.3,0,0.4,0.1
                                            c0.1,0.1,0.2,0.1,0.3,0.2c0.1,0.1,0.2,0.2,0.2,0.3C571.2,202,571.2,202.1,571.2,202.3z M570.9,204.7v8h-1.5v-8H570.9z"/>
                                        <path class="st1" d="M574.2,200.7c0.2,0.4,0.4,0.8,0.5,1.2s0.1,0.8,0,1.3s-0.2,0.8-0.4,1.2s-0.5,0.7-0.8,1l-0.5-0.3
                                            c-0.1-0.1-0.1-0.1-0.1-0.2c0-0.1,0-0.1,0.1-0.2c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.2,0.2-0.5,0.2-0.8s0-0.6,0-0.9
                                            c-0.1-0.3-0.2-0.6-0.3-0.9c-0.1-0.1-0.1-0.2-0.1-0.3s0.1-0.2,0.2-0.2L574.2,200.7z M576.7,200.7c0.2,0.4,0.4,0.8,0.5,1.2
                                            s0.1,0.8,0,1.3c-0.1,0.4-0.2,0.8-0.4,1.2s-0.5,0.7-0.8,1l-0.5-0.3c-0.1-0.1-0.1-0.1-0.1-0.2s0-0.1,0.1-0.2
                                            c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.2,0.2-0.5,0.2-0.8s0-0.6,0-0.9c-0.1-0.3-0.2-0.6-0.3-0.9c-0.1-0.1-0.1-0.2-0.1-0.3
                                            s0.1-0.2,0.2-0.2L576.7,200.7z"/>
                                    </g>
                                </a>
                                <line id="line_2ldh-22ldh" class="st6" x1="254.3" y1="103.5" x2="194.2" y2="103.5"/>
                                <line id="line_lgzpp-22ldh" class="st6" x1="254.2" y1="207.2" x2="284" y2="155.5"/>
                            </g>
                        </svg>
                    </div>
                </section>

                <section class="col-lg-6" id="email-us">
                    <h2 class="text-uppercase">Napisz do nas</h2>
                    <span class="form-email-address">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        pasieka.zhp@gmail.com
                    </span>

                    <form method="post">
                        <div class="form-group">
                            <label for="name">Imi?? i nazwisko</label>
                            <input type="text" class="form-control" id="name" name="name" value="">

                            <?php
                                if(isset($errors['errName'])) {
                                    echo '<small class="form-text text-danger">'.$errors['errName'].'</small>';
                                }
                            ?>

                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="">

                            <?php
                                if(isset($errors['errEmail'])) {
                                    echo '<small class="form-text text-danger">'.$errors['errEmail'].'</small>';
                                }
                            ?>

                        </div>
                        <div class="form-group">
                            <label for="message">Tre???? wiadomo??ci:</label>
                            <textarea class="form-control" name="message" id="message" rows="10"><?php if(isset($_SESSION['preMessage'])) {echo $_SESSION['preMessage']; unset($_SESSION['preMessage']);} ?></textarea>

                            <?php
                                if(isset($errors['errMessage'])) {
                                    echo '<small class="form-text text-danger">'.$errors['errMessage'].'</small>';
                                }
                            ?>

                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" id="rodo-check" name="rodo" required>
                            <label id="rodo-label" class="form-check-label" for="rodo-check">
                                <small>
                                    Zapozna??am/em si?? z
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="top" data-trigger="click" data-html="true" data-container="body" data-title="<p>Wyra??am zgod?? na przetwarzanie moich danych osobowych zgodnie z ustaw?? o ochronie danych osobowych w celach wy????cznie kontaktowych.</p><p>Administratorem Twoich danych osobowych jest komenda Szczepu Harcerskiego Pasieka (ul. ??ubardzka 3, 91-022 ????d??). Podanie danych osobowych jest dobrowolne, jednak niezb??dne do utrzymania korenspondencji mailowej. Zosta??am/em poinformowana/y, ??e przys??uguje mi prawo dost??pu do swoich danych, mo??liwo??ci ich poprawienia oraz ????dania zaprzestania ich przetwarzania.</p>">
                                            <a href="#" style="pointer-events: none;" disabled>informacj?? o administratorze i przetwarzaniu danych</a>
                                    </span>
                                </small>
                            </label>
                        </div>

                            <?php
                                if(isset($errors['errRODO'])) {
                                    echo '<small class="form-text text-danger">'.$errors['errRODO'].'</small>';
                                }
                            ?>

                        <div class="g-recaptcha" data-sitekey="6LdKtTcUAAAAANcEIcS8ZY4Dee3ENqWXNDpxYgA0"></div>

                            <?php
                                if(isset($errors['errCaptcha'])) {
                                    echo '<small class="form-text text-danger">'.$errors['errCaptcha'].'</small>';
                                }
                            ?>

                        <button type="submit" class="btn bg-black my-3" name="submit">Wy??lij</button>

                        <?php
                            if($isValid) {
                                if(isset($sendSuccessMsg)) {
                                    echo '<div class="alert alert-success alert-custom-valid"><i class="fa fa-check mr-2" aria-hidden="true"></i>'.$sendSuccessMsg.'</div>';
                                } else if(isset($sendErrorMsg)) {
                                    echo '<div class="alert alert-danger alert-custom-invalid"><i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>'.$sendErrorMsg.'</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger alert-custom-invalid"><i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>Wiadomo???? nie zosta??a wys??ana.<br/>Przynajmniej jedno pole zosta??o b????dnie wype??nione.</div>';
                            }
                        ?>

                    </form>
                </section>
            </div>
        </div>
    </main>
    <!-- MAIN CONTENT END -->

    <!-- SOCIAL MEDIA START -->
    <div class="social-media-bar container-fluid d-flex justify-content-center">
      <div class="social-item fb">
        <a class="d-inline-flex align-items-center justify-content-center" href="https://www.facebook.com/Szczep-Harcerski-Pasieka-502292589937213/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
      </div>
      <div class="social-item ig">
        <a class="d-inline-flex align-items-center justify-content-center" href="https://instagram.com/shpasieka?igshid=ue5wdf4zyrf3" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
      </div>
      <div class="social-item yt">
        <a class="social-link-disabled d-inline-flex align-items-center justify-content-center" href="#" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
      </div>
    </div> <!-- /.social-media-bar -->
    <!-- SOCIAL MEDIA END -->

    <!-- FOOTER START -->
    <footer class="pt-5">
        <div class="footer-sidebar pb-30">
            <div class="container">
                <div class="row">
                    <div class="sites-links col-md-5 d-flex flex-column">
                        <div class="f-sidebar-heading d-flex flex-column align-items-start">
                            <span class="text-uppercase mb-2">Przydatne linki</span>
                            <span class="text-uppercase">Jednostki szczepu</span>
                        </div> <!-- /.f-sidebar-heading -->
                        <div class="teams-sites-links d-flex flex-column">
                            <a href="../../2ldh/" class="team-site-link d-flex align-items-center mt-3" target="_blank">
                                <img src="../../assets/logotypes_teams/2ldh_logo_white.svg" alt="#">
                                <span class="team-name ml-3">II ??DH-rzy</span>
                            </a> <!-- /.team-site-link -->
                            <a href="../../22ldh/" class="team-site-link d-flex align-items-center mt-3" target="_blank">
                                <img src="../../assets/logotypes_teams/22ldh_logo_white.svg" alt="#">
                                <span class="team-name ml-3">22 ??DH-ek "Watra"</span>
                            </a> <!-- /.team-site-link -->
                            <a href="../../zuchy/" class="team-site-link d-flex align-items-center mt-3" target="_blank">
                                <img src="../../assets/logotypes_teams/lgzpp_logo_white.svg" alt="#">
                                <span class="team-name ml-3">??GZ "Pracowite Pszcz????ki"</span>
                            </a> <!-- /.team-site-link -->
                        </div> <!-- /.teams-sites-links -->
                    </div> <!-- /.sites-links -->

                    <hr class="d-md-none">

                    <div class="partnerships-container col-md-7 d-flex justify-content-between justify-content-lg-end">
                        <a class="partner-logo-link" href="http://lodzka.zhp.pl" target="_blank">
                            <img src="../../assets/logotypes_partnerships/LogoCHL_PNG_White.png" alt="Logotyp Chor??gwi ????dzkiej">
                        </a> <!-- /.partner-logo-link -->
                        <a class="partner-logo-link ml-lg-4" href="https://zhp.pl" target="_blank">
                            <img src="../../assets/logotypes_partnerships/IdentyfikatorZHP_PNG_White.png" alt="Logotyp Zwi??zku Harcerstwa Polskiego">
                        </a> <!-- /.partner-logo-link -->
                        <a class="partner-logo-link ml-lg-4" href="https://www.scout.org" target="_blank">
                            <img src="../../assets/logotypes_partnerships/LogoSCOUT_EN_PNG_White.png" alt="Logotyp WOSM">
                        </a> <!-- /.partner-logo-link -->
                    </div> <!-- /.partnerships-container -->
                </div>
            </div>
        </div> <!-- /.footer-sidebar -->

        <div class="footer-copyright container-fluid d-flex justify-content-center py-3">
            <div class="f-copy-text d-flex flex-wrap">
                <span class="text-site-rights">Copyright &copy; 2018 Szczep Harcerski Pasieka</span>
                <span class="text-site-breakline mx-2">|</span>
                <span class="text-site-created">Created by Mateusz K??pa</span>
            </div> <!-- /.f-copy-text -->
        </div> <!-- /.footer-copyright -->
    </footer>
    <!-- FOOTER END -->

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <script src="../../js/sticky-bar.js"></script>
</body>
</html>