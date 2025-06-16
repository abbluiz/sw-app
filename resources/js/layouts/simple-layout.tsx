import { Head } from '@inertiajs/react';
import { type ReactNode } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import { type SharedData } from '@/types';

interface SimpleAppLayoutProps {
    children: ReactNode;
    title: string;
}

export default function SimpleLayout({ children, title }: SimpleAppLayoutProps) {
    const { auth } = usePage<SharedData>().props;

    const handleLogout = () => {
        router.flushAll();
    };

    return (
        <>
            <Head title={title}>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
                <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
                <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
                <link rel="shortcut icon" href="/favicon.ico" />
                <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
                <meta name="apple-mobile-web-app-title" content="SWStarter" />
                <link rel="manifest" href="/site.webmanifest" />
            </Head>
            <main className="sw-main">
                <header className="sw-header">
                    <span className="sw-starter">
                        SWStarter
                    </span>
                </header>
                {auth.user ? (
                    <div className="sw-logout">
                        <span>Welcome back, {auth.user.name}!</span>
                        <Link className="sw-logout-button" method="post" href={route('logout')} as="button" onClick={handleLogout}>
                            Log Out
                        </Link>
                    </div>
                ) : (<></>)}
                <div>{children}</div>
            </main>
        </>
    )
}
