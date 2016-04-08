<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-container-center uk-width-medium-1">
            <div class="uk-grid" style="margin:10px 0px;">
                <div class="uk-width-medium-1-1" style="padding:0px">
                    Remitente : {{ $cam->content['mail']['from_name'].' <'.$cam->content['mail']['from_mail'].'>' }}<br>
                </div>
                <div class="uk-width-medium-1-1" style="padding:0px">
                    Asunto : {{ $cam->content['mail']['subject'] }}<br>
                </div>
            </div>
        </div>

        <div class="md-list-heading uk-width-large-1 azul">
            <i class="uk-icon-file-picture-o "
               style="margin-right:10px;"></i>Imagen chica :
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
        <div class="md-list-content uk-width-large-1 azul">
            <i class="uk-icon-file-picture-o "
               style="margin-right:10px;"></i>Imagen grande :
            <a id="link" class=""
               data-uk-modal="{target:'#modal_lightbox-2'}">
                {!! isset($cam->content['images']['large'])?$cam->content['images']['large']:'no hay imagen' !!}</a>
            <div class="uk-modal" id="modal_lightbox-2">
                <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                    <button type="button"
                            class="uk-modal-close uk-close uk-close-alt"></button>
                    <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['large'] !!}"
                         alt=""/>
                    <div class="uk-modal-caption">$cam->content['images']['large']</div>
                </div>
            </div>
        </div>

        <a href="#my-id" data-uk-modal="{target:'#my-id'}" style="cursor: pointer;">
            <i class="uk-icon-th-list " style="margin-right:10px;"></i>Contenido del Correo</a>
        <!-- This is the modal -->
        <div id="my-id" class="uk-modal">
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                {!! $cam->content['mail']['content'] !!}
            </div>
        </div>
    </div>
</div>