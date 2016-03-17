@extends('layout.main')
@section('title', ' -  Campaña')
@section('head_scripts')
    {!! HTML::style(asset('assets/css/campaign.css')) !!}
@endsection
@section('content')
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="uk-grid">
            <div class="uk-width-medium-1-10"></div>
            <div class="uk-width-medium-2-10">
                <h1>Lista de redes</h1>
            </div>
            <div class="uk-width-medium-5-10">
            </div>
            <div class="uk-width-medium-1-10 uk-hidden-small" style="padding-left: 0; text-align: right">
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Archive"
                   data-uk-modal="{target:'#my-id'}"><i
                            class="md-icon material-icons">
                        &#xE149;</i></a>
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Print"><i class="md-icon material-icons">
                        &#xE8AD;</i></a>
                <div class="uk-button-dropdown" data-uk-dropdown>

                    <!-- This is the button toggling the dropdown -->
                    <i class="md-icon material-icons">&#xE5D4;</i>

                    <!-- This is the dropdown -->
                    <div class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="">Action</a></li>
                            <li><a href="">Other Action</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
                            @foreach($networks as $network)
                                <li onclick="window.location.href='{!! route('network::show', [$network->id]) !!}'"
                                    style="cursor: pointer;">
                                    <span class="md-card-list-item-date">{{ $network->branches->count().' ' }} Nodo(s)</span>
                                    <div class="md-card-list-item-avatar-wrapper"><span
                                                class="md-card-list-item-avatar md-bg-green-400">@for($i = 0; $i < 2; $i++){{$network->name[$i]}}@endfor</span>
                                    </div>
                                    <div class="md-card-list-item-sender">
                                        <span>{{$network->name}}</span>
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <div class="md-card-list-item-sender-small">
                                            <span>{{$network->name}}</span>
                                        </div>
                                        <span>{{($network->client == null) ? 'Sin cliente' : $network->client->name }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="my-id" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <form action="{!! route('network::search') !!}" class="uk-form-stacked" method="post" id="form"
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
@stop

@section('scripts')
    {!! HTML::script('bower_components/parsleyjs/dist/parsley.min.js') !!}
    {!! HTML::script('bower_components/parsleyjs/src/i18n/es.js') !!}
    {!! HTML::script('assets/js/pages/forms_validation.min.js') !!}
@stop