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
                        <a class="md-btn" href="{{ route('campaigns::active::campaign', [$cam->id]) }}"><i
                                    class="material-icons">&#xE876;</i>Aceptar</a>
                        <a class="md-btn" href="#" data-uk-modal="{target:'#reject',bgclose:false}"><i
                                    class="material-icons">&#xE14C;</i>Rechazar</a>
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

    <div id="reject" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <form  action="{!! route('campaigns::reject::campaign') !!}" class="uk-form-stacked" method="post" id="form" data-parsley-validate
                  enctype="multipart/form-data">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1">
                        <div class="parsley-row">
                            <label for="fullname">Razon</label>
                            <input type="text" name="razon" required class="md-input"/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <div class="parsley-row">
                            <label for="message">Explicación</label>
                            <textarea class="md-input" name="motivo" cols="10" rows="8" data-parsley-trigger="keyup"
                                      data-parsley-minlength="20" data-parsley-maxlength="500"
                                      data-parsley-validation-threshold="10"  required
                                      data-parsley-minlength-message="Debes ingresar al menos 20 caracteres"></textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <button type="submit" class="md-btn md-btn-primary">Rechazar</button>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <input type="hidden" name="campaign_id" value="{{$cam->_id}}">
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
    <script>
        $('#form').parsley();
    </script>
@stop