import type { PropsWithChildren } from 'react';

import { AppContent } from '@/components/app-content';
import { AppHeader } from '@/components/app-header';
import { AppShell } from '@/components/app-shell';
import { BannerCarousel } from '@/components/banner-carousel';

export default function AppHeaderLayout({ children, cartItemCount }: PropsWithChildren<{ cartItemCount: number }>) {
    return (
        <AppShell>
            <AppHeader cartItemCount={cartItemCount} />
            <BannerCarousel />
            <AppContent>{children}</AppContent>
        </AppShell>
    );
}
