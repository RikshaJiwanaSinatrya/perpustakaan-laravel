export default function TextInput({ label, id, error, className = 'py-3', ...props }) {
    return (
        <div>
            {label && (
                <label htmlFor={id} className="mb-1.5 block text-sm font-medium text-stone-700">
                    {label}
                </label>
            )}
            <input
                id={id}
                {...props}
                className={`w-full rounded-xl border border-stone-300 px-4 ${className} text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200`}
            />
            {error && <p className="mt-1 text-xs font-medium text-rose-600">{error}</p>}
        </div>
    );
}
