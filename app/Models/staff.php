<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    //мастера
    public function getStaffMasters() {
        $Staff = $this->Holiday()->where('position', '=', 'Мастер')->get();
        return $Staff;
    }
    //заправщики
    public function getPrintMasters() {
        $Staff = $this->Holiday()->where('position', '=', 'Заправщик')->get();
        return $Staff;
    }

    //scope для отпусков
    public function scopeHoliday($query)
    {
        $query->where('holiday', '=', '1');
    }

    //Разрешонные поля для массовой записи
    protected $fillable = ['name', 'discription', 'position', 'avatar', 'holiday'];
}
