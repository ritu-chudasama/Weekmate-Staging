<?php
function add_open_graph_image_meta_for_all_pages() {
    global $post;

    // Default OG info
    $site_name     = get_bloginfo('name');
    $default_image = 'https://weekmate.in/wp-content/uploads/2025/10/WeekMate-Logo-Set-01.10.2025_WeekMate-Logo-Square-Dark-.png';
    $image_url     = $default_image;
    $page_url      = get_permalink();
    $title         = is_front_page() ? $site_name : get_the_title();
    $description   = get_bloginfo('description');

    // ✅ Define OG images for Product post type slugs
    $product_images = [
        'hrms' => 'https://weekmate.in/wp-content/uploads/2025/10/HRMS-8.png',
        'taskhub' => 'https://weekmate.in/wp-content/uploads/2025/10/taskhub-8.png',
        'e-crm' => 'https://weekmate.in/wp-content/uploads/2025/10/E-crm-8.png',
        'e-connect' => 'https://weekmate.in/wp-content/uploads/2025/10/E-connect-8.png',
        'email-marketing-tool' => 'https://weekmate.in/wp-content/uploads/2025/10/E-mail-marketing-tool-8.png',
        'ecommerce' => 'https://weekmate.in/wp-content/uploads/2025/10/E-commerce-8.png',
    ];

    // ✅ Define OG images for Template/Page slugs
    $template_images = [
        'software-it' => 'https://weekmate.in/wp-content/uploads/2025/10/softwareit-8.png',
        'financial' => 'https://weekmate.in/wp-content/uploads/2025/10/finance-8.png',
        'manufacturing' => 'https://weekmate.in/wp-content/uploads/2025/10/manufacturing-8.png',
        'hospitality' => 'https://weekmate.in/wp-content/uploads/2025/10/hospitality-8.png',
        'about-us' => 'https://weekmate.in/wp-content/uploads/2025/10/about-us-8.png',
    ];

    // ✅ Homepage
    if (is_front_page() || is_home()) {
        $image_url = 'https://weekmate.in/wp-content/uploads/2025/10/weekmate.in-8.png';
    }
    // ✅ Product post type (custom slugs)
    elseif (isset($post) && $post->post_type === 'product') {
        $slug = $post->post_name;
        if (isset($product_images[$slug])) {
            $image_url = $product_images[$slug];
        } elseif (has_post_thumbnail($post->ID)) {
            $image_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        }
    }
    // ✅ Page templates or static pages
    elseif (isset($post) && $post->post_type === 'page') {
        $slug = $post->post_name;
        if (isset($template_images[$slug])) {
            $image_url = $template_images[$slug];
        } elseif (has_post_thumbnail($post->ID)) {
            $image_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        }
    }
    // ✅ Fallback: featured image if available
    elseif (isset($post) && has_post_thumbnail($post->ID)) {
        $image_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    }

    // ✅ Output OG Meta Tags
    echo '
    <meta property="og:title" content="' . esc_attr($title) . '" />
    <meta property="og:description" content="' . esc_attr($description) . '" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="' . esc_url($page_url) . '" />
    <meta property="og:image" content="' . esc_url($image_url) . '" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    ';
}
add_action('wp_head', 'add_open_graph_image_meta_for_all_pages', 5);
