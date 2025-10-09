import { type ReactNode } from 'react';

import AppLayoutTemplate from '@/layouts/app/app-header-layout';

interface AppLayoutProps {
    children: ReactNode;
    cartItemCount: number;
}

export default ({ children, ...props }: AppLayoutProps) => <AppLayoutTemplate {...props}>{children}</AppLayoutTemplate>;
