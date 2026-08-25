document.addEventListener("DOMContentLoaded", () => {

  const tabs = document.querySelectorAll(".tab-link");
  // Check if we are on the pricing page
  const page = document.querySelector(".pricing-page");
  if (!page) return; // Stop script if not on pricing page
  const pageTitle = document.querySelector(".main-title");
  const card = document.querySelector("[data-role='card']");

  const startupTitle = document.querySelector("[data-role='startup-title']");
  const startupPrice = document.querySelector("[data-role='startup-price']");
  const startupDescription = document.querySelector("[data-role='startup-description']");
  const startupCta = document.querySelector("[data-role='startup-cta']");

  const enterpriseTitle = document.querySelector("[data-role='enterprise-title']");
  const enterprisePrice = document.querySelector("[data-role='enterprise-price']");
  const enterpriseDescription = document.querySelector("[data-role='enterprise-description']");
  const enterpriseCta = document.querySelector("[data-role='enterprise-cta']");

  const featuresWrapper = document.querySelector("[data-role='features-wrapper']");

  const currencySymbols = {
    INR: "₹",
    USD: "$",
    EUR: "€",
    GBP: "£",
    AUD: "A$",
    CAD: "C$",
    SGD: "S$",
    AED: "د.إ",
    JPY: "¥",
    CNY: "¥",
    CHF: "CHF ",
    NZD: "NZ$"
  };


  const pricingData = {
    "HRMS & Payroll": {
      hero: "From Startup to Enterprise",
      accentColor: "#1a73e8",
      accentTint: "#dbeafe",
      plans: {
        startup: { title: "Professional", price: "₹2250", description: "Monthly (Upto 25 employees)  Additional User @ ₹70/Month", cta: "Start A Free Trial" },
        enterprise: { title: "Exclusive", price: "Custom Plan",description: "Designed for Flexibility",  cta: "Request Pricing" }
      },

      sections: [
        {
          title: "Core HR",
          items: [
            "Employee Records",
            "Employee Onboarding",
            "Induction Automations",
            "Exit Process Automations",
            "Assets Tracking",
            "Holidays / Birthday / Anniversaries",
            "HR Helpdesk",
            "Announcements",
            "Role-Based Access"
          ]
        },
        {
          title: "Time & Attendance",
          items: [
            "Leave Management",
            "Timesheet Tracker",
            "Roster Planner",
            "Geo - Fencing & Geo - Tagging",
            "Email Integration",
            "Leave-to-Pay Mapping"
          ]
        },
        {
          title: "Payroll & Expense",
          items: [
            "Reimbursement",
            "Salary Setup",
            "Salary Structure",
            "CTC Dashboard",
            "Salary Insights",
            "Employee Master Data",
            "Multi-Branch Payroll"
          ]
        },
        {
          title: "Employee Self Service",
          items: [
            "People Finder",
            "Quick Search",
            "Employee Appreciations",
            "Peer to Peer",
            "Mobile Apps",
            "Multi Channel"
          ]
        },
        {
          title: "Employee Experience",
          items: [
            "Moodo Meter",
            "Peer Mentorship",
            "Visual Comfort"
          ]
        },
        {
          title: "Employee Development",
          items: [
            "Peer Mentorship",
            "Employee Appreciations"
          ]
        },
        {
          title: "Performance Management",
          items: [
            "Growth Reviews",
            "360 Degree Review",
            "Performance Tracking",
            "Appraisal Planner",
            "Goals & KPI's",
            "Employee Ranking",
            "Team Ranking"
          ]
        },
        {
          title: "Salary Setup",
          items: [
            "Salary Structure",
            "CTC Dashboard",
            "Salary Insights",
            "Employee Master Data",
            "Multi-Branch Payroll",
            "Role-Based Access"
          ]
        },
        {
          title: "Salary Processing",
          items: [
            "Auto Salary Calculation",
            "One-Click Payroll Run",
            "Payroll Additions & Deductions",
            "Attendance & LOP Sync",
            "Flexible Loan Repayment",
            "Loan EMI Auto Deduction"
          ]
        },
        {
          title: "Compliance & Statutory",
          items: [
            "PF, ESI, PT Auto Calculator",
            "Tax & Statutory Compliance",
            "Form 16 Generation",
            "Payroll Audit Trail",
            "Monthly & Yearly Reports"
          ]
        },
        {
          title: "Payslips & Outputs",
          items: [
            "Bulk Payslip Generation",
            "Payslip Auto Send",
            "Payroll Cost Analytics"
          ]
        }
      ]
    },

    // ------------------ TASKHUB ---------------------
    TaskHub: {
      hero: "From Startup to Enterprise",
      accentColor: "#c79a00",
      accentTint: "#fff3c4",
      plans: {
        startup: { title: "Professional", price: "₹200", description: "Per-user Monthly", cta: "Start A Free Trial" },
        enterprise: { title: "Exclusive", price: "Custom Plan",description: "Designed for Flexibility",  cta: "Request Pricing" }
      },

      sections: [
        {
          title: "Project Management",
          items: [
            "Project Management",
            "Milestone Planner",
            "Deadlines / Priority",
            "Real-Time Project Tracker",
            "Archive Projects",
            "Resource Organiser",
            "Project Expense Management"
          ]
        },
        {
          title: "Execution & Tracking",
          items: [
            "Dynamic Workflow",
            "Timesheet Tracker",
            "Sprint Notes",
            "Resource Organiser",
            "Performance Tracking"
          ]
        },
        {
          title: "Workspaces",
          items: [
            "Shared Workspace",
            "File Sharing",
            "Email Preferences"
          ]
        },
        {
          title: "Client Management",
          items: [
            "Client Central",
            "Team Collaboration"
          ]
        }
      ]
    },

    // ------------------ CRM ---------------------
    "CRM": {
      hero: "From Startup to Enterprise",
      accentColor: "#0f9b8e",
      accentTint: "#d8f3ef",
      plans: {
        startup: { title: "Professional", price: "₹300", description: "Per-user Monthly", cta: "Start A Free Trial" },
        enterprise: { title: "Exclusive", price: "Custom Plan",description: "Designed for Flexibility",  cta: "Request Pricing" }
      },

      sections: [
        {
          title: "Leads & Pipeline",
          items: [
            "Leads",
            "Sales Pipeline",
            "Lead Tagging",
            "Follow Up Tracker",
            "Territory Management",
            "Leadboard"
          ]
        },
        {
          title: "Sales Operations",
          items: [
            "Invoices",
            "Multi Currency",
            "Calendar Integration",
            "Email Integration",
            "Outreach Management",
            "Forecast Sells",
            "Payment Tracker",
            "Sales Target",
            "Sales Order"
          ]
        },
        {
          title: "Client Management",
          items: [
            "Client Central",
            "Team Collaboration"
          ]
        }
      ]
    },

    // ------------------ Connect ---------------------
    "Connect": {
      hero: "From Startup to Enterprise",
      accentColor: "#1c7ed6",
      accentTint: "#e2f0ff",
      plans: {
        startup: { title: "Professional", price: "₹350", description: "Monthly (Upto 5 Employees)  Additional User @ ₹60/Month", cta: "Start A Free Trial" },
        enterprise: { title: "Exclusive", price: "Custom Plan",description: "Designed for Flexibility",  cta: "Request Pricing" }
      },

      sections: [
        {
          title: "Communication",
          items: [
            "Realtime Chat",
            "Encrypted Messaging",
            "Peer to Peer",
            "Audio and Video Call",
          ]
        },
        {
          title: "Collaboration",
          items: [
            "Team Collaboration",
            "File Sharing",
            "Shared Workspace",
          ]
        },
        {
          title: "Utilities",
          items: [
            "Mobile Apps",
            "Multi Channel",
            "Quick Search",
            "People Finder"
          ]
        }
      ]
    },
    // ------------------ ASSETS ---------------------
  "Assets": {
    hero: "From Startup to Enterprise",
    accentColor: "#8b5cf6",
    accentTint: "#ede9fe",

    plans: {
      startup: {
        title: "Professional",
        price: "₹20",
        description: "Per Asset",
        cta: "Start A Free Trial"
      },
      enterprise: {
        title: "Exclusive",
        price: "Custom Plan",
        description: "Designed for Flexibility",
        cta: "Request Pricing"
      }
    },

    sections: [
      {
        title: "Asset Tracking",
        items: [
          "Asset Register",
          "Asset Classification",
          "Branch-wise Asset Tracking",
          "Asset Lifecycle Monitoring"
        ]
      },
      {
        title: "Asset Allocation",
        items: [
          "Employee Asset Allocation",
          "Asset De-Allocation",
          "Asset History"
        ]
      },
      {
        title: "Asset Maintenance",
        items: [
          "Warranty Tracking",
          "Repair & Maintenance Tracking",
          "Scrap & Disposal Management",
          "Bulk Asset Import & Export"
        ]
      }
    ]
  }
  };


  const buildFeatureItem = (label) => {
    const item = document.createElement("div");
    item.className = "feature-item";
    item.innerHTML = `
      <svg class="check-icon" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
      </svg>
      <span>${label}</span>
    `;
    return item;
  };


  const renderFeatures = (sections) => {
    featuresWrapper.innerHTML = "";

    sections.forEach((section) => {
      const sectionEl = document.createElement("section");
      sectionEl.className = "feature-section";

      const heading = document.createElement("h3");
      heading.className = "features-title";
      heading.textContent = section.title;

      const grid = document.createElement("div");
      grid.className = "features-grid";

      section.items.forEach((item) => {
        grid.appendChild(buildFeatureItem(item));
      });

      sectionEl.appendChild(heading);
      sectionEl.appendChild(grid);

      featuresWrapper.appendChild(sectionEl);
    });
  };


  let userCurrency = "INR";
  let conversionRate = 1;
  let userCountry = "India";

  // --- safe number extractor ---
  function extractNumber(str) {
    if (!str) return 0;
    const clean = String(str).replace(/[^0-9.]/g, ""); // keep digits & dot
    return parseFloat(clean) || 0;
  }

  // --- convert and format ---
  function convertPrice(inrValue) {
    const symbol = currencySymbols[userCurrency] || userCurrency + " ";
    if (!conversionRate || userCurrency === "INR") {
      return (currencySymbols.INR || "₹") + inrValue.toLocaleString();
    }
    const converted = inrValue * conversionRate;
    const rounded = Math.round(converted);
    return symbol + rounded.toLocaleString();
  }

  // Update only prices
  function updateOnlyPrices() {
    const activeKey = document.querySelector(".tab-link.active")?.dataset.key;
    if (!activeKey) return;

    const data = pricingData[activeKey];
    if (!data) return;

    [startupPrice, enterprisePrice].forEach((el) => {
      let planKey = el === startupPrice ? "startup" : "enterprise";
      const price = data.plans[planKey].price;

      if (typeof price === "string" && price.toLowerCase() === "custom plan") {
        el.textContent = price;
      } else {
        el.textContent = convertPrice(extractNumber(price));
      }
    });
  }

  function formatDescription(text) {
    const spans = text.split(/  +/).map(part => `<span>${part.trim()}</span>`).join("");
    return `${spans}`;
  }

  const renderPricing = (key) => {
    const data = pricingData[key];
    if (!data) return;

    pageTitle.textContent = data.hero;
    page.style.setProperty("--accent-color", data.accentColor);
    page.style.setProperty("--accent-strong", data.accentColor);
    page.style.setProperty("--accent-tint", data.accentTint);
    card.style.setProperty("--accent-tint", data.accentTint);

    startupTitle.textContent = data.plans.startup.title;
    startupDescription.innerHTML = formatDescription(data.plans.startup.description);
    enterpriseDescription.innerHTML = formatDescription(data.plans.enterprise.description);

    enterpriseTitle.textContent = data.plans.enterprise.title;
    enterpriseDescription.textContent = data.plans.enterprise.description;
    enterpriseCta.textContent = data.plans.enterprise.cta;

    // Update prices
    [startupPrice, enterprisePrice].forEach((el) => {
      let planKey = el === startupPrice ? "startup" : "enterprise";
      const plan = data.plans[planKey];
      if (!plan) return;

      const price = plan.price;

      if (typeof price === "string" && price.toLowerCase() === "custom plan") {
        el.textContent = price;
      } else {
        el.textContent = convertPrice(extractNumber(price));
      }
    });

    renderFeatures(data.sections);
  };

  tabs.forEach((tab) => {
    tab.addEventListener("click", (event) => {
      event.preventDefault();
      tabs.forEach((t) => t.classList.remove("active"));
      tab.classList.add("active");

      const key = tab.dataset.key;

      const hrmsTab   = document.querySelector(".hrms-tab-content");
      const ecrmTab   = document.querySelector(".ecrm-tab-content");
      const otherTabs = document.querySelector(".other-tabs-content");

      if ( key === "HRMS & Payroll" ) {
          hrmsTab.style.display   = "block";
          if (ecrmTab) ecrmTab.style.display = "none";
          otherTabs.style.display = "none";
      } else if ( key === "CRM" ) {
          hrmsTab.style.display   = "none";
          if (ecrmTab) ecrmTab.style.display = "block";
          otherTabs.style.display = "none";
      } else {
          hrmsTab.style.display   = "none";
          if (ecrmTab) ecrmTab.style.display = "none";
          otherTabs.style.display = "block";

          const pricingSection = document.querySelector(".pricing-section");
          pricingSection.classList.remove("hrms-active","taskhub-active","e-crm-active","e-connect-active","assets-active");
          if (key === "TaskHub")   pricingSection.classList.add("taskhub-active");
          if (key === "CRM")     pricingSection.classList.add("e-crm-active");
          if (key === "Connect") pricingSection.classList.add("e-connect-active");
          if (key === "Assets")    pricingSection.classList.add("assets-active");

          renderPricing(key);
      }
    });
  });

  // --- init flow: get IP -> currency -> rate -> render first tab ---
  async function init() {
    // 1️⃣ Render UI instantly with INR (default)
    const firstKey = document.querySelector(".tab-link")?.dataset.key;
    if (firstKey && firstKey !== "HRMS & Payroll") renderPricing(firstKey);

    try {
      const ipRes = await fetch("https://ipapi.co/json/");

      if (!ipRes.ok) {
        throw new Error("IP API failed");
      }

      const ipData = await ipRes.json();

      userCountry = ipData.country_name || "India";
      userCurrency = ipData.currency || "INR";

      // ---- Fetch conversion rate ----
      if (userCurrency !== "INR") {
        try {
          const rateRes = await fetch(`https://api.frankfurter.app/latest?from=INR&to=${userCurrency}`);
          const rateData = await rateRes.json();

          if (rateData && rateData.rates && typeof rateData.rates[userCurrency] === "number") {
            conversionRate = rateData.rates[userCurrency];
          } else {
            conversionRate = 1;
            userCurrency = "INR";
          }
        } catch (err) {
          conversionRate = 1;
          userCurrency = "INR";
        }
      }
    } catch (err) {
      userCountry = "India";
      userCurrency = "INR";
      conversionRate = 1;
    }

    updateOnlyPrices();
  }

  function switchHrmsTab(target) {
    document.querySelectorAll('.hrms-sub-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.hrms-sub-panel').forEach(p => p.classList.remove('active'));
    const btn = document.querySelector(`.hrms-sub-tab-btn[data-hrms-tab="${target}"]`);
    if (btn) btn.classList.add('active');
    document.querySelector(`.hrms-sub-panel[data-hrms-panel="${target}"]`)?.classList.add('active');
    const dropdown = document.querySelector('.hrms-sub-tabs-dropdown');
    if (dropdown) dropdown.value = target;
  }

  document.querySelectorAll('.hrms-sub-tab-btn').forEach(btn => {
    btn.addEventListener('click', () => switchHrmsTab(btn.dataset.hrmsTab));
  });

  const hrmsDropdown = document.querySelector('.hrms-sub-tabs-dropdown');
  if (hrmsDropdown) {
    hrmsDropdown.addEventListener('change', () => switchHrmsTab(hrmsDropdown.value));
  }

  const mainDropdown = document.querySelector('.main-tabs-dropdown');
  if (mainDropdown) {
    mainDropdown.addEventListener('change', () => {
      tabs.forEach((t) => t.classList.remove('active'));
      const matchingTab = document.querySelector(`.tab-link[data-key="${mainDropdown.value}"]`);
      if (matchingTab) matchingTab.classList.add('active');

      const key = mainDropdown.value;
      const hrmsTab   = document.querySelector('.hrms-tab-content');
      const ecrmTab   = document.querySelector('.crm-tab-content');
      const otherTabs = document.querySelector('.other-tabs-content');

      if (key === 'HRMS & Payroll') {
        hrmsTab.style.display   = 'block';
        if (ecrmTab) ecrmTab.style.display = 'none';
        otherTabs.style.display = 'none';
      } else if (key === 'CRM') {
        hrmsTab.style.display   = 'none';
        if (ecrmTab) ecrmTab.style.display = 'block';
        otherTabs.style.display = 'none';
      } else {
        hrmsTab.style.display   = 'none';
        if (ecrmTab) ecrmTab.style.display = 'none';
        otherTabs.style.display = 'block';

        const pricingSection = document.querySelector('.pricing-section');
        pricingSection.classList.remove('hrms-active','taskhub-active','e-crm-active','e-connect-active','assets-active');
        if (key === 'TaskHub')   pricingSection.classList.add('taskhub-active');
        if (key === 'Connect') pricingSection.classList.add('Connect-active');
        if (key === 'Assets')    pricingSection.classList.add('assets-active');

        renderPricing(key);
      }
    });
  }

  // Start init
  init();
});