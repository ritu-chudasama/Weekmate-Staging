(function () {
  var root = document.querySelector(".wmcp-city-page");
  var dataEl = document.getElementById("page-data");
  if (!root || !dataEl) {
    return;
  }

  var data;
  try {
    data = JSON.parse(dataEl.textContent);
  } catch (e) {
    return;
  }

  function get(path) {
    return path.split(".").reduce(function (o, k) {
      return (o || {})[k];
    }, data);
  }

  root.querySelectorAll("[data-field]").forEach(function (el) {
    var v = get(el.getAttribute("data-field"));
    if (v != null) {
      el.textContent = v;
    }
  });

  var placesUl = root.querySelector('[data-list="places"]');
  if (placesUl) {
    (get("sections.places.items") || []).forEach(function (p) {
      var li = document.createElement("li");
      li.className = "place";
      li.innerHTML = '<div class="name"></div><div class="desc"></div>';
      li.querySelector(".name").textContent = p.name;
      li.querySelector(".desc").textContent = p.description;
      placesUl.appendChild(li);
    });
  }

  function fillBullets(listKey, dataPath, markChar) {
    var ul = root.querySelector('[data-list="' + listKey + '"]');
    if (!ul) {
      return;
    }
    (get(dataPath) || []).forEach(function (text) {
      var li = document.createElement("li");
      li.className = "bullet " + listKey;
      li.innerHTML = '<span class="mark"></span><span class="txt"></span>';
      li.querySelector(".mark").textContent = markChar;
      li.querySelector(".txt").textContent = text;
      ul.appendChild(li);
    });
  }

  fillBullets("pain", "sections.pain_points.bullets", "!");
  fillBullets("fix", "sections.solutions.bullets", "\u2713");

  var faqWrap = root.querySelector('[data-list="faqs"]');
  if (faqWrap) {
    (get("sections.faqs.items") || []).forEach(function (f) {
      var item = document.createElement("div");
      item.className = "faq";
      item.setAttribute("open-state", "false");
      item.innerHTML =
        '<button aria-expanded="false"><span class="q"></span><span class="icon">+</span></button>' +
        '<div class="answer"><p></p></div>';
      item.querySelector(".q").textContent = f.question;
      item.querySelector(".answer p").textContent = f.answer;
      var btn = item.querySelector("button");
      var ans = item.querySelector(".answer");
      btn.addEventListener("click", function () {
        var open = item.getAttribute("open-state") === "true";
        item.setAttribute("open-state", String(!open));
        btn.setAttribute("aria-expanded", String(!open));
        ans.style.maxHeight = open ? null : ans.scrollHeight + "px";
      });
      faqWrap.appendChild(item);
    });
  }
})();
