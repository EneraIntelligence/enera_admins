@extends('layout.main')
@section('title', ' -  Issue Tracker Show')
@section('head_scripts')
    <style>
        .issue-data-expand {
            cursor: pointer;
        }
    </style>
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
                {{ $issue->exception['msg'] }}
            </span>
        </div>

        <div id="page_content_inner">

            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-margin-bottom" data-uk-margin>
                        <a href="#" class="md-btn">
                            <i class="material-icons">&#xE254;</i> Editar
                        </a>
                        <div class="md-btn-group">
                            <a href="#" class="md-btn" style="background-color: #2196f3; color: white;">Asignar</a>
                            <a href="#" class="md-btn md-btn-success">Iniciar</a>
                            <a href="{!! route('issuetracker::close', ['id' => $issue->_id]) !!}"
                               class="md-btn md-btn-danger">
                                Cerrar
                            </a>
                        </div>
                    </div>
                    <hr/>
                    <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                        <div class="uk-width-medium-3-4">
                            <div class="uk-margin-large-bottom">
                                <h2 class="heading_c uk-margin-small-bottom">Contexto (
                                    L: {{ $issue->file['line'] }})</h2>
                                <pre data-start="{!! $issue->file['line'] > 9 ? $issue->file['line'] - 9 : 1 !!}"
                                     class="line-numbers" style="max-height: 380px; !important;">
                                    <code class="language-php"
                                          style="margin-top: -18px;">{!! $issue->file['context'] !!}</code>
                                </pre>
                            </div>
                            <div class="uk-margin-large-bottom">
                                <h2 class="heading_c uk-margin-small-bottom">URL</h2>
                                <pre><a href="#">{{ $issue->request['url'] }}</a></pre>
                            </div>
                            <div class="uk-margin-large-bottom">
                                <h2 class="heading_c uk-margin-small-bottom issue-data-expand" data-pre="session_vars">
                                    Variables de Sesión <i class="material-icons">expand_less</i>
                                </h2>
                                <pre id="session_vars" class="line-numbers">
                                    <code class="language-php"
                                          style="margin-top: -18px;">{!! print_r($issue->request['session_vars']) !!}</code>
                                </pre>
                            </div>
                            <div class="uk-margin-large-bottom">
                                <h2 class="heading_c uk-margin-small-bottom issue-data-expand" data-pre="tracer">
                                    Exception Trace <i class="material-icons">expand_more</i>
                                </h2>
                                <pre id="tracer" style="display: none;"><code
                                            style="margin-top: -20px;">{!! $issue->exception['trace'] !!}</code>
                                </pre>
                            </div>
                            <div class="uk-margin-large-bottom">
                                <h2 class="heading_c uk-margin-small-bottom">Comentarios</h2>
                                <ul class="uk-comment-list">
                                    {{--<li>
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
                                    </li>--}}

                                </ul>
                            </div>
                            <textarea cols="30" rows="4" class="md-input" placeholder="Add Comment..."></textarea>
                            <a href="#" class="md-btn uk-margin-top">Add Comment</a>
                        </div>
                        <div class="uk-width-medium-1-4">
                            <div class="uk-margin-medium-bottom">
                                <p>
                                    Prioridad:
                                    <span class="uk-badge uk-badge-warning uk-text-upper uk-margin-small-left">
                                        {{ $issue->priority }}
                                    </span>
                                </p>
                                <p>
                                    Estado:
                                    <span class="uk-badge uk-badge-outline uk-text-upper uk-margin-small-left">
                                        {{ $issue->status }}
                                    </span>
                                </p>
                                <p>
                                    Server:
                                    <span class="uk-badge uk-badge-outline uk-text-upper uk-margin-small-left">
                                        {{ $issue->request['host'] }}
                                    </span>
                                </p>
                                <p>
                                    Plataforma:
                                    <span class="uk-badge uk-badge-outline uk-text-upper uk-margin-small-left">
                                        {{ $issue->request['platform'] }}
                                    </span>
                                </p>
                                <p>
                                    Ambiente:
                                    <span class="uk-badge uk-badge-outline uk-text-upper uk-margin-small-left">
                                        {{ $issue->request['environment'] }}
                                    </span>
                                </p>
                            </div>
                            <h2 class="heading_c uk-margin-small-bottom">Detalles</h2>
                            <ul class="md-list md-list-addon">
                                <li>
                                    <div class="md-list-addon-element">
                                        <img class="md-user-image md-list-addon-avatar"
                                             src="{!! $issue->responsible_id > 0 ? '' : '' !!}" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">
                                            {{ $issue->responsible_id > 0 ? $issue->responsible->name : '---' }}
                                        </span>
                                        <span class="uk-text-small uk-text-muted">Responsable</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <i class="md-list-addon-icon material-icons">&#xE8DF;</i>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">
                                            {{ $issue->created_at->format('j M y H:i:s') }}
                                        </span>
                                        <span class="uk-text-small uk-text-muted">Creación</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <i class="md-list-addon-icon material-icons">&#xE8B5;</i>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">
                                            {{ $issue->updated_at->format('j M y H:i:s') }}
                                        </span>
                                        <span class="uk-text-small uk-text-muted">Actualización</span>
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
    <script>
        $(document).ready(function () {
            $(".issue-data-expand").click(function () {
                var $this = $(this);
                $("#" + $this.attr('data-pre')).slideToggle("slow", function () {
                    $this.find('.material-icons').html($this.find('.material-icons').html() == 'expand_more' ? 'expand_less' : 'expand_more');
                });
            });
        });
    </script>
@stop