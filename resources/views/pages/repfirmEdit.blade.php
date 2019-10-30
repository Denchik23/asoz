@extends('Main')
@section('head')
    <script src="{{asset('js/repairFirms.js')}}"></script>
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
            <h4>Редактирование фирмы {{$messages->name}}</h4>
            {!! Form::open(['route'=>'repair.repfirmUpdate', 'class'=>'form']) !!}
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
            <div class="form-group">
                {!! Form::label('name', 'Имя фирмы') !!}
                {!! Form::text('name', $messages->name, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                <button id="ButtonNewFirm" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
                {!! link_to_route('repair.repfirm', 'Отмена', '', ['class'=>'btn btn-danger', 'style'=>'margin-top:15px'])!!}
            </div>
            {!! Form::Close() !!}
        </div>
    </div>
@stop