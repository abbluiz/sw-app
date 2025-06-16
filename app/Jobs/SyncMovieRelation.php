<?php

namespace App\Jobs;

use App\Models\Movie;
use App\Repositories\PersonRepository;
use App\Services\PersonService;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncMovieRelation implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Movie $movie,
        public int|string $personId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $relationAlreadyExists = $this->movie->people()
            ->wherePivot('person_id', $this->personId)
            ->exists();

        if (! $relationAlreadyExists) {
            $personService = app(PersonService::class);
            $personRepository = app(PersonRepository::class);

            $person = $personRepository->find($this->personId);

            if (empty($entity)) {
                $person = $personService->showAndSave($this->personId);
            }

            $this->movie->people()->attach($person->id);
        }
    }
}
