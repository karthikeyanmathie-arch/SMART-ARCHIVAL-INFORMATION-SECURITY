// Smart Archival & Information System JavaScript

document.addEventListener("DOMContentLoaded", function () {
  // Form validation
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false;
          field.style.borderColor = "#dc3545";
        } else {
          field.style.borderColor = "#e1e5e9";
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert("Please fill in all required fields.");
      }
    });
  });

  // File upload preview
  const fileInputs = document.querySelectorAll('input[type="file"]');
  fileInputs.forEach((input) => {
    input.addEventListener("change", function () {
      const label = this.parentNode.querySelector(".file-upload-label");
      if (this.files.length > 0) {
        label.textContent = `Selected: ${this.files[0].name}`;
        label.style.color = "#28a745";
      } else {
        label.textContent = "Choose file or drag and drop";
        label.style.color = "#667eea";
      }
    });
  });

  // Auto-hide alerts
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach((alert) => {
    setTimeout(() => {
      alert.style.opacity = "0";
      setTimeout(() => {
        alert.remove();
      }, 300);
    }, 5000);
  });

  // Confirm delete actions
  const deleteButtons = document.querySelectorAll(".btn-danger");
  deleteButtons.forEach((button) => {
    if (button.textContent.toLowerCase().includes("delete")) {
      button.addEventListener("click", function (e) {
        if (!confirm("Are you sure you want to delete this record?")) {
          e.preventDefault();
        }
      });
    }
  });

  // Data table search functionality
  const searchInputs = document.querySelectorAll(".table-search");
  searchInputs.forEach((input) => {
    input.addEventListener("keyup", function () {
      const filter = this.value.toLowerCase();
      const table = this.closest(".content-card").querySelector(".data-table");
      const rows = table.querySelectorAll("tbody tr");

      rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
      });
    });
  });

  // Print functionality
  const printButtons = document.querySelectorAll(".print-btn");
  printButtons.forEach((button) => {
    button.addEventListener("click", function () {
      window.print();
    });
  });

  // Export functionality
  const exportButtons = document.querySelectorAll(".export-btn");
  exportButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const table = this.closest(".content-card").querySelector(".data-table");
      exportTableToCSV(table, "export.csv");
    });
  });
});

// Export table to CSV
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
}

// Form auto-save functionality
function autoSave(formId) {
  const form = document.getElementById(formId);
  if (!form) return;

  const inputs = form.querySelectorAll("input, select, textarea");
  inputs.forEach((input) => {
    input.addEventListener("change", function () {
      const formData = new FormData(form);
      localStorage.setItem(
        formId + "_autosave",
        JSON.stringify(Object.fromEntries(formData))
      );
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
  }
}

// Clear auto-save data on successful form submission
function clearAutoSave(formId) {
  localStorage.removeItem(formId + "_autosave");
}
