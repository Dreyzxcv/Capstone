import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function documentUrl(path: string | null | undefined): string | null {
    if (!path) return null;
    return route('documents.download', { path: btoa(path) });
}
