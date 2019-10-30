<div class="form-group">
    {!! Form::label('cartridgeprices', 'Цена кртриджа:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::input('text', 'cartridgeprices', $datacartridge->cartridgeprices, ['class'=>'form-control', 'disabled'=>'disabled']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('toner', 'Вместимость тонера:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::input('text', 'toner', $datacartridge->toner, ['class'=>'form-control', 'disabled'=>'disabled']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('resourceprint', 'ресурс печати:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::input('text', 'resourceprint', $datacartridge->resourceprint, ['class'=>'form-control', 'disabled'=>'disabled']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('refueling', 'Заправка:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        <div class="input-group">
            {!! Form::input('number', 'refueling', $datacartridge->refueling, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">
                <input type="checkbox" name="C-refueling" value="Заправка" checked="checked">
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('drum', 'замена барабана:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        <div class="input-group">
            {!! Form::input('number', 'drum', $datacartridge->drum, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">
                <input type="checkbox" name="C-drum" value="замена барабана">
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('raquel', 'замена Ракеля:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        <div class="input-group">
            {!! Form::input('number', 'raquel', $datacartridge->raquel, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">
                <input type="checkbox" name="C-raquel" value="замена Ракеля">
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('rollercharge', 'замена ролика заряда:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        <div class="input-group">
            {!! Form::input('number', 'rollercharge', $datacartridge->rollercharge, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">
                <input type="checkbox" name="C-rollercharge" value="замена ролика заряда">
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('magroller', 'замена магнитного вала:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        <div class="input-group">
            {!! Form::input('number', 'magroller', $datacartridge->magroller, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">
                <input type="checkbox" name="C-magroller" value="замена магнитного вала">
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('blade', 'замена дозирующего лезвия:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        <div class="input-group">
            {!! Form::input('number', 'blade', $datacartridge->blade, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">
                <input type="checkbox" name="C-blade" value="Замена дозирующего лезвия">
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('chip', 'замена чипа:', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        <div class="input-group">
            {!! Form::input('number', 'chip', $datacartridge->chip, ['class'=>'form-control', 'min'=>'0']) !!}
            <span class="input-group-addon">
                <input type="checkbox" name="C-chip" value="замена чипа">
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('number', 'Колличество', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::input('number', 'number', 1, ['class'=>'form-control', 'min'=>'1']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('prices', 'Цена ремонта', ['class'=>'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        <div class="input-group">
            {!! Form::input('number', 'prices', null, ['class'=>'form-control']) !!}
            <span class="input-group-btn">
                <button class="btn btn-info" type="button" id="BtnCalculate">Расчитать стоимость!</button>
            </span>
        </div>
    </div>
</div>