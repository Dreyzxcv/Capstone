import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { QrScanner } from '@/Components/shared/QrScanner';
import { Head } from '@inertiajs/react';

export default function ScanIndex() {
    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold text-gray-800">QR Scanner</h2>}
        >
            <Head title="Scan QR" />

            <div className="mx-auto max-w-lg px-4 sm:px-6 lg:px-8">
                <p className="mb-4 text-sm text-gray-600">
                    Point your camera at an asset QR code. You will be redirected to the asset record.
                </p>
                <QrScanner />
            </div>
        </AuthenticatedLayout>
    );
}
