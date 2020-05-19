<?php

namespace App\Http\Controllers\Auth;

use App\File;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private $file;
    private $project;

    public function __construct(File $file, Project $project)
    {
        $this->file = $file;
        $this->project = $project;
    }

    public function index()
    {
        return view('auth.document.index')->with(['files' => $this->file->get(), 'projects' => $this->project->get(['id', 'name'])]);
    }

    public function create(Project $project)
    {
        session(['previous' => url()->previous()]);

        return view('auth.project.document.create')->with('project', $project);
    }

    public function store(Project $project, Request $request)
    {
        $request = $request->all();

        $request['content'] = str_replace('src="/image', 'src="'.public_path().'/image', $request['content']);

        $pdf = App::make('dompdf.wrapper');

        if(!\Illuminate\Support\Facades\File::exists(public_path() . '/pdf')) {
            File::create(public_path() . '/pdf');
        }

        $name = public_path() . '/pdf' . str_replace(' ', '_', "/$request[title].pdf");

        $pdf->loadHTML($request['content'])->setPaper('a4', 'landscape')->save($name);

        $project->addFile($name);

        session()->flash('message', 'Document saved.');

        return redirect(session('previous'));
    }

    public function stream($p, $file_id)
    {
        $file = $this->file->find($file_id);

        return response()->file($file->path);
    }

    public function destroy($project, $document)
    {
        $document = $this->file->find($document);

        $document->delete();

        session()->flash('message', 'Document deleted.');

        return redirect()->back();
    }
}
