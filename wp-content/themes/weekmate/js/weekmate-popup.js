document.addEventListener("DOMContentLoaded", function () {

    var popup = document.getElementById("weekmate-popup-overlay");

    console.log("Hello Weekmate");

    // If popup doesn't exist → stop the script
    if (!popup) return;

    // Get page popup ID (hrms, taskhub, etc.)
    var popupID = popup.getAttribute("data-popup-id");

    // Cookie helper
    function getCookie(name) {
        let match = document.cookie.match(
            new RegExp("(^| )" + name + "=([^;]+)")
        );
        return match ? match[2] : null;
    }

    // ==============================
    // SUBMISSION LOGIC
    // ==============================

    // If form submitted once → never show again
    var submitted = getCookie("popup_submitted_" + popupID);

    if (submitted) {
        popup.style.display = "none";
        return;
    }

    // ==============================
    // TAB-SPECIFIC CLOSE LOGIC
    // ==============================

    // sessionStorage works per-tab
    // Close in one tab won't affect another tab
    var closed = sessionStorage.getItem("popup_closed");

    if (closed) {
        popup.style.display = "none";
        return;
    }

    // Show popup after 10 seconds
    setTimeout(() => {
        popup.style.display = "flex";
    }, 10000);

    // ==============================
    // MOBILE NUMBER VALIDATION
    // ==============================

    const field = document.getElementById("popup-form-number");

    if (field) {
        field.setAttribute("inputmode", "numeric");

        field.addEventListener("input", function () {

            // Allow only digits
            this.value = this.value.replace(/\D/g, "");

            // Limit to max 10 digits
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });
    }

    // ==============================
    // CLOSE ON ESC
    // ==============================

    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            if (popup.style.display === "flex") {

                popup.style.display = "none";

                // Hide only for current tab
                sessionStorage.setItem("popup_closed", "true");
            }
        }
    });

    // ==============================
    // CLOSE ON OUTSIDE CLICK
    // ==============================

    popup.addEventListener("click", function (event) {

        // Clicked on overlay background
        if (event.target === popup) {

            popup.style.display = "none";

            // Hide only for current tab
            sessionStorage.setItem("popup_closed", "true");
        }
    });

    // ==============================
    // PREVENT MULTIPLE SUBMISSIONS
    // ==============================

    let isProcessing = false;

    // Select ONLY popup submit button
    const popupSubmitBtn = document.querySelector(
        "#weekmate-popup-overlay .wpcf7-submit"
    );

    if (popupSubmitBtn) {

        popupSubmitBtn.addEventListener("click", function (event) {

            const btn = event.target.closest(".wpcf7-submit");

            if (!btn) return;

            // Prevent repeat clicks
            if (isProcessing) {
                event.preventDefault();
                return false;
            }

            // Lock button
            isProcessing = true;

        }, true);
    }

    // ==============================
    // CF7 EVENTS
    // ==============================

    // Disable button while submitting
    document.addEventListener("wpcf7submit", function (event) {

        const btn = event.target.querySelector(".wpcf7-submit");

        if (btn) {
            btn.disabled = true;
        }
    });

    // Mail failed → allow retry
    document.addEventListener("wpcf7mailfailed", function (event) {

        isProcessing = false;

        const btn = event.target.querySelector(".wpcf7-submit");

        if (btn) {
            btn.disabled = false;
        }
    });

    // Validation failed → allow retry
    document.addEventListener("wpcf7invalid", function (event) {

        setTimeout(() => {

            isProcessing = false;

            const btn = event.target.querySelector(".wpcf7-submit");

            if (btn) {

                btn.disabled = false;
                btn.style.opacity = "1";
                btn.style.cursor = "pointer";
            }

        }, 100);
    });

    // Successful submit
    document.addEventListener("wpcf7mailsent", function () {

        isProcessing = true;

        // Never show again for 1 year
        document.cookie =
            `popup_submitted_${popupID}=true; path=/; max-age=${365 * 24 * 60 * 60}`;

        // Hide popup
        popup.style.display = "none";

    }, false);

});