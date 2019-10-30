@extends('Main')

@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/Datepicker/jquery-ui.theme.min.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/scriptRepairCreat.js')}}"></script>
    <script src="{{asset('js/Datepicker/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/Datepicker/datepicker.regional.js')}}"></script>
    <script>
    $(function() {
        var dates = $( "#date_begin, #date_end" ).datepicker({
        onSelect: function( selectedDate ) {
        var option = this.id == "date_begin" ? "minDate" : "maxDate",
        instance = $( this ).data( "datepicker" ),
        date = $.datepicker.parseDate(
        instance.settings.dateFormat ||
        $.datepicker._defaults.dateFormat,
        selectedDate, instance.settings );
        dates.not( this ).datepicker( "option", option, date );
        }
        });
    });
    </script>
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['route'=>'repair.order', 'class'=>'form-inline', 'method' => 'get']) !!}
            <div class="form-group">
                <h4>Сортировать по:  </h4>
            </div>
            <div class="form-group">
                {!! Form::label('date_begin', 'Дате:') !!}
                {!! Form::text('date_begin', $oldOrderfields['date_begin'], ['class'=>'form-control', 'placeholder' => 'С']) !!}
                {!! Form::label('date_end', 'Дате:', ['class'=>'sr-only']) !!}
                {!! Form::text('date_end', $oldOrderfields['date_end'], ['class'=>'form-control', 'placeholder' => 'По']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('equipment_id', 'Технике:') !!}
                {!! Form::select('equipment_id', $equipment, $oldOrderfields['equipment_id'], ['class'=>'form-control', 'id' => 'equipment']) !!}
                {!! Form::input('text', 'ACFirm', $oldOrderfields['ACFirm'], ['class'=>'form-control', 'id'=>'ACFirm', 'disabled'=>'disabled']) !!}
                {!! Form::hidden('repfirm_id', $oldOrderfields['repfirm_id'], ['id'=>'repfirm_id']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Статусу:') !!}
                {!! Form::select('status', array(
                '0' => 'Все',
                '1' => 'Принят',
                '2' => 'В процессе ремонта',
                '3' => 'Ожидает запчастей',
                '4' => 'Завершен',
                '5' => 'Отдан'
                ), $oldOrderfields['status'], ['class'=>'form-control', 'id' => 'status']) !!}
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
                <td>Фирма</td>
                <td>Модель</td>
                <td>Статус</td>
                <td colspan="4" class="Actions">Действия</td>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <th>{!!$message->id!!}</th>
                    <th>{!!$message->date_begin!!}</th>
                    <th>{!!$message->customer!!}</th>
                    <th>{!!$message->repfirm->name!!}</th>
                    <th>{!!$message->repmodel!!}</th>
                    @if ($message->status == 1)
                        <th>Принят</th>
                    @elseif($message->status == 2)
                        <th class="danger">В процессе ремонта</th>
                    @elseif($message->status == 3)
                        <th class="info">Ожидает запчастей</th>
                    @elseif($message->status == 4)
                        <th class="success">Завершен</th>
                    @elseif($message->status == 5)
                        <th class="warning">Отдан</th>
                    @endif
                    <th><a class="btn btn-primary btn-xs" href="repair/{!!$message->id!!}/show"><span class="glyphicon glyphicon-fullscreen"></span> Просм</a></th>
                    <th><a class="btn btn-primary btn-xs" href="repair/{!!$message->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a></th>
                    <th><a class="btn btn-primary btn-xs" href="repair/{!!$message->id!!}/edit"><span class="glyphicon glyphicon-pencil"></span>  Ред</a></th>
                    <th><a class="btn btn-primary btn-xs" href="repair/{!!$message->id!!}/del"><span class="glyphicon glyphicon-trash"></span> Удл</a></th>
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