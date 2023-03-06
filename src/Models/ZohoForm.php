<?php

namespace Omatech\EdiZohoConnect\Models;

use Illuminate\Database\Eloquent\Model;

class ZohoForm extends Model
{
    protected $table = 'zoho_forms';

    public $timestamps = true;

    protected $fillable = ['inst_id', 'language', 'status', 'form', 'email_admin', 'data', 'url', 'data_api'];

    protected $attributes = [
        'inst_id' => 0,
        'status' => 'pending',
    ];

    protected $casts = [
        'data' => 'json',
        'data_api' => 'json',
    ];
}
