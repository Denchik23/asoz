@extends('Main')
@section('head')
    <script src="{{asset('js/repairFirms.js')}}"></script>
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['route'=>'repair.repfirmOrder', 'class'=>'form-inline', 'method' => 'get']) !!}
                <div class="form-group">
                    <h4>Сортировать по: </h4>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="exampleInputEmail2">Email</label>
                    {!! Form::select('equipment_id', $equipmentAll, $equipment_id, ['class'=>'form-control']) !!}
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
                                <td>Имя</td>
                                <td>Техника</td>
                                <td colspan="2">Действия</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <th>{!!$message->id!!}</th>
                                    <th>{!!$message->name!!}</th>
                                    <th>{!!$message->equipment->name!!}</th>
                                    <th><a class="btn btn-primary btn-xs" href="repair/repfirm/{!!$message->id!!}/edit"><span class="glyphicon glyphicon-pencil"></span>  Редактировать</a></th>
                                    <th><a class="btn btn-primary btn-xs" href="repair/repfirm/{!!$message->id!!}/del" onclick="return confirmDelete();"><span class="glyphicon glyphicon-trash"></span> Удалить</a></th>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td>Нет данных</td>
                                </tr>
                            @endif
                            </tbody>
                    </table>
                    <div class="text-center">
                        {!!$messages->render()!!}
                    </div>
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
                    {!! Form::open(['route'=>'repair.repfirmAdd', 'class'=>'form-horizontal formNewFirm', 'name'=>'ButtonNewFirm']) !!}
                        {!! Form::label('equipment_id', 'Вид техники') !!}
                        <select class="form-control equipmentAll" name="equipment_id">
                            <option value="0">Выберите вед техники</option>
                            @foreach($equipmentAll as $texnik => $value)
                                @if ($texnik != 0)
                                    <option value="{{$texnik}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                        {!! Form::label('name', 'Имя фирмы') !!}
                        {!! Form::text('name', Input::old('name'), ['class'=>'form-control']) !!}
                        <button id="ButtonNewFirm" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
                    {!! Form::Close() !!}
                </div>
            </div>
        </div>
    </div>
@stop