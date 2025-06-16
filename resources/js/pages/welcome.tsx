import { Link } from '@inertiajs/react';
import SimpleLayout from '@/layouts/simple-layout';

export default function Welcome() {
    return (
        <SimpleLayout title="Welcome">
            <div className="sw-auth-required">
                <>
                    <p className="text-style sw-auth-required-item">
                        Welcome! Please authenticated yourself to use our application.
                    </p>
                    <Link
                        className="sw-auth-required-item sw-button"
                        href={route('login')}
                    >
                        LOG IN
                    </Link>
                    <Link
                        className="sw-auth-required-item sw-button"
                        href={route('register')}
                    >
                        REGISTER
                    </Link>
                </>
            </div>
        </SimpleLayout>
    );
}
