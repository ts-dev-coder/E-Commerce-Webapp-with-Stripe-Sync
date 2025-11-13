import AdminLayout from '@/layouts/admin-layout';

import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

import { Product } from '@/types';

type Props = {
    result: Product[];
};

const productMetaData = ['name', 'price', 'stock', 'is_published'];

export default function Search({ result }: Props) {
    return (
        <AdminLayout>
            <div className="flex size-full">
                <Table>
                    <TableCaption>A list of product.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            {productMetaData.map((metaData) => (
                                <TableHead key={metaData}>{metaData}</TableHead>
                            ))}
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        {result.length > 0 ? (
                            result.map((product, index) => {
                                const style = index % 2 !== 0 ? 'bg-sky-200/60' : '';
                                const publishStatusMap: Record<number, string> = {
                                    0: '非公開',
                                    1: '公開',
                                };

                                return (
                                    <TableRow key={product.id} className={`hover:cursor-pointer hover:bg-sky-300 ${style}`}>
                                        <TableCell>{product.name}</TableCell>
                                        <TableCell>{product.price}</TableCell>
                                        <TableCell>{product.stock}</TableCell>
                                        <TableCell>{publishStatusMap[product.is_published]}</TableCell>
                                    </TableRow>
                                );
                            })
                        ) : (
                            <TableRow>
                                <TableCell colSpan={4} className="py-6 text-center text-gray-500">
                                    該当する商品は見つかりませんでした。
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>
            </div>
        </AdminLayout>
    );
}
