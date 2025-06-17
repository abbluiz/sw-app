<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\SearchMode;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id Identifier
 * @property string $query Query
 * @property SearchMode $mode Mode
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Query extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'query',
        'mode'
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mode' => SearchMode::class,
        ];
    }
}
