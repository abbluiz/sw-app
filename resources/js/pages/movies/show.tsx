import SimpleLayout from '@/layouts/simple-layout';
import { Movie, Person } from '@/types';
import { Link } from '@inertiajs/react';

interface ShowMovieProps {
    movie: Movie
};

function PersonLink(person: Person) {
    return (
        <Link className="sw-entity-relation-link" method="get" href={route('people.show', { id: person.id })} as="button">
            {person.name}
        </Link>
    );
}

export default function ShowMovie({ movie }: ShowMovieProps) {
    return (
        <SimpleLayout title="Movie Details">
            <div className="text-style sw-details-card">
                <span className="font-bold">{movie.title}</span>
                <div className="sw-details-inner-container">
                    <div className="sw-details">
                        <span className="font-bold">Opening Crawl</span>
                        <div className="divider"></div>
                        {movie.opening_crawl}
                    </div>
                    <div className="sw-related-entities">
                        <span className="font-bold">People</span>
                        <div className="divider"></div>
                        {movie.people.map((person, i) => [
                            i > 0 && ", ",
                            <PersonLink key={i} {...person} />
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
