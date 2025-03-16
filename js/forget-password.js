// update password
document
  .getElementById("forget-password-form")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    const email = document.getElementById("email").value;
    const password = document.getElementById("new-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    // Validate passwords match
    if (password !== confirmPassword) {
      alert("ពាក្យសម្ងាត់ទាំងពីរមិនត្រូវគ្នា។ សូមព្យាយាមម្ដងទៀត។");
      return;
    }

    // Prepare form data
    const formData = new FormData();
    formData.append("email", email);
    formData.append("new_password", password);
    formData.append("confirm_password", confirmPassword);
    

    // Send form data via fetch to the PHP script
    fetch("../php/service/forget_password.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // remove data from cookie
          document.cookie.split(";").forEach((cookie) => {
            document.cookie = cookie
              .replace(/^ +/, "") // Remove spaces
              .replace(
                /=.*/,
                `=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`
              );
          });
          alert("✅ ពាក្យសម្ងាត់បានផ្លាស់ប្តូរជោគជ័យ");
          window.location.href = "../pages/login.html"; // Redirect if success
        } else {
          console.log(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("មានកំហុសក្នុងការបញ្ជូនព័ត៌មាន! សូមព្យាយាមម្ដងទៀត។");
      });
  });
