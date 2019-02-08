<?php
if(!defined('ABSPATH')) {
    exit;
}
class WP_First_Letter_Avatar_Config
{
    private $options;
    public function __construct()
    {
        add_action('admin_menu', array(
            $this,
            'add_admin_menu'
        ));
        add_action('admin_init', array(
            $this,
            'settings_init'
        ));
    }
    public function add_admin_menu()
    {
        add_options_page('WP First Letter Avatar', 'WP First Letter Avatar', 'manage_options', 'wp_first_letter_avatar', array(
            $this,
            'options_page'
        ));
    }
    public function settings_init()
    {
        register_setting('wpfla_pluginPage', 'wpfla_settings');
        add_settings_section('wpfla_pluginPage_section', __('Plugin configuration', 'aka-first-letter-avatar'), array(
            $this,
            'settings_section_callback'
        ), 'wpfla_pluginPage');
        add_settings_field('wpfla_letter_index', __('Letter index', 'aka-first-letter-avatar') . '<br/>' . __('Default:', 'aka-first-letter-avatar') . ' 0', array(
            $this,
            'letter_index_render'
        ), 'wpfla_pluginPage', 'wpfla_pluginPage_section');
        add_settings_field('wpfla_file_format', __('File format', 'aka-first-letter-avatar') . '<br/>' . __('Default:', 'aka-first-letter-avatar') . ' png', array(
            $this,
            'file_format_render'
        ), 'wpfla_pluginPage', 'wpfla_pluginPage_section');
        add_settings_field('wpfla_unknown_image', __('Unknown image name', 'aka-first-letter-avatar') . '<br/>' . __('Default:', 'aka-first-letter-avatar') . ' mystery', array(
            $this,
            'unknown_image_render'
        ), 'wpfla_pluginPage', 'wpfla_pluginPage_section');
        add_settings_field('wpfla_avatar_set', __('Avatar set', 'aka-first-letter-avatar') . '<br/>' . __('Default:', 'aka-first-letter-avatar') . ' default', array(
            $this,
            'avatar_set_render'
        ), 'wpfla_pluginPage', 'wpfla_pluginPage_section');
        add_settings_field('wpfla_use_gravatar', __('Use Gravatar', 'aka-first-letter-avatar') . '<br/>' . __('Default:', 'aka-first-letter-avatar') . ' ' . __('check', 'aka-first-letter-avatar'), array(
            $this,
            'use_gravatar_render'
        ), 'wpfla_pluginPage', 'wpfla_pluginPage_section');
        add_settings_field('wpfla_round_avatars', __('Round avatars', 'aka-first-letter-avatar') . '<br/>' . __('Default:', 'aka-first-letter-avatar') . ' ' . __('uncheck', 'aka-first-letter-avatar'), array(
            $this,
            'round_avatars_render'
        ), 'wpfla_pluginPage', 'wpfla_pluginPage_section');
        add_settings_field('wpfla_filter_priority', __('Plugin filter priority', 'aka-first-letter-avatar') . '<br/>' . __('Default:', 'aka-first-letter-avatar') . ' 10', array(
            $this,
            'filter_priority_render'
        ), 'wpfla_pluginPage', 'wpfla_pluginPage_section');
    }
    public function letter_index_render()
    {
?>
		<input style="width:40px;" type='text' name='wpfla_settings[wpfla_letter_index]' value='<?php
        if(array_key_exists('wpfla_letter_index', $this->options))
            echo $this->options['wpfla_letter_index'];
?>' />
	<?php
    }
    public function file_format_render()
    {
?>
		<input style="width: 100px;" type='text' name='wpfla_settings[wpfla_file_format]' value='<?php
        if(array_key_exists('wpfla_file_format', $this->options))
            echo $this->options['wpfla_file_format'];
?>' />
	<?php
    }
    public function unknown_image_render()
    {
?>
		<input type='text' name='wpfla_settings[wpfla_unknown_image]' value='<?php
        if(array_key_exists('wpfla_unknown_image', $this->options))
            echo $this->options['wpfla_unknown_image'];
?>' />
	<?php
    }
    public function avatar_set_render()
    {
?>
		<input type='text' name='wpfla_settings[wpfla_avatar_set]' value='<?php
        if(array_key_exists('wpfla_avatar_set', $this->options))
            echo $this->options['wpfla_avatar_set'];
?>' />
	<?php
    }
    public function use_gravatar_render()
    {
?>
		<input type='checkbox' name='wpfla_settings[wpfla_use_gravatar]' <?php
        if(array_key_exists('wpfla_use_gravatar', $this->options))
            checked($this->options['wpfla_use_gravatar'], 1);
?> value='1' />
	<?php
    }
    public function round_avatars_render()
    {
?>
		<input type='checkbox' name='wpfla_settings[wpfla_round_avatars]' <?php
        if(array_key_exists('wpfla_round_avatars', $this->options))
            checked($this->options['wpfla_round_avatars'], 1);
?> value='1' />
	<?php
    }
    public function filter_priority_render()
    {
?>
		<input type='text' name='wpfla_settings[wpfla_filter_priority]' value='<?php
        if(array_key_exists('wpfla_filter_priority', $this->options))
            echo $this->options['wpfla_filter_priority'];
?>' />
	<?php
    }
    public function settings_section_callback()
    {
        $this->options = get_option('wpfla_settings');
    }
    public function options_page()
    {
?>
		<form action='options.php' method='post'>

			<h2>WP First Letter Avatar</h2>

			<?php
        settings_fields('wpfla_pluginPage');
        do_settings_sections('wpfla_pluginPage');
        submit_button();
?>

			<hr />

			<h3><?php
        _e('Fields description:', 'aka-first-letter-avatar');
?></h3>
			<p>
				<strong><?php
        _e('Letter index', 'aka-first-letter-avatar');
?></strong><br />
				<?php
        echo sprintf(__('%s use first letter for the avatar; %s use second letter; %s use last letter, etc.', 'aka-first-letter-avatar'), '<span style="text-decoration: underline">0</span>:', '<span style="text-decoration: underline">1</span>:', '<span style="text-decoration: underline">-1</span>:');
?>
			</p>
			<p>
				<strong><?php
        _e('File format', 'aka-first-letter-avatar');
?></strong><br />
				<?php
        echo sprintf(__('File format of your avatars, for example %s or %s.', 'aka-first-letter-avatar'), '<span style="text-decoration: underline">png</span>', '<span style="text-decoration: underline">jpg</span>');
?>
			</p>
			<p>
				<strong><?php
        _e('Unknown image name', 'aka-first-letter-avatar');
?></strong><br />
				<?php
        _e('Name of the file used for unknown usernames (without extension).', 'aka-first-letter-avatar');
?>
			</p>
			<p>
				<strong><?php
        _e('Avatar set', 'aka-first-letter-avatar');
?></strong><br />
				<?php
        _e('Directory where your avatars are stored. Supplied sets: "default", "opensans" and "roboto".', 'aka-first-letter-avatar');
?>
			</p>
			<p>
				<strong><?php
        _e('Use Gravatar', 'aka-first-letter-avatar');
?></strong><br />
				<?php
        echo sprintf(__('%sCheck%s: use Gravatar when available; %sUncheck%s: always use custom avatars.', 'aka-first-letter-avatar'), '<span style="text-decoration: underline">', '</span>', '<span style="text-decoration: underline">', '</span>');
?>
			</p>
			<p>
				<strong><?php
        _e('Round avatars', 'aka-first-letter-avatar');
?></strong><br />
				<?php
        echo sprintf(__('%sCheck%s: use rounded avatars; %sUncheck%s: use standard avatars. This may not always work - your theme may override this setting.', 'aka-first-letter-avatar'), '<span style="text-decoration: underline">', '</span>', '<span style="text-decoration: underline">', '</span>');
?>
			</p>
			<p>
				<strong><?php
        _e('Filter priority', 'aka-first-letter-avatar');
?></strong><br />
				<?php
        _e('If you are using multiple avatar plugins, you can increase or decrease execution priority of this plugin. If WP First Letter Avatar is overriding your other plugins, try changing this to a lower value (for example 9).', 'aka-first-letter-avatar');
?>
			</p>
			<p><?php
        _e('In case of any problems, please use default values.', 'aka-first-letter-avatar');
?></p>

			<hr />

			<p style="text-align: right; margin-right:30px"><?php
        $ending_text = sprintf(__('If you like the plugin, please <a href="%s">leave a rating in WordPress Plugin Directory</a>!', 'aka-first-letter-avatar'), 'https://wordpress.org/support/view/plugin-reviews/aka-first-letter-avatar#postform');
        $ending_text .= '<br />';
        $ending_text .= sprintf(__('WP First Letter Avatar was created by <a href="%s">Daniel Wroblewski</a>', 'aka-first-letter-avatar'), 'http://dev49.net/');
        echo $ending_text;
?></p>

		</form>
	<?php
    }
}
