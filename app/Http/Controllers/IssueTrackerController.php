<?php

namespace Admins\Http\Controllers;

use Admins\Issue;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;

class IssueTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('issuetracker.index', [
            'issues' => Issue::where('status', '<>', 'closed')->orderBy('created_at', 'ASC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issue = Issue::find($id);
        if ($issue) {
            return view('issuetracker.show', [
                'issue' => $issue
            ]);
        } else {
            return redirect()->route('issuetracker::index')->with([
                'n_type' => 'danger',
                'n_timeout' => 5000,
                'n_msg' => '"Issue" no encontrado.'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
