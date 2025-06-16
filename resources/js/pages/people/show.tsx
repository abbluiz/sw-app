import SimpleLayout from '@/layouts/simple-layout';
import { Movie, Person } from '@/types';
import { Link } from '@inertiajs/react';

interface ShowPersonProps {
    person: Person
};

function MovieLink(movie: Movie) {
    return (
        <Link className="sw-entity-relation-link" method="get" href={route('movies.show', { id: movie.id })} as="button">
            {movie.title}
        </Link>
    );
}

export default function ShowMovie({ person }: ShowPersonProps) {
    return (
        <SimpleLayout title="Person Details">
            <div className="text-style sw-details-card">
                <span className="font-bold">{person.name}</span>
                <div className="sw-details-inner-container">
                    <div className="sw-details">
                        <span className="font-bold">Details</span>
                        <div className="divider"></div>
                        <p>Birth Year: {person.birth_year}</p>
                        <p>Gender: {person.gender}</p>
                        <p>Eye Color: {person.eye_color}</p>
                        <p>Hair Color: {person.hair_color}</p>
                        <p>Height: {person.height_in_cm}</p>
                        <p>Mass: {person.mass_in_kg}</p>
                    </div>
                    <div className="sw-related-entities">
                        <span className="font-bold">Movies</span>
                        <div className="divider"></div>
                        {person.movies.map((movie, i) => [
                            i > 0 && ", ",
                            <MovieLink key={i} {...movie} />
                        ])}
                    </div>
                </div>
                <Link className="font-bold sw-button" method="get" href={route('search')} as="button">
                    BACK TO SEARCH
                </Link>
            </div>
        </SimpleLayout>
    );
}
