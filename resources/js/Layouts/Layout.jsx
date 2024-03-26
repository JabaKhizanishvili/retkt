import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import Header from '../Components/Header';
import Footer from '@/Components/Footer';

export default function Layout({ children }) {
    return (
        <>
            <Header />
            <div className='min-h-screen'>
                <div className="container mx-auto px-20">
                  {children}
                </div>

            </div>
            <Footer/>
        </>
    );
}
