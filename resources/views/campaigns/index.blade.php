@extends('layout.main')

@section('title', 'Campañas')

@section('head_scripts')
    <style>
        li.nav {
            width: 100% !important;
        }
    </style>
@stop

@section('content')

    <div id="page_content">
        <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="heading_actions" style="margin-right: 8%">
                <a href="javascript:void(0) " data-uk-tooltip="{pos:'bottom'}" title="Buscar"
                   data-uk-modal="{target:'#my-id'}"><i class="material-icons">&#xE8B6;</i></a>
                {{--<a href="#" data-uk-tooltip="{pos:'bottom'}" title="Print"><i class="md-icon material-icons">--}}
                        {{--&#xE8AD;</i></a>--}}
                <div data-uk-dropdown>
                    <i class="md-icon material-icons">&#xE5D4;</i>
                    <div class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav">
                            <li><a href="#">Imprimir</a></li>
                            <li><a href="#">Other Action</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <h1 style="width: 80%;margin: auto;">Campañas</h1>
             <span style="margin-left: 10%;" class="uk-text-upper uk-text-small"> campañas activas y pendientes </span>
        </div>
        <div id="page_content_inner">
            <div class="md-card-list-wrapper" id="mailbox">
                <div class="uk-width-large-8-10 uk-container-center">
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Pendientes</div>
                        <ul class="hierarchical_slide">
                            <li>
                                <span class="md-card-list-item-date">Terminación</span>
                                <span class="md-card-list-item-date" style="padding-right: 20px;">Inicio</span>
                                <div class="md-card-list-item-avatar-wrapper" style="padding: 0 8px 0 35px">
                                    <img src="assets/img/avatars/avatar_08_tn@2x.png" style="background: none;"
                                         class="md-card-list-item-avatar dense-image dense-ready" alt="">
                                </div>
                                <div class="md-card-list-item-sender" style="display:block;">
                                    <span>Nombre</span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <span>Días de interacción</span>
                                </div>
                            </li>
                        </ul>
                        <ul class=""
                            data-uk-grid="{controls: '#campaign-filter, #action-filter, #campaign-sort' }">
                            @foreach($campaignsP as $campaign)
                                <li class="nav" style=" cursor: pointer; width: 100%; !important;"
                                    onclick="window.location.href='{!! route('campaigns::show', [$campaign->id]) !!}'"
                                    data-uk-filter="campaign-{!! $campaign->status !!}, action-{!! $campaign->interaction['name'] !!}"
                                    data-name="{!! $campaign->name !!}"
                                    data-action="{!! $campaign->interaction['name'] !!}"
                                    data-company="{!! $campaign->publishers_summary['client'] !!}"
                                    data-status="{!! CampaignStyle::getStatusValue( $campaign->status )  !!}"
                                    data-date="{!! $campaign->created_at !!}">
                                    <div class="md-card-list-item-select">
                                        <input type="checkbox" data-md-icheck />
                                    </div>
                                    <span class="md-card-list-item-date">{{date('d-M-y',$campaign->filters['date']['end']->sec)}}</span>
                                    <span class="md-card-list-item-date"
                                          style="margin-right: 25px;">{{date('d-M-y',$campaign->filters['date']['start']->sec)}}</span>
                                    <div class="md-card-list-item-avatar-wrapper">
                                        <img src="{!! URL::asset('images/icons/'.CampaignStyle::getCampaignIcon( $campaign->interaction['name'] ) ) !!}2.svg"
                                             style="background: {!! CampaignStyle::getStatusColor($campaign->status) !!};border: solid 1px {!! CampaignStyle::getStatusColor($campaign->status) !!};"
                                             class="md-card-list-item-avatar dense-image dense-ready" alt="">
                                    </div>
                                    <div class="md-card-list-item-sender" style="display: block;">
                                        <span>{{$campaign->name}}</span>
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <span>
                                            @for ($i = 1; $i < 8; $i++)
                                                @if(in_array($i ,$campaign->filters['week_days'] ))
                                                    <span class="uk-badge uk-badge-primary"
                                                          style="background:#2196f3 !important;">{{ trans('days.siglas.'.$i)}}</span>
                                                @else
                                                    <span class="uk-badge uk-badge-primary"
                                                          style="background:gray !important;">{{ trans('days.siglas.'.$i)}}</span>
                                        @endif
                                        @endfor
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="uk-width-large-8-10 uk-container-center">
                    <div class="md-card-list" style="margin-top:35px ">
                        <ul class=""
                            data-uk-grid="{controls: '#campaign-filter, #action-filter, #campaign-sort' }">
                            <div class="md-card-list-header heading_list">Activas</div>
                            @foreach($campaignsA as $campaign)
                                <li class="nav" style=" cursor: pointer; width: 100%; !important;"
                                    onclick="window.location.href='{!! route('campaigns::show', [$campaign->id]) !!}'"
                                    data-uk-filter="campaign-{!! $campaign->status !!}, action-{!! $campaign->interaction['name'] !!}"
                                    data-name="{!! $campaign->name !!}"
                                    data-action="{!! $campaign->interaction['name'] !!}"
                                    data-company="{!! $campaign->publishers_summary['client'] !!}"
                                    data-status="{!! CampaignStyle::getStatusValue( $campaign->status )  !!}"
                                    data-date="{!! $campaign->created_at !!}">
                                    <div class="md-card-list-item-select">
                                        <input type="checkbox" data-md-icheck />
                                    </div>
                                    <span class="md-card-list-item-date">{{date('d-M-y',$campaign->filters['date']['end']->sec)}}</span>
                                    <span class="md-card-list-item-date"
                                          style="padding-right: 30px;">{{date('d-M-y',$campaign->filters['date']['start']->sec)}}</span>
                                    <div class="md-card-list-item-avatar-wrapper">
                                        <img src="{!! URL::asset('images/icons/'.CampaignStyle::getCampaignIcon( $campaign->interaction['name'] ) ) !!}2.svg"
                                             style="background: {!! CampaignStyle::getStatusColor($campaign->status) !!};border: solid 1px {!! CampaignStyle::getStatusColor($campaign->status) !!};"
                                             class="md-card-list-item-avatar dense-image dense-ready" alt="">
                                    </div>
                                    <div class="md-card-list-item-sender" style="display: block;">
                                        <span>{{$campaign->name}}</span>
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <span>
                                           @for ($i = 1; $i < 8; $i++)
                                                @if(in_array($i ,$campaign->filters['week_days'] ))
                                                    <span class="uk-badge uk-badge-primary"
                                                          style="background:#2196f3 !important;">{{ trans('days.siglas.'.$i)}}</span>
                                                @else
                                                    <span class="uk-badge uk-badge-primary"
                                                          style="background:gray !important;">{{ trans('days.siglas.'.$i)}}</span>
                                                @endif
                                            @endfor
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- This is the modal -->
    <div id="my-id" class="uk-modal">
        <div class="uk-modal-dialog">
            <h3 class="uk-panel-title">Buscar...</h3>
            <form action="{!! route('campaigns::search::campaign') !!}" class="uk-form-stacked" method="post" id="form-buscar"
                  data-parsley-validate
                  enctype="multipart/form-data">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-3">
                        <div class="parsley-row">
                            <input type="text" name="search" required class="md-input"/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" style="text-align: center;">
                        <div class="parsley-row">
                            <button type="submit" class="md-btn md-btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@section('scripts')

    {{--    {!! HTML::script('bower_components/parsleyjs/dist/parsley.min.js') !!}
        {!! HTML::script('bower_components/parsleyjs/src/i18n/es.js') !!}
        {!! HTML::script('assets/js/pages/forms_validation.min.js') !!}--}}
    <script>
        $("li.nav").css('width', '100%');
    </script>

@stop

