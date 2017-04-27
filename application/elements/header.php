<?php defined('C5_EXECUTE') or defined('BASEPATH') or die("Access Denied."); ?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
    
    <!-- Must be loaded first (Does not require Jquery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <style>
        /* ----------- Pace Theme (Loading Bar) ----------- */
        /* Must be loaded first */
        .pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;-o-box-sizing:border-box;box-sizing:border-box;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;-webkit-background-clip:padding-box;-moz-background-clip:padding;background-clip:padding-box;z-index:2000;position:fixed;margin:auto;top:12px;left:0;right:0;bottom:0;width:200px;height:50px;overflow:hidden}.pace .pace-progress{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;-o-box-sizing:border-box;box-sizing:border-box;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;-webkit-background-clip:padding-box;-moz-background-clip:padding;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0);display:block;position:absolute;right:100%;margin-right:-7px;width:93%;top:7px;height:14px;font-size:12px;background:#c2324b;color:#c2324b;line-height:60px;font-weight:700;font-family:Helvetica,Arial,"Lucida Grande",sans-serif;-webkit-box-shadow:120px 0 #fff,240px 0 #fff;-ms-box-shadow:120px 0 #fff,240px 0 #fff;box-shadow:120px 0 #fff,240px 0 #fff}.pace .pace-progress:after{content:attr(data-progress-text);display:inline-block;position:fixed;width:45px;text-align:right;right:0;padding-right:16px;top:4px}.pace .pace-progress[data-progress-text="0%"]:after{right:-200px}.pace .pace-progress[data-progress-text="1%"]:after{right:-198.14px}.pace .pace-progress[data-progress-text="2%"]:after{right:-196.28px}.pace .pace-progress[data-progress-text="3%"]:after{right:-194.42px}.pace .pace-progress[data-progress-text="4%"]:after{right:-192.56px}.pace .pace-progress[data-progress-text="5%"]:after{right:-190.7px}.pace .pace-progress[data-progress-text="6%"]:after{right:-188.84px}.pace .pace-progress[data-progress-text="7%"]:after{right:-186.98px}.pace .pace-progress[data-progress-text="8%"]:after{right:-185.12px}.pace .pace-progress[data-progress-text="9%"]:after{right:-183.26px}.pace .pace-progress[data-progress-text="10%"]:after{right:-181.4px}.pace .pace-progress[data-progress-text="11%"]:after{right:-179.54px}.pace .pace-progress[data-progress-text="12%"]:after{right:-177.68px}.pace .pace-progress[data-progress-text="13%"]:after{right:-175.82px}.pace .pace-progress[data-progress-text="14%"]:after{right:-173.96px}.pace .pace-progress[data-progress-text="15%"]:after{right:-172.1px}.pace .pace-progress[data-progress-text="16%"]:after{right:-170.24px}.pace .pace-progress[data-progress-text="17%"]:after{right:-168.38px}.pace .pace-progress[data-progress-text="18%"]:after{right:-166.52px}.pace .pace-progress[data-progress-text="19%"]:after{right:-164.66px}.pace .pace-progress[data-progress-text="20%"]:after{right:-162.8px}.pace .pace-progress[data-progress-text="21%"]:after{right:-160.94px}.pace .pace-progress[data-progress-text="22%"]:after{right:-159.08px}.pace .pace-progress[data-progress-text="23%"]:after{right:-157.22px}.pace .pace-progress[data-progress-text="24%"]:after{right:-155.36px}.pace .pace-progress[data-progress-text="25%"]:after{right:-153.5px}.pace .pace-progress[data-progress-text="26%"]:after{right:-151.64px}.pace .pace-progress[data-progress-text="27%"]:after{right:-149.78px}.pace .pace-progress[data-progress-text="28%"]:after{right:-147.92px}.pace .pace-progress[data-progress-text="29%"]:after{right:-146.06px}.pace .pace-progress[data-progress-text="30%"]:after{right:-144.2px}.pace .pace-progress[data-progress-text="31%"]:after{right:-142.34px}.pace .pace-progress[data-progress-text="32%"]:after{right:-140.48px}.pace .pace-progress[data-progress-text="33%"]:after{right:-138.62px}.pace .pace-progress[data-progress-text="34%"]:after{right:-136.76px}.pace .pace-progress[data-progress-text="35%"]:after{right:-134.9px}.pace .pace-progress[data-progress-text="36%"]:after{right:-133.04px}.pace .pace-progress[data-progress-text="37%"]:after{right:-131.18px}.pace .pace-progress[data-progress-text="38%"]:after{right:-129.32px}.pace .pace-progress[data-progress-text="39%"]:after{right:-127.46px}.pace .pace-progress[data-progress-text="40%"]:after{right:-125.6px}.pace .pace-progress[data-progress-text="41%"]:after{right:-123.74px}.pace .pace-progress[data-progress-text="42%"]:after{right:-121.88px}.pace .pace-progress[data-progress-text="43%"]:after{right:-120.02px}.pace .pace-progress[data-progress-text="44%"]:after{right:-118.16px}.pace .pace-progress[data-progress-text="45%"]:after{right:-116.3px}.pace .pace-progress[data-progress-text="46%"]:after{right:-114.44px}.pace .pace-progress[data-progress-text="47%"]:after{right:-112.58px}.pace .pace-progress[data-progress-text="48%"]:after{right:-110.72px}.pace .pace-progress[data-progress-text="49%"]:after{right:-108.86px}.pace .pace-progress[data-progress-text="50%"]:after{right:-107px}.pace .pace-progress[data-progress-text="51%"]:after{right:-105.14px}.pace .pace-progress[data-progress-text="52%"]:after{right:-103.28px}.pace .pace-progress[data-progress-text="53%"]:after{right:-101.42px}.pace .pace-progress[data-progress-text="54%"]:after{right:-99.56px}.pace .pace-progress[data-progress-text="55%"]:after{right:-97.7px}.pace .pace-progress[data-progress-text="56%"]:after{right:-95.84px}.pace .pace-progress[data-progress-text="57%"]:after{right:-93.98px}.pace .pace-progress[data-progress-text="58%"]:after{right:-92.12px}.pace .pace-progress[data-progress-text="59%"]:after{right:-90.26px}.pace .pace-progress[data-progress-text="60%"]:after{right:-88.4px}.pace .pace-progress[data-progress-text="61%"]:after{right:-86.54px}.pace .pace-progress[data-progress-text="62%"]:after{right:-84.68px}.pace .pace-progress[data-progress-text="63%"]:after{right:-82.82px}.pace .pace-progress[data-progress-text="64%"]:after{right:-80.96px}.pace .pace-progress[data-progress-text="65%"]:after{right:-79.1px}.pace .pace-progress[data-progress-text="66%"]:after{right:-77.24px}.pace .pace-progress[data-progress-text="67%"]:after{right:-75.38px}.pace .pace-progress[data-progress-text="68%"]:after{right:-73.52px}.pace .pace-progress[data-progress-text="69%"]:after{right:-71.66px}.pace .pace-progress[data-progress-text="70%"]:after{right:-69.8px}.pace .pace-progress[data-progress-text="71%"]:after{right:-67.94px}.pace .pace-progress[data-progress-text="72%"]:after{right:-66.08px}.pace .pace-progress[data-progress-text="73%"]:after{right:-64.22px}.pace .pace-progress[data-progress-text="74%"]:after{right:-62.36px}.pace .pace-progress[data-progress-text="75%"]:after{right:-60.5px}.pace .pace-progress[data-progress-text="76%"]:after{right:-58.64px}.pace .pace-progress[data-progress-text="77%"]:after{right:-56.78px}.pace .pace-progress[data-progress-text="78%"]:after{right:-54.92px}.pace .pace-progress[data-progress-text="79%"]:after{right:-53.06px}.pace .pace-progress[data-progress-text="80%"]:after{right:-51.2px}.pace .pace-progress[data-progress-text="81%"]:after{right:-49.34px}.pace .pace-progress[data-progress-text="82%"]:after{right:-47.48px}.pace .pace-progress[data-progress-text="83%"]:after{right:-45.62px}.pace .pace-progress[data-progress-text="84%"]:after{right:-43.76px}.pace .pace-progress[data-progress-text="85%"]:after{right:-41.9px}.pace .pace-progress[data-progress-text="86%"]:after{right:-40.04px}.pace .pace-progress[data-progress-text="87%"]:after{right:-38.18px}.pace .pace-progress[data-progress-text="88%"]:after{right:-36.32px}.pace .pace-progress[data-progress-text="89%"]:after{right:-34.46px}.pace .pace-progress[data-progress-text="90%"]:after{right:-32.6px}.pace .pace-progress[data-progress-text="91%"]:after{right:-30.74px}.pace .pace-progress[data-progress-text="92%"]:after{right:-28.88px}.pace .pace-progress[data-progress-text="93%"]:after{right:-27.02px}.pace .pace-progress[data-progress-text="94%"]:after{right:-25.16px}.pace .pace-progress[data-progress-text="95%"]:after{right:-23.3px}.pace .pace-progress[data-progress-text="96%"]:after{right:-21.44px}.pace .pace-progress[data-progress-text="97%"]:after{right:-19.58px}.pace .pace-progress[data-progress-text="98%"]:after{right:-17.72px}.pace .pace-progress[data-progress-text="99%"]:after{right:-15.86px}.pace .pace-progress[data-progress-text="100%"]:after{right:-14px}.pace .pace-activity{position:absolute;width:100%;height:28px;z-index:2001;box-shadow:inset 0 0 0 2px #c2324b,inset 0 0 0 7px #FFF;border-radius:10px}.pace.pace-inactive{display:none}
        
        <?php if (!isset($is_codeigniter)) {
            if ($view->getThemePath() == '/application/themes/ekcintranet') { ?>
                .pace .pace-progress {
                    background: #00a399;
                    color: #00a399;
                }
                .pace .pace-activity {
                    box-shadow: inset 0 0 0 2px #00a399, inset 0 0 0 7px #FFF;
                }
            <?php }
        } ?>
        
        /* ----------- END Pace Theme (Loading Bar) ----------- */
    </style>
    
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta http-equiv="Cache-control" content="public">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#C2324B" />

    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">

    
    
    <?php if (isset($is_codeigniter)) { ?>
    
        <!-- Jquery Order Matters -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
    
        <meta name="msapplication-TileColor" content="rgb(18, 70, 128)">
        <meta name="msapplication-TileImage" content="https://intranet.cant-col.ac.uk/application/files/3414/5649/6499/Canterbury_College.png">
        <link rel="shortcut icon" type="image/x-icon" href="/application/files/2414/5633/1057/favicon.ico">
        <link rel="icon" href="/application/files/2414/5633/1057/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" href="/application/files/3414/5649/6499/Canterbury_College.png">
        <title>Intranet - Canterbury College</title>

        <link type="text/css" rel="stylesheet" href="/concrete/css/jquery-ui.css">
        <link type="text/css" rel="stylesheet" href="/application/themes/ccintranet/assets/css/style.css">
        
    <?php /* END Codeigniter */ } else {  /* IF Concrete5 */ ?>
            
            <!-- Jquery Order Matters -->
            <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
    
            <?php $is_concrete5 = TRUE; ?>
            <?php Loader::element('header_required'); ?>
            <link type="text/css" rel="stylesheet" href="<?= $view->getThemePath() ?>/assets/css/style.css">

            <?php 
                $u = new User();
                global $u;
                $u = new User(); if($u->inGroup(Group::getByName('Staff'))){ 

                    if(!isset($_COOKIE['CI-CONCRETE5'])) {

                        define('IV_SIZE', mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

                        function encrypt ($key, $username) {
                          $iv = mcrypt_create_iv(IV_SIZE, MCRYPT_DEV_URANDOM);
                          $crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $username, MCRYPT_MODE_CBC, $iv);
                          $combo = $iv . $crypt;
                          $output = base64_encode($iv . $crypt);
                          return $output;
                        }

                        $key = "dnqyypv8y6qcm8n38cvmsuqkevcvmhy2";
                        $username = $u->getUserName();

                        // ENCRYPTION
                        $output = encrypt($key, $username);
                        setcookie('CI-CONCRETE5', $output, time() + (600), "/");

                        $url = URL::to('/login', 'logout', \Core::make('helper/validation/token')->generate('logout'));
                        setcookie('CONCRETE5_LOGOUT', $url, time() + (600), "/");

                    }
                }
            ?>
    <?php /* END Concrete5 */ } ?>
            
</head>
<body>
    <div id="wrapper">
        
        <?php 
            if (isset($is_codeigniter)) {
                include('/var/www/html/intranet/application/elements/navigation.php');
            } else {
                Loader::element('navigation');
            }
        ?>

        <div id="page-wrapper">

            <?php 
                if (isset($is_codeigniter)) {
                    $this->load->view('templates/notification');
                }