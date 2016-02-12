@extends('layout.main')
@section('title', ' -  Campaña')
@section('head_scripts')
    {!! HTML::style(asset('assets/css/campaign.css')) !!}
@endsection
@section('content')

    <h3 style="margin: 10px 40px;" class="heading_b uk-margin-bottom">Pricing Tables</h3>
   {{-- <div id="top_bar">
        <div class="md-top-bar">
            <div class="uk-width-large-8-10 uk-container-center">
                <div class="uk-clearfix">
                    <div class="md-top-bar-actions-left">
                        <div class="md-top-bar-checkbox">
                            <input type="checkbox" name="mailbox_select_all" id="mailbox_select_all" data-md-icheck />
                        </div>
                    </div>
                    <div class="md-top-bar-actions-right">
                        <div class="md-top-bar-icons">
                            <i id="mailbox_list_split" class=" md-icon material-icons">&#xE8EE;</i>
                            <i id="mailbox_list_combined" class="md-icon material-icons">&#xE8F2;</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    {!! dd($admins) !!}
    <div id="page_content">
        <div id="page_content_inner">

            <div class="md-card-list-wrapper" id="mailbox">
                <div class="uk-width-large-8-10 uk-container-center">
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Today</div>
                        <div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>
                        <ul class="hierarchical_slide">
                            <li>
                                <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                    <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                            <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="md-card-list-item-date">13 Nov</span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <span class="md-card-list-item-avatar md-bg-grey">hp</span>
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span>sophia70@danielnicolas.info</span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>sophia70@danielnicolas.info</span>
                                    </div>
                                    <span>Dolorum omnis fugit facere voluptatem.</span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        Autem et in qui natus repudiandae molestiae doloribus necessitatibus aut ea repudiandae voluptas voluptas molestiae odit assumenda et rem corrupti quia sunt in ut qui ipsam maiores officiis sapiente iusto et dolor consequatur et eius fugit possimus dignissimos sapiente deserunt perferendis voluptatem molestiae architecto eum accusamus omnis.                                    </div>
                                    <form class="md-card-list-item-reply">
                                        <label for="mailbox_reply_1895">Reply to <span>sophia70@danielnicolas.info</span></label>
                                        <textarea class="md-input md-input-full" name="mailbox_reply_1895" id="mailbox_reply_1895" cols="30" rows="4"></textarea>
                                        <button class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                    <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                            <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="md-card-list-item-date">13 Nov</span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    {{--<img src="assets/img/avatars/avatar_10_tn.png" class="md-card-list-item-avatar" alt="" />--}}
                                    <span class="md-card-list-item-avatar md-bg-grey">hp</span>
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span>Vernice Wiza I</span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>Vernice Wiza I</span>
                                    </div>
                                    <span>Quidem et voluptatem doloremque rerum ea corporis.</span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        Magnam et rerum itaque aut accusantium non velit voluptas aut veniam cupiditate fugiat fuga necessitatibus facilis et accusamus nihil sit cumque consequuntur consequuntur aspernatur dolorum minus et dolorem voluptatem molestiae est possimus illum commodi voluptatem possimus qui nobis nemo veniam voluptatem id aut quod eos reprehenderit voluptatum nostrum quo suscipit aut veniam nobis repellendus facilis temporibus et qui eius non quod repellendus beatae autem est modi voluptas molestiae et architecto laboriosam excepturi ut libero aperiam facilis delectus eius odit quidem maxime earum accusamus magnam ut sunt est saepe aspernatur corrupti eaque vel quo omnis fuga quia illo qui doloribus perspiciatis aut sit veritatis id dolorem accusamus corporis quo consectetur eos dolore voluptatem accusamus ex voluptas maxime ipsam accusantium.                                    </div>
                                    <form class="md-card-list-item-reply">
                                        <label for="mailbox_reply_1872">Reply to <span>Vernice Wiza I</span></label>
                                        <textarea class="md-input md-input-full" name="mailbox_reply_1872" id="mailbox_reply_1872" cols="30" rows="4"></textarea>
                                        <button class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                    <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                            <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="md-card-list-item-date">28 Jul</span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <span class="md-card-list-item-avatar md-bg-cyan">jr</span>
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span>heathcote.brooke@kuhic.net</span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>heathcote.brooke@kuhic.net</span>
                                    </div>
                                    <span>Ipsum aut enim facilis.</span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        Magnam et rerum itaque aut accusantium non velit voluptas aut veniam cupiditate fugiat fuga necessitatibus facilis et accusamus nihil sit cumque consequuntur consequuntur aspernatur dolorum minus et dolorem voluptatem molestiae est possimus illum commodi voluptatem possimus qui nobis nemo veniam voluptatem id aut quod eos reprehenderit voluptatum nostrum quo suscipit aut veniam nobis repellendus facilis temporibus et qui eius non quod repellendus beatae autem est modi voluptas molestiae et architecto laboriosam excepturi ut libero aperiam facilis delectus eius odit quidem maxime earum accusamus magnam ut sunt est saepe aspernatur corrupti eaque vel quo omnis fuga quia illo qui doloribus perspiciatis aut sit veritatis id dolorem accusamus corporis quo consectetur eos dolore voluptatem accusamus ex voluptas maxime ipsam accusantium.                                    </div>
                                    <form class="md-card-list-item-reply">
                                        <label for="mailbox_reply_598">Reply to <span>heathcote.brooke@kuhic.net</span></label>
                                        <textarea class="md-input md-input-full" name="mailbox_reply_598" id="mailbox_reply_598" cols="30" rows="4"></textarea>
                                        <button class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Yesterday</div>
                        <ul class="hierarchical_slide">
                            <li>
                                <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                    <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                            <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="md-card-list-item-date">12 Nov</span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    {{--<img src="assets/img/avatars/avatar_01_tn.png" class="md-card-list-item-avatar" alt="" />--}}
                                    <span class="md-card-list-item-avatar md-bg-grey">hp</span>
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span>luettgen.rahul@gmail.com</span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>luettgen.rahul@gmail.com</span>
                                    </div>
                                    <span>Sed autem atque omnis distinctio.</span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        Earum maxime ratione itaque et consequatur sed laborum sed mollitia architecto laudantium ipsa porro molestiae accusamus numquam corrupti voluptatum quia eum blanditiis et molestiae illum explicabo suscipit autem non porro voluptatem molestiae atque est molestias hic officiis quisquam velit quis sint et consequuntur et consequuntur sit dolores non necessitatibus ea ex quos id et vitae omnis deleniti omnis et sunt ratione dolores quos voluptatem ut dolor voluptas omnis exercitationem voluptas voluptatem voluptas iste ea libero odit rerum et ex nihil qui qui ut sunt reprehenderit fuga recusandae error quod consequatur ab accusantium officia consequuntur sunt dolorem explicabo animi nihil dolor itaque in sint vel aperiam ut consequatur molestias doloremque eius tempore voluptas esse voluptatibus et asperiores consequuntur et dolores ut iusto id fugiat laboriosam voluptatum veritatis rerum sunt at qui dignissimos ab dignissimos magni error recusandae sunt eius vero rerum quo officiis id et non molestiae aspernatur illum ullam ad ea animi impedit ea doloribus est ut dolorem eos quis autem tenetur sapiente neque et tenetur sapiente quam sed rem at ex voluptatem adipisci consequuntur et maxime dolores quibusdam laboriosam consequatur molestiae voluptas excepturi ut dicta rerum quas sint esse accusamus quod ut laborum aperiam autem totam repellat qui perspiciatis consequuntur similique saepe sed aut numquam beatae reprehenderit eveniet tempora consequuntur saepe quia voluptatum ullam et expedita aut aut quo mollitia possimus deserunt dolorum voluptate modi veniam voluptatum suscipit enim vitae sunt voluptatem nihil nihil aut dolores alias distinctio modi molestias consequatur hic enim qui qui ipsa libero reiciendis tempora qui ut aut ut quis eveniet vel voluptatibus perferendis iure dolorum nobis quo voluptate molestiae iusto iure voluptas et repellat deserunt reprehenderit distinctio aliquam reprehenderit sunt quos rem molestiae nemo mollitia sed voluptates nostrum laboriosam magnam minima eos voluptatibus accusamus porro sunt consequatur nihil aliquid sunt ex quidem quis eligendi autem similique sed nihil sapiente praesentium voluptas nulla non et magnam nemo aut qui magnam id dolorem sapiente voluptatibus excepturi qui quidem assumenda aut est soluta quae tempora est voluptatem magnam et omnis et enim necessitatibus quod iusto exercitationem ea porro voluptatem laudantium sunt rerum animi quasi illum consequatur ducimus et ut pariatur nulla ut qui optio doloribus magni porro molestiae distinctio modi cumque cupiditate id et qui autem assumenda maiores enim reprehenderit voluptates fuga saepe aut nihil.                                    </div>
                                    <form class="md-card-list-item-reply">
                                        <label for="mailbox_reply_7254">Reply to <span>luettgen.rahul@gmail.com</span></label>
                                        <textarea class="md-input md-input-full" name="mailbox_reply_7254" id="mailbox_reply_7254" cols="30" rows="4"></textarea>
                                        <button class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                    <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                            <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                            <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="md-card-list-item-date">12 Nov</span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <span class="md-card-list-item-avatar md-bg-grey">hp</span>
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span>Ana Paucek</span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>Ana Paucek</span>
                                    </div>
                                    <span>Sapiente sunt quidem dolores consequatur qui fugiat magnam mollitia.</span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        Totam dolores aut sit deleniti nihil distinctio doloribus ratione a voluptas itaque mollitia sit suscipit voluptatem aliquid libero aut enim numquam suscipit doloribus perferendis consectetur adipisci quibusdam quisquam necessitatibus aperiam corrupti voluptatem animi placeat amet esse sed recusandae distinctio dolores voluptatem eius enim at sunt voluptate tenetur et sit iusto rerum molestiae cum dolores architecto quis enim dolorem nam ut sint repellendus et voluptatem labore magnam quia consectetur quo quia consequatur veniam enim ipsa quaerat culpa voluptatem est natus molestiae nihil autem quia incidunt sunt modi velit deserunt cupiditate consequatur nihil aut saepe perferendis adipisci ut doloremque quisquam suscipit et inventore et corporis quae consectetur labore consectetur ab impedit harum iure nesciunt a maxime aut repellat fuga saepe tempore sit reprehenderit ullam fugit neque sapiente nemo ea voluptate dolorem eos voluptatem eos harum reiciendis quidem dolores dolorem facilis ut vel laboriosam vel qui quod est modi eligendi earum voluptatem amet aut voluptas sint deserunt a et porro est beatae pariatur consequatur doloremque ut tenetur ut pariatur fuga eos nulla dicta aut eum minima illo aperiam nihil enim quis sequi doloribus quis quis nesciunt non soluta hic saepe quia vel soluta alias qui ullam dolores consectetur qui ipsum incidunt eum nostrum ut eligendi quia ut fuga ut rerum pariatur voluptatem rerum sunt excepturi illum dolor vel aut a sed hic expedita ipsa rerum exercitationem impedit quia dolores autem quam deserunt soluta sint sequi qui impedit quo delectus repudiandae minus maxime et est incidunt deleniti libero laudantium fugiat et ut porro aut animi aspernatur voluptatum quo repudiandae incidunt vel non voluptatem eos et quis quam ut possimus dolorem id porro sunt quas voluptatibus recusandae explicabo aspernatur repellat rerum repellat blanditiis hic.                                    </div>
                                    <form class="md-card-list-item-reply">
                                        <label for="mailbox_reply_2947">Reply to <span>Ana Paucek</span></label>
                                        <textarea class="md-input md-input-full" name="mailbox_reply_2947" id="mailbox_reply_2947" cols="30" rows="4"></textarea>
                                        <button class="md-btn md-btn-flat md-btn-flat-primary">Send</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    {{--aqui termina cada categoria--}}
                </div>
            </div>

        </div>
    </div>

    {{--modal para editar un correo--}}
    {{--<div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE150;</i>
        </a>
    </div>--}}

    {{--<div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>
            <form>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="mail_new_to">To</label>
                    <input type="text" class="md-input" id="mail_new_to"/>
                </div>
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Message</label>
                    <textarea name="mail_new_message" id="mail_new_message" cols="30" rows="6" class="md-input"></textarea>
                </div>
                <div id="mail_upload-drop" class="uk-file-upload">
                    <p class="uk-text">Drop file to upload</p>
                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" type="file"></a>
                </div>
                <div id="mail_progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
                <div class="uk-modal-footer">
                    <a href="#" class="md-icon-btn"><i class="md-icon material-icons">&#xE226;</i></a>
                    <button type="button" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                </div>
            </form>
        </div>
    </div>--}}
@stop

@section('scripts')

@stop