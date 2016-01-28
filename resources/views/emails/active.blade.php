<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function () {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

</head>
<body>
<div style="text-align: center;">
    <img src="http://enera.mx/images/logo-dark.png" alt="">
</div>
<div>
    <p>Estimado {{$user->name['first']. ' '. $user->name['last'].':'}}</p>
    <p>Le informamos que la campaña <b><u>{{$cam->name}}</u></b> ha sido revisada por el equipo de Enera y ha sido aprobada</p>
</div>
</body>
</html>
