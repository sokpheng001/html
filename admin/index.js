// Function to get the value of a cookie by name
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null; // Cookie not found
}

// Check if the admin is logged in by checking the 'admin_logged_in' cookie
// if (!getCookie("admin_logged_in")) {
//   // Redirect to the login page if not logged in
//   window.location.href = "/admin/status/login.html";
// }

function logout() {
  // Delete the 'admin_logged_in' cookie
  document.cookie =
    "admin_logged_in=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
  // Redirect to the login page
  window.location.href = "/admin/status/login.html";
}
