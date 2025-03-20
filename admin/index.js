// Function to get the value of a cookie by name
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null; // Cookie not found
}

// Delete the 'admin_logged_in' cookie
document.cookie =
  "admin_logged_in=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
