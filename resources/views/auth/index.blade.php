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

    <link rel="icon" type="image/png" href="{!! URL::asset('images/favicon.png') !!}" sizes="32x32">

    <title>Enera Publishers</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
    <!-- uikit -->
    {!! HTML::style('bower_components/uikit/css/uikit.almost-flat.min.css') !!}

            <!-- altair admin login page -->
    {!! HTML::style('assets/css/login_page.min.css') !!}
    {!! HTML::style('assets/css/main.min.css') !!}
    <style>
        span {
            list-style: none;
        }
        ul {
            list-style: none;
        }
    </style>
</head>
<body class="login_page">
<div class="login_page_wrapper">

    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding" id="login_form">
            <div class="login_heading">
                <div style="width: 290px;height: 100px; display:inline-block;text-align:center;">
                    <img src="images/publisher.png" alt="">
                </div>
                @if(session('data')=='active')
                    <div class="uk-alert uk-alert-success" style="padding-right:10px">
                        <a href="#" class="uk-alert-close "></a>
                        Tu cuenta ha sido activada.
                    </div>
                @elseif(session('data')=='invalido')
                    <div class="uk-alert uk-alert-danger" style="padding-right:10px">
                        <span class="uk-margin">Codigo invalido.</span>
                    </div>
                @endif
            </div>
            {!! Form::open(['route'=>'auth.login', 'class'=>'uk-form-stacked', 'id'=>'form_validation']) !!}
            @if( Session::has('error') )
                <div style="text-align: center; color: red; margin-bottom: 10px;">{!! session('error') !!}</div>
            @endif

            @foreach($errors->get('email') as $m)
                <div style="text-align: center; color: red;">{!! $m !!}</div>
            @endforeach

            @foreach($errors->get('password') as $m)
                <div style="text-align: center; color: red;">{!! $m !!}</div>
            @endforeach

            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">
                    <div class="parsley-row">
                        <label for="email">Email <span class="req"></span></label>
                        {{--<div class="md-input-wrapper md-input-filled md-input-wrapper-danger">--}}
                        {{--<input data-parsley-type="email" id="email" name="email" required
                               data-parsley-trigger="change" class="md-input"
                               data-parsley-type-message="ingresa un correo valido"
                               data-parsley-required-message="Ingresa tu correo"/>--}}
                        <input type="email" name="email" data-parsley-trigger="change" required  class="md-input" />
                        {{--</div>--}}
                        <div class="parsley-errors-list filled" id="parsley-id-6">
                            @foreach($errors->get('email') as $m)
                                <span class="parsley-type">{!! $m !!}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">
                    <div class="parsley-row uk-margin-top">
                        <div class="md-input-wrapper">
                            <label for="login_password">Contraseña</label>
                            <input type="password" id="login_password" name="password" required
                                   data-parsley-trigger="change" class="md-input"
                                   data-parsley-minlength="8" data-parsley-minlength-message="minimo 8 caracteres"
                                   data-parsley-maxlength="16" data-parsley-maxlength-message="maximo 16 caracteres"
                                   data-parsley-validation-threshold="10" data-parsley-id="2"
                                   data-parsley-required-message="No olvides tu contraseña"
                            />
                            <span class="md-input-bar"> </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-margin-medium-top">
                <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Entrar</button>
            </div>
            <div class="uk-margin-top">
                {{--<a href="#" id="login_help_show" class="uk-float-right">Necesitas ayuda?</a>--}}
                <span class="icheck-inline">
                    <input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" data-md-icheck/>
                    <label for="login_page_stay_signed" class="inline-label">Mantener sesión</label>
                </span>
            </div>

            {!! Form::close() !!}
        </div>
        <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
            <button type="button"
                    class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
            <h2 class="heading_b uk-text-success">No puedes iniciar sesión?</h2>

            <p>Aquí está la información para que usted vuelva a su cuenta tan pronto como sea posible.</p>

            <p>En primer lugar, trate con lo más sencillo: si usted recuerda su contraseña, pero no funciona, asegúrese
                de que Bloq Mayús está apagado y que su nombre de usuario está escrito correctamente, y vuelva a
                intentarlo.</p>

            <p>Si la contraseña sigue sin funcionar, es hora de <a href="#" id="password_reset_show">restablecer la
                    contraseña</a>.</p>
        </div>
        <div class="md-card-content large-padding" id="login_password_reset" style="display: none">
            <button type="button"
                    class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
            <h2 class="heading_a uk-margin-large-bottom">Restablecer la contraseña</h2>

            <form>
                <div class="uk-form-row">
                    <label for="login_email_reset">Email</label>
                    <input class="md-input" type="text" id="login_email_reset" name="login_email_reset"/>
                </div>
                <div class="uk-margin-medium-top">
                    <a href="index.html" class="md-btn md-btn-primary md-btn-block">Restablecer</a>
                </div>
            </form>
        </div>
    </div>
</div>
        <!-- common functions -->
{!! HTML::script('assets/js/common.min.js') !!}
        <!-- altair core functions -->
{!! HTML::script('assets/js/altair_admin_common.min.js') !!}
        <!-- altair login page functions -->
{!! HTML::script('assets/js/pages/login.min.js') !!}
{!! HTML::script('bower_components/parsleyjs/dist/parsley.min.js') !!}
{!! HTML::script('bower_components/parsleyjs/src/i18n/es.js') !!}
{!! HTML::script('assets/js/pages/forms_validation.min.js') !!}


</body>
</html>