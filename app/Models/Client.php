<?php

namespace App\Models;

use App\Models\Concerns\HasPublishedFlag;
use App\Models\Concerns\HasSortOrder;
use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static> published()
 * @method static \Illuminate\Database\Eloquent\Builder<static> ordered()
 */
class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory, HasPublishedFlag, HasSortOrder;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'logo',
        'url',
        'is_published',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }
}
