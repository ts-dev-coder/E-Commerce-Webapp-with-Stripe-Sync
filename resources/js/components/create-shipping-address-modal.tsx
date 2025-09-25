'use client';

import { useForm } from '@inertiajs/react';
import { Button } from './ui/button';
import { Checkbox } from './ui/checkbox';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from './ui/dialog';
import { Input } from './ui/input';
import { Label } from './ui/label';

type ShippingAddressForm = {
    recipient_name: string;
    postal_code: string;
    prefecture: string;
    city: string;
    street: string;
    building: string;
    phone_number: string;
    is_default: boolean;
};

export const CreateShippingAddressModal = () => {
    const { data, setData, post, processing, errors, reset } = useForm<ShippingAddressForm>({
        recipient_name: '',
        postal_code: '',
        prefecture: '',
        city: '',
        street: '',
        building: '',
        phone_number: '',
        is_default: false,
    });

    const onSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/shipping-addresses', {
            onSuccess: () => reset(),
        });
    };

    return (
        <Dialog>
            <DialogTrigger asChild>
                <Button>新しい住所を登録する</Button>
            </DialogTrigger>

            <DialogContent className="max-w-md">
                <DialogHeader>
                    <DialogTitle>新規住所</DialogTitle>
                </DialogHeader>

                <form onSubmit={onSubmit} className="space-y-4">
                    <div className="space-y-2">
                        <Label htmlFor="recipient_name">受取人氏名</Label>
                        <Input id="recipient_name" value={data.recipient_name} onChange={(e) => setData('recipient_name', e.target.value)} />
                        {errors.recipient_name && <p className="text-sm text-red-500">{errors.recipient_name}</p>}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="postal_code">郵便番号</Label>
                        <Input id="postal_code" value={data.postal_code} onChange={(e) => setData('postal_code', e.target.value)} />
                        {errors.postal_code && <p className="text-sm text-red-500">{errors.postal_code}</p>}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="prefecture">都道府県</Label>
                        <Input id="prefecture" value={data.prefecture} onChange={(e) => setData('prefecture', e.target.value)} />
                        {errors.prefecture && <p className="text-sm text-red-500">{errors.prefecture}</p>}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="city">市区町村</Label>
                        <Input id="city" value={data.city} onChange={(e) => setData('city', e.target.value)} />
                        {errors.city && <p className="text-sm text-red-500">{errors.city}</p>}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="street">町名・番地</Label>
                        <Input id="street" value={data.street} onChange={(e) => setData('street', e.target.value)} />
                        {errors.street && <p className="text-sm text-red-500">{errors.street}</p>}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="building">建物名・部屋番号</Label>
                        <Input id="building" value={data.building} onChange={(e) => setData('building', e.target.value)} />
                        {errors.building && <p className="text-sm text-red-500">{errors.building}</p>}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="phone_number">電話番号</Label>
                        <Input id="phone_number" value={data.phone_number} onChange={(e) => setData('phone_number', e.target.value)} />
                        {errors.phone_number && <p className="text-sm text-red-500">{errors.phone_number}</p>}
                    </div>

                    <div className="flex items-center space-x-2">
                        <Checkbox id="is_default" checked={data.is_default} onCheckedChange={(checked) => setData('is_default', checked === true)} />
                        <Label htmlFor="is_default">この住所をデフォルトに設定する</Label>
                    </div>

                    <DialogFooter>
                        <Button type="submit" disabled={processing}>
                            {processing ? '登録中...' : '登録'}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
};
