// resources/js/components/NotFound.jsx

import React from 'react';

const NotFound = () => {
    return (
        <div className="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
            <div className="max-w-lg w-full bg-white shadow-md rounded-lg p-8">
                <h1 className="text-4xl text-red-500 font-bold mb-4">404 - Page Not Found</h1>
                <p className="text-lg text-gray-700 mb-4">
                    The page you're looking for doesn't exist or has been moved.
                </p>
                <a href="/" className="text-blue-500 hover:text-blue-700">Go back to homepage</a>
            </div>
        </div>
    );
};

export default NotFound;
