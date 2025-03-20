// check if ther is cookie data
// Function to get a specific cookie by name
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}

function checkStudentCookies() {
  // Check for student_email cookie
  const emailCookie = getCookie("student_email");

  // Check for student_pass cookie
  const passCookie = getCookie("student_password");

  // Return true if both cookies exist
  return emailCookie && passCookie;
}
// usage if cookie is not existed
if (!checkStudentCookies()) {
  window.location.href = "/";
}
// print as pdf
function printStudentInfoAsPDF() {
  document
    .getElementById("export-pdf-btn")
    .addEventListener("click", function () {
      // Hide the header and footer elements
      const header = document.querySelector("header");
      const footer = document.querySelector("footer");

      // Save the current display state of header and footer
      const headerDisplay = header.style.display;
      const footerDisplay = footer.style.display;

      // Hide header and footer
      header.style.display = "none";
      footer.style.display = "none";

      // Create a new style element to hide buttons and export section during printing
      const style = document.createElement("style");

      // Set the CSS rules to hide buttons and the export section during printing
      style.innerHTML = `
      @media print {
        button, #export-excel-btn {
          display: none !important;
        }
        #export-as-excel-section {
          display: none !important;
        }
      }
    `;

      // Append the style element to the head of the document
      document.head.appendChild(style);

      // Trigger print
      window.print();

      // Restore the original display state after printing
      setTimeout(() => {
        header.style.display = headerDisplay;
        footer.style.display = footerDisplay;
        // Remove the added print styles after printing
        document.head.removeChild(style);
      }, 0);
    });
}
// load student data from api
document.addEventListener("DOMContentLoaded", function () {
  //
  const urlParams = new URLSearchParams(window.location.search);
  const uuid = urlParams.get("id");

  if (!uuid) {
    window.location.href = "../not-found.html"; // Redirect if no uuid is provided
    return;
  }
  if (uuid) {
    fetch("../../php/service/fetch_user.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `uuid=${uuid}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Populate profile details with fetched data
          document.getElementById("khmer-name").textContent = data.khmer_name;
          document.getElementById("profile-name").textContent = data.khmer_name;
          document.getElementById("profile-name-title").textContent =
            "គណនី - " + data.khmer_name;
          document.getElementById("latin-name").textContent = data.latin_name;
          document.getElementById("father-name").textContent = data.father_name;
          document.getElementById("mother-name").textContent = data.mother_name;
          document.getElementById("date-of-birth").textContent =
            data.date_of_birth;
          document.getElementById("place-of-birth").textContent =
            data.place_of_birth;
          document.getElementById("school-email").textContent =
            data.school_email || "Not provided";
          document.getElementById("phone-number").textContent =
            data.phone_number;
          document.getElementById("major").textContent = data.major;
          document.getElementById("profile-major").textContent = data.major;
          document.getElementById("gender").textContent = data.gender;
          document.getElementById("expired_date").textContent =
            data.expired_date || "02-21-2025";

          var currentDate = new Date();
          var expiredDate = new Date(data.expired_date);
          // Check if the account has expired
          if (expiredDate < currentDate) {
            alert("⚠️ គណនីរបស់អ្នកបានផុតកំណត់!");
            window.location.href = "../not-found.html"; // Redirect on error
            return; // Prevent form submission if expired
          }

          // If you have a profile image URL, you can also update the profile picture
          if (data.profile) {
            document.querySelector(".profile-picture").src = data.profile;
          }
        } else {
          console.error("User not found");
          window.location.href = "../not-found.html"; // Redirect on error
        }
      })
      .catch((error) => {
        console.error("Error fetching user data:", error);
      });
  }
});
//

//print as excel
function printOneStudentInfoAsExcel() {
  // Export Excel button functionality
  const exportButton = document.getElementById("export-excel-btn");
  exportButton.addEventListener("click", function () {
    if (uuid) {
      console.log("Exporting data for UUID:", uuid); // Log the UUID for debugging

      // Create an invisible link to trigger the download
      const link = document.createElement("a");
      link.href = `../../php/service/export_as_excel.php?uuid=${uuid}`; // Path to your PHP script
      link.download = "profile.xlsx"; // Set the filename for the downloaded file

      // Append the link to the body and trigger the click event
      document.body.appendChild(link);
      link.click();

      // Remove the link after the click
      document.body.removeChild(link);
    } else {
      console.error("UUID is missing!");
      alert("UUID is missing!");
    }
  });
}
//  ------------------------------------

// logout
function logout() {
  // remove data from cookie
  document.cookie.split(";").forEach((cookie) => {
    document.cookie = cookie
      .replace(/^ +/, "") // Remove spaces
      .replace(/=.*/, `=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`);
  });
  window.location.href = "/";
}

//  update profile
// Get elements for the profile picture and file upload input
const profilePicture = document.getElementById("profile-picture");
const profileUpload = document.getElementById("profile-upload");
const student_uuid = getCookie("student_uuid");

// When the profile picture is clicked, trigger the file input
profilePicture.addEventListener("click", () => {
  profileUpload.click(); // Open file dialog
});
// Handle the file input change (when a new image is selected)
profileUpload.addEventListener("change", (event) => {
  const file = event.target.files[0]; // Get the selected file
  if (file) {
    const reader = new FileReader();

    // When the file is loaded, update the profile picture
    reader.onload = () => {
      profilePicture.src = reader.result; // Set the new image as the profile picture
    };

    // Read the file as a data URL
    reader.readAsDataURL(file);
    updateProfilePicture(file, student_uuid);
  }
});
// Function to send the file to the server and update the profile picture in the database
function updateProfilePicture(file, uuid) {
  const formData = new FormData();
  formData.append("profile-photo", file);
  formData.append("uuid", uuid); // Send the user's UUID along with the file

  fetch("../../php/service/update_profile.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("✅ រូបថតប្រវត្តិបានអាប់ដេតជោគជ័យ!");
      } else {
        alert(data?.message);
        // alert("⚠️ បរាជ័យក្នុងការអាប់ដេតរូបថតប្រវត្តិ");
      }
    })
    .catch((error) => {
      console.error("Error updating profile picture:", error);
      alert("Error uploading image.");
    });
}
