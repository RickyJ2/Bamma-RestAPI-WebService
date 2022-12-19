<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_mobil',
        'tgl_pengembalian',
        'tgl_peminjaman',
        'status'
    ];
}
