<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    /**
     * Relacionamento muitos-para-muitos com User.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
