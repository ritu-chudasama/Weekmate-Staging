<?php
defined('ABSPATH') || exit;

/* -------------------------------------------------------------------------
 * Settings page
 * ------------------------------------------------------------------------- */

add_action('admin_notices', 'wmcp_admin_missing_key_notice');

function wmcp_admin_missing_key_notice()
{
	if (! current_user_can('manage_options')) {
		return;
	}
	$settings = wmcp_get_settings();
	$provider = $settings['ai_provider'] ?? 'groq';

	$has_key = false;
	if ( 'openai' === $provider && ! empty($settings['openai_api_key']) ) {
		$has_key = true;
	} elseif ( 'claude' === $provider && ! empty($settings['claude_api_key']) ) {
		$has_key = true;
	} elseif ( 'groq' === $provider && ! empty($settings['groq_api_key']) ) {
		$has_key = true;
	}

	if ( $has_key ) {
		return;
	}
	$url = admin_url('options-general.php?page=weekmate-city-pages');
	echo '<div class="notice notice-error"><p><strong>Ai Content Integration:</strong> API key is not set for the selected AI provider. City pages cannot be generated until you add one in <a href="' . esc_url($url) . '">Settings → Ai Content Integration</a>.</p></div>';
}

add_action('admin_menu', 'wmcp_admin_menu');
add_action('admin_init', 'wmcp_register_settings');

function wmcp_admin_menu()
{
	add_options_page(
		'Ai Content Integration',
		'Ai Content Integration',
		'manage_options',
		'ai-content-integration',
		'wmcp_settings_page'
	);
}

function wmcp_register_settings()
{
	register_setting('wmcp_settings_group', WMCP_OPTION_KEY, 'wmcp_sanitize_settings');
}

function wmcp_sanitize_settings($input)
{
	$defaults = wmcp_default_settings();

	// ---- Sanitize custom page types ----
	$custom_page_types = array();
	if (isset($input['custom_page_types']) && is_array($input['custom_page_types'])) {
		foreach ($input['custom_page_types'] as $pt_key => $ct) {
			$pt_key = sanitize_key($pt_key);
			// Reserved built-in keys cannot be overridden.
			if ('' === $pt_key || in_array($pt_key, array('payroll', 'hr'), true) || ! is_array($ct)) {
				continue;
			}
			$custom_page_types[ $pt_key ] = array(
				'label'       => sanitize_text_field($ct['label']        ?? ''),
				'slug'        => sanitize_title($ct['slug']              ?? ''),
				'slug_prefix' => sanitize_title($ct['slug_prefix']       ?? ''),
				'keywords'    => sanitize_textarea_field($ct['keywords'] ?? ''),
			);
		}
	}

	// Handle "add new page type" submitted via the dedicated add-form.
	if (
		! empty($input['new_pt_key']) &&
		! empty($input['new_pt_label']) &&
		! empty($input['new_pt_slug']) &&
		! empty($input['new_pt_slug_prefix'])
	) {
		$new_key = sanitize_key($input['new_pt_key']);
		if ('' !== $new_key && ! in_array($new_key, array('payroll', 'hr'), true)) {
			$custom_page_types[ $new_key ] = array(
				'label'       => sanitize_text_field($input['new_pt_label']),
				'slug'        => sanitize_title($input['new_pt_slug']),
				'slug_prefix' => sanitize_title($input['new_pt_slug_prefix']),
				'keywords'    => sanitize_textarea_field($input['new_pt_keywords'] ?? ''),
			);
		}
	}

	// Handle "delete page type".
	if (! empty($input['delete_pt_key'])) {
		$del_key = sanitize_key($input['delete_pt_key']);
		unset($custom_page_types[ $del_key ]);
	}

	return array(
		'groq_api_key'      => sanitize_text_field($input['groq_api_key']   ?? ''),
		'groq_model'        => sanitize_text_field($input['groq_model']      ?? $defaults['groq_model']),
		'post_status'       => in_array($input['post_status'] ?? '', array('publish', 'draft'), true) ? $input['post_status'] : 'publish',
		'base_blog_path'    => sanitize_title($input['base_blog_path']       ?? $defaults['base_blog_path']),
		'category_slug'     => sanitize_title($input['category_slug']        ?? $defaults['category_slug']),
		'ai_provider'       => in_array($input['ai_provider'] ?? '', array('groq', 'openai', 'claude'), true) ? $input['ai_provider'] : 'groq',
		'openai_api_key'    => sanitize_text_field($input['openai_api_key']  ?? ''),
		'claude_api_key'    => sanitize_text_field($input['claude_api_key']  ?? ''),
		'custom_page_types' => $custom_page_types,
	);
}

function wmcp_settings_page()
{
	if (! current_user_can('manage_options')) {
		return;
	}

	if (isset($_POST['wmcp_flush_cache']) && check_admin_referer('wmcp_flush_cache')) {
		wmcp_flush_cache();
		echo '<div class="notice notice-success"><p>City cache flushed.</p></div>';
	}

	$settings = wmcp_get_settings();
	$count    = wmcp_cache_count();
?>
	<div class="wrap">
		<h1>AI Content Integration</h1>
		<form method="post" action="options.php" id="wmcp-master-form">
			<?php settings_fields('wmcp_settings_group'); ?>
			<?php
			// Pre-load all custom page type data as hidden fields
			// so they survive every save regardless of which section is being saved.
			$_ct_all = $settings['custom_page_types'] ?? array();
			foreach ($_ct_all as $_ctk => $_ctv) :
				$_cfb = WMCP_OPTION_KEY . '[custom_page_types][' . esc_attr($_ctk) . ']';
			?>
				<input type="hidden" name="<?php echo esc_attr($_cfb); ?>[label]"       value="<?php echo esc_attr($_ctv['label']       ?? ''); ?>" />
				<input type="hidden" name="<?php echo esc_attr($_cfb); ?>[slug]"        value="<?php echo esc_attr($_ctv['slug']        ?? ''); ?>" />
				<input type="hidden" name="<?php echo esc_attr($_cfb); ?>[slug_prefix]" value="<?php echo esc_attr($_ctv['slug_prefix'] ?? ''); ?>" />
				<input type="hidden" name="<?php echo esc_attr($_cfb); ?>[keywords]"    value="<?php echo esc_attr($_ctv['keywords']    ?? ''); ?>" />
			<?php endforeach; ?>
			<table class="form-table">
				<tr>
					<th><label for="ai_provider">AI Provider</label></th>
					<td>
						<select id="ai_provider" name="<?php echo esc_attr(WMCP_OPTION_KEY); ?>[ai_provider]" onchange="wmcpToggleApiKeyFields(this.value)">
							<option value="groq"   <?php selected($settings['ai_provider'] ?? 'groq', 'groq');   ?>>Grok (Groq)</option>
							<option value="openai" <?php selected($settings['ai_provider'] ?? 'groq', 'openai'); ?>>ChatGPT (OpenAI)</option>
							<option value="claude" <?php selected($settings['ai_provider'] ?? 'groq', 'claude'); ?>>Claude (Anthropic)</option>
						</select>
						<p class="description">Select the AI provider used to generate city page content.</p>
					</td>
				</tr>
				<tr id="wmcp_row_groq" style="<?php echo ('groq' !== ($settings['ai_provider'] ?? 'groq')) ? 'display:none' : ''; ?>">
					<th><label for="groq_api_key">Grok API Key</label></th>
					<td><input type="password" id="groq_api_key" name="<?php echo esc_attr(WMCP_OPTION_KEY); ?>[groq_api_key]" value="<?php echo esc_attr($settings['groq_api_key']); ?>" class="regular-text" autocomplete="off" /></td>
				</tr>
				<tr id="wmcp_row_openai" style="<?php echo ('openai' !== ($settings['ai_provider'] ?? 'groq')) ? 'display:none' : ''; ?>">
					<th><label for="openai_api_key">ChatGPT API Key</label></th>
					<td><input type="password" id="openai_api_key" name="<?php echo esc_attr(WMCP_OPTION_KEY); ?>[openai_api_key]" value="<?php echo esc_attr($settings['openai_api_key'] ?? ''); ?>" class="regular-text" autocomplete="off" /></td>
				</tr>
				<tr id="wmcp_row_claude" style="<?php echo ('claude' !== ($settings['ai_provider'] ?? 'groq')) ? 'display:none' : ''; ?>">
					<th><label for="claude_api_key">Claude API Key</label></th>
					<td><input type="password" id="claude_api_key" name="<?php echo esc_attr(WMCP_OPTION_KEY); ?>[claude_api_key]" value="<?php echo esc_attr($settings['claude_api_key'] ?? ''); ?>" class="regular-text" autocomplete="off" /></td>
				</tr>
				<tr>
					<th><label for="ai_model_display">Model</label></th>
					<td>
						<?php
						$provider_model_map = array(
							'groq'   => $settings['groq_model'],
							'openai' => 'gpt-4o',
							'claude' => 'claude-3-5-sonnet-20241022',
						);
						$current_provider = $settings['ai_provider'] ?? 'groq';
						$current_model    = $provider_model_map[ $current_provider ] ?? $settings['groq_model'];
						?>
						<input type="text" id="ai_model_display" name="<?php echo esc_attr(WMCP_OPTION_KEY); ?>[groq_model]" value="<?php echo esc_attr($current_model); ?>" class="regular-text" />
						<p class="description">Enter the exact model name for the selected provider. e.g. <code>llama-3.3-70b-versatile</code>, <code>gpt-4o</code>, <code>claude-opus-4-8</code></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>

		<hr />
		<h2>Cache Management</h2>
		<p><?php echo esc_html($count); ?> cities in cache. Flushing does <strong>not</strong> delete WordPress posts.</p>
		<form method="post">
			<?php wp_nonce_field('wmcp_flush_cache'); ?>
			<input type="hidden" name="wmcp_flush_cache" value="1" />
			<?php submit_button('Flush All City Cache', 'delete', 'submit', false); ?>
		</form>

	</div>
	<script>
	var wmcpModels = {
		groq:   'llama-3.3-70b-versatile',
		openai: 'gpt-4o',
		claude: 'claude-opus-4-8'
	};
	function wmcpToggleApiKeyFields(provider) {
		var rows = {groq: 'wmcp_row_groq', openai: 'wmcp_row_openai', claude: 'wmcp_row_claude'};
		for (var key in rows) {
			document.getElementById(rows[key]).style.display = (key === provider) ? '' : 'none';
		}
		var modelField = document.getElementById('ai_model_display');
		if (modelField && wmcpModels[provider]) {
			modelField.value = wmcpModels[provider];
		}
	}
	</script>
<?php
}
