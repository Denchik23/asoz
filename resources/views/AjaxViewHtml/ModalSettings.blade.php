@foreach($dataSetting as $setting)
<form class="form-inline setForm">
    <div class="form-group">
        <label for="SetValue">{{$setting->name}}: </label>
        <input type="hidden" name="SetId" value="{{$setting->id}}">
        <input type="number" min="1" class="form-control" name="SetValue" value="{{$setting->value}}">
    </div>
    <button id="setting{{$setting->id}}" type="submit" class="btn btn-default" data-loading-text="Сохранение...">Сохранить</button>
</form>
@endforeach
<div id="AjaxReturn">
</div>