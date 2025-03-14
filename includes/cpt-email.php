<?php
if (!defined('ABSPATH')) {
    exit; // Sécurité
}

// Création du Custom Post Type gb_email
function gb_register_email_cpt() {
    $args = array(
        'labels'      => array(
            'name'          => 'Emails',
            'singular_name' => 'Email',
        ),
        'public'      => true,
        'has_archive' => false,
        'menu_position' => 25,
        'supports'    => array('title'),
    );
    register_post_type('gb_email', $args);
}
add_action('init', 'gb_register_email_cpt');

// Ajout des champs personnalisés au Custom Post Type gb_email
function gb_add_custom_meta_boxes() {
    add_meta_box('gb_email_meta', 'Informations Email', 'gb_email_meta_callback', 'gb_email', 'normal', 'high');
}
add_action('add_meta_boxes', 'gb_add_custom_meta_boxes');

function gb_email_meta_callback($post) {
    $nom = get_post_meta($post->ID, 'gb_nom', true);
    $email = get_post_meta($post->ID, 'gb_email', true);
    ?>
    <p>
        <label for="gb_nom">Nom :</label>
        <input type="text" id="gb_nom" name="gb_nom" value="<?php echo esc_attr($nom); ?>" class="widefat" />
    </p>
    <p>
        <label for="gb_email">Email :</label>
        <input type="email" id="gb_email" name="gb_email" value="<?php echo esc_attr($email); ?>" class="widefat" />
    </p>
    <?php
}

// Sauvegarde des champs personnalisés
function gb_save_email_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['gb_nom']) || !isset($_POST['gb_email'])) return;
    update_post_meta($post_id, 'gb_nom', sanitize_text_field($_POST['gb_nom']));
    update_post_meta($post_id, 'gb_email', sanitize_email($_POST['gb_email']));
}
add_action('save_post', 'gb_save_email_meta');
