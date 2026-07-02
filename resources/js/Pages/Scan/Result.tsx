import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { AssetStatusBadge } from '@/Components/shared/AssetStatusBadge';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Asset } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

interface ScanResultProps {
    asset: Asset;
    token: string;
}

export default function ScanResult({ asset, token }: ScanResultProps) {
    const { data, setData, post, processing } = useForm({
        token,
        scan_location_note: '',
    });

    function submit(e: FormEvent) {
        e.preventDefault();
        post(route('scan.store'));
    }

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold text-gray-800">Scan Result</h2>}>
            <Head title="Scan Result" />

            <div className="mx-auto max-w-lg space-y-4 px-4 sm:px-6 lg:px-8">
                <div className="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                    <p className="font-medium text-emerald-900">Valid QR code</p>
                    <p className="text-sm text-emerald-800">{asset.asset_code}</p>
                    <div className="mt-2">
                        <AssetStatusBadge status={asset.current_status} label={asset.current_status.replace(/_/g, ' ')} />
                    </div>
                </div>

                <form onSubmit={submit} className="space-y-4 rounded-lg border border-gray-200 bg-white p-4">
                    <div>
                        <Label htmlFor="scan_location_note">Location Note (optional)</Label>
                        <Input
                            id="scan_location_note"
                            value={data.scan_location_note}
                            onChange={(e) => setData('scan_location_note', e.target.value)}
                        />
                    </div>
                    <Button type="submit" disabled={processing} className="w-full">
                        Log Scan
                    </Button>
                </form>

                <Link href={route('assets.show', asset.id)}>
                    <Button variant="outline" className="w-full">View Full Asset Record</Button>
                </Link>
            </div>
        </AuthenticatedLayout>
    );
}
