<!-- campaign elements -->
<h3 class="heading_c uk-margin-small-bottom">Elementos de la campaña</h3>

<div class="md-list-heading uk-width-large-1 azul">
    @if(isset($cam->content['video']))
        <i class="uk-icon-youtube-play"
           style="margin-right:10px;"></i>Video :
        <a id="link" class=""
           data-uk-modal="{target:'#video'}">
            {!! $cam->content['video'] !!}</a>
        <div class="uk-modal" id="video">
            <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                <button type="button"
                        class="uk-modal-close uk-close uk-close-alt"></button>
                <video width="600" height="300" controls>
                    <source src="{!! URL::asset('https://s3-us-west-1.amazonaws.com/enera-publishers/items/'.$cam->content['video']) !!}"
                            type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
                {{--<div class="uk-modal-caption">Lorem</div>--}}
            </div>
        </div>
    @else
        <span>
            <i class="uk-icon-youtube-play" style="margin-right:10px;"> no
                hay video asignado </i>
        </span>
    @endif
</div>