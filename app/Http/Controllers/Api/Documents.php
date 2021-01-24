<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Documents extends Controller
{

    private $document;

    /**
     * Documents constructor.
     * @param $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->middleware('auth:api');
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->document->get();

        return response()->json($data,200);
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->json();
        $dataArr = collect($data)->toArray();
        $doc = $this->document->create($dataArr);
        $created = $doc ? true : false;
        return response()->json(['created'=>$created],201);
    }


    public function copyDocument(Request $request)
    {

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = collect($request->json())->toArray();
        $updatedDoc = $this->document->find($id)->update($data);
        return response()->json(['updated'=>$updatedDoc],200);
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
