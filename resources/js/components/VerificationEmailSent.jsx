import React, { memo } from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import axios from 'axios';

/**
 * VerificationEmailSent component
 *
 * This is a functional component that renders a page informing the user that a verification email has been sent.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also provides a function to resend the verification email.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The VerificationEmailSent component
 */
const VerificationEmailSent = memo(({ title, activeTab}) => {
    /**
     * handleResendEmail function
     *
     * This function sends a POST request to the server to resend the verification email.
     * It alerts the user whether the email was successfully sent or not.
     */
    const handleResendEmail = () => {
        axios.post('/algoritmizator/api/email-verification-notification')
            .then(response => {
                alert('E-mail sikeresen újraküdve!');
            })
            .catch(error => {
                alert('E-mail újraküldés sikertelen.');
                console.error('There was an error!', error);
            });
    };

    // Render the Navbar, verification email sent page, and Footer
    return (
        <div>
            <Navbar title={title} activeTab={activeTab}/>
            <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-md text-center">
                    <div className="flex flex-col items-center mb-8">
                        <img src="/algoritmizator/storage/logo.png" alt="Logo"
                             className="h-16 w-16 rounded-full mb-5 object-cover border-2 border-purple-800"/>
                        <h2 className="text-3xl font-bold text-white mb-2">Erősítse meg az e-mail címét</h2>
                    </div>
                    <div className="px-8 py-6 bg-gray-800 shadow-lg rounded-lg">
                        <h3 className="text-2xl font-bold text-center text-white mb-4">Megerősítő e-mail elküldve</h3>
                        <p className="text-lg text-gray-300 mb-4">Kérjük, ellenőrizze e-mail címét, hogy hitelesíthesse fiókját és befejezhesse a regisztrációs folyamatot.</p>
                        <button onClick={handleResendEmail} className="px-6 py-2 m-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Újraküldés</button>
                        <a href="/algoritmizator/app" className="px-6 py-2 m-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Tovább a főoldalra</a>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
});

export default VerificationEmailSent;
