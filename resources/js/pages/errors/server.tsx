import SimpleLayout from '@/layouts/simple-layout';

export default function ServerError({ status }: number) {
    const title = {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page/Resource Not Found',
        403: '403: Forbidden',
    }[status]

    const description = {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page/resource you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page/resource.',
    }[status]

    return (
        <SimpleLayout title="Error">
            <div>
                <h1>{title}</h1>
                <div>{description}</div>
            </div>
        </SimpleLayout>
    );
}
