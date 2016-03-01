@extends('layout.main')
@section('title', ' -  Campaña')
@section('head_scripts')
    {!! HTML::style(asset('assets/css/campaign.css')) !!}
@endsection
@section('content')
    <div id="page_content">
        <div id="page_heading">
            <h1>{{$network->name}}</h1>
            <a href="{{($network->client == null) ? 'javascript:void(0)' : route('admin::clients::show', [$network->client->_id])}}"><span
                        class="uk-text-muted uk-text-upper uk-text-small">{{($network->client == null) ? 'Sin cliente' : $network->client->name }}</span></a>
        </div>
        <div id="page_content_inner">
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10">
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <h3 class="md-card-toolbar-heading-text">
                                Analiticos
                            </h3>
                        </div>
                        <div class="md-card-content">
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-xLarge-8-10  uk-width-large-7-10">
                    <div class="md-card">
                        <div class="md-card-content large-padding" style="padding-top: 12px;">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-1-1">
                                    <ul class="uk-tab" data-uk-tab="{connect:'#tabs_1'}">
                                        <li class="uk-active"><a href="#">Detalles</a></li>
                                        <li><a href="#">Aps</a></li>
                                        <li class="uk-disabled"><a href="#">Item</a></li>
                                        <li class="uk-disabled"><a href="#">Disabled</a></li>
                                    </ul>
                                    <ul id="tabs_1" class="uk-switcher uk-margin">
                                        <li>
                                            <div class="uk-width-large-1">
                                                <div class="uk-grid uk-grid-small">
                                                    <div class="uk-width-large-1-3">
                                                        <span class="uk-text-muted uk-text-small">Nombre de la red</span>
                                                    </div>
                                                    <div class="uk-width-large-2-3">
                                                        <span class="uk-text-large uk-text-middle"><a href="#">{{$network->name}}</a></span>
                                                    </div>
                                                </div>
                                                <hr class="uk-grid-divider">
                                                <div class="uk-grid uk-grid-small">
                                                    <div class="uk-width-large-1-3">
                                                        <span class="uk-text-muted uk-text-small">Cliente</span>
                                                    </div>
                                                    <div class="uk-width-large-2-3">
                                                        <span class="uk-text-large uk-text-middle">{{($network->client == null) ? 'Sin cliente' : $network->client->name }}</span>
                                                    </div>
                                                </div>
                                                <hr class="uk-grid-divider">
                                                <div class="uk-grid uk-grid-small">
                                                    <div class="uk-width-large-1-3">
                                                        <span class="uk-text-muted uk-text-small">Tipo</span>
                                                    </div>
                                                    <div class="uk-width-large-2-3">
                                                        {{$network->type}}
                                                    </div>
                                                </div>
                                                <hr class="uk-grid-divider">
                                                <div class="uk-grid uk-grid-small">
                                                    <div class="uk-width-large-1-3">
                                                        <span class="uk-text-muted uk-text-small">Estatus</span>
                                                    </div>
                                                    <div class="uk-width-large-2-3">
                                                        {{$network->status}}
                                                    </div>
                                                </div>
                                                <hr class="uk-grid-divider uk-hidden-large">
                                            </div>
                                        </li>
                                        <li>
                                            <table class="uk-table uk-table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Status</th>
                                                    <th>Aps</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($network->branches as $n)
                                                    <tr>
                                                        <td>{{$n->name}}</td>
                                                        <td>{{$n->status}}</td>
                                                        <td>{{count($n->aps)}}</td>
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

@stop

@section('scripts')
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

    <script>
        var chart1 = c3.generate({
            bindto: '#chart1',
            data: {
                columns: [
                    ['data1', 30],
                    ['data2', 120],
                    ['data3', 300],
                    ['data4', 50]
                ],
                type: 'donut'
            },
            color: {
                pattern: ['red', '#aec7e8', '#ff7f0e', '#ffbb78']
            },
            donut: {
                title: "nombre"
            }
        });
    </script>
@stop