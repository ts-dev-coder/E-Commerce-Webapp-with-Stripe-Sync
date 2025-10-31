import { Grid, Home, Settings, User } from 'lucide-react';
import { ReactNode } from 'react';

import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarProvider,
} from '@/components/ui/sidebar';
import { Link } from '@inertiajs/react';

type NavItems = {
    id: string;
    label: string;
    icon: ReactNode;
    href: string;
};

export default function AdminLayout({ children }: { children: ReactNode }) {
    const navItems: NavItems[] = [
        {
            id: 'dashboard',
            label: 'Dashboard',
            icon: <Home />,
            href: '/admin/dashboard',
        },
        {
            id: 'products',
            label: 'Products',
            icon: <Grid />,
            href: '/admin/products',
        },
        {
            id: 'users',
            label: 'Users',
            icon: <User />,
            href: '/admin/users',
        },
        {
            id: 'settings',
            label: 'Settings',
            icon: <Settings />,
            href: '/admin/settings',
        },
    ];
    return (
        <div className="h-screen max-h-screen w-screen max-w-screen overflow-hidden">
            <div className="flex size-full">
                <SidebarProvider>
                    <Sidebar>
                        <SidebarHeader>
                            <div className="flex items-center gap-x-3">
                                <h1 className="text-xl font-semibold">管理者画面</h1>
                                <Link href="/">
                                    <span className="text-xs text-gray-500 hover:text-gray-900">トップページへ戻る</span>
                                </Link>
                            </div>
                        </SidebarHeader>
                        <SidebarContent>
                            <SidebarGroup>
                                <SidebarGroupLabel>Menu</SidebarGroupLabel>
                                <SidebarGroupContent>
                                    <SidebarMenu>
                                        {navItems.map((item) => (
                                            <SidebarMenuItem key={item.id}>
                                                <SidebarMenuButton asChild>
                                                    <a href={item.href}>
                                                        {item.icon}
                                                        <span>{item.label}</span>
                                                    </a>
                                                </SidebarMenuButton>
                                            </SidebarMenuItem>
                                        ))}
                                    </SidebarMenu>
                                </SidebarGroupContent>
                            </SidebarGroup>
                        </SidebarContent>
                    </Sidebar>
                    {/* Content */}
                    {children}
                </SidebarProvider>
            </div>
        </div>
    );
}
