@extends('Main')

@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/Datepicker/jquery-ui.theme.min.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/scriptCartridgeCreat.js')}}"></script>
    <script src="{{asset('js/Datepicker/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/Datepicker/datepicker.regional.js')}}"></script>
    <script>
    $(function() {
        $("#date_begin").datepicker({
            altFormat: "yy-mm-dd",
            altField: "#date_begin",
            onSelect: function(dateText, inst) {
                $("#date_begin").val(dateText);
            }
        });
    });
    </script>
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['route'=>'cartridge.order', 'class'=>'form-inline', 'method' => 'get']) !!}
            <div class="form-group">
                <h4>Сортировать по:  </h4>
            </div>
            <div class="form-group">
                {!! Form::label('date_begin', 'Дате:') !!}
                {!! Form::text('date_begin', $oldOrderfields['date_begin'], ['class'=>'form-control', 'placeholder' => 'С']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('repfirm_id', 'Фирме:') !!}
                {!! Form::select('repfirm_id', $firm, $oldOrderfields['repfirm_id'], ['class'=>'form-control', 'id' => 'cartridgfirm']) !!}
                {!! Form::hidden('printmodels_id', $oldOrderfields['printmodels_id'], ['id'=>'printmodels_id']) !!}
                {!! Form::input('text', 'ACModel', $oldOrderfields['ACModel'], ['class'=>'form-control', 'id'=>'ACModel', 'disabled'=>'disabled']) !!}
            </div>
            <button id="ButtomOrder" type="submit" class="btn btn-primary">Показать</button>
            {!! Form::Close() !!}
        </div>
    </div>
<p>Коллицество заявок  <span class="badge">{{$count}}</span></p>
    <?php $status = Session::get('status'); ?>
@if ( isset($status))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>{{$status}}</h4>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        @if (! $messages->isEmpty() )
            <thead>
            <tr>
                <td>№</td>
                <td>Дата</td>
                <td>Имя</td>
                <td>Телефон</td>
                <td>Фирма</td>
                <td>Модель</td>
                <td colspan="4" class="Actions">Действия</td>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <th>{!!$message->id!!}</th>
                    <th>{!!$message->date_begin!!}</th>
                    <th>{!!$message->name!!}</th>
                    <th>{{$message->phone}}</th>
                    <th>{{$message->repfirm->name}}</th>
                    <th>{{$message->printmodels->name}}</th>

                    <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$message->id!!}/show"><span class="glyphicon glyphicon-fullscreen"></span> Просм</a></th>
                    <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$message->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a></th>
                    <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$message->id!!}/edit"><span class="glyphicon glyphicon-pencil"></span>  Ред</a></th>
                    <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$message->id!!}/del"><span class="glyphicon glyphicon-trash"></span> Удл</a></th>
                </tr>
            @endforeach
            @else
                <tr>
                    <td>Нет данных</td>
                </tr>
            @endif
            </tbody>
    </table>
    <div class="text-center">
        {!!$messages->render()!!}
    </div>
</div>
@stop