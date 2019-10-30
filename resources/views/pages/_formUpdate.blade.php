{!! Form::open(['route'=>'repair.equipmentUpdate', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
{!! Form::hidden('id', $UpEuipment->id) !!}
<div class="form-group">
    {!! Form::label('name', 'Название вида техники') !!}
    {!! Form::text('name', $UpEuipment->name, ['class'=>'form-control' ,'placeholder'=>'Введите название']) !!}
</div>
<div class="form-group">
    {!! Form::label('exampleInputFile', 'Текущее изображение') !!}
    <p><img style="width: 150px;" src="{{$UpEuipment->picture}}" alt="{{$UpEuipment->name}}"></p>
</div>
<div class="form-group">
    {!! Form::label('image', 'Новое изображение') !!}

    {!! Form::file('image', ['id'=>'exampleInputFile']) !!}
    <p class="help-block">Изображения формата png или jpg.</p>
</div>
<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
{!! Form::Close() !!}