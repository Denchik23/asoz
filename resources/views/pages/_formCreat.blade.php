{!! Form::open(['route'=>'repair.equipmentStore', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
<div class="form-group">
    {!! Form::label('name', 'Название вида техники') !!}
    {!! Form::text('name', Input::old('name'), ['class'=>'form-control' ,'placeholder'=>'Введите название']) !!}
</div>
<div class="form-group">
    {!! Form::label('exampleInputFile', 'Изображение') !!}

    {!! Form::file('image', ['id'=>'exampleInputFile']) !!}
    <p class="help-block">Изображения формата png или jpg.</p>
</div>
<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
{!! Form::Close() !!}