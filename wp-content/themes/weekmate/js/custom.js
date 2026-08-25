jQuery(function ($) {
"use strict";
  $('.slick.bannerfeatureLists1').slick({
    speed: 3000,
    autoplay: true,
    autoplaySpeed: 0,
    centerMode: false,
    cssEase: 'linear',
    slidesToShow: 1,
    draggable:false,
    focusOnSelect:false,
    pauseOnFocus:false,
    pauseOnHover:false,
    slidesToScroll: 1,
    variableWidth: true,
    infinite: true,
    initialSlide: 1,
    arrows: false,
    buttons: false
  });

  $('.slick.bannerfeatureLists2').slick({
    speed: 3000,
    autoplay: true,
    autoplaySpeed: 0,
    centerMode: false,
    cssEase: 'linear',
    draggable:false,
    focusOnSelect:false,
    pauseOnFocus:false,
    pauseOnHover:false,
    slidesToShow: 1,
    slidesToScroll: 1,
    variableWidth: true,
    infinite: true,
    initialSlide: 1,
    arrows: false,
    buttons: false,
    rtl:true
  });

  $('.slick.featureLists1').slick({
    speed: 3000,
    autoplay: true,
    autoplaySpeed: 0,
    centerMode: false,
    cssEase: 'linear',
    slidesToShow: 1,
    draggable:false,
    focusOnSelect:false,
    pauseOnFocus:false,
    pauseOnHover:false,
    slidesToScroll: 1,
    variableWidth: true,
    infinite: true,
    initialSlide: 1,
    arrows: false,
    buttons: false
  });

  $('.slick.featureLists2').slick({
    speed: 3000,
    autoplay: true,
    autoplaySpeed: 0,
    centerMode: false,
    cssEase: 'linear',
    draggable:false,
    focusOnSelect:false,
    pauseOnFocus:false,
    pauseOnHover:false,
    slidesToShow: 1,
    slidesToScroll: 1,
    variableWidth: true,
    infinite: true,
    initialSlide: 1,
    arrows: false,
    buttons: false,
    rtl:true
  });

  $('.client-slider').slick({
    speed: 3000,
    autoplay: true,
    autoplaySpeed: 0,
    centerMode: false,
    cssEase: 'linear',
    slidesToShow: 1,
    draggable:false,
    focusOnSelect:false,
    pauseOnFocus:false,
    pauseOnHover:false,
    slidesToScroll: 1,
    variableWidth: true,
    infinite: true,
    initialSlide: 1,
    arrows: false,
    buttons: false
  });

  $("#about-gallery-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    centerMode: true,
    centerPadding: '0px',
    arrows: false,
    infinite: true,
    autoplay: true,
    speed: 1500,
  fade: true,
  cssEase: 'linear'
  });

  $("#testimonials-slider").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      centerMode: true,
      centerPadding: '0',
      arrows: false,
      infinite: true,
      autoplay: true,
      adaptiveHeight: true,
      prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
      nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
      responsive: [
      {
        breakpoint: 1410,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 620,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });

  $("#industries-slider").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      centerMode: true,
      centerPadding: '0',
      arrows: false,
      infinite: true,
      autoplay: true,
      adaptiveHeight: true,
      speed: 1500,
      prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
      nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
      responsive: [
      {
        breakpoint: 1410,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 520,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });

  $("#casestudy-slider").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      centerMode: true,
      centerPadding: '0',
      arrows: false,
      infinite: true,
      autoplay: true,
      adaptiveHeight: true,
      prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
      nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
      responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 481,
        settings: {
          slidesToShow: 1,
        }
      }
    ]

  });

  $("#video-testi-slider").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      centerMode: true,
      centerPadding: '0px',
      //arrows: false,
      infinite: true,
      autoplay: true,
      adaptiveHeight: true,
      //prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
      //nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
      prevArrow: $('.vt-prev-btn'),
      nextArrow: $('.vt-next-btn')
  });

  $('.tool-item').on('click', function () {
    $('.tool-item').removeClass('active');
    $(this).addClass('active');
    var targetId = $(this).data('target');
    var targetContent = $('#' + targetId);
    if (!targetContent.is(':visible')) {
      $('.tool-item-content').slideUp();
      targetContent.slideDown();
    }
  });
  $(window).on('scroll', function() {
    if ($(this).scrollTop() > 50) {
      $('.header-nav').addClass('stickey');
    } else {
      $('.header-nav').removeClass('stickey');
    }
  });
  
    var rev = $('#product-video-slider');

  if (rev.length) {

    // Find slide whose data-title matches the current page slug
    var startIndex = 0;
    var slug = (window.wmCurrentSlug || '').toLowerCase();
    if (slug) {
      rev.find('.rev_slide').each(function (i) {
        if (String($(this).data('title')) === slug) {
          startIndex = i;
          return false; // break
        }
      });
    }

    rev.on('init', function (event, slick) {
      var cur   = $(slick.$slides[slick.currentSlide]),
          next  = cur.next(),
          next2 = next.next(),
          prev  = cur.prev(),
          prev2 = prev.prev();
      prev.addClass('slick-sprev');
      next.addClass('slick-snext');
      prev2.addClass('slick-sprev2');
      next2.addClass('slick-snext2');
      cur.removeClass('slick-snext slick-sprev slick-snext2 slick-sprev2');
      slick.$prev = prev;
      slick.$next = next;
    }).on('beforeChange', function (event, slick, currentSlide, nextSlide) {
      var cur = $(slick.$slides[nextSlide]);
      if (slick.$prev && slick.$next) {
        slick.$prev.removeClass('slick-sprev');
        slick.$next.removeClass('slick-snext');
        slick.$prev.prev().removeClass('slick-sprev2');
        slick.$next.next().removeClass('slick-snext2');
      }
      var n = cur.next(), p = cur.prev();
      p.addClass('slick-sprev');
      n.addClass('slick-snext');
      p.prev().addClass('slick-sprev2');
      n.next().addClass('slick-snext2');
      slick.$prev = p;
      slick.$next = n;
      cur.removeClass('slick-next slick-sprev slick-next2 slick-sprev2');
    });

    rev.slick({
      speed: 1000,
      arrows: true,
      dots: false,
      focusOnSelect: true,
      infinite: true,
      centerMode: true,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      centerPadding: '0',
      swipe: true,
      initialSlide: startIndex,          // <-- starts on the matched video
      customPaging: function () { return ''; }
    });
  }
});

jQuery(document).ready(function() {
  if (jQuery('#advtoolDropdown').length){
    let advtoolDropdown = document.getElementById('advtoolDropdown');

      advtoolDropdown.addEventListener('change', function () {
              const selectedTab = this.value;
              const tabTrigger = document.querySelector(`#${selectedTab}-tab`);
              if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
              }
      });
  }
});

// Awards Slider - standalone init
jQuery(document).ready(function($) {
  if ($("#awards-slider").length) {
    $("#awards-slider").slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2500,
      speed: 600,
      arrows: false,
      dots: false,
      infinite: true,
      pauseOnHover: true,
      prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
      nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
      responsive: [
        { breakpoint: 1200, settings: { slidesToShow: 3 } },
        { breakpoint: 900,  settings: { slidesToShow: 2 } },
        { breakpoint: 576,  settings: { slidesToShow: 1 } }
      ]
    });
  }
});


// Slider for news events
function initAnnouncementSlider() {
    var $track = jQuery('.announcement-slider__track');
    console.log("Hello World")
    if (!$track.length) return;

    if ($track.hasClass('slick-initialized')) {
        $track.slick('destroy');
    }

    $track.slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 1000,
        cssEase: 'ease-in-out',
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true,
        autoplay: true,
        autoplaySpeed: 3000,
    });
}

jQuery(document).ready(function($) {
    initAnnouncementSlider();
});

jQuery(function ($) {

    function showSubtitles(targetId) {
        $('.accordion-subtitle').removeClass('is-visible');
        $('.accordion-subtitle[data-parent="' + targetId + '"]').addClass('is-visible');
    }

    var $activeItem = $('.accordion-item.active').first();
    if ($activeItem.length) {
        showSubtitles($activeItem.data('target'));
    }

    $('.accordion-item')
        .off('click.accordionMain')
        .on('click.accordionMain', function () {
            var $item = $(this);

            $('.accordion-item').removeClass('active');
            $item.addClass('active');

            var targetId = $item.data('target');
            showSubtitles(targetId);

            if ($item.hasClass('has-subs')) {
                return;
            }

            var targetContent = $('#' + targetId);
            if (!targetContent.is(':visible')) {
                $('.accordion-item-content').stop(true, true).slideUp();
                targetContent.stop(true, true).slideDown();
            }
        });

    $('.accordion-subtitle')
        .off('click.accordionSub')
        .on('click.accordionSub', function () {
            var $sub    = $(this);
            var parent  = $sub.data('parent');
            var subId   = $sub.data('sub-target');
            var $panel  = $('#' + parent);
            var $target = $('#' + subId);

            $('.accordion-subtitle[data-parent="' + parent + '"]').removeClass('active');
            $sub.addClass('active');

            if (!$panel.is(':visible')) {
                $('.accordion-item-content').stop(true, true).slideUp();
                $panel.stop(true, true).slideDown();
            }

            if ($target.is(':visible')) return;

            $panel.find('.accordion-sub-content').stop(true, true).slideUp();
            $target.stop(true, true).slideDown();
        });

});


// Smart Hiring Section JS 

  // ---------- live counters ----------
  // Defined before Pipeline below because Pipeline's run() calls countUpFrom()
  // synchronously (before its first `await`) as part of Pipeline's own IIFE
  // invocation — if these were declared afterward in the file, that first call
  // would hit `prefersReducedMotion` while it was still in its temporal dead
  // zone and throw, which silently kills the whole run() loop forever (an
  // uncaught rejection in an async function with nothing awaiting it). That
  // exact bug shipped once already; declaring everything counter-related before
  // Pipeline uses it is what actually prevents it from coming back.
  //
  // This is plain JS/inline-style, so unlike every CSS animation/transition on
  // the page it isn't automatically collapsed by the prefers-reduced-motion
  // media query — checked once here and honored the same way: jump straight
  // to the value.
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Fired once, right as a card activates (see Pipeline.run() below): resets the
  // counter to "0" and rolls it up to its real value. This is a genuine numeric
  // roll (not the flip above) because 0 -> 247 has plenty of digits to visibly
  // count through — a flip only reads well for the small ±1 fluctuations that
  // follow once the card settles into its active window.
  function countUpFrom(el, target, duration){
    if (prefersReducedMotion){ el.textContent = target; return; }
    el.dataset.counting = '1';
    el.style.transition = 'none';
    el.style.transform = 'translateY(0)';
    el.style.opacity = '1';
    el.textContent = '0';
    const start = performance.now();
    function frame(now){
      const t = Math.min(1, (now - start) / duration);
      const eased = 1 - Math.pow(1 - t, 3);
      el.textContent = Math.round(target * eased);
      if (t < 1){
        requestAnimationFrame(frame);
      } else {
        el.dataset.counting = '0';
      }
    }
    requestAnimationFrame(frame);
  }

  // ---------- unified pipeline ----------
  // The 4-step timeline and the 3-card sequence used to be two independent timers
  // with different total cycle lengths (9.5s vs 12.2s) — they'd desync within a few
  // loops, showing e.g. "AI Screening" highlighted up top while Card 3 glowed below.
  // Both are now driven from this one `run()` loop so they can never drift apart.
  // Single source of truth: `activeStage`. Every card and counter reads its own
  // "am I allowed to animate" state from this one variable — nothing else decides it.
  (function(){
    const STAGES = {
      CARD_1: 'card1',
      TRANSITION_1_2: 'transition1to2',
      CARD_2: 'card2',
      TRANSITION_2_3: 'transition2to3',
      CARD_3: 'card3',              // card 3, "Best Fit" content
      TRANSITION_3_4: 'transition3to4',
      CARD_4: 'card4',              // card 3, "Candidate Hired" content — same physical card
      TRANSITION_4_1: 'transition4to1',
    };

    // The only place timing is defined — nothing below hardcodes a duration.
    const ANIMATION_CONFIG = {
      cardDuration: 3000,
      transitionDuration: 800,
    };

    const card1 = document.getElementById('card1');
    const card2 = document.getElementById('card2');
    const card3 = document.getElementById('card3');
    const card3Label = document.getElementById('card3Label');
    const applicantsCount = document.getElementById('applicants');
    const shortlistedCount = document.getElementById('shortlisted');
    const hiredCount = document.getElementById('bestfit');
    const connectorAB = document.getElementById('connectorAB'); // card1 <-> card2
    const connectorBC = document.getElementById('connectorBC'); // card2 <-> card3
    const trackAB = connectorAB.querySelector('.track');
    const trackBC = connectorBC.querySelector('.track');
    const lightA = document.getElementById('lightA');
    const lightB = document.getElementById('lightB');

    const timelineCircles = document.querySelectorAll('#timeline .circle');
    const timelineFills = document.querySelectorAll('#timeline .connector .fill');

    let activeStage = null;

    // Every stage maps to exactly one active card (or none, during a transition) —
    // reused both to drive the CSS `.active` class and to gate the JS counters below.
    // CARD_3 and CARD_4 both map to card3 — it's the same physical card active in
    // both stages, just showing different internal content (.show-hired below).
    const STAGE_TO_CARD = {
      [STAGES.CARD_1]: card1,
      [STAGES.CARD_2]: card2,
      [STAGES.CARD_3]: card3,
      [STAGES.CARD_4]: card3,
    };

    function setStage(stage){
      activeStage = stage;
      const activeCard = STAGE_TO_CARD[stage] || null;
      [card1, card2, card3].forEach(c => c.classList.toggle('active', c === activeCard));
    }

    function sleep(ms){
      return new Promise(resolve => setTimeout(resolve, ms));
    }

    // Reusable connector-light mover: measures the *visible track's* real rendered
    // width (not the wider connector container it sits in) so the light travels
    // exactly along the dashed line instead of overshooting past both ends, and
    // animates only `transform`/`opacity` — never `left` — so no layout is triggered.
    function travelLight(light, track, forward){
      return new Promise(resolve => {
        light.classList.toggle('is-reverse', !forward);
        const distance = track.getBoundingClientRect().width;
        const from = forward ? 0 : distance;
        const to = forward ? distance : 0;
        light.style.transition = 'none';
        light.style.transform = `translate(calc(-50% + ${from}px), -50%)`;
        light.style.opacity = '1';
        void light.offsetWidth; // force reflow so the transition below actually runs
        light.style.transition =
          `transform ${ANIMATION_CONFIG.transitionDuration}ms cubic-bezier(.4,0,.2,1), opacity 150ms ease`;
        light.style.transform = `translate(calc(-50% + ${to}px), -50%)`;
        setTimeout(() => {
          light.style.transition = 'opacity 200ms ease';
          light.style.opacity = '0';
          resolve();
        }, ANIMATION_CONFIG.transitionDuration);
      });
    }

    // Timeline: step 0-3 ("01".."04"), fill(i) lights the connector leading into step i+1.
    function setTimelineStep(activeIndex){
      timelineCircles.forEach((c, i) => {
        c.classList.toggle('is-done', i < activeIndex);
        c.classList.toggle('is-active', i === activeIndex);
      });
    }
    function fillTimelineConnector(i){
      const fill = timelineFills[i];
      if (!fill){ return; }
      fill.style.transition = 'none';
      fill.style.width = '0%';
      void fill.offsetWidth;
      fill.style.transition = `width ${ANIMATION_CONFIG.transitionDuration}ms linear`;
      fill.style.width = '100%';
    }
    // Same duration as travelLight's card-connector animation, so the timeline-only
    // 03->04 leg (no physical card sits between them, so no dot to move) still takes
    // exactly as long before the trigger below is allowed to fire.
    function fillTimelineConnectorAndWait(i){
      fillTimelineConnector(i);
      return sleep(ANIMATION_CONFIG.transitionDuration);
    }
    function resetTimeline(){
      timelineCircles.forEach(c => c.classList.remove('is-done', 'is-active'));
      timelineFills.forEach(fill => {
        fill.style.transition = 'width 500ms ease';
        fill.style.width = '0%';
      });
    }

    function showHiredCard(){
      card3.classList.add('show-hired');
      card3Label.textContent = 'Hired';
      countUpFrom(hiredCount, 1, 500);
    }
    function showBestFitCard(){
      card3.classList.remove('show-hired');
      card3Label.textContent = 'Best fit';
    }

    // The exact required flow, one stage at a time, never skipped, never overlapped —
    // with the 4-step timeline advancing in lockstep at every same call site.
    // Critical trigger: card3's content never swaps until the 03->04 light has
    // actually finished traveling (awaited below), never the instant stage03 ends.
    async function run(){
      while (true){
        setStage(STAGES.CARD_1);
        setTimelineStep(0);
        countUpFrom(applicantsCount, 247, 900);
        await sleep(ANIMATION_CONFIG.cardDuration);

        setStage(STAGES.TRANSITION_1_2); // all cards idle; only the light moves
        fillTimelineConnector(0);
        await travelLight(lightA, trackAB, true);

        setStage(STAGES.CARD_2);
        setTimelineStep(1);
        countUpFrom(shortlistedCount, 3, 700);
        await sleep(ANIMATION_CONFIG.cardDuration);

        setStage(STAGES.TRANSITION_2_3);
        fillTimelineConnector(1);
        await travelLight(lightB, trackBC, true);

        setStage(STAGES.CARD_3); // card3 active, showing "Best Fit"
        setTimelineStep(2);
        countUpFrom(hiredCount, 1, 500);
        await sleep(ANIMATION_CONFIG.cardDuration);

        setStage(STAGES.TRANSITION_3_4); // card3 idle, still "Best Fit" — only the timeline light moves
        await fillTimelineConnectorAndWait(2);

        setTimelineStep(3);   // light has arrived: 04 activates...
        showHiredCard();      // ...and only now does the physical card's content swap
        setStage(STAGES.CARD_4); // card3 active again, now animating its Hired-state visuals
        await sleep(ANIMATION_CONFIG.cardDuration);

        setStage(STAGES.TRANSITION_4_1); // card3 idle, stays in Hired look; light returns across the cards
        await travelLight(lightB, trackBC, false);
        await travelLight(lightA, trackAB, false);

        resetTimeline();
        showBestFitCard(); // only once back at the start does card3 reset for the new cycle
      }
    }
    run();
  })();
