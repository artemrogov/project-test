@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>Управление </strong>документами</div>
                    <div class="card-body">

                        <form class="form-horizontal" action="{{route('documents.update',$document->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if(Session::has('status'))
                                <div class="alert alert-success">{{Session::get('status')}}</div>
                            @endif

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                            @endif

                            @method('PATCH')

                            @include('documents.form')
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm btn-primary" type="submit">Сохранить</button>
                        <button class="btn btn-sm btn-danger" type="reset">Отмена</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        jQuery('#start_publish').datetimepicker({
            format:'Y-m-d H:i',
        });
        jQuery('#end_publish').datetimepicker({
            format:'Y-m-d H:i',
        });
    </script>
@endsection
