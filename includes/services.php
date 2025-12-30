<section class="py-24 bg-slate-50" id="services">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12"><span class="text-blue-600 font-bold uppercase tracking-wider text-sm" data-k="services">Departments</span><h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-2" data-k="comp_care">Comprehensive Dental Care</h2></div>
        <div class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-xl overflow-hidden min-h-[500px] border border-gray-100">
            <div class="lg:w-1/3 bg-slate-50 border-r border-gray-100 flex flex-col">
                <?php 
                $tabs = [['laser','light_mode','Laser Dentistry'], ['implant','architecture','Digital Implants'], ['rct','dentistry','Root Canal'], ['kids','child_care','Pediatric'], ['cosmetic','face','Cosmetic']];
                foreach($tabs as $i => $t) {
                    $cls = $i===0 ? "active bg-white border-l-4 border-blue-600" : "";
                    echo "<button onclick=\"switchTab($i)\" class=\"service-btn $cls w-full text-left px-6 py-5 flex items-center gap-4 transition hover:bg-white border-b border-gray-100\"><span class=\"material-symbols-outlined text-2xl\">{$t[1]}</span><span class=\"font-bold\">{$t[2]}</span></button>";
                }
                ?>
            </div>
            <div class="lg:w-2/3 p-10 relative flex flex-col justify-center">
                <?php foreach($tabs as $i => $t) { $hide = $i===0 ? "block" : "hidden"; echo "<div id=\"tab-$i\" class=\"tab-content $hide\"><div class=\"h-64 rounded-2xl overflow-hidden mb-6 relative\"><img src=\"".val('img_'.$t[0])."\" class=\"absolute inset-0 w-full h-full object-cover\"></div><h3 class=\"text-2xl font-bold mb-4\">{$t[2]}</h3><p class=\"text-gray-600 text-lg mb-6\">".val('desc_'.$t[0])."</p><button onclick=\"openModal()\" class=\"btn-gradient px-8 py-3 rounded-lg font-bold\">Book Consultation</button></div>"; } ?>
            </div>
        </div>
    </div>
</section>