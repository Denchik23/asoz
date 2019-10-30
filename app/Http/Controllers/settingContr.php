<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class settingContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settingAjax(setting $setting)
    {
        if ($dataSetting = $setting->getAll()) {
            return view('AjaxViewHtml.ModalSettings')->with('dataSetting', $dataSetting);
        } else {
            return 'Настроек в базе даннх нет';
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update записи настройки через Ajax.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            if ((isset($_POST['SetId'])) && (isset($_POST['SetValue']))) {
                $id = $_POST['SetId'];
                $value = $_POST['SetValue'];
                $validator = validator::make(
                    array('id' => $id, 'value' => $value),
                    array('id' => 'integer|min:1', 'value' => 'integer|min:1')
                );
                if ($validator->fails())
                    return '<p class="text-danger"><small>Ошибка валидации!</small></p>';
                $update = setting::find($id);
                $update->value = $value;
                if ($update->save())
                    echo '<p class="text-success"><small>Настройки сохранены!</small></p>';
            }
        }
    }
}
