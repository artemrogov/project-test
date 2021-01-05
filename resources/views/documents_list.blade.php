@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Документы <small>({{ $documents->count() }})</small>
        </div>
        <div class="card-body">
            <form action="{{ route('page.documents') }}" method="get">

                <div class="form-group">
                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        placeholder="Search..."
                        value="{{request('q')}}"
                    />
                </div>
            </form>
            @forelse ($documents as $document)
            <article class="mb-3">
                <h2><a href="#">{{ $document->title }}</a></h2>
                @isset($document->start_publish)
                    <p>Дата и время публикации:<strong>{{$document->start_publish}}</strong></p>
                @else
                    <i>нет даты публикации</i>
                @endisset
                <p>Дата и окончания публикации:<strong>{{$document->end_publish}}</strong></p>
            </hr>
                <p class="m-0">{{ \Illuminate\Support\Str::limit($document->content,50,'<..>') }}</p>
            </article>
            @empty
                 <p>Нет документов</p>
            @endforelse
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
@stop
