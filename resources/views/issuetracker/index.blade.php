@extends('layout.main')
@section('title', ' -  Issue Tracker')
@section('head_scripts')

@stop
@section('content')
    <div id="page_content">
        <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="heading_actions">
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Asignar" id="asignar">
                    <i class="md-icon material-icons uk-text-primary">&#xE853;</i>
                </a>
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Iniciar" id="iniciar">
                    <i class="md-icon material-icons uk-text-success">&#xE86C;</i>
                </a>
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Cerrar" id="cerrar">
                    <i class="md-icon material-icons uk-text-danger">&#xE5C9;</i>
                </a>
                <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Eliminar" id="eliminar">
                    <i class="md-icon material-icons">&#xE872;</i>
                </a>
                {{--<div data-uk-dropdown>
                    <i class="md-icon material-icons">&#xE5D4;</i>
                    <div class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Other Action</a></li>
                            <li><a href="#">Other Action</a></li>
                        </ul>
                    </div>
                </div>--}}
            </div>
            <h1>Issue Tracker</h1>
            <span class="uk-text-upper uk-text-small">
                Rastreo automatico de errores
            </span>
        </div>
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair"
                               id="ts_issues">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Issue</th>
                                <th>Eventos</th>
                                <th>Prioridad</th>
                                <th>Fecha</th>
                                <th>Plataforma</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($issues as $issue)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="issue" data-md-icheck name="issue[]"
                                               value="{!! $issue->_id !!}"/>
                                    </td>
                                    <td>
                                        <a href="{!! route('issuetracker::show', ['id' => $issue->_id]) !!}">
                                            {{ $issue->issue['title'] }}
                                        </a><br>
                                        {{ strlen($issue->exception['msg']) > 80?substr($issue->exception['msg'],0,80).'...':$issue->exception['msg'] }}
                                    </td>
                                    <td>
                                        ---
                                    </td>
                                    <td>
                                        <span class="uk-badge uk-badge-warning">
                                            {{ $issue->priority }}
                                        </span>
                                    </td>
                                    <td class="uk-text-small">
                                        {{ $issue->created_at->format('j/M/y H:i:s') }}
                                    </td>
                                    <td class="uk-text-small">
                                        {{ $issue->issue['platform'] }}
                                    </td>
                                    <td>
                                        <span class="uk-badge uk-badge-outline uk-text-upper">{{ $issue->status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            {{--<tr>
                                </td>
                                <td>
                                    <a href="page_issue_details.html"> Magnam recusandae placeat perferendis voluptates
                                        blanditiis quas modi.</a>
                                </td>
                                <td>Garry Stehr</td>
                                <td><span class="uk-badge uk-badge-info">minor</span></td>
                                <td class="uk-text-small">28/Jun/16 12:12:12</td>
                                <td class="uk-text-small">Network</td>
                                <td><span class="uk-badge uk-badge-outline uk-text-upper">open</span></td>
                            </tr>--}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#cerrar').click(function () {

                var modal = UIkit.modal.blockUI('<div class="uk-text-center">Cerrando Issues...<br/>' +
                        '<img class="uk-margin-top" src="/assets/img/spinners/spinner.gif" alt=""></div>');

                var issues = [];
                $('.issue:checked').each(function () {
                    var $this = $(this);
                    issues.push($this.val());
                });
                $.ajax({
                    method: "POST",
                    url: "{!! route('issuetracker::close_list') !!}",
                    data: {issues: issues}
                }).done(function (resp) {
                    if (resp.ok) {
                        location.reload();
                    } else {
                        modal.hide();
                        UIkit.modal.alert('<p>Enera Admins</p><pre>' + resp.msg + '</pre>');
                    }
                }).fail(function (resp) {
                    //
                });
            });
        });
    </script>
@stop