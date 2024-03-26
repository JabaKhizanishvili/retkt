import { Link, Head } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    const renderHTML = (rawHTML) => React.createElement("div", { dangerouslySetInnerHTML: { __html: rawHTML } });
    const handleImageError = () => {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    return (
        <>
            <Layout>

            </Layout>

        </>
    );
}
