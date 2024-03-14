<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cardFiles extends Model
{
    protected $table = 'files';
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $hidden = array('cardId', 'filePath', 'fileType', 'type');
    protected $fillable=['detail', 'fileName'];
    protected $appends=['hasImage'];
    public function getHasImageAttribute()  {
        return Files::where('id',$this->id)->value('filePath')!=null;
    }
}
