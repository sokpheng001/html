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
