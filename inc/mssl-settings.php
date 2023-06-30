<?php 

class MSSL_Settings {
	/**
	 * Capability required by the user to access the My Plugin menu entry.
	 *
	 * @var string $capability
	 */
	private $capability = 'manage_network_options';

    /**
     * This will be used for the SubMenu URL in the settings page and to verify which variables to save.
     *
     * @var string
     */
    protected $settings_slug = 'mssl-custom-settings-page';
  
    /**
     * Class Constructor.
     */
    public function __construct() {
        // Register function for settings page creation.
        add_action( 'network_admin_menu', array( $this, 'menu_and_fields' ) );
        add_action( 'network_admin_edit_' . $this->settings_slug . '-update', array( $this, 'update' ) );

    }

    /**
     * Creates the sub-menu page and register the multisite settings.
     *
     * @return void
     */
    public function menu_and_fields() {

        // Create the submenu and register the page creation function.
        add_submenu_page(
            'settings.php',
            __( 'Multisite Settings Page', 'multisite-settings' ),
            __( 'Custom Settings', 'multisite-settings' ),
            'manage_network_options',
            $this->settings_slug,
            array( $this, 'create_page' )
        );

        // Register a new section on the page.
        add_settings_section(
            'default-section',
            __( 'This the first and only section', 'multisite-settings' ),
            array( $this, 'section_first' ),
            $this->settings_slug
        );

        // Register a variable and add a field to update it.
        register_setting( $this->settings_slug, 'first_input_var' );

        add_settings_field(
            'test-input',
            __( 'This is the first input', 'multisite-settings' ),
            array( $this, 'dropdown_option_0_callback' ), // callback.
            $this->settings_slug, // page.
            'default-section', // section.
            array(
                'label_for' => 'select',
            )
        );
    }


    public function dropdown_option_0_callback() {
        ?> <select name="dropdown_option_setting_option_name[dropdown_option_0]" id="dropdown_option_0">

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-one') ? 'selected' : '' ; ?>
            <option value="dashboard" <?php echo $selected; ?>>Dashboard</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-two') ? 'selected' : '' ; ?>
            <option value="visit-site" <?php echo $selected; ?>>Visit Site</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-three') ? 'selected' : '' ; ?>
            <option value="new-post" <?php echo $selected; ?>>New Post</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-three') ? 'selected' : '' ; ?>
            <option value="new-page" <?php echo $selected; ?>>New Page</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-three') ? 'selected' : '' ; ?>
            <option value="plugins" <?php echo $selected; ?>>Plugins</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-three') ? 'selected' : '' ; ?>
            <option value="themes" <?php echo $selected; ?>>Themes</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-three') ? 'selected' : '' ; ?>
            <option value="users" <?php echo $selected; ?>>Users</option>

            <?php if ( is_plugin_active( 'wp-ultimo/wp-ultimo.php' ) ) : ?>

            <option disabled>----------</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-three') ? 'selected' : '' ; ?>
            <option value="ultimo-settings" <?php echo $selected; ?>>WP-Ultimo Settings</option>

            <?php $selected = (isset( $this->dropdown_option_setting_options['dropdown_option_0'] ) && $this->dropdown_option_setting_options['dropdown_option_0'] === 'option-three') ? 'selected' : '' ; ?>
            <option value="ultimo-membership" <?php echo $selected; ?>>WP-Ultimo Membership</option>

            <?php endif; ?>

        </select> <?php
    }

    /**
     * This creates the settings page itself.
     */
    public function create_page() {
    
        if ( isset( $_GET['updated'] ) ) : ?>
            <div id="message" class="updated notice is-dismissible">
                <p><?php esc_html_e( 'Options Saved', 'multisite-settings' ); ?></p>
            </div>
        <?php endif; ?>
            <div class="wrap">
                <h1><?php echo esc_attr( get_admin_page_title() ); ?></h1>
                <form action="edit.php?action=<?php echo esc_attr( $this->settings_slug ); ?>-update" method="POST">
                    <?php
                        settings_fields( $this->settings_slug );
                        do_settings_sections( $this->settings_slug );
                        submit_button();
                    ?>
                </form>
            </div>
        <?php  }


    /**
     * Html after the new section title.
     *
     * @return void
     */
    public function section_first() { ?>
        <div class='site-example'>
            <div class="mssl-setting-network-admin-example">
                <h3><a href="http://flauntsites.local/wp-admin/network/sites.php" style="font-weight: bold;">Network Admin</a></h3>
                <ul>
                    <li><a href="http://flauntsites.local/wp-admin/network/">Dashboard</a></li>
                    <li><a href="http://flauntsites.local/wp-admin/network/sites.php">Sites</a></li>
                    <li><a href="http://flauntsites.local/wp-admin/network/users.php">Users</a></li>
                    <li><a href="http://flauntsites.local/wp-admin/network/themes.php">Themes</a></li>
                    <li><a href="http://flauntsites.local/wp-admin/network/plugins.php">Plugins</a></li>
                    <li><a href="http://flauntsites.local/wp-admin/network/settings.php">Settings</a></li>
                </ul>
                <input id="search" type="text" placeholder="Search for your site">
            </div>

            <div class="mssl-setting-site-example">
                <img src="http://flauntsites.local/wp-content/uploads/2020/04/cropped-FlauntSitesIcon.png" class="mssl-favicon" alt="">
                <span class="mssl-site-id">10</span>
                <h3 class="mssl-site-name"><a href="http://padang-padang.flauntsites.local/">Padang Padang</a></h3>
                <a class="mssl-site-function" href="http://padang-padang.flauntsites.local/wp-admin/">Dashboard</a>
                <a class="mssl-site-function" href="http://padang-padang.flauntsites.local/">Visit Site</a>
                <a class="mssl-site-function" href="http://padang-padang.flauntsites.local/wp-admin/post-new.php">New Post</a>
                <a class="mssl-site-function" href="http://padang-padang.flauntsites.local/wp-admin/post-new.php?post_type=page">New Page</a>
                <a class="mssl-site-function" href="http://padang-padang.flauntsites.local/wp-admin/plugins.php">Plugins</a>
            </div>
        </div>
    <?php }

    /**
     * Creates and input field.
     *
     * @return void
     */
    public function field_first_input() {
        $val = get_site_option( 'first_input_var', '' );
        echo '<input type="text" name="first_input_var" value="' . esc_attr( $val ) . '" />';
    }

    /**
     * Multisite options require its own update function. Here we make the actual update.
     */
    public function update() {
        check_admin_referer( $this->settings_slug . '-options' );
        global $new_whitelist_options;

        $options = $new_whitelist_options[ $this->settings_slug ];

        foreach ( $options as $option ) {
            if ( isset( $_POST[ $option ] ) ) {
                update_site_option( $option, $_POST[ $option ] );
            } else {
                delete_site_option( $option );
            }
        }

        wp_safe_redirect(
            add_query_arg(
                array(
                'page'    => $this->settings_slug,
                'updated' => 'true',
                ),
                network_admin_url( 'settings.php' )
            )
        );
        exit;
    }

}
// Initialize the execution.
new MSSL_Settings();