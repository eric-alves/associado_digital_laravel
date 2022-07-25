<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        "cpfcnpj",
        "nascimento",
        "conta",
        "sexo",
        "pai",
        "mae",
        "status",
        "token",
        "cooperativa",
        "matricula_empresa",
        "nome_empresa",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "password",
        "remember_token",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rules(){
        return [
            'name' => "required",
            'email' => "required|unique:users,email,".$this->id,
            'password' => "required",

            "cpfcnpj" => [
                "required"
            ],
            "nascimento" => "required",
            "conta" => "required",
            "sexo" => "required",
            "pai" => "required",
            "mae" => "required",
            "status" => "required",
            "token" => "required",
            "cooperativa" => "required",
            "matricula_empresa" => "required",
            "nome_empresa" => "required",
        ];
    }

    // Um user possui vários documentos
    public function documentos(){
        return $this->hasMany("App\Models\Documento");
    }
}
