import { ReactNode } from 'react';

export const CategoryNavigation = () => {
    return (
        <div className="flex w-96 flex-col items-end">
            <NavigationTitle title="カテゴリーから探す" />

            <NavigationList>
                <div className="bg-gray-200/60 px-4 py-2 hover:cursor-pointer">
                    <span className="text-sm">トップス</span>
                </div>

                <div className="px-4 py-2 text-black hover:cursor-pointer hover:bg-gray-200/60">
                    <span className="text-sm">ジャケット / アウター</span>
                </div>

                <div className="px-4 py-2 text-black hover:cursor-pointer hover:bg-gray-200/60">
                    <span className="text-sm">パンツ</span>
                </div>
            </NavigationList>
            
            <NavigationTitle title="お気に入り" />
            <NavigationList>
                <div className="px-4 py-2 text-black hover:cursor-pointer hover:bg-gray-200/60">
                    <span className="text-sm">ブランド</span>
                </div>

                <div className="px-4 py-2 text-black hover:cursor-pointer hover:bg-gray-200/60">
                    <span className="text-sm">ショップ</span>
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
