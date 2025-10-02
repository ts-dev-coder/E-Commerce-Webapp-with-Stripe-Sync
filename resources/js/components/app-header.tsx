
import { Link, usePage } from '@inertiajs/react';
import {  ShoppingCart } from 'lucide-react';
import AppLogo from './app-logo';

import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';

import { UserMenuContent } from '@/components/user-menu-content';
import { SearchBar } from '@/components/search-bar';
import { AuthenticationButton } from '@/components/authentication-button';

import { type SharedData } from '@/types';

import { useInitials } from '@/hooks/use-initials';


interface AppHeaderProps {
    cartItemCount: number;
}

export function AppHeader({ cartItemCount }: AppHeaderProps) {
    // 認証状態を管理
    const page = usePage<SharedData>();
    const { auth } = page.props;

    // ユーザ名のイニシャルを取得するメソッド
    const getInitials = useInitials();

    return (
        <div className='h-16'>
            <div className="mx-auto flex items-center md:max-w-[1600px]">
                {/* Mobile Menu */}

                {/* Logo */}
                <Link href="/" prefetch className="flex items-center">
                    <AppLogo />
                </Link>
                {/* 検索 */}
                <div className='h-full flex items-center px-5 max-w-4xl w-full'>
                    <SearchBar />
                </div>

                {/* Login / Register Button OR User Icon */}
                {
                    auth.user === null ? (
                        <div className='h-full w-fit flex items-center gap-x-2 px-2'>
                            <AuthenticationButton />
                        </div>
                    ): (
                        /* 認証後User Icon */
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant={'ghost'} className='size-10 rounded-full p-1'>
                                    <Avatar className='size-8 overflow-hidden  rounded-full'>
                                        <AvatarImage src={auth.user.avatar} alt={auth.user.name} />
                                        <AvatarFallback className='rounded-lg bg-neutral-200 text-black'>
                                            {getInitials(auth.user.name)}
                                        </AvatarFallback>
                                    </Avatar>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className='w-56' align='end'>
                                <UserMenuContent user={auth.user}/>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    )
                }
                {/* Cart Icon */}
                <div className='h-full w-fit flex items-center justify-center'>
                    <Link href='/cart' className='relative flex items-center size-full px-2'>
                        <span className='absolute bg-blue-500 text-white min-w-[20px] text-center text-xs px-2 py-0.5 rounded-full top-0 left-5'>{cartItemCount}</span>
                        <ShoppingCart className='hover:cursor-pointer size-7'/>
                    </Link>
                </div>
            </div>
        </div>
    );
}
