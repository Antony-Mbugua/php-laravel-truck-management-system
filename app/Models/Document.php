<?php

namespace App\Models;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    protected $casts = [
        'type' => DocumentType::class,
    ];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
