<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presence extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     * The migrations create a 'presences' table, so explicitly set it here.
     *
     * @var string
     */
    protected $table = 'presences';
    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'check_in',
        'check_out',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
