<?php
/**
 * Template Name: About Us
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
$banner_section = get_field('banner_section');
$setup_process = get_field('setup_process');

// echo "<pre>";
// print_r($banner_section);
// echo "</pre>";
// exit;
get_header();

?>
<section class="aboutus-banner-section sectionCvr advtool-sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 order-1 order-lg-0 mt-4 mt-lg-0">
                <div class="about-conetnt">
                    <!-- <h6 class="subheading"><?php echo $banner_section['top_title'];?></h6> -->
                    <h1 class="heading-bold"><?php echo $banner_section['heading'];?></h1>
                    <p class="banner-subtitle"><?php echo $banner_section['sub_heading'];?></p>
                    <div class="count-wrapper row">
                        <?php 
                            if( $banner_section['about_banner_repeater'] ){
                                foreach( $banner_section['about_banner_repeater'] as $about_banner ){
                                    ?>
                        <div class="count-wrap col-6">
                            <h2 class="big-size h1"><?php echo $about_banner['title'];?></h2>
                            <p><?php echo $about_banner['content'];?></p>
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <img src="<?php echo $banner_section['right_image']['url'];?>"
                    alt="<?php echo $banner_section['right_image']['name'];?>" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<section class="setup-process sectionCvr">
    <div class="container">
        <div class="small-section-header section-header">

            <div class="row">
                <div class="col-md-5 col-lg-4">
                    <div class="heading-wrapper">
                        <?php
                        if(!empty($setup_process['heading'])) {
                            echo '<h2 class="setup-process-title h1 heading-bold">' . esc_html($setup_process['heading']) . '</h2>';
                        }
                    ?>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <div class="rte ps-lg-5">
                        <?php
                            if(!empty($setup_process['description'])) {
                                echo '<p>' . esc_html($setup_process['description']) . '</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-3">
            <?php
                $colors = ['sky-blue-bg-clr', 'light-ivory-bg-clr', 'light-mint-bg-clr'];
                if(!empty($setup_process['setup_process_repeater'])) {
                    foreach($setup_process['setup_process_repeater'] as $key => $process) {
                        ?>
            <div class="col-md-4">
                <div class="step-wrapper <?php echo $colors[$key]?>">
                    <div class="step-icon">
                        <img src="<?php echo $process['image']['url'];?>" width="98px" height="98px"
                            alt="<?php echo $process['image']['name'];?>" />
                    </div>
                    <h3 class="h3 heading-bold"><?php echo $process['title'];?></h3>
                    <div class="rte">
                        <p><?php echo $process['description'];?></p>
                    </div>
                </div>
            </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
</section>

<section class="our-story-section sectionCvr">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-7">
                <div class="our-story-wrapper">
                    <div class="our-story-wrap product-info-wrapper">
                        <div class="product-info-block product-count-block">
                            <div class="collage-img">
                                <img src="https://weekmate.in/wp-content/uploads/2025/11/siddharth-jain.webp">
                                <img src="https://weekmate.in/wp-content/uploads/2025/08/het-balar.png">
                                <img src="https://weekmate.in/wp-content/uploads/2025/11/nikhil-shah.webp">
                            </div>
                            <div class="count-block">
                                <p class="count">8000+</p>
                                <p class="desc">People are using WeekMate for client support, employee management, and
                                    more, driven by the need for simpler, scalable pricing model business software.</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-info-img">
                        <img src="https://weekmate.in/wp-content/uploads/2025/12/our-story-.png" width="100%"
                            height="100%" alt="step-icon" />
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 mt-4 mt-lg-0">
                <div class="product-info-detail">
                    <h2 class="heading-bold h1">our story</h2>
                    <div class="rte">
                        <p>WeekMate began with a simple observation: growing businesses spend more time managing tools than running their business. Teams juggled platforms for HR, sales, tasks, documents, each with its own login, its own silo. The bigger the business, the messier it got.</p>
                        <p>We believed there was a better way. So we built WeekMate: one platform for people, pipeline, operations, and communication. No more switching apps or entering the same data twice.</p>
                        <p>Just one intelligent platform handling hiring, payroll, client management, and task tracking, the way teams actually work.</p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 mt-4 mt-lg-0">
                <div class="image-heading">
                    <img src="https://weekmate.in/wp-content/uploads/2025/08/elsner-logo.png" width="110px"
                        height="45.87px" alt="elsner-logo">
                    <h4 class="heading-bold h4">What is elsner?</h4>
                </div>
                <p>WeekMate is proudly built by Elsner Technologies, a global tech company with over 19 years of
                    experience in creating smart digital solutions. With 250+ skilled developers and 6,200+ happy
                    clients around the world, Elsner brings the knowledge and reliability that make WeekMate strong from
                    the ground up.</p>
            </div> -->
        </div>
    </div>
</section>

<section class="our-team-section sectionCvr">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="section-header text-center">
                    <h2 class="heading-bold h1">Our team</h2>
                    <div class="rte">
                        <p>Behind every feature we build is a group of passionate thinkers, makers, and problem-solvers.
                        </p>
                    </div>
                </div>

                <div class="our-team">
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/01/Harshal-bhai-1.webp"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Harshal Shah</h5>
                            <h6 class="h6">Founder & CEO</h6>
                        </div>
                    </div>
                    <!-- <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2025/08/Chiragbhai-New-Photo.jpg.webp"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Chirag Rawal</h5>
                            <h6 class="h6">COO</h6>
                        </div>
                    </div> -->
                    <!-- <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2025/08/deepak-sir.webp" width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Dipak Patil</h5>
                            <h6 class="h6">- Delivery Head - eCommerce</h6>
                        </div>
                    </div> -->

                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/01/Tarun-Bansal.png" width="100%"
                                height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Tarun Bansal</h5>
                            <h6 class="h6">Director</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/pankaj-sir.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Pankaj Sakariya</h5>
                            <h6 class="h6">Director</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/07/karan_Chugh.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Karan Chugh</h5>
                            <h6 class="h6">Director - Business & Technology Consulting</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/04/Sachin_Mehta.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Sachin Mehta</h5>
                            <h6 class="h6">Director</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/01/Kartavya_shah.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Kartavya Shah</h5>
                            <h6 class="h6">Director</h6>
                        </div>
                    </div>
                    <!-- <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Sudhir_Pansal_1773727402226.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Sudhir Pansal</h5>
                            <h6 class="h6">Sales Head</h6>
                        </div>
                    </div> -->
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Chetan_Mistry_1773725086146.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Chetan Mistry</h5>
                            <h6 class="h6">Digital Marketing Manager</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Anchal_Gor_1773727402552.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Anchal Gor</h5>
                            <h6 class="h6">HR & Talent Acquisition Manager</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/01/Prashant_tiwari.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Prashant Tiwari</h5>
                            <h6 class="h6">Business Development Manager</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Frame_3015260_1773666303353_1773725086226.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Ritesh Rajput</h5>
                            <h6 class="h6">Customer Success Manager</h6>
                        </div>
                    </div>
                    <!-- <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Sameersingh_Pawar_1773727402566.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Sameer Pawar</h5>
                            <h6 class="h6">Social Media Manager</h6>
                        </div>
                    </div> -->
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/07/ChatGPT_Image_Jun_12_2026_12_11_05_PM_1781246506032_1_1783323675250.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Ayushi Gupta</h5>
                            <h6 class="h6">Social Media Manager</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/01/Abhishek-Bharti.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Abhishek Bharti</h5>
                            <h6 class="h6">Product Operations Executive</h6>
                        </div>
                    </div>
                    <!-- <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/02/jyotitiwari.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Jyoti Tiwari</h5>
                            <h6 class="h6">Business Development Executive</h6>
                        </div>
                    </div> -->
                    <!-- <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Ambika_Rani_1773725086608.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Ambika Rani</h5>
                            <h6 class="h6">Content Strategist </h6>
                        </div>
                    </div> -->
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Krunal_Hinduja_1773725086120.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Krunal Hinduja</h5>
                            <h6 class="h6">Scrum Master</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/06/Frame_2147224423_1780310202130_1780311194335-5.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Kartik Trivedi</h5>
                            <h6 class="h6">Technical Support Engineer</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/image_1773730271820-1.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Karan Tulsani</h5>
                            <h6 class="h6">Senior Software Engineer</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/kevin.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Kevin Mungra</h5>
                            <h6 class="h6">AI/ML Engineer</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Ankit_Patel_1773725086076.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Ankit Patel</h5>
                            <h6 class="h6">Mobile App Developer</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Rohan_Pandey_1773725086304.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Rohan Pandey</h5>
                            <h6 class="h6">QA Engineer</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2026/03/Shaival_Bhojak_1773727402628.png"
                                width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Shaival Bhojak</h5>
                            <h6 class="h6">UI/UX Designer</h6>
                        </div>
                    </div>
                    <!-- <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2025/08/vijay-yalamanchili-user.jpg" width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Vijay Yalamanchili</h5>
                            <h6 class="h6">- CEO</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2025/08/vijay-yalamanchili-user.jpg" width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Vijay Yalamanchili</h5>
                            <h6 class="h6">- CEO</h6>
                        </div>
                    </div>
                    <div class="our-team-member">
                        <div class="image-wrapper">
                            <img src="https://weekmate.in/wp-content/uploads/2025/08/vijay-yalamanchili-user.jpg" width="100%" height="100%" alt="member-img" />
                        </div>
                        <div class="member-detail member-detail-section">
                            <h5 class="h5">Vijay Yalamanchili</h5>
                            <h6 class="h6">- CEO</h6>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="why-choose-section sectionCvr">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-xxl-10">
                <div class="why-choose-wrap">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-wrap">
                                <div class="banner-rating">
                                    <ul class="rating-block">
                                        <li>
                                            <p class="rating-icon"><a href="#"><img
                                                        src="https://weekmate.in/wp-content/themes/weekmate/images/rating-icon-1.png"
                                                        align="rating-icon"></a></p>
                                            <p>
                                                <span class="rating">4.4</span>
                                                <span class="star-rating">
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="far" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                        </path>
                                                    </svg><!-- <i class="fa-regular fa-star"></i> -->
                                                </span>
                                            </p>
                                        </li>
                                        <li>
                                            <p class="rating-icon"><a href="#"><img
                                                        src="https://weekmate.in/wp-content/themes/weekmate/images/rating-icon-2.png"
                                                        align="rating-icon"></a></p>
                                            <p>
                                                <span class="rating">4.6</span>
                                                <span class="star-rating">
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                                                        </path>
                                                    </svg><!-- <i class="fa fa-star"></i> -->
                                                    <svg class="svg-inline--fa fa-star" aria-hidden="true"
                                                        focusable="false" data-prefix="far" data-icon="star" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z">
                                                        </path>
                                                    </svg><!-- <i class="fa-regular fa-star"></i> -->
                                                </span>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="banner-details">
                                    <div class="banner-title">
                                        <h2 class="heading-bold">Why choose us?</h2>
                                    </div>
                                    <p class="banner-desc">We’ve built WeekMate to remove complexity from SaaS
                                        solutions. Our platform is simple, fast, and built for teams that value control,
                                        clarity, and cost-efficiency—without recurring fees.</p>
                                    <div class="banner-cta"><a href="<?php echo esc_url( site_url( 'contact-us' ) ); ?>" class="theme-btn">Contact Us</a></div>
                                </div>
                                <div class="banner-img">
                                    <img src="https://weekmate.in/wp-content/uploads/2025/08/why-choose-us.png"
                                        alt="banner-img" width="100%" height="100%" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="accordion accordion-flush faqs-accordion" id="faqLists">
                                <!-- <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faqcollapse-1"
                                            aria-expanded="false" aria-controls="faqcollapse-1">1. Do you really have no per-user costing?</button>
                                    </h3>
                                    <div id="faqcollapse-1" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqLists">
                                        <div class="accordion-body">
                                            <p>Yes, we have no per-user costs in the WeekMate tools. There are scalable pricing models to ensure a cost-effective solution.</p>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faqcollapse-1"
                                            aria-expanded="true" aria-controls="faqcollapse-1">1. Is WeekMate right for
                                            service-based businesses?</button>
                                    </h3>
                                    <div id="faqcollapse-1" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqLists">
                                        <div class="accordion-body">
                                            <p>Absolutely. WeekMate is designed for service-led teams in IT, consulting,
                                                support, and similar industries that need structure without added
                                                complexity.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faqcollapse-2" aria-expanded="true"
                                            aria-controls="faqcollapse-2">2. What’s included in the platform?</button>
                                    </h3>
                                    <div id="faqcollapse-2" class="accordion-collapse collapse"
                                        data-bs-parent="#faqLists">
                                        <div class="accordion-body">
                                            <p>WeekMate gives you access to a growing suite of business tools designed
                                                to simplify operations everything from team management and client
                                                communication to task tracking and more.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faqcollapse-3" aria-expanded="true"
                                            aria-controls="faqcollapse-3">3. How long does it take to get
                                            started?</button>
                                    </h3>
                                    <div id="faqcollapse-3" class="accordion-collapse collapse"
                                        data-bs-parent="#faqLists">
                                        <div class="accordion-body">
                                            <p>Most businesses go live in under 2 weeks. The setup is simple, and your
                                                team can start using it with little to no learning curve.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faqcollapse-4" aria-expanded="true"
                                            aria-controls="faqcollapse-4">4. Can I host WeekMate on my own
                                            server?</button>
                                    </h3>
                                    <div id="faqcollapse-4" class="accordion-collapse collapse"
                                        data-bs-parent="#faqLists">
                                        <div class="accordion-body">
                                            <p>WeekMate is hosted in a secure cloud environment, so you don’t need to
                                                worry about managing your own servers. It’s fully managed and maintained
                                                for you, making setup and ongoing updates simple and stress-free.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php

get_footer();