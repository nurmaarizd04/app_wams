<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProjectTech extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama_institusi",
        "kode_project",
        "no_sales",
        "tgl_sales",
        "nama_project",
        "hps",
        "nama_sales",
        "jenis_dokumen",
        "upload_dokumen",
        "user_id",

    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function uploads()
    {
        return $this->morphMany(Media::class, 'model');
    }
}
