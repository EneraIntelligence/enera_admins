<div id="page_content">
    <div id="page_content_inner">
        <div class="gallery_grid uk-grid-width-medium-1-2 uk-grid-width-large-1-2" data-uk-grid="{gutter: 16}">
            <div>
                <div class="md-card md-card-hover">
                    <div class="gallery_grid_item md-card-content">
                        <a href="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['large'] !!}" data-uk-lightbox="{group:'gallery'}">
                            <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['large'] !!}"
                                 alt="" style="width: 480px; height: 450px;"/>
                        </a>
                        <div class="gallery_grid_image_caption">
                            <span class="gallery_image_title uk-text-truncate">{!! $cam->content['images']['large'] !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover">
                    <div class="gallery_grid_item md-card-content">
                        <a href="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['small'] !!}" data-uk-lightbox="{group:'gallery'}">
                            <img src="{!! "https://s3-us-west-1.amazonaws.com/enera-publishers/items/". $cam->content['images']['small'] !!}"
                                 alt="" style="width: 480px; height: 450px;"  />
                        </a>
                        <div class="gallery_grid_image_caption">
                            <span class="gallery_image_title uk-text-truncate">{!! $cam->content['images']['small'] !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>