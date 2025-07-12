<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ["module_id", "title", "description", "file_path", "order_num", "type", "quiz_id"];
    protected $hidden = ["updated_at"];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
