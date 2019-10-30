@extends('Main')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <h4>Предупреждение!</h4>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if (isset($update))
                @include('pages._formUpdate')
            @else
                @include('pages._formCreat')
            @endif
        </div>
    </div>
@stop