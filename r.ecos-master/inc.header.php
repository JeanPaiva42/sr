<?

// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));

session_start('andre');
// session_destroy();

//mostra os erros
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once('config/inc.config.php');
require_once('config/inc.functions.php');
?>
<!DOCTYPE html>
<html>
    <head>

        <title>R.ECOS (alpha)</title>
        <meta charset="utf-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

        <!--<meta http-equiv="Content-Security-Policy" content="default-src 'self' data: gap: https://ssl.gstatic.com 'unsafe-eval'; style-src 'self' 'unsafe-inline'; media-src *; img-src 'self' data: content:;">-->
        <!-- <meta name="format-detection" content="telephone=no"> -->
        <!-- <meta name="msapplication-tap-highlight" content="no"> -->
        <!-- <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" type="text/css" href="assets/styles.css">


        <!-- FONTS -->
      	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Work+Sans:100,300,400,500,700,900" type="text/css">
        <!-- <link rel="stylesheet" href="css/fonts.css"> -->

        <!-- MATERIAL DESIGN -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="assets/mdl/material.css">
        <!-- <link rel="stylesheet" href="css/material-icons.css"> -->
        <!-- <link rel="stylesheet" href="mdl/material.grey-light_blue.min.css" /> -->

        <!-- jquery -->
        <script src="assets/jquery.min.js"></script>

        <!-- Money -->
        <!--<script src="js/jquery.maskMoney.min.js"></script>-->

        <!-- CHARTLETS -->
        <!--<script src="js/chartlets.js"></script>-->

        <!-- dialog -->
        <!--<link rel='stylesheet prefetch' href='dialog-polyfill-master/dialog-polyfill.css'>-->


        <!-- CHARTS -->
        <script src="assets/Chart.js"></script>


    </head>

    <body>






