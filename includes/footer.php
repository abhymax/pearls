<footer class="bg-slate-950 text-slate-400 py-16" id="contact">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12 text-sm">
        <div>
            <div class="flex items-center gap-2 mb-6 text-white"><img src="<?php echo val('logo'); ?>" class="h-8 brightness-0 invert"><span class="text-2xl font-bold">Pearls Shine</span></div>
            <div class="space-y-4">
                <p class="flex items-start gap-3"><span class="material-symbols-outlined text-blue-500">location_on</span> <?php echo val('address_full'); ?></p>
                <p class="flex items-center gap-3"><span class="material-symbols-outlined text-blue-500">call</span> <?php echo val('phone'); ?></p>
            </div>
        </div>
        <div>
            <h4 class="text-white font-bold text-lg mb-6 border-b border-slate-800 pb-2 inline-block">Opening Hours</h4>
            <ul class="space-y-2">
                <li class="flex justify-between"><span>Sun - Fri</span> <span class="text-blue-400 font-medium"><?php echo val('hours_morn'); ?></span></li>
                <li class="flex justify-between border-b border-slate-800 pb-2 mb-2"><span></span> <span class="text-blue-400 font-medium"><?php echo val('hours_eve'); ?></span></li>
                <li class="flex justify-between text-slate-600"><span>Saturday</span> <span>Closed</span></li>
            </ul>
        </div>
        <div class="h-60 rounded-xl overflow-hidden border border-slate-800 bg-slate-900 shadow-inner">
            <iframe src="<?php echo val('map_url'); ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <div class="text-center mt-12 pt-8 border-t border-slate-900 text-xs">© 2025 Pearls Shine Oral and Dental Care. All Rights Reserved.</div>
</footer>

<div id="modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div id="modal-header" class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-6 flex justify-between items-center">
                <h3 id="modal-title" class="text-xl font-bold text-white">Book Appointment</h3>
                <button onclick="closeModal()" class="text-white hover:bg-white/20 rounded-full p-1"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="p-6">
                <div id="offer-msg" class="hidden mb-4 bg-yellow-50 text-yellow-800 p-3 rounded-lg text-sm font-bold border border-yellow-200">🎉 First Visit Special: You get a FLAT 20% DISCOUNT!</div>
                <form id="bookForm" class="space-y-4">
                    <input type="text" name="name" placeholder="Full Name" required class="w-full border border-gray-300 rounded-lg p-3">
                    <input type="tel" name="phone" placeholder="Phone" required class="w-full border border-gray-300 rounded-lg p-3">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="date" name="date" required class="w-full border border-gray-300 rounded-lg p-3">
                        <select name="service" class="w-full border border-gray-300 rounded-lg p-3"><option>Checkup</option><option>Pain</option><option>RCT</option></select>
                    </div>
                    <button type="submit" class="w-full btn-gradient py-3 rounded-lg font-bold">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const dict={en:{home:"Home",about:"About",services:"Departments",reviews:"Reviews",book:"Book Appointment",book_visit:"Book Your Visit",hero_h1:"Advanced Dentistry",hero_sub:"Reimagined.",meet_experts:"Meet The Experts",team_k:"Our Team",comp_care:"Comprehensive Dental Care"},hi:{home:"होम",about:"परिचय",services:"विभाग",reviews:"समीक्षाएं",book:"अपॉइंटमेंट बुक करें",book_visit:"यात्रा बुक करें",hero_h1:"उन्नत दंत चिकित्सा",hero_sub:"पुनर्कल्पित।",meet_experts:"विशेषज्ञों से मिलें",team_k:"हमारी टीम",comp_care:"व्यापक दंत चिकित्सा"},bn:{home:"হোম",about:"পরিচয়",services:"বিভাগ",reviews:"পর্যালোচনা",book:"অ্যাপয়েন্টমেন্ট বুক করুন",book_visit:"বুকিং করুন",hero_h1:"উন্নত দন্তচিকিৎসা",hero_sub:"পুনঃকল্পিত।",meet_experts:"বিশেষজ্ঞদের সাথে দেখা করুন",team_k:"আমাদের দল",comp_care:"বিস্তৃত ডেন্টাল কেয়ার"}};
    function changeLang(l){document.querySelectorAll('[data-k]').forEach(e=>{if(dict[l][e.dataset.k])e.innerText=dict[l][e.dataset.k]})}
    function switchTab(i){document.querySelectorAll('.tab-content').forEach(e=>e.classList.add('hidden'));document.getElementById('tab-'+i).classList.remove('hidden');document.querySelectorAll('.service-btn').forEach(b=>b.classList.remove('active','bg-white','border-l-4','border-blue-600'));document.querySelectorAll('.service-btn')[i].classList.add('active','bg-white','border-l-4','border-blue-600')}
    function switchBA(c,b){document.querySelectorAll('.ba-btn').forEach(x=>x.classList.remove('active'));b.classList.add('active');document.getElementById('img-before').src=b.dataset.b;document.getElementById('img-after').src=b.dataset.a}
    const s=document.getElementById('ba-slider'),o=document.getElementById('ba-overlay'),h=document.getElementById('ba-handle');let d=false;function m(e){if(!d)return;const r=s.getBoundingClientRect(),x=Math.max(0,Math.min((e.clientX||e.touches[0].clientX)-r.left,r.width)),p=(x/r.width)*100;o.style.width=p+"%";h.style.left=p+"%"}s.addEventListener('mousedown',()=>d=true);window.addEventListener('mouseup',()=>d=false);s.addEventListener('mousemove',m);s.addEventListener('touchmove',m);
    function openModal(t){document.getElementById('modal').classList.remove('hidden');if(t==='offer'){document.getElementById('offer-msg').classList.remove('hidden');document.getElementById('modal-title').innerText="Claim 20% Discount"}else{document.getElementById('offer-msg').classList.add('hidden');document.getElementById('modal-title').innerText="Book Appointment"}}
    function closeModal(){document.getElementById('modal').classList.add('hidden')}
    
    // Form Submission Logic
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