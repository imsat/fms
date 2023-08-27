<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
      'form_id',
      'label',
      'field_type',
      'options',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
