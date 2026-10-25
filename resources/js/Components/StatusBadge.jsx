import { labelStatus, classStatus } from '../lib/format';

export default function StatusBadge({ status }) {
    return (
        <span className={`rounded-full px-2.5 py-0.5 text-xs font-bold ${classStatus(status)}`}>
            {labelStatus(status)}
        </span>
    );
}
