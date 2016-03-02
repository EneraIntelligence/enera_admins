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

    <div id="page_content" >
        <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="heading_actions">
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Archive"><i class="md-icon material-icons">
                        &#xE149;</i></a>
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Print"><i class="md-icon material-icons">
                        &#xE8AD;</i></a>
                <div data-uk-dropdown>
                    <i class="md-icon material-icons">&#xE5D4;</i>
                    <div class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Other Action</a></li>
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
                        <ul class="hierarchical_slide">
                            <li>
                                <span class="md-card-list-item-date">Terminación</span>
                                <span class="md-card-list-item-date">Loaded</span>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <img src="assets/img/avatars/avatar_08_tn@2x.png" style="background: none;"
                                         class="md-card-list-item-avatar dense-image dense-ready" alt="">
                                </div>
                                <div class="md-card-list-item-sender">
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
                                    <span class="md-card-list-item-date">{{date('Y-m-d',$campaign->filters['date']['end']->sec)}}</span>
                                    <span class="md-card-list-item-date"
                                          style="margin-right: 25px;">{{$campaign->logs()->where('interaction.loaded', 'exists', 'true')->count()}}</span>
                                    <div class="md-card-list-item-avatar-wrapper">
                                        <img src="{!! URL::asset('images/icons/'.CampaignStyle::getCampaignIcon( $campaign->interaction['name'] ) ) !!}2.svg"
                                             style="background: {!! CampaignStyle::getStatusColor($campaign->status) !!};border: solid 1px {!! CampaignStyle::getStatusColor($campaign->status) !!};"
                                             class="md-card-list-item-avatar dense-image dense-ready" alt="">
                                    </div>
                                    <div class="md-card-list-item-sender">
                                        <span>{{$campaign->name}}</span>
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <span>
                                            @if(isset($campaign->filters['week_days'] ))
                                                @foreach($campaign->filters['week_days'] as $dia)
                                                    <span class="uk-badge uk-badge-notification uk-badge-primary">{{ trans('days.'.$dia) }}</span>,
                                                @endforeach
                                            @else
                                                no definido
                                            @endif</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="uk-width-large-8-10 uk-container-center">
                    <div class="md-card-list">
                        <ul class="hierarchical_slide">
                            <li>
                                <span class="md-card-list-item-date">Terminación</span>
                                <span class="md-card-list-item-date">Loaded</span>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <img src="assets/img/avatars/avatar_08_tn@2x.png" style="background: none;"
                                         class="md-card-list-item-avatar dense-image dense-ready" alt="">
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span>Nombre</span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <span>Días de interacción</span>
                                </div>
                            </li>
                        </ul>
                        <ul class=""
                            data-uk-grid="{controls: '#campaign-filter, #action-filter, #campaign-sort' }">
                            @foreach($campaignsA as $campaign)
                                <li class="nav" style=" cursor: pointer; width: 100%; !important;"
                                    onclick="window.location.href='{!! route('campaigns::show', [$campaign->id]) !!}'"
                                    data-uk-filter="campaign-{!! $campaign->status !!}, action-{!! $campaign->interaction['name'] !!}"
                                    data-name="{!! $campaign->name !!}"
                                    data-action="{!! $campaign->interaction['name'] !!}"
                                    data-company="{!! $campaign->publishers_summary['client'] !!}"
                                    data-status="{!! CampaignStyle::getStatusValue( $campaign->status )  !!}"
                                    data-date="{!! $campaign->created_at !!}">
                                    <span class="md-card-list-item-date">{{date('Y-m-d',$campaign->filters['date']['end']->sec)}}</span>
                                    <span class="md-card-list-item-date"
                                          style="margin-right: 25px;">{{$campaign->logs()->where('interaction.loaded', 'exists', 'true')->count()}}</span>
                                    <div class="md-card-list-item-avatar-wrapper">
                                        <img src="{!! URL::asset('images/icons/'.CampaignStyle::getCampaignIcon( $campaign->interaction['name'] ) ) !!}2.svg"
                                             style="background: {!! CampaignStyle::getStatusColor($campaign->status) !!};border: solid 1px {!! CampaignStyle::getStatusColor($campaign->status) !!};"
                                             class="md-card-list-item-avatar dense-image dense-ready" alt="">
                                    </div>
                                    <div class="md-card-list-item-sender">
                                        <span>{{$campaign->name}}</span>
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <span>
                                            @if(isset($campaign->filters['week_days'] ))
                                                @foreach($campaign->filters['week_days'] as $dia)
                                                    {{ trans('days.'.$dia) }},
                                                @endforeach
                                            @else
                                                no definido
                                            @endif</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="md-fab-wrapper">--}}
    {{--<a class="md-fab md-fab-accent md-fab-wave" href="#mailbox_new_message" data-uk-modal="{center:true}">--}}
    {{--<i class="material-icons">&#xE150;</i>--}}
    {{--</a>--}}
    {{--</div>--}}

    {{--<div class="uk-modal" id="mailbox_new_message">--}}
    {{--<div class="uk-modal-dialog">--}}
    {{--<button class="uk-modal-close uk-close" type="button"></button>--}}
    {{--<form>--}}
    {{--<div class="uk-modal-header">--}}
    {{--<h3 class="uk-modal-title">Compose Message</h3>--}}
    {{--</div>--}}
    {{--<div class="uk-margin-medium-bottom">--}}
    {{--<label for="mail_new_to">To</label>--}}
    {{--<input type="text" class="md-input" id="mail_new_to"/>--}}
    {{--</div>--}}
    {{--<div class="uk-margin-large-bottom">--}}
    {{--<label for="mail_new_message">Message</label>--}}
    {{--<textarea name="mail_new_message" id="mail_new_message" cols="30" rows="6"--}}
    {{--class="md-input"></textarea>--}}
    {{--</div>--}}
    {{--<div id="mail_upload-drop" class="uk-file-upload">--}}
    {{--<p class="uk-text">Drop file to upload</p>--}}
    {{--<p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>--}}
    {{--<a class="uk-form-file md-btn">choose file<input id="mail_upload-select" type="file"></a>--}}
    {{--</div>--}}
    {{--<div id="mail_progressbar" class="uk-progress uk-hidden">--}}
    {{--<div class="uk-progress-bar" style="width:0">0%</div>--}}
    {{--</div>--}}
    {{--<div class="uk-modal-footer">--}}
    {{--<a href="#" class="md-icon-btn"><i class="md-icon material-icons">&#xE226;</i></a>--}}
    {{--<button type="button" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}

@stop

@section('scripts')

    <script>
        $("li.nav").css('width', '100%');
    </script>

@stop

