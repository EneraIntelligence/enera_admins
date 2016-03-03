<h3 class="heading_c uk-margin-small-bottom">Elementos de la campaña</h3>

<div class="md-list-heading uk-width-large-1 azul">
    <i class="uk-icon-file-picture-o " style="margin-right:10px;"></i>Imagen
    Chica :
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
<div class="md-list-heading uk-width-large-1 azul">
    <i class="uk-icon-file-picture-o " style="margin-right:10px;"></i>Imagen
    Grande :
    <a id="link" class=""
       data-uk-modal="{target:'#captcha-image-2'}">
        {!! isset($cam->content['images']['large'])?$cam->content['images']['large']:'imagen no definida' !!}</a>
    <div class="uk-modal" id="captcha-image-2">
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
<div class="md-list-heading uk-width-large-1 azul">
    <i class="uk-icon-key " style="margin-right:10px;"></i>Texto Captcha :
    <a id="link" class="">
        {!!isset($cam->content['captcha'])?  $cam->content['captcha']:'texto no definido' !!}</a>
</div>