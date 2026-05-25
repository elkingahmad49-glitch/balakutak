<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\LocaleFilter;

class Post extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'excerpt', 'content',
        'featured_image', 'type', 'status', 'language', 'seo_meta',
        'views', 'is_featured', 'allow_comments', 'published_at', 'sdgs'
    ];

    protected $casts = [
        'seo_meta' => 'array',
        'sdgs' => 'array',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'published_at' => 'datetime',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['title', 'status']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function visitorLogs()
    {
        return $this->hasMany(VisitorLog::class);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return str_starts_with($this->featured_image, 'http')
                ? $this->featured_image
                : asset('storage/' . $this->featured_image);
        }
        return asset('images/default-post.jpg');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        return max(1, (int)ceil($wordCount / 200));
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = self::generateUniqueSlug($model->slug ?: \Illuminate\Support\Str::slug($model->title), $model->id);
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') || $model->isDirty('slug')) {
                $base = $model->isDirty('slug') ? $model->slug : \Illuminate\Support\Str::slug($model->title);
                $model->slug = self::generateUniqueSlug($base, $model->id);
            }
        });
    }

    private static function generateUniqueSlug($titleOrSlug, $id = null)
    {
        $slug = \Illuminate\Support\Str::slug($titleOrSlug);
        $slug = \Illuminate\Support\Str::limit($slug, 240, '');
        $originalSlug = $slug;
        $count = 2;

        $query = self::query();
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(self::class))) {
            $query->withTrashed();
        }

        while ($query->clone()->where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $suffix = '-' . $count++;
            $slug = \Illuminate\Support\Str::limit($originalSlug, 255 - strlen($suffix), '') . $suffix;
        }

        return $slug;
    }
}
