import React, {memo, useState} from 'react';
import Modal from 'react-modal';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import { Tooltip as ReactTooltip } from 'react-tooltip';
import Footer from "./Footer.jsx";
import Navbar from "./Navbar.jsx";

Modal.setAppElement('body');

const Profile = memo(({title, activeTab, navUser}) => {
        const initialUser = {
            fullName: "Példa Béla",
            username: "pldbla",
            email: "pelda.bela@inf.elte.hu",
            oldPassword: '',
            newPassword: '',
            confirmPassword: '',
            registrationDate: "Regisztráció dátuma: 2020-05-15",
            experience: 4500,
            level: 27,
            completedLessons: [
                { title: "Bevezetés a Reactba", date: "2021-01-20" },
                { title: "Haladó CSS a Tailwinddel", date: "2021-02-15" },
                { title: "Állapotkezelés Reactban", date: "2021-03-10" }
            ]
        };

        const [user, setUser] = useState(initialUser);
        const [formData, setFormData] = useState({ ...initialUser });
        const [formErrors, setFormErrors] = useState({});
        const [modalIsOpen, setModalIsOpen] = useState(false);
        const [notificationModalOpen, setNotificationModalOpen] = useState(false);
        const [notificationMessage, setNotificationMessage] = useState('');
        const [currentField, setCurrentField] = useState('');

        const handleChange = (e) => {
            const { name, value } = e.target;
            setFormData({
                ...formData,
                [name]: value
            });
        };

        const validateForm = () => {
            const errors = {};
            const emailRegex = /^[^\s@]+@inf\.elte\.hu$/i;
            if (!formData.fullName && currentField === 'név') errors.fullName = "A teljes név megadása kötelező.";
            if (!formData.username && currentField === 'felhasználónév') errors.username = "Felhasználónév megadása kötelező.";
            if (!formData.email && currentField === 'email') errors.email = "Az e-mail cím megadása kötelező.";
            else if (!emailRegex.test(formData.email) && currentField === 'email') errors.email = "Az e-mail cím formátuma nem megfelelő. Csak inf.elte.hu címek elfogadottak.";
            if (!formData.oldPassword && currentField === 'password') errors.oldPassword = "Az aktuális jelszó megadása kötelező.";
            if (!formData.newPassword && currentField === 'password') errors.newPassword = "Az új jelszó megadása kötelező.";
            if (formData.newPassword !== formData.confirmPassword && currentField === 'password') errors.confirmPassword = "A jelszavak nem egyeznek.";
            return errors;
        };

        const handleSubmit = (event) => {
            event.preventDefault();
            const errors = validateForm();
            setFormErrors(errors);
            if (Object.keys(errors).length === 0) {
                setUser({
                    ...user,
                    [currentField]: formData[currentField]
                });
                setModalIsOpen(false);
                const message = (currentField === 'email' || currentField === 'password') ?
                    "Az ellenőrző e-mailt elküldtük. Kérjük, ellenőrizze e-mailjét a változások ellenőrzéséhez." :
                    "A módosítások sikeresen elmentve.";
                setNotificationMessage(message);
                setNotificationModalOpen(true);
            }
        };

        const openModal = (field) => {
            setCurrentField(field);
            setModalIsOpen(true);
        };

        const closeModal = () => {
            setModalIsOpen(false);
            setFormErrors({});
        };

        const closeNotificationModal = () => {
            setNotificationModalOpen(false);
        };

    return (
        <div>
            <Navbar title={title} activeTab={activeTab} user={navUser}/>
            <div className="flex flex-col justify-between min-h-screen p-10 text-white" style={{ background: 'linear-gradient(#363291, #4742be)' }}>
                <div className="flex justify-between items-start gap-8">
                    <div className="bg-gray-800 p-6 rounded-lg">
                        <img src="https://via.placeholder.com/100" alt="Profil" className="w-32 h-32 rounded-full mb-4"/>
                        <div>
                            <h1 className="text-3xl font-bold">{user.fullName}</h1>
                            <p className="text-xl">{user.username}</p>
                            <p className="text-md">{user.email}</p>
                            <p className="text-sm">{user.registrationDate}</p>
                        </div>
                    </div>
                    <div className="bg-gray-800 p-6 rounded-lg">
                        <h2 className="text-2xl font-bold">Statisztikák</h2>
                        <p className="text-xl">Tapasztalatpontok: {user.experience}</p>
                        <p className="text-xl">Szint: {user.level}</p>
                    </div>
                </div>
                <div className="bg-gray-800 p-6 rounded-lg">
                    <h2 className="text-2xl font-bold">Befejezett leckék</h2>
                    <ul>
                        {user.completedLessons.map((lesson, index) => (
                            <li key={index}>{lesson.title} - {lesson.date}</li>
                        ))}
                    </ul>
                </div>
                <div className="flex justify-center space-x-4 mt-8">
                    <button onClick={() => openModal('név')}
                            className="px-6 py-2 bg-gray-800 rounded-lg hover:bg-purple-700">Név módosítása
                    </button>

                    <button onClick={() => openModal('felhasználónév')}
                            className="px-6 py-2 bg-gray-800 rounded-lg hover:bg-purple-700">Felhasználónév módosítása
                    </button>

                    <button onClick={() => openModal('e-mail')}
                            className="px-6 py-2 bg-gray-800 rounded-lg hover:bg-purple-700">E-mail cím módosítása
                    </button>

                    <button onClick={() => openModal('jelszó')}
                            className="px-6 py-2 bg-gray-800 rounded-lg hover:bg-purple-700">Jelszó módosítása
                    </button>

                </div>
                <Modal
                    isOpen={modalIsOpen}
                    onRequestClose={closeModal}
                    className="bg-gray-800 p-6 rounded-lg outline-none"
                    overlayClassName="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <form onSubmit={handleSubmit} className="w-full max-w-md">
                        <h2 className="text-3xl font-bold mb-6 text-white">{currentField.charAt(0).toUpperCase() + currentField.slice(1)} módosítása</h2>
                        {
                            currentField === 'password' ? (
                                <>
                                    <div className="mb-4">
                                        <label htmlFor="oldPassword" className="block text-sm font-bold mb-2 text-white">
                                            Jelenlegi jelszó:
                                            <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="oldPasswordTip"/>
                                            <ReactTooltip anchorSelect={'#oldPasswordTip'} place="right" effect="solid">
                                                Add meg a jelenlegi jelszavad.
                                            </ReactTooltip>
                                        </label>
                                        <input
                                            type="password"
                                            name="oldPassword"
                                            id="oldPassword"
                                            value={formData.oldPassword}
                                            onChange={handleChange}
                                            className="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                        />
                                        {formErrors.oldPassword && <p className="text-xs text-red-500 mt-1">{formErrors.oldPassword}</p>}
                                    </div>

                                    <div className="mb-4">
                                        <label htmlFor="newPassword" className="block text-sm font-bold mb-2 text-white">
                                            Új jelszó:
                                            <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="newPasswordTip"/>
                                            <ReactTooltip anchorSelect={'#newPasswordTip'} place="right" effect="solid">
                                                Add meg az új jelszavad.
                                            </ReactTooltip>
                                        </label>
                                        <input
                                            type="password"
                                            name="newPassword"
                                            id="newPassword"
                                            value={formData.newPassword}
                                            onChange={handleChange}
                                            className="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                        />
                                        {formErrors.newPassword && <p className="text-xs text-red-500 mt-1">{formErrors.newPassword}</p>}
                                    </div>

                                    <div className="mb-4">
                                        <label htmlFor="confirmPassword" className="block text-sm font-bold mb-2 text-white">
                                            Új jelszó megerősítése:
                                            <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id="confirmPasswordTip"/>
                                            <ReactTooltip anchorSelect={'#confirmPasswordTip'} place="right" effect="solid">
                                                Add meg az új jelszavad újra.
                                            </ReactTooltip>
                                        </label>
                                        <input
                                            type="password"
                                            name="confirmPassword"
                                            id="confirmPassword"
                                            value={formData.confirmPassword}
                                            onChange={handleChange}
                                            className="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                        />
                                        {formErrors.confirmPassword && <p className="text-xs text-red-500 mt-1">{formErrors.confirmPassword}</p>}
                                    </div>
                                </>
                            ) : (
                                <div className="mb-4">
                                    <label htmlFor={currentField} className="block text-sm font-bold mb-2 text-white">
                                        {currentField.charAt(0).toUpperCase() + currentField.slice(1)}:
                                        <FontAwesomeIcon icon={faQuestionCircle} className="ml-2" id={currentField + 'Tip'}/>
                                        <ReactTooltip anchorSelect={'#' + currentField + 'Tip'} place="right" effect="solid">
                                            Új {currentField} megadása.
                                        </ReactTooltip>
                                    </label>
                                    <input
                                        type={currentField === 'email' ? 'email' : 'text'}
                                        name={currentField}
                                        id={currentField}
                                        value={formData[currentField]}
                                        onChange={handleChange}
                                        className="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-700 text-white"
                                    />
                                    {formErrors[currentField] && <p className="text-xs text-red-500 mt-1">{formErrors[currentField]}</p>}
                                </div>
                            )
                        }

                        <div className="flex justify-between mt-4">
                            <button type="submit"
                                    className="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded">Mentés
                            </button>
                            <button onClick={closeModal}
                                    className="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">Mégsem
                            </button>
                        </div>
                    </form>
                </Modal>
                <Modal
                    isOpen={notificationModalOpen}
                    onRequestClose={closeNotificationModal}
                    className="bg-gray-800 p-6 rounded-lg outline-none"
                    overlayClassName="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="text-center">
                        <h2 className="text-xl font-bold mb-4 text-white">{notificationMessage}</h2>
                        <button onClick={closeNotificationModal}
                                className="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded">Bezárás
                        </button>
                    </div>
                </Modal>
            </div>
            <Footer />
        </div>
    );
});

export default Profile;
