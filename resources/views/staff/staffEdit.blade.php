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
            <div class="thumbnail">
                <img src="{{$staffEdit->avatar}}" data-src="holder.js/300x200" alt="...">
                <div class="caption">
                    {!! Form::open(['route'=>'staff.update', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
                    {!! Form::hidden('id', $staffEdit->id) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Имя') !!}
                        {!! Form::text('name', $staffEdit->name, ['class'=>'form-control' ,'placeholder'=>'Введите название']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('position', 'Должность') !!}
                        <select name="position" class="form-control">
                            @foreach($positions as $position)
                                @if ($staffEdit->position == $position)
                                    <option value="{{$position}}" selected>{{$position}}</option>
                                @else
                                    <option value="{{$position}}">{{$position}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        {!! Form::label('discription', 'Описание') !!}
                        {!! Form::textarea('discription', $staffEdit->discription, ['class'=>'form-control', 'rows'=>'3']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('avatar', 'Аватар') !!}

                        {!! Form::file('avatar', ['id'=>'exampleInputFile']) !!}
                        <p class="help-block">Изображения формата png или jpg.</p>
                    </div>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
                    <a href="http://asoz.sobaka-service.ru/staff" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> Отмена</a>
                    {!! Form::Close() !!}
                </div>
            </div>
        </div>
    </div>
@stop