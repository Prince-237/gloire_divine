<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class NewsArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'title_fr', 'title_en', 'excerpt_fr', 'excerpt_en',
        'content_fr', 'content_en', 'image_url', 'is_published', 'published_at', 'author_id',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function notificationLogs(): MorphMany
    {
        return $this->morphMany(NotificationLog::class, 'notifiable');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('created_at');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'en' ? $this->title_en : $this->title_fr;
    }

    public function getExcerptAttribute(): string
    {
        $value = app()->getLocale() === 'en' ? $this->excerpt_en : $this->excerpt_fr;

        if ($value) {
            return $value;
        }

        return \Illuminate\Support\Str::limit(strip_tags($this->content), 140);
    }

    public function getContentAttribute(): string
    {
        return app()->getLocale() === 'en' ? $this->content_en : $this->content_fr;
    }
}
