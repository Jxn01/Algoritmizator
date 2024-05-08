import React, { memo, useState } from 'react';
import Navbar from "./Navbar.jsx";
import Footer from "./Footer.jsx";
import Modal from 'react-modal';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle, faTimes } from '@fortawesome/free-solid-svg-icons';

Modal.setAppElement('body');

/**
 * Profile component
 *
 * This is a functional component that renders a user's profile page.
 * It uses React's memo function to optimize rendering by avoiding re-rendering when props haven't changed.
 * It also uses React's useState hook to manage the state of the user, form data, form errors, modal state, selected form, password strength, success message, and profile picture.
 *
 * @param {Object} props - The properties passed to the component
 * @param {string} props.title - The title of the page
 * @param {string} props.activeTab - The currently active tab in the navbar
 * @param {Object} props.user - The currently logged in user
 *
 * @returns {JSX.Element} The Profile component
 */
const Profile = memo(({ title, activeTab, user }) => {
    // State variables for the user, form data, form errors, modal state, selected form, password strength, success message, and profile picture
    const [currentUser, setCurrentUser] = useState(user);
    const [formData, setFormData] = useState({...user});
    const [formErrors, setFormErrors] = useState({});
    const [modalIsOpen, setModalIsOpen] = useState(false);
    const [selectedForm, setSelectedForm] = useState('');
    const [passwordStrength, setPasswordStrength] = useState(0);
    const [successMessage, setSuccessMessage] = useState('');
    const [profilePicture, setProfilePicture] = useState('/storage/' + user.avatar);

    // Function to handle the change of form inputs
    const handleChange = (e) => {
        const {name, value} = e.target;
        setFormData({
            ...formData,
            [name]: value
        });
        if (name === 'newPassword') {
            setPasswordStrength(calculatePasswordStrength(value));
        }
    };

    // Function to open the modal
    const openModal = (form) => {
        setSelectedForm(form);
        setModalIsOpen(true);
        setFormErrors({});
        setSuccessMessage('');
    };

    // Function to close the modal
    const closeModal = () => {
        setModalIsOpen(false);
        setSelectedForm('');
        setFormErrors({});
        setSuccessMessage('');
    };

    // Function to go back to the form selection
    const goBackToSelection = () => {
        setSelectedForm('');
        setFormErrors({});
        setSuccessMessage('');
    };

    // Function to validate the form
    const validateForm = () => {
        const errors = {};
        const emailRegex = /^[^\s@]+@inf\.elte.hu$/i;
        if (selectedForm === 'name' && !formData.name.trim()) errors.name = "A teljes név megadása kötelező.";
        if (selectedForm === 'username' && !formData.username.trim()) errors.username = "Felhasználónév megadása kötelező.";
        if (selectedForm === 'email'){
            if(!formData.email.trim())
                errors.email = "Az e-mail cím megadása kötelező.";
            if(!emailRegex.test(formData.email))
                errors.email = "Csak inf.elte.hu e-maileket fogadunk el.";
            if(!formData.password.trim())
                errors.password = "A jelszó megadása kötelező.";
        }
        if (selectedForm === 'password') {
            if (!formData.oldPassword.trim()) errors.oldPassword = "Az aktuális jelszó megadása kötelező.";
            if (!formData.newPassword.trim()) errors.newPassword = "Az új jelszó megadása kötelező.";
            if (formData.newPassword !== formData.confirmPassword) errors.confirmPassword = "A jelszavak nem egyeznek.";
        }
        return errors;
    };

    // Function to handle the change of the profile picture
    const handleImageChange = async (event) => {
        const file = event.target.files[0];
        const formData = new FormData();
        formData.append('avatar', file);

        axios.post('/algoritmizator/api/update-avatar', formData)
            .then(response => {
                setProfilePicture('/storage/' + response.data.avatar);
                alert("A profilkép módosítása sikeres.")
            })
            .catch(error => {
                console.log(error);
                alert("Hiba történt a profilkép módosítása során.");
            });
    };

    // Function to handle the form submission
    const handleSubmit = (event) => {
        event.preventDefault();
        const errors = validateForm();
        setFormErrors(errors);
        if (Object.keys(errors).length === 0) {
            if (selectedForm === 'password') {
                axios.post('/algoritmizator/api/update-password', {
                    oldPassword: formData.oldPassword,
                    password: formData.newPassword,
                }).then(response => {
                    setSuccessMessage("A jelszó módosítása sikeres.");
                }).catch(error => {
                    if(error.response.status === 400){
                        setFormErrors({oldPassword: "Hibás jelszó."});
                    }
                    if(error.response.status === 422){
                        setFormErrors({newPassword: "A jelszó nem felel meg a követelményeknek."});
                    }
                })
            }
            if (selectedForm === 'email') {
                axios.post('/algoritmizator/api/update-email', {
                    email: formData.email,
                    password: formData.password
                }).then(response => {
                    setSuccessMessage("Az e-mail cím módosítása sikeres.");
                }).catch(error => {
                    if(error.response.status === 401) {
                        setFormErrors({password: "Hibás jelszó."});
                    } else {
                        setFormErrors({email: "Az e-mail cím foglalt."});
                    }
                })
            }
            if (selectedForm === 'username') {
                axios.post('/algoritmizator/api/update-username', {
                    username: formData.username
                }).then(response => {
                    setSuccessMessage("A felhasználónév módosítása sikeres.");
                }).catch(error => {
                    setFormErrors({username: "A felhasználónév foglalt."});
                })
            }
            if (selectedForm === 'name') {
                axios.post('/algoritmizator/api/update-name', {
                    name: formData.name
                }).then(response => {
                    setSuccessMessage("A név módosítása sikeres.");
                }).catch(error => {
                    setFormErrors({name: "Hiba történt a módosítás során."});
                })
            }

            if (Object.keys(errors).length === 0) {
                setCurrentUser({
                    ...currentUser,
                    [selectedForm]: formData[selectedForm]
                });
            }
        }
    };

    // Function to calculate the strength of a password
    function calculatePasswordStrength(pass) {
        let strength = 0;
        if (pass.length >= 8) strength += 1;
        if (pass.match(/\d+/)) strength += 1;
        if (pass.match(/[a-z]/) && pass.match(/[A-Z]/)) strength += 1;
        if (pass.match(/[^a-zA-Z0-9]/)) strength += 1;
        return strength;
    }

    // Function to render the form
    const renderForm = () => {
        if (!selectedForm) {
            return renderSelectionButtons();
        }
        switch (selectedForm) {
            case 'name':
            case 'username':
                return renderTextField();
            case 'email':
                return renderEmailFields();
            case 'password':
                return renderPasswordFields();
            default:
                return null;
        }
    };

    // Function to render the selection buttons
    const renderSelectionButtons = () => (
        <>
            <button type="button" onClick={() => openModal('name')}
                    className="block w-full text-center bg-purple-700 py-2 rounded-md hover:bg-purple-800 text-white">Teljes
                név módosítása
            </button>
            <button type="button" onClick={() => openModal('username')}
                    className="block w-full text-center bg-purple-700 py-2 rounded-md hover:bg-purple-800 text-white">Felhasználónév
                módosítása
            </button>
            <button type="button" onClick={() => openModal('email')}
                    className="block w-full text-center bg-purple-700 py-2 rounded-md hover:bg-purple-800 text-white">E-mail
                cím módosítása
            </button>
            <button type="button" onClick={() => openModal('password')}
                    className="block w-full text-center bg-purple-700 py-2 rounded-md hover:bg-purple-800 text-white">Jelszó
                módosítása
            </button>
        </>
    );

    // Function to render the text field
    const renderTextField = () => (
        <div className="mb-4">
            <label htmlFor={selectedForm}
                   className="block text-white text-sm font-bold mb-2">
                {selectedForm === 'name' ? 'Teljes név' : 'Felhasználónév'}
                <FontAwesomeIcon icon={faQuestionCircle} className="ml-2 text-white" id="textTip"/>
                <ReactTooltip anchorSelect={'#textTip'} place="right" effect="solid">
                    {selectedForm === 'name' ? 'A teljes neved, amit a többi felhasználó látni fog.' : 'Az új felhasználóneved.'}
                </ReactTooltip>
            </label>

            <input
                type='text'
                name={selectedForm}
                value={formData[selectedForm]}
                onChange={handleChange}
                className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500"
            />
            {formErrors[selectedForm] && <p className="text-xs text-red-500">{formErrors[selectedForm]}</p>}
        </div>
    );

    // Function to render the email fields
    const renderEmailFields = () => (
        <>
            <div className="mb-4">
                <label htmlFor={selectedForm} className="block text-white text-sm font-bold mb-2">
                    'E-mail cím'
                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2 text-white" id="emailTip"/>
                    <ReactTooltip anchorSelect={'#emailTip'} place="right" effect="solid">
                        'Az inf.elte.hu-s e-mail címed.'
                    </ReactTooltip>
                </label>
                <input
                    autoComplete={'email'}
                    type='email'
                    name='email'
                    value={formData['email']}
                    onChange={handleChange}
                    className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500"
                />
                {formErrors['email'] && <p className="text-xs text-red-500">{formErrors['email']}</p>}
            </div>
            <div className="mb-4">
                <label htmlFor="password" className="block text-white text-sm font-bold mb-2">Régi jelszó
                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2 text-white" id="oldPassTip"/>
                    <ReactTooltip anchorSelect={'#oldPassTip'} place="right" effect="solid">
                        A jelenlegi jelszavad.
                    </ReactTooltip>
                </label>
                <input
                    autoComplete={'current-password'}
                    type="password"
                    name="password"
                    placeholder="Jelszó"
                    value={formData.password}
                    onChange={handleChange}
                    className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500"
                />
                {formErrors['password'] && <p className="text-xs text-red-500 mt-1">{formErrors['password']}</p>}
            </div>
        </>
    );

    // Function to render the password fields
    const renderPasswordFields = () => (
        <>
            <div className="mb-4">
                <label htmlFor="oldPassword" className="block text-white text-sm font-bold mb-2">Régi jelszó
                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2 text-white" id="oldPassTip"/>
                    <ReactTooltip anchorSelect={'#oldPassTip'} place="right" effect="solid">
                        A jelenlegi jelszavad.
                    </ReactTooltip>
                </label>
                <input
                    autoComplete={'current-password'}
                    type="password"
                    name="oldPassword"
                    placeholder="Régi jelszó"
                    value={formData.oldPassword}
                    onChange={handleChange}
                    className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500"
                />
                {formErrors['oldPassword'] && <p className="text-xs text-red-500 mt-1">{formErrors['oldPassword']}</p>}
            </div>
            <div className="mb-4">
                <label htmlFor="newPassword" className="block text-white text-sm font-bold mb-2">Új jelszó
                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2 text-white" id="newPassTip"/>
                    <ReactTooltip anchorSelect={'#newPassTip'} place="right" effect="solid">
                        Minimum 8 karakter hosszú, legalább egy kis- és nagybetűt, egy számot és egy speciális karaktert
                        tartalmazzon.
                    </ReactTooltip>
                </label>
                <input
                    autoComplete={'new-password'}
                    type="password"
                    name="newPassword"
                    placeholder="Új jelszó"
                    value={formData.newPassword}
                    onChange={handleChange}
                    className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500"
                />
                {formErrors['newPassword'] && <p className="text-xs text-red-500 mt-1">{formErrors['newPassword']}</p>}
            </div>
            <div className="mb-4">
                <label htmlFor="confirmPassword" className="block text-white text-sm font-bold mb-2">Jelszó megerősítése
                    <FontAwesomeIcon icon={faQuestionCircle} className="ml-2 text-white" id="newPassAgainTip"/>
                    <ReactTooltip anchorSelect={'#newPassAgainTip'} place="right" effect="solid">
                        A jelszó megerősítése.
                    </ReactTooltip>
                </label>
                <input
                    autoComplete={'new-password'}
                    type="password"
                    name="confirmPassword"
                    placeholder="Jelszó megerősítése"
                    value={formData.confirmPassword}
                    onChange={handleChange}
                    className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500"
                />
                {formErrors['confirmPassword'] &&
                    <p className="text-xs text-red-500 mt-1">{formErrors['confirmPassword']}</p>}
                {formData.newPassword && (
                    <div className="mt-2">
                        <div className="bg-gray-300 w-full h-2 rounded-full">
                            <div
                                className={`h-2 rounded-full ${passwordStrength === 1 ? 'bg-red-500' : passwordStrength === 2 ? 'bg-yellow-500' : passwordStrength === 3 ? 'bg-green-500' : passwordStrength === 4 ? 'bg-blue-500' : 'bg-gray-300'} w-${passwordStrength * 25}%`}></div>
                        </div>
                        <p className="text-xs text-gray-500 mt-1">Jelszó
                            erőssége: {["Nincs", "Gyenge", "Mérsékelt", "Erős", "Nagyon erős"][passwordStrength]}</p>
                    </div>
                )}
            </div>
        </>
    );

    // Render the Navbar, profile page, and Footer
    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={user}/>
            <div
                className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800">
                <div className="w-full max-w-4xl bg-gray-800 p-6 rounded-lg shadow-lg text-white space-y-4">
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <div className="relative inline-block">
                                <input
                                    type="file"
                                    onChange={handleImageChange}
                                    id="fileInput"
                                    className="hidden"
                                />
                                <img
                                    src={profilePicture}
                                    alt="Profile"
                                    className="w-32 h-32 rounded-full object-cover border-4 border-purple-800 cursor-pointer"
                                />
                                <div
                                    onClick={() => document.getElementById('fileInput').click()}
                                    className="overlay absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center rounded-full opacity-0 hover:opacity-100 transition-opacity duration-500 cursor-pointer">
                                    <span className="text-white">Megváltoztatás</span>
                                </div>
                            </div>

                            <h1 className="text-3xl font-bold">{currentUser.name}</h1>
                            <p className="text-xl">{currentUser.username}</p>
                            <p className="text-md">{currentUser.email}</p>
                            <p className="text-sm">Regisztráció
                                dátuma: {new Date(currentUser.created_at).toLocaleString('hu-HU', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}</p>
                            <p className="text-sm text-gray-500">ID: {currentUser.id}</p>
                        </div>
                        {/* Stats */}
                        <div>
                            <h2 className="text-2xl font-bold">Statisztikák</h2>
                            <p className="text-xl">Tapasztalatpontok: {currentUser.total_xp} XP</p>
                            <p className="text-xl">Szint: LVL {currentUser.level}</p>
                        </div>
                    </div>
                    <hr className={'border-purple-600 border-2 mx-auto'}/>
                    <div className="flex flex-col items-center justify-center">
                        <h2 className="text-2xl font-bold">Teljesített leckék</h2>
                        <p className="text-xl">Lecke 1</p>
                        <p className="text-xl">Lecke 1</p>
                        <p className="text-xl">Lecke 1</p>
                        <p className="text-xl">Lecke 1</p>
                    </div>
                    <hr className={'border-purple-600 border-2 mx-auto'}/>
                    <button onClick={() => setModalIsOpen(true)}
                            className="self-end px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Profiladatok
                        módosítása
                    </button>
                    <Modal
                        isOpen={modalIsOpen}
                        onRequestClose={closeModal}
                        className="bg-gray-800 p-6 rounded-lg outline-none mx-auto my-auto max-w-lg"
                        overlayClassName="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center">
                        <div className="flex justify-between items-center">
                            <h2 className="text-xl text-white font-bold mb-4">Profiladatok módosítása</h2>
                            <button onClick={closeModal} className="text-white mb-3 ml-3"><FontAwesomeIcon
                                icon={faTimes}/></button>
                        </div>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            {renderForm()}
                            <div className="flex justify-between">
                                {selectedForm && <button type="submit"
                                                         className="px-6 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900">Mentés</button>}
                                {selectedForm && <button onClick={goBackToSelection}
                                                         className="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Mégsem</button>}
                            </div>
                            {successMessage && <p className="text-green-500">{successMessage}</p>}
                        </form>
                    </Modal>
                </div>
            </div>
            <Footer/>
        </div>
    );
});

export default Profile;
