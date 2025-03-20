function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null; // Cookie not found
}

// Check if the admin is logged in by checking the 'admin_logged_in' cookie
if (getCookie("admin_logged_in")) {
  //   window.location.reload();
  // Avoid redirecting if already on the dashboard page
  if (window.location.pathname !== "/admin/pages/dashboard.html") {
    // Redirect to the dashboard if not already there
    window.location.href = "/admin/pages/dashboard.html";
  }
} else {
  window.location.href = "../index.html";
}

function logout() {
  // Delete the 'admin_logged_in' cookie
  document.cookie =
    "admin_logged_in=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
  // Redirect to the login page
  window.location.href = "../index.html";
}
// export students's data as excel
// Export Excel button functionality
const exportButton = document.querySelector(".excel-export-button");
exportButton.addEventListener("click", function () {
  console.log("Exporting all student data...");

  // Create an invisible link to trigger the download
  const link = document.createElement("a");
  link.href = "../php/services/export_as_excel.php"; // Path to your PHP script (without UUID)
  link.download = "students-data.xlsx"; // Set the filename for the downloaded file

  // Append the link to the body and trigger the click event
  document.body.appendChild(link);
  link.click();

  // Remove the link after the click
  document.body.removeChild(link);
});
