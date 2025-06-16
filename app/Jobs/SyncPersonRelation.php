<?php

namespace App\Jobs;

use App\Models\Person;
use App\Repositories\MovieRepository;
use App\Services\MovieService;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncPersonRelation implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Person $person,
        public int|string $movieId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $relationAlreadyExists = $this->person->movies()
            ->wherePivot('movie_id', $this->movieId)
            ->exists();

        if (! $relationAlreadyExists) {
            $movieService = app(MovieService::class);
            $movieRepository = app(MovieRepository::class);

            $movie = $movieRepository->find($this->movieId);

            if (empty($movie)) {
                $movie = $movieService->showAndSave($this->movieId);
            }

            $this->person->movies()->attach($movie->id);
        }
    }
}
