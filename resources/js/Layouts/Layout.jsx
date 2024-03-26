import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import Header from '../Components/Header';

export default function Layout({ children }) {
    return (
        <>
            <Header/>
            {children}
        </>
    );
}
