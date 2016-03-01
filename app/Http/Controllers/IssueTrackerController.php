<?php

namespace Admins\Http\Controllers;

use Admins\Issue;
use Illuminate\Http\Request;

use Admins\Http\Requests;
use Admins\Http\Controllers\Controller;
use MongoDate;

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
            'issues' => Issue::where('status', '<>', 'closed')->orderBy('created_at', 'ASC')->take(100)->get(),
        ]);
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
                'issue' => $issue,
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
     * Cierre de Issue
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close($id)
    {
        $issue = Issue::find($id);
        if ($issue && $issue->status != 'closed') {
            $issue->status = 'closed';
            $issue->closed = new MongoDate();
            $issue->responsible_id = $issue->responsible_id == 0 ? auth()->user()->_id : $issue->responsible_id;
            $issue->save();
            return redirect()->route('issuetracker::index')->with([
                'n_type' => 'success',
                'n_timeout' => 5000,
                'n_msg' => '"Issue" cerrado.'
            ]);
        } else {
            return redirect()->route('issuetracker::index')->with([
                'n_type' => 'danger',
                'n_timeout' => 5000,
                'n_msg' => '"Issue" no valido.'
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
}
