(function () {
  'use strict';

  function wmcpGetImgBase() {
    if (window.wmcpImgBase) { return window.wmcpImgBase; }
    return '/wp-content/themes/weekmate/images';
  }

  /* ---- pain / fix icons (image paths reused from zip) ---- */
  var PAIN_ICONS = [
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/document.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/clock.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/calendar-x.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/file-signature.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/star-off.png" alt="" width="22" height="22" />'
  ];
  var FIX_ICONS = [
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/icon1-right.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/clock-right.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/calendar-right.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/rocket-right.png" alt="" width="22" height="22" />',
    '<img loading="lazy" src="' + wmcpGetImgBase() + '/bar-chart.png" alt="" width="22" height="22" />'
  ];

  /* location pin SVG used for each place card */
  var PIN_SVG = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><g clip-path="url(#wmcp-pin)"><mask id="wmcp-pm" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40"><path d="M0 0H40V40H0V0Z" fill="white"/></mask><g mask="url(#wmcp-pm)"><path d="M8.28125 12.8887C8.28125 6.42735 13.5387 1.16992 20 1.16992C26.4613 1.16992 31.7188 6.42735 31.7188 12.8887C31.7188 17.9349 29.9026 19.3089 20 32.6738C10.1191 19.3382 8.28125 17.9359 8.28125 12.8887Z" stroke="black" stroke-width="2.34375" stroke-miterlimit="10"/><path d="M20 17.5781C17.4153 17.5781 15.3125 15.4753 15.3125 12.8906C15.3125 10.3059 17.4153 8.20312 20 8.20312C22.5847 8.20312 24.6875 10.3059 24.6875 12.8906C24.6875 15.4753 22.5847 17.5781 20 17.5781Z" stroke="black" stroke-width="2.34375" stroke-miterlimit="10"/><path d="M22.335 29.5462C27.6884 29.9791 31.7188 31.8716 31.7188 34.1406C31.7188 36.7295 26.4721 38.8281 20 38.8281C13.528 38.8281 8.28125 36.7295 8.28125 34.1406C8.28125 31.8716 12.3116 29.9791 17.665 29.5462" stroke="black" stroke-width="2.34375" stroke-miterlimit="10"/></g></g><defs><clipPath id="wmcp-pin"><rect width="40" height="40" fill="white"/></clipPath></defs></svg>';

  /* ---- Read JSON data ---- */
  var dataEl = document.getElementById('page-data');
  if (!dataEl) return;
  var data;
  try { data = JSON.parse(dataEl.textContent); } catch (e) { return; }

  function get(path) {
    return path.split('.').reduce(function (o, k) { return (o || {})[k]; }, data);
  }

  var root = document.querySelector('.wmcp-city-page');
  if (!root) return;

  /* ---- 1. data-field: simple text injection ---- */
  root.querySelectorAll('[data-field]').forEach(function (el) {
    var v = get(el.getAttribute('data-field'));
    if (v == null || v === '') { return; }

    if (el.tagName === 'H1') {
      var str = String(v);
      var builtIdx = str.indexOf(' Built for');
      if (builtIdx !== -1) {
        var beforeBuilt = str.substring(0, builtIdx);
        var afterBuilt  = str.substring(builtIdx);
        var words = beforeBuilt.split(' ');
        var cityWord = words.pop();
        el.innerHTML = words.join(' ') + ' <br/><span class="homepage__hero-highlight">' + cityWord + '</span><br/>' + afterBuilt.trim();
      } else {
        var parts = String(v).split(' ');
        var last = parts.pop();
        el.innerHTML = parts.join(' ') + ' <br/><span class="homepage__hero-highlight">' + last + '</span>';
      }
    } else {
      el.textContent = v;
    }
  });

  // heading left as plain text — no city-highlight split

function formatPlacesTitle() {
  const heading = document.querySelector('h2[data-field="sections.places.h2"]');
  if (!heading) return;

  const text = heading.textContent.trim();
  const keyword = 'visit in ';
  const idx = text.toLowerCase().lastIndexOf(keyword);

  if (idx === -1) return;

  // Includes "Visit in"
  const before = text.substring(0, idx + keyword.length);
  const after = text.substring(idx + keyword.length).trim();

  heading.innerHTML = `${before}<br><span>${after}</span>`;
}

  formatPlacesTitle();
  

  /* ---- 2. Places cards (homepage__business-card) ---- */
  var placesEl = root.querySelector('[data-list="places"]');
  if (placesEl) {
    (get('sections.places.items') || []).forEach(function (p) {
      var card = document.createElement('article');
      card.className = 'homepage__business-card';
      card.innerHTML =
        '<div class="homepage__business-icon">' + PIN_SVG + '</div>'
        + '<h3 class="homepage__business-title"></h3>'
        + '<p class="homepage__business-text"></p>';
      card.querySelector('.homepage__business-title').textContent = p.name || '';
      card.querySelector('.homepage__business-text').textContent = p.description || '';
      placesEl.appendChild(card);
    });
  }

  /* ---- helper: build a challenges row ---- */
  function buildChallengeRow(text, iconHtml, variant) {
    var row = document.createElement('div');
    row.className = 'homepage__challenges-row';
    row.innerHTML =
      '<div class="homepage__challenges-icon homepage__challenges-icon--' + variant + '">' + iconHtml + '</div>'
      + '<div class="homepage__challenges-text">'
      + '<p class="homepage__challenges-row-title"></p>'
      + '</div>';
    row.querySelector('.homepage__challenges-row-title').textContent = text;
    return row;
  }

  /* ---- 3. Pain points ---- */
  var painEl = root.querySelector('[data-list="pain"]');
  if (painEl) {
    (get('sections.pain_points.bullets') || []).forEach(function (text, i) {
      painEl.appendChild(buildChallengeRow(text, PAIN_ICONS[i] || PAIN_ICONS[0], 'pain'));
    });
  }

  /* ---- 4. Solutions ---- */
  var fixEl = root.querySelector('[data-list="fix"]');
  if (fixEl) {
    (get('sections.solutions.bullets') || []).forEach(function (text, i) {
      fixEl.appendChild(buildChallengeRow(text, FIX_ICONS[i] || FIX_ICONS[0], 'solution'));
    });
  }

  /* ---- 5. Feature grid (about) — first 4 solution bullets ---- */
  var featureGrid = document.getElementById('wmcp-feature-grid');
  if (featureGrid) {
    var bullets = get('sections.solutions.bullets') || [];
    var nums = ['01.', '02.', '03.', '04.'];
    var featureTitles = [
      'Smart Automation',
      'Centralized Platform',
      'Better Engagement',
      'Data Driven Growth'
    ];
    bullets.slice(0, 4).forEach(function (text, i) {
      var div = document.createElement('div');
      div.className = 'homepage__business-feature';
      div.innerHTML =
        '<span class="homepage__business-number">' + nums[i] + '</span>'
        + '<div class="homepage__business-feature-content">'
        + '<h3 class="homepage__business-feature-title"></h3>'
        + '<p class="homepage__business-feature-text"></p>'
        + '</div>';
      div.querySelector('.homepage__business-feature-title').textContent = featureTitles[i];
      div.querySelector('.homepage__business-feature-text').textContent = text;
      featureGrid.appendChild(div);
    });
  }

  /* ---- 6. FAQs — Bootstrap accordion (unchanged from theme) ---- */
  var faqWrap = root.querySelector('[data-list="faqs"]');
  if (faqWrap) {
    var items = get('sections.faqs.items') || [];

    var col1 = document.createElement('div');
    col1.className = 'col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12';
    var acc1 = document.createElement('div');
    acc1.className = 'accordion accordion-flush faqs-accordion';
    col1.appendChild(acc1);

    var col2 = document.createElement('div');
    col2.className = 'col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12';
    var acc2 = document.createElement('div');
    acc2.className = 'accordion accordion-flush faqs-accordion';
    col2.appendChild(acc2);

    faqWrap.appendChild(col1);
    faqWrap.appendChild(col2);

    items.forEach(function (f, i) {
      var colIdx = i % 2 === 0 ? 0 : 1;
      var acc = colIdx === 0 ? acc1 : acc2;
      var uid = 'wmcpFaq' + i;
      var isFirst = (i === 0);

      var item = document.createElement('div');
      item.className = 'accordion-item';
      item.innerHTML =
        '<h3 class="accordion-header">'
        + '<button class="accordion-button' + (isFirst ? '' : ' collapsed') + '" type="button"'
        + ' data-bs-toggle="collapse" data-bs-target="#' + uid + '"'
        + ' aria-expanded="' + (isFirst ? 'true' : 'false') + '"'
        + ' aria-controls="' + uid + '"></button>'
        + '</h3>'
        + '<div id="' + uid + '" class="accordion-collapse collapse' + (isFirst ? ' show' : '') + '"'
        + ' data-bs-parent="#wmcpFaqMain">'
        + '<div class="accordion-body"></div>'
        + '</div>';

      item.querySelector('.accordion-button').textContent = f.question || '';
      item.querySelector('.accordion-body').textContent = f.answer || '';
      acc.appendChild(item);
    });
  }

  /* ---- 7. Scroll reveal ---- */
  var revealEls = root.querySelectorAll('.wmcp-reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          e.target.classList.add('wmcp-is-visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('wmcp-is-visible'); });
  }

})();