<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <div class="gallery_grid uk-grid-width-medium-1 uk-grid-width-large-1" data-uk-grid="{gutter: 16}">
                    <div>
                        <div class="md-card md-card-hover">
                            <div class="gallery_grid_item md-card-content">
                                <a href="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/avatars/". $cam->content['images']['survey'] !!}" data-uk-lightbox="{group:'gallery'}">
                                    <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/avatars/". $cam->content['images']['survey'] !!}"
                                         alt="" style="width: 480px; height: 450px;"/>
                                </a>
                                <div class="gallery_grid_image_caption">
                                    <span class="gallery_image_title uk-text-truncate">{!! $cam->content['images']['survey'] !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-medium-1-2">
                @if(isset($cam->content['survey']))
                    <div class="azul">
                        <i class="uk-icon-th-list " style="margin-right:5px;"></i> Preguntas de la encuesta
                    </div>
                    <div style="margin-left:10px;padding-top:5px;" >
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
        </div>
    </div>
</div>