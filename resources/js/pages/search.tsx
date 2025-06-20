import SimpleLayout from '@/layouts/simple-layout';
import { Person, Movie } from '@/types';
import { Link } from '@inertiajs/react';
import { useState, useEffect } from 'react';

interface SearchProps {
    people: Array<Person>;
    movies: Array<Movie>;
}

function PersonComponent(person: Person) {
    return (
        <li>
            <span className="text-style font-bold">{person.name}</span>
            <Link className="font-bold sw-button" method="get" href={route('people.show', { id: person.id })} as="button">
                SEE DETAILS
            </Link>
        </li>
    );
}

function MovieComponent(movie: Movie) {
    return (
        <li>
            <span className="text-style font-bold">{movie.title}</span>
            <Link className="font-bold sw-button" method="get" href={route('movies.show', { id: movie.id })} as="button">
                SEE DETAILS
            </Link>
        </li>
    );
}

const renderPeople = (people: Array<Person>) => {
    return (
        <ul>
            {people.map((item: Person) => (
                <PersonComponent key={item.id} {...item}></PersonComponent>
            ))}
        </ul>
    );
};

const renderMovies = (movies: Array<Movie>) => {
    return (
        <ul>
            {movies.map((item: Movie) => (
                <MovieComponent key={item.id} {...item}></MovieComponent>
            ))}
        </ul>
    );
};

const renderResults = (mode: string, people: Array<Person>, movies: Array<Movie>) => {
    if (mode === "people" && people && people.length !== 0) {
        return renderPeople(people);
    }

    if (mode === "movies" && movies && movies.length !== 0) {
        return renderMovies(movies);
    }

    return (
        <div className="sw-empty-content">
            <span className="sw-empty-content-text">
                <center>There are zero matches. <br />Use the form to search for People or Movies.</center>
            </span>
        </div>
    );
};

export default function Search({ people, movies }: SearchProps) {
    const [mode, setMode] = useState("people");
    const [query, setQuery] = useState("");

    useEffect(() => {
        setMode(route().queryParams.mode);
        setQuery(route().queryParams.query);
    }, []);

    return (
        <SimpleLayout title="Search">
            <div className="main-container">
                <div className="search-box">
                    <h3>What are you searching for?</h3>
                    <div className="radio-group">
                        <label>
                            <input
                                type="radio"
                                value="people"
                                checked={mode === "people"}
                                onChange={() => setMode("people")}
                            />
                            People
                        </label>
                        <label>
                            <input
                                type="radio"
                                value="movies"
                                checked={mode === "movies"}
                                onChange={() => setMode("movies")}
                            />
                            Movies
                        </label>
                    </div>
                    <input
                        type="text"
                        placeholder={mode === "people" ? "e.g. Chewbacca, Yoda, Boba Fett" : "e.g. Revenge of the Sith"}
                        value={query}
                        onChange={(e) => setQuery(e.target.value)}
                    />
                    <Link disabled={query === ""} className={query === "" ? "font-bold sw-button sw-disabled-button" : "font-bold sw-button"} method="get" href={route('search')} data={{ query: query, mode: mode }} as="button">
                        SEARCH
                    </Link>
                </div>
                <div className="results">
                    <h3 className="font-semibold">Results</h3>
                    <div className="divider"></div>
                    {renderResults(mode, people, movies)}
                </div>
            </div>
        </SimpleLayout>
    );
}


