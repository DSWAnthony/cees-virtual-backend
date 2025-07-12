<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ["title","description","image_url","teacher_id","price","start_date","end_date","duration_hours","is_active","is_published","certificate_enabled"];
    protected $hidden = ["created_at", "updated_at"];

    // relations
    
    public function teacher(){
        return $this->belongsTo(User::class,"teacher_id");
    }

    public function modules(){
        return $this->hasMany(Module::class);
    }

    public function getImagenUrlAttribute(){
        return $this->image_url ? asset("storage/".$this->image_url) : null;
    }
}
