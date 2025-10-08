<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaMagang extends Model
{
    use HasFactory;

    protected $table = 'pesertas'; // sesuaikan nama tabel
    protected $fillable = ['user_id', 'nama', 'alamat', 'batch'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
