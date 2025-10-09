import type { PropsWithChildren } from 'react';

import { AppContent } from '@/components/app-content';
import { AppHeader } from '@/components/app-header';
import { AppShell } from '@/components/app-shell';

export default function AppHeaderLayout({ children, cartItemCount }: PropsWithChildren<{ cartItemCount: number }>) {
    return (
        <AppShell>
            <AppHeader cartItemCount={cartItemCount} />
            <AppContent>{children}</AppContent>
        </AppShell>
    );
}
