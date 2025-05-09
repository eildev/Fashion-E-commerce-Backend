<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferBanner extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function images(){
        return $this->hasMany(ImageGallery::class,'offer_banner_id','id');
    }
}
