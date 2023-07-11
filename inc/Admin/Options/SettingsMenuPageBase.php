<?php

namespace HP_SEO_ANALYZER\Admin\Options;
use HP_SEO_ANALYZER\Admin\Options\IOptionPageSaveInterface;

abstract class SettingsMenuPageBase {
    protected $pageTitle;
    protected $menuTitle;
    protected $capability;
    protected $menuSlug;
    protected $templateFile;
    protected $allowedUserCapabilities;
    protected $saveCallback;

	/**
	 * OptionPageBase constructor.
	 * @param String $pageTitle The text to be displayed in the title tags of the page when the menu is selected
	 * @param String $menuTitle The text to be used for the menu
	 * @param String $capability The capability required for this menu to be displayed to the user
	 * @param String $menuSlug The slug name to refer to this menu by (should be unique for this menu)
	 * @param String $templateFile The template file to be used for rendering the option page
	 * @param array $allowedUserCapabilities The capabilities that are allowed to access the option page
	 * @param IOptionPageSaveInterface $saveCallback The callback function to be called on submit of the option page
	*/

    public function __construct(
		String $pageTitle,
		String $menuTitle,
		String $capability,
		String $menuSlug,
		String $templateFile,
		Array $allowedUserCapabilities,
		IOptionPageSaveInterface $saveCallback
	) {
        $this->pageTitle = __($pageTitle, HP_SEO_ANALYZER_TEXT_DOMAIN);
        $this->menuTitle = __($menuTitle, HP_SEO_ANALYZER_TEXT_DOMAIN);
        $this->capability = $capability;
        $this->menuSlug = $menuSlug;
        $this->templateFile = HP_SEO_ANALYZER_VIEWS . '/' . $templateFile;
		$this->allowedUserCapabilities = $allowedUserCapabilities;
        $this->saveCallback = $saveCallback;
        // Additional parameters can be assigned to class properties or used as needed
        // For example: $this->additionalParam = $additionalParams['paramName'];

        add_action('admin_menu', [$this, 'registerOptionPage']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    public function registerOptionPage() {
        add_options_page(
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            [$this, 'render']
        );
    }

    public function render() {
        // Check user capabilities before rendering the option page
		foreach ($this->allowedUserCapabilities as $capability) {
			if (!current_user_can($capability)) {
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
		}
		settings_errors();
		$current_uri = $_SERVER['REQUEST_URI'];

		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="<?php echo esc_url( $current_uri ); ?>" method="post">
				<?php
					include $this->templateFile;
					wp_nonce_field( 'hp_seo_analyzer_option_page', 'hp_seo_analyzer_option_page_nonce' );
				?>

			</form>
		</div>
		<?php
    }

    public function registerSettings() {
		// check if the action is equal to the current page slug
		if (!isset($_GET['page']) || $_GET['page'] !== $this->menuSlug) {
			return;
		}
		// check if the user has the required capability
		foreach ($this->allowedUserCapabilities as $capability) {
			if (!current_user_can($capability)) {
				return;
			}
		}
		if (!isset($_POST['hp_seo_analyzer_option_page_nonce']) || !wp_verify_nonce($_POST['hp_seo_analyzer_option_page_nonce'], 'hp_seo_analyzer_option_page')) {
			return;
		}
		// register the settings
		$this->saveCallback->save();
    }
}
