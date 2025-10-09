type StockStatusProps = {
    status: 'in-stock' | 'out-of-stock' | 'low-stock';
};

export const StockStatus = ({ status }: StockStatusProps) => {
    switch (status) {
        case 'in-stock':
            return (
                <div className="flex items-center gap-2 rounded-md border border-green-300 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">
                    <span className="h-2 w-2 rounded-full bg-green-500"></span>
                    在庫あり
                </div>
            );
        case 'out-of-stock':
            return (
                <div className="flex items-center gap-2 rounded-md border border-red-300 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700">
                    <span className="h-2 w-2 rounded-full bg-red-500"></span>
                    在庫なし
                </div>
            );
        case 'low-stock':
            return (
                <div className="flex items-center gap-2 rounded-md border border-yellow-300 bg-yellow-50 px-4 py-2 text-sm font-semibold text-yellow-700">
                    <span className="h-2 w-2 rounded-full bg-yellow-500"></span>
                    残りわずか
                </div>
            );
    }
};
