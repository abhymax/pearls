<section id="home" class="relative bg-[#0F172A] min-h-[650px] flex items-center pb-24 clip-slant overflow-hidden">
    <div class="absolute inset-0 z-0"><div class="absolute inset-0 bg-gradient-to-r from-[#0F172A] via-[#0F172A]/95 to-blue-900/20"></div></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-12 items-center pt-8">
        <div class="text-center lg:text-left space-y-8">
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-[1.1]">
                <span data-k="hero_h1"><?php echo val('hero_h1'); ?></span> <br><span class="text-gradient" data-k="hero_sub"><?php echo val('hero_sub'); ?></span>
            </h1>
            <p class="text-lg text-slate-400 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium" data-k="hero_desc"><?php echo val('hero_desc'); ?></p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                <button onclick="openModal()" class="btn-gradient px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-2xl">
                    <span class="material-symbols-outlined">calendar_month</span> <span data-k="book_visit">Book Your Visit</span>
                </button>
                <a href="tel:<?php echo preg_replace('/[^0-9]/', '', val('phone')); ?>" class="border border-slate-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-slate-800 transition flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">call</span> <?php echo val('phone'); ?>
                </a>
            </div>
        </div>
        <div class="hidden lg:block relative group">
             <div class="relative bg-gradient-to-br from-slate-700 to-slate-900 rounded-3xl p-1 shadow-2xl animate-float">
                 <div class="relative rounded-2xl overflow-hidden h-[450px]">
                     <img src="<?php echo val('hero_main'); ?>" class="w-full h-full object-cover">
                 </div>
             </div>
        </div>
    </div>
</section>