<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class equipment extends Model
{
    //Виды техники кроме переданного id
    public function getEquipmentBesides($id = false) {
        if ($id) {
            $out = $this->where('id', '!=', $id)->get();
            return $out;
        }
    }

    public function getequipmentAll($id) {
        if (!empty($id)) {
            $repair = $this->where('id', '!=', $id)->paginate(15);
        } else {
            $repair = $this->latest()->paginate(15);
        }
        return $repair;
    }

    //Разрешонные поля для массовой записи
    protected $fillable = ['name', 'picture'];
}
