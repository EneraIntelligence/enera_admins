<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            font-family: Roboto, sans-serif;
            color: #000000;
        }
    </style>

</head>
<body>
<div style="text-align: center;">
    <img src="http://publishers.enera-intelligence.mx/images/publisher.png" alt="Publisher">
</div>
<div>
    <p>Estimado {{$user->name['first']. ' '. $user->name['last'].':'}}</p>
    <p>Le informamos que la campaña <b><u>{{$cam->name}}</u></b> ha sido revisada por el equipo de Enera y ha sido
        rechazada, la razon es "{{$razon}}". {{$mensaje}} </p>
    <br>
    <p>Este correo se genero de forma automatica, para mayo infomación le invitamos a ingresar a su cuenta de publisher
        o mandar un correo a contacto@enera.mx</p>
    <p>Atte.</p>
</div>
<div style="text-align: center;">
    <img src="http://enera.mx/images/logo-dark.png" alt="Enera Intelligence">
</div>
</body>
</html>
