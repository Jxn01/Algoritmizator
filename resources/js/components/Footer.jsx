import React, { memo } from 'react';

/**
 * Footer component
 *
 * This component displays a footer section with the author's information and the current year.
 * It is styled using TailwindCSS classes.
 * @returns {JSX.Element} Footer component
 */
const Footer = memo(() => {
    return (
        <footer className="bg-gray-800 text-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="py-8 flex justify-between items-center">
                    {/* Author's information */}
                    <div>
                        <p className="text-sm">Készítette: Oláh Norbert (PST8RA)</p>
                        <p className="text-sm">
                            Email: <a href="mailto:pst8ra@inf.elte.hu" className="underline">pst8ra@inf.elte.hu</a>
                        </p>
                    </div>

                    {/* Current year */}
                    <div>
                        <p>{new Date().getFullYear()} Algoritmizátor</p>
                    </div>
                </div>
            </div>
        </footer>
    );
});

export default Footer;
