<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{

	public function children() {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('parent_id', '!=', null);
    }

}
