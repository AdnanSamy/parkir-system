<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    use HasFactory;

    protected $table = "parkir";

    public function setCreatedAt($value)
    {
        $this->attributes['created_at'] = $value;
    }

    public function setWaktuKeluar($value)
    {
        $this->attributes['waktu_keluar'] = $value;
    }
}
