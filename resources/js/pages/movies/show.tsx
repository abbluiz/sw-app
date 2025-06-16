import SimpleLayout from '@/layouts/simple-layout';
import { Movie } from '@/types';

interface ShowMovieProps {
    movie: Movie
};

export default function ShowMovie({ movie }: ShowMovieProps) {
    return (
        <SimpleLayout title="Movie Details">
            <div>
                <span>{movie.title}</span>
            </div>
        </SimpleLayout>
    );
}
