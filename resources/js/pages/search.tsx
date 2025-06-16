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
        <>
            <div>
                <span className="text-style font-bold">{person.name}</span>
                <Link className="font-bold sw-button" method="get" href={route('people.show', { id: person.id })} as="button">
                    SEE DETAILS
                </Link>
            </div>
            <div className="divider"></div>
        </>
    );
}

function MovieComponent(movie: Movie) {
    return (
        <>
            <div>
                <span className="text-style font-bold">{movie.title}</span>
                <Link className="font-bold sw-button" method="get" href={route('movies.show', { id: movie.id })} as="button">
                    SEE DETAILS
                </Link>
            </div>
            <div className="divider"></div>
        </>
    );
}

const renderPeople = (people: Array<Person>) => {
    return people.map((item: Person) => (
        <PersonComponent key={item.id} {...item}></PersonComponent>
    ));
};

const renderMovies = (movies: Array<Movie>) => {
    return movies.map((item: Movie) => (
        <MovieComponent key={item.id} {...item}></MovieComponent>
    ));
};

const renderResults = (mode: string, people: Array<Person>, movies: Array<Movie>) => {
    if (mode === "people" && people) {
        return renderPeople(people);
    }

    if (mode === "movies" && movies) {
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

    function handleQueryChange(e) {
        setQuery(e.target.value);
    }

    function handleModeChange(e) {
        setMode(e.target.value);
    }

    return (
        <SimpleLayout title="Search">
            <div className="sw-search">
                <>
                    <div className="text-style sw-search-container">
                        <label htmlFor="query" className="font-semibold">
                            What are you searching for?
                        </label><br />
                        <input type="radio" id="people" name="search_mode" value="people" checked={mode === 'people'} onChange={handleModeChange} />
                        <label htmlFor="people">People</label>
                        <input type="radio" id="movies" name="search_mode" value="movies" checked={mode === 'movies'} onChange={handleModeChange} />
                        <label htmlFor="movies">Movies</label><br />
                        <input className="sw-query-input" id="query" value={query} onChange={handleQueryChange} /><br />
                        <Link disabled={query === ""} className={query === "" ? "font-bold sw-button sw-disabled-button" : "font-bold sw-button"} method="get" href={route('search')} data={{ query: query, mode: mode }} as="button">
                            SEARCH
                        </Link>
                    </div>
                    <div className="sw-search-results">
                        <span className="text-style font-bold text-results-title">
                            Results
                        </span>
                        <div className="divider"></div>
                        {renderResults(mode, people, movies)}
                    </div>
                </>
            </div>
        </SimpleLayout>
    );
}


