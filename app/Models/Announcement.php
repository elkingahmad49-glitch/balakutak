<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LocaleFilter;

class Announcement extends Model
{
    use LocaleFilter;
    protected $fillable = [
        'user_id', 'title', 'content', 'attachment', 'priority',
        'is_published', 'expire_date', 'language',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->title) . '-' . \Illuminate\Support\Str::random(5);
            }
        });
    }

    protected $casts = [
        'is_published' => 'boolean',
        'expire_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeActive($query)
    {
        return $query->published()
            ->where(fn($q) => $q->whereNull('expire_date')->orWhere('expire_date', '>=', today()));
    }
}
