@extends('layout.main')
@section('title', ' -  Issue Tracker Show')
@section('head_scripts')

@endsection
@section('content')
    <div id="page_content">

        <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="heading_actions">
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Archive"><i class="md-icon material-icons">
                        &#xE149;</i></a>
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Print"><i class="md-icon material-icons">
                        &#xE8AD;</i></a>
                <div data-uk-dropdown>
                    <i class="md-icon material-icons">&#xE5D4;</i>
                    <div class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Other Action</a></li>
                            <li><a href="#">Other Action</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <h1>{{ $issue->msg }}</h1>
            <span class="uk-text-upper uk-text-small">
                {{ $issuel->file['path'] }} ({{ $issue->file['line'] }})
            </span>
        </div>

        <div id="page_content_inner">

            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-margin-bottom" data-uk-margin>
                        <a href="#" class="md-btn"><i class="material-icons">&#xE254;</i> Editar</a>
                        <div class="md-btn-group">
                            <a class="md-btn" href="#">Asignar</a>
                            <a href="#" class="md-btn">Iniciar</a>
                            <a href="#" class="md-btn">Cerrar</a>
                        </div>
                    </div>
                    <hr/>
                    <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                        <div class="uk-width-medium-3-4">
                            <div class="uk-margin-large-bottom">
                                {{--<h2 class="heading_c uk-margin-small-bottom">Descripción</h2>--}}
                                {{ $issue->url }}
                                <pre class="line-numbers">
                                    <code class="language-php">
                                        {{ $issue->file['context'] }}
                                    </code>
                                </pre>
                            </div>
                            <div class="uk-margin-large-bottom">
                                <h2 class="heading_c uk-margin-small-bottom">Comentarios</h2>
                                <ul class="uk-comment-list">
                                    <li>
                                        <article class="uk-comment">
                                            <header class="uk-comment-header">
                                                <img class="md-user-image uk-comment-avatar"
                                                     src="assets/img/avatars/avatar_05_tn.png" alt="">
                                                <h4 class="uk-comment-title">Demarco Haley</h4>
                                                <div class="uk-comment-meta">24/Jun/15 14:26</div>
                                            </header>
                                            <div class="uk-comment-body">
                                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                                    nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
                                                    erat, sed diam voluptua.</p>
                                            </div>
                                        </article>
                                        <ul>
                                            <li>
                                                <article class="uk-comment">
                                                    <header class="uk-comment-header">
                                                        <img class="md-user-image uk-comment-avatar"
                                                             src="assets/img/avatars/avatar_02_tn.png" alt="">
                                                        <h4 class="uk-comment-title">Beverly Hirthe</h4>
                                                        <div class="uk-comment-meta">24/Jun/15 14:26</div>
                                                    </header>
                                                    <div class="uk-comment-body">
                                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                                            diam nonumy eirmod tempor invidunt ut labore et dolore magna
                                                            aliquyam erat, sed diam voluptua.</p>
                                                    </div>
                                                </article>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <article class="uk-comment">
                                            <header class="uk-comment-header">
                                                <img class="md-user-image uk-comment-avatar"
                                                     src="assets/img/avatars/avatar_08_tn.png" alt="">
                                                <h4 class="uk-comment-title">Ian Donnelly</h4>
                                                <div class="uk-comment-meta">24/Jun/15 14:26</div>
                                            </header>
                                            <div class="uk-comment-body">
                                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                                    nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
                                                    erat, sed diam voluptua.</p>
                                            </div>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="uk-comment">
                                            <header class="uk-comment-header">
                                                <img class="md-user-image uk-comment-avatar"
                                                     src="assets/img/avatars/avatar_07_tn.png" alt="">
                                                <h4 class="uk-comment-title">Fern Grady</h4>
                                                <div class="uk-comment-meta">24/Jun/15 14:26</div>
                                            </header>
                                            <div class="uk-comment-body">
                                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                                    nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
                                                    erat, sed diam voluptua.</p>
                                            </div>
                                        </article>
                                    </li>
                                </ul>
                            </div>
                            <textarea cols="30" rows="4" class="md-input" placeholder="Add Comment..."></textarea>
                            <a href="#" class="md-btn uk-margin-top">Add Comment</a>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <div class="uk-margin-medium-bottom">
                                <p>
                                    Priority:
                                    <span class="uk-badge uk-badge-success uk-text-upper uk-margin-small-left">Major</span>
                                </p>
                                <p>
                                    Status:
                                    <span class="uk-badge uk-badge-outline uk-text-upper uk-margin-small-left">Open</span>
                                </p>
                            </div>
                            <h2 class="heading_c uk-margin-small-bottom">Details</h2>
                            <ul class="md-list md-list-addon">
                                <li>
                                    <div class="md-list-addon-element">
                                        <img class="md-user-image md-list-addon-avatar"
                                             src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Berneice Feil</span>
                                        <span class="uk-text-small uk-text-muted">Assignee</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <i class="md-list-addon-icon material-icons">&#xE8DF;</i>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">14 Jun 2015</span>
                                        <span class="uk-text-small uk-text-muted">Created</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <i class="md-list-addon-icon material-icons">&#xE8B5;</i>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">18 Jun 2015</span>
                                        <span class="uk-text-small uk-text-muted">Updated</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@stop

@section('scripts')

@stop