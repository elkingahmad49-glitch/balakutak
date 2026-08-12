<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'content', 'excerpt', 'featured_image',
        'template', 'is_builder', 'builder_data', 'is_published', 'order', 'seo_meta'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = self::generateUniqueSlug($model->slug ?: Str::slug($model->title), $model->id);
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') || $model->isDirty('slug')) {
                $base = $model->isDirty('slug') ? $model->slug : Str::slug($model->title);
                $model->slug = self::generateUniqueSlug($base, $model->id);
            }
        });
    }

    private static function generateUniqueSlug($titleOrSlug, $id = null)
    {
        $slug = Str::slug($titleOrSlug);
        $slug = Str::limit($slug, 240, '');
        $originalSlug = $slug;
        $count = 2;

        $query = self::query();
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(self::class))) {
            $query->withTrashed();
        }

        while ($query->clone()->where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $suffix = '-' . $count++;
            $slug = Str::limit($originalSlug, 255 - strlen($suffix), '') . $suffix;
        }

        return $slug;
    }
}
