@extends('layout.main')
@section('head_scripts')
    <style>
        #genero span {
            width: 100%;
        }

        #dataEmail div, #data div {
            padding-bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card-content">
                {!! Form::open(['route'=>'mailing::createMail', 'class'=>'uk-form-stacked', 'id'=>'form_validation']) !!}
                <div class="md-card" style="max-width:1100px;margin:auto;">
                    <div class="uk-width-large-9-10" style="margin: auto">
                        <div style="padding-top: 20px;">
                            <input hidden name="list" id="list" type="text" value="{!! $id !!}">
                        </div>
                        <div id="data" class="uk-width-medium-1-1 uk-width-small-1-1 ">
                            <h3>Datos para el registro</h3>
                            <label for=""> lista a la que se va a enviar: <b>{!! $name !!}</b> </label>
                            <div>
                                <label for="sendermail">Nombre para identificar el correo: </label>
                                <input placeholder="" name="name" id="name" type="text">
                            </div>
                        </div>
                        <div id="dataEmail" class="uk-width-large-9-10">
                            <h3>Informacion de correo que aparecera como remitente</h3>
                            <div id="senderMail">
                                <label for="sendermail">Email que saldra como envia</label>
                                <input placeholder="" name="sender_mail" id="sender_mail" type="text">
                            </div>
                            <div id="senderName">
                                <label for="sendername">Nombre que dira quien lo envia </label>
                                <input placeholder="" name="sender_name" id="sender_name" type="text">
                            </div>
                            <div class="input-field col s12">
                                <label for="mail_subject">Asunto</label>
                                <input placeholder="" name="mail_subject" id="mail_subject" type="text">
                            </div>
                        </div>
                    </div>

                    <!-- mailing list: name/email -->
                    <div id="editor" class="uk-width-large-9-10 data-mailing_list"
                         style="margin:auto;padding-top: 20px">
                        <div class="input-field col s12">
                            <textarea style="height:450px" id="mailing_content" name="mailing_content"> </textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-margin-medium-top">
                    <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">crear correo
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </div>
    @stop


    @section('scripts')
            <!-- wysiwyg -->
    {!! HTML::script('js/tinymce/tinymce.min.js') !!}
            <!-- slider script -->
    {!! HTML::script('bower_components/ion.rangeslider/js/ion.rangeSlider.min.js') !!}
    {!! HTML::script('bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js') !!}
    {!! HTML::script('assets/js/pages/forms_advanced.min.js') !!}

    <script>

        $(document).ready(function () {

//initialize wysiwyg
            tinymce.init({
                selector: '#mailing_content',
                language: 'es_MX',
                plugins: 'code',
                toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
// update validation status on change
                /*setup: function (editor) {
                 editor.on('change', function (e) {
                 //console.log(editor.id);
                 tinymce.triggerSave();
                 $("#" + editor.id).valid();
                 });
                 }*/
            });
        })

    </script>

@stop