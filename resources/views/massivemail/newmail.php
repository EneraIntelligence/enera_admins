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
                <div class="user_content">

                    <div id="asunto" class="uk-width-medium-3-10  uk-width-small-1-1 uk-float-left">
                        <div class="uk-width-large-1-1 uk-row-first data-field data-mailing_list">
                            <div class="input-field col s12">
                                <label for="mail_subject">Asunto</label>
                                <input placeholder="" name="mail_subject" id="mail_subject" type="text">
                            </div>
                        </div>
                    </div>

                    <!-- mailing list: name/email -->

                    <div class="uk-width-large-9-10 data-mailing_list" style="margin:auto;padding-top: 20px">
                        <div class="input-field col s12">
                                    <textarea style="height:450px" id="mailing_content"
                                              name="mailing_content"> </textarea>
                        </div>
                    </div>
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