<?php
// 1. SECURE SESSION HANDLING
$sess_folder = __DIR__ . '/my_sessions';
if (!file_exists($sess_folder)) { mkdir($sess_folder, 0777, true); }
ini_set('session.save_path', $sess_folder);
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
session_start();

require 'db_connect.php';

// 2. DEFINE DEFAULTS
$defaults = [
    'logo'             => '[https://img.icons8.com/color/48/dental-braces.png](https://img.icons8.com/color/48/dental-braces.png)',
    'hero_bg'          => '[https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1600&q=80](https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1600&q=80)',
    'hero_main'        => '[https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80)',
    
    // Doctors
    'doctor_1'         => 'doctor.jpg',
    'doctor_2'         => '[https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=80)',
    
    // Services
    'img_laser'        => '[https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80)',
    'img_implant'      => '[https://images.unsplash.com/photo-1445527697940-6170001a2911?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1445527697940-6170001a2911?auto=format&fit=crop&w=800&q=80)',
    'img_rct'          => '[https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80)',
    'img_kids'         => '[https://images.unsplash.com/photo-1588776813186-6f6d27845688?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1588776813186-6f6d27845688?auto=format&fit=crop&w=800&q=80)',
    'img_cosmetic'     => '[https://images.unsplash.com/photo-1609840114035-1c99d59242cc?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1609840114035-1c99d59242cc?auto=format&fit=crop&w=800&q=80)',
    
    'desc_laser'       => 'Experience painless gum treatments with no bleeding and no sutures.',
    'desc_implant'     => 'We use 3D Computer Guided Surgery to place implants with 100% accuracy.',
    'desc_rct'         => 'Complete your Root Canal Treatment in a single sitting using flexible rotary files.',
    'desc_kids'        => 'We make dentistry fun! From fluoride application to sealants, we ensure your child grows up with a healthy smile.',
    'desc_cosmetic'    => 'Transform your smile with Zirconia crowns, veneers, and laser teeth whitening.',

    // B/A Images
    'ba_implant_b'     => '[https://images.unsplash.com/photo-1571772996211-2f02c9727629?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1571772996211-2f02c9727629?auto=format&fit=crop&w=800&q=80)', 'ba_implant_a' => '[https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=800&q=80)',
    'ba_veneer_b'      => '[https://plus.unsplash.com/premium_photo-1661775756810-82dbd209fc95?auto=format&fit=crop&w=800&q=80](https://plus.unsplash.com/premium_photo-1661775756810-82dbd209fc95?auto=format&fit=crop&w=800&q=80)', 'ba_veneer_a' => '[https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80)',
    'ba_cleaning_b'    => '[https://images.unsplash.com/photo-1609840114035-1c99d59242cc?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1609840114035-1c99d59242cc?auto=format&fit=crop&w=800&q=80)', 'ba_cleaning_a' => '[https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80)',
    'ba_fmr_b'         => '[https://images.unsplash.com/photo-1445527697940-6170001a2911?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1445527697940-6170001a2911?auto=format&fit=crop&w=800&q=80)', 'ba_fmr_a' => '[https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80)',
    'ba_restoration_b' => '[https://images.unsplash.com/photo-1571772996211-2f02c9727629?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1571772996211-2f02c9727629?auto=format&fit=crop&w=800&q=80)', 'ba_restoration_a' => '[https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=800&q=80)',
    'ba_gbt_b'         => '[https://images.unsplash.com/photo-1588776813186-6f6d27845688?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1588776813186-6f6d27845688?auto=format&fit=crop&w=800&q=80)', 'ba_gbt_a' => '[https://images.unsplash.com/photo-1609840114035-1c99d59242cc?auto=format&fit=crop&w=800&q=80](https://images.unsplash.com/photo-1609840114035-1c99d59242cc?auto=format&fit=crop&w=800&q=80)',

    // Contact & Text
    'phone'            => '092313 28309',
    'whatsapp'         => '919231328309',
    'location_short'   => 'Budge Budge, Kolkata',
    'address_full'     => '15/1/A, AL Daw Rd, Joychandipur, Budge Budge, Kolkata 700137',
    'map_url'          => '[https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3686.866898765432!2d88.345678!3d22.456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDI3JzI0LjQiTiA4OMKwMjAnNDQuNCJF!5e0!3m2!1sen!2sin!4v1600000000000!5m2!1sen!2sin](https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3686.866898765432!2d88.345678!3d22.456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDI3JzI0LjQiTiA4OMKwMjAnNDQuNCJF!5e0!3m2!1sen!2sin!4v1600000000000!5m2!1sen!2sin)',
    
    'hours_morn'       => '9:00 AM – 12:30 PM',
    'hours_eve'        => '5:00 PM – 8:30 PM',
    
    'link_fb'          => '#',
    'link_insta'       => '#',
    'link_yt'          => '#',
    
    'hero_h1'          => 'Advanced Dentistry',
    'hero_sub'         => 'Reimagined.',
    'hero_desc'        => 'The only clinic in Budge Budge to introduce laser surgery.',
    
    'doc1_name'        => 'Dr. Shiv Bhusan Pandey',
    'doc1_title'       => 'Lead Dentist & Implantologist',
    'doc2_name'        => 'Dr. Aditi Sharma',
    'doc2_title'       => 'Orthodontist & Cosmetic Specialist',
    'about_bio'        => 'Welcome to <strong>Pearls Shine Oral and Dental Care</strong>. We are proud to be the <strong>only clinic</strong> in Budge Budge to introduce revolutionary technologies.',
    
    'rev1_name' => 'Rahul S.', 'rev1_text' => 'Best dental clinic in Budge Budge. Very detailed consultation.',
    'rev2_name' => 'Priya M.', 'rev2_text' => 'My child was scared but the team here made her very comfortable.',
    'rev3_name' => 'Debarati Roy', 'rev3_text' => 'Dr. Pandey immediately diagnosed the issue. Pain gone!',
    'rev4_name' => 'Krishnapada M.', 'rev4_text' => 'Thanks for explaining the need for implants so clearly.'
];

$site = [];
$res = $conn->query("SELECT * FROM site_settings");
if($res) {
    while($row = $res->fetch_assoc()) {
        $site[$row['setting_key']] = $row['setting_value'];
    }
}
$site = array_merge($defaults, $site);

// THIS FUNCTION IS CRITICAL
function val($key) { 
    global $site; 
    return isset($site[$key]) ? $site[$key] : ''; 
}
?>