// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// Salary Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
document.addEventListener("DOMContentLoaded", () => {

  const salaryContainer = document.querySelector(".salary__card");
  if (!salaryContainer) return; // <-- stops code if calculator not on page

  // Parse currency-like input (commas allowed)
  function parseNumber(str) {
    if (str === null || str === undefined) return 0;
    str = String(str).replace(/[^0-9.-]/g, '');
    const val = Number(str);
    return isNaN(val) ? 0 : val;
  }

  // Format numbers in Indian comma grouping
  function formatINR(num) {
    const n = Math.round(Number(num) || 0);
    return n.toLocaleString('en-IN');
  }

  // Format rupee input on blur to avoid caret jumps while typing
  function formatINRInput(el) {
    const parsed = parseNumber(el.value);
    el.value = parsed ? formatINR(parsed) : '';
  }

  // DOM elements
  const currentCTC = document.getElementById("currentCTC");
  const newCTC = document.getElementById("newCTC");
  const hikeRange = document.getElementById("hikeRange");
  const hikePct = document.getElementById("hikePct");

  const absIncrease = document.getElementById("absIncrease");
  const monthlyIncrease = document.getElementById("monthlyIncrease");

  const displayBefore = document.getElementById("displayBefore");
  const displayAfter = document.getElementById("displayAfter");
  const displayPct = document.getElementById("displayPct");
  const pctPill = document.getElementById("pctPill");
  const displayIncAnn = document.getElementById("displayIncAnn");
  const displayIncMo = document.getElementById("displayIncMo");

  const resetBtn = document.getElementById("salary-resetBtn");
  const errorEl = document.getElementById("newCtcError");
  const limitErr = document.getElementById("ctcLimitError");


  const MAX_LIMIT = 100000000; // 10 Crore

  // Central update function
  function updateValues(curInput, pctInput, newValInput) {
    // raw numbers (no commas)
    const cur = Number(curInput) || 0;
    let pct = Number(pctInput) || 0;
    let newVal = Number(newValInput) || 0;

    if (cur > MAX_LIMIT || newVal > MAX_LIMIT) {
      currentCTC.classList.add("input-error");
      newCTC.classList.add("input-error")
      limitErr.style.display = "block";
      return;
    } else {
      currentCTC.classList.remove("input-error");
      newCTC.classList.remove("input-error")
      limitErr.style.display = "none";
    }

    // If user hasn't typed newVal (0 or empty) calculate it from pct
    if (!newVal && cur) newVal = cur * (1 + pct / 100);

    // Only calculate pct when current CTC > 0 and new is greater
    if (cur > 0 && newVal > cur) {
      pct = ((newVal - cur) / cur) * 100;

      // Prevent unrealistic explosion values
      if (!isFinite(pct) || pct > MAX_PCT) {
        pct = MAX_PCT;
      }
    } else if (cur === 0) {
      pct = 0; // Never calculate pct if current CTC not set
    }

    // prevent negative pct
    if (pct < 0) pct = 0;

    // validation: new CTC must be >= current (only if user typed newVal)
    // treat empty/newVal=0 as "not typed" and allow calculation from pct
    if (newValInput && newValInput !== 0 && newVal < cur) {
      errorEl.textContent = "New CTC must be greater than or equal to Current CTC";
      errorEl.style.display = "block";
      newCTC.classList.add("input-error")
      return;
    } else {
      errorEl.style.display = "none";
      newCTC.classList.remove("input-error")
    }

    // compute increases
    const absInc = newVal - cur;
    const monthlyInc = absInc / 12;

    // Update visible fields:
    // - Format currency only on blur; during live typing we keep raw numbers in input.
    if (document.activeElement !== currentCTC) {
      currentCTC.value = cur ? formatINR(cur) : '';
    }
    if (document.activeElement !== newCTC) {
      newCTC.value = newVal ? formatINR(newVal) : '';
    }

    // update slider and pct input (but don't clobber pct while the user is editing)
    hikeRange.value = pct;
    if (document.activeElement !== hikePct) {
      // show with up to 2 decimals, as plain number (no % sign)
      hikePct.value = Number(pct.toFixed(2));
    }

    displayBefore.textContent = cur ? "" + formatINR(cur) : "0";
    displayAfter.textContent = newVal ? "" + formatINR(newVal) : "0";
    displayPct.textContent = pct ? pct.toFixed(2) + " %" : "0 %";
    pctPill.textContent = pct ? pct.toFixed(2) + "%" : "0%";

    const formattedIncrease = "" + formatINR(Math.max(0, absInc));
    absIncrease.textContent = cur ? formattedIncrease : "0";
    displayIncAnn.textContent = cur ? formattedIncrease : "0";

    const formattedMonthly = "" + formatINR(Math.max(0, monthlyInc));
    monthlyIncrease.textContent = cur ? formattedMonthly : "0";
    displayIncMo.textContent = cur ? formattedMonthly : "0";
  }

  function restrictToNumeric(el) {
    el.addEventListener("input", () => {
      el.value = el.value.replace(/[^0-9.]/g, ""); // Allow only digits + .
    });
  }
  restrictToNumeric(currentCTC);
  restrictToNumeric(newCTC);
  restrictToNumeric(hikePct);

  function enforceCTCLimit(el) {
    el.addEventListener("input", () => {
      let val = parseNumber(el.value);

      if (val > MAX_LIMIT) {
        val = MAX_LIMIT;
      }

      el.value = val ? formatINR(val) : "";
    });

    // Remove commas while typing
    el.addEventListener("keydown", () => {
      el.value = parseNumber(el.value);
    });
  }
  enforceCTCLimit(currentCTC);
  enforceCTCLimit(newCTC);


  // LISTENERS

  // Current CTC: user types digits (no formatting while typing), format on blur
  currentCTC.addEventListener("input", () => {
    // allow user to type; use parseNumber for calculations
    const cur = parseNumber(currentCTC.value);
    const pct = Number(hikeRange.value) || 0;
    updateValues(cur, pct, 0);
  });
  currentCTC.addEventListener("blur", () => {
    formatINRInput(currentCTC);
  });

  // New CTC: similar behavior — live parse and validate but format on blur
  newCTC.addEventListener("input", () => {
    const cur = parseNumber(currentCTC.value);
    const newVal = parseNumber(newCTC.value);
    // pass pct as 0 so updateValues will compute pct from newVal if needed
    updateValues(cur, 0, newVal);
  });
  newCTC.addEventListener("blur", () => {
    formatINRInput(newCTC);
  });

  // Range slider: updates pct and recalculates
  hikeRange.addEventListener("input", () => {
    const cur = parseNumber(currentCTC.value);
    const pct = Number(hikeRange.value) || 0;
    // reflect in numeric pct input (but don't steal focus)
    if (document.activeElement !== hikePct) hikePct.value = Number(pct.toFixed(2));
    updateValues(cur, pct, 0);
  });

  const MAX_PCT = 1000;

  hikePct.addEventListener("input", () => {
    let pct = Number(hikePct.value);

    if (pct > MAX_PCT) {
      pct = MAX_PCT;
      hikePct.value = MAX_PCT;
    }
    if (pct < 0) pct = 0;

    hikeRange.value = pct;
    const cur = parseNumber(currentCTC.value);
    updateValues(cur, pct, 0);
  });

  // ensure pct displays with 2 decimals on blur
  hikePct.addEventListener("blur", () => {
    const pct = Number(hikePct.value) || 0;
    hikePct.value = Number(pct.toFixed(2));
  });

  // Reset button
  resetBtn.addEventListener("click", () => {
    currentCTC.value = 0;
    newCTC.value = 0;
    hikeRange.value = 0;
    hikePct.value = 0;
    errorEl.style.display = "none";
    updateValues(0, 0, 0);
  });

  // init default
  updateValues(1000000, 10, 0);

});










// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// HRA Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
document.addEventListener("DOMContentLoaded", () => {
  const hraContainer = document.querySelector(".hra-calculator");
  if (!hraContainer) return;



  function INR(v) {
    return "₹" + (Number(v) || 0).toLocaleString("en-IN", { minimumFractionDigits: 2 });
  }

  const calcBtn = hraContainer.querySelector("#calcBtn");
  const resetBtn = hraContainer.querySelector("#hra-resetBtn");

  function calculateHRA() {

    const basicInput = hraContainer.querySelector("#basic");
    const daInput = hraContainer.querySelector("#da");
    const hraInput = hraContainer.querySelector("#hra");
    const rentInput = hraContainer.querySelector("#rent");


    const getNonNegativeValue = (inputElement) => {
      let value = Number(inputElement.value) || 0;
      if (value < 0) {
        value = 0;
        inputElement.value = 0;
      }
      return value;
    };

    const basic = getNonNegativeValue(basicInput);
    const da = getNonNegativeValue(daInput);
    const hra = getNonNegativeValue(hraInput);
    const rent = getNonNegativeValue(rentInput);


    const salary = basic + da;
    const actual = hra;

    const rentExcess = Math.max(0, rent - salary * 0.10);

    const city = hraContainer.querySelector("input[name='cityType']:checked").value;

    const percentSalary = city === "metro" ? salary * 0.50 : salary * 0.40;

    const exempt = Math.min(actual, rentExcess, percentSalary);
    const taxable = actual - exempt;

    hraContainer.querySelector("#percentLabel").textContent =
      city === "metro" ? "50% Salary" : "40% Salary";

    hraContainer.querySelector("#outActual").textContent = INR(actual);
    hraContainer.querySelector("#outRent").textContent = INR(rentExcess);
    hraContainer.querySelector("#outPercent").textContent = INR(percentSalary);
    hraContainer.querySelector("#outExempt").textContent = INR(exempt);
    hraContainer.querySelector("#outTax").textContent = INR(taxable);
  }


  calcBtn?.addEventListener("click", calculateHRA);

  hraContainer.querySelectorAll("input[name='cityType']").forEach(radio => {
    radio.addEventListener("change", calculateHRA);
  });

  hraContainer.querySelectorAll("input[type='number']").forEach(input => {
    input.addEventListener("input", calculateHRA);
    input.addEventListener("change", calculateHRA);
  });


  resetBtn?.addEventListener("click", () => {
    hraContainer.querySelectorAll("input[type='number']").forEach(el => el.value = 0);
    hraContainer.querySelector("input[value='metro']").checked = true;

    calculateHRA();
  });

  calculateHRA();
});










// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// Gradutity Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
document.addEventListener("DOMContentLoaded", () => {
  const graContainer = document.querySelector(".gra-calculator");
  if (!graContainer) return;



  // Re-use INR formatting function
  function INR(v) {
    return "₹" + (Number(v) || 0).toLocaleString("en-IN", { minimumFractionDigits: 2 });
  }

  const basicInput = graContainer.querySelector("#basicGra");
  const daInput = graContainer.querySelector("#daGra");
  const yearsInput = graContainer.querySelector("#yearsGra");
  const coveredRadios = graContainer.querySelectorAll("input[name='coveredType']");
  const resetBtn = graContainer.querySelector("#resetBtnGra");

  // --- Core Calculation Function ---
  function calculateGratuity() {
    // 1. Get and VALIDATE all input values
    const getNonNegativeValue = (inputElement, defaultValue = 0) => {
      let value = Number(inputElement.value) || defaultValue;
      if (value < 0) {
        value = defaultValue;
        inputElement.value = defaultValue;
      }
      return value;
    };

    const basic = getNonNegativeValue(basicInput);
    const da = getNonNegativeValue(daInput);
    let years = getNonNegativeValue(yearsInput, 5); // Default to 5 years

    const coveredType = graContainer.querySelector("input[name='coveredType']:checked").value;


    if (years < 5) {
      years = 5;
      yearsInput.value = 5;
    }


    const lastDrawnSalary = basic + da;

    let multiplier;
    if (coveredType === 'covered') {
      // Covered under Act: 15 days' wages / 26 working days
      multiplier = 15 / 26;
    } else {
      // Not Covered under Act: Half a month's wages / 1 month (30 days approx)
      multiplier = 0.5;
    }

    // Gratuity = (Last Drawn Salary * Multiplier) * Years of Service
    const gratuityAmount = Math.floor(lastDrawnSalary * multiplier * years);


    // 2. Update the result display
    graContainer.querySelector("#outSalaryGra").textContent = INR(lastDrawnSalary);
    graContainer.querySelector("#outYearsGra").textContent = years;
    graContainer.querySelector("#outGratuity").textContent = INR(gratuityAmount);
  }
  // --- End Core Calculation Function ---




  graContainer.querySelectorAll("input[type='number']").forEach(input => {
    input.addEventListener("input", calculateGratuity);
    input.addEventListener("change", calculateGratuity);
  });


  coveredRadios.forEach(radio => {
    radio.addEventListener("change", calculateGratuity);
  });


  resetBtn?.addEventListener("click", () => {
    // Reset input values to initial defaults
    basicInput.value = 0;
    daInput.value = 0;
    yearsInput.value = 5;
    graContainer.querySelector("input[value='covered']").checked = true;

    calculateGratuity();
  });

  // Initial calculation to display "0" results when the page loads
  calculateGratuity();
});










// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// PF and ESI Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
document.addEventListener("DOMContentLoaded", () => {

  const container = document.querySelector(".pf-esi");
  if (!container) return; // <-- prevents script crash if not on page


  const basicField = container.querySelector("#pf-esi-basic-salary");
  const hraField = container.querySelector("#pf-esi-hra");
  const allowanceField = container.querySelector("#pf-esi-allowances");
  const empPfField = container.querySelector("#pf-esi-emp-pf");
  const emprPfField = container.querySelector("#pf-esi-empr-pf");
  const empEsiField = container.querySelector("#pf-esi-emp-esi");
  const emprEsiField = container.querySelector("#pf-esi-empr-esi");
  const grossField = container.querySelector("#pf-esi-gross");

  const empPfResult = container.querySelector("#pf-esi-emp-pf-result");
  const emprPfResult = container.querySelector("#pf-esi-empr-pf-result");
  const empEsiResult = container.querySelector("#pf-esi-emp-esi-result");
  const emprEsiResult = container.querySelector("#pf-esi-empr-esi-result");
  const totalDeductionField = container.querySelector("#pf-esi-total-emp-deduction");

  function calculate() {
    const basic = parseFloat(basicField.value) || 0;
    const hra = parseFloat(hraField.value) || 0;
    const other = parseFloat(allowanceField.value) || 0;

    const empPfRate = parseFloat(empPfField.value) || 0;
    const emprPfRate = parseFloat(emprPfField.value) || 0;
    const empEsiRate = parseFloat(empEsiField.value) || 0;
    const emprEsiRate = parseFloat(emprEsiField.value) || 0;

    const gross = basic + hra + other;
    grossField.value = gross.toFixed(2);

    const empPfValue = (basic * empPfRate) / 100;
    const emprPfValue = (basic * emprPfRate) / 100;
    const empEsiValue = (gross * empEsiRate) / 100;
    const emprEsiValue = (gross * emprEsiRate) / 100;

    empPfResult.textContent = empPfValue.toFixed(2);
    emprPfResult.textContent = emprPfValue.toFixed(2);
    empEsiResult.textContent = empEsiValue.toFixed(2);
    emprEsiResult.textContent = emprEsiValue.toFixed(2);

    totalDeductionField.textContent = (empPfValue + empEsiValue).toFixed(2);
  }

  // Attach event listeners only inside container
  container.querySelectorAll("input").forEach(input => {
    input.addEventListener("input", calculate);
  });

  // RESET BUTTON
  const resetBtn = container.querySelector(".pf-esi__button");

  if (resetBtn) {
    resetBtn.addEventListener("click", () => {
      // Clear all input fields inside this calculator only
      container.querySelectorAll("input").forEach(input => input.value = "");

      // Reset result fields
      empPfResult.textContent = "0";
      emprPfResult.textContent = "0";
      empEsiResult.textContent = "0";
      emprEsiResult.textContent = "0";
      totalDeductionField.textContent = "0";
      grossField.value = "0";

      // Recalculate after clearing
      calculate();
    });
  }


  calculate();
});











// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// Salary SLip Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
document.addEventListener("DOMContentLoaded", () => {

  const payslipContainer = document.querySelector(".payslip"); // or whatever wrapper your shortcode outputs
  if (!payslipContainer) return;



  // ------- FIELD MAP -------
  const f = {
    logo: document.getElementById("payslip-logo"),
    logoPreview: document.getElementById("payslip-logo-preview"),

    companyName: document.getElementById("payslip-company-name"),
    companyAddress: document.getElementById("payslip-company-address"),
    companyLocation: document.getElementById("payslip-company-location"),

    empName: document.getElementById("payslip-emp-name"),
    empId: document.getElementById("payslip-emp-id"),
    payPeriod: document.getElementById("payslip-period"),
    paidDays: document.getElementById("payslip-paid-days"),
    lossDays: document.getElementById("payslip-loss-days"),
    payDate: document.getElementById("payslip-date"),

    basic: document.getElementById("payslip-basic"),
    hra: document.getElementById("payslip-hra"),
    tax: document.getElementById("payslip-tax"),
    pf: document.getElementById("payslip-pf"),

    gross: document.getElementById("payslip-gross"),
    totalDeduction: document.getElementById("payslip-total-deduction"),
    net: document.getElementById("payslip-net"),
    words: document.getElementById("payslip-words")
  };

  setDefaultMonth();



  function validateFields() {
    clearErrors(); // remove all previous messages

    const required = [
      f.companyName,
      f.companyAddress,
      f.empName,
      f.empId,
      f.payPeriod,
      f.payDate
    ];

    for (let input of required) {
      if (!input.value.trim()) {
        // Use name, placeholder, or id for error message
        const fieldName = input.name || input.placeholder || input.id.replace("payslip-", "");
        showError(input, `${fieldName} field is required`);
        input.focus();
        return false;
      }
    }

    // Special case: location (placeholder allowed)
    if (!f.companyLocation.value.trim() && !f.companyLocation.placeholder) {
      showError(f.companyLocation, "Please fill Company Location");
      f.companyLocation.focus();
      return false;
    }

    // Salary checks
    if (!f.basic.value.trim() || isNaN(f.basic.value) || Number(f.basic.value) <= 0) {
      showError(f.basic, "Basic Salary must be greater than 0");
      f.basic.focus();
      return false;
    }

    const optionalSalaryFields = [f.hra, f.tax, f.pf];
    for (let field of optionalSalaryFields) {
      if (field.value.trim() !== "" && isNaN(field.value)) {
        showError(field, "Must be a number");
        field.focus();
        return false;
      }
    }

    return true;
  }





  // ------- NUMBER → WORDS -------
  function numberToWords(num) {
    if (num < 0) return "Negative Amount";
    if (num === 0) return "Zero";

    const a = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];
    const b = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

    function convert(n) {
      if (n < 20) return a[n];
      if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
      if (n < 1000) return a[Math.floor(n / 100)] + " Hundred " + convert(n % 100);
      if (n < 100000) return convert(Math.floor(n / 1000)) + " Thousand " + convert(n % 1000);
      if (n < 10000000) return convert(Math.floor(n / 100000)) + " Lakh " + convert(n % 100000);
      return convert(Math.floor(n / 10000000)) + " Crore " + convert(n % 10000000);
    }

    return convert(num).trim() + " Only";
  }


  // ------- LIVE CALCULATION -------
  function calculate() {
    const basic = parseFloat(f.basic.value) || 0;
    const hra = parseFloat(f.hra.value) || 0;
    const tax = parseFloat(f.tax.value) || 0;
    const pf = parseFloat(f.pf.value) || 0;

    const gross = basic + hra;
    const deductions = tax + pf;
    const net = gross - deductions;

    f.gross.innerText = gross.toFixed(2);
    f.totalDeduction.innerText = deductions.toFixed(2);
    f.net.innerText = net.toFixed(2);
    f.words.innerText = numberToWords(Math.round(net));


    clearError(f.net);



    if (net < 0) {
      f.net.classList.add("payslip-net-negative");
    } else {
      f.net.classList.remove("payslip-net-negative");
    }

  }




  ["basic", "hra", "tax", "pf"].forEach(id => {
    document.getElementById(`payslip-${id}`).addEventListener("input", calculate);
  });


  // ------- LOGO PREVIEW -------
  f.logo.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (ev) => {
      f.logoPreview.src = ev.target.result;
      f.logoPreview.style.display = "block";
    };
    reader.readAsDataURL(file);
  });


  // ------- UPDATE MONTH -------
  function updatePayslipMonth() {
    const value = f.payPeriod.value;
    if (!value) return;
    const date = new Date(value + "-01");
    const formatted = date.toLocaleDateString("en-US", { month: "long", year: "numeric" });

    document.getElementById("payslip-month").innerText = formatted;
    document.getElementById("print-month").innerText = formatted;
  }

  f.payPeriod.addEventListener("change", updatePayslipMonth);



  function setDefaultMonth() {
    const today = new Date();

    // Format for visible display (print + UI)
    const formatted = today.toLocaleDateString("en-US", {
      month: "long",
      year: "numeric"
    });

    // Format for input field (YYYY-MM) — required format for `<input type="month">`
    const formattedInput = today.toISOString().slice(0, 7);

    f.payPeriod.value = formattedInput;
    document.getElementById("payslip-month").innerText = formatted;
    document.getElementById("print-month").innerText = formatted;
  }


  // -------- Reset Form (use instead of location.reload) ----------
  function resetForm() {
    // Clear text inputs
    f.companyName.value = "";
    f.companyAddress.value = "";
    f.companyLocation.value = "";
    f.empName.value = "";
    f.empId.value = "";
    f.paidDays.value = "30";
    f.lossDays.value = "0";
    f.payDate.value = "";
    f.basic.value = "0";
    f.hra.value = "0";
    f.tax.value = "0";
    f.pf.value = "0";

    // Hide logo preview
    f.logoPreview.src = "";
    f.logoPreview.style.display = "none";
    f.logo.value = ""; // clear file input

    // Reset month display
    setDefaultMonth();

    f.gross.innerText = "0.00";
    f.totalDeduction.innerText = "0.00";
    f.net.innerText = "0.00";
    f.words.innerText = "---";


    // Clear print template fields (optional, for safety)
    const printIds = [
      "print-name", "print-id", "print-period", "print-paid", "print-loss", "print-date",
      "print-company-name", "print-company-address", "print-company-location",
      "print-basic", "print-hra", "print-tax", "print-pf", "print-gross", "print-deduct",
      "print-net", "print-words"
    ];
    printIds.forEach(id => {
      const el = document.getElementById(id);
      if (el) el.innerText = "";
    });

    // Remove red error for negative salary
    f.net.classList.remove("payslip-net-negative");
    // Recalculate to update UI
    calculate();

    clearErrors();
    // Close popup if open
    const popup = document.querySelector(".payslip-popup");
    if (popup) popup.style.display = "none";
  }

  // --------- Error Toast (bottom) ----------
  // Show error below a specific input
  function showError(input, message) {
    // Remove any previous error for this input
    clearError(input);

    // Create error element
    const errorEl = document.createElement("div");
    errorEl.className = "payslip-input-error";
    errorEl.style.color = "red";
    errorEl.style.fontSize = "13px";
    errorEl.style.marginTop = "3px";
    errorEl.innerText = message;

    // Insert after the input
    input.insertAdjacentElement("afterend", errorEl);
  }

  // Show error below any element (works for div/span like net salary)
  function showErrorForDisplay(el, message) {
    // Remove previous error if exists
    const next = el.nextElementSibling;
    if (next && next.classList.contains("payslip-input-error")) next.remove();

    const errorEl = document.createElement("div");
    errorEl.className = "payslip-input-error";
    errorEl.style.color = "red";
    errorEl.style.fontSize = "13px";
    errorEl.style.fontWeight = "13px";
    errorEl.style.marginTop = "3px";
    errorEl.innerText = message;

    el.appendChild(errorEl);
  }


  // Clear error for a specific input
  function clearError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("payslip-input-error")) {
      next.remove();
    }
  }

  // Clear all errors
  function clearErrors() {
    document.querySelectorAll(".payslip-input-error").forEach(el => el.remove());
  }


  // ------- PDF DOWNLOAD -------
  function downloadPDF() {
    // Validate (optional: remove if not required)
    if (!f.empName.value.trim() || !f.payPeriod.value.trim() ||
      !f.companyName.value.trim()) {
      showError("Please fill required fields (*) before generating payslip.");
      return;
    }

    // Fill print template
    document.getElementById("print-name").innerText = f.empName.value || "-";
    document.getElementById("print-id").innerText = f.empId.value || "-";
    document.getElementById("print-period").innerText = document.getElementById("payslip-month").innerText;
    document.getElementById("print-paid").innerText = f.paidDays.value || "-";
    document.getElementById("print-loss").innerText = f.lossDays.value || "-";
    document.getElementById("print-date").innerText = f.payDate.value || "-";

    document.getElementById("print-company-name").innerText = f.companyName.value || "-";
    document.getElementById("print-company-address").innerText = f.companyAddress.value || "-";
    document.getElementById("print-company-location").innerText = f.companyLocation.value || f.companyLocation.placeholder || "-";


    document.getElementById("print-basic").innerText = f.basic.value || "0.00";
    document.getElementById("print-hra").innerText = f.hra.value || "0.00";
    document.getElementById("print-tax").innerText = f.tax.value || "0.00";
    document.getElementById("print-pf").innerText = f.pf.value || "0.00";
    document.getElementById("print-gross").innerText = f.gross.innerText;
    document.getElementById("print-deduct").innerText = f.totalDeduction.innerText;
    document.getElementById("print-net").innerText = f.net.innerText;
    document.getElementById("print-words").innerText = f.words.innerText;

    // Logo optional
    document.getElementById("print-logo").src = f.logoPreview.src || "";
    document.getElementById("print-logo").style.display = f.logoPreview.src ? "block" : "none";

    // ---- NEW FIX: Create print wrapper ----
    const printWrapper = document.createElement("div");
    const clone = document.getElementById("payslip-print").cloneNode(true);
    clone.style.display = "block";
    printWrapper.appendChild(clone);

    // Backup original page
    const originalContent = document.body.innerHTML;

    // Replace body with payslip only
    document.body.innerHTML = printWrapper.innerHTML;

    // Set PDF filename based on company name
    const originalTitle = document.title;
    document.title = (f.companyName.value.trim() || "Payslip") + " Payslip";
    // Print
    window.print();

    // Restore original title after print
    setTimeout(() => {
      document.title = originalTitle;
    }, 500);

    // Restore page
    document.body.innerHTML = originalContent;

    // Hide again after print preview is closed
    document.getElementById("payslip-print").style.display = "none";
  }

  function downloadCSV() {
    const rows = [
      ["Company Name", f.companyName.value],
      ["Company Address", f.companyAddress.value],
      ["Location", f.companyLocation.value],
      [],
      ["Employee Name", f.empName.value],
      ["Employee ID", f.empId.value],
      ["Pay Period", document.getElementById("payslip-month").innerText],
      ["Paid Days", f.paidDays.value],
      ["Loss of Pay Days", f.lossDays.value],
      ["Pay Date", f.payDate.value],
      [],
      ["Basic", f.basic.value],
      ["HRA", f.hra.value],
      ["Income Tax", f.tax.value],
      ["PF", f.pf.value],
      [],
      ["Gross Earnings", f.gross.innerText],
      ["Total Deductions", f.totalDeduction.innerText],
      ["Net Salary", f.net.innerText],
      ["Amount in words", f.words.innerText]
    ];

    const csvContent = rows.map(row => row.join(",")).join("\n");
    const blob = new Blob([csvContent], { type: "text/csv" });

    const a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = (f.empName.value || "payslip") + ".csv";
    a.click();
  }



  // ------- POPUP -------
  function showPopup() {
    if (!validateFields()) return;

    calculate();

    const net = parseFloat(f.net.innerText);

    if (net < 0) {
      showErrorForDisplay(f.net, "Cannot generate payslip: Net salary is negative.");
      return; // Stop popup and download
    }



    let popup = document.querySelector(".payslip-popup");

    if (!popup) {
      popup = document.createElement("div");
      popup.className = "payslip-popup";
      popup.innerHTML = `
                <div class="payslip-popup__box">
                    <span class="payslip-popup__title">Payslip Ready 🎉</span>
                    <button class="payslip-popup__close">✖</button>
                    <div class="payslip-popup__actions">
                        <button class="payslip__button--pdf btn">Download PDF</button>
                        <button class="payslip__button--excel btn">Download CSV</button>
                    </div>
                </div>
            `;
      document.body.appendChild(popup);
      popup.querySelector(".payslip-popup__close").onclick = () => popup.style.display = "none";
      popup.querySelector(".payslip__button--pdf").onclick = () => {
        downloadPDF();
        popup.style.display = "none";
        resetForm();
      };

      popup.querySelector(".payslip__button--excel").onclick = () => {
        downloadCSV();
        popup.style.display = "none";
        resetForm();
      };

    }

    popup.style.display = "flex";
  }

  // Set user's country as placeholder
  function setUserCountryPlaceholder() {
    const countryInput = document.getElementById("payslip-company-location");
    if (!countryInput) return;

    fetch("https://ipapi.co/json/")
      .then(res => res.json())
      .then(data => {
        if (data.country_name) {
          countryInput.placeholder = data.country_name; // show country as placeholder
        }
      })
      .catch(err => {
        console.log("Could not fetch country:", err);
      });
  }

  // Call this function after DOM loads
  setUserCountryPlaceholder();


  // ------- BUTTONS -------
  document.getElementById("payslip-generate").addEventListener("click", showPopup);
  document.getElementById("payslip-reset").addEventListener("click", resetForm);

});









// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
//  Freetools container scroll
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
document.addEventListener("DOMContentLoaded", function () {
    const button = document.getElementById("acf-scroll-btn");
    const target = document.getElementById("scroll-target");

    if (!button || !target) return;

    button.addEventListener("click", function (e) {
        e.preventDefault();

        console.log("Scroll button clicked");

        // Detect your sticky header height (you may change selector based on your site)
        const header = document.querySelector("header");
        const headerHeight = header ? header.offsetHeight : 0;

        // Calculate exact scroll with offset
        const elementPosition = target.getBoundingClientRect().top + window.scrollY;
        const offsetPosition = elementPosition - headerHeight - 80; // -20 for extra spacing

        window.scrollTo({
            top: offsetPosition,
            behavior: "smooth"
        });
    });
});







// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
//  Read More and read Less button
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
document.addEventListener('DOMContentLoaded', function() {
  // Get the button and remaining sections container
  const toggleBtn = document.querySelector('.free-tools-toggle-remaining');
  const remainingSections = document.querySelector('.free-tools-remaining-sections');

  // If either element doesn't exist, exit
  if (!toggleBtn || !remainingSections) return;

  // Click event for toggling
  toggleBtn.addEventListener('click', function() {
    if (remainingSections.style.display === 'none' || remainingSections.style.display === '') {
      remainingSections.style.display = 'block';
      toggleBtn.textContent = 'Read Less';
    } else {
      remainingSections.style.display = 'none';
      toggleBtn.textContent = 'Read More';
    }
  });
});


// ===============================
// ===============================
// Invoice Generator
// ===============================
// ===============================
document.addEventListener("DOMContentLoaded", () => {
  const invContainer = document.querySelector(".invoice-generator-wrapper");
  if (!invContainer) return;

  const itemsBody = document.getElementById("inv-items-body");
  const addBtn = document.getElementById("inv-add-item");
  const printBtn = document.getElementById("inv-print-btn");

  const subtotalEl = document.getElementById("inv-subtotal");
  const sgstTotalEl = document.getElementById("inv-sgst-total");
  const cgstTotalEl = document.getElementById("inv-cgst-total");
  const grandTotalEl = document.getElementById("inv-grand-total");

  function INR(val) {
    return Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  let subtotal = 0;
  let sgstTotal = 0;
  let cgstTotal = 0;
  let cessTotal = 0;

  function calculateTotals() {
    subtotal = 0;
    sgstTotal = 0;
    cgstTotal = 0;
    cessTotal = 0;

    const rows = itemsBody.querySelectorAll("tr");
    rows.forEach(row => {
      const qty = parseFloat(row.querySelector(".inv-qty").value) || 0;
      const rate = parseFloat(row.querySelector(".inv-rate").value) || 0;
      const sgstPct = parseFloat(row.querySelector(".inv-sgst").value) || 0;
      const cgstPct = parseFloat(row.querySelector(".inv-cgst").value) || 0;
      const cess = parseFloat(row.querySelector(".inv-cess").value) || 0;

      const amount = qty * rate;
      const sgstAmt = amount * (sgstPct / 100);
      const cgstAmt = amount * (cgstPct / 100);

      const rowTotal = amount + sgstAmt + cgstAmt + cess;
      row.querySelector(".inv-amount-txt").textContent = INR(rowTotal);

      subtotal += amount;
      sgstTotal += sgstAmt;
      cgstTotal += cgstAmt;
      cessTotal += cess;
    });

    const grandTotal = subtotal + sgstTotal + cgstTotal + cessTotal;
    
    subtotalEl.textContent = INR(subtotal);
    sgstTotalEl.textContent = INR(sgstTotal);
    cgstTotalEl.textContent = INR(cgstTotal);
    grandTotalEl.textContent = INR(grandTotal);
  }

  function addRow() {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td><input type="text" class="payslip__input inv-desc" placeholder="Item Name" style="text-align:center"></td>
      <td><input type="number" class="payslip__input inv-qty" value="1" min="1" style="text-align:center"></td>
      <td><input type="number" class="payslip__input inv-rate" value="0.00" min="0" step="0.01" style="text-align:center"></td>
      <td><input type="number" class="payslip__input inv-sgst" value="0" min="0" step="0.1" style="text-align:center"></td>
      <td><input type="number" class="payslip__input inv-cgst" value="0" min="0" step="0.1" style="text-align:center"></td>
      <td><input type="number" class="payslip__input inv-cess" value="0" min="0" step="0.01" style="text-align:center"></td>
      <td style="text-align:center; font-size:14px; color:#374151" class="inv-amount-txt">0.00</td>
      <td class="no-print"><button class="inv-btn-del inv-del" aria-label="Delete line item">×</button></td>
    `;
    
    itemsBody.appendChild(tr);

    // Event listeners
    tr.querySelectorAll("input").forEach(input => {
      input.addEventListener("input", calculateTotals);
    });
    tr.querySelector(".inv-del").addEventListener("click", () => {
      tr.remove();
      calculateTotals();
    });

    calculateTotals();
  }

  addBtn.addEventListener("click", addRow);
  
  const currencySelect = document.getElementById("inv-currency");
  if (currencySelect) {
    currencySelect.addEventListener("change", calculateTotals);
  }

  // Initialize with one row
  addRow();

  // Logo upload
  const logoInput = document.getElementById("inv-logo");
  const logoPreview = document.getElementById("inv-logo-preview");
  const logoText = document.getElementById("inv-logo-text");
  let logoDataURL = "";

  logoInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (ev) => {
        logoDataURL = ev.target.result;
        logoPreview.src = logoDataURL;
        logoPreview.style.display = "inline-block";
        logoText.style.display = "none";
        // Style the label box to fit the logo nicely
        const labelBox = document.getElementById("inv-logo-label-box");
        if (labelBox) {
          labelBox.style.border = "none";
          labelBox.style.padding = "0";
          labelBox.style.background = "transparent";
        }
        // Hide the "Upload Logo" text next to the box
        const uploadLogoSpan = labelBox ? labelBox.parentElement.querySelector('.payslip__upload-text.no-print') : null;
        if (uploadLogoSpan) uploadLogoSpan.style.display = "none";
      };
      reader.readAsDataURL(file);
    }
  });

  // -------------------------------------------------------
  // Build a full standalone HTML document for PDF printing
  // -------------------------------------------------------
  function buildPrintDocument() {
    const v = id => {
      const el = document.getElementById(id);
      return el ? el.value : "";
    };
    const t = id => {
      const el = document.getElementById(id);
      return el ? el.textContent : "";
    };

    const companyName   = v("inv-company-name");
    const companyPerson = v("inv-company-name-person");
    const companyEmail  = v("inv-company-email");
    const companyGST    = v("inv-company-gst");
    const companyAddr   = [v("inv-company-address"), v("inv-company-city"), v("inv-company-state"), v("inv-company-country")].filter(Boolean).join(", ");

    const clientCompany = v("inv-client-company");
    const clientEmail   = v("inv-client-email");
    const clientGST     = v("inv-client-gst");
    const clientAddr    = [v("inv-client-address"), v("inv-client-city"), v("inv-client-state"), v("inv-client-country")].filter(Boolean).join(", ");

    const invNumber   = v("inv-number");
    const invDate     = v("inv-date") ? new Date(v("inv-date") + "T00:00:00").toLocaleDateString("en-IN") : "";
    const dueDate     = v("inv-due-date") ? new Date(v("inv-due-date") + "T00:00:00").toLocaleDateString("en-IN") : "";
    const placeSupply = v("inv-place-supply");
    const title       = v("inv-title") || "TAX INVOICE";
    const selectedCurrency = v("inv-currency") || "₹";

    const logoImg = logoDataURL
      ? '<img src="' + logoDataURL + '" style="max-height:70px; max-width:140px;">'
      : "";

    // Build item rows as plain text table rows
    let itemRows = "";
    const rows = itemsBody.querySelectorAll("tr");
    rows.forEach(row => {
      const desc = row.querySelector(".inv-desc").value;
      const qty  = row.querySelector(".inv-qty").value;
      const rate = parseFloat(row.querySelector(".inv-rate").value) || 0;
      const sgst = parseFloat(row.querySelector(".inv-sgst").value) || 0;
      const cgst = parseFloat(row.querySelector(".inv-cgst").value) || 0;
      const cess = parseFloat(row.querySelector(".inv-cess").value) || 0;
      const amt  = row.querySelector(".inv-amount-txt").textContent;

      itemRows +=
        '<tr>' +
          '<td class="td-center">' + desc + '</td>' +
          '<td class="td-center">' + qty + '</td>' +
          '<td class="td-center">' + INR(rate) + '</td>' +
          '<td class="td-center">' + sgst + '%</td>' +
          '<td class="td-center">' + cgst + '%</td>' +
          '<td class="td-center">' + INR(cess) + '</td>' +
          '<td class="td-center td-bold">' + amt + '</td>' +
        '</tr>';
    });

    const notes = v("inv-notes");
    const terms = v("inv-terms");

    // Return a FULL HTML document string
    return '<!DOCTYPE html>' +
    '<html><head><meta charset="utf-8">' +
    '<title>Invoice ' + invNumber + '</title>' +
    '<style>' +
      '* { margin:0; padding:0; box-sizing:border-box; }' +
      'body { font-family: Arial, Helvetica, sans-serif; color:#111827; padding:30px 40px; font-size:13px; }' +
      'table { border-collapse:collapse; }' +

      '.header { overflow:hidden; margin-bottom:35px; }' +
      '.header-logo { float:left; }' +
      '.header-logo img { display:block; }' +
      '.header-title { float:right; font-size:28px; font-weight:300; color:#111827; line-height:1.2; }' +

      '.info-row { overflow:hidden; margin-bottom:20px; }' +
      '.info-left { float:left; width:55%; }' +
      '.info-right { float:right; width:40%; }' +

      '.company-name { font-size:15px; font-weight:700; margin-bottom:3px; }' +
      '.text-sm { font-size:12px; color:#6b7280; margin-bottom:2px; }' +
      '.text-md { font-size:13px; color:#374151; margin-bottom:2px; }' +

      '.section-label { font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; margin-bottom:6px; padding-bottom:4px; border-bottom:1px solid #e5e7eb; }' +
      '.client-name { font-size:14px; font-weight:700; margin-bottom:3px; }' +

      '.meta-table { width:100%; font-size:12px; }' +
      '.meta-table td { padding:3px 0; }' +
      '.meta-label { font-weight:600; }' +
      '.meta-value { text-align:right; }' +

      '.items-table { width:100%; margin:25px 0 15px 0; table-layout:fixed; }' +
      '.items-table th { background:#111827; color:#fff; padding:8px 6px; font-size:10px; text-transform:uppercase; font-weight:600; word-wrap:break-word; overflow-wrap:break-word; text-align:center; }' +
      '.td-center { padding:8px 6px; border-bottom:1px solid #e5e7eb; text-align:center; word-wrap:break-word; overflow-wrap:break-word; }' +
      '.td-bold { font-weight:600; }' +

      '.totals-wrap { overflow:hidden; margin-bottom:25px; }' +
      '.totals-table { float:right; width:240px; font-size:13px; }' +
      '.totals-table td { padding:5px 4px; }' +
      '.totals-table .grand { background:#f3f4f6; font-weight:700; font-size:15px; }' +
      '.totals-table .grand td { padding:8px 6px; }' +

      '.footer-section { margin-bottom:12px; }' +
      '.footer-label { font-size:10px; font-weight:600; color:#6b7280; text-transform:uppercase; margin-bottom:3px; }' +
      '.footer-text { font-size:12px; color:#374151; white-space:pre-wrap; }' +

      '@page { size:A4; margin:10mm; }' +
      '@media print { body { padding:10px 20px; } }' +
    '</style>' +
    '</head><body>' +

    // Header
    '<div class="header">' +
      '<div class="header-logo">' + logoImg + '</div>' +
      '<div class="header-title">' + title + '</div>' +
    '</div>' +

    // Company Info + Invoice Meta
    '<div class="info-row">' +
      '<div class="info-left">' +
        '<div class="company-name">' + companyName + '</div>' +
        '<div class="text-md">' + companyPerson + '</div>' +
        (companyEmail ? '<div class="text-md">' + companyEmail + '</div>' : '') +
        (companyGST ? '<div class="text-sm">GSTIN: ' + companyGST + '</div>' : '') +
        '<div class="text-sm">' + companyAddr + '</div>' +
      '</div>' +
      '<div class="info-right">' +
        '<table class="meta-table">' +
          '<tr><td class="meta-label">Invoice#</td><td class="meta-value">' + invNumber + '</td></tr>' +
          '<tr><td class="meta-label">Invoice Date</td><td class="meta-value">' + invDate + '</td></tr>' +
          '<tr><td class="meta-label">Due Date</td><td class="meta-value">' + dueDate + '</td></tr>' +
        '</table>' +
      '</div>' +
    '</div>' +

    // Bill To
    '<div class="info-row">' +
      '<div class="info-left">' +
        '<div class="section-label">Bill To</div>' +
        '<div class="client-name">' + clientCompany + '</div>' +
        (clientEmail ? '<div class="text-md">' + clientEmail + '</div>' : '') +
        (clientGST ? '<div class="text-sm">GSTIN: ' + clientGST + '</div>' : '') +
        '<div class="text-sm">' + clientAddr + '</div>' +
        (placeSupply ? '<div class="text-sm"><span class="meta-label">Place of Supply: </span>' + placeSupply + '</div>' : '') +
      '</div>' +
      '<div class="info-right">' +
      '</div>' +
    '</div>' +

    // Items Table
    '<table class="items-table">' +
      '<colgroup>' +
        '<col style="width:30%">' +
        '<col style="width:8%">' +
        '<col style="width:14%">' +
        '<col style="width:12%">' +
        '<col style="width:12%">' +
        '<col style="width:10%">' +
        '<col style="width:14%">' +
      '</colgroup>' +
      '<thead><tr>' +
        '<th>Item Description</th>' +
        '<th>Qty</th>' +
        '<th>Rate</th>' +
        '<th>SGST(%)</th>' +
        '<th>CGST(%)</th>' +
        '<th>Cess</th>' +
        '<th>Amount</th>' +
      '</tr></thead>' +
      '<tbody>' + itemRows + '</tbody>' +
    '</table>' +

    '<div class="totals-wrap">' +
      '<table class="totals-table">' +
        '<tr><td>Sub Total</td><td style="text-align:right;">' + t("inv-subtotal") + '</td></tr>' +
        '<tr><td>SGST</td><td style="text-align:right;">' + t("inv-sgst-total") + '</td></tr>' +
        '<tr><td>CGST</td><td style="text-align:right;">' + t("inv-cgst-total") + '</td></tr>' +
        '<tr class="grand"><td>Total</td><td style="text-align:right;">' + selectedCurrency + ' ' + t("inv-grand-total") + '</td></tr>' +
      '</table>' +
    '</div>' +

    // Notes & Terms
    (notes ? '<div class="footer-section"><div class="footer-label">Notes</div><div class="footer-text">' + notes + '</div></div>' : '') +
    (terms ? '<div class="footer-section"><div class="footer-label">Terms & Conditions</div><div class="footer-text">' + terms + '</div></div>' : '') +

    '</body></html>';
  }

  // -------------------------------------------------------
  // Download / Print Invoice
  // Opens a new window with the rendered invoice and
  // triggers the browser's native print dialog.
  // User can select "Save as PDF" from the print dialog.
  // -------------------------------------------------------
  printBtn.addEventListener("click", () => {
    // Collect line items
    const lineItems = [];
    itemsBody.querySelectorAll("tr").forEach(row => {
      lineItems.push({
        description: row.querySelector(".inv-desc").value,
        qty: row.querySelector(".inv-qty").value,
        rate: row.querySelector(".inv-rate").value,
        sgst: row.querySelector(".inv-sgst").value,
        cgst: row.querySelector(".inv-cgst").value,
        cess: row.querySelector(".inv-cess").value,
        amount: row.querySelector(".inv-amount-txt").textContent
      });
    });

    const v = id => {
      const el = document.getElementById(id);
      return el ? el.value : "";
    };

    const formData = new URLSearchParams();
    formData.append("action", "save_generated_invoice");
    formData.append("user_company_name", v("inv-company-name"));
    formData.append("user_person_name", v("inv-company-name-person"));
    formData.append("user_email", v("inv-company-email"));
    formData.append("user_gstin", v("inv-company-gst"));
    formData.append("user_address", v("inv-company-address"));
    formData.append("user_city", v("inv-company-city"));
    formData.append("user_state", v("inv-company-state"));
    formData.append("user_country", v("inv-company-country"));
    
    formData.append("client_company_name", v("inv-client-company"));
    formData.append("client_email", v("inv-client-email"));
    formData.append("client_gstin", v("inv-client-gst"));
    formData.append("client_address", v("inv-client-address"));
    formData.append("client_city", v("inv-client-city"));
    formData.append("client_state", v("inv-client-state"));
    formData.append("client_country", v("inv-client-country"));
    
    formData.append("invoice_number", v("inv-number"));
    formData.append("invoice_date", v("inv-date"));
    formData.append("due_date", v("inv-due-date"));
    formData.append("place_of_supply", v("inv-place-supply"));
    
    formData.append("currency", v("inv-currency") || "₹");
    formData.append("subtotal", subtotal.toString());
    formData.append("sgst_total", sgstTotal.toString());
    formData.append("cgst_total", cgstTotal.toString());
    formData.append("grand_total", (subtotal + sgstTotal + cgstTotal + cessTotal).toString());
    formData.append("notes", v("inv-notes"));
    formData.append("terms", v("inv-terms"));

    lineItems.forEach((item, index) => {
       for (const key in item) {
          formData.append(`line_items[${index}][${key}]`, item[key]);
       }
    });

    const docHtml = buildPrintDocument();
    const invNum = v("inv-number") || "Draft";
    const fileName = "Invoice_" + invNum + ".pdf";

    // Open in a new tab (not a popup window)
    const printWindow = window.open("", "_blank");

    if (!printWindow) {
      alert("Please allow popups for this site to download your invoice.");
      return;
    }

    // Inject html2pdf CDN script into the generated HTML (before </head>)
    const html2pdfScript = '<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"><\/script>';
    
    // Add auto-download script that runs after page loads
    const autoDownloadScript = `
      <script>
        window.addEventListener("load", function() {
          setTimeout(function() {
            var opt = {
              margin: [10, 10, 10, 10],
              filename: "${fileName}",
              image: { type: "jpeg", quality: 0.98 },
              html2canvas: { scale: 2, useCORS: true, logging: false },
              jsPDF: { unit: "mm", format: "a4", orientation: "portrait" }
            };
            html2pdf().set(opt).from(document.body).save();
          }, 500);
        });
      <\/script>
    `;

    // Insert the scripts before </head>
    const modifiedHtml = docHtml.replace('</head>', html2pdfScript + '</head>').replace('</body>', autoDownloadScript + '</body>');

    printWindow.document.open();
    printWindow.document.write(modifiedHtml);
    printWindow.document.close();

    // Send data silently in background
    if (typeof freetools_ajax_url !== 'undefined') {
       fetch(freetools_ajax_url, {
         method: "POST",
         body: formData,
         headers: {
           'Content-Type': 'application/x-www-form-urlencoded'
         }
       }).catch(err => console.error("Error saving invoice:", err));
    }
  });
});
