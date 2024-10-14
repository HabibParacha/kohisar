<?php

namespace App\Models;

use App\Models\TripSheet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact_person',
        'mobile_no',
        'image',
        'is_active'

    ];


    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }
    public function vehicleAssignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class);
    }
    public function tripSheets(): HasMany
    {
        return $this->hasMany(TripSheet::class);
    }
}
