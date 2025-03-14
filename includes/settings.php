<?php
if (!defined('ABSPATH')) {
    exit; // Sécurité
}

// Ajouter la page d'administration
function pn_add_admin_menu() {
    add_options_page('Post Notification', 'Post Notification', 'manage_options', 'post_notification', 'pn_settings_page');
}
add_action('admin_menu', 'pn_add_admin_menu');

// Enregistrement des paramètres
function pn_register_settings() {
    register_setting('pn_options_group', 'pn_email_subject');
    register_setting('pn_options_group', 'pn_email_content');
    register_setting('pn_options_group', 'pn_recipient_email');
}
add_action('admin_init', 'pn_register_settings');

// Affichage de la page des paramètres
function pn_settings_page() {
    ?>
    <div class="wrap">
        <h1>Post Notification</h1>
        <form method="post" action="options.php">
            <?php settings_fields('pn_options_group'); ?>
            <?php do_settings_sections('pn_options_group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Sujet de l'email</th>
                    <td><input type="text" name="pn_email_subject" value="<?php echo esc_attr(get_option('pn_email_subject', 'Nouvel article publié !')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row">Contenu de l'email</th>
                    <td>
                        <?php
                        $content = get_option('pn_email_content', 'Un nouvel article a été publié : {post_title}. Consultez-le ici : {post_link}');
                        wp_editor($content, 'pn_email_content', array('textarea_name' => 'pn_email_content', 'media_buttons' => false, 'textarea_rows' => 10));
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Email personnalisé</th>
                    <td><input type="email" name="pn_recipient_email" value="<?php echo esc_attr(get_option('pn_recipient_email', '')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
