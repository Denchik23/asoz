@extends('Main')
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.theme.min.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/scriptRepairCreat.js')}}"></script>
@stop
@section('content')
    <div id="addFirm" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавление новой фирмы</h4>
                </div>
                <!-- Основной текст сообщения -->
                <form id="QFormForm" role="form">
                    <div class="modal-body">
                        <p>Вид техники: <span class="textModal"></span></p>
                        <div class="form-group">
                            {!! Form::hidden('QAddFirm_id', '', ['id'=>'QAddFirm_id']) !!}
                            <label for="email">Название фирмы</label>
                            {!! Form::input('text', 'QAddFirm', '', ['class'=>'form-control', 'id'=>'QAddFirm']) !!}
                        </div>
                        <p class="text-warning"><small>Проверьте соответствие вида техники.</small></p>
                    </div>
                    <!-- Нижняя часть модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    {!! Form::open(['route'=>'spare.updata', 'class'=>'form-horizontal']) !!}
    {!! Form::hidden('id', $repair->id) !!}
    <div class="form-group">
        {!! Form::label('date_begin', 'Дата начала работ', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::input('date', 'date_begin', $strdate, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Имя заказчика', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('name', $repair->name, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('phone', 'Телефон заказчика', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('phone', $repair->phone, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('equipment_id', 'Вид техники', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select id="equipment" class="form-control" name="equipment_id">
                <option value="{{$repair->equipment->id}}" selected>{{$repair->equipment->name}}</option>
                @foreach($equipment as $texnik)
                    <option value="{{$texnik->id}}">{{$texnik->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="form-feedback" class="col-sm-9 col-sm-offset-3"></div>
    <div class="form-group">
        {!! Form::label('ACFirm', 'Фирма производитель:', ['class'=>'col-sm-3 control-label']) !!}
        <div id="firms" class="col-sm-8">
            {!! Form::hidden('repfirm_id', $repair->repfirm->id, ['id'=>'repfirm_id']) !!}
            {!! Form::input('text', 'ACFirm', $repair->repfirm->name, ['class'=>'form-control', 'id'=>'ACFirm', 'disabled'=>'disabled']) !!}
        </div>
        <div class="col-sm-1">
            <button id="BtnAddFirm" class="btn btn-primary btnclick hidden-print" type="button"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('repmodel', 'Модель устройства', ['class'=>'col-sm-3 control-label']) !!}
        <div id="models" class="col-sm-9">
            {!! Form::text('repmodel', $repair->repmodel, ['class'=>'form-control', 'id'=>'repmodel']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('sparepart', 'Запчасть', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('sparepart', $repair->sparepart, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('prices', 'Цена запчасти', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::input('number', 'prices', $repair->prices, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('replacement', 'Стоимость замены', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::input('number', 'replacement', $repair->replacement, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('status', 'Статус запроса', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('status', array(
            '1' => 'Запрс',
            '2' => 'Подтвержден',
            '3' => 'Отменен'
            ), $repair->status, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('discription', 'Коментарий', ['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::textarea('discription', $repair->discription, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {!! Form::submit('Сохранить', ['class'=>'btn btn-success', 'id'=>'BtnRepairCreat']) !!}
            <a href="spare/{!!$repair->id!!}/printed" class="btn btn-default">Печать</a>
            {!! link_to_route('spare', 'Отмена', null, ['class'=>'btn btn-danger'])!!}
        </div>
    </div>
    {!! Form::Close() !!}
@stop