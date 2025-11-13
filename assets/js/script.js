// Smart Archival & Information System - Modern JavaScript

document.addEventListener("DOMContentLoaded", function () {
  // Initialize all components
  initializeAnimations();
  initializeFormValidation();
  initializeFileUploads();
  initializeAlerts();
  initializeButtons();
  initializeTables();
  initializeThemeToggle();
  initializeScrollEffects();
  initializeNavToggle();
  initializeHeaderAutoHide();
  initializeViewToggle();

  // Form validation with modern feedback
  function initializeFormValidation() {
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
      form.addEventListener("submit", function (e) {
      // Skip validation for delete forms (we don't want to block them)
      const action = form.querySelector('input[name="action"]');
      if (action && action.value === "delete") {
        return true; // allow delete form to submit immediately
      }

      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

        requiredFields.forEach((field) => {
          if (!field.value.trim()) {
            isValid = false;
            field.style.borderColor = "var(--error)";
            field.style.boxShadow = "0 0 0 3px rgba(239, 68, 68, 0.1)";
            animateShake(field);
          } else {
            field.style.borderColor = "var(--success)";
            field.style.boxShadow = "0 0 0 3px rgba(16, 185, 129, 0.1)";
          }
        });

        if (!isValid) {
          e.preventDefault();
          showNotification("Please fill in all required fields.", "error");
        }
      });

      // Real-time validation
      const inputs = form.querySelectorAll("input, select, textarea");
      inputs.forEach((input) => {
        input.addEventListener("blur", function () {
          if (this.hasAttribute("required") && !this.value.trim()) {
            this.style.borderColor = "var(--error)";
            animateShake(this);
          } else if (this.value.trim()) {
            this.style.borderColor = "var(--success)";
          }
        });
      });
    });
  }

  // File upload with modern preview
  function initializeFileUploads() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach((input) => {
      input.addEventListener("change", function () {
        const label = this.parentNode.querySelector(".file-upload-label");
        if (this.files.length > 0) {
          const file = this.files[0];
          const fileSize = (file.size / 1024 / 1024).toFixed(2);
          label.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
              <span>📎</span>
              <div>
                <div style="font-weight: 600;">${file.name}</div>
                <div style="font-size: 0.8rem; opacity: 0.7;">${fileSize} MB</div>
              </div>
            </div>
          `;
          label.style.color = "var(--success)";
          label.style.borderColor = "var(--success)";
          animateSuccess(label);
        } else {
          label.innerHTML = "Choose file or drag and drop";
          label.style.color = "var(--text-secondary)";
          label.style.borderColor = "var(--border)";
        }
      });
    });
  }

  // Auto-hide alerts with animation
  function initializeAlerts() {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
      // Add close button
      const closeBtn = document.createElement("button");
      closeBtn.innerHTML = "×";
      closeBtn.style.cssText = `
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
      `;
      closeBtn.addEventListener("click", () => {
        animateFadeOut(alert);
      });
      alert.style.position = "relative";
      alert.appendChild(closeBtn);

      // Auto-hide after 5 seconds
      setTimeout(() => {
        if (alert.parentNode) {
          animateFadeOut(alert);
        }
      }, 5000);
    });
  }

  // Enhanced button interactions
  function initializeButtons() {
    const buttons = document.querySelectorAll(".btn");
    buttons.forEach((button) => {
      button.addEventListener("mouseenter", function () {
        this.style.transform = "translateY(-2px)";
      });

      button.addEventListener("mouseleave", function () {
        this.style.transform = "";
      });

      button.addEventListener("click", function (e) {
        // Ripple effect
        const ripple = document.createElement("span");
        ripple.style.cssText = `
          position: absolute;
          border-radius: 50%;
          background: rgba(255, 255, 255, 0.3);
          transform: scale(0);
          animation: ripple 0.6s linear;
          pointer-events: none;
        `;

        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + "px";
        ripple.style.left = e.clientX - rect.left - size / 2 + "px";
        ripple.style.top = e.clientY - rect.top - size / 2 + "px";

        this.style.position = "relative";
        this.style.overflow = "hidden";
        this.appendChild(ripple);

        setTimeout(() => ripple.remove(), 600);
      });
    });

    // Confirm delete actions with modern modal
  const deleteButtons = document.querySelectorAll("form .btn-danger");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const form = this.closest("form");
      if (!form) return;
    
           showConfirmModal(
        "Are you sure you want to delete this record? This cannot be undone.",
        () => form.submit()
      );
          });
        });
      }

  // Enhanced table functionality
  function initializeTables() {
    // Data table search with debouncing
    const searchInputs = document.querySelectorAll(".table-search");
    searchInputs.forEach((input) => {
      let timeout;
      input.addEventListener("input", function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
          const filter = this.value.toLowerCase();
          const table =
            this.closest(".content-card").querySelector(".data-table");
          const rows = table.querySelectorAll("tbody tr");

          rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            if (text.includes(filter)) {
              animateFadeIn(row);
              row.style.display = "";
            } else {
              row.style.display = "none";
            }
          });
        }, 300);
      });
    });

    // Table sorting
    const sortableHeaders = document.querySelectorAll(
      ".data-table th[data-sort]"
    );
    sortableHeaders.forEach((header) => {
      header.style.cursor = "pointer";
      header.addEventListener("click", function () {
        const table = this.closest(".data-table");
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const index = Array.from(this.parentNode.children).indexOf(this);
        const isAscending = this.classList.contains("sort-asc");

        // Reset all headers
        sortableHeaders.forEach((h) =>
          h.classList.remove("sort-asc", "sort-desc")
        );

        rows.sort((a, b) => {
          const aVal = a.children[index].textContent.trim();
          const bVal = b.children[index].textContent.trim();

          if (isAscending) {
            this.classList.add("sort-desc");
            return bVal.localeCompare(aVal);
          } else {
            this.classList.add("sort-asc");
            return aVal.localeCompare(bVal);
          }
        });

        rows.forEach((row) => tbody.appendChild(row));
        animateTableSort(table);
      });
    });
  }

  // Theme toggle (for pages without header toggle)
  function initializeThemeToggle() {
    const themeToggle = document.getElementById("themeToggle");
    if (!themeToggle) return;

    const themeIcon = document.getElementById("themeIcon");
    const body = document.body;

    // Determine initial theme: localStorage -> system preference -> default dark
    const saved = localStorage.getItem("theme");
    let isLight;
    if (saved === "light") isLight = true;
    else if (saved === "dark") isLight = false;
    else
      isLight =
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: light)").matches;

    if (isLight) {
      body.classList.add("light-theme");
    } else {
      body.classList.remove("light-theme");
    }

    // Update icon and aria state
    function updateThemeUI(isLightNow, announce) {
      if (themeIcon) {
        if (isLightNow) {
          themeIcon.innerHTML =
            '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        } else {
          themeIcon.innerHTML =
            '<path d="M12 3V4M12 20V21M4 12H3M6.34315 6.34315L5.63604 5.63604M17.6569 6.34315L18.364 5.63604M6.34315 17.6569L5.63604 18.364M17.6569 17.6569L18.364 18.364M21 12H20M16 12C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        }
      }

      // Accessible label
      themeToggle.setAttribute("aria-pressed", String(isLightNow));

      if (announce) {
        showNotification(
          `Switched to ${isLightNow ? "light" : "dark"} theme`,
          "info"
        );
      }
    }

    // Initial UI update (no announce)
    updateThemeUI(isLight, false);

    // Toggle handler
    themeToggle.addEventListener("click", () => {
      const nowLight = !document.body.classList.contains("light-theme");
      document.body.classList.toggle("light-theme");
      localStorage.setItem("theme", nowLight ? "light" : "dark");
      updateThemeUI(nowLight, true);
    });

    // React to system changes if user hasn't explicitly set a preference
    if (!saved && window.matchMedia) {
      const mq = window.matchMedia("(prefers-color-scheme: light)");
      mq.addEventListener &&
        mq.addEventListener("change", (e) => {
          const systemIsLight = e.matches;
          document.body.classList.toggle("light-theme", systemIsLight);
          updateThemeUI(systemIsLight, false);
        });
    }
  }

  // Scroll effects and animations
  function initializeScrollEffects() {
    const observerOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0)";
        }
      });
    }, observerOptions);

    // Observe cards and other elements
    document
      .querySelectorAll(".dashboard-card, .content-card")
      .forEach((card) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(30px)";
        card.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        observer.observe(card);
      });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
          target.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        }
      });
    });
  }

  // Initialize animations
  function initializeAnimations() {
    // Add CSS for animations
    const style = document.createElement("style");
    style.textContent = `
      @keyframes ripple {
        to {
          transform: scale(4);
          opacity: 0;
        }
      }

      @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
      }

      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }

      @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
      }

      @keyframes successPulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
      }

      @keyframes tableSort {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
      }

      /* Mobile viewport optimization */
      @supports (-webkit-touch-callout: none) {
        body {
          -webkit-text-size-adjust: 100%;
          -webkit-tap-highlight-color: transparent;
        }
      }

      /* Smooth scrolling */
      html {
        scroll-behavior: smooth;
      }
    `;
    document.head.appendChild(style);

    // Add viewport meta tag if missing
    if (!document.querySelector('meta[name="viewport"]')) {
      const viewport = document.createElement("meta");
      viewport.name = "viewport";
      viewport.content =
        "width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes";
      document.head.appendChild(viewport);
    }
  }
});

// Utility functions
function animateShake(element) {
  element.style.animation = "shake 0.5s ease";
  setTimeout(() => (element.style.animation = ""), 500);
}

// Header auto-hide on mobile: hide on scroll down, show on scroll up
function initializeHeaderAutoHide() {
  const header = document.querySelector(".header");
  if (!header) return;

  let lastY = window.scrollY || 0;
  let ticking = false;

  function onScroll() {
    const currentY = window.scrollY || 0;

    if (Math.abs(currentY - lastY) < 10) return; // small threshold

    if (currentY > lastY && currentY > 80) {
      // scrolling down
      header.classList.add("header-hidden");
    } else {
      // scrolling up
      header.classList.remove("header-hidden");
    }

    lastY = currentY;
    ticking = false;
  }

  window.addEventListener(
    "scroll",
    () => {
      if (!ticking) {
        window.requestAnimationFrame(onScroll);
        ticking = true;
      }
    },
    { passive: true }
  );

  // Ensure header is visible on resize to larger screens
  window.addEventListener("resize", () => {
    if (window.innerWidth > 768) {
      header.classList.remove("header-hidden");
      header.style.transform = "";
    }
  });
}

// Navigation toggle for mobile
function initializeNavToggle() {
  const navToggle = document.getElementById("navToggle");
  const navMenu = document.getElementById("navMenu");
  if (!navToggle || !navMenu) return;

  navToggle.addEventListener("click", () => {
    const expanded = navToggle.getAttribute("aria-expanded") === "true";
    navToggle.setAttribute("aria-expanded", String(!expanded));
    if (navMenu.hasAttribute("hidden")) {
      navMenu.removeAttribute("hidden");
    } else {
      navMenu.setAttribute("hidden", "");
    }
  });

  // Close menu on escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      navMenu.setAttribute("hidden", "");
      navToggle.setAttribute("aria-expanded", "false");
    }
  });

  // Close menu when clicking outside
  document.addEventListener("click", (e) => {
    if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
      navMenu.setAttribute("hidden", "");
      navToggle.setAttribute("aria-expanded", "false");
    }
  });

  // Handle window resize - show menu on desktop, hide on mobile
  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      if (window.innerWidth > 768) {
        navMenu.removeAttribute("hidden");
        navToggle.setAttribute("aria-expanded", "false");
      } else {
        navMenu.setAttribute("hidden", "");
        navToggle.setAttribute("aria-expanded", "false");
      }
    }, 250);
  });

  // Mobile dropdown toggle
  const dropdownTriggers = document.querySelectorAll(".dropdown-trigger");
  dropdownTriggers.forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        const navItem = trigger.closest(".nav-item");
        const dropdown = navItem.querySelector(".dropdown");

        // Toggle active class for arrow rotation
        navItem.classList.toggle("active");

        // Toggle dropdown visibility
        if (dropdown.style.display === "block") {
          dropdown.style.display = "none";
        } else {
          // Close other dropdowns
          document.querySelectorAll(".dropdown").forEach((d) => {
            d.style.display = "none";
          });
          document.querySelectorAll(".nav-item").forEach((item) => {
            if (item !== navItem) item.classList.remove("active");
          });
          dropdown.style.display = "block";
        }
      }
    });
  });
}

function animateFadeIn(element) {
  element.style.animation = "fadeIn 0.5s ease";
}

function animateFadeOut(element) {
  element.style.animation = "fadeOut 0.5s ease";
  setTimeout(() => element.remove(), 500);
}

function animateSuccess(element) {
  element.style.animation = "successPulse 1s ease";
}

function animateTableSort(table) {
  table.style.animation = "tableSort 0.3s ease";
  setTimeout(() => (table.style.animation = ""), 300);
}

function showNotification(message, type = "info") {
  const notification = document.createElement("div");
  notification.className = `alert alert-${type}`;
  notification.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    max-width: 300px;
    animation: slideInRight 0.5s ease;
  `;
  notification.innerHTML = `
    <div style="display: flex; align-items: center; gap: 10px;">
      <span>${getIcon(type)}</span>
      <span>${message}</span>
    </div>
  `;

  document.body.appendChild(notification);

  setTimeout(() => {
    animateFadeOut(notification);
  }, 3000);
}

function showConfirmModal(message, onConfirm) {
  const modal = document.createElement("div");
  modal.classList.add("modal-overlay");
  modal.style.cssText = `
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    animation: fadeIn 0.3s ease;
  `;

  modal.innerHTML = `
    <div style="
      background: var(--bg-card);
      border-radius: var(--radius-lg);
      padding: var(--spacing-2xl);
      box-shadow: var(--glass-shadow);
      max-width: 400px;
      text-align: center;
    ">
      <h3 style="margin-bottom: var(--spacing-lg); color: var(--text-primary);">Confirm Action</h3>
      <p style="margin-bottom: var(--spacing-xl); color: var(--text-secondary);">${message}</p>
      <div style="display: flex; gap: var(--spacing-md); justify-content: center;">
        <button id="cancelBtn" class="btn btn-secondary">Cancel</button>
        <button id="confirmBtn" class="btn btn-danger">Delete</button>
      </div>
    </div>
  `;

  document.body.appendChild(modal);

  modal.querySelector("#cancelBtn").addEventListener("click", () => modal.remove());
  modal.querySelector("#confirmBtn").addEventListener("click", () => {
    modal.remove();
    if (typeof onConfirm === "function") onConfirm();
  });
}

function getIcon(type) {
  const icons = {
    success: "✅",
    error: "❌",
    warning: "⚠️",
    info: "ℹ️",
  };
  return icons[type] || icons.info;
}

// Export table to CSV (enhanced)
function exportTableToCSV(table, filename) {
  const csv = [];
  const rows = table.querySelectorAll("tr");

  rows.forEach((row) => {
    const cols = row.querySelectorAll("td, th");
    const rowData = [];
    cols.forEach((col) => {
      rowData.push('"' + col.textContent.replace(/"/g, '""') + '"');
    });
    csv.push(rowData.join(","));
  });

  const csvContent = csv.join("\n");
  const blob = new Blob([csvContent], { type: "text/csv" });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = filename;
  a.click();
  window.URL.revokeObjectURL(url);

  showNotification("CSV exported successfully!", "success");
}

// Form auto-save functionality (enhanced)
function autoSave(formId) {
  const form = document.getElementById(formId);
  if (!form) return;

  const inputs = form.querySelectorAll("input, select, textarea");
  inputs.forEach((input) => {
    input.addEventListener("input", function () {
      const formData = new FormData(form);
      localStorage.setItem(
        formId + "_autosave",
        JSON.stringify(Object.fromEntries(formData))
      );
      // Show auto-save indicator
      showAutoSaveIndicator();
    });
  });

  // Restore saved data
  const savedData = localStorage.getItem(formId + "_autosave");
  if (savedData) {
    const data = JSON.parse(savedData);
    Object.keys(data).forEach((key) => {
      const input = form.querySelector(`[name="${key}"]`);
      if (input) {
        input.value = data[key];
      }
    });
    showNotification("Draft restored from auto-save", "info");
  }
}

function showAutoSaveIndicator() {
  let indicator = document.getElementById("autosave-indicator");
  if (!indicator) {
    indicator = document.createElement("div");
    indicator.id = "autosave-indicator";
    indicator.style.cssText = `
      position: fixed;
      bottom: 20px;
      left: 20px;
      background: var(--success);
      color: white;
      padding: 8px 16px;
      border-radius: var(--radius-md);
      font-size: 0.9rem;
      animation: fadeIn 0.3s ease;
      z-index: 1000;
    `;
    document.body.appendChild(indicator);
  }

  indicator.textContent = "💾 Auto-saved";
  clearTimeout(indicator.timeout);
  indicator.timeout = setTimeout(() => {
    animateFadeOut(indicator);
  }, 2000);
}

// Clear auto-save data on successful form submission
function clearAutoSave(formId) {
  localStorage.removeItem(formId + "_autosave");
  showNotification("Form submitted successfully!", "success");
}

// View toggle: switch between mobile and desktop view manually
function initializeViewToggle() {
  // Support both header toggle and navigation toggle
  const viewToggle = document.getElementById("viewToggle");
  const viewToggleNav = document.getElementById("viewToggleNav");

  if (!viewToggle && !viewToggleNav) return;

  const viewIcon = document.getElementById("viewIcon");
  const viewIconNav = document.getElementById("viewIconNav");
  const viewLabel = document.getElementById("viewLabel");
  const body = document.body;

  // Check for saved view preference
  const savedView = localStorage.getItem("viewMode");
  let currentView = savedView || "auto";

  // Mobile icon SVG
  const mobileIcon = `<rect x="7" y="4" width="10" height="16" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
    <line x1="12" y1="18" x2="12" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>`;

  // Desktop icon SVG
  const desktopIcon = `<rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
    <line x1="2" y1="17" x2="22" y2="17" stroke="currentColor" stroke-width="2"/>`;

  function applyView(view) {
    body.classList.remove("force-mobile-view", "force-desktop-view");

    if (view === "mobile") {
      body.classList.add("force-mobile-view");
      if (viewIcon) viewIcon.innerHTML = mobileIcon;
      if (viewIconNav) viewIconNav.innerHTML = mobileIcon;
      if (viewLabel) viewLabel.textContent = "Mobile";
      if (viewToggle)
        viewToggle.setAttribute(
          "title",
          "Currently: Mobile View (click for Auto)"
        );
      if (viewToggleNav)
        viewToggleNav.setAttribute(
          "title",
          "Currently: Mobile View (click for Auto)"
        );
    } else if (view === "desktop") {
      body.classList.add("force-desktop-view");
      if (viewIcon) viewIcon.innerHTML = desktopIcon;
      if (viewIconNav) viewIconNav.innerHTML = desktopIcon;
      if (viewLabel) viewLabel.textContent = "Desktop";
      if (viewToggle)
        viewToggle.setAttribute(
          "title",
          "Currently: Desktop View (click for Mobile)"
        );
      if (viewToggleNav)
        viewToggleNav.setAttribute(
          "title",
          "Currently: Desktop View (click for Mobile)"
        );
    } else {
      // auto mode
      if (viewIcon) viewIcon.innerHTML = desktopIcon;
      if (viewIconNav) viewIconNav.innerHTML = desktopIcon;
      if (viewLabel) viewLabel.textContent = "Auto";
      if (viewToggle)
        viewToggle.setAttribute("title", "Currently: Auto (click for Desktop)");
      if (viewToggleNav)
        viewToggleNav.setAttribute("title", "Currently: Auto (Responsive)");
    }
  }

  // Apply initial view
  applyView(currentView);

  // Toggle handler function
  function handleToggle() {
    if (currentView === "auto") {
      currentView = "desktop";
    } else if (currentView === "desktop") {
      currentView = "mobile";
    } else {
      currentView = "auto";
    }

    localStorage.setItem("viewMode", currentView);
    applyView(currentView);

    const modeLabel =
      currentView === "auto"
        ? "Auto (responsive)"
        : currentView === "desktop"
        ? "Desktop"
        : "Mobile";
    showNotification(`View mode: ${modeLabel}`, "info");
  }

  // Attach click handlers to both toggles
  if (viewToggle) {
    viewToggle.addEventListener("click", handleToggle);
  }
  if (viewToggleNav) {
    viewToggleNav.addEventListener("click", handleToggle);
  }
}


console.log("Smart Archival System JS loaded ✅");
