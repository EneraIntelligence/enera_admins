<div id="page_content">
    <div style="width: 100%">
        <!-- banner link preview -->
        <div class="interaction uk-align-center uk-position-relative" style="margin: 0 auto; width: 400px;">
            <img class="interaction-image"
                 src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/". $cam->content['images']['large'] !!}"
                 alt="" data-uk-modal="{target:'#video'}" style="width: 480px; height: 450px;"/>
            <div class="uk-clearfix"></div>
        </div>
        <i class="uk-icon-youtube-play"
           style="margin-right:10px;"></i>Video :
        <a id="link" class=""
        >
            video</a>
        <div class="uk-modal" id="video">
            <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                <button type="button"
                        class="uk-modal-close uk-close uk-close-alt"></button>
                <video width="600" height="300" controls>
                    <source src="{!! URL::asset('https://s3-us-west-1.amazonaws.com/enera-publishers/items/2015-02-22 23.02.02.mp4') !!}"
                            type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
                {{--<div class="uk-modal-caption">Lorem</div>--}}
            </div>
        </div>
    </div>
</div>