@extends('layout.main')
@section('head_scripts')
        <!-- c3.js (charts) -->
{!! HTML::style('bower_components/c3js-chart/c3.min.css') !!}

<style>
    li p {
        font: 400 14px/18px Roboto, sans-serif;
        color: #000000;
        margin-bottom: 0;
    }

    .p {
        list-style: none;
    }

    #button {
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>
@endsection

@section('content')
    <div id="page_content">
        <div id="page_content_inner">
            <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
                <div class="uk-width-large-1">
                    <div class="md-card">
                        <div class="user_heading">
                            <div class="user_heading_menu" data-uk-dropdown>
                                <i class="md-icon material-icons md-icon-light">&#xE5D4;</i>
                                {{--<div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
                                    <ul class="uk-nav">
                                        <li><a href="#">Action 1</a></li>
                                        <li><a href="#">Action 2</a></li>
                                    </ul>
                                </div>--}}
                            </div>
                            <div class="user_heading_avatar">
                                <div>
                                    <div id="circle" style="max-width:98px;max-height:98px;margin:auto;">
                                        <img class="svg"
                                             style="background-image:none!important;margin:-103px 0px;background:transparent;border:none;"
                                             src="{!! URL::asset('images/icons/'.
                                                                CampaignStyle::getCampaignIcon( $cam->interaction['name']
                                                             ) ) !!}2.svg"
                                             alt="producto"/>
                                    </div>
                                </div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b uk-margin-bottom"><span
                                            class="uk-text-truncate">{{ $cam->name }} </span><span
                                            class="sub-heading">{{ (str_replace("_", " ",$cam->interaction['name'])) }}</span>
                                </h2>
                            </div>
                            <a data-uk-tooltip="{pos:'left'}" title="{!! $cam->status !!}"
                               class="md-fab md-fab-small md-fab-accent {!! CampaignStyle::getStatusColor($cam->status) !!} ">
                                {{--style="background: {!! Publishers\Libraries\CampaignStyleHelper::getStatusColor($cam->status) !!}">  --}}{{-- href="page_user_edit.html" --}}
                                <i class="material-icons">{!! CampaignStyle::getStatusIcon($cam->status) !!}</i>
                            </a>
                        </div>
                        <div class="md-card-content">
                            <div class="user_content">
                                {{--@if($cam->status == 'pending')--}}
                                {{--<div class="uk-margin-bottom" data-uk-margin>--}}
                                {{--<div class="md-btn-group">--}}
                                {{--<a class="md-btn"--}}
                                {{--href="{{ route('campaigns::active::campaign', [$cam->id]) }}"><i--}}
                                {{--class="material-icons">&#xE876;</i>Aceptar</a>--}}
                                {{--<a class="md-btn" href="#" data-uk-modal="{target:'#reject',bgclose:false}"><i--}}
                                {{--class="material-icons">&#xE14C;</i>Rechazar</a>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--@endif--}}
                                <div class="uk-grid uk-margin-medium-top uk-width-large-1-1 " data-uk-grid-margin>
                                    <div class="uk-width-large-1-2">
                                        <div class="uk-grid">
                                            <div class="uk-width-large-1-2">
                                                <h4 class="heading_c uk-margin-small-bottom">Información</h4>
                                                <ul class="md-list md-list-addon ul">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="material-icons md-36">&#xE851;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Administrador</span>
                                                            <span class="uk-text-small uk-text-muted">{{ $cam->administrator->name['first'].' '.$cam->administrator->name['last']  }}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon uk-icon-archive"></i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Nombre</span>
                                                            <span class="uk-text-small uk-text-muted">{{ $cam->name }}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element azul">
                                                            <i class="md-list-addon-icon uk-icon-dashboard"></i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Estado</span>
                                                            <span class="uk-text-small uk-text-muted">{{ $cam->status }}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element azul">
                                                            <i class="md-list-addon-icon uk-icon-money"></i>
                                                        </div>
                                                        <div class="md-list-content azul">
                                                            <span class="md-list-heading">Balance</span>
                                                            <span class="uk-text-small uk-text-muted">$ {{number_format($cam->balance['current'],2)}}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element azul">
                                                            <i class="md-list-addon-icon uk-icon-check-square-o"></i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Interacción</span>
                                                            <span class="uk-text-small uk-text-muted">{{$cam->interaction['name']}}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element azul">
                                                            <i class="md-list-addon-icon uk-icon-road"></i>
                                                        </div>
                                                        <div class="md-list-content azul">
                                                            <span class="md-list-heading">Lugares</span>
                                                            @if($lugares!='global')
                                                                @foreach($lugares as $branch)
                                                                    <span>
                                                                        {{ Admins\Branche::find($branch)->name }},
                                                                    </span>
                                                                @endforeach
                                                            @else
                                                                <span>Global</span>
                                                            @endif
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="uk-width-large-1-2">
                                                <h4 class="heading_c uk-margin-small-bottom">Filtros</h4>
                                                <ul class="md-list ul">
                                                    <li>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Fecha de la interaccion</span>
                                                            <span class="uk-text-small uk-text-muted">inicia : &nbsp;&nbsp;&nbsp;&nbsp;{{ date('Y-m-d', $cam->filters['date']['start']->sec) }} </span>
                                                            <span class="uk-text-small uk-text-muted">finaliza : &nbsp;{{ date('Y-m-d', $cam->filters['date']['end']->sec) }} </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Rango de Edad</span>
                                                            {{--<span class="uk-text-small uk-text-muted">{{  $cam->filters['age'][0].' a '.$cam->filters['age'][1]}} </span>--}}
                                                            <span class="uk-text-small uk-text-muted">{{ isset($cam->filters['age'][0])? $cam->filters['age'][0].' a '.$cam->filters['age'][1] :'no definido' }} </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Generos</span>
                                                                    <span class="uk-text-small uk-text-muted">
                                                                        {{--{{ trans_choice('gender.'.$cam->filters['gender'][0],1) }}--}}
                                                                        {{ isset($filters['gender'][1]) ? trans_choice('gender.'.$cam->filters['gender'][0],1):'ambos' }}
                                                                        , {{ isset($filters['gender'][2]) ? trans_choice('gender.'.$cam->filters['gender'][1],1):' ' }}
                                                                    </span>
                                                            {{--{{$filters['gender'][0].',  '.$filters['gender'][1]}}--}}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Dias</span>
                                                            <span class="uk-text-small uk-text-muted">
                                                                @if(isset($cam->filters['week_days'] ))
                                                                    @foreach($cam->filters['week_days'] as $dia)
                                                                        {{ trans('days.'.$dia) }},
                                                                    @endforeach
                                                                @else
                                                                    no definido
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading azul">Horario</span>
                                                                    <span class="uk-text-small uk-text-muted">
                                                                        @if(isset($cam->filters['day_hours']))
                                                                            {{ $cam->filters['day_hours'][0].':00' }}
                                                                            a {{ $cam->filters['day_hours'][count($cam->filters['day_hours'])-1].':00' }}
                                                                        @else
                                                                            no se definio horario
                                                                        @endif
                                                                    </span>
                                                        </div>
                                                    </li>
                                                    {{-- esta parte usao if para saber que es lo que se va a mostrar --}}
                                                    <li>
                                                        <div class="md-list-content azul">
                                                            <span class="md-list-heading">Usuario unico </span>
                                                            <span class="uk-text-small uk-text-muted">{{ isset($cam->filters['unique_user'])?'SI':'NO' }}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-content azul">
                                                            <span class="md-list-heading">Usuarios unicos por dia </span>
                                                            <span class="uk-text-small uk-text-muted">{{ isset($cam->filters['unique_user_per_day'])? $cam->filters['unique_user_per_day'] :0 }}</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-content azul">
                                                            <span class="md-list-heading">Meta de interacciones </span>
                                                            <span class="uk-text-small uk-text-muted">{{ isset($cam->filters['max_interactions'])?$cam->filters['max_interactions']:'no definido' }}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="md-list-content uk-width-large-1-1">
                                            <h3 class="heading_c uk-margin-small-bottom">Elementos de la campaña</h3>
                                            @if($cam->interaction['name'] == 'banner'|| $cam->interaction['name'] ==  'banner_link')
                                                <div class="md-list-heading uk-width-large-1-2"
                                                     style="color: #1e88e5;float: left">
                                                    Imagen chica :
                                                    <a id="link" class=""
                                                       data-uk-modal="{target:'#modal_lightbox-1'}">{!! isset($cam->content['images']['small'])?$cam->content['images']['small']:'no hay imagen' !!}</a>
                                                    <div class="uk-modal" id="modal_lightbox-1">
                                                        <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                            <button type="button"
                                                                    class="uk-modal-close uk-close uk-close-alt"></button>
                                                            <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['small'] !!}"
                                                                 alt=""/>
                                                            <div class="uk-modal-caption">{!! $cam->content['images']['small'] !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="md-list-content uk-width-large-1-2"
                                                     style=" color: #1e88e5;float: right;">
                                                    Imagen grande :
                                                    <a id="link" class=""
                                                       data-uk-modal="{target:'#modal_lightbox-2'}">
                                                        {!! isset($cam->content['images']['large'])?$cam->content['images']['large']:'no hay imagen' !!}</a>
                                                    <div class="uk-modal" id="modal_lightbox-2">
                                                        <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                            <button type="button"
                                                                    class="uk-modal-close uk-close uk-close-alt"></button>
                                                            <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['large'] !!}"
                                                                 alt=""/>
                                                            <div class="uk-modal-caption">Lorem</div>
                                                        </div>
                                                    </div>
                                                    {{--<span class="uk-text-small uk-text-muted"><img class="uk-width-large-2-6" src="{!! URL::asset('images/'.$content['imageng']) !!}" alt=""></span>--}}
                                                </div>
                                                <h3 class="md-hr" style="margin-bottom: 10px;"></h3>
                                                <div class="md-list-content uk-width-large-1-2"
                                                     style=" color: #1e88e5;">
                                                    Link a redireccionar :
                                                    <a id="link" class=""
                                                       href="http://{{ isset($cam->content['link'])? str_replace("http://","",$cam->content['link']):'no definido' }}"
                                                       target="_blank">{!! isset($cam->content['link'])? $cam->content['link']:'no hay una definida www.enera.com ' !!}</a>
                                                </div>
                                            @endif
                                            @if($cam->interaction['name'] == 'captcha')
                                                <div class="md-list-heading uk-width-large-1-2"
                                                     style="color: #1e88e5;float: left">
                                                    Imagen Chica :
                                                    <a id="link" class=""
                                                       data-uk-modal="{target:'#captcha-image'}">
                                                        {!! isset($cam->content['images']['small'])?$cam->content['images']['small']:'imagen no definida' !!}</a>
                                                    <div class="uk-modal" id="captcha-image">
                                                        <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                            <button type="button"
                                                                    class="uk-modal-close uk-close uk-close-alt"></button>
                                                            @if(isset($cam->content['images']['small']))
                                                                <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['small'] !!}"
                                                                     alt=""/>
                                                            @endif
                                                            <div class="uk-modal-caption">{{$cam->content['images']['small']}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="md-list-heading uk-width-large-1-2"
                                                     style="color: #1e88e5;float: left">
                                                    Imagen Grande :
                                                    <a id="link" class=""
                                                       data-uk-modal="{target:'#captcha-image'}">
                                                        {!! isset($cam->content['images']['large'])?$cam->content['images']['large']:'imagen no definida' !!}</a>
                                                    <div class="uk-modal" id="captcha-image">
                                                        <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                            <button type="button"
                                                                    class="uk-modal-close uk-close uk-close-alt"></button>
                                                            @if(isset($cam->content['images']['large']))
                                                                <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['large'] !!}"
                                                                     alt=""/>
                                                            @endif
                                                            <div class="uk-modal-caption">{{$cam->content['images']['large']}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="md-list-heading uk-width-large-1-2"
                                                     style="color: #1e88e5;float: left">
                                                    Texto Captcha :
                                                    <a id="link" class="">
                                                        {!!isset($cam->content['captcha'])?  $cam->content['captcha']:'texto no definido' !!}</a>
                                                </div>
                                            @endif
                                            @if($cam->interaction['name'] == 'mailing_list')
                                                @if(isset($cam->content['images']))
                                                    <div class="md-list-heading uk-width-large-1-2"
                                                         style="color: #1e88e5;float: left">
                                                        Imagen Chica :
                                                        <a id="link" class=""
                                                           data-uk-modal="{target:'#captcha-image'}">
                                                            {!! isset($cam->content['images']['small'])?$cam->content['images']['small']:'imagen no definida' !!}</a>
                                                        <div class="uk-modal" id="captcha-image">
                                                            <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                                <button type="button"
                                                                        class="uk-modal-close uk-close uk-close-alt"></button>
                                                                @if(isset($cam->content['images']['small']))
                                                                    <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['small'] !!}"
                                                                         alt=""/>
                                                                @endif
                                                                <div class="uk-modal-caption">{{$cam->content['images']['small']}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="md-list-heading uk-width-large-1-2"
                                                         style="color: #1e88e5;float: left">
                                                        Imagen Grande :
                                                        <a id="link" class=""
                                                           data-uk-modal="{target:'#captcha-image'}">
                                                            {!! isset($cam->content['images']['large'])?$cam->content['images']['large']:'imagen no definida' !!}</a>
                                                        <div class="uk-modal" id="captcha-image">
                                                            <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                                <button type="button"
                                                                        class="uk-modal-close uk-close uk-close-alt"></button>
                                                                @if(isset($cam->content['images']['large']))
                                                                    <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['large'] !!}"
                                                                         alt=""/>
                                                                @endif
                                                                <div class="uk-modal-caption">{{$cam->content['images']['large']}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="md-list-heading uk-width-large-1-2"
                                                         style="color: #1e88e5;float: left">
                                                        no hay imagen definida
                                                    </div>
                                                    @endif

                                                            <!-- create mailing campaign button start -->
                                                    {{--<div class="uk-grid uk-margin-medium-top" data="uk-grid-margin">
                                                        <div class="uk-width-1-1">
                                                            <div class="uk-width-medium-1-1">
                                                                <a class="md-btn md-btn-primary"
                                                                   onclick="new_campaign.promptMailingCampaign('{{$cam->_id}}')">
                                                                    <span class="uk-display-block">Crear campaña de mailing</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>--}}
                                                            <!-- create mailing campaign button end -->

                                                @endif
                                                @if($cam->interaction['name'] == 'survey')
                                                    @if(isset($cam->content['survey']))
                                                        <div class="md-list-heading uk-width-large-1"
                                                             style="color: #1e88e5;float: left">
                                                            Imagen Encuesta :
                                                            <a id="link" class=""
                                                               data-uk-modal="{target:'#survey-image'}">
                                                                {!! $cam->content['images']['survey'] !!}</a>
                                                            <div class="uk-modal" id="survey-image">
                                                                <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                                    <button type="button"
                                                                            class="uk-modal-close uk-close uk-close-alt"></button>
                                                                    <img src="{!! URL::asset('images/'.$cam->content['images']['survey']) !!}"
                                                                         alt="{{$cam->content['images']['survey']}}"/>
                                                                    <div class="uk-modal-caption">Lorem</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div>
                                                            no hay imagen que mostrar
                                                        </div>
                                                        @endif
                                                                <!------- informacion de survey  ---->
                                                        <div class="md-list-content uk-width-large-1"
                                                             style=" color: #1e88e5;">
                                                            @if(isset($cam->content['survey']))
                                                                @foreach($cam->content['survey'] as $key => $con)
                                                                    <span>Pregunta {!! $key[1] !!}
                                                                        : &nbsp;{!! $con['question'] !!}</span>
                                                                    <br>
                                                                    @foreach($con['answers'] as $key => $a)
                                                                        <ul>
                                                                            <li class="p"><p>Respuesta {!! $key[1] !!}
                                                                                    : {!! $a !!}</p>
                                                                        </ul>
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                <div>
                                                                    no hay preguntas que mostrar
                                                                </div>
                                                            @endif

                                                        </div>
                                                    @endif
                                                    @if($cam->interaction['name'] == 'video')
                                                        <div class="md-list-heading uk-width-large-1-2"
                                                             style="color: #1e88e5;float: left">
                                                            @if(isset($cam->content['video']))
                                                                Video :
                                                                <a id="link" class=""
                                                                   data-uk-modal="{target:'#video'}">
                                                                    {!! $cam->content['video'] !!}</a>
                                                                <div class="uk-modal" id="video">
                                                                    <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                                        <button type="button"
                                                                                class="uk-modal-close uk-close uk-close-alt"></button>
                                                                        <video width="600" height="300" controls>
                                                                            <source src="{!! URL::asset('videos/'.$cam->content['video']) !!}"
                                                                                    type="video/mp4">
                                                                            Your browser does not support HTML5 video.
                                                                        </video>
                                                                        {{--<div class="uk-modal-caption">Lorem</div>--}}
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span>
                                                        no hay video asignado
                                                    </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @if($cam->interaction['name'] == 'like')
                                                        <div class="md-list-heading uk-width-large-1-2"
                                                             style="color: #1e88e5;float: left">
                                                            Imagen chica :
                                                            <a id="link" class=""
                                                               data-uk-modal="{target:'#modal_lightbox-1'}">{!! isset($cam->content['images']['small'])?$cam->content['images']['small']:'no hay imagen' !!}</a>
                                                            <div class="uk-modal" id="modal_lightbox-1">
                                                                <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                                    <button type="button"
                                                                            class="uk-modal-close uk-close uk-close-alt"></button>
                                                                    <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['small'] !!}"
                                                                         alt=""/>
                                                                    <div class="uk-modal-caption">{!! $cam->content['images']['small'] !!}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="md-list-content uk-width-large-1-2"
                                                             style=" color: #1e88e5;float: right;">
                                                            Imagen grande :
                                                            <a id="link" class=""
                                                               data-uk-modal="{target:'#modal_lightbox-2'}">
                                                                {!! isset($cam->content['images']['large'])?$cam->content['images']['large']:'no hay imagen' !!}</a>
                                                            <div class="uk-modal" id="modal_lightbox-2">
                                                                <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                                                                    <button type="button"
                                                                            class="uk-modal-close uk-close uk-close-alt"></button>
                                                                    <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['large'] !!}"
                                                                         alt=""/>
                                                                    <div class="uk-modal-caption">Lorem</div>
                                                                </div>
                                                            </div>
                                                            {{--<span class="uk-text-small uk-text-muted"><img class="uk-width-large-2-6" src="{!! URL::asset('images/'.$content['imageng']) !!}" alt=""></span>--}}
                                                        </div>
                                                        <h3 class="md-hr" style="margin-bottom: 10px;"></h3>
                                                        <div class="md-list-content uk-width-large-1-2"
                                                             style=" color: #1e88e5;">
                                                            Url:
                                                            <a id="link" class=""
                                                               href="http://{{ isset($cam->content['like_url'])? str_replace("http://","",$cam->content['like_url']):'no definido' }}"
                                                               target="_blank">{!! isset($cam->content['like_url'])? $cam->content['like_url']:'Like url no definido www.enera.mx' !!}</a>
                                                        </div>
                                                    @endif
                                        </div>
                                    </div>

                                    <div class="uk-width-large-1-2">
                                        <div class="">
                                            <div class="uk-width-medium-1">
                                                <div class="uk-grid">
                                                    <div class="uk-width-medium-1-3 uk-width-small-1-3">
                                                        <div class="uk-width-medium-1-2 uk-width-small-1-2 uk-container-center">
                                                            <i class="uk-icon-eye uk-icon-medium"

                                                               data-uk-tooltip="{pos:'top'}"
                                                               title="visto"></i>

                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-3 uk-width-small-1-3">
                                                        <div class="uk-width-medium-1-2 uk-width-small-1-2 uk-container-center">
                                                            <i class="material-icons md-36"
                                                               data-uk-tooltip="{pos:'top'}"
                                                               title="Completado">done</i>

                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-3 uk-width-small-1-3">
                                                        <div class="uk-kit-medium-2-3 uk-width-small-1-2 uk-container-center">
                                                            <i class="uk-icon-user uk-icon-medium "
                                                               data-uk-tooltip="{pos:'top'}"
                                                               title="Usuario"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-medium-1">
                                                <div class="uk-grid">
                                                    <div class="uk-width-medium-1-3 uk-width-small-1-3">
                                                        <div class="uk-width-medium-1-2 uk-width-small-1-2 uk-container-center">
                                                            <h2 class="jumbo uk-float-left" id="vistos">0</h2>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-3 uk-width-small-1-3">
                                                        <div class="uk-width-medium-1-2 uk-width-small-1-2 uk-container-center">
                                                            <h2 class="jumbo uk-float-left" id="completados">0</h2>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-3 uk-width-small-1-3">
                                                        <div class="uk-kit-medium-2-3 uk-width-small-1-2 uk-container-center">
                                                            <h2 class="jumbo uk-float-left" id="usuarios">0</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="md-card">
                                            <div id="graficas" class="md-card-content">
                                                <h3 class="heading_a uk-margin-bottom">Analiticos</h3>
                                                <div id='intXHour'
                                                     class="uk-width-large-1-1 uk-margin-right"></div>
                                                <h3 class="md-hr" style="margin: 10px;"></h3>
                                                <div id='genderAge' class="uk-width-large-1-1 uk-panel-teaser"
                                                     style="height: 350px"></div>
                                            </div>
                                        </div>
                                        <div class="uk-grid uk-margin-medium-top" data="uk-grid-margin">
                                            <div class="uk-width-1-1">
                                                <div class="uk-width-medium-1-6">
                                                    <a class="md-btn md-btn-primary">
                                                        {{--href="{{route('analytics::single', ['id' => $cam->_id])}}">--}}
                                                        <span class="uk-display-block">Reportes</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($cam->status == 'pending')
        <div class="md-fab-wrapper md-fab-in-card" id="button">
            <div class="md-fab md-fab-accent md-fab-sheet">
                <i class="material-icons md-color-white">&#xE8DD;</i>
                <div class="md-fab-sheet-actions">
                    <a href="{{ route('campaigns::active::campaign', [$cam->id]) }}" class="md-color-white"><i
                                class="material-icons md-color-white">&#xE8DC;</i> Aceptar</a>
                    <a href="#" data-uk-modal="{target:'#reject',bgclose:false}" class="md-color-white"><i
                                class="material-icons md-color-white">&#xE8DB;</i> Rechazar</a>
                </div>
            </div>
        </div>
    @endif

    {{--modal de rechazo--}}
    <div id="reject" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <form action="{!! route('campaigns::reject::campaign') !!}" class="uk-form-stacked" method="post" id="form"
                  data-parsley-validate
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
                                      data-parsley-validation-threshold="10" required
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

            <!-- slider script -->
    {{--{!! HTML::script('js/preview_helper.js') !!}--}}

    {!! HTML::script('bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') !!}
    {!! HTML::script('bower_components/ionrangeslider/js/ion.rangeSlider.min.js') !!}
    {!! HTML::script('bower_components/countUp.js/countUp.js') !!}
    {!! HTML::script('js/circle-progress.js') !!}
    {!! HTML::style('css/show.css') !!}

            <!-- page specific plugins -->
    <!-- d3 -->
    {{--<script src="bower_components/d3/d3.min.js"></script>--}}
    {!! HTML::script('bower_components/d3/d3.min.js') !!}
            <!-- metrics graphics (charts) -->
    {{--<script src="bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>--}}
            <!-- c3.js (charts) -->
    {!! HTML::script('bower_components/c3js-chart/c3.min.js') !!}
            <!-- chartist -->
    {{--<script src="bower_components/chartist/dist/chartist.min.js"></script>--}}
            <!-- links para que funcione la grafica demografica  -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <!--  charts functions -->
    {{--<script src="assets/js/pages/plugins_charts.min.js"></script>--}}

    {!! HTML::script('js/ajax/graficas.js') !!}
    <script>
        //-------------------------------------- animacion del circulo  ---------------------------------------------
        $('#circle').circleProgress({
            value: {!! $porcentaje !!}, //lo que se va a llenar con el color
            size: 98,   //tamaño del circulo
            startAngle: -300, //de donde va a empezar la animacion
            reverse: true, //empieza la animacion al contrario
            thickness: 8,  //el grosor la linea
            fill: {color: "{!! CampaignStyle::getStatusColor($cam->status) !!}"} //el color de la linea
        }).on('circle-animation-progress', function (event, progress) {
            $(this).find('strong').html(parseInt(100 * progress) + '<i>%</i>');
        });

        //-------------------------------------- animación de los numeros  ---------------------------------------------
        var options = {
            useEasing: true,
            useGrouping: true,
            separator: ',',
            decimal: '.',
            prefix: '',
            suffix: ''
        };
        var vistos = new CountUp("vistos", 0, {!! $cam->logs()->where('interaction.loaded','exists',true)->count() !!}, 0, 5.0, options);
        vistos.start();
        var completados = new CountUp("completados", 0, {!! $cam->logs()->where('interaction.completed','exists',true)->count() !!}, 0, 5.0, options);
        completados.start();
        var users = new CountUp("usuarios", 0, {!! count(DB::collection('campaign_logs')->where('campaign_id',$cam->id)->distinct('user.id')->get()) !!}, 0, 5.0, options);
        users.start();

        //------------------------------------------Grafica---------------------------------------------
        var grafica = new graficas;
        var menJson = '{!! json_encode($men) !!}';
        var menObj = JSON.parse(menJson);
        var womenJson = '{!! json_encode($women) !!}';
        var womenObj = JSON.parse(womenJson);

        var intLJson = '{!! json_encode($IntHours) !!}';
        var intLObj = JSON.parse(intLJson);
        //        console.log(intLObj);

        var gra = grafica.genderAge(menObj, womenObj);
        var graf = grafica.intPerHour(intLObj);
    </script>
    <!-- enera custom scripts -->
    {{--{!! HTML::script('assets/js/enera/create_campaign_helper.js') !!}--}}

@stop