@extends('Main')
@section('head')
    <script src="{{asset('js/repairFirms.js')}}"></script>
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
    {!! Form::open(['route'=>'cartridge.modelsUpdata', 'class'=>'form-horizontal', 'name'=>'ModelsCreat']) !!}
    {!! Form::hidden('id', $messages->id) !!}
        <div class="form-group">
            {!! Form::label('repfirm_id', 'Фирма производитель', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                <select id="repfirm" class="form-control" name="repfirm_id">
                    <option value="{{$messages->repfirm->id}}" selected>{{$messages->repfirm->name}}</option>
                    @foreach($repfirm as $firm)
                        <option value="{{$firm->id}}">{{$firm->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Название модели картриджа', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('name', $messages->name, ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('cartridgeprices', 'Цена кртриджа', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'cartridgeprices', $messages->cartridgeprices, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('refueling', 'Заправка', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'refueling', $messages->refueling, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('drum', 'замена барабана', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'drum', $messages->drum, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('raquel', 'замена Ракеля', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'raquel', $messages->raquel, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('rollercharge', 'замена ролика заряда', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'rollercharge', $messages->rollercharge, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('magroller', 'замена магнитного вала', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'magroller', $messages->magroller, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('blade', 'замена дозирующего лезвия', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'blade', $messages->blade, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('chip', 'замена чипа', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'chip', $messages->chip, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Руб.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('resourceprint', 'ресурс печати', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'resourceprint', $messages->resourceprint, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Стр.</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('toner', 'Вместимость тонера', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                    {!! Form::input('number', 'toner', $messages->toner, ['class'=>'form-control', 'min'=>'1']) !!}
                    <span class="input-group-addon">Грамм.</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                {!! Form::submit('Сохранить', ['class'=>'btn btn-success', 'id'=>'BtnModelsCreat']) !!}
                {!! link_to_route('cartridge.models', 'Отмена', null, ['class'=>'btn btn-danger'])!!}
            </div>
        </div>
    {!! Form::Close() !!}
@stop
