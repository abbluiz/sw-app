import SimpleLayout from '@/layouts/simple-layout';
import { Person } from '@/types';

interface ShowPersonProps {
    person: Person
};

export default function ShowMovie({ person }: ShowPersonProps) {
    return (
        <SimpleLayout title="Person Details">
            <div>
                <span>{person ? (person.name) : "Person not found"}</span>
            </div>
        </SimpleLayout>
    );
}
