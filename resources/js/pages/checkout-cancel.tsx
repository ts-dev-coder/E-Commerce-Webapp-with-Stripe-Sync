import { Link } from '@inertiajs/react';

export default function CheckoutCancel() {
    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-gray-50">
            <div className="flex flex-col items-center rounded-xl bg-white p-8 shadow-lg">
                <svg className="mb-4 h-16 w-16 text-red-500" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="2" fill="white" />
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 9l-6 6M9 9l6 6" />
                </svg>
                <h1 className="mb-2 text-2xl font-bold text-gray-800">Payment Cancelled</h1>
                <p className="mb-6 text-center text-gray-600">
                    Your payment was not completed.
                    <br />
                    If you wish to try again, please return to your cart.
                </p>
                <Link href="/cart" className="rounded-lg bg-primary px-6 py-2 font-semibold text-white shadow transition hover:bg-primary/90">
                    Back to Cart
                </Link>
            </div>
        </div>
    );
}
