@extends('Main')
@section('head')
    <script src="{{asset('repairFirms.js')}}"></script>
@stop
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
            <h4>Редактирование модели {{$messages->name}}</h4>
            {!! Form::open(['route'=>'repair.repmodelUpdate', 'class'=>'form']) !!}
                {!! Form::hidden('id', $messages->id) !!}
            <div class="form-group">
                {!! Form::label('equipment_id', 'Вид техники') !!}
                <select class="form-control equipmentAll" name="equipment_id">
                    <option value="{{$messages->equipment->id}}" selected>{{$messages->equipment->name}}</option>
                    @foreach($equipmentAll as $texnik)
                        <option value="{{$texnik->id}}">{{$texnik->name}}</option>
                    @endforeach
                </select>
            </div>
            <div id="firms2" class="form-group">
                {!! Form::label('repfirm_id', 'Фирма') !!}
                <select class="form-control" name="repfirm_id">
                    <option value="{{$messages->repfirm->id}}" selected>{{$messages->repfirm->name}}</option>
                    @foreach($repfirmAll as $texnik)
                        <option value="{{$texnik->id}}">{{$texnik->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!! Form::label('name', 'Название модели') !!}
                {!! Form::text('name', $messages->name, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('discription', 'Описание модели') !!}
                {!! Form::textarea('discription', $messages->discription, ['class'=>'form-control', 'rows'=>'3']) !!}
            </div>
            <div class="form-group">
                <button id="ButtonNewFirm" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
                {!! link_to_route('repair.repmodel', 'Отмена', '', ['class'=>'btn btn-danger', 'style'=>'margin-top:15px'])!!}
            </div>
            {!! Form::Close() !!}
        </div>
    </div>
@stop
