<section class="py-20 bg-[#0F172A]">
    <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-16 items-center">
        <div class="text-white">
            <span class="text-blue-400 font-bold uppercase tracking-wider text-sm">Real Results</span>
            <h2 class="text-4xl font-bold mt-2 mb-6">Smile Transformations</h2>
            <div class="flex flex-wrap gap-2 mb-8">
                <?php $cats=['implant'=>'Implants','veneer'=>'Veneers','cleaning'=>'Laser','fmr'=>'Full Mouth','restoration'=>'Restoration','gbt'=>'GBT']; $first=true; foreach($cats as $k=>$label){ $cls=$first?"active":""; echo "<button class=\"ba-btn $cls px-3 py-1.5 rounded-lg font-bold text-xs\" onclick=\"switchBA('$k',this)\" data-b=\"".val('ba_'.$k.'_b')."\" data-a=\"".val('ba_'.$k.'_a')."\">$label</button>"; $first=false; } ?>
            </div>
        </div>
        <div class="h-[400px] w-full rounded-2xl overflow-hidden relative select-none bg-black">
            <div class="ba-container" id="ba-slider"><img src="<?php echo val('ba_implant_b'); ?>" class="ba-img" id="img-before"><div class="ba-overlay" id="ba-overlay"><img src="<?php echo val('ba_implant_a'); ?>" class="ba-img" id="img-after" style="width:200%;max-width:none;"></div><div class="ba-handle" id="ba-handle"><span class="material-symbols-outlined text-blue-600">code</span></div></div>
        </div>
    </div>
</section>