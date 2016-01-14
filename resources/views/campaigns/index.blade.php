@extends('layout.main')
@section('title', ' -  Campaña')
@section('head_scripts')
    {!! HTML::style(asset('assets/css/campaign.css')) !!}
@endsection
@section('content')


    <div id="page_content">
        <div class="uk-grid"  id="grid">
            <div class="uk-width-8-10 uk-container-center" >
                {{--id="container-center">--}}
                <h4 class="heading_a uk-align-left" style="display:inline-block;">Campañas</h4>
                <div class="uk-grid uk-align-right">
                    @if(count($campaigns)<=0)
                        <div class="uk-button-dropdown"  id="dropdown" data-uk-dropdown>
                            @else
                                <div class="uk-button-dropdown abajo" data-uk-dropdown>
                                    @endif

                                    <button class="md-btn bottom-10">
                                        Filtrar campañas
                                        <i class="material-icons"></i>
                                    </button>
                                    <div class="uk-dropdown uk-dropdown-width-2">
                                        <div class="uk-grid uk-dropdown-grid">
                                            <div class="uk-width-1-2">
                                                <ul class="uk-nav uk-nav-dropdown" id="campaign-filter">
                                                    <li class="uk-nav-header">Estado</li>
                                                    <li class="uk-active" data-uk-filter="">
                                                        <a href="#">Todas</a>
                                                    </li>
                                                    <li data-uk-filter="campaign-active">
                                                        <a href="#">Activas</a>
                                                    </li>
                                                    <li data-uk-filter="campaign-pending">
                                                        <a href="#">En espera</a>
                                                    </li>
                                                    <li data-uk-filter="campaign-rejected">
                                                        <a href="#">Rechazadas</a>
                                                    </li>
                                                    <li data-uk-filter="campaign-ended">
                                                        <a href="#">Terminadas</a>
                                                    </li>
                                                    <li data-uk-filter="campaign-canceled">
                                                        <a href="#">Canceladas</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="uk-width-1-2">
                                                <ul class="uk-nav uk-nav-dropdown" id="action-filter">
                                                    <li class="uk-nav-header">Interacción</li>
                                                    <li data-uk-filter="action-banner">
                                                        <a href="#">Banner</a>
                                                    </li>

                                                    <li data-uk-filter="action-banner_link">
                                                        <a href="#">Banner+Link</a>
                                                    </li>

                                                    <li data-uk-filter="action-mailing_list">
                                                        <a href="#">Mailing list</a>
                                                    </li>

                                                    <li data-uk-filter="action-survey">
                                                        <a href="#">Captcha</a>
                                                    </li>

                                                    <li data-uk-filter="action-survey">
                                                        <a href="#">Encuesta</a>
                                                    </li>

                                                    <li data-uk-filter="action-video">
                                                        <a href="#">Video</a>
                                                    </li>


                                                </ul>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                @if(count($campaigns)<=0 && count($subcampaigns)<=0)
                                    <div class="uk-button-dropdown" id="event" data-uk-dropdown>
                                        @else
                                            <div class="uk-button-dropdown" style="" data-uk-dropdown>
                                                @endif

                                                <button class="md-btn">
                                                    Ordenar por:
                                                    <i class="material-icons"></i>
                                                </button>


                                                <div class="uk-dropdown uk-dropdown-small">
                                                    <ul class="uk-nav uk-nav-dropdown" id="campaign-sort">
                                                        <li class="uk-active" data-uk-sort="date">
                                                            <a href="#">Fecha de creación</a>
                                                        </li>
                                                        <li data-uk-sort="name">
                                                            <a href="#">Nombre</a>
                                                        </li>
                                                        <li data-uk-sort="company">
                                                            <a href="#">Compañía</a>
                                                        </li>
                                                        <li data-uk-sort="action">
                                                            <a href="#">Interacción</a>
                                                        </li>
                                                        <li data-uk-sort="status">
                                                            <a href="#">Estado</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                    </div>


                        </div>
                </div>


                <div id="page_content_inner">

                    @if(count($campaigns)<=0)

                        <div class="uk-grid uk-text-center">

                            <div class="uk-width-1-10">
                            </div>

                            <div class="uk-width-8-10">

                                <div class="uk-block md-card ">
                                    <h4 class="heading_a"><br>
                                        <span></span>
                                    </h4>


                                    <img src="{!! URL::asset('img/icons/banner_new.svg') !!}" alt="">

                                    <h4 class="heading_a"><br>
                                        <span></span>
                                    </h4>

                                    <a class="md-btn md-btn-primary disabled" href="#" >
                                        ¡No hay campañas por aprobar!
                                    </a>

                                </div>

                            </div>

                        </div>

                    @endif

                    <div class="uk-width-large-9-10 uk-container-center">
                        <div id="snippets">
                            <div class="uk-grid uk-grid-width-1-1 hierarchical_show"
                                 data-uk-grid="{ gutter: 16, controls: '#campaign-filter, #action-filter, #campaign-sort' }">
                                @foreach($campaigns as $campaign)
                                    {{--                                    {{var_dump($campaign->grafica['dia1'])}}--}}
                                    <div data-uk-filter="campaign-{!! $campaign->status !!}, action-{!! $campaign->interaction['name'] !!}"
                                         data-name="{!! $campaign->name !!}"
                                         data-action="{!! $campaign->interaction['name'] !!}"
                                         data-company="{!! $campaign->publishers_summary['client'] !!}"
                                         data-status="{!! CampaignStyle::getStatusValue( $campaign->status )  !!}"
                                         data-date="{!! $campaign->created_at !!}"
                                         style="cursor: pointer;">

                                        <div onclick="window.location.href='{!! route('campaigns::show',['id'=>$campaign->_id]) !!}'"
                                             class="scrum_task {!! CampaignStyle::getStatusColorClass( $campaign->status ) !!}"
                                             data-snippet-title="{!! $campaign->name !!}">

                                            <div class="md-card-content uk-grid">

                                                <!-- icon -->
                                                <div class="interaction-icon uk-width-medium-1-10 uk-hidden-small">
                                                    <div class="uk-vertical-align"  id="name"
                                                         data-uk-tooltip="{cls:'long-text'}"
                                                         title="{{$campaign->interaction['name']}} - {!! $campaign->status !!}">
                                                        <img src="{!! URL::asset('img/icons/'.
                                                                CampaignStyle::getCampaignIcon( $campaign->interaction['name']
                                                             ) ) !!}" alt="">

                                                    </div>

                                                </div>

                                                <!-- campaign name -->
                                                <div id="campaign-title" class="uk-width-medium-3-10 uk-width-small-1-1">
                                                    <h2>{{$campaign->name}}</h2>
                                                    <h4>{{$campaign->publishers_summary['client']}}</h4>
                                                </div>

                                                <!-- days and budget bars -->
                                                <div class="uk-width-medium-4-10 uk-width-small-1-2" >

                                                    <div class="uk-grid uk-grid-medium" style="max-width: 317px;">

                                                        <div class="uk-width-1-6 margin-10 top-bottom-20" >
                                                            <i class="uk-icon-calendar"></i>
                                                        </div>

                                                        <div class="uk-width-5-6 margin-10 top-bottom-20" >
                                                            @if($campaign->dias['porcentaje']==0)
                                                                <div class="uk-progress uk-progress uk-progress-striped " style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width: {!! $campaign->status=='active'?'100%':'0%' !!};"> </div>
                                                                </div>
                                                                <div id="porcentaje"  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #FFFFff; ">{!! $campaign->dias['total'] !!}  día(s) restantes </span>
                                                                </div>
                                                            @elseif($campaign->dias['porcentaje']<=50)
                                                                <div class="uk-progress uk-progress-success uk-progress-striped uk-active" style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width:{{$campaign->dias['porcentaje']}}%;"> </div>
                                                                </div>
                                                                <div id="porcentaje"  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #000; ">{{$campaign->dias['total']}} día(s) restantes </span>
                                                                </div>
                                                            @elseif($campaign->dias['porcentaje']<=80)
                                                                <div class="uk-progress uk-progress-warning uk-progress-striped uk-active" style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width:{{$campaign->dias['porcentaje']}}%;"> </div>
                                                                </div>
                                                                <div id="porcentaje"  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #000; ">{{$campaign->dias['total']}}  día(s) restantes </span>
                                                                </div>
                                                            @elseif($campaign->dias['porcentaje']>=80)
                                                                <div class="uk-progress uk-progress-danger uk-progress-striped uk-active " style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width:{{$campaign->dias['porcentaje']}}%;"> </div>
                                                                </div>
                                                                <div id="porcentaje"  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #FFFFff; ">{{$campaign->dias['total']}}  día(s) restantes </span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="uk-width-1-6 margin-10 top-bottom-20" >
                                                            <i class="uk-icon-money"></i>
                                                        </div>
                                                        @if($campaign->balance['init']==0)
                                                            <div id="dinero" class="uk-width-5-6 margin-10 top-bottom-20" >
                                                                <div class="uk-progress uk-progress-danger" style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width: 100%;"> </div>
                                                                </div>
                                                                <div  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #FFFFff; ">$ 0.00</span>
                                                                </div>
                                                            </div>
                                                        @elseif($campaign->balance['init']!=0 && ($campaign->balance['current']*100)/$campaign->balance['init']<=50 )
                                                            <div id="dinero" class="uk-width-5-6 margin-10 top-bottom-20" >
                                                                <div class="uk-progress uk-progress-danger" style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width: {{($campaign->balance['current']*100)/$campaign->balance['init'] }}%;"> </div>
                                                                </div>
                                                                <div  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #000; ">$ {{ $campaign->balance['current']!=0? number_format($campaign->balance['current'],2):'0' }}</span>
                                                                </div>
                                                            </div>
                                                        @elseif($campaign->balance['init']!=0 && ($campaign->balance['current']*100)/$campaign->balance['init']<=80)
                                                            <div id="dinero" class="uk-width-5-6 margin-10 top-bottom-20" >
                                                                <div class="uk-progress uk-progress-warning" style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width: {{ ($campaign->balance['current']*100)/$campaign->balance['init'] }}%;"> </div>
                                                                </div>
                                                                <div  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #000; "> $ {{ $campaign->balance['current']!=0?number_format($campaign->balance['current'],2):'0' }}</span>
                                                                </div>
                                                            </div>
                                                        @elseif($campaign->balance['init']!=0 && ($campaign->balance['current']*100)/$campaign->balance['init']>=80)
                                                            <div id="dinero" class="uk-width-5-6 margin-10 top-bottom-20" >
                                                                <div class="uk-progress uk-progress-success" style="z-index: -5">
                                                                    <div class="uk-progress-bar" style="width: {{ ($campaign->balance['current']*100)/$campaign->balance['init'] }}%;"> </div>
                                                                </div>
                                                                <div  style="z-index:10; text-align:center; margin-top:-35px;">
                                                                    <span style="margin:auto; color: #FFFFff; ">$ {{ $campaign->balance['current']!=0?number_format($campaign->balance['current'],2):'0' }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>

                                                @if($campaign->status=="pending")
                                                    <!-- check campaign button -->
                                                    <div class="uk-width-medium-2-10  uk-width-small-1-2">
                                                    <a class="md-btn md-btn-warning">
                                                        Revisar campaña
                                                    </a>
                                                </div>
                                                @endif;

                                            </div>
                                        </div>
                                    </div>

                                    @foreach($subcampaigns as $sub)

                                        @if($sub->campaign_id==$campaign->_id)

                                            <div data-uk-filter="campaign-{!! $sub->status !!}, action-mailing"
                                                 data-name="{!! $sub->name !!}"
                                                 data-action="mailing"
                                                 data-company="{!! $sub->publishers_summary['client'] !!}"
                                                 data-status="{!! CampaignStyle::getStatusValue( $sub->status )  !!}"
                                                 data-date="{!! $sub->created_at !!}"
                                                 style="cursor: pointer;">

                                                <div onclick="window.location.href='{!! route('campaigns::sub',['id'=>$sub->_id]) !!}'"
                                                     class="scrum_task {!! CampaignStyle::getStatusColorClass( $sub->status ) !!}"
                                                     data-snippet-title="{!! $sub->name !!}" style="margin-left:20px;">
                                                    <div class="md-card-content uk-grid">

                                                        <div class="interaction-icon uk-width-large-1-10 uk-hidden-small uk-width-medium-1-4 uk-hidden-medium">
                                                            <div class="uk-vertical-align"  id="name"
                                                                 data-uk-tooltip="{cls:'long-text'}"
                                                                 title="{{$sub->interaction['name']}} - {!! $sub->status !!}"
                                                            >

                                                                <img src="{!! URL::asset('img/icons/mailing.svg') !!}" alt="">

                                                            </div>

                                                        </div>

                                                        <div id="campaign-title"
                                                             class="uk-width-large-5-10 uk-grid-width-small-2-3  uk-width-medium-1-4 uk-width-large-1">
                                                            <h4>Subcampaña de mailing</h4>
                                                            <h2>{{$sub->name}}</h2>

                                                        </div>



                                                    </div>


                                                </div>
                                            </div>

                                        @endif

                                    @endforeach


                                @endforeach


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end campaigns content -->
@stop

@section('scripts')


@stop