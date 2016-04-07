<style>
    .tooltip{
        display: inline;
        position: relative;
    }

    .tooltip:hover:after{
        background: #333;
        background: rgba(0,0,0,.8);
        border-radius: 5px;
        bottom: 26px;
        color: #fff;
        content: attr(title);
        left: 20%;
        padding: 5px 15px;
        position: absolute;
        z-index: 98;
        width: 220px;
    }
</style>

<h3 class="heading_c uk-margin-small-bottom">Elementos de la campaña</h3>
@foreach($json as $survey)
    <div class="uk-grid">
        {{--{{dd(($survey['a2']['male'] + $survey['a2']['female']) * 100 / $survey['total'])}}--}}
        <h3 class="heading_c uk-margin-small-bottom">{{$survey['data']['question']}}</h3>
        <div class="uk-width-1" >
            <div class="uk-grid">
                {{--{{dd($survey['a4']['female'])}}--}}
                <div class="uk-width-1-4 md-bg-indigo-300 tooltip" title="{{isset($survey['a1'])? $survey['data']['answers']['a1'] .' Female: '. $survey['a1']['female']. ' Male: '. $survey['a1']['male']  : ''}}"
                     style="width: {{(isset($survey['a1'])? (round(($survey['a1']['male'] + $survey['a1']['female']) * 100 / $survey['total'],2, PHP_ROUND_HALF_UP)) : 0)}}%;
                             display: {{(!isset($survey['a1']) ? 'none' : 'block')}}">
                    <span style="color: white">{{(isset($survey['a1'])? (round(($survey['a1']['male'] + $survey['a1']['female']) * 100 / $survey['total'] ,0,PHP_ROUND_HALF_UP)): 0)}}
                        %</span>
                </div>
                <div class="uk-width-1-4 md-bg-cyan-200 tooltip" title="{{isset($survey['a2'])? $survey['data']['answers']['a2'] .' Female: '. $survey['a2']['female']. ' Male: '. $survey['a2']['male']: ''}}"
                     style="width: {{(isset($survey['a2']) ? (round(($survey['a2']['male'] + $survey['a2']['female']) * 100 / $survey['total'],0,PHP_ROUND_HALF_UP )): 'block')}}%;
                             display: {{(!isset($survey['a2']) ? 'none' : 'block')}}">
                    <span style="color: white">{{(isset($survey['a2'])? (round(($survey['a2']['male'] + $survey['a2']['female']) * 100 / $survey['total'],0,PHP_ROUND_HALF_UP)) : 0)}}
                        %</span>
                </div>
                <div class="uk-width-1-4 md-bg-yellow-500 tooltip" title="{{isset($survey['a3'])? $survey['data']['answers']['a3'] .' Female: '. $survey['a3']['female']. ' Male: '. $survey['a3']['male']: ''}}"
                     style="width: {{(isset($survey['a3']) ? (round(($survey['a3']['male'] + $survey['a3']['female']) * 100 / $survey['total'],0,PHP_ROUND_HALF_UP )): 0)}}%;
                             display: {{(!isset($survey['a3']) ? 'none' : 'block')}}">
                    <span style="color: white">{{(isset($survey['a3'])? (round(($survey['a3']['male'] + $survey['a3']['female']) * 100 / $survey['total'],0,PHP_ROUND_HALF_UP)) : 0)}}
                        %</span>
                </div>
                <div class="uk-width-1-4 md-bg-deep-orange-200 tooltip" title="{{isset($survey['a4'])? $survey['data']['answers']['a4'] .' Female: '. $survey['a4']['female']. ' Male: '. $survey['a4']['male']: ''}}"
                     style="width: {{(isset($survey['a4']) ? (round(($survey['a4']['male'] + $survey['a4']['female']) * 100 / $survey['total'],0 , PHP_ROUND_HALF_UP)) : 0)}}%;
                             display: {{(!isset($survey['a4']) ? 'none' : 'block')}}">
                    <span style="color: white">{{(isset($survey['a4'])? (round(($survey['a4']['male'] + $survey['a4']['female']) * 100 / $survey['total'],0,PHP_ROUND_HALF_UP)) : 0)}}
                        %</span>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if(isset($cam->content['images']))
    <div class="md-list-heading uk-width-large-1 azul ">
        <i class="uk-icon-file-picture-o "
           style="margin-right:10px;"></i>Imagen Encuesta :
        <a id="link" class=""
           data-uk-modal="{target:'#survey-image'}">
            {!! $cam->content['images']['survey'] !!}</a>
        <div class="uk-modal" id="survey-image">
            <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                <button type="button"
                        class="uk-modal-close uk-close uk-close-alt"></button>
                <img src="{!! URL::asset('https://s3-us-west-1.amazonaws.com/enera-publishers/items/'.$cam->content['images']['survey']) !!}"
                     alt="{{$cam->content['images']['survey']}}"/>
                <div class="uk-modal-caption">{{$cam->content['images']['survey']}}</div>
            </div>
        </div>
    </div>
@else
    <div>
        <i class="uk-icon-file-picture-o "
           style="margin-right:10px;"></i> no hay imagen que mostrar
    </div>
    @endif

            <!------- informacion de survey  ---->
    <div class="md-list-content uk-width-large-1 ">
        @if(isset($cam->content['survey']))
            <div class="azul">
                <i class="uk-icon-th-list " style="margin-right:5px;"></i> Preguntas de la encuesta
            </div>
            <div style="margin-left:10px;padding-top:5px;">
                @foreach($cam->content['survey'] as $key => $con)
                    <span class="azul">P {!! $key[1] !!}:</span>
                    <span> &nbsp;{!! $con['question'] !!}</span>
                    <br>
                    @foreach($con['answers'] as $key => $a)
                        <ul>
                            <li class="p"><p>R {!! $key[1] !!}
                                    : {!! $a !!}</p>
                        </ul>
                    @endforeach
                @endforeach
            </div>
        @else
            <div class="">
                <i class="uk-icon-th-list " style="margin-right:10px;"></i> no hay preguntas que mostrar
            </div>
        @endif
    </div>