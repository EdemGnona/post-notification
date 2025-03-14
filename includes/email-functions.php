<?php
if (!defined('ABSPATH')) {
    exit; // Sécurité
}

// Fonction pour envoyer des emails à la publication d'un article
function pn_send_notification_email($post_id, $post) {
    if ($post->post_status !== 'publish') {
        return;
    }
    
    // Récupérer les emails du CPT gb_email
    $emails = [];
    $args = array(
        'post_type'      => 'gb_email',
        'posts_per_page' => -1,
    );
    $email_posts = get_posts($args);
    foreach ($email_posts as $email_post) {
        $email = get_post_meta($email_post->ID, 'gb_email', true);
        if (is_email($email)) {
            $emails[] = $email;
        }
    }
    
    // Ajouter l'email personnalisé s'il est défini
    $custom_email = get_option('pn_recipient_email');
    if (!empty($custom_email) && is_email($custom_email)) {
        $emails[] = $custom_email;
    }
    
    if (empty($emails)) {
        return;
    }
    
    // Récupérer les options de l'email
    $subject = get_option('pn_email_subject', 'Nouvel article publié !');
    $content = get_option('pn_email_content', 'Un nouvel article a été publié : {post_title}. Consultez-le ici : {post_link}');
    
    // Remplacement des variables dynamiques
    $content = str_replace('{post_title}', get_the_title($post_id), $content);
    $content = str_replace('{post_link}', get_permalink($post_id), $content);
    
    // Charger le template de l'email
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/email-template.php';
    $message = ob_get_clean();
    
    // Headers
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Envoi des emails
    foreach ($emails as $email) {
        wp_mail($email, $subject, $message, $headers);
    }
}
add_action('publish_post', 'pn_send_notification_email', 10, 2);
