import React, { useState, useEffect, useRef, Suspense } from 'react';
import { Canvas, useFrame, useThree } from '@react-three/fiber';
import { OrbitControls, PerspectiveCamera, useGLTF, Environment, Text, Float, Stars } from '@react-three/drei';
import * as THREE from 'three';

// Main component
const Portfolio = () => {
  const [language, setLanguage] = useState('ar'); // 'ar' for Arabic, 'en' for English
  const [section, setSection] = useState('home');
  const [darkMode, setDarkMode] = useState(false);
  const [visitorCount, setVisitorCount] = useState(63);

  // Toggle language
  const toggleLanguage = () => {
    setLanguage(language === 'ar' ? 'en' : 'ar');
  };

  // Toggle dark mode
  const toggleDarkMode = () => {
    setDarkMode(!darkMode);
  };

  // Content based on language
  const content = {
    ar: {
      name: 'م. عبدالرحمن الهجلة',
      title: 'ماجستير ادارة هندسية',
      subtitle: 'خبرة مهنية احترافية',
      nav: {
        home: 'الرئيسية',
        cv: 'السيرة الذاتية',
        contact: 'اتصل بي',
      },
      home: {
        description: 'مجالات الاعمال (ادارة المشاريع، التطوير والتدريب، ادارة العمليات، دراسات المقارنات)',
        cta: 'اذا مهتم؟ تواصل وابشر بالخير',
        highlights: [
          'ماجستير في الادارة الهندسية',
          'تطوير اعمال - ادارة مشاريع',
          'استشارات استثماريه - استشارات تقنية - استشارات تطوير',
        ],
      },
      contact: {
        title: 'اتصل بي',
        subtitle: 'تحتاج الى المساعدة!؟',
        form: {
          name: 'الاسم',
          email: 'البريد الالكتروني*',
          message: 'الرسالة',
          send: 'ارسال',
        },
        info: {
          phone: 'الهاتف',
          phoneNumber: '+966557704697',
          email: 'البريد الالكتروني',
          emailAddress: 'engr.aalmutairi@gmail.com',
          address: 'العنوان',
          addressText: 'الرياض، المملكة العربية السعودية',
          follow: 'تابعني:',
        },
      },
      visitors: 'الزوار',
    },
    en: {
      name: 'Eng. Abdulrahman Almutairi',
      title: 'Master of Engineering Management',
      subtitle: 'Professional Expertise',
      nav: {
        home: 'Home',
        cv: 'CV',
        contact: 'Contact',
      },
      home: {
        description: 'Business Areas (Project Management, Development & Training, Operations Management, Comparative Studies)',
        cta: 'Interested? Contact me and I\'ll help you',
        highlights: [
          'Master\'s degree in Engineering Management',
          'Business Development - Project Management',
          'Investment Consulting - Technical Consulting - Development Consulting',
        ],
      },
      contact: {
        title: 'Contact Me',
        subtitle: 'Need assistance?',
        form: {
          name: 'Name',
          email: 'Email*',
          message: 'Message',
          send: 'Send',
        },
        info: {
          phone: 'Phone',
          phoneNumber: '+966557704697',
          email: 'Email',
          emailAddress: 'engr.aalmutairi@gmail.com',
          address: 'Address',
          addressText: 'Riyadh, Saudi Arabia',
          follow: 'Follow me:',
        },
      },
      visitors: 'Visitors',
    },
  };

  const mainStyle = {
    fontFamily: language === 'ar' ? '"DroidArabicKufiRegular", Arial, sans-serif' : 'Arial, sans-serif',
    direction: language === 'ar' ? 'rtl' : 'ltr',
    textAlign: language === 'ar' ? 'right' : 'left',
    color: darkMode ? '#fff' : '#333',
    backgroundColor: darkMode ? '#121212' : '#f5f5f5',
    minHeight: '100vh',
  };

  return (
    <div style={mainStyle} className="transition-colors duration-300">
      {/* Header */}
      <header className="fixed top-0 left-0 right-0 z-50 bg-opacity-90 backdrop-blur-md p-4 shadow-md" 
              style={{ backgroundColor: darkMode ? 'rgba(18, 18, 18, 0.9)' : 'rgba(255, 255, 255, 0.9)' }}>
        <div className="container mx-auto flex justify-between items-center">
          <div className="flex items-center">
            <img 
              src="/api/placeholder/60/60" 
              alt="Profile" 
              className="rounded-full w-12 h-12 mr-4 ml-4 object-cover border-2 border-blue-500"
            />
            <h1 className="text-xl font-bold">{content[language].name}</h1>
          </div>
          
          <nav>
            <ul className="flex space-x-6">
              <li>
                <button 
                  onClick={() => setSection('home')}
                  className={`px-3 py-2 rounded-md hover:bg-blue-500 hover:text-white transition ${section === 'home' ? 'bg-blue-500 text-white' : ''}`}
                >
                  {content[language].nav.home}
                </button>
              </li>
              <li>
                <a 
                  href="cv/cv.pdf" 
                  target="_blank" 
                  className="px-3 py-2 rounded-md hover:bg-blue-500 hover:text-white transition"
                >
                  {content[language].nav.cv}
                </a>
              </li>
              <li>
                <button 
                  onClick={() => setSection('contact')}
                  className={`px-3 py-2 rounded-md hover:bg-blue-500 hover:text-white transition ${section === 'contact' ? 'bg-blue-500 text-white' : ''}`}
                >
                  {content[language].nav.contact}
                </button>
              </li>
            </ul>
          </nav>
          
          <div className="flex items-center space-x-4">
            <button 
              onClick={toggleLanguage}
              className="px-3 py-1 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300 transition dark:bg-gray-700 dark:text-gray-200"
            >
              {language === 'ar' ? 'English' : 'العربية'}
            </button>
            
            <button 
              onClick={toggleDarkMode}
              className="w-10 h-10 rounded-full flex items-center justify-center transition"
              style={{ backgroundColor: darkMode ? '#f5f5f5' : '#333' }}
            >
              {darkMode ? (
                <span className="text-gray-800">☀️</span>
              ) : (
                <span className="text-white">🌙</span>
              )}
            </button>
          </div>
        </div>
      </header>

      {/* 3D Canvas Background */}
      <div className="fixed top-0 left-0 w-full h-full z-0">
        <Canvas>
          <PerspectiveCamera makeDefault position={[0, 0, 10]} />
          <ambientLight intensity={0.5} />
          <spotLight position={[10, 10, 10]} angle={0.15} penumbra={1} intensity={1} />
          <Suspense fallback={null}>
            <Environment preset="city" />
            <Stars radius={100} depth={50} count={5000} factor={4} saturation={0} fade speed={1} />
            
            {/* Floating 3D Shapes */}
            <Float speed={2} rotationIntensity={1} floatIntensity={1}>
              <mesh position={[5, 2, -10]} rotation={[0, 0, THREE.MathUtils.degToRad(45)]}>
                <boxGeometry args={[2, 2, 2]} />
                <meshStandardMaterial color={darkMode ? "#1E40AF" : "#3B82F6"} />
              </mesh>
            </Float>
            
            <Float speed={1.5} rotationIntensity={2} floatIntensity={1}>
              <mesh position={[-6, -3, -8]}>
                <sphereGeometry args={[1.5, 32, 32]} />
                <meshStandardMaterial color={darkMode ? "#4C1D95" : "#8B5CF6"} metalness={0.5} />
              </mesh>
            </Float>
            
            <Float speed={1} rotationIntensity={1.5} floatIntensity={1}>
              <mesh position={[8, -4, -12]}>
                <torusGeometry args={[1, 0.4, 16, 32]} />
                <meshStandardMaterial color={darkMode ? "#065F46" : "#10B981"} metalness={0.3} />
              </mesh>
            </Float>
          </Suspense>
          
          <OrbitControls enableZoom={false} enablePan={false} autoRotate autoRotateSpeed={0.5} />
        </Canvas>
      </div>

      {/* Main Content */}
      <main className="container mx-auto py-24 px-4 min-h-screen relative z-10">
        {section === 'home' && (
          <div className="mt-16">
            <div className="glass-panel p-8 rounded-xl backdrop-blur-md bg-opacity-20 shadow-xl mb-10"
                 style={{ backgroundColor: darkMode ? 'rgba(0, 0, 0, 0.4)' : 'rgba(255, 255, 255, 0.4)' }}>
              <h2 className="text-4xl font-bold mb-2">{content[language].name}</h2>
              <div className="text-xl mb-4 text-blue-600 dark:text-blue-400">{content[language].title}</div>
              <p className="text-lg mb-6">{content[language].subtitle}</p>
              <hr className="border-t border-gray-300 dark:border-gray-700 my-4" />
              <p className="text-xl mt-6">{content[language].home.description}</p>
              
              <div className="mt-8 p-4 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                <h3 className="text-2xl font-semibold mb-4">{content[language].home.cta}</h3>
              </div>
              
              <div className="mt-10">
                <h3 className="text-2xl font-semibold mb-4">
                  {language === 'ar' ? 'هنا ستجد كل ما تحتاجه بسهولة!' : 'Here you will find everything you need easily!'}
                </h3>
                <ul className="space-y-3">
                  {content[language].home.highlights.map((highlight, index) => (
                    <li key={index} className="flex items-start">
                      <span className="text-blue-500 mt-1 mr-2 ml-2">•</span>
                      <span>{highlight}</span>
                    </li>
                  ))}
                </ul>
              </div>
            </div>
            
            <div className="glass-panel p-6 rounded-xl backdrop-blur-md bg-opacity-20 shadow-xl"
                 style={{ backgroundColor: darkMode ? 'rgba(0, 0, 0, 0.4)' : 'rgba(255, 255, 255, 0.4)' }}>
              <div className="flex items-center">
                <div className="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center mr-4 ml-4">
                  <span className="text-white text-xl">👨‍💼</span>
                </div>
                <div>
                  <h3 className="text-lg font-semibold">{content[language].visitors}</h3>
                  <div className="text-2xl font-bold">{visitorCount}</div>
                </div>
              </div>
            </div>
          </div>
        )}

        {section === 'contact' && (
          <div className="mt-16">
            <div className="glass-panel p-8 rounded-xl backdrop-blur-md bg-opacity-20 shadow-xl"
                 style={{ backgroundColor: darkMode ? 'rgba(0, 0, 0, 0.4)' : 'rgba(255, 255, 255, 0.4)' }}>
              <h2 className="text-3xl font-bold mb-3">{content[language].contact.title}</h2>
              <p className="text-xl mb-8">{content[language].contact.subtitle}</p>
              
              <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div className="col-span-1">
                  <form className="space-y-4">
                    <div>
                      <label className="block mb-2">{content[language].contact.form.name}</label>
                      <input 
                        type="text" 
                        className="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800"
                        required 
                      />
                    </div>
                    <div>
                      <label className="block mb-2">{content[language].contact.form.email}</label>
                      <input 
                        type="email" 
                        className="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800"
                        required 
                      />
                    </div>
                    <div>
                      <label className="block mb-2">{content[language].contact.form.message}</label>
                      <textarea 
                        className="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800"
                        rows="6" 
                        required
                      ></textarea>
                    </div>
                    <button 
                      type="submit"
                      className="px-6 py-3 rounded-md bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"
                    >
                      {content[language].contact.form.send}
                    </button>
                  </form>
                </div>
                
                <div className="col-span-1">
                  <div className="space-y-6">
                    <div className="flex items-start">
                      <div className="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center mr-4 ml-4 mt-1">
                        <span className="text-white text-xl">📱</span>
                      </div>
                      <div>
                        <h3 className="text-lg font-semibold">{content[language].contact.info.phone}</h3>
                        <p className="text-lg" dir="ltr">{content[language].contact.info.phoneNumber}</p>
                      </div>
                    </div>
                    
                    <div className="flex items-start">
                      <div className="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center mr-4 ml-4 mt-1">
                        <span className="text-white text-xl">✉️</span>
                      </div>
                      <div>
                        <h3 className="text-lg font-semibold">{content[language].contact.info.email}</h3>
                        <p className="text-lg">{content[language].contact.info.emailAddress}</p>
                      </div>
                    </div>
                    
                    <div className="flex items-start">
                      <div className="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center mr-4 ml-4 mt-1">
                        <span className="text-white text-xl">📍</span>
                      </div>
                      <div>
                        <h3 className="text-lg font-semibold">{content[language].contact.info.address}</h3>
                        <p className="text-lg">{content[language].contact.info.addressText}</p>
                      </div>
                    </div>
                    
                    <div className="mt-8">
                      <h3 className="text-lg font-semibold mb-4">{content[language].contact.info.follow}</h3>
                      <div className="flex space-x-4">
                        <a href="#" className="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white hover:bg-blue-700 transition">
                          <span>f</span>
                        </a>
                        <a href="#" className="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white hover:bg-gray-800 transition">
                          <span>𝕏</span>
                        </a>
                        <a href="https://www.linkedin.com/in/abdulrahman-almutairi/" target="_blank" className="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center text-white hover:bg-blue-900 transition">
                          <span>in</span>
                        </a>
                        <a href="#" className="w-10 h-10 rounded-full bg-pink-600 flex items-center justify-center text-white hover:bg-pink-700 transition">
                          <span>ig</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        )}
      </main>

      {/* Footer */}
      <footer className="py-6 text-center relative z-10" style={{ 
        backgroundColor: darkMode ? 'rgba(0, 0, 0, 0.7)' : 'rgba(255, 255, 255, 0.7)',
        backdropFilter: 'blur(10px)'
      }}>
        <div className="container mx-auto">
          <p>© 2024 - {language === 'ar' ? 'جميع الحقوق محفوظة' : 'All Rights Reserved'} | {content[language].name}</p>
        </div>
      </footer>
    </div>
  );
};

export default Portfolio;