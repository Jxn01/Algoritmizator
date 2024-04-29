import React, {memo} from 'react';

const Footer = memo(() => {
    return (
        <footer className="bg-gray-800 text-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="py-8 flex justify-between items-center">
                    <div>
                        <p className="text-sm">Készítette: Oláh Norbert (PST8RA)</p>
                        <p className="text-sm">Email: <a href="mailto:pst8ra@inf.elte.hu" className="underline">pst8ra@inf.elte.hu</a></p>
                    </div>
                    <div>
                        <p>{new Date().getFullYear()} Algoritmizátor</p>
                    </div>
                </div>
            </div>
        </footer>
    );
});

export default Footer;
