<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\Gender;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id Identifier
 * @property string $name Name
 * @property Gender $gender Gender
 * @property string $eye_color Eye Color
 * @property string $hair_color Hair Color
 * @property string $height_in_cm Height (in centimeters)
 * @property string $mass_in_kg Mass (in kilograms)
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @property Collection<int, Movie> $movies List of Movies the Person is in
 */
class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'gender',
        'eye_color',
        'hair_color',
        'height_in_cm',
        'mass_in_kg'
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
        ];
    }

    /**
     * @return BelongsToMany<Movie, $this>
     */
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
