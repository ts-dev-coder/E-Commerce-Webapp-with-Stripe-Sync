import { Head } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';

import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];



export default function Checkout() {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={0}>
            <Head title="Checkout" />
            <div>
                Checkout page
            </div>
        </AppLayout>
    );
}
