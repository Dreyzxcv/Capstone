import { Html5QrcodeScanner } from 'html5-qrcode';
import { useEffect, useRef } from 'react';

export function QrScanner() {
    const scannerRef = useRef<Html5QrcodeScanner | null>(null);

    useEffect(() => {
        const scanner = new Html5QrcodeScanner(
            'qr-reader',
            { fps: 10, qrbox: { width: 250, height: 250 } },
            false,
        );

        scanner.render(
            (decodedText) => {
                if (decodedText.startsWith('http')) {
                    window.location.href = decodedText;
                }
            },
            () => {},
        );

        scannerRef.current = scanner;

        return () => {
            scanner.clear().catch(() => {});
        };
    }, []);

    return (
        <div className="overflow-hidden rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
            <div id="qr-reader" className="w-full" />
        </div>
    );
}
