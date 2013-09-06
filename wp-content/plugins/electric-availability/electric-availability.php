<?php
/*
  Plugin Name: Electric Availability
  Description: Easy way to display your availability to accept new work
  Author: Carlos Morales
  Author URI: http://www.cmorales.es
  Version: 0.1
 */
  define( 'ELECTRICAVAILABILITY_PATH', plugin_dir_path(__FILE__) );
  class electric_availability_options {

    protected $textdomain = "electric_availability";
    protected $editor_settings = array();

    function __construct() {
      add_action('admin_init', array(&$this, 'init'));
      add_action('admin_menu', array(&$this, 'add_menu_page'));
      $this->editor_settings = array(
                'media_buttons' => false,
                'textarea_rows' => 5,
                'teeny' => true,
                'editor_css' => '<style>.mceIframeContainer {background: white;}</style>'
        );
    }

    function add_menu_page() {
      $options_page = add_options_page(
                __('Electric Availability Options', $this->textdomain), // Name of page (html title)
                __('Electric Availability Options', $this->textdomain), // Label in menu
                'manage_options', // Capability required
                'electric_availability_options_page', // Menu slug, used to uniquely identify the page
                array(&$this, 'render_page')
                );
    }

    function init() {
      register_setting(
                'electric_availability_options', //Options name
                'electric_availability_options', //DB entry
                array($this, 'validate') //Validate callback
                );

// Register our settings field group
      add_settings_section(
                'electric_availability_general', // Unique identifier for the settings section
                '', // Section title (we don't want one)
                '__return_false', // Section callback (we don't want anything)
                'electric_availability_options_page' // Menu slug, used to uniquely identify the page; see add_menu_page()
                );


//General fields
      add_settings_field('electric_availability_load_icons', __('Load icons?', $this->textdomain), array($this, 'render_load_icons_field'), 'electric_availability_options_page', 'electric_availability_general');
      add_settings_field('electric_availability_status', __('Your availability status', $this->textdomain), array($this, 'render_status_field'), 'electric_availability_options_page', 'electric_availability_general');
      add_settings_field('electric_availability_link', __('Where is the widget going to lead?', $this->textdomain), array($this, 'render_link_field'), 'electric_availability_options_page', 'electric_availability_general');
      add_settings_field('electric_availability_low_text', __('Low level text', $this->textdomain), array($this, 'render_low_level_text'), 'electric_availability_options_page', 'electric_availability_general');
      add_settings_field('electric_availability_med_text', __('Medium level text', $this->textdomain), array($this, 'render_med_level_text'), 'electric_availability_options_page', 'electric_availability_general');
      add_settings_field('electric_availability_high_text', __('High level text', $this->textdomain), array($this, 'render_high_level_text'), 'electric_availability_options_page', 'electric_availability_general');
    }

    /**
     * Renders the options page.
     *
     * @since Electric Availability 0.1
     */
    function render_page() {
      ?>
      <div class="wrap">

        <h2><?php _e('Electric Availability Options', $this->textdomain) ?></h2>
        <p><?php _e('Choose your availability status, the text displayed or whether to load the styles or use your own', $this->textdomain) ?>.</p>
        <form method="post" action="options.php">
          <?php
          settings_fields('electric_availability_options');
          do_settings_sections('electric_availability_options_page');
          submit_button();
          ?>
        </form>
      </div>
      <?php
    }

    /**
     * Renders the load icons checkbox
     *
     * @since Electric Availability 0.1
     */
    function render_load_icons_field() {
      $options = $this->get_options();
      ?>
      <label for="load-icons" class="description">
        <input type="checkbox" name="electric_availability_options[load_icons]" id="load-icons" <?php checked('on', $options['load_icons']); ?> />
        <?php _e('Uncheck if you use your own set of icons (or the ones included with the Electric Theme)', $this->textdomain); ?>
      </label>
      <?php
    }

    /**
     * Renders the input field for the link
     *
     * @since Electric Availability 0.1
     */
    function render_link_field() {
      $options = $this->get_options();
        ?>
         <input type="url" name="electric_availability_options[link]" id="link" value="<?php echo esc_attr($options['link']); ?>" />
      <?php
    }

    /**
     * Renders the input field for the low level text
     *
     * @since Electric Availability 0.1
     */
    function render_low_level_text() {
      $options = $this->get_options();
        ?>
        <?php wp_editor( $options['low_level_text'], "electric_availability_options[low_level_text]", $this->editor_settings); ?>
      <?php
    }

    /**
     * Renders the input field for the medium  level text
     *
     * @since Electric Availability 0.1
     */
    function render_med_level_text() {
      $options = $this->get_options();
        ?>
        <?php wp_editor( $options['med_level_text'], "electric_availability_options[med_level_text]", $this->editor_settings); ?>
      <?php
    }

    /**
     * Renders the input field for the high level text
     *
     * @since Electric Availability 0.1
     */
    function render_high_level_text() {
       $options = $this->get_options();
        ?>
        <?php wp_editor( $options['high_level_text'], "electric_availability_options[high_level_text]", $this->editor_settings); ?>
      <?php
    }

    /**
     * Renders the availability options setting field.
     *
     * @since Electric Availability 0.1
     */
    function render_status_field() {
      $options = $this->get_options();

      foreach ($this->status_field() as $button) {
        ?>
        <label class="description">
          <input type="radio" name="electric_availability_options[status_field]" value="<?php echo esc_attr($button['value']); ?>" <?php checked($options['status_field'], $button['value']); ?> />
          <?php echo $button['label']; ?>
        </label>

        <?php } ?>
        <p class="description">
          <?php _e("Low = You can't accept new jobs, high = you are free to accept new jobs", $this->textdomain) ?>
        </p>
        <?php
      }

    /**
     * Returns an array of availability levels
     *
     * @since Electric Availability 0.1
     */
    function status_field() {
      $status_field = array(
        'low' => array(
          'value' => 'low',
          'label' => __('Low', $this->textdomain)
          ),
        'med' => array(
          'value' => 'med',
          'label' => __('Medium', $this->textdomain)
          ),
        'high' => array(
          'value' => 'high',
          'label' => __('High', $this->textdomain)
          )
        );

      return apply_filters('electric_availability_status_field', $status_field);
    }

    /**
     * Returns the options array
     *
     * @since Electric Availability 0.1
     */
    function get_options() {
      $saved = (array) get_option('electric_availability_options');
      $defaults = array(
        'load_icons' => 'off',
        'status_field' => 'med',
        'low_level_text' => '',
        'med_level_text' => '',
        'high_level_text' => '',
        'link' => ''
        );

      $defaults = apply_filters('electric_availability_default_options', $defaults);

      $options = wp_parse_args($saved, $defaults);
      $options = array_intersect_key($options, $defaults);

      return $options;
    }

    function validate($input) {
      $output = array();

      if (isset($input['load_icons']))
        $output['load_icons'] = 'on';

// The status field button value must be in our array of radio button values
      if (isset($input['status_field']) && array_key_exists($input['status_field'], $this->status_field()))
        $output['status_field'] = $input['status_field'];


      if (isset($input['low_level_text'])) {
        $output['low_level_text'] = wp_kses_data($input['low_level_text']);
      }
      if (isset($input['med_level_text'])) {
        $output['med_level_text'] = wp_kses_data($input['med_level_text']);
      }
      if (isset($input['high_level_text'])) {
        $output['high_level_text'] = wp_kses_data($input['high_level_text']);
      }

      if (isset($input['link'])) {
        $output['link'] = esc_url_raw($input['link']);
      }

      return apply_filters('electric_availability_options_validate', $output, $input);
    }
  }

  class electric_availability {

    public $textdomain = "electric_availability";

    function __construct() {
      add_action('wp_enqueue_scripts', array(&$this, 'add_styles'));
    }

    function add_styles(){

      $options = get_option('electric_availability_options');
      //Check if icon Fonts are used
      if(!empty($options['load_icons']) ){
        wp_enqueue_style('electric-availability-icons', plugins_url('fonts/style.css', __FILE__) );
      }
    }
  }

  new electric_availability_options;
  new electric_availability;

  require ELECTRICAVAILABILITY_PATH . 'widget.php';

