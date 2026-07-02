import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Head } from '@inertiajs/react';

interface AuditLogsProps {
    logs: {
        data: Array<{
            id: number;
            action: string;
            model_type: string | null;
            model_id: number | null;
            ip_address: string | null;
            created_at: string;
            user?: { name: string };
        }>;
    };
}

export default function AuditLogs({ logs }: AuditLogsProps) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold text-gray-800">Audit Logs</h2>}>
            <Head title="Audit Logs" />

            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <Card>
                    <CardHeader><CardTitle className="text-base">Append-only Activity Log</CardTitle></CardHeader>
                    <CardContent>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200 text-sm">
                                <thead>
                                    <tr>
                                        <th className="px-3 py-2 text-left">Time</th>
                                        <th className="px-3 py-2 text-left">User</th>
                                        <th className="px-3 py-2 text-left">Action</th>
                                        <th className="px-3 py-2 text-left">Model</th>
                                        <th className="px-3 py-2 text-left">IP</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-100">
                                    {logs.data.map((log) => (
                                        <tr key={log.id}>
                                            <td className="px-3 py-2">{new Date(log.created_at).toLocaleString()}</td>
                                            <td className="px-3 py-2">{log.user?.name ?? 'System'}</td>
                                            <td className="px-3 py-2">{log.action}</td>
                                            <td className="px-3 py-2">{log.model_type ? `${log.model_type}#${log.model_id}` : '—'}</td>
                                            <td className="px-3 py-2">{log.ip_address ?? '—'}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AuthenticatedLayout>
    );
}
