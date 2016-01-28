@extends('layout.main')
@section('title', ' -  Admin Campaign')
@section('head_scripts')

@stop

@section('content')
    <div id="page_content_inner">

        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-margin-bottom" data-uk-margin>
                    <div class="md-btn-group">
                        <a class="md-btn" href="{{ route('campaigns::active::campaign', [$cam->id]) }}"><i class="material-icons">&#xE876;</i>Aceptar</a>
                        <a class="md-btn" href="#" ><i class="material-icons">&#xE14C;</i>Rechazar</a>
                        <a class="md-btn" href="#" ><i class="material-icons">&#xE002;</i>Borrar</a>
                    </div>
                </div>
                <hr/>
                <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                    <div class="uk-width-medium-3-4">
                        <div class="uk-margin-large-bottom">
                            <h2 class="heading_c uk-margin-small-bottom">{!! ucfirst(str_replace('_', ' ', $cam->interaction['name'])) !!}</h2>
                        </div>
                        <div>
                            @if(view()->exists('campaigns.partials.'.$cam->interaction['name']))
                                @include('campaigns.partials.'.$cam->interaction['name'])
                            @else
                                <p>error</p>
                            @endif
                        </div>

                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-margin-medium-bottom">
                            <p>
                                Status:
                                <span class="uk-badge uk-badge-outline uk-text-upper uk-margin-small-left">{!! $cam->status !!}</span>
                            </p>
                        </div>
                        <h2 class="heading_c uk-margin-small-bottom">Detalles</h2>
                        <ul class="md-list md-list-addon">
                            <li>
                                <div class="md-list-addon-element">
                                    <i class="md-list-addon-icon material-icons">&#xE8D3;</i>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading">{!! $cam->administrator->name['first'].' '. $cam->administrator->name['last']  !!}</span>
                                    <span class="uk-text-small uk-text-muted">Administrador</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-addon-element">
                                    <i class="md-list-addon-icon material-icons">&#xE8DF;</i>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading">{!! $cam->created_at !!}</span>
                                    <span class="uk-text-small uk-text-muted">Creada</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-addon-element">
                                    <i class="md-list-addon-icon material-icons">&#xE8B5;</i>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading">{!! date('Y-m-d h:m:s', $cam->filters['date']['start']->sec) !!}</span>
                                    <span class="uk-text-small uk-text-muted">Inicia</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-addon-element">
                                    <i class="md-list-addon-icon material-icons">&#xE01B;</i>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading">{!! date('Y-m-d h:m:s', $cam->filters['date']['end']->sec) !!}</span>
                                    <span class="uk-text-small uk-text-muted">Finaliza</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('scripts')

@stop