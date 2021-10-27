<?php
    require_once("dbconnect.php");

    $result = $sql->query("SELECT * FROM news WHERE id='".(int)$_GET['id']."'");
    $news = $result->fetch_assoc();

    $result->free();
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

    <title>Aktualności | Szczep Harcerski Pasieka</title>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../styles/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,500,700|Roboto:400,500,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="../../fonts/museo_500/font-museo_500.css">
    <link rel="stylesheet" href="../../fonts/museo_300/font-museo_300.css">
    <script src="https://use.fontawesome.com/2127fd32bd.js"></script>
    <link rel="stylesheet" href="../../styles/main.css">
    <link rel="stylesheet" href="../../styles/aktualnosci.css">
    <link rel="stylesheet" href="../../styles/news.css">
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
                        <li class="nav-item active">
                            <a class="nav-link" href="../">Aktualności <span class="sr-only">(aktulny)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../historia-szczepu/">Historia</a>
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
                        <li class="nav-item">
                            <a class="nav-link" href="../../kontakt/">Kontakt</a>
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
            <img src="../../assets/hexagons_teams/hexagon_2ldh.svg" alt="Czarny sześciokąt z logiem II ŁDH-rzy">
            <div class="widget-item-text">II ŁDH-rzy</div>
        </a>
        <a href="../../22ldh/" class="widget-item d-flex align-items-center">
            <img src="../../assets/hexagons_teams/hexagon_22ldh.svg" alt="Czarny sześciokąt z logiem II ŁDH-rzy">
            <div class="widget-item-text">22 ŁDH-ek "Watra"</div>
        </a>
        <a href="../../zuchy/" class="widget-item d-flex align-items-center">
            <img src="../../assets/hexagons_teams/hexagon_lgzpp.svg" alt="Czarny sześciokąt z logiem II ŁDH-rzy">
            <div class="widget-item-text">ŁGZ "Pracowite Pszczółki"</div>
        </a>
    </div>
    <!-- SLIDEOUT WIDGET END -->

    <!-- CARDBAR START -->
    <div class="cardbar">
        <div class="container d-flex align-items-center">
            <span class="card-title">Aktualności</span>
            <ul class="subpages-list">
                <a href="https://calendar.google.com/calendar?cid=cGFzaWVrYS56aHBAZ21haWwuY29t" target="_blank"><li>Kalendarz</li></a>
            </ul>
        </div>
    </div>
    <!-- CARDBAR END -->

    <!-- BREADCRUMBS START -->
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../">Szczep Pasieka</a></li>
            <li class="breadcrumb-item"><a href="../">Aktualności</a></li>
            <li class="breadcrumb-item active"><?php echo $news["title"]; ?></li>
        </ol>
    </div>
    <!-- BREADCRUMBS END -->

    <!-- MAIN CONTENT START -->
    <main>
        <div class="container">
            <div class="row">
                <article class="col-md-8">
                    <section class="entry-info">
                        <h2 class="entry-title"><?php echo $news["title"]; ?></h2>
                        <div class="meta-info">
                            <span class="entry-author"><?php echo $news["author"]; ?></span>
                            <span class="entry-date"><?php echo $news["published_on"]; ?></span>
                        </div>
                    </section>

                    <div class="content-separator entry-cat-<?php echo $news["category"]; ?>"><?php echo $news["category"]; ?></div>

                    <img src="../../assets/news/<?php echo $news["photo_name"]; ?>" class="img-fluid" alt="Alternative text">

                    <section class="entry-content">
                        <?php echo $news["article"]; ?>
                    </section>

                    <div class="article-separator-end"></div>

                    <section class="share d-flex justify-content-end">
                        <span>Udostępnij</span>
                        <div class="social-media-share-icons">
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        </div>
                    </section>
                </article>

                <aside class="col-md-4">
                    <section class="last-entries">
                        <h3 class="text-uppercase">Ostatnie wpisy</h3>

                        <?php
                            $last_entries = $sql->query("SELECT title, published_on, id FROM news ORDER BY id DESC LIMIT 5");

                            while($entry = $last_entries->fetch_assoc()) {

                                $list_item .= '<li class="last-entry d-flex">';
                                    $list_item .= '<a href="../news-id='.$entry["id"].'/" class="last-entry-img mr-3">';
                                        $list_item .= '<i class="fa fa-external-link" aria-hidden="true"></i>';
                                    $list_item .= '</a>';
                                    $list_item .= '<div class="last-entry-info d-flex flex-column justify-content-center">';
                                        $list_item .= '<span class="last-entry-title"><a href="../news-id='.$entry["id"].'/">'.$entry["title"].'</a></span>';
                                        $list_item .= '<span class="last-entry-date">'.$entry["published_on"].'</span>';
                                    $list_item .= '</div>';
                                $list_item .= '</li>';
                            }

                            $last_entries->free();

                            echo '<ul class="last-entries-list mb-30">'.$list_item.'</ul>';

                        ?>

                    </section>

                    <section class="archive">
                        <h3 class="text-uppercase">Archiwum</h3>
                        <ul class="archive-month-list mb-30">
                            <li class="archive-month"><a href="../2018-09/">Wrzesień 2018</a></li>
                            <li class="archive-month"><a href="../2018-10/">Październik 2018</a></li>
                        </ul>
                    </section>

                    <section class="categories">
                        <h3 class="text-uppercase">Kategorie</h3>
                        <ul class="cat-list">
                            <li class="news-cat news-cat-szczep"><a href="../szczep/">Szczep</a></li>
                            <li class="news-cat news-cat-harcerze"><a href="../harcerze/">Harcerze</a></li>
                            <li class="news-cat news-cat-harcerki"><a href="../harcerki/">Harcerki</a></li>
                            <li class="news-cat news-cat-wedrownicy"><a href="../wedrownicy/">Wędrownicy</a></li>
                            <li class="news-cat news-cat-zuchy"><a href="../zuchy/">Zuchy</a></li>
                            <li class="news-cat news-cat-zhp"><a href="../zhp/">ZHP</a></li>
                            <li class="news-cat news-cat-choragiew"><a href="../choragiew/">Chorągiew</a></li>
                            <li class="news-cat news-cat-hufiec"><a href="../hufiec/">Hufiec</a></li>
                        </ul>
                    </section>
                </aside>
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
                                <span class="team-name ml-3">II ŁDH-rzy</span>
                            </a> <!-- /.team-site-link -->
                            <a href="../../22ldh/" class="team-site-link d-flex align-items-center mt-3" target="_blank">
                                <img src="../../assets/logotypes_teams/22ldh_logo_white.svg" alt="#">
                                <span class="team-name ml-3">22 ŁDH-ek "Watra"</span>
                            </a> <!-- /.team-site-link -->
                            <a href="../../zuchy/" class="team-site-link d-flex align-items-center mt-3" target="_blank">
                                <img src="../../assets/logotypes_teams/lgzpp_logo_white.svg" alt="#">
                                <span class="team-name ml-3">ŁGZ "Pracowite Pszczółki"</span>
                            </a> <!-- /.team-site-link -->
                        </div> <!-- /.teams-sites-links -->
                    </div> <!-- /.sites-links -->

                    <hr class="d-md-none">

                    <div class="partnerships-container col-md-7 d-flex justify-content-between justify-content-lg-end">
                        <a class="partner-logo-link" href="http://lodzka.zhp.pl" target="_blank">
                            <img src="../../assets/logotypes_partnerships/LogoCHL_PNG_White.png" alt="Logotyp Chorągwi Łódzkiej">
                        </a> <!-- /.partner-logo-link -->
                        <a class="partner-logo-link ml-lg-4" href="https://zhp.pl" target="_blank">
                            <img src="../../assets/logotypes_partnerships/IdentyfikatorZHP_PNG_White.png" alt="Logotyp Związku Harcerstwa Polskiego">
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
                <span class="text-site-created">Created by Mateusz Kępa</span>
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