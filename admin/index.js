// Check if session data exists
if (sessionStorage.getItem("admin_logged_in")) {
  // Redirect to the dashboard or another page
  window.location.href = "/";
} else {
  // Redirect to the login page
  window.location.href = "/admin/status/login.html";
}
