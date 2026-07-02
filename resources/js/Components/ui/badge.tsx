import { cn } from '@/lib/utils';

const variants: Record<string, string> = {
    default: 'bg-gray-100 text-gray-800',
    blue: 'bg-blue-100 text-blue-800',
    amber: 'bg-amber-100 text-amber-800',
    green: 'bg-emerald-100 text-emerald-800',
    gray: 'bg-gray-200 text-gray-700',
};

export function Badge({
    className,
    variant = 'default',
    ...props
}: React.HTMLAttributes<HTMLSpanElement> & { variant?: string }) {
    return (
        <span
            className={cn(
                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                variants[variant] ?? variants.default,
                className,
            )}
            {...props}
        />
    );
}
