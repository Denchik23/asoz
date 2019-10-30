<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    /**
     * Получение всех настроек
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        if ($this->count() <= 0) {
            return false;
        } else {
            return $this->all();
        }
    }
}
