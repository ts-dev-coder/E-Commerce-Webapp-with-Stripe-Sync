import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

type Props = {
    cartItemCount: number;
};

export default function Checkout({ cartItemCount }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs} cartItemCount={cartItemCount}>
            <Head title="Checkout" />
            <div className="flex min-h-screen flex-col items-center py-8">
                <h2 className="mb-6 text-2xl font-bold">レジ</h2>
                <div className="w-full max-w-xl space-y-8">
                    {/* 配送先情報 */}
                    <Card>
                        <CardHeader>
                            <CardTitle>配送先情報</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div>
                                <Label htmlFor="name">氏名</Label>
                                <Input id="name" name="name" placeholder="山田 太郎" />
                            </div>
                            <div>
                                <Label htmlFor="postal">郵便番号</Label>
                                <Input id="postal" name="postal" placeholder="123-4567" />
                            </div>
                            <div>
                                <Label htmlFor="address">住所</Label>
                                <Input id="address" name="address" placeholder="東京都新宿区..." />
                            </div>
                            <div>
                                <Label htmlFor="phone">電話番号</Label>
                                <Input id="phone" name="phone" placeholder="090-1234-5678" />
                            </div>
                        </CardContent>
                    </Card>
                    {/* 支払方法 */}
                    <Card>
                        <CardHeader>
                            <CardTitle>支払方法</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <RadioGroup defaultValue="credit">
                                <div className="mb-2 flex items-center space-x-2">
                                    <RadioGroupItem value="credit" id="credit" />
                                    <Label htmlFor="credit">クレジットカード</Label>
                                </div>
                                <div className="mb-2 flex items-center space-x-2">
                                    <RadioGroupItem value="cod" id="cod" />
                                    <Label htmlFor="cod">代金引換</Label>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <RadioGroupItem value="bank" id="bank" />
                                    <Label htmlFor="bank">銀行振込</Label>
                                </div>
                            </RadioGroup>
                        </CardContent>
                    </Card>
                    <div className="flex justify-end">
                        <Button className="px-8 py-3 text-lg" variant="default">
                            注文を確定する
                        </Button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
