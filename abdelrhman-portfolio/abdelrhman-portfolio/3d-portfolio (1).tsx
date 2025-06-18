import React, { useState, useEffect, useRef, Suspense } from 'react';
import { Canvas, useFrame } from '@react-three/fiber';
import { OrbitControls, PerspectiveCamera, Text, Float, Stars } from '@react-three/drei';
import * as THREE from 'three';

// 3D Text component with glow effect
const GlowingText = ({ position, rotation, text, size, color, glowColor, glowIntensity = 0.5 }) => {
  const textRef = useRef();
  
  useFrame((state) => {
    if (textRef.current) {
      textRef.current.material.color.lerp(
        new THREE.Color(color).multiplyScalar(1 + Math.sin(state.clock.elapsedTime) * 0.2 * glowIntensity), 
        0.1
      );
    }
  });

  return (
    <Text
      ref={textRef}
      position={position}
      rotation={rotation}
      fontSize={size}
      color={color}
      font="/fonts/Tajawal-Bold.ttf"
      maxWidth={10}
      textAlign="center"
      anchorX="center"
      anchorY="middle"
    >
      {text}
    </Text>
  );
};

// Animated 3D shape
const AnimatedShape = ({ geometry, position, color, speed = 1, rotationFactor = 1 }) => {
  const meshRef = useRef();
  
  useFrame((state) => {
    if (meshRef.current) {
      meshRef.current.rotation.x = Math.sin(state.clock.elapsedTime * speed * 0.4) * 0.3 * rotationFactor;
      meshRef.current.rotation.y += 0.01 * speed;
      meshRef.current.rotation.z = Math.cos(state.clock.elapsedTime * speed * 0.3) * 0.2 * rotationFactor;
    }
  });

  return (
    <mesh ref={meshRef} position={position}>
      {geometry}
      <meshStandardMaterial 
        color={color} 
        metalness={0.5} 
        roughness={0.2}
      />
    </mesh>
  );
};

// 3D Scene Component
const Scene = ({ language, section, darkMode }) => {
  // Content based on language
  const content = {
    ar: {
      name: 'م. عبدالرحمن الهجلة',
      title: 'ماجستير ادارة هندسية',
      expertise: [
        'إدارة المشاريع',
        'التطوير والتدريب', 
        'الاستشارات التقنية',
        'دراسات المقارنات'
      ]
    },
    en: {
      name: 'Eng. Abdulrahman Almutairi',
      title: 'Master of Engineering Management',
      expertise: [
        'Project Management',
        'Development & Training',
        'Technical Consulting',
        'Comparative Studies'
      ]
    }
  };

  const renderSection = () => {
    if (section === 'home') {
      return (
        <>
          {/* Main title */}
          <GlowingText
            position={[0, 2, 0]}
            text={content[language].name}
            size={0.8}
            color={darkMode ? "#ffffff" : "#2563eb"}
            glowColor={darkMode ? "#3b82f6" : "#1e40af"}
            glowIntensity={0.6}
          />
          
          {/* Subtitle */}
          <GlowingText
            position={[0, 1, 0]}
            text={content[language].title}
            size={0.5}
            color={darkMode ? "#93c5fd" : "#1d4ed8"}
            glowIntensity={0.4}
          />
          
          {/* Floating expertise items */}
          {content[language].expertise.map((item, index) => (
            <Float 
              key={index}
              speed={(1 + index * 0.3)} 
              rotationIntensity={0.5} 
              floatIntensity={2}
              position={[
                Math.cos(index * Math.PI / 2) * 4,
                -1,
                Math.sin(index * Math.PI / 2) * 4
              ]}
            >
              <Text
                fontSize={0.4}
                color={darkMode ? "#f0f9ff" : "#1e3a8a"}
                font="/fonts/Tajawal-Medium.ttf"
                anchorX="center"
                anchorY="middle"
              >
                {item}
              </Text>
            </Float>
          ))}
        </>
      );
    } else if (section === 'contact') {
      return (
        <>
          <GlowingText
            position={[0, 2, 0]}
            text={language === 'ar' ? 'اتصل بي' : 'Contact Me'}
            size={0.8}
            color={darkMode ? "#ffffff" : "#2563eb"}
            glowIntensity={0.6}
          />
          
          <GlowingText
            position={[0, 1, 0]}
            text="engr.aalmutairi@gmail.com"
            size={0.4}
            color={darkMode ? "#93c5fd" : "#1d4ed8"}
            glowIntensity={0.3}
          />
          
          <GlowingText
            position={[0, 0.2, 0]}
            text="+966557704697"
            size={0.4}
            color={darkMode ? "#93c5fd" : "#1d4ed8"}
            glowIntensity={0.3}
          />
          
          <GlowingText
            position={[0, -0.6, 0]}
            text={language === 'ar' ? 'الرياض، المملكة العربية السعودية' : 'Riyadh, Saudi Arabia'}
            size={0.4}
            color={darkMode ? "#93c5fd" : "#1d4ed8"}
            glowIntensity={0.3}
          />
        </>
      );
    }
    
    return null;
  };

  return (
    <>
      <ambientLight intensity={0.5} />
      <directionalLight position={[10, 10, 5]} intensity={1} />
      <pointLight position={[-10, -10, -10]} intensity={0.5} />
      
      {/* Background stars */}
      <Stars radius={100} depth={50} count={5000} factor={4} saturation={0} fade speed={1} />
      
      {/* Animated 3D shapes in background */}
      <AnimatedShape 
        geometry={<boxGeometry args={[1.5, 1.5, 1.5]} />} 
        position={[6, 3, -10]} 
        color={darkMode ? "#3b82f6" : "#1d4ed8"} 
        speed={0.7}
      />
      
      <AnimatedShape 
        geometry={<sphereGeometry args={[1, 32, 32]} />} 
        position={[-6, -2, -8]} 
        color={darkMode ? "#8b5cf6" : "#5b21b6"} 
        speed={1.2}
      />
      
      <AnimatedShape 
        geometry={<torusGeometry args={[1, 0.4, 16, 32]} />} 
        position={[7, -4, -12]} 
        color={darkMode ? "#10b981" : "#047857"} 
        speed={0.9}
      />
      
      <AnimatedShape 
        geometry={<octahedronGeometry args={[1]} />} 
        position={[-5, 4, -9]} 
        color={darkMode ? "#f97316" : "#c2410c"} 
        speed={1.5}
      />
      
      {/* Content based on active section */}
      {renderSection()}
      
      <OrbitControls 
        enableZoom={false} 
        enablePan={false} 
        autoRotate 
        autoRotateSpeed={0.5} 
        minPolarAngle={Math.PI / 3} 
        maxPolarAngle={Math.PI / 1.5}
      />
    </>
  );
};

// Main Portfolio Component
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
  const uiContent = {
    ar: {
      name: 'م. عبدالرحمن الهجلة',
      title: 'ماجستير ادارة هندسية',
      subtitle: 'خبرة مهنية احترافية',
      nav: {
        home: 'الرئيسية',
        cv: 'السيرة الذاتية',
        contact: 'اتصل بي',
      },
      areas: 'مجالات الاعمال',
      expertiseAreas: [
        'ادارة المشاريع',
        'التطوير والتدريب',
        'ادارة العمليات',
        'دراسات المقارنات'
      ],
      contactInfo: {
        title: 'بيانات الاتصال',
        phone: 'الهاتف:',
        email: 'البريد الالكتروني:',
        address: 'العنوان:',
        addressText: 'الرياض، المملكة العربية السعودية',
        follow: 'تابعني:',
      },
      visitors: 'الزوار',
      footer: 'حقوق النشر والتصميم © 2024 - جميع الحقوق محفوظة'
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
      areas: 'Business Areas',
      expertiseAreas: [
        'Project Management',
        'Development & Training',
        'Operations Management',
        'Comparative Studies'
      ],
      contactInfo: {
        title: 'Contact Information',
        phone: 'Phone:',
        email: 'Email:',
        address: 'Address:',
        addressText: 'Riyadh, Saudi Arabia',
        follow: 'Follow me:',
      },
      visitors: 'Visitors',
      footer: 'Copyright © 2024 - All Rights Reserved'
    },
  };

  const mainStyle = {
    fontFamily: language === 'ar' ? '"Tajawal", Arial, sans-serif' : 'Arial, sans-serif',
    direction: language === 'ar' ? 'rtl' : 'ltr',
    textAlign: language === 'ar' ? 'right' : 'left',
    color: darkMode ? '#fff' : '#333',
    backgroundColor: darkMode ? '#121212' : '#f5f5f5',
    minHeight: '100vh',
  };
  
  // Add font styles for Arabic and English
  useEffect(() => {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap';
    document.head.appendChild(link);
    
    return () => {
      document.head.removeChild(link);
    };
  }, []);

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
            <h1 className="text-xl font-bold">{uiContent[language].name}</h1>
          </div>
          
          <nav>
            <ul className="flex space-x-6">
              <li>
                <button 
                  onClick={() => setSection('home')}
                  className={`px-3 py-2 rounded-md hover:bg-blue-500 hover:text-white transition ${section === 'home' ? 'bg-blue-500 text-white' : ''}`}
                >
                  {uiContent[language].nav.home}
                </button>
              </li>
              <li>
                <a 
                  href="cv/cv.pdf" 
                  target="_blank" 
                  className="px-3 py-2 rounded-md hover:bg-blue-500 hover:text-white transition"
                >
                  {uiContent[language].nav.cv}
                </a>
              </li>
              <li>
                <button 
                  onClick={() => setSection('contact')}
                  className={`px-3 py-2 rounded-md hover:bg-blue-500 hover:text-white transition ${section === 'contact' ? 'bg-blue-500 text-white' : ''}`}
                >
                  {uiContent[language].nav.contact}
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

      {/* 3D Canvas - Main Feature */}
      <div className="fixed top-0 left-0 w-full h-full z-0">
        <Canvas camera={{ position: [0, 0, 8], fov: 60 }}>
          <Suspense fallback={null}>
            <Scene 
              language={language} 
              section={section} 
              darkMode={darkMode} 
            />
          </Suspense>
        </Canvas>
      </div>

      {/* Main Content Overlay */}
      <main className="relative z-10 pt-24 pb-16 min-h-screen flex flex-col justify-center">
        {section === 'home' && (
          <div className="container mx-auto px-4 mt-64">
            <div className="glass-panel p-8 rounded-xl backdrop-blur-md bg-opacity-20 shadow-xl mb-10"
                 style={{ backgroundColor: darkMode ? 'rgba(0, 0, 0, 0.4)' : 'rgba(255, 255, 255, 0.4)' }}>
              <h2 className="text-2xl font-bold mb-6">{uiContent[language].areas}</h2>
              
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {uiContent[language].expertiseAreas.map((area, index) => (
                  <div 
                    key={index} 
                    className="p-6 rounded-lg transition-transform transform hover:scale-105"
                    style={{ 
                      backgroundColor: darkMode ? 'rgba(37, 99, 235, 0.2)' : 'rgba(37, 99, 235, 0.1)',
                      borderLeft: `4px solid ${darkMode ? '#3b82f6' : '#2563eb'}`
                    }}
                  >
                    <h3 className="text-xl font-semibold mb-2">{area}</h3>
                  </div>
                ))}
              </div>
            </div>
            
            <div className="glass-panel p-6 rounded-xl backdrop-blur-md bg-opacity-20 shadow-xl"
                 style={{ backgroundColor: darkMode ? 'rgba(0, 0, 0, 0.4)' : 'rgba(255, 255, 255, 0.4)' }}>
              <div className="flex items-center">
                <div className="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center mr-4 ml-4">
                  <span className="text-white text-xl">👨‍💼</span>
                </div>
                <div>
                  <h3 className="text-lg font-semibold">{uiContent[language].visitors}</h3>
                  <div className="text-2xl font-bold">{visitorCount}</div>
                </div>
              </div>
            </div>
          </div>
        )}

        {section === 'contact' && (
          <div className="container mx-auto px-4 mt-64">
            <div className="glass-panel p-8 rounded-xl backdrop-blur-md bg-opacity-20 shadow-xl"
                 style={{ backgroundColor: darkMode ? 'rgba(0, 0, 0, 0.4)' : 'rgba(255, 255, 255, 0.4)' }}>
              <h2 className="text-3xl font-bold mb-6">{uiContent[language].contactInfo.title}</h2>
              
              <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div className="p-4 rounded-lg flex flex-col items-center text-center">
                  <div className="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center mb-4">
                    <span className="text-white text-2xl">📱</span>
                  </div>
                  <h3 className="text-xl font-semibold mb-2">{uiContent[language].contactInfo.phone}</h3>
                  <p className="text-lg" dir="ltr">+966557704697</p>
                </div>
                
                <div className="p-4 rounded-lg flex flex-col items-center text-center">
                  <div className="w-16 h-16 rounded-full bg-green-500 flex items-center justify-center mb-4">
                    <span className="text-white text-2xl">✉️</span>
                  </div>
                  <h3 className="text-xl font-semibold mb-2">{uiContent[language].contactInfo.email}</h3>
                  <p className="text-lg">engr.aalmutairi@gmail.com</p>
                </div>
                
                <div className="p-4 rounded-lg flex flex-col items-center text-center">
                  <div className="w-16 h-16 rounded-full bg-purple-500 flex items-center justify-center mb-4">
                    <span className="text-white text-2xl">📍</span>
                  </div>
                  <h3 className="text-xl font-semibold mb-2">{uiContent[language].contactInfo.address}</h3>
                  <p className="text-lg">{uiContent[language].contactInfo.addressText}</p>
                </div>
              </div>
              
              <div className="text-center mt-10">
                <h3 className="text-xl font-semibold mb-4">{uiContent[language].contactInfo.follow}</h3>
                <div className="flex justify-center space-x-4">
                  <a href="#" className="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white hover:bg-blue-700 transition">
                    <span className="text-xl">f</span>
                  </a>
                  <a href="#" className="w-12 h-12 rounded-full bg-black flex items-center justify-center text-white hover:bg-gray-800 transition">
                    <span className="text-xl">𝕏</span>
                  </a>
                  <a href="https://www.linkedin.com/in/abdulrahman-almutairi/" target="_blank" className="w-12 h-12 rounded-full bg-blue-800 flex items-center justify-center text-white hover:bg-blue-900 transition">
                    <span className="text-xl">in</span>
                  </a>
                  <a href="#" className="w-12 h-12 rounded-full bg-pink-600 flex items-center justify-center text-white hover:bg-pink-700 transition">
                    <span className="text-xl">ig</span>
                  </a>
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
          <p>{uiContent[language].footer}</p>
        </div>
      </footer>
    </div>
  );
};

export default Portfolio;