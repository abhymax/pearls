<?php require 'config.php';
$ADMIN_USER = "admin"; $ADMIN_PASS = "Pearls@2025"; 
if (isset($_GET['logout'])) { session_destroy(); echo "<script>location.href='admin.php';</script>"; exit; }
$is_logged_in = (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    if ($_POST['user'] === $ADMIN_USER && $_POST['pass'] === $ADMIN_PASS) { $_SESSION['logged_in'] = true; echo "<script>location.href='admin.php';</script>"; exit; }
}
if ($is_logged_in && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_section') {
    foreach ($_POST as $k => $v) {
        if (in_array($k, ['action', 'section_name'])) continue;
        $sk = $conn->real_escape_string($k); $sv = $conn->real_escape_string($v);
        $conn->query("INSERT INTO site_settings (setting_key, setting_value) VALUES ('$sk', '$sv') ON DUPLICATE KEY UPDATE setting_value='$sv'");
    }
    foreach ($_FILES as $k => $f) {
        if ($f['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $n = $k . '_' . time() . '.' . $ext;
                if (move_uploaded_file($f['tmp_name'], __DIR__ . '/' . $n)) {
                    $conn->query("INSERT INTO site_settings (setting_key, setting_value) VALUES ('$k', '$n') ON DUPLICATE KEY UPDATE setting_value='$n'");
                }
            }
        }
    }
    $msg = "✅ " . htmlspecialchars($_POST['section_name']) . " updated!";
}
$s = $site; $apps = [];
if ($is_logged_in) { $res = $conn->query("SELECT * FROM appointments ORDER BY created_at DESC"); if($res) while($r = $res->fetch_assoc()) $apps[] = $r; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>.nav-item.active{background-color:#2563eb;color:white}.input-text{width:100%;border:1px solid #e2e8f0;padding:8px;border-radius:6px}.label{display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;margin-bottom:4px}</style>
    <script>function openTab(id,btn){document.querySelectorAll('.tab-content').forEach(e=>e.classList.add('hidden'));document.getElementById(id).classList.remove('hidden');document.querySelectorAll('.nav-item').forEach(e=>e.classList.remove('active'));btn.classList.add('active');}</script>
</head>
<body class="bg-slate-100 font-sans text-sm">
<?php if (!$is_logged_in): ?>
    <div class="flex items-center justify-center h-screen"><form method="POST" class="bg-white p-8 rounded-xl shadow-xl w-80 space-y-4"><h2 class="text-xl font-bold text-center">Login</h2><input type="hidden" name="action" value="login"><input name="user" class="input-text" placeholder="User"><input type="password" name="pass" class="input-text" placeholder="Pass"><button class="w-full bg-blue-600 text-white py-2 rounded font-bold">Login</button></form></div>
<?php else: ?>
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-white border-r flex flex-col"><div class="p-6 border-b font-bold text-lg text-blue-600">Admin Panel</div>
            <nav class="flex-1 p-4 space-y-2">
                <div onclick="openTab('dash',this)" class="nav-item active p-3 rounded cursor-pointer">Dashboard</div>
                <div onclick="openTab('hero',this)" class="nav-item p-3 rounded cursor-pointer">Header & Hero</div>
                <div onclick="openTab('about',this)" class="nav-item p-3 rounded cursor-pointer">Doctors</div>
                <div onclick="openTab('srv',this)" class="nav-item p-3 rounded cursor-pointer">Services</div>
                <div onclick="openTab('ba',this)" class="nav-item p-3 rounded cursor-pointer">Before/After</div>
                <div onclick="openTab('rev',this)" class="nav-item p-3 rounded cursor-pointer">Reviews</div>
                <div onclick="openTab('foot',this)" class="nav-item p-3 rounded cursor-pointer">Footer & Contact</div>
            </nav>
        </aside>
        <main class="flex-1 bg-slate-50 p-8 overflow-y-auto">
            <?php if(isset($msg)) echo "<div class='bg-green-100 text-green-800 p-3 rounded mb-4'>$msg</div>"; ?>
            
            <div id="dash" class="tab-content block">
                <h2 class="font-bold text-xl mb-4">Appointments</h2>
                <div class="bg-white rounded border">
                    <table class="w-full text-left">
                        <tr class="bg-slate-50 border-b"><th class="p-3">Date</th><th class="p-3">Patient</th><th class="p-3">Phone</th></tr>
                        <?php foreach($apps as $r) echo "<tr><td class='p-3'>{$r['preferred_date']}</td><td class='p-3'>{$r['patient_name']}</td><td class='p-3'>{$r['phone']}</td></tr>"; ?>
                    </table>
                </div>
            </div>

            <div id="hero" class="tab-content hidden">
                <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
                    <input type="hidden" name="action" value="update_section"><input type="hidden" name="section_name" value="Header & Hero">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="label">Logo</label><input type="file" name="logo" class="text-xs"></div>
                        <div><label class="label">Top Bar Phone</label><input name="phone" value="<?php echo val('phone');?>" class="input-text"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div><label class="label">Facebook Link</label><input name="link_fb" value="<?php echo val('link_fb');?>" class="input-text"></div>
                        <div><label class="label">Instagram Link</label><input name="link_insta" value="<?php echo val('link_insta');?>" class="input-text"></div>
                        <div><label class="label">YouTube Link</label><input name="link_yt" value="<?php echo val('link_yt');?>" class="input-text"></div>
                    </div>
                    <label class="label">Hero Heading</label><input name="hero_h1" value="<?php echo val('hero_h1');?>" class="input-text">
                    <label class="label">Hero Sub</label><input name="hero_sub" value="<?php echo val('hero_sub');?>" class="input-text">
                    <label class="label">Description</label><textarea name="hero_desc" class="input-text h-20"><?php echo val('hero_desc');?></textarea>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">Save</button>
                </form>
            </div>

            <div id="about" class="tab-content hidden">
                <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
                    <input type="hidden" name="action" value="update_section"><input type="hidden" name="section_name" value="Doctors">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border p-3 rounded">
                            <label class="label">Doctor 1 Image</label><input type="file" name="doctor_1" class="text-xs mb-2">
                            <label class="label">Name</label><input name="doc1_name" value="<?php echo val('doc1_name');?>" class="input-text mb-2">
                            <label class="label">Title</label><input name="doc1_title" value="<?php echo val('doc1_title');?>" class="input-text">
                        </div>
                        <div class="border p-3 rounded">
                            <label class="label">Doctor 2 Image</label><input type="file" name="doctor_2" class="text-xs mb-2">
                            <label class="label">Name</label><input name="doc2_name" value="<?php echo val('doc2_name');?>" class="input-text mb-2">
                            <label class="label">Title</label><input name="doc2_title" value="<?php echo val('doc2_title');?>" class="input-text">
                        </div>
                    </div>
                    <label class="label">Middle Section Text</label><textarea name="about_bio" class="input-text h-32"><?php echo val('about_bio');?></textarea>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">Save</button>
                </form>
            </div>

            <div id="srv" class="tab-content hidden">
                <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
                    <input type="hidden" name="action" value="update_section"><input type="hidden" name="section_name" value="Services">
                    <?php $s_list=['laser'=>'Laser','implant'=>'Implant','rct'=>'RCT','kids'=>'Kids','cosmetic'=>'Cosmetic']; 
                    foreach($s_list as $k=>$v): ?>
                    <div class="mb-4 border-b pb-4">
                        <label class="label font-bold text-blue-600"><?php echo $v; ?></label>
                        <div class="flex gap-4">
                            <input type="file" name="img_<?php echo $k;?>" class="text-xs w-1/3">
                            <textarea name="desc_<?php echo $k;?>" class="input-text w-2/3 h-16"><?php echo val('desc_'.$k);?></textarea>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">Save</button>
                </form>
            </div>

            <div id="ba" class="tab-content hidden">
                <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
                    <input type="hidden" name="action" value="update_section"><input type="hidden" name="section_name" value="Gallery">
                    <div class="grid grid-cols-2 gap-4">
                    <?php $cats=['implant','veneer','cleaning','fmr','restoration','gbt']; 
                    foreach($cats as $c): ?>
                        <div class="border p-2 rounded">
                            <label class="label font-bold"><?php echo ucfirst($c); ?></label>
                            <label class="label">Before</label><input type="file" name="ba_<?php echo $c;?>_b" class="text-xs mb-1">
                            <label class="label">After</label><input type="file" name="ba_<?php echo $c;?>_a" class="text-xs">
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded mt-4">Save</button>
                </form>
            </div>

            <div id="rev" class="tab-content hidden">
                <form method="POST" class="bg-white p-6 rounded shadow space-y-4">
                    <input type="hidden" name="action" value="update_section"><input type="hidden" name="section_name" value="Reviews">
                    <?php for($i=1;$i<=4;$i++): ?>
                    <div class="border p-3 rounded">
                        <input name="rev<?php echo $i;?>_name" value="<?php echo val('rev'.$i.'_name');?>" class="input-text font-bold mb-2" placeholder="Name">
                        <textarea name="rev<?php echo $i;?>_text" class="input-text h-16"><?php echo val('rev'.$i.'_text');?></textarea>
                    </div>
                    <?php endfor; ?>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">Save</button>
                </form>
            </div>

            <div id="foot" class="tab-content hidden">
                <form method="POST" class="bg-white p-6 rounded shadow space-y-4">
                    <input type="hidden" name="action" value="update_section"><input type="hidden" name="section_name" value="Footer">
                    <label class="label">Full Address</label><textarea name="address_full" class="input-text h-20"><?php echo val('address_full');?></textarea>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="label">WhatsApp Number</label><input name="whatsapp" value="<?php echo val('whatsapp');?>" class="input-text"></div>
                        <div><label class="label">Short Location</label><input name="location_short" value="<?php echo val('location_short');?>" class="input-text"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="label">Morning Hours</label><input name="hours_morn" value="<?php echo val('hours_morn');?>" class="input-text"></div>
                        <div><label class="label">Evening Hours</label><input name="hours_eve" value="<?php echo val('hours_eve');?>" class="input-text"></div>
                    </div>
                    <label class="label">Google Maps Embed URL</label><input name="map_url" value="<?php echo val('map_url');?>" class="input-text">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">Save</button>
                </form>
            </div>

        </main>
    </div>
<?php endif; ?>
</body>
</html>