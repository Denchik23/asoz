<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class repmodel extends Model
{
    //Получение все моделей
    public  function getrepmodel()
    {
        $out = $this->with('repfirm')->latest()->paginate(15);
        return $out;

    }
    //Модели для сортировки
    public  function getrepmodelOrd($id = false)
    {
        if ($id) {
            $out = $this->where('repfirm_id', '=', $id)->latest()->paginate(15)->appends(['repfirm_id'=> $id]);
            return $out;
        } else {
            $out = $this->with('equipment', 'repfirm')->latest()->paginate(15);
            return $out;
        }
    }
    //Подсчет колличества для разных целей моделях
    public  function getrepmodelCount($id)
    {
        if (!empty($id)) {
            $out = $this->where('repfirm_id', '=', $id)->count();
            return $out;
        } else {
            $out = $this->select('id', 'name')->get();
            return $out;
        }
    }
    function getOrderAjax($idFirm, $nameModel) {
        $out = $this->where('repfirm_id', '=', $idFirm)->where('name', 'LIKE', '%'.$nameModel.'%')->get()->toJson();
        return $out;
    }
    //Удаление всех по фирмам
    public function DelmodelsFromFirm($id_firm) {
        $countDel = $this->where('repfirm_id', '=', $id_firm)->delete();
        return $countDel;
    }
    //удаление по ключу
    public function DelrepmodelKey($id)
    {
        $out = $this->find($id);
        $out->delete();
    }
    //связь с фирмой
    public function repfirm()
    {
        return $this->belongsTo('App\Models\repfirm');
    }
    //Поля разрешенные для массовой записи
    protected $fillable = ['cartridgeprices', 'refueling', 'drum', 'name', 'repfirm_id', 'raquel', 'rollercharge', 'magroller', 'blade', 'chip', 'resourceprint', 'toner'];
}
