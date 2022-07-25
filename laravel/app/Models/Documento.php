<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "tipo",
        "status",
        "imagem"
    ];

    public function rules(){
        return [
            'user_id' => 'required|exists:users,id',
            'tipo' => 'required|integer',
            'imagem' => 'required|file|mimes:jpeg,png,pdf',
        ];
    }

    // Um documento PERTENCE À UM user
    public function user(){
        return $this->belongsTo("App\Models\User");
    }
}
