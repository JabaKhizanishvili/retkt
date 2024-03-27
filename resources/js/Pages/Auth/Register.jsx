import { useEffect, useState } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Register() {
    const [userType, setUserType] = useState(1);
    const { data, setData, post, processing, errors, reset, progress } = useForm({
        name: '',
        email: '',
        type: '',
        password: '',
        password_confirmation: '',
        id_front_img: '',
        id_back_img: '',
        phone: '',
        id_number: '',
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const handleFileChange = (e, key) => {
        setData(key, e.target.files[0]);
    };

    const submit = (e) => {
        e.preventDefault();
        data['type'] = userType;
        const userData = { ...data };
        post(route('register'), userData, { forceFormData: true });
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit}>
                <div>
                    <div className='mb-4 flex justify-around'>
                        <label className="inline-flex items-center">
                            <input
                                type="radio"
                                value="buyer"
                                checked={userType === 1}
                                onChange={() => setUserType(1)}
                            />
                            <span className="ml-2">Register as Buyer</span>
                        </label>
                        <label className="inline-flex items-center ml-4">
                            <input
                                type="radio"
                                value="seller"
                                checked={userType === 2}
                                onChange={() => setUserType(2)}
                            />
                            <span className="ml-2">Register as Seller</span>
                        </label>
                    </div>

                    <InputLabel htmlFor="name" value="Name" />
                    <TextInput
                        id="name"
                        name="name"
                        value={data.name}
                        className="mt-1 block w-full"
                        autoComplete="name"
                        isFocused={true}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                    />
                    <InputError message={errors.name} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        required
                    />
                    <InputError message={errors.email} className="mt-2" />
                </div>

                {userType === 2 && (
                    <>
                        <div className="mt-4">
                            <InputLabel htmlFor="id_front_img" value="ID Front" />
                            <input
                                type="file"
                                id="id_front_img"
                                name="id_front_img"
                                className="mt-1 block w-full"
                                onChange={(e) => handleFileChange(e, 'id_front_img')}
                            />
                            <InputError message={errors.id_front_img} className="mt-2" />
                            {progress && (
                                <progress value={progress.percentage} max="100">
                                    {progress.percentage}%
                                </progress>
                            )}
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="id_back_img" value="ID Back" />
                            <input
                                type="file"
                                id="id_back_img"
                                name="id_back_img"
                                className="mt-1 block w-full"
                                onChange={(e) => handleFileChange(e, 'id_back_img')}
                            />
                            <InputError message={errors.id_back_img} className="mt-2" />
                            {progress && (
                                <progress value={progress.percentage} max="100">
                                    {progress.percentage}%
                                </progress>
                            )}
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="phone" value="Phone" />
                            <TextInput
                                id="phone"
                                name="phone"
                                value={data.phone}
                                className="mt-1 block w-full"
                                autoComplete="phone"
                                onChange={(e) => setData('phone', e.target.value)}
                                required
                            />
                            <InputError message={errors.phone} className="mt-2" />
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="id_number" value="ID Number" />
                            <TextInput
                                id="id_number"
                                name="id_number"
                                value={data.id_number}
                                className="mt-1 block w-full"
                                autoComplete="id_number"
                                onChange={(e) => setData('id_number', e.target.value)}
                                required
                            />
                            <InputError message={errors.id_number} className="mt-2" />
                        </div>
                    </>
                )}

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                        required
                    />
                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password_confirmation" value="Confirm Password" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                        required
                    />
                    <InputError message={errors.password_confirmation} className="mt-2" />
                </div>

                <div className="flex items-center justify-end mt-4">
                    <Link
                        href={route('login')}
                        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton className="ms-4" disabled={processing}>
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
