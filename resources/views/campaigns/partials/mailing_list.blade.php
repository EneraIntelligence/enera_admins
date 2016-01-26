<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-container-center uk-width-medium-1">
            <div class="uk-grid" style="margin: 20px;">
                <div class="uk-width-medium-1-3">
                    <p>Remitente : {!! $cam->content['mail']['from_name'] !!}</p>
                </div>
                <div class="uk-width-medium-1-3">
                    <p>Correo : {!! $cam->content['mail']['from_mail'] !!}</p>
                </div>
                <div class="uk-width-medium-1-3">
                    <p>Asunto : {!! $cam->content['mail']['subject'] !!}</p>
                </div>
            </div>
        </div>
        <p>Contenido:</p>
        {!! $cam->content['mail']['content'] !!}
    </div>
</div>