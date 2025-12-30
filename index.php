<?php
// 1. CONNECT TO DATABASE & FETCH SETTINGS
require 'db_connect.php';

$img = [];
// Default Fallbacks
$defaults = [
    'hero_bg'    => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1600&q=80',
    'hero_main'  => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80',
    'doctor'     => 'doctor.jpg', // DYNAMIC DOCTOR IMAGE
    'about_bg'   => 'https://www.transparenttextures.com/patterns/cubes.png',
    
    // Service Images
    'laser'      => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80',
    'implant'    => 'https://images.unsplash.com/photo-1445527697940-6170001a2911?auto=format&fit=crop&w=800&q=80',
    'rct'        => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80',
    'kids'       => 'https://images.unsplash.com/photo-1588776813186-6f6d27845688?auto=format&fit=crop&w=800&q=80',
    'cosmetic'   => 'https://images.unsplash.com/photo-1609840114035-1c99d59242cc?auto=format&fit=crop&w=800&q=80',
    
    // Before/After Demo
    'ba_before'  => 'https://images.unsplash.com/photo-1571772996211-2f02c9727629?auto=format&fit=crop&w=800&q=80',
    'ba_after'   => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=800&q=80'
];

$result = $conn->query("SELECT * FROM site_settings");
if($result) {
    while ($row = $result->fetch_assoc()) {
        $img[$row['setting_key']] = $row['setting_value'];
    }
}
$img = array_merge($defaults, $img);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pearls Shine Dental | Dr. Shiv Bhusan Pandey</title>
    <link rel="icon" type="image/png" href="https://img.icons8.com/color/48/dental-braces.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3, h4, h5 { font-family: 'Exo 2', sans-serif; }
        
        /* 1. ANIMATIONS */
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
        .animate-float { animation: float 5s ease-in-out infinite; }
        
        /* 2. REVIEWS MARQUEE */
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-marquee { display: flex; width: max-content; animation: scroll 40s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }

        /* 3. BEFORE/AFTER SLIDER */
        .ba-container { position: relative; width: 100%; height: 100%; overflow: hidden; }
        .ba-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .ba-overlay { position: absolute; top: 0; left: 0; height: 100%; width: 50%; overflow: hidden; border-right: 3px solid white; }
        .ba-handle { 
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 40px; height: 40px; background: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3); cursor: grab; z-index: 20;
        }

        /* 4. UTILITIES */
        .clip-slant { clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%); }
        .text-gradient { background: linear-gradient(to right, #60a5fa, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        /* 5. SERVICE TABS */
        .service-btn.active { border-left-color: #2563eb; background-color: #eff6ff; color: #1e3a8a; }
        .service-btn { border-left: 4px solid transparent; }
        
        /* 6. GRADIENT BUTTON */
        .btn-gradient {
            background: linear-gradient(90deg, #2563eb 0%, #06b6d4 100%);
            color: white;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, #1d4ed8 0%, #0891b2 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }
        
        /* 7. BA BUTTONS */
        .ba-btn.active { background-color: #2563eb; color: white; border-color: #2563eb; }
        .ba-btn { background-color: rgba(255,255,255,0.1); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body class="bg-gray-50 text-slate-800">

    <a href="tel:09231328309" class="fixed bottom-6 left-6 z-[60] bg-blue-600 p-4 rounded-full shadow-2xl hover:scale-110 transition flex items-center justify-center text-white border-2 border-white animate-bounce">
        <span class="material-symbols-outlined text-2xl">call</span>
    </a>
    <a href="https://wa.me/919231328309" class="fixed bottom-6 right-6 z-[60] bg-[#25D366] p-4 rounded-full shadow-2xl hover:scale-110 transition flex items-center justify-center text-white border-2 border-white">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" class="w-8 h-8">
    </a>

    <div class="hidden md:block bg-white border-b border-gray-100 py-2">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center text-xs text-gray-500 font-medium">
            <div class="flex gap-6">
                <span class="flex items-center gap-1 hover:text-blue-600"><span class="material-symbols-outlined text-[16px]">call</span> 092313 28309</span>
                <span class="flex items-center gap-1 hover:text-blue-600"><span class="material-symbols-outlined text-[16px]">location_on</span> Budge Budge, Kolkata</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex gap-3 items-center border-r pr-4 border-gray-200">
                    <a href="#" class="text-[#1877F2] hover:scale-110 transition" title="Facebook"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="#" class="text-[#E4405F] hover:scale-110 transition" title="Instagram"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a href="#" class="text-[#FF0000] hover:scale-110 transition" title="YouTube"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg></a>
                </div>
                <div class="flex gap-2 text-xs font-bold cursor-pointer">
                    <span onclick="setLang('en')" class="hover:text-blue-600">English</span>
                    <span onclick="setLang('hi')" class="hover:text-blue-600">हिंदी</span>
                    <span onclick="setLang('bn')" class="hover:text-blue-600">বাংলা</span>
                </div>
            </div>
        </div>
    </div>

    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2 cursor-pointer" onclick="location.reload()">
                    <div class="bg-gradient-to-br from-blue-600 to-cyan-500 text-white p-2 rounded-lg shadow-lg">
                        <span class="material-symbols-outlined text-2xl">dentistry</span>
                    </div>
                    <div class="leading-none">
                        <span class="block font-bold text-xl text-slate-900">Pearls Shine</span>
                        <span class="block text-[10px] text-blue-600 font-bold tracking-widest uppercase">Oral & Dental Care</span>
                    </div>
                </div>
                <div class="hidden lg:flex gap-8 text-sm font-bold text-slate-600 uppercase tracking-wide">
                    <a href="#home" class="hover:text-blue-600 transition" data-key="nav_home">Home</a>
                    <a href="#about" class="hover:text-blue-600 transition" data-key="nav_about">About</a>
                    <a href="#services" class="hover:text-blue-600 transition" data-key="nav_services">Departments</a>
                    <a href="#reviews" class="hover:text-blue-600 transition" data-key="nav_reviews">Reviews</a>
                    <a href="#contact" class="hover:text-blue-600 transition" data-key="nav_contact">Contact</a>
                </div>
                <button onclick="openModal()" class="hidden lg:block btn-gradient px-6 py-2.5 rounded-full font-bold shadow-lg" data-key="btn_book">Book Appointment</button>
                <button class="lg:hidden text-slate-600" onclick="document.getElementById('mob-menu').classList.toggle('hidden')"><span class="material-symbols-outlined text-3xl">menu</span></button>
            </div>
        </div>
        <div id="mob-menu" class="hidden lg:hidden bg-white border-t px-4 py-4 space-y-3 shadow-xl">
            <a href="#home" class="block font-bold text-slate-600">Home</a>
            <a href="#services" class="block font-bold text-slate-600">Services</a>
            <button onclick="openModal()" class="w-full btn-gradient py-3 rounded-lg font-bold">Book Now</button>
        </div>
    </nav>

    <section id="home" class="relative bg-[#0F172A] min-h-[650px] flex items-center pb-24 clip-slant overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A] via-[#0F172A]/95 to-blue-900/20"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-12 items-center pt-8">
            <div class="text-center lg:text-left space-y-8">
                <div class="inline-flex items-center gap-2 border border-slate-600 rounded-full px-4 py-1.5 bg-slate-800/50 backdrop-blur-sm">
                    <span class="material-symbols-outlined text-blue-400 text-sm">verified</span>
                    <span class="text-slate-300 text-xs font-bold uppercase tracking-widest">ISO 9001:2015 Certified</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-[1.1]">
                    <span data-key="hero_main">Advanced Dentistry</span> <br>
                    <span class="text-gradient" data-key="hero_sub">Reimagined.</span>
                </h1>
                <p class="text-lg text-slate-400 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium" data-key="hero_desc">
                    The only clinic in Budge Budge to introduce laser surgery, automated anesthesia, and digital navigation implant surgery.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <button onclick="openModal()" class="btn-gradient px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-2xl">
                        <span class="material-symbols-outlined">calendar_month</span> <span data-key="btn_visit">Book Your Visit</span>
                    </button>
                    <a href="tel:09231328309" class="border border-slate-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-slate-800 transition flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">call</span> 092313 28309
                    </a>
                </div>
                <p class="text-slate-500 text-sm pt-4">Serving Budge Budge, New Alipore, and Pujali.</p>
            </div>
            <div class="hidden lg:block relative group">
                 <div class="relative bg-gradient-to-br from-slate-700 to-slate-900 rounded-3xl p-1 shadow-2xl animate-float">
                     <div class="relative rounded-2xl overflow-hidden h-[450px]">
                         <img src="<?php echo $img['hero_main']; ?>" class="w-full h-full object-cover">
                         <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                         <div class="absolute bottom-6 right-6 bg-black/80 backdrop-blur-md text-white text-sm font-semibold px-4 py-2 rounded-lg border border-white/10 flex items-center gap-2 shadow-lg">
                             <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Micro-Dentistry Enabled
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white" id="about">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-16 items-center">
            
            <div class="relative order-2 lg:order-1">
                <div class="bg-gray-300 rounded-[3rem] w-full h-[500px] relative overflow-hidden shadow-inner">
                    <img src="<?php echo $img['doctor']; ?>" class="w-full h-full object-cover mix-blend-multiply opacity-90" alt="Dr. Shiv Bhusan Pandey">
                </div>
                <div class="absolute bottom-8 left-8 right-8 bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
                    <h3 class="text-xl font-bold text-slate-900" data-key="doc_name">Dr. Shiv Bhusan Pandey</h3>
                    <p class="text-blue-600 font-semibold text-sm mb-2">University Topper & Lead Dentist</p>
                    <div class="flex gap-2">
                        <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded font-bold">Gold Medalist</span>
                        <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded font-bold">ISO Certified</span>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-sm">Our Expertise</span>
                <h2 class="text-4xl font-bold text-slate-900 mt-2 mb-6 leading-tight">Pioneering Advanced Dental Care in <span class="text-blue-600">Budge Budge</span></h2>
                <p class="text-gray-600 text-lg mb-6 leading-relaxed" data-key="doc_bio">
                    Welcome to <strong>Pearls Shine Oral and Dental Care</strong>, the most advanced dental care center in the region with <strong>ISO 9001:2015 certification</strong>. We are proud to be the <strong>only clinic</strong> in Budge Budge to introduce revolutionary technologies like Laser Surgery and Digital Navigation Implants.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                    <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm flex items-start gap-4 hover:border-blue-200 transition">
                        <span class="material-symbols-outlined text-blue-600 text-3xl">verified</span>
                        <div><h4 class="font-bold text-slate-900">ISO 9001:2015</h4><p class="text-sm text-gray-500">Certified for quality management.</p></div>
                    </div>
                    <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm flex items-start gap-4 hover:border-purple-200 transition">
                        <span class="material-symbols-outlined text-purple-600 text-3xl">light_mode</span>
                        <div><h4 class="font-bold text-slate-900">Laser Surgery</h4><p class="text-sm text-gray-500">Painless & precise soft tissue care.</p></div>
                    </div>
                    <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm flex items-start gap-4 hover:border-green-200 transition">
                        <span class="material-symbols-outlined text-green-600 text-3xl">medication_liquid</span>
                        <div><h4 class="font-bold text-slate-900">Automated Anesthesia</h4><p class="text-sm text-gray-500">Computer-controlled comfort.</p></div>
                    </div>
                    <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm flex items-start gap-4 hover:border-orange-200 transition">
                        <span class="material-symbols-outlined text-orange-600 text-3xl">architecture</span>
                        <div><h4 class="font-bold text-slate-900">Digital Implants</h4><p class="text-sm text-gray-500">Guided navigation surgery.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50" id="services">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-blue-600 font-bold uppercase tracking-wider text-sm">Departments</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-2" data-key="srv_head">Comprehensive Dental Care</h2>
            </div>
            <div class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-xl overflow-hidden min-h-[550px] border border-gray-100">
                <div class="lg:w-1/3 bg-slate-50 border-r border-gray-100 flex flex-col">
                    <button onclick="switchTab(0)" class="service-btn active w-full text-left px-6 py-5 flex items-center gap-4 transition hover:bg-white border-b border-gray-100">
                        <span class="material-symbols-outlined text-2xl">light_mode</span><div><span class="block font-bold text-base">Laser Dentistry</span><span class="text-xs text-gray-500">Gum surgery</span></div>
                    </button>
                    <button onclick="switchTab(1)" class="service-btn w-full text-left px-6 py-5 flex items-center gap-4 transition hover:bg-white border-b border-gray-100">
                        <span class="material-symbols-outlined text-2xl">architecture</span><div><span class="block font-bold text-base">Digital Implants</span><span class="text-xs text-gray-500">Permanent solutions</span></div>
                    </button>
                    <button onclick="switchTab(2)" class="service-btn w-full text-left px-6 py-5 flex items-center gap-4 transition hover:bg-white border-b border-gray-100">
                        <span class="material-symbols-outlined text-2xl">dentistry</span><div><span class="block font-bold text-base">Root Canal (RCT)</span><span class="text-xs text-gray-500">Single Sitting</span></div>
                    </button>
                    <button onclick="switchTab(3)" class="service-btn w-full text-left px-6 py-5 flex items-center gap-4 transition hover:bg-white border-b border-gray-100">
                        <span class="material-symbols-outlined text-2xl">child_care</span><div><span class="block font-bold text-base">Pediatric Care</span><span class="text-xs text-gray-500">Kids Friendly</span></div>
                    </button>
                    <button onclick="switchTab(4)" class="service-btn w-full text-left px-6 py-5 flex items-center gap-4 transition hover:bg-white">
                        <span class="material-symbols-outlined text-2xl">face_retouching_natural</span><div><span class="block font-bold text-base">Cosmetic</span><span class="text-xs text-gray-500">Veneers & Smile Design</span></div>
                    </button>
                </div>
                <div class="lg:w-2/3 p-8 lg:p-12 relative flex flex-col justify-center">
                    <div id="tab-0" class="tab-content block">
                        <div class="h-64 rounded-2xl overflow-hidden mb-6 relative group">
                            <img src="<?php echo $img['laser']; ?>" class="absolute inset-0 w-full h-full object-cover">
                            <h3 class="absolute bottom-6 left-6 text-2xl font-bold text-white z-10">Advanced Laser Dentistry</h3>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">Experience painless gum treatments with no bleeding and no sutures.</p>
                        <button onclick="openModal()" class="btn-gradient px-8 py-3 rounded-lg font-bold">Book Laser Treatment</button>
                    </div>
                    <div id="tab-1" class="tab-content hidden">
                        <div class="h-64 rounded-2xl overflow-hidden mb-6 relative group">
                            <img src="<?php echo $img['implant']; ?>" class="absolute inset-0 w-full h-full object-cover">
                            <h3 class="absolute bottom-6 left-6 text-2xl font-bold text-white z-10">Digital Navigation Implants</h3>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">We use 3D Computer Guided Surgery to place implants with 100% accuracy.</p>
                        <button onclick="openModal()" class="btn-gradient px-8 py-3 rounded-lg font-bold">Get Implant Consult</button>
                    </div>
                    <div id="tab-2" class="tab-content hidden">
                        <div class="h-64 rounded-2xl overflow-hidden mb-6 relative group">
                            <img src="<?php echo $img['rct']; ?>" class="absolute inset-0 w-full h-full object-cover">
                            <h3 class="absolute bottom-6 left-6 text-2xl font-bold text-white z-10">Painless Rotary RCT</h3>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">Complete your Root Canal Treatment in a single sitting using flexible rotary files.</p>
                        <button onclick="openModal()" class="btn-gradient px-8 py-3 rounded-lg font-bold">Save Your Tooth</button>
                    </div>
                    <div id="tab-3" class="tab-content hidden">
                        <div class="h-64 rounded-2xl overflow-hidden mb-6 relative group">
                            <img src="<?php echo $img['kids']; ?>" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <h3 class="absolute bottom-6 left-6 text-2xl font-bold text-white">Friendly Pediatric Care</h3>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">We make dentistry fun! From fluoride application to sealants, we ensure your child grows up with a healthy smile.</p>
                        <button onclick="openModal()" class="btn-gradient px-8 py-3 rounded-lg font-bold">Book For Child</button>
                    </div>
                    <div id="tab-4" class="tab-content hidden">
                        <div class="h-64 rounded-2xl overflow-hidden mb-6 relative group">
                            <img src="<?php echo $img['cosmetic']; ?>" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <h3 class="absolute bottom-6 left-6 text-2xl font-bold text-white">Smile Designing</h3>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">Transform your smile with Zirconia crowns, veneers, and laser teeth whitening.</p>
                        <button onclick="openModal()" class="btn-gradient px-8 py-3 rounded-lg font-bold">Design My Smile</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gradient-to-br from-blue-600 to-indigo-700 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
            <div class="bg-white rounded-3xl p-12 shadow-2xl border-4 border-white/20">
                <div class="inline-block bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wide mb-6">Exclusive Online Offer</div>
                <h2 class="text-4xl font-extrabold text-slate-900 mb-6">First Visit Privilege</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    New to Pearls Shine? Experience our state-of-the-art care with a comprehensive consultation package including digital X-rays and a personalized treatment plan.
                </p>
                <div class="flex justify-center gap-8 mb-10 text-sm font-bold text-gray-700 flex-wrap">
                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-green-500">check_circle</span> Comprehensive Exam</span>
                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-green-500">check_circle</span> Digital X-Rays</span>
                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-green-500">check_circle</span> Expert Consultation</span>
                </div>
                <button onclick="openModal()" class="bg-[#587bf0] text-white text-xl font-bold px-12 py-4 rounded-lg shadow-lg hover:bg-blue-600 transition animate-bounce">
                    Claim Your Offer Now
                </button>
                <p class="text-xs text-gray-400 mt-6">*Terms and conditions apply. Valid for new patients only.</p>
            </div>
        </div>
    </section>

    <section class="py-20 bg-[#0F172A]">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-16 items-center">
            <div class="text-white">
                <span class="text-blue-400 font-bold uppercase tracking-wider text-sm">Real Results</span>
                <h2 class="text-4xl font-bold mt-2 mb-6">Smile Transformations</h2>
                
                <div class="flex gap-4 mb-8">
                    <button class="ba-btn active px-4 py-2 rounded-lg font-bold text-sm" onclick="switchBA('implant', this)">Implants</button>
                    <button class="ba-btn px-4 py-2 rounded-lg font-bold text-sm" onclick="switchBA('veneer', this)">Veneers</button>
                    <button class="ba-btn px-4 py-2 rounded-lg font-bold text-sm" onclick="switchBA('cleaning', this)">Laser Cleaning</button>
                </div>
                
                <p class="text-gray-400 border-l-2 border-blue-500 pl-4 italic">
                    "We use digital navigation for precise implant placement, ensuring faster healing and natural aesthetics."
                </p>
            </div>
            
            <div class="h-[400px] w-full rounded-2xl overflow-hidden relative select-none bg-black">
                <div class="ba-container" id="ba-slider">
                    <img src="<?php echo $img['ba_before']; ?>" class="ba-img" id="img-before">
                    <div class="ba-overlay" id="ba-overlay">
                        <img src="<?php echo $img['ba_after']; ?>" class="ba-img" id="img-after" style="width: 200%; max-width:none;">
                    </div>
                    <div class="ba-handle" id="ba-handle">
                        <span class="material-symbols-outlined text-blue-600">code</span>
                    </div>
                    <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">After</span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white overflow-hidden" id="reviews">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900">What Our Patients Say</h2>
            <div class="flex justify-center text-yellow-400 gap-1 mt-2">
                <span class="material-symbols-outlined fill-current">star</span><span class="material-symbols-outlined fill-current">star</span><span class="material-symbols-outlined fill-current">star</span><span class="material-symbols-outlined fill-current">star</span><span class="material-symbols-outlined fill-current">star</span>
                <span class="text-slate-600 font-bold ml-2">4.9/5 Average Rating</span>
            </div>
            <a href="#" class="text-blue-600 text-sm font-bold hover:underline mt-2 inline-block">See all reviews on Google <span class="material-symbols-outlined text-xs align-middle">open_in_new</span></a>
        </div>
        <div class="w-full inline-flex flex-nowrap overflow-hidden [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]">
            <ul class="flex items-center justify-center md:justify-start [&_li]:mx-4 [&_img]:max-w-none animate-marquee">
                <?php 
                $reviews = [
                    ["Rahul S.", "Best dental clinic in Budge Budge. The digital x-rays were quick and the consultation was very detailed."],
                    ["Priya M.", "My child was scared of dentists but the team here made her very comfortable. Very kid friendly!"],
                    ["Debarati Roy", "My mother and I were suffering from severe tooth pain. Dr. Pandey immediately diagnosed the issue."],
                    ["Krishnapada M.", "I visited for dentures. Thanks to Dr. Pandey for explaining the need for implants so clearly."]
                ];
                for($i=0; $i<4; $i++) {
                    foreach($reviews as $r) {
                        echo '<li class="w-[400px] flex-shrink-0 bg-slate-50 p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition"><div class="flex items-center gap-4 mb-4"><div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl">'.substr($r[0],0,1).'</div><div><h4 class="font-bold text-slate-900 text-lg">'.$r[0].'</h4><div class="text-yellow-400 text-sm">★★★★★</div></div></div><p class="text-gray-600 italic leading-relaxed">"'.$r[1].'"</p></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </section>

    <footer class="bg-slate-950 text-slate-400 py-16" id="contact">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 text-sm">
            <div>
                <div class="flex items-center gap-2 mb-6 text-white"><span class="material-symbols-outlined text-4xl text-blue-500">dentistry</span><span class="text-2xl font-bold">Pearls Shine</span></div>
                <div class="space-y-4">
                    <p class="flex items-start gap-3"><span class="material-symbols-outlined text-blue-500">location_on</span> 15/1/A, AL Daw Rd,<br>Joychandipur, Budge Budge,<br>Kolkata 700137</p>
                    <p class="flex items-center gap-3"><span class="material-symbols-outlined text-blue-500">call</span> 092313 28309</p>
                </div>
            </div>
            <div>
                <h4 class="text-white font-bold text-lg mb-6 border-b border-slate-800 pb-2 inline-block">Opening Hours</h4>
                <ul class="space-y-2">
                    <li class="flex justify-between"><span>Sun - Fri</span> <span class="text-blue-400 font-medium">9:00 AM – 12:30 PM</span></li>
                    <li class="flex justify-between border-b border-slate-800 pb-2 mb-2"><span></span> <span class="text-blue-400 font-medium">5:00 PM – 8:30 PM</span></li>
                    <li class="flex justify-between text-slate-600"><span>Saturday</span> <span>Closed</span></li>
                </ul>
            </div>
            <div class="h-60 rounded-xl overflow-hidden border border-slate-800 bg-slate-900 shadow-inner">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3686.857646546252!2d88.17!3d22.48!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDI4JzQ4LjAiTiA4OMKwMTAnNDguMCJF!5e0!3m2!1sen!2sin!4v1625634534567" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <div class="text-center mt-12 pt-8 border-t border-slate-900 text-xs">© 2025 Pearls Shine Oral and Dental Care. All Rights Reserved.</div>
    </footer>

    <div id="modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white">Book Appointment</h3>
                    <button onclick="closeModal()" class="text-white hover:bg-white/20 rounded-full p-1"><span class="material-symbols-outlined">close</span></button>
                </div>
                <div class="p-6">
                    <form id="bookForm" class="space-y-4">
                        <input type="text" name="name" placeholder="Full Name" required class="w-full border border-gray-300 rounded-lg p-3">
                        <input type="tel" name="phone" placeholder="Phone" required class="w-full border border-gray-300 rounded-lg p-3">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="date" name="date" required class="w-full border border-gray-300 rounded-lg p-3">
                            <select name="service" class="w-full border border-gray-300 rounded-lg p-3"><option>Checkup</option><option>Pain</option><option>RCT</option></select>
                        </div>
                        <button type="submit" class="w-full btn-gradient py-3 rounded-lg font-bold">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const langData = { en: {}, hi: {}, bn: {} };
        function setLang(lang) { }

        function switchTab(index) {
            document.querySelectorAll('.tab-content').forEach(el => { el.classList.add('hidden'); el.classList.remove('block'); });
            const selectedContent = document.getElementById('tab-' + index);
            if(selectedContent) { selectedContent.classList.remove('hidden'); selectedContent.classList.add('block'); }
            const btns = document.querySelectorAll('.service-btn');
            btns.forEach(btn => { btn.classList.remove('active'); btn.classList.remove('bg-white'); btn.classList.remove('shadow-sm'); btn.classList.remove('border-l-4'); btn.classList.remove('border-blue-600'); });
            btns[index].classList.add('active', 'bg-white', 'shadow-sm', 'border-l-4', 'border-blue-600');
        }

        const slider = document.getElementById('ba-slider');
        const overlay = document.getElementById('ba-overlay');
        const handle = document.getElementById('ba-handle');
        let isDown = false;
        function moveSlider(e) {
            if(!isDown && e.type !== 'mousemove') return; 
            const rect = slider.getBoundingClientRect();
            let x = (e.clientX || e.touches[0].clientX) - rect.left;
            x = Math.max(0, Math.min(x, rect.width));
            const percent = (x / rect.width) * 100;
            overlay.style.width = percent + "%";
            handle.style.left = percent + "%";
        }
        slider.addEventListener('mousedown', () => isDown = true);
        slider.addEventListener('touchstart', () => isDown = true);
        window.addEventListener('mouseup', () => isDown = false);
        window.addEventListener('touchend', () => isDown = false);
        window.addEventListener('mousemove', (e) => { if(isDown) moveSlider(e); });
        window.addEventListener('touchmove', (e) => { if(isDown) moveSlider(e); });
        slider.addEventListener('click', (e) => { isDown = true; moveSlider(e); isDown = false; });

        function switchBA(type, btn) {
            document.querySelectorAll('.ba-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        function openModal() { document.getElementById('modal').classList.remove('hidden'); }
        function closeModal() { document.getElementById('modal').classList.add('hidden'); }

        document.getElementById('bookForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            const originalText = btn.innerText;
            btn.innerText = "Booking...";
            const formData = new FormData(this);
            fetch('api.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') { alert("✅ Appointment Confirmed!"); this.reset(); closeModal(); } 
                else { alert("❌ Error: " + data.message); }
            })
            .catch(error => { alert("Connection Error."); })
            .finally(() => { btn.innerText = originalText; });
        });
    </script>
</body>
</html>