@extends('layout.main')
@section('head_scripts')
    <style>
        #genero span {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card-content">
                <div class="md-card" style="max-width:1100px;margin:auto;">
                    <div id="contenido" class="user_content">
                        <h3>Crear nueva lista</h3>
                        {!! Form::open(['route'=>'mailing::createList', 'class'=>'uk-form-stacked', 'id'=>'form_validation']) !!}
                        <div id="nom" style="margin: 10px">
                            <span>nombre:</span>
                            <input id="nombre" name="nombre" type="text" placeholder="nombre"/>
                        </div>
                        <div id="filtros" class="uk-width-medium-9-10  uk-width-small-1-1"
                             style="margin:auto;display:flex ">
                            <div id="genero" class="uk-width-medium-3-10  uk-width-small-1-1 uk-float-left">
                                <label class="uk-form-label" style="width: 100%">Género <i class="material-icons">
                                        &#xE63D;</i></label>
                                <div class="icheck" style="width: 100%">
                                    <input type="checkbox" name="male" id="wizard_gender_men"
                                           class="" value="male"/>
                                    <label for="wizard_gender_men" class="inline-label">Hombres </label>
                                    <input type="checkbox" name="female" id="wizard_gender_women"
                                           class="wizard-icheck" value="female"/>
                                    <label for="wizard_gender_women" class="inline-label">Mujeres</label>
                                </div>
                                {{--<div class="clearfix"></div>--}}
                                {{--<span class="icheck">
                                    <input type="radio" name="gender" id="wizard_gender_both" checked
                                           class="wizard-icheck" value="ambos"/>
                                    <label for="wizard_gender_both" class="inline-label">Ambos</label>
                                </span>--}}
                            </div>
                            <div id="edad" class="uk-width-medium-4-10  uk-width-small-1-1 uk-float-left">
                                <div class="uk-width-medium-1-1 uk-width-small-1-1">
                                    <input type="text" id="age_slider" name="edad"
                                           data-ion-slider
                                           data-min="0" data-max="100"
                                           data-from="13" data-to="60"
                                           data-from-min="13"
                                           data-type="int" data-grid="true" data-postfix=" años"/>
                                </div>
                            </div>
                            {{--<div class="uk-width-medium-1-6" style="margin: auto">
                                <a class="md-btn md-btn-primary md-btn-wave-light" href="{!! route('mailing::newList') !!}">Crear lista</a>
                            </div>--}}
                        </div>
                        <div class="uk-margin-medium-top">
                            <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Crear lista
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
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
        $("#age_slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 24,
            min_interval: 3,
            postfix: ":00",
            from_min: 5,
            from: 5,
            to: 24,
            step: 1,
            force_edges: true
        });

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