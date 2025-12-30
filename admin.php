<?php
// 1. SESSION & CONFIGURATION
// --------------------------------------------------------
$sess_folder = __DIR__ . '/my_sessions';
if (!file_exists($sess_folder)) { mkdir($sess_folder, 0777, true); }
ini_set('session.save_path', $sess_folder);
ini_set('session.gc_maxlifetime', 86400); 
session_set_cookie_params(86400);
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connect.php';

$ADMIN_USER = "admin";
$ADMIN_PASS = "Pearls@2025"; 

// 2. LOGOUT LOGIC
// --------------------------------------------------------
if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>window.location.href='admin.php';</script>";
    exit;
}

// 3. LOGIN LOGIC
// --------------------------------------------------------
$login_msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $u = trim($_POST['user'] ?? '');
    $p = trim($_POST['pass'] ?? '');

    if ($u === $ADMIN_USER && $p === $ADMIN_PASS) {
        $_SESSION['logged_in'] = true;
        echo "<script>window.location.href='admin.php';</script>";
        exit;
    } else {
        $login_msg = "❌ Wrong Password";
    }
}

$is_logged_in = (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true);

// 4. IMAGE UPLOAD LOGIC
// --------------------------------------------------------
$upload_msg = "";
if ($is_logged_in && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_images') {
    
    // List of allowed image keys
    $allowed_keys = [
        'doctor', 'hero_bg', 'hero_main', 
        'laser', 'implant', 'rct', 'kids', 'cosmetic',
        'ba_before', 'ba_after'
    ];

    $count = 0;

    foreach ($allowed_keys as $key) {
        // Check if a file was uploaded for this key
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            
            $fileTmpPath = $_FILES[$key]['tmp_name'];
            $fileName = $_FILES[$key]['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Sanitize filename
            $newFileName = $key . '_' . time() . '.' . $fileExtension;
            
            // Allowed extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'webp', 'jpeg');
            
            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Upload Directory (Root folder)
                $dest_path = __DIR__ . '/' . $newFileName;
                
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Update Database
                    $safe_val = $newFileName; 
                    // Or full URL if needed: 'https://pearlsshine.co.in/' . $newFileName;
                    // Ideally relative path is enough for <img> src
                    
                    $conn->query("INSERT INTO site_settings (setting_key, setting_value) VALUES ('$key', '$safe_val') ON DUPLICATE KEY UPDATE setting_value='$safe_val'");
                    $count++;
                }
            }
        }
    }
    
    if ($count > 0) {
        $upload_msg = "✅ Success! $count image(s) updated.";
    } else {
        $upload_msg = "⚠️ No files selected or upload failed.";
    }
}

// 5. FETCH DATA
// --------------------------------------------------------
$settings = [];
$appointments = [];

if ($is_logged_in) {
    // Fetch Settings
    $r = $conn->query("SELECT * FROM site_settings");
    while ($row = $r->fetch_assoc()) $settings[$row['setting_key']] = $row['setting_value'];
    
    // Fetch Appointments
    $a = $conn->query("SELECT * FROM appointments ORDER BY created_at DESC");
    if ($a) while ($row = $a->fetch_assoc()) $appointments[] = $row;
}

function val($k, $d) { return isset($d[$k]) ? $d[$k] : ''; }

// ---------------- HTML START ----------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | Pearls Shine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script>
        function show(id) {
            document.querySelectorAll('.tab').forEach(e => e.classList.add('hidden'));
            document.getElementById(id).classList.remove('hidden');
            // Update buttons
            document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('bg-blue-600', 'text-white'));
            document.querySelectorAll('.nav-btn').forEach(b => b.classList.add('bg-white', 'text-slate-700'));
            document.getElementById('btn-'+id).classList.remove('bg-white', 'text-slate-700');
            document.getElementById('btn-'+id).classList.add('bg-blue-600', 'text-white');
        }
    </script>
</head>
<body class="bg-slate-100 min-h-screen font-sans text-sm">

<?php if (!$is_logged_in): ?>
    <div class="flex items-center justify-center h-screen bg-slate-200">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-96 border-t-4 border-blue-600">
            <div class="text-center mb-6">
                <span class="material-symbols-outlined text-5xl text-blue-600">dentistry</span>
                <h2 class="text-2xl font-bold text-slate-800">Admin Access</h2>
            </div>
            <?php if($login_msg): ?><div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-center font-bold"><?php echo $login_msg; ?></div><?php endif; ?>
            <form method="POST">
                <input type="hidden" name="action" value="login">
                <div class="space-y-4">
                    <input type="text" name="user" placeholder="Username" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    <input type="password" name="pass" placeholder="Password" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    <button class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 shadow-lg transition">Secure Login</button>
                </div>
            </form>
            <a href="index.php" class="block text-center mt-6 text-xs text-gray-400 hover:text-blue-500">← Back to Website</a>
        </div>
    </div>

<?php else: ?>
    <div class="bg-white border-b sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
            <div class="font-bold text-xl flex items-center gap-2 text-slate-800">
                <span class="material-symbols-outlined text-blue-600">admin_panel_settings</span> Dashboard
            </div>
            <div class="flex gap-4">
                <a href="index.php" target="_blank" class="flex items-center gap-1 text-slate-500 hover:text-blue-600 font-bold text-xs border px-3 py-1.5 rounded-lg transition">
                    <span class="material-symbols-outlined text-sm">open_in_new</span> Visit Site
                </a>
                <a href="admin.php?logout=true" class="flex items-center gap-1 bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-red-100 transition">
                    <span class="material-symbols-outlined text-sm">logout</span> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-6">
        
        <div class="flex gap-4 mb-8">
            <button id="btn-apps" onclick="show('apps')" class="nav-btn bg-blue-600 text-white px-6 py-3 rounded-xl font-bold shadow-md transition flex items-center gap-2">
                <span class="material-symbols-outlined">calendar_month</span> Appointments
            </button>
            <button id="btn-imgs" onclick="show('imgs')" class="nav-btn bg-white text-slate-700 px-6 py-3 rounded-xl font-bold shadow-md transition flex items-center gap-2">
                <span class="material-symbols-outlined">image</span> Website Images
            </button>
        </div>

        <div id="apps" class="tab block">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-slate-800">Patient Bookings</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold"><?php echo count($appointments); ?> Total</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-bold">
                            <tr>
                                <th class="p-4">Date Booked</th>
                                <th class="p-4">Patient Name</th>
                                <th class="p-4">Phone</th>
                                <th class="p-4">Service</th>
                                <th class="p-4">Preferred Date</th>
                                <th class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php foreach($appointments as $row): ?>
                            <tr class="hover:bg-blue-50 transition">
                                <td class="p-4 text-gray-500"><?php echo date("d M Y, h:i A", strtotime($row['created_at'])); ?></td>
                                <td class="p-4 font-bold text-slate-800"><?php echo $row['patient_name']; ?></td>
                                <td class="p-4 font-mono text-blue-600"><?php echo $row['phone']; ?></td>
                                <td class="p-4"><span class="bg-slate-100 text-slate-700 px-2 py-1 rounded border"><?php echo $row['service_type']; ?></span></td>
                                <td class="p-4 font-bold"><?php echo $row['preferred_date']; ?></td>
                                <td class="p-4">
                                    <a href="https://wa.me/91<?php echo str_replace(['+',' ','-'], '', $row['phone']); ?>" target="_blank" class="bg-green-100 text-green-700 px-3 py-1.5 rounded-lg font-bold hover:bg-green-200 flex items-center w-fit gap-1 text-xs">
                                        <span class="material-symbols-outlined text-sm">chat</span> WhatsApp
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($appointments)) echo "<tr><td colspan='6' class='p-10 text-center text-gray-400 italic'>No appointments received yet.</td></tr>"; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="imgs" class="tab hidden">
            <form method="POST" enctype="multipart/form-data" class="space-y-8">
                <input type="hidden" name="action" value="upload_images">
                
                <?php if($upload_msg): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl text-center font-bold text-lg animate-bounce">
                        <?php echo $upload_msg; ?>
                    </div>
                <?php endif; ?>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span class="material-symbols-outlined">person</span> Doctor Profile</h3>
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden border">
                            <?php if(val('doctor', $settings)): ?>
                                <img src="<?php echo val('doctor', $settings); ?>" class="w-full h-full object-cover">
                            <?php else: ?><div class="flex h-full items-center justify-center text-gray-300"><span class="material-symbols-outlined">image_not_supported</span></div><?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Upload New Photo</label>
                            <input type="file" name="doctor" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"/>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-slate-800"></div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span class="material-symbols-outlined">home</span> Hero Section</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex justify-between mb-1"><label class="text-xs font-bold text-gray-500 uppercase">Background</label><span class="text-xs text-blue-600 truncate max-w-[150px]"><?php echo val('hero_bg', $settings); ?></span></div>
                            <input type="file" name="hero_bg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"/>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1"><label class="text-xs font-bold text-gray-500 uppercase">Right Side Image</label><span class="text-xs text-blue-600 truncate max-w-[150px]"><?php echo val('hero_main', $settings); ?></span></div>
                            <input type="file" name="hero_main" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"/>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-purple-500"></div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span class="material-symbols-outlined">compare</span> Before & After Slider</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                            <label class="block text-xs font-bold text-purple-600 uppercase mb-2">Before Image</label>
                            <div class="h-32 bg-gray-200 rounded-lg overflow-hidden mb-3">
                                <?php if(val('ba_before', $settings)): ?><img src="<?php echo val('ba_before', $settings); ?>" class="w-full h-full object-cover"><?php endif; ?>
                            </div>
                            <input type="file" name="ba_before" class="w-full text-xs"/>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                            <label class="block text-xs font-bold text-purple-600 uppercase mb-2">After Image</label>
                            <div class="h-32 bg-gray-200 rounded-lg overflow-hidden mb-3">
                                <?php if(val('ba_after', $settings)): ?><img src="<?php echo val('ba_after', $settings); ?>" class="w-full h-full object-cover"><?php endif; ?>
                            </div>
                            <input type="file" name="ba_after" class="w-full text-xs"/>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-cyan-500"></div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span class="material-symbols-outlined">medical_services</span> Services</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <?php 
                        $services = ['laser'=>'Laser Surgery', 'implant'=>'Implants', 'rct'=>'Root Canal', 'kids'=>'Pediatric', 'cosmetic'=>'Cosmetic'];
                        foreach($services as $key => $label): 
                        ?>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1"><?php echo $label; ?></label>
                            <input type="file" name="<?php echo $key; ?>" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-cyan-50 file:text-cyan-700"/>
                            <?php if(val($key, $settings)): ?>
                                <p class="text-[10px] text-green-600 mt-1 truncate">Current: <?php echo val($key, $settings); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="sticky bottom-6">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-2xl hover:bg-blue-700 hover:scale-[1.01] transition transform flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">cloud_upload</span> Upload & Save All Images
                    </button>
                </div>

            </form>
        </div>

    </div>
<?php endif; ?>

</body>
</html>