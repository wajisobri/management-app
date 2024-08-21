<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_description',
        'deadline',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function projectFiles()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function getIsActiveAttribute()
    {
        if ($this->deadline < now()) {
            return false;
        }

        return true;
    }
}
