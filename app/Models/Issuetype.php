<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issuetype extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
        'type',
    ];

    public function specs()
    {
        return $this->hasMany(Issuetype::class, 'parent_id');
    }

    public function subspecs()
    {
        return $this->hasMany(Issuetype::class, 'parent_id')->where('type',2);
    }

    public function parent()
    {
        return $this->belongsTo(Issuetype::class, 'parent_id');
    }
}
