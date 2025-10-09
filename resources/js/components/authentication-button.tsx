import { Link } from '@inertiajs/react';
import { Button } from './ui/button';

export const AuthenticationButton = () => {
    return (
        <>
            <Link href="/login">
                <Button variant={'ghost'} className="hover:cursor-pointer">
                    Sign in
                </Button>
            </Link>
            <span className="mx-2 text-lg text-gray-500">/</span>
            <Link href="/register">
                <Button variant={'default'} className="hover:cursor-pointer">
                    Sign up
                </Button>
            </Link>
        </>
    );
};
