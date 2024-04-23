<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'user_id',
        'machine_model',
        'machine_serial',
        'issue_type_id',
        'issue_specs_id',
        'issue_subspecs_id',
        'title',
        'description',
        'type',
        'inst_start',
        'inst_end',
        'file_path',
        'status',
        'solved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issuetype()
    {
        return $this->belongsTo(Issuetype::class, 'issue_type_id', 'id');
    }
    public function issuespec()
    {
        return $this->belongsTo(Issuetype::class, 'issue_specs_id', 'id');
    }
    public function issuesubspec()
    {
        return $this->belongsTo(Issuetype::class, 'issue_subspecs_id', 'id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'id', 'ticket_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'id', 'ticket_id');
    }

    public function technicians()
    {
        return $this->belongsToMany(User::class);
    }
}
