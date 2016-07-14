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
                        @if(count($lists)>0 )
                            @foreach($lists as $list)
                                <div
                                        {{--data-uk-filter="campaign-{!! $campaign->status !!}, action-{!! $campaign->interaction['name'] !!}"--}}
                                        {{--data-name="{!! $campaign->name !!}"
                                        data-action="{!! $campaign->interaction['name'] !!}"
                                        data-company="{!! $campaign->publishers_summary['client'] !!}"
                                        data-status="{!! CampaignStyle::getStatusValue( $campaign->status )  !!}"
                                        data-date="{!! $campaign->created_at !!}"--}}
                                        style="cursor: pointer;">

                                    <div onclick="window.location.href='{!! route('mailing::newMail',['id'=>$list->_id,'name'=>$list->name]) !!}'"
                                         class="scrum_task"
                                         data-snippet-title="{!! $list->name !!}">
                                        <div class=" uk-grid">

                                            <div id="campaign-title"
                                                 class="uk-width-large-2-10 uk-width-medium-3-10 uk-width-small-1-1 uk-flex uk-flex-middle"
                                                 title="{!!$list->name!!} - {!! $list->status !!}">
                                                <h2>{!! $list->name !!}</h2>
                                                {{--                                                <h4>{{$list->publishers_summary['client']}}</h4>--}}
                                            </div>

                                            <div class="uk-width-medium-2-10 uk-width-small-1-1 uk-flex uk-flex-middle">
                                                <div class="" >
                                                    <i class="uk-icon-calendar"></i> <span>Genero:</span>
                                                </div>
                                                <div class="" style="margin-left:10px">
                                                    {!! isset($list->filters['gender'][0])?$list->filters['gender'][0]:''!!} , {!!isset($list->filters['gender'][1])? $list->filters['gender'][1]: '' !!}
                                                </div>
                                            </div>
                                            <div class="uk-width-medium-5-10 uk-hidden-small uk-flex uk-flex-middle chart_id"
                                                 id="chart_{!! $list->_id !!}">
                                                <div class="" >
                                                    <span>Edad:</span>
                                                </div>
                                                <div class="" style="margin-left:10px">
                                                    {!! $list->filters['age'][0].", ". $list->filters['age'][1] !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div>
                                    <label> {!! $list['name'] !!}</label>
                                    <input id="nombre" name="nombre" type="text" placeholder="nombre"/>
                                </div>--}}
                            @endforeach
                        @else
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