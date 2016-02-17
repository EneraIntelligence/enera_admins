@extends('layout.main')
@section('title', ' -  Issue Tracker')
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
            <h1>Issue Tracker</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Project Name</a></span>
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
                            <tfoot>
                            <tr>
                                <th>Issue</th>
                                <th>Responsable</th>
                                <th>Prioridad</th>
                                <th>Fecha</th>
                                <th>Plataforma</th>
                                <th>Estado</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <tr>
                                </td>
                                <td>
                                    <a href="page_issue_details.html"> Inventore ipsa vitae rerum delectus sit.</a>
                                </td>
                                <td>Shanie Wuckert</td>
                                <td><span class="uk-badge uk-badge-warning">critical</span></td>
                                <td class="uk-text-small">14/Jun/16 12:12:12</td>
                                <td class="uk-text-small">Network</td>
                                <td><span class="uk-badge uk-badge-outline uk-text-upper">closed</span></td>
                            </tr>
                            <tr>
                                </td>
                                <td>
                                    <a href="page_issue_details.html"> Vel sit molestiae dolorum minima aut.</a>
                                </td>
                                <td>Bernie Raynor</td>
                                <td><span class="uk-badge uk-badge-info">minor</span></td>
                                <td class="uk-text-small">24/Jun/16 12:12:12</td>
                                <td class="uk-text-small">Network</td>
                                <td><span class="uk-badge uk-badge-outline uk-text-upper">closed</span></td>
                            </tr>
                            <tr>
                                </td>
                                <td>
                                    <a href="page_issue_details.html"> Quia et similique soluta est libero eveniet eos
                                        aspernatur.</a>
                                </td>
                                <td>Blake Corwin</td>
                                <td><span class="uk-badge uk-badge-warning">critical</span></td>
                                <td class="uk-text-small">26/Jun/16 12:12:12</td>
                                <td class="uk-text-small">Network</td>
                                <td><span class="uk-badge uk-badge-outline uk-text-upper">closed</span></td>
                            </tr>
                            <tr>
                                </td>
                                <td>
                                    <a href="page_issue_details.html"> At nihil quos natus unde nulla qui.</a>
                                </td>
                                <td>Liam Eichmann</td>
                                <td><span class="uk-badge uk-badge-warning">critical</span></td>
                                <td class="uk-text-small">15/Jun/16 12:12:12</td>
                                <td class="uk-text-small">Network</td>
                                <td><span class="uk-badge uk-badge-outline uk-text-upper">open</span></td>
                            </tr>
                            <tr>
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
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    {{--<ul class="uk-pagination ts_pager">--}}
                        {{--<li data-uk-tooltip title="Select Page">--}}
                            {{--<select class="ts_gotoPage ts_selectize"></select>--}}
                        {{--</li>--}}
                        {{--<li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a>--}}
                        {{--</li>--}}
                        {{--<li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>--}}
                        {{--<li><span class="pagedisplay"></span></li>--}}
                        {{--<li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>--}}
                        {{--<li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a>--}}
                        {{--</li>--}}
                        {{--<li data-uk-tooltip title="Page Size">--}}
                            {{--<select class="pagesize ts_selectize">--}}
                                {{--<option value="5">5</option>--}}
                                {{--<option value="10">10</option>--}}
                                {{--<option value="25">25</option>--}}
                                {{--<option value="50">50</option>--}}
                            {{--</select>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                </div>
            </div>
        </div>

    </div>

@stop

@section('scripts')

@stop