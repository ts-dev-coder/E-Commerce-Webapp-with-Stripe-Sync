import { Link } from '@inertiajs/react';

export default function CheckoutSuccess() {
    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-gray-50">
            <div className="flex flex-col items-center rounded-xl bg-white p-8 shadow-lg">
                <svg className="mb-4 h-16 w-16 text-green-500" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="2" fill="white" />
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4" />
                </svg>
                <h1 className="mb-2 text-2xl font-bold text-gray-800">Thank you for your purchase!</h1>
                <p className="mb-6 text-center text-gray-600">
                    Your order has been completed successfully.
                    <br />A confirmation email has been sent to your registered address.
                </p>
                <Link href="/" className="rounded-lg bg-primary px-6 py-2 font-semibold text-white shadow transition hover:bg-primary/90">
                    Back to Home
                </Link>
            </div>
        </div>
    );
}
