<?php
session_start();
error_reporting(0);
if (isset($_SESSION['name'])) {
} else {
    header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>


    <style>
    .navbar-brand {
        width: 10% !important;
    }

    .bg_color {
        background-color: #274472 !important;
    }

    body {
        font-family: 'Raleway', sans-serif;
    }

    .carousel-caption {
        top: 50%;
        transform: translateY(-50%);
        bottom: initial;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }

    .carousel .carousel-item {
        height: 80vh;
    }

    .carousel-item img {
        position: absolute;
        top: 0;
        left: 0;
        min-height: 80vh;
        object-fit: cover;

    }

    section {
        padding: 60px 0;
    }

    .carousel-item:after {
        content: "";
        display: block;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
    }
    </style>


</head>

<body class="bg-light">
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-light bg_color">
            <div class="container">
                <a class="navbar-brand font-weight-bold" style="font-family: 'Lato', sans-serif; color: #481639"
                    href="index.php"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./booking.php">Staff</a>
                        </li>









                    </ul>

                </div>
            </div>
        </nav>
    </div>





    <div class="container">
        <h1 class="text-center mt-3">Home Page</h1>
    </div>




    <?php include('layout/script.php') ?>


</body>

</html>