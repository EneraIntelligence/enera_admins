@extends('layout.main')
@section('title', ' -  Campaña')
@section('head_scripts')
    {!! HTML::style(asset('assets/css/campaign.css')) !!}
@endsection
@section('content')
    <div id="page_content">
        <div id="page_heading">
            <h1>{{$client->name}}</h1>
            <span class="uk-text-muted uk-text-upper uk-text-small">{{$client->billing_information['business_name']}}</span>
        </div>
        <div id="page_content_inner">
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10">
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <h3 class="md-card-toolbar-heading-text">
                                Detalles
                            </h3>
                        </div>
                        <div class="md-card-content">
                            <ul class="md-list">
                                <li>
                                    <div class="md-list-content">
                                        <span class="uk-text-small uk-text-muted uk-display-block">Adminitradores</span>
                                        <span class="md-list-heading uk-text-large uk-text-success">{{$client->administrators()->count()}}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="uk-text-small uk-text-muted uk-display-block">Redes</span>
                                        <span class="md-list-heading uk-text-large">{{$client->networks()->count()}}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="uk-text-small uk-text-muted uk-display-block">Direección</span>
                                        <span class="md-list-heading uk-text-large">{{$client->billing_information['address']}}</span>
                                        <span class="md-list-heading uk-text-large">{{$client->billing_information['suburb']. ' '. $client->billing_information['zipcode']}}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="uk-text-small uk-text-muted uk-display-block">RFC</span>
                                        <span class="md-list-heading uk-text-large">{{$client->billing_information['rfc']}}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-width-xLarge-8-10  uk-width-large-7-10">
                    <div class="md-card">
                        <div class="md-card-content large-padding" style="padding-top: 12px;">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-1-1">
                                    <ul class="uk-tab" data-uk-tab="{connect:'#tabs_1'}">
                                        <li class="uk-active"><a href="#">Analiticos</a></li>
                                        <li><a href="#">Administradores</a></li>
                                        <li class="uk-disabled"><a href="#">Item</a></li>
                                        <li class="uk-disabled"><a href="#">Disabled</a></li>
                                    </ul>
                                    <ul id="tabs_1" class="uk-switcher uk-margin">
                                        <li>Analiticos</li>
                                        <li>
                                            <table class="uk-table uk-table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Rol</th>
                                                    <th>Email</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($client->administrators as $c)
                                                    <tr>
                                                        <td>{{$c->name['first'] . ' '. $c->name['last']}}</td>
                                                        <td>{{$c->role->name}}</td>
                                                        <td>{{$c->email}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </li>
                                        <li>Content 3</li>
                                        <li>Content 4</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function () {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>


    <script>
        $(function () {
            // enable hires images
            altair_helpers.retina_images();
            // fastClick (touch devices)
            if (Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
    </script>

@stop

@section('scripts')

@stop