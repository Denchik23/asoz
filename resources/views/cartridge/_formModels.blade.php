{!! Form::open(['route'=>'cartridge.modelsStore', 'class'=>'form-horizontal formNewFirm', 'name'=>'ModelsCreat']) !!}
    {!! Form::label('repfirm_id', 'Фирма производитель') !!}
    <select id="repfirm" class="form-control" name="repfirm_id">
        <option value="0" selected>Виберите фирму</option>
        @foreach($repfirm as $firm)
            <option value="{{$firm->id}}">{{$firm->name}}</option>
        @endforeach
    </select>
    {!! Form::label('name', 'Название модели картриджа') !!}
    {!! Form::text('name', Input::old('name'), ['class'=>'form-control']) !!}

<div class="form-group">
    {!! Form::label('cartridgeprices', 'Цена кртриджа', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'cartridgeprices', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('refueling', 'Заправка', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'refueling', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('drum', 'замена барабана', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'drum', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('raquel', 'замена Ракеля', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'raquel', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('rollercharge', 'замена ролика заряда', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'rollercharge', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('magroller', 'замена магнитного вала', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'magroller', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('blade', 'замена дозирующего лезвия', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'blade', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('chip', 'замена чипа', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'chip', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Руб.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('resourceprint', 'ресурс печати', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'resourceprint', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Стр.</span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('toner', 'Вместимость тонера', ['class'=>'col-sm-6 control-label']) !!}
    <div class="col-sm-6">
        <div class="input-group">
            {!! Form::input('number', 'toner', null, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">Грамм.</span>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-6 col-sm-6">
        <button id="BtnModelsCreat" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
    </div>
</div>
{!! Form::Close() !!}