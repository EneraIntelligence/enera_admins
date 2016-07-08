<!doctype html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    {{--<link rel="icon" type="image/png" href="{!! URL::asset('assets/img/favicon-16x16.png') !!}" sizes="16x16">--}}
    <link rel="icon" type="image/png" href="{!! URL::asset('images/favicon.png') !!}" sizes="32x32">

    <title>Enera Publishers</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
    <!-- uikit -->
    {!! HTML::style('bower_components/uikit/css/uikit.almost-flat.min.css') !!}

            <!-- altair admin login page -->
    {!! HTML::style('assets/css/login_page.min.css') !!}
    {!! HTML::style('assets/css/login_enera.css') !!}
    {!! HTML::style('assets/css/main.min.css') !!}
    <style>
        #motivo span {
            width: 100%
        }

        form {
            width: 100%;
        }

        ul {
            list-style: none;
        }
    </style>
</head>
<body class="login_page login_body">
<div class=" uk-width-large-4-10 uk-width-medium-6-10 uk-padding-remove" style="margin: auto">
    <div class="md-card">
        <div class="md-card-content">
            <div class="user_content">
                <div id="salio">
                    <span>A dejado la lista de distribucion correctamente.</span>
                    <span>Ya no recibira correos de nuestra parte</span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script>
    $(document).ready(function () {
        console.log('cargado');

    })

</script>
</html>