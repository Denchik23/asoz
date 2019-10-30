<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Авторизация
Route::group(['prefix'=>'','middleware'=>'auth'], function()
{
    Route::get('/', ['uses' => 'mainContr@index', 'as' => 'main']);
});
Route::get('auth/login', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'auth']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


//Главный контроллер
//Route::get('/', ['uses' => 'mainContr@index', 'as' => 'main']); - авторизация только на главной странице
Route::get('сalculator', ['uses' => 'mainContr@calculator', 'as' => 'Calculator']);
Route::get('SpareDestroyAll', ['uses' => 'mainContr@SpareDestroyAll', 'as' => 'SpareDestroyAll']);
Route::post('search', ['uses' => 'mainContr@search', 'as' => 'search']);


//Ремонт
Route::get('repair', ['uses' => 'repairContr@index', 'as' => 'repair']);
Route::get('repair/{id}/show', ['uses' => 'repairContr@show', 'as' => 'repair.show'])->where(['id' => '[0-9]+']);
Route::get('repair/{id}/printed', ['uses' => 'repairContr@printed', 'as' => 'repair.printed'])->where(['id' => '[0-9]+']);
Route::get('repair/{id}/edit', ['uses' => 'repairContr@edit', 'as' => 'repair.edit'])->where(['id' => '[0-9]+']);
Route::get('repair/{id}/del', ['uses' => 'repairContr@destroy', 'as' => 'repair.destroy'])->where(['id' => '[0-9]+']);
Route::get('repair/create', ['uses' => 'repairContr@create', 'as' => 'repair.create']);
Route::post('repair/store', ['uses' => 'repairContr@store', 'as' => 'repair.store']);
Route::post('repair/update', ['uses' => 'repairContr@update', 'as' => 'repair.update']);
Route::get('repair/order', ['uses' => 'repairContr@order', 'as' => 'repair.order']);

//виды техники
Route::get('repair/equipment', ['uses' => 'equipmentCont@index', 'as' => 'repair.equipment']);
Route::get('repair/equipment/add', ['uses' => 'equipmentCont@create', 'as' => 'repair.equipmentAdd']);
Route::get('repair/equipment/{id}/edit', ['uses' => 'equipmentCont@edit', 'as' => 'repair.equipmentEdit'])->where(['id' => '[0-9]+']);
Route::get('repair/equipment/{id}/del', ['uses' => 'equipmentCont@destroy', 'as' => 'repair.equipmentDel'])->where(['id' => '[0-9]+']);
Route::post('repair/equipment/store', ['uses' => 'equipmentCont@store', 'as' => 'repair.equipmentStore']);
Route::post('repair/equipment/update', ['uses' => 'equipmentCont@update', 'as' => 'repair.equipmentUpdate']);


//фирмы
Route::get('repair/repfirm', ['uses' => 'repfirmContr@index', 'as' => 'repair.repfirm']);
Route::get('repair/repfirm/{id}/del', ['uses' => 'repfirmContr@destroy', 'as' => 'repair.repfirmDel'])->where(['id' => '[0-9]+']);
Route::get('repair/repfirm/{id}/edit', ['uses' => 'repfirmContr@edit', 'as' => 'repair.repfirmEdit'])->where(['id' => '[0-9]+']);
Route::post('repair/repfirm/add', ['uses' => 'repfirmContr@store', 'as' => 'repair.repfirmAdd']);
Route::post('repair/repfirm/update', ['uses' => 'repfirmContr@update', 'as' => 'repair.repfirmUpdate']);
Route::get('repair/repfirm/order', ['uses' => 'repfirmContr@order', 'as' => 'repair.repfirmOrder']);


//Сотрудники
Route::get('staff', ['uses' => 'staffContr@index', 'as' => 'staff']);
Route::get('staff/add', ['uses' => 'staffContr@create', 'as' => 'staff.add']);
Route::get('staff/{id}/edit', ['uses' => 'staffContr@edit', 'as' => 'staff.Edit'])->where(['id' => '[0-9]+']);
Route::get('staff/{id}/del', ['uses' => 'staffContr@destroy', 'as' => 'staff.del'])->where(['id' => '[0-9]+']);
Route::get('staff/{id}/holiday', ['uses' => 'staffContr@holiday', 'as' => 'staff.holiday'])->where(['id' => '[0-9]+']);
Route::post('staff/store', ['uses' => 'staffContr@store', 'as' => 'staff.store']);
Route::post('staff/update', ['uses' => 'staffContr@update', 'as' => 'staff.update']);


//Картриджи
Route::get('cartridge', ['uses' => 'cartridgeContr@index', 'as' => 'cartridge']);
Route::get('cartridge/create', ['uses' => 'cartridgeContr@create', 'as' => 'cartridge.create']);
Route::get('cartridge/{id}/show', ['uses' => 'cartridgeContr@show', 'as' => 'cartridge.show'])->where(['id' => '[0-9]+']);
Route::get('cartridge/{id}/edit', ['uses' => 'cartridgeContr@edit', 'as' => 'cartridge.edit'])->where(['id' => '[0-9]+']);
Route::get('cartridge/{id}/del', ['uses' => 'cartridgeContr@destroy', 'as' => 'cartridge.destroy'])->where(['id' => '[0-9]+']);
Route::get('cartridge/{id}/printed', ['uses' => 'cartridgeContr@printed', 'as' => 'cartridge.printed'])->where(['id' => '[0-9]+']);
Route::post('cartridge/store', ['uses' => 'cartridgeContr@store', 'as' => 'cartridge.store']);
Route::post('cartridge/update', ['uses' => 'cartridgeContr@update', 'as' => 'cartridge.update']);
Route::get('cartridge/order', ['uses' => 'cartridgeContr@order', 'as' => 'cartridge.order']);


//Модели картриджей
Route::get('cartridge/models', ['uses' => 'printmodelContr@index', 'as' => 'cartridge.models']);
Route::get('cartridge/{id}/modelsEdit', ['uses' => 'printmodelContr@edit', 'as' => 'cartridge.modelsEdit'])->where(['id' => '[0-9]+']);
Route::get('cartridge/{id}/modelsdel', ['uses' => 'printmodelContr@destroy', 'as' => 'cartridge.modelsdestroy'])->where(['id' => '[0-9]+']);
Route::post('cartridge/models/store', ['uses' => 'printmodelContr@store', 'as' => 'cartridge.modelsStore']);
Route::post('cartridge/models/update', ['uses' => 'printmodelContr@update', 'as' => 'cartridge.modelsUpdata']);
Route::get('cartridge/models/order', ['uses' => 'printmodelContr@order', 'as' => 'cartridge.modelsOrder']);

//Запросы на запчатси
Route::get('spare', ['uses' => 'spareContr@index', 'as' => 'spare']);
Route::get('spare/create', ['uses' => 'spareContr@create', 'as' => 'spare.create']);
Route::get('spare/{id}/show', ['uses' => 'spareContr@show', 'as' => 'spare.show'])->where(['id' => '[0-9]+']);
Route::get('spare/{id}/edit', ['uses' => 'spareContr@edit', 'as' => 'spare.edit'])->where(['id' => '[0-9]+']);
Route::get('spare/{id}/del', ['uses' => 'spareContr@destroy', 'as' => 'spare.destroy'])->where(['id' => '[0-9]+']);
Route::get('spare/{id}/printed', ['uses' => 'spareContr@printed', 'as' => 'spare.printed'])->where(['id' => '[0-9]+']);
Route::post('spare/store', ['uses' => 'spareContr@store', 'as' => 'spare.store']);
Route::post('spare/update', ['uses' => 'spareContr@update', 'as' => 'spare.updata']);
Route::get('spare/order', ['uses' => 'spareContr@order', 'as' => 'spare.order']);

//Архив
Route::get('archive', ['uses' => 'ArchiveContr@index', 'as' => 'archive']);
Route::get('archive/create', ['uses' => 'ArchiveContr@create', 'as' => 'archive.create']);
Route::get('archive/{id}/printed', ['uses' => 'ArchiveContr@printed', 'as' => 'archive.printed'])->where(['id' => '[0-9]+']);
Route::post('archive/store', ['uses' => 'ArchiveContr@store', 'as' => 'archive.store']);
Route::get('archive/order', ['uses' => 'ArchiveContr@order', 'as' => 'archive.order']);
Route::get('archive/faind', ['uses' => 'ArchiveContr@faind', 'as' => 'archive.faind']);
Route::get('archive/export/excel', ['uses' => 'ArchiveContr@exportExcel', 'as' => 'archive.exportExcel']);
Route::get('archive/export/xml', ['uses' => 'ArchiveContr@exportXml', 'as' => 'archive.exportXml']);

// POST-запрос при нажатии на нашу Ajax.
Route::post('repair/ajax', array('before'=>'csrf-ajax', 'uses'=>'repairContr@getajax', 'as'=>'repair.ajax'));

// POST-запрос поиска моделей картриджей Ajax.
Route::post('cartridge/ajax', array('before'=>'csrf-ajax', 'uses'=>'cartridgeContr@getajax', 'as'=>'cartridge.ajax'));

// POST-запрос добавления блока работ Ajax.
Route::post('cartridge/Modelajax', array('before'=>'csrf-ajax', 'uses'=>'cartridgeContr@Modelajax', 'as'=>'cartridge.Modelajax'));

// POST-запрос показа в модальном окне записи архива Ajax.
Route::post('archive/ajax', array('before'=>'csrf-ajax', 'uses'=>'ArchiveContr@ShowArchiveAjax', 'as'=>'archive.Modelajax'));

// POST-запрос обновления настройки Ajax.
Route::post('setting/update', array('before'=>'csrf-ajax', 'uses'=>'settingContr@update', 'as'=>'setting.update'));

// GET-запрос показа модального окна с записями настроек Ajax.
Route::get('setting/ajax', array('before'=>'csrf-ajax', 'uses'=>'settingContr@settingAjax', 'as'=>'setting.Modelajax'));

Route::post('repair/Fastadd/ajax', array('before'=>'csrf-ajax', 'uses'=>'repairContr@Fastaddajax', 'as'=>'Fastadd.ajax'));
// Фильтр, срабатывающий перед пост запросом.
Route::filter('csrf-ajax', function()
{
    if (Session::token() != Request::header('x-csrf-token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});