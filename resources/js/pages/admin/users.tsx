import AdminLayout from '@/layouts/admin-layout';

import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

import { User } from '@/types';

type Props = {
    users: User[];
};

const userMetaData = ['name', 'email'];

export default function Users({ users }: Props) {
    return (
        <AdminLayout>
            <div className="flex size-full">
                <Table>
                    <TableCaption>A list of user.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            {userMetaData.map((metaData) => (
                                <TableHead>{metaData}</TableHead>
                            ))}
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {users.map((user, index) => {
                            const style = index % 2 !== 0 ? 'bg-sky-200/60' : '';

                            return (
                                <TableRow key={user.id} className={`hover:cursor-pointer hover:bg-sky-300 ${style}`}>
                                    <TableCell>{user.name}</TableCell>
                                    <TableCell>{user.email}</TableCell>
                                </TableRow>
                            );
                        })}
                    </TableBody>
                </Table>
            </div>
        </AdminLayout>
    );
}
