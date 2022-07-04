<!DOCTYPE html>
<html lang="en" ng-app="transparencyApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Transparency</title>
        <base href="/">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css/login-form.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <style src="css/app.css"></style>



        <script src="js/libs.js"></script>

        <script src="angular/app/app.js"></script>
        <script src="angular/app/transparencyAppControllers.js"></script>
        <script src="angular/app/components/services/routes.js"></script>
        <script src="angular/app/components/services/auth.js"></script>
        <script src="angular/app/components/auth/authController.js"></script>
        <script src="js/app.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div ui-view></div>
        <div ui-view="auth"></div>
        <div ui-view="back"></div>
        <div ui-view="home"></div>
    </body>
</html>
