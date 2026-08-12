<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResearchService extends Model
{
    protected $table = 'research_services';

    protected $fillable = [
        'title',
        'slug',
        'author',
        'year',
        'type',
        'abstract',
        'content',
        'featured_image',
        'file_path',
        'external_link',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            if (str_contains($this->featured_image, 'http')) {
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/placeholder-research.jpg');
    }

    public function getExcerptAttribute($value)
    {
        if ($this->abstract) {
            return Str::limit($this->abstract, 160);
        }
        return Str::limit(strip_tags($this->content), 160);
    }

    public function getPublishedAtAttribute()
    {
        return $this->created_at;
    }

    public function getViewsAttribute()
    {
        return 0; // Placeholder for now
    }

    public function getCategoryAttribute()
    {
        // Mock category for front-end badge
        return (object)[
            'name' => ($this->type === 'research' ? 'Penelitian' : 'Pengabdian')
        ];
    }

    public function getUserAttribute()
    {
        // Mock user for front-end compatibility
        return (object)[
            'name' => ($this->author ?? 'Admin')
        ];
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
        // Truncate to 240 chars to leave space for suffix
        $slug = Str::limit($slug, 240, '');
        $originalSlug = $slug;
        $count = 2;

        while (self::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $suffix = '-' . $count++;
            $slug = Str::limit($originalSlug, 255 - strlen($suffix), '') . $suffix;
        }

        return $slug;
    }
}
