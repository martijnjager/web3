<?php

namespace App\Http\Controllers\Auth;
use App\Bug;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BugController extends Controller
{
    public function display($project_id)
    {
        $bugs=Bug::all();
        return view('auth.project.bug.index')->with('bugs', $bugs)->with('project_id', $project_id);
    }

    public function store(Request $request)
    {
        $bug =new Bug();

        $bug->description = $request->input('description');
        $bug->status = $request->input('status');
        $bug->project_id = $request->input('project');

        if($request->hasfile('image'))
        {
            $file =$request->file('image');
            $extention = $file->getClientOriginalExtention();
            $filename=time() . '.' . $extention;
            $file->move('uploads/bug/',$filename);
            $bug->image=$filename;
        }

        $bug->save();
        return redirect(route('auth.project.bug.index', $request->project));
//        return view('auth.project.bug.index')->with('bugs', Bug::all()->where('project_id', $request->project))->with('project_id', $request->project);
    }

    public function create($project_id)
    {
        return view('auth.project.bug.bugform')->with('project_id', $project_id);
    }

    public function edit($id)
    {
        $bugs=Bug::find($id);
        return view('auth.project.bug.bugupdateform')->with('bug', $bugs);
    }

    public function update(Request $request, $id)
    {
        $bug=Bug::find($id);

        $bug->description = $request->input('description');
        $bug->status = $request->input('status');

        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extention = $file ->getClientOriginalExtension();
            $filename=time() . '.' . $extention;
            $file->move('uploads/bug/', $filename);
            $bug->image=$filename;
        }
        $bug->save();
        return redirect(route('auth.project.bug.index', $bug->project->id));
    }

    public function delete($bug_id)
    {
        $bug = Bug::find($bug_id);

        $bug->delete();

        return redirect()->back();
    }
}
