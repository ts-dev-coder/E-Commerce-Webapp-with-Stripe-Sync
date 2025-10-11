import { ReactNode } from 'react';

type Props = {
    categories: string[];
};

export const CategoryNavigation = ({ categories }: Props) => {
    return (
        <div className="flex h-full flex-col">
            <NavigationTitle title="カテゴリーから探す" />

            <NavigationList>
                {categories.map((category) => (
                    <div key={category} className="px-4 py-2 hover:cursor-pointer hover:bg-gray-200/60">
                        <span className="line-clamp-1 text-sm">{category}</span>
                    </div>
                ))}
            </NavigationList>

            <NavigationTitle title="お気に入り" />
            <NavigationList>
                <div className="px-4 py-2 text-black hover:cursor-pointer hover:bg-gray-200/60">
                    <span className="text-sm">ブランド</span>
                </div>
            </NavigationList>
        </div>
    );
};

const NavigationTitle = ({ title }: { title: string }) => {
    return (
        <div className="h-fit w-40 max-w-40 text-start">
            <span className="text-base font-semibold">{title}</span>
        </div>
    );
};

const NavigationList = ({ children }: { children: ReactNode }) => {
    return <div className="w-40 max-w-40 space-y-0.5 py-2 pr-1">{children}</div>;
};
