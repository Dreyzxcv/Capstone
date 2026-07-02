import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { AssetStatusBadge } from '@/Components/shared/AssetStatusBadge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Head, Link, usePage } from '@inertiajs/react';
import {
    Bar,
    BarChart,
    CartesianGrid,
    ResponsiveContainer,
    Tooltip,
    XAxis,
    YAxis,
} from 'recharts';
import { PageProps } from '@/types';

interface DashboardProps {
    stats: {
        total: number;
        byType: Record<string, number>;
        byStatus: Record<string, number>;
        byMunicipality: Array<{ municipality_of_origin: string; count: number }>;
    };
    recentActivity: Array<{
        id: number;
        status: string;
        notes: string | null;
        changed_at: string;
        asset?: { asset_code: string; id: number };
        changed_by?: { name: string };
    }>;
    statusLabels: Record<string, string>;
    typeLabels: Record<string, string>;
    roleContext: {
        title: string;
        description: string;
        cards: Array<{ label: string; value: number; description: string }>;
    };
    canViewAudit: boolean;
}

export default function DashboardIndex({
    stats,
    recentActivity,
    statusLabels,
    typeLabels,
    roleContext,
}: DashboardProps) {
    const { auth } = usePage<PageProps>().props;
    const permissions = auth.user?.permissions ?? [];

    const primaryAction = permissions.includes('assets.create')
        ? { label: 'New Intake', href: route('assets.create') }
        : permissions.includes('reports.view')
            ? { label: 'View Reports', href: route('reports.index') }
            : permissions.includes('disposals.view')
                ? { label: 'View Disposals', href: route('disposals.index') }
                : { label: 'View All Assets', href: route('assets.index') };

    const typeChartData = Object.entries(stats.byType).map(([type, count]) => ({
        name: typeLabels[type] ?? type,
        count,
    }));

    const municipalityChartData = stats.byMunicipality.map((row) => ({
        name: row.municipality_of_origin,
        count: row.count,
    }));

    return (
        <AuthenticatedLayout
            header={
                <div className="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 className="text-xl font-semibold leading-tight text-gray-800">
                            Inventory Dashboard
                        </h2>
                        <p className="text-sm text-gray-500">{roleContext.description}</p>
                    </div>
                    <Link href={primaryAction.href}>
                        <Button variant="outline">{primaryAction.label}</Button>
                    </Link>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-base">{roleContext.title}</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <p className="text-sm text-gray-600">{roleContext.description}</p>
                        <div className="grid gap-4 md:grid-cols-3">
                            {roleContext.cards.map((card) => (
                                <div key={card.label} className="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                    <p className="text-sm font-medium text-gray-700">{card.label}</p>
                                    <p className="mt-2 text-2xl font-semibold text-emerald-700">{card.value}</p>
                                    <p className="mt-1 text-sm text-gray-500">{card.description}</p>
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>

                <div className="grid gap-4 md:grid-cols-4">
                    <Card>
                        <CardHeader><CardTitle className="text-base">Total Assets</CardTitle></CardHeader>
                        <CardContent><p className="text-3xl font-bold">{stats.total}</p></CardContent>
                    </Card>
                    {Object.entries(stats.byType).map(([type, count]) => (
                        <Card key={type}>
                            <CardHeader><CardTitle className="text-base">{typeLabels[type] ?? type}</CardTitle></CardHeader>
                            <CardContent><p className="text-3xl font-bold">{count}</p></CardContent>
                        </Card>
                    ))}
                </div>

                <div className="grid gap-6 lg:grid-cols-2">
                    <Card>
                        <CardHeader><CardTitle className="text-base">Assets by Type</CardTitle></CardHeader>
                        <CardContent className="h-72">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart data={typeChartData}>
                                    <CartesianGrid strokeDasharray="3 3" />
                                    <XAxis dataKey="name" tick={{ fontSize: 12 }} />
                                    <YAxis allowDecimals={false} />
                                    <Tooltip />
                                    <Bar dataKey="count" fill="#047857" />
                                </BarChart>
                            </ResponsiveContainer>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader><CardTitle className="text-base">Confiscations by Municipality</CardTitle></CardHeader>
                        <CardContent className="h-72">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart data={municipalityChartData}>
                                    <CartesianGrid strokeDasharray="3 3" />
                                    <XAxis dataKey="name" tick={{ fontSize: 11 }} />
                                    <YAxis allowDecimals={false} />
                                    <Tooltip />
                                    <Bar dataKey="count" fill="#059669" />
                                </BarChart>
                            </ResponsiveContainer>
                        </CardContent>
                    </Card>
                </div>

                <Card>
                    <CardHeader><CardTitle className="text-base">Recent Activity</CardTitle></CardHeader>
                    <CardContent>
                        <div className="space-y-3">
                            {recentActivity.length === 0 && (
                                <p className="text-sm text-gray-500">No activity yet.</p>
                            )}
                            {recentActivity.map((entry) => (
                                <div key={entry.id} className="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-3">
                                    <div>
                                        <Link
                                            href={route('assets.show', entry.asset?.id)}
                                            className="font-medium text-emerald-800 hover:underline"
                                        >
                                            {entry.asset?.asset_code}
                                        </Link>
                                        <p className="text-sm text-gray-600">
                                            {entry.changed_by?.name} — {entry.notes}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <AssetStatusBadge
                                            status={entry.status}
                                            label={statusLabels[entry.status] ?? entry.status}
                                        />
                                        <p className="mt-1 text-xs text-gray-500">
                                            {new Date(entry.changed_at).toLocaleString()}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AuthenticatedLayout>
    );
}
