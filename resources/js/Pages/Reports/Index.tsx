import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Head, Link } from '@inertiajs/react';

interface ReportsIndexProps {
    summary: {
        total: number;
        inStorage: number;
        forDisposal: number;
        underTrial: number;
    };
}

export default function ReportsIndex({ summary }: ReportsIndexProps) {
    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold text-gray-800">Reports</h2>}>
            <Head title="Reports" />

            <div className="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <div className="grid gap-4 md:grid-cols-4">
                    {Object.entries(summary).map(([key, value]) => (
                        <Card key={key}>
                            <CardHeader><CardTitle className="text-base capitalize">{key.replace(/([A-Z])/g, ' $1')}</CardTitle></CardHeader>
                            <CardContent><p className="text-3xl font-bold">{value}</p></CardContent>
                        </Card>
                    ))}
                </div>

                <Card>
                    <CardHeader><CardTitle className="text-base">Export</CardTitle></CardHeader>
                    <CardContent className="flex flex-wrap gap-3">
                        <a href={route('reports.inventory')}>
                            <Button variant="outline">Download Inventory CSV</Button>
                        </a>
                        <a href={route('reports.compliance')}>
                            <Button variant="outline">Download Compliance PDF</Button>
                        </a>
                        <Link href={route('audit-logs.index')}>
                            <Button variant="secondary">View Audit Logs</Button>
                        </Link>
                    </CardContent>
                </Card>
            </div>
        </AuthenticatedLayout>
    );
}
