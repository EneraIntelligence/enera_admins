@extends('layout.main')
@section('title', ' -  Campaña')
@section('head_scripts')
    {!! HTML::style(asset('assets/css/campaign.css')) !!}
@endsection
@section('content')
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
        <h1 style="width: 80%;margin: auto;">Clientes</h1>
    </div>
    <div id="page_content">
        <div id="page_content_inner">

            <div class="md-card-list-wrapper" id="mailbox">
                <div class="uk-width-large-8-10 uk-container-center">
                    <div class="md-card-list">
                        <div class="md-card-list-header md-card-list-header-combined heading_list"
                             style="display: none">All Messages
                        </div>
                        <ul class="hierarchical_slide">
                            @foreach($clients as $client)
                                <li onclick="window.location.href='{!! route('admin::clients::show', [$client->id]) !!}'"
                                    style="cursor: pointer;">
                                    <span class="md-card-list-item-date">{{($client->administrators()->count() > 1 ) ?
                                    $client->administrators()->count().' Usuarios' : $client->administrators()->count().' Usuario' }}</span>
                                    <div class="md-card-list-item-avatar-wrapper"><span
                                                class="md-card-list-item-avatar md-bg-grey">hp</span>
                                    </div>
                                    <div class="md-card-list-item-sender">
                                        <span>{{$client->name}}</span>
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <div class="md-card-list-item-sender-small">
                                            <span>{{$client->name}}</span>
                                        </div>
                                        <span>{{$client->billing_information['business_name']}}</span>
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
            <form action="{!! route('campaigns::search::campaign') !!}" class="uk-form-stacked" method="post" id="form"
                  data-parsley-validate
                  enctype="multipart/form-data">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1">
                        <div class="parsley-row">
                            <input type="text" name="search" required class="md-input"/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <button type="submit" class="md-btn md-btn-primary">Buscar</button>
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


    {{--modal para editar un correo--}}
    {{--<div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE150;</i>
        </a>
    </div>--}}

    {{--<div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>
            <form>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="mail_new_to">To</label>
                    <input type="text" class="md-input" id="mail_new_to"/>
                </div>
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Message</label>
                    <textarea name="mail_new_message" id="mail_new_message" cols="30" rows="6" class="md-input"></textarea>
                </div>
                <div id="mail_upload-drop" class="uk-file-upload">
                    <p class="uk-text">Drop file to upload</p>
                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" type="file"></a>
                </div>
                <div id="mail_progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
                <div class="uk-modal-footer">
                    <a href="#" class="md-icon-btn"><i class="md-icon material-icons">&#xE226;</i></a>
                    <button type="button" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                </div>
            </form>
        </div>
    </div>--}}
@stop

@section('scripts')

@stop