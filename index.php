<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'config.php'; 
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pearls Shine Dental</title>
    <link rel="icon" type="image/png" href="<?php echo val('logo'); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3, h4, h5 { font-family: 'Exo 2', sans-serif; }
        .clip-slant { clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%); }
        .text-gradient { background: linear-gradient(to right, #60a5fa, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .service-btn.active { border-left-color: #2563eb; background-color: #eff6ff; color: #1e3a8a; }
        .service-btn { border-left: 4px solid transparent; }
        .btn-gradient { background: linear-gradient(90deg, #2563eb 0%, #06b6d4 100%); color: white; transition: all 0.3s ease; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); }
        .ba-btn.active { background-color: #2563eb; color: white; border-color: #2563eb; }
        .ba-btn { background-color: rgba(255,255,255,0.1); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1); }
        /* Slider CSS */
        .ba-container { position: relative; width: 100%; height: 100%; overflow: hidden; }
        .ba-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .ba-overlay { position: absolute; top: 0; left: 0; height: 100%; width: 50%; overflow: hidden; border-right: 3px solid white; }
        .ba-handle { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.3); cursor: grab; z-index: 20; }
        /* Marquee */
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }
        .animate-marquee { display: flex; animation: scroll 30s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800">
    <?php $clean_phone = preg_replace('/[^0-9]/', '', val('phone')); ?>
    
    <a href="tel:<?php echo $clean_phone; ?>" class="fixed bottom-6 left-6 z-[60] bg-blue-600 p-4 rounded-full shadow-2xl hover:scale-110 transition flex items-center justify-center text-white border-2 border-white animate-bounce"><span class="material-symbols-outlined text-2xl">call</span></a>
    <a href="https://wa.me/<?php echo val('whatsapp'); ?>" class="fixed bottom-6 right-6 z-[60] bg-[#25D366] p-4 rounded-full shadow-2xl hover:scale-110 transition flex items-center justify-center text-white border-2 border-white"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" class="w-8 h-8"></a>

    <?php include 'includes/header.php'; ?>
    <?php include 'includes/hero.php'; ?>
    <?php include 'includes/about.php'; ?>
    <?php include 'includes/services.php'; ?>
    <?php include 'includes/offer.php'; ?>
    <?php include 'includes/gallery.php'; ?>
    <?php include 'includes/reviews.php'; ?>
    <?php include 'includes/footer.php'; ?>

</body>
</html>