@extends('layout.main')
@section('title', ' -  Campaña')
@section('head_scripts')
    {!! HTML::style(asset('assets/css/campaign.css')) !!}
@endsection
@section('content')

    <h3 style="margin: 10px 40px;" class="heading_b uk-margin-bottom">Pricing Tables</h3>
    {{-- <div id="top_bar">
         <div class="md-top-bar">
             <div class="uk-width-large-8-10 uk-container-center">
                 <div class="uk-clearfix">
                     <div class="md-top-bar-actions-left">
                         <div class="md-top-bar-checkbox">
                             <input type="checkbox" name="mailbox_select_all" id="mailbox_select_all" data-md-icheck />
                         </div>
                     </div>
                     <div class="md-top-bar-actions-right">
                         <div class="md-top-bar-icons">
                             <i id="mailbox_list_split" class=" md-icon material-icons">&#xE8EE;</i>
                             <i id="mailbox_list_combined" class="md-icon material-icons">&#xE8F2;</i>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>--}}
    <div id="page_content">
        <div id="page_content_inner">

            <div class="md-card-list-wrapper" id="mailbox">
                <div class="uk-width-large-8-10 uk-container-center">

                    <div class="md-card uk-margin-medium-bottom">
                        <div class="md-card-content">
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-medium-1-2 uk-row-first">
                                    <div class="uk-vertical-align">
                                        <div class="uk-vertical-align-middle">

                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <form action="{!! route('admin::clients::search') !!}" method="post"
                                          class="uk-form">
                                        <div class="uk-grid">
                                            <div class="uk-width-medium-2-3">
                                                <div class="md-input-wrapper"><label for="contact_list_search">Encontrar
                                                        usuario</label><input class="md-input" type="text"
                                                                              id="contact_list_search"
                                                                              name="search"><span
                                                            class="md-input-bar"></span></div>
                                            </div>
                                            <div class="uk-width-medium-1-3">
                                                    <button type="submit" class="header_main_search_btn uk-button-link"><i
                                                                class="md-icon material-icons">&#xE8B6;</i>
                                                    </button>
                                            </div>
                                        </div>


                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Today</div>
                        <div class="md-card-list-header md-card-list-header-combined heading_list"
                             style="display: none">All Messages
                        </div>
                        <ul class="hierarchical_slide">
                            @foreach($clients as $client)
                                <li onclick="window.location.href='{!! route('admin::clients::show', [$client->id]) !!}'"
                                    style="cursor: pointer;">
                                    <span class="md-card-list-item-date">{{ $client->administrators()->count() }}</span>
                                    <div class="md-card-list-item-select">
                                        <input type="checkbox" data-md-icheck/>
                                    </div>
                                    <div class="md-card-list-item-avatar-wrapper">
                                        <span class="md-card-list-item-avatar md-bg-grey">hp</span>
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
                    {{--aqui termina cada categoria--}}
                </div>
            </div>

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