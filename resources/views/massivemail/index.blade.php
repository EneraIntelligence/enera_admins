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
                        @if(count($list)>0 )
                            @foreach($lists as $list)
                            <div>
                                <span> {!! $list !!}</span>
                            </div>
                            @endforeach
                        @elseif
                            <div>
                                <span>no hay lista disponible</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="md-card" style="max-width:1100px;margin:auto;">
                    <div class="user_content">
                        <div class="uk-width-medium-1-6">
                            <a class="md-btn md-btn-primary md-btn-wave-light" href="{!! route('mailing::newList') !!}">Crear
                                nueva lista</a>
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

        })

    </script>

@stop