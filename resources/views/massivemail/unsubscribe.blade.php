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
                {{--<div id="logo" class="login_heading " style="margin-bottom:15px!important;">
                    <h3>Para finalizar la baja de la lista de distribucion </h3>
                    <h3>el siguiente correo sera dado de baja de la lista de distribucion: </h3>
                </div>--}}
                <div id="wrapper" class="uk-grid uk-width-large-1 ">
                    {!! Form::open(['route'=>'unSubscribe', 'class'=>'uk-form-stacked', 'id'=>'form_validation']) !!}
                    <div id="correo" class="uk-width-large-1-1 uk-margin">
                        <div class="parsley-row">
                            {{--<label for="email">Escribe tu correo para dejar de recibir notificaciones Email <span--}}
                            <h3> El siguiente correo {!! $email !!} sera dado de baja de la
                                lista de distribucion
                            </h3>
                            <input type="hidden" name="email" placeholder="correo" required
                                   value="{!! $email  !!}" class="md-input"/>
                        </div>
                    </div>

                    <div id="motivos" class="uk-width-large-1-1 uk-margin">
                        <h3 class="">Elige uno o varios motivos:</h3>

                        <span class="icheck-inline" style="width: 100% ">
                            <input type="radio" name="motivo" value="No es de mi interes"
                                   id="checkbox_inline_1" data-md-icheck/>
                            <label for="checkbox_inline_1" class="inline-label">No es de mi interes</label>
                        </span>
                        <span class="icheck-inline">
                            <input type="radio" name="motivo"
                                   value="Considero la publicidad recibida inapropiada o molesta"
                                   id="checkbox_inline_2" data-md-icheck/>
                            <label for="checkbox_inline_2" class="inline-label">Considero la publicidad recibida
                                inapropiada o molesta</label>
                        </span>
                        <span class="icheck-inline">
                            <input type="radio" name="motivo" value="Demasiada publicidad"
                                   id="checkbox_inline_3" data-md-icheck/>
                            <label for="checkbox_inline_3" class="inline-label">Demasiada publicidad</label>
                        </span>
                        <span class="icheck-inline">
                            <input type="radio" name="motivo" value="No me suscribi a esta lista de distribucion"
                                   id="checkbox_inline_4" data-md-icheck/>
                            <label for="checkbox_inline_4" class="inline-label">No me suscribi a esta lista de
                                distribucion</label>
                        </span>
                        <span class="icheck-inline" style="width:100%;">
                            <input type="radio" id="otro" name="motivo" value="otro" class="md-input"/>
                            <label for="otro" class="inline-label">Otro</label>
                        </span>
                        <div>
                            {{--<span style="display:block"><label for="checkbox_inline_5" class="inline-label">Otro</label></span>--}}
                            <textarea id="text" name="motivo2" rows="10" cols="62" hidden
                                      placeholder="escribe aqui otro motivo"></textarea>
                        </div>
                        {{--<input type="submit" name="submit" id="checkbox_demo_inline_3" data-md-icheck/>--}}
                        <div class="uk-width-1-1 uk-width-small-1-1 uk-margin">
                            <button type="submit" class="uk-width-1-1 md-btn md-btn-primary md-btn-block">enviar
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div id="salio">

                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('assets/js/common.min.js') !!}
<script>
    $(document).ready(function () {
        console.log('cargado');
//        var otro = $("#otro");
        $("input[name='motivo']").click(function () {
            var input = $(this);
//            console.log(input.attr("id"));
            var id = input.attr("id");
            if (id=='otro') {
                $("#text").show();
            }else{
                $("#text").hide();
            }
        });
    })

</script>
</body>
</html>