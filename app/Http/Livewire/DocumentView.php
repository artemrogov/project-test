<?php

namespace App\Http\Livewire;

use App\Models\Document;
use Livewire\Component;

class DocumentView extends Component
{

    public $title;

    public $description;

    public $content;

    protected $rules = [
        'title'=>'required',
        'description' => 'required|min:6',
        'content'=>'required|min:10',
    ];


    public function createDocument()
    {
        $this->validate();
        $document = new Document();
        $document->title = $this->title;
        $document->description = $this->description;
        $document->content = $this->content;
        $document->save();

        session()->flash('message', 'Users Created Successfully.');

        $this->resetInputFields();

    }


    public function render()
    {
        return view('livewire.document-view');
    }

}
