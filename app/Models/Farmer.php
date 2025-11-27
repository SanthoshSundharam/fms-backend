<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'village_name',
        'mobile_number',
        'bank_account',
        'ifsc_code',
        'bank_name',
        'branch',
        'aadhar_number',
        'farmer_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['farmer_image_url'];

    public function getFarmerImageUrlAttribute()
    {
        if ($this->farmer_image) {
            return asset('storage/' . $this->farmer_image);
        }
        return null;
    }
}