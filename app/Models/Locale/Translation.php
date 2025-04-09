<?php

namespace App\Models\Locale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id', 'tag_id', 'key', 'value'
    ];
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

}
