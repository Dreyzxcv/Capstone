import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Asset } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

interface DisposalsCreateProps {
    asset: Asset;
    disposalTypes: Array<{ value: string; label: string }>;
}

export default function DisposalsCreate({ asset, disposalTypes }: DisposalsCreateProps) {
    const { data, setData, post, processing, errors } = useForm({
        disposal_type: disposalTypes[0]?.value ?? '',
        requester_name: '',
        notes: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        if (confirm('Confirm disposal action? This cannot be undone.')) {
            post(route('disposals.store', asset.id));
        }
    };

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold text-gray-800">Process Disposal</h2>}>
            <Head title="Process Disposal" />

            <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <p className="mb-4 text-sm text-gray-600">
                    Asset: <strong>{asset.asset_code}</strong> ({asset.type})
                </p>

                <form onSubmit={submit} className="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div>
                        <Label htmlFor="disposal_type">Disposal Type</Label>
                        <select
                            id="disposal_type"
                            value={data.disposal_type}
                            onChange={(e) => setData('disposal_type', e.target.value)}
                            className="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                        >
                            {disposalTypes.map((t) => (
                                <option key={t.value} value={t.value}>{t.label}</option>
                            ))}
                        </select>
                        <InputError message={errors.disposal_type} />
                    </div>

                    {data.disposal_type === 'donation' && (
                        <div>
                            <Label htmlFor="requester_name">Requester / Donee Name</Label>
                            <Input
                                id="requester_name"
                                value={data.requester_name}
                                onChange={(e) => setData('requester_name', e.target.value)}
                                required
                            />
                            <InputError message={errors.requester_name} />
                        </div>
                    )}

                    <div>
                        <Label htmlFor="notes">Notes</Label>
                        <Input id="notes" value={data.notes} onChange={(e) => setData('notes', e.target.value)} />
                    </div>

                    <div className="flex gap-3">
                        <Button type="submit" disabled={processing}>Confirm Disposal</Button>
                        <Link href={route('assets.show', asset.id)}>
                            <Button type="button" variant="outline">Cancel</Button>
                        </Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
