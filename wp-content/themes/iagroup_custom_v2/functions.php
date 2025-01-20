<?php
/**
 * Blocksy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blocksy
 */

if (version_compare(PHP_VERSION, '5.7.0', '<')) {
	require get_template_directory() . '/inc/php-fallback.php';
	return;
}

require get_template_directory() . '/inc/init.php';

function mytheme_enqueue_styles() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');

// การตั้งค่า Cookies ด้วย PHP
add_action('init', 'set_custom_cookie');
function set_custom_cookie() {
    if (!isset($_COOKIE['custom_cookie'])) {
        setcookie('custom_cookie', 'value', time() + 3600, COOKIEPATH, COOKIE_DOMAIN);
    }
}

// การแสดงข้อความแจ้งเตือนด้วย PHP
add_action('wp_footer', 'display_cookie_notice');
function display_cookie_notice() {
    if (!isset($_COOKIE['accept_cookies'])) {
        echo '<div id="cookie-notice">
                This site uses cookies. <button id="accept-cookies">Accept</button>
              </div>';
    }
}

function enqueue_contact_form_script() {
    // โหลด jQuery
    wp_enqueue_script('jquery');
    
    // โหลด reCAPTCHA Script (Google)
    wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);

    // โหลด contact-us-form.js
    wp_enqueue_script('contact-form', get_template_directory_uri() . '/js/contact-us-form.js', array('jquery'), null, true);

    // ส่งค่า ajax_url ไปยัง JavaScript
    wp_localize_script('contact-form', 'contactFormAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_contact_form_script');


function handle_contact_form() {
    global $wpdb;

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $fullName =  $firstName . ' ' . ($lastName ? $lastName : '');
    $email = $_POST['email'];
    $phone = $_POST['phonenumber'];
    $message = $_POST['message'];
    
    if ( !empty($fullName) && !empty($email) && !empty($message) ) {
        $recaptcha_secret = '6Lf9cbIqAAAAAKL0_RzuzhiQoc8tYXxFs5Y77Rny';
        $recaptcha_response = $_POST['recaptcha_response'];
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response;
        $response = wp_remote_post($url, array(
            'method'    => 'POST',
        ));
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body);

        if ($result->success) {
            $table_name = $wpdb->prefix . 'contact_us';
            $wpdb->insert($table_name, [
                'name' => $fullName,
                'email' => $email,
                'phone_number' => $phone,
                'message' => $message,
                'date' => current_time('mysql'),
            ]);

            $to = 'warawutm@iagroupcompany.com';
            $subject = 'Form Contact Submission';
            $msg = 'Name: ' . $fullName . "\n";
            $msg .= 'Phone number: ' . $phone . "\n";
            $msg .= 'Email: ' . $email . "\n";
            $msg .= 'Message: ' . $message . "\n";
    
            $headers = array('Content-Type: text/plain; charset=UTF-8');
    
            wp_mail($to, $subject, $msg, $headers);
            wp_send_json_success('Form submitted successfully.');
        } else {
            wp_send_json_error('reCAPTCHA validation failed.');
        }
    } else {
        wp_send_json_error('Missing required fields.');
    }

    wp_die();
}

add_action('wp_ajax_contact_form', 'handle_contact_form');
add_action('wp_ajax_nopriv_contact_form', 'handle_contact_form');

function get_job_listings() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'job_listings'; // เปลี่ยนชื่อตารางถ้าคุณใช้ prefix
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

    return $results;
}

function get_job_details($job_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'job_listings';
    $job = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $job_id));

    return $job;
}

function job_listings_shortcode() {
    $jobs = get_job_listings(); // ดึงข้อมูลจากฐานข้อมูล
    ob_start(); // เริ่มการเก็บข้อมูลที่จะแสดงผลใน buffer
    
    if ( !empty($jobs) ) {
        echo '<div class="job-listings"><h1>Current Job Openings</h1>';
        foreach ( $jobs as $job ) {
            echo '<div class="job-item">';
            echo '<h2>' . esc_html($job->job_title) . '</h2>';
            echo '<div class="job-excerpt">';
            echo '<p>' . wp_trim_words(esc_html($job->job_description), 30, '...') . '</p>';
            echo '<a href="' . get_permalink() . '?job_id=' . $job->id . '">View Details</a>';
            echo '</div></div>';
        }
        echo '</div>';
    } else {
        echo '<p>No job openings available at the moment.</p>';
    }

    return ob_get_clean(); // ส่งคืนเนื้อหาที่เก็บไว้ใน buffer
}
add_shortcode('job_listings', 'job_listings_shortcode');



function job_detail_shortcode($atts) {
    $atts = shortcode_atts( array(
        'job_id' => 0,
    ), $atts );

    $job_id = intval($atts['job_id']);
    $job = get_job_details($job_id);

    if ( $job ) {
        ob_start();
        echo '<div class="job-detail">';
        echo '<h1>' . esc_html($job->job_title) . '</h1>';
        echo '<div class="job-content">';
        echo '<p>' . esc_html($job->job_description) . '</p>';
        echo '<h3>Requirements</h3>';
        echo '<p>' . esc_html($job->job_requirements) . '</p>';
        echo '</div></div>';
        return ob_get_clean();
    } else {
        return '<p>Job details not found.</p>';
    }
}
add_shortcode('job_detail', 'job_detail_shortcode');

