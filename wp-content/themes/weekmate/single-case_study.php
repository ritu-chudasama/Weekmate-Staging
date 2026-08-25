<?php get_header(); 
?>
<!-- 📌 Case Study Hero Section -->
<section class="sectionCvr casestudy-hero-sec advtool-sec case-study-detail-banner">
    <div class="container">
        <div class="row align-items-center">

            <!-- Left Column: Title + Meta -->
            <div class="col-lg-12 col-md-12">
                <div class="casestudy-hero-wrap text-center">

                    <!-- 📅 Meta -->
                    <div class="casestudy-meta">
                        <span class="read-time"> <img src="https://weekmate.in/wp-content/uploads/2025/09/cs-watch-icon.png" alt="time">
                        Max.
                            <?php
                            $content     = get_post_field('post_content', get_the_ID());
                            $word_count  = str_word_count( wp_strip_all_tags( $content ) );
                            $minutes     = ceil( $word_count / 200 );
                            echo $minutes . ' min read';
                             ?>
                        </span>
                        <!-- 🏷 Title -->
                        <h1 class="fw-bold casestudy-hero-title"><?php the_title(); ?></h1>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End casestudy Hero Section -->
<!-- 📑 Single casestudy Content -->
<section class="single-casestudy sectionCvr case-study-detail">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="casestudy-content">
                    <!--  Column: Featured Image -->
                    <div class="feture-img">
                        <?php if ( has_post_thumbnail() ) : ?>
                        <div class="casestudy-hero-image text-center">
                            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                 <div class="contact-form-wrapper">
                    <div class="contact-form-inner">
                        <div class="contact-title">
                            <h2 class="heading-bold">Fill the form</h2>
                        </div>
                        <?php echo do_shortcode('[contact-form-7 id="924eb0e" title="Case Study Form"]')?>
                    </div>
                </div>
                <?php
                    $blog_side_section = get_field('blog_side_section', 'option');
                    if( $blog_side_section ) : 
                    $heading      = $blog_side_section['heading'];
                    $detail_block = $blog_side_section['detail_block'];
                    $button       = $blog_side_section['button'];
                 ?>
                <aside class="blog-side-section">
                    <?php if( $heading ): ?>
                    <h3 class="side-heading"><?php echo esc_html($heading); ?></h3>
                    <?php endif; ?>

                    <?php if( $detail_block ): ?>
                    <ul class="side-detail-block">
                        <?php foreach( $detail_block as $item ): ?>
                        <?php if( !empty($item['text']) ): ?>
                        <li><?php echo esc_html($item['text']); ?></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php if( $button ): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="side-btn btn btn-primary mt-3"
                        target="<?php echo esc_attr($button['target']); ?>">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                    <?php endif; ?>
                </aside>
               
            </div>
            <?php endif; ?>
        </div>
    </div>
    </div>
</section>

<?php get_footer(); ?>