<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\MovieFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id Identifier
 * @property string $title Title
 * @property string $opening_crawl Opening crawl
 * @property Collection<int, Person> $people List of People the Movie has in
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Movie extends Model
{
    /** @use HasFactory<MovieFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'title',
        'opening_crawl',
    ];

    /**
     * @return BelongsToMany<Person, $this>
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
