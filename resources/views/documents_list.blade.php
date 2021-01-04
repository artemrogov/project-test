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
                <h2>{{ $document->title }}</h2>
                <p class="m-0">{{ $document->content }}</p>
            </article>
            @empty
                 <p>Нет документов</p>
            @endforelse
        </div>
    </div>
</div>
@stop
