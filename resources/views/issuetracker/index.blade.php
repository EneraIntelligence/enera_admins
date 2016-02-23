@extends('layout.main')
@section('title', ' -  Issue Tracker')
@section('head_scripts')

@stop
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
                                <th>Issue</th>
                                <th>Responsable</th>
                                <th>Prioridad</th>
                                <th>Fecha</th>
                                <th>Plataforma</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($issues as $issue)
                                <tr>
                                    </td>
                                    <td>
                                        <a href="{!! route('issuetracker::show', ['id' => $issue->_id]) !!}">
                                            {{ $issue->msg }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $issue->responsible_id > 0 ? $issue->responsible->name : '---' }}
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
                                        {{ $issue->request['platform'] }}
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

@stop