<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

?>

</div>
<footer>
  <div class="ftrCvr">
    <div class="ftrtopCvr">
      <div class="container">
        <div class="row">
          <div class=" footer-menu-links footer-newsletter-box">
            <div class="footer-newsletter-wrapper">
              <h4 class="footertittle">Get Update</h4>
              <?php echo do_shortcode('[contact-form-7 id="3f1bfdc" title="News Letter"]'); ?>
            </div>

          </div>
        </div>
        <div class="row justify-content-between">
          <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-12 col-sm-12">
            <div class="ftr-contact-details">
              <div class="ftr-logo-wrap">
                <?php $logo = get_field('site_logo', 'option'); ?>
                <a class="ftr-logo text-center" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>"></a>
              </div>
              <div class="ftr-title">
                <p class="ftr-sectitle">Let's create something together</p>
              </div>
              <ul>
                <li><a><?php echo get_field('cta_address', 'option'); ?></a></li>
                <li><a href="mailto:<?php echo get_field('cta_email', 'option'); ?>"><?php echo get_field('cta_email', 'option'); ?></a></li>
                <li><a href="mailto:<?php echo get_field('cta_email_2', 'option'); ?>"><?php echo get_field('cta_email_2', 'option'); ?></a></li>
                <?php $phone = get_field('cta_phone', 'option');
                $phoneLink = str_replace([' ', '-', '.', '(', ')',], '', $phone); ?>
                <li><a href="tel:<?php echo $phoneLink; ?>"><?php echo $phone; ?></a></li>
              </ul>
            </div>
            <div class="ftrsocial-wrapper">
              <ul class="ftrsocialLinks">
                <?php $smoLink = get_field('smo_links', 'option'); ?>
                <li><a target="_blank" href="<?php echo $smoLink['fb_link']; ?>"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a target="_blank" href="<?php echo $smoLink['x_link']; ?>"><i class="fa-brands fa-x-twitter"></i> </a></li>
                <li><a target="_blank" href="<?php echo $smoLink['in_link']; ?>"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a target="_blank" href="<?php echo $smoLink['insta_link']; ?>"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a target="_blank" href="<?php echo $smoLink['ytb_link']; ?>"><i class="fa-brands fa-youtube"></i></a></li>
              </ul>
            </div>
          </div>

          <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-12 col-sm-12">
            <div class="footer-listsCvr">
              <div class="row">
                <div class="col-xx-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 footer-menu-links">
                  <h4 class="footertittle">Industries</h4>
                  <ul>
                    <!-- <li><a href="https://weekmate.in/ecommerce/">Ecommerce</a></li> -->
                    <li><a href="https://weekmate.in/software-it/">Software & IT</a></li>
                    <!-- <li><a href="https://weekmate.in/financial/">Financial</a></li> -->
                    <li><a href="https://weekmate.in/manufacturing/">Manufacturing</a></li>
                    <!-- <li><a href="https://weekmate.in/hospitality/">Hospitality </a></li> -->
                    <li><a href="https://weekmate.in/bpo/">BPO</a></li>
                    <!-- <li><a href="https://weekmate.in/kpo/">KPO</a></li> -->
                    <li><a href="https://weekmate.in/pharmacy/">Pharmacy</a></li>
                    <li><a href="https://weekmate.in/accounting/">Accounting</a></li>
                  </ul>
                </div>
                <div class="col-xx-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 footer-menu-links">
                  <h4 class="footertittle">Products</h4>
                  <ul>
                    <li><a href="<?= home_url(); ?>/hrms/">HRMS & Payroll</a></li>
                    <li><a href="<?= home_url(); ?>/crm/">CRM</a></li>
                    <li><a href="<?= home_url(); ?>/taskhub/">TaskHub</a></li>
                    <li><a href="<?= home_url(); ?>/connect/">Connect</a></li>
                    <li><a href="<?= home_url(); ?>/proposal-management-tool/">Proposal Tool</a></li>
                    <li><a href="<?= home_url(); ?>/email-marketing-tool/">Email Marketing Tool</a></li>
                    <li><a href="<?= home_url(); ?>/visitor-management-system/">Visitor Management</a></li>
                    <li><a href="<?= home_url(); ?>/field-sales-management/">Field Sales Management</a></li>
                  </ul>
                </div>

                <div class="col-xx-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 footer-menu-links">
                  <h4 class="footertittle">Locations</h4>
                  <ul>
                    <li><a href="<?= home_url(); ?>/hr-software-in-delhi/">HR Software in Delhi</a></li>
                    <li><a href="<?= home_url(); ?>/hr-software-in-bangalore/">HR Software in Bangalore</a></li>
                    <li><a href="<?= home_url(); ?>/hr-software-in-hyderabad/">HR Software in Hyderabad</a></li>
                    <li><a href="<?= home_url(); ?>/hr-software-in-ahmedabad/">HR Software in Ahmedabad</a></li>
                    <li><a href="<?= home_url(); ?>/hr-software-in-pune/">HR Software in Pune</a></li>
                    <li><a href="<?= home_url(); ?>/payroll-software-in-delhi/">Payroll Software in Delhi</a></li>
                    <li><a href="<?= home_url(); ?>/payroll-software-in-hyderabad/">Payroll Software in Hyderabad</a></li>
                    <li><a href="<?= home_url(); ?>/payroll-software-in-chennai/">Payroll Software in Chennai</a></li>
                    <li><a href="<?= home_url(); ?>/payroll-software-in-ahmedabad/">Payroll Software in Ahmedabad</a></li>
                    <li><a href="<?= home_url(); ?>/payroll-software-in-pune/">Payroll Software in Pune</a></li>
                  </ul>
                </div>

                <!--<div class="col-xx-4 col-xl-4 col-lg-4 col-md-4 col-sm-4">
										<h4 class="footertittle">Compare</h4>
                      <ul>
											<li><a href="#">vs Monday</a></li>
											<li><a href="#">vs Notion</a></li>
											<li><a href="#">vs Asana</a></li>
											<li><a href="#">vs Jira</a></li>
											<li><a href="#">vs Trello</a></li>
											<li><a href="#">vs Slack</a></li>
											<li><a href="#">vs Ms Project</a></li>
											<li><a href="#">vs Smartsheet</a></li>
											<li><a href="#">vs Airtable</a></li>
                      </ul>
									</div>-->
                <div class="col-xx-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 footer-menu-links">
                  <h4 class="footertittle">Quick Links</h4>
                  <ul>
                    <li><a href="<?= home_url(); ?>/about-us/">About Us</a></li>
                    <li><a href="<?= home_url(); ?>/contact-us/">Contact Us</a></li>
                    <li><a href="<?= home_url(); ?>/blog/">Blog</a></li>
                    <li><a href="<?= home_url(); ?>/case-studies/">Case Studies</a></li>
                    <li><a href="<?= home_url(); ?>/partners/">Our Partners</a></li>
                    <li><a href="<?= home_url(); ?>/privacy-policy/">Privacy Policy</a></li>
                    <li><a href="<?= home_url(); ?>/terms-of-services/">Terms of Services</a></li>
                    <li><a href="<?= home_url(); ?>/wp-content/uploads/2026/08/WEEKMATE_CORPORATE_PROFILE-1.pdf">Corporate Profile</a></li>
                    <li><a href="https://help.weekmate.in/portal/en/home" target="_blank">Help Center</a></li>
                  </ul>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ftrbottomCvr">
      <div class="container">
        <div class="row">
          
          <div class="footer-logo">
            <?php
            $store_images = get_field('footer_store_images', 'option');
            if ($store_images && !empty($store_images['footer_store_logos'])) : ?>
              <ul class="footer-store-logos">
                <?php foreach ($store_images['footer_store_logos'] as $store) :
                  $img = $store['footer_store_image'];
                  $link = $store['footer_store_link'];
                ?>
                  <li>
                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
                      <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
          <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="ftrbottom-wrap">
              <div class="row">
                <div class="col-xxl-5 col-xl-4 col-lg-5 col-md-12 col-sm-12">
                  <div class="copyright">
                    <p class="mb-0">© Copyright <?php echo date('Y'); ?> WeekMate. All rights reserved. <?php /* Design &amp; Developed by <a href="https://www.aoneseoservice.com/" target="_blank" class="company-name">AONE SEO SERVICE</a> */ ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- <a href="https://weekmate.in/become-partner/" class="sticky-btn">Become A Partner</a> -->
<?php $whatsapp = get_field('cta_whatsapp', 'option');
$whatsappLink = str_replace([' ', '-', '.', '+', '(', ')',], '', $whatsapp); ?>
<a target="_blank" href="https://wa.me/<?php echo $whatsappLink; ?>" class="sticky-whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
</div>
<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/all.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/owl-min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/slick.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/fancybox.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/custom.js?v=<?php echo filemtime(get_template_directory() . '/js/custom.js'); ?>"></script>
<script>
  Fancybox.bind('[data-fancybox]', {});
</script>
<?php wp_footer(); ?>
<?php if (is_page(9)) { ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      function initSmoothAccordion(accordionId) {
        const accordionContainer = document.getElementById(accordionId);
        if (!accordionContainer) {
          console.log(`Accordion ${accordionId} not found`);
          return;
        }

        const accordionButtons = accordionContainer.querySelectorAll('.accordion-button');
        const accordionCollapses = accordionContainer.querySelectorAll('.accordion-collapse');

        let currentOpenIndex = -1;
        accordionCollapses.forEach((collapse, index) => {
          if (collapse.classList.contains('show')) {
            currentOpenIndex = index;
          }
        });

        if (currentOpenIndex === -1) {
          currentOpenIndex = 0;
          openTab(0, false);
        }

        function openTab(index, animate = true) {
          const currentCollapse = currentOpenIndex >= 0 ?
            document.querySelector(accordionButtons[currentOpenIndex].getAttribute('data-bs-target') ||
              accordionButtons[currentOpenIndex].getAttribute('data-target')) : null;

          const newButton = accordionButtons[index];
          const newTargetSelector = newButton.getAttribute('data-bs-target') || newButton.getAttribute('data-target');
          const newCollapse = document.querySelector(newTargetSelector);

          if (animate && currentCollapse && currentOpenIndex !== index) {

            currentCollapse.style.height = currentCollapse.scrollHeight + 'px';
            accordionButtons[currentOpenIndex].classList.add('collapsed');
            accordionButtons[currentOpenIndex].setAttribute('aria-expanded', 'false');

            currentCollapse.offsetHeight;

            currentCollapse.classList.add('collapsing');
            currentCollapse.classList.remove('show');
            currentCollapse.style.height = '0px';

            setTimeout(() => {
              newCollapse.classList.remove('show');
              newCollapse.style.height = '0px';
              newCollapse.classList.add('collapsing');

              newCollapse.offsetHeight;

              newButton.classList.remove('collapsed');
              newButton.setAttribute('aria-expanded', 'true');
              newCollapse.style.height = newCollapse.scrollHeight + 'px';

            }, 100);

            setTimeout(() => {
              if (currentCollapse) {
                currentCollapse.classList.remove('collapsing');
                currentCollapse.style.height = '';
              }

              newCollapse.classList.remove('collapsing');
              newCollapse.classList.add('show');
              newCollapse.style.height = '';

            }, 450);

          } else {

            accordionButtons.forEach((btn, i) => {
              const targetSelector = btn.getAttribute('data-bs-target') || btn.getAttribute('data-target');
              const targetCollapse = document.querySelector(targetSelector);

              if (i === index) {
                targetCollapse.classList.add('show');
                btn.classList.remove('collapsed');
                btn.setAttribute('aria-expanded', 'true');
              } else {
                targetCollapse.classList.remove('show');
                btn.classList.add('collapsed');
                btn.setAttribute('aria-expanded', 'false');
              }
            });
          }

          currentOpenIndex = index;
        }

        accordionButtons.forEach((button, clickedIndex) => {
          button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (button.disabled) return;

            accordionButtons.forEach(btn => btn.disabled = true);

            if (clickedIndex === currentOpenIndex) {
              const nextIndex = (clickedIndex + 1) % accordionButtons.length;
              openTab(nextIndex, true);
            } else {
              openTab(clickedIndex, true);
            }

            // Re-enable buttons after animation
            setTimeout(() => {
              accordionButtons.forEach(btn => btn.disabled = false);
            }, 500);
          });
        });

        //console.log(`Smooth accordion initialized for ${accordionId} with ${accordionButtons.length} tabs`);
      }

      initSmoothAccordion('banner-tab1');
      initSmoothAccordion('banner-tab2');

    });
  </script>
  <script>
    jQuery(document).ready(function($) {
      $('.banner-tabsCvr .accordion-collapse.show').each(function() {
        $(this).closest('.accordion-item').find('.tab-img').hide();
      });

      $('.banner-tabsCvr .accordion-collapse').on('show.bs.collapse', function() {
        $(this).closest('.accordion-item').find('.tab-img').hide();
      });

      $('.banner-tabsCvr .accordion-collapse').on('hide.bs.collapse', function() {
        $(this).closest('.accordion-item').find('.tab-img').show();
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.0.2/dist/gsap.min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/SplitText3.min.js"></script>
  <script>
    var vsOpts = {
      slides: document.querySelectorAll(".v-slide"),
      list: document.querySelector(".v-slides"),
      duration: 0.5,
      lineHeight: 130
    };

    var vSlide = gsap.timeline({
      paused: true,
      repeat: -1
    });

    vsOpts.slides.forEach(function(slide, i) {
      let label = "slide" + i;
      vSlide.add(label);

      // Move the whole slide up
      vSlide.to(vsOpts.list, {
        duration: vsOpts.duration,
        y: i * -1 * vsOpts.lineHeight
      }, label);

      // Animate each line (strong and light) separately
      slide.querySelectorAll('.line').forEach(line => {
        let letters = new SplitText(line, {
          type: "chars"
        }).chars;
        vSlide.from(letters, {
          duration: vsOpts.duration,
          y: 50,
          stagger: vsOpts.duration / 20
        }, label);
      });

      vSlide.to({}, {
        duration: 1
      }); // delay before next
    });
    vSlide.play();
  </script>
  <script>
    // Switch tab content based on dropdown
    document.getElementById('advtoolDropdown').addEventListener('change', function() {
      const selectedTab = this.value;
      const tabTrigger = document.querySelector(`#${selectedTab}-tab`);
      if (tabTrigger) {
        const tab = new bootstrap.Tab(tabTrigger);
        tab.show();
      }
    });
  </script>
<?php }
?>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
  (function() {
    var s1 = document.createElement("script"),
      s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/69774e8c20b0fa1985223431/1jft0lle7';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
  })();
</script>
<!--End of Tawk.to Script-->


</body>

</html>