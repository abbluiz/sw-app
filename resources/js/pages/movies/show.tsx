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
            <div className="details-container">
                <h2 className="font-semibold">{movie.title}</h2>

                <div className="details-content">
                    <div className="details-left">
                        <h4 className="font-semibold">Details</h4>
                        <hr />
                        <p className="opening-crawl">{movie.opening_crawl}</p>
                        <Link className="font-bold back-button" method="get" href={route('search')} as="button">
                            BACK TO SEARCH
                        </Link>
                    </div>

                    <div className="details-right">
                        <h4 className="font-semibold">Characters</h4>
                        <hr />
                        <div>
                            {movie.people.map((person, i) => [
                                i > 0 && ", ",
                                <PersonLink key={i} {...person} />
                            ])}
                        </div>
                    </div>
                </div>
            </div>
        </SimpleLayout>
    );
}
