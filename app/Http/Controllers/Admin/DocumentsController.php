<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{

    private $document;

    /**
     * DocumentsController constructor.
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $documents = $this->document->paginate(10);
        return view('documents.index',compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $data = $this->formDataInputs($request);

        $document = $this->document->create($data);

        return redirect()->route('documents.edit',$document->id)->with('status','Создан новый документ');
    }


    protected function formDataInputs($requestData):array
    {
        $data = array();

        if($requestData->has('title')){
            $data['title'] = $requestData->input('title');
        }

        if($requestData->has('description')){
            $data['description'] = $requestData->input('description');
        }

        if($requestData->has('content')){
            $data['content'] = $requestData->input('content');
        }

        return $data;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = $this->document->findOrFail($id);
        return view('documents.edit',compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, $id)
    {
        $document = $this->document->findOrFail($id);
        $data = $this->formDataInputs($request);
        $document->update($data);
        return redirect()->back()->with('status','Обновлен текущий документ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
