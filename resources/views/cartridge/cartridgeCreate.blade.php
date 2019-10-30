@extends('Main')
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.theme.min.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/scriptCartridgeCreat.js')}}"></script>
@stop
@section('content')
    <?php $status = Session::get('status'); ?>
    @if ( isset($status))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>{{$status}}</h4>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <h4>Предупреждение!</h4>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        </div>
    @endif
    <?php $Errors = Session::get('Errors'); ?>
    @if ( isset($Errors))
        <div class="alert alert-success alert-danger">
            <h4>Предупреждение!</h4>
            <p>{{ $Errors }}</p>
        </div>
    @endif
    {!! Form::open(['route'=>'cartridge.store', 'class'=>'form-horizontal', 'name'=>'cartridgeCreat']) !!}
        <div class="form-group">
            {!! Form::label('date_begin', 'Дата начала работ', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::input('date', 'date_begin', date('Y-m-d'), ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Имя заказчика', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('name', Input::old('name'), ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('phone', 'Телефон заказчика', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('phone', null, ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('repfirm_id', 'Фирма картриджа', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                <select id="cartridgfirm" class="form-control" name="repfirm_id">
                    <option value="0" selected>Виберите фирму картриджа</option>
                    @foreach($firm as $texnik)
                        <option value="{{$texnik->id}}">{{$texnik->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('ACModel', 'Модель картриджа:', ['class'=>'col-sm-3 control-label']) !!}
            <div id="firms" class="col-sm-9">
                {!! Form::hidden('printmodels_id', '0', ['id'=>'printmodels_id']) !!}
                {!! Form::input('text', 'ACModel', '', ['class'=>'form-control', 'id'=>'ACModel', 'disabled'=>'disabled']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('datacartridge', 'Работы', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9" id="DivDatacartridge">

            </div>
        </div>
        <div class="form-group hidden-print">
            {!! Form::label('staff_id', 'Исполнитель', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('staff_id', $holidayStaff, '1', ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group hidden-print">
            <div class="col-sm-offset-3 col-sm-9">
                {!! Form::submit('Сохранить', ['class'=>'btn btn-success', 'id'=>'BtnCartridgeCreat']) !!}
                {!! link_to_route('cartridge', 'Отмена', null, ['class'=>'btn btn-danger'])!!}
            </div>
        </div>
    {!! Form::Close() !!}
@stop
