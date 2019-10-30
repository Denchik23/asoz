@extends('Main')
@section('head')
    <script src="{{asset('repairFirms.js')}}"></script>
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['route'=>'repair.repmodelOrder', 'class'=>'form-inline']) !!}
                <div class="form-group">
                    <h4>Сортировать по: </h4>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="equipment_id">Email</label>
                    <select class="form-control equipment" name="equipment_id">
                        <option value="0">Вся техника</option>
                        @foreach($equipmentAll as $texnik)
                            @if ($texnik->id == $equipment_id)
                                <option value="{{$texnik->id}}" selected>{{$texnik->name}}</option>
                            @else
                                <option value="{{$texnik->id}}">{{$texnik->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <h4>Фирма: </h4>
                </div>
                <div id="firms" class="form-group">
                    <label class="sr-only" for="exampleInputEmail2">модели</label>
                    <select class="form-control repfirmOrd" name="repfirm_id">
                        @if ($repfirm_id == -1)
                            <option value="0">Сначала укажите вид техники</option>
                        @else
                            @foreach($repfirmOrd as $texnik)
                                @if ($texnik->id == $repfirm_id)
                                    <option value="{{$texnik->id}}" selected>{{$texnik->name}}</option>
                                @else
                                    <option value="{{$texnik->id}}">{{$texnik->name}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
                <button id="ButtomOrder" type="submit" class="btn btn-primary">Показать</button>
            {!! Form::Close() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">Коллицество фирм  <span class="badge">{{$count}}</span></div>
                <div class="panel-body">
                    <?php $status = Session::get('status'); ?>
                    @if ( isset($status))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4>{{$status}}</h4>
                        </div>
                    @endif
                    <table class="table table-striped">
                        @if (! $messages->isEmpty() )
                            <thead>
                            <tr>
                                <td>№</td>
                                <td>Имя модели</td>
                                <td>Техника</td>
                                <td>Фирма</td>
                                <td colspan="2">Действия</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <th>{!!$message->id!!}</th>
                                    <th>{!!$message->name!!}</th>
                                    <th>{!!$message->equipment->name!!}</th>
                                    <th>{!!$message->repfirm->name!!}</th>
                                    <th><a class="btn btn-primary btn-xs" href="repair/repmodel/{!!$message->id!!}/edit"><span class="glyphicon glyphicon-pencil"></span>  Редактировать</a></th>
                                    <th><a class="btn btn-primary btn-xs" href="repair/repmodel/{!!$message->id!!}/del"><span class="glyphicon glyphicon-trash"></span> Удалить</a></th>
                                </tr>
                            @endforeach
                            <div class="text-center">
                                {!!$messages->render()!!}
                            </div>
                            @else
                                <tr>
                                    <td>Нет данных</td>
                                </tr>
                            @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">Добавить новую фирму</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <h4>Предупреждение!</h4>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    {!! Form::open(['route'=>'repair.repmodelAdd', 'class'=>'form-horizontal formNewFirm', 'name'=>'ButtonNewFirm']) !!}
                        {!! Form::label('equipment_id', 'Вид техники') !!}
                        <select class="form-control equipmentAll" name="equipment_id">
                            <option value="0">Выберите вед техники</option>
                            @foreach($equipmentAll as $texnik)
                                <option value="{{$texnik->id}}">{{$texnik->name}}</option>
                            @endforeach
                        </select>
                        {!! Form::label('repfirm_id', 'Фирма') !!}
                        <div id="firms2">
                            <select class="form-control" name="repfirm_id">
                                <option value="0">Сначала укажите вид техники</option>
                            </select>
                        </div>
                        {!! Form::label('name', 'Имя модели') !!}
                        {!! Form::text('name', Input::old('name'), ['class'=>'form-control']) !!}
                        {!! Form::label('discription', 'Описание модели') !!}
                        {!! Form::textarea('discription', Input::old('discription'), ['class'=>'form-control', 'rows'=>'3']) !!}
                        <button id="ButtonNewFirm" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
                    {!! Form::Close() !!}
                </div>
            </div>
        </div>
    </div>
@stop