<section class="py-24 bg-white" id="about">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-blue-600 font-bold uppercase tracking-wider text-sm" data-k="team_k">Our Team</span>
            <h2 class="text-3xl font-bold text-slate-900" data-k="meet_experts">Meet The Experts</h2>
        </div>
        <div class="grid lg:grid-cols-3 gap-8 items-start">
            <div class="group relative bg-slate-50 rounded-3xl overflow-hidden shadow-lg border hover:shadow-2xl transition">
                <div class="h-80 w-full overflow-hidden"><img src="<?php echo val('doctor_1'); ?>" class="w-full h-full object-cover transition duration-500 group-hover:scale-105"></div>
                <div class="absolute bottom-0 inset-x-0 bg-white/95 backdrop-blur p-6 border-t"><h3 class="font-bold text-lg text-slate-900"><?php echo val('doc1_name'); ?></h3><p class="text-blue-600 text-sm font-bold"><?php echo val('doc1_title'); ?></p></div>
            </div>
            <div class="group relative bg-slate-50 rounded-3xl overflow-hidden shadow-lg border hover:shadow-2xl transition">
                <div class="h-80 w-full overflow-hidden"><img src="<?php echo val('doctor_2'); ?>" class="w-full h-full object-cover transition duration-500 group-hover:scale-105"></div>
                <div class="absolute bottom-0 inset-x-0 bg-white/95 backdrop-blur p-6 border-t"><h3 class="font-bold text-lg text-slate-900"><?php echo val('doc2_name'); ?></h3><p class="text-blue-600 text-sm font-bold"><?php echo val('doc2_title'); ?></p></div>
            </div>
            <div class="py-4 text-center lg:text-left">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-xs">Our Expertise</span>
                <h3 class="text-2xl font-bold mb-4 mt-1">World Class Care</h3>
                <p class="text-gray-600 leading-relaxed mb-6 text-sm"><?php echo val('about_bio'); ?></p>
                <div class="grid grid-cols-1 gap-3 text-left">
                    <div class="flex items-center gap-3 bg-blue-50 p-3 rounded-lg border border-blue-100"><span class="material-symbols-outlined text-blue-600 text-2xl">verified</span><div><div class="text-sm font-bold text-slate-900">ISO 9001:2015</div><div class="text-xs text-slate-500">Certified Quality</div></div></div>
                    <div class="flex items-center gap-3 bg-purple-50 p-3 rounded-lg border border-purple-100"><span class="material-symbols-outlined text-purple-600 text-2xl">light_mode</span><div><div class="text-sm font-bold text-slate-900">Laser Dentistry</div><div class="text-xs text-slate-500">Painless Care</div></div></div>
                    <div class="flex items-center gap-3 bg-green-50 p-3 rounded-lg border border-green-100"><span class="material-symbols-outlined text-green-600 text-2xl">medication_liquid</span><div><div class="text-sm font-bold text-slate-900">Auto Anesthesia</div><div class="text-xs text-slate-500">Computer Controlled</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>