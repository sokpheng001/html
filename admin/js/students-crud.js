function getAllStudents() {
  const tableBody = document.querySelector(".student-table tbody");
  if (!tableBody) {
    console.error("Error: Table body not found!");
    return;
  }

  // Clear existing data before fetching new ones
  tableBody.innerHTML = "";
  fetch("../php/services/student_service.php?read=true")
    .then((response) => {
      if (!response.ok) {
        console.log("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      // console.log("Received data:", data);

      if (!Array.isArray(data) || data.length === 0) {
        checkIfNoData("empty");
        return;
      }

      // Truncate email function
      const truncateEmail = (email) =>
        email.length > 5 ? email.slice(0, 5) + "..." : email;

      // Populate table
      data.forEach((user) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${user.stu_id}</td>
          <td>${user.khmer_name}</td>
          <td>${user.latin_name}</td>
          <td>${user.father_name}</td>
          <td>${user.mother_name}</td>
          <td>${user.date_of_birth}</td>
          <td>${user.place_of_birth}</td>
          <td>
            <span style="cursor: pointer" class="email-display" data-email="${
              user.original_email
            }">
              ${truncateEmail(user.original_email)}
            </span>
          </td>
          <td>
            <span style="cursor: pointer" class="email-display" data-email="${
              user.school_email
            }">
              ${truncateEmail(user.school_email)}
            </span>
          </td>
          <td>${user.phone_number}</td>
          <td>${user.major}</td>
          <td>${user.expired_date}</td>
          <td>${user.gender}</td>
          <td>
            <button class="action-button edit" onclick="openUpdateModal({})">កែ</button>
            <button class="action-button delete" onclick="deleteRecord('${
              user.stu_id
            }')">លុប</button>
          </td>
        `;

        tableBody.appendChild(row);
      });
    })
    .catch((error) => {
      console.error("Error fetching users:", error);
      checkIfNoData("error");
    });
}
// delete data in api
// ----------------------------------------------------------------
function deleteRecord(stu_id) {
  localStorage.setItem("stu_id", stu_id);
  openModal();

  // alert("Record deleted (This is a placeholder action).");
  // deleteUser(stu_id);
}
// search student by id
let debounceTimeout;

function searchStudentById() {
  const studentId = document.getElementById("search-input").value.trim();
  const tableBody = document.querySelector(".student-table tbody");

  // Clear table if no input or input is empty
  if (!studentId) {
    tableBody.innerHTML = ""; // Clear table if search field is empty
    return;
  }

  // Check if table body exists
  if (!tableBody) {
    console.error("Error: Table body not found!");
    return;
  }
  // Fetch all students if input is empty
  if (studentId == "") {
    window.location.reload();
    return;
  }

  // Clear the table before fetching new data
  tableBody.innerHTML = "";

  // Debounce: Only make request after 300ms of inactivity
  clearTimeout(debounceTimeout);

  debounceTimeout = setTimeout(() => {
    fetch(`../php/services/search_student_by_id.php?search=${studentId}`)
      .then((response) => {
        if (!response.ok) {
          console.log("Network response was not ok");
          return;
        }
        return response.json();
      })
      .then((data) => {
        // Handle case where no data is returned
        if (data.error) {
          checkIfNoData("empty");
          return;
        }
        // Truncate email if too long
        const truncateEmail = (email) =>
          email.length > 5 ? email.slice(0, 5) + "..." : email;

        // Populate table with the found student data
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${data.stu_id}</td>
          <td>${data.khmer_name}</td>
          <td>${data.latin_name}</td>
          <td>${data.father_name}</td>
          <td>${data.mother_name}</td>
          <td>${data.date_of_birth}</td>
          <td>${data.place_of_birth}</td>
          <td>
            <span style="cursor: pointer" class="email-display" data-email="${
              data.original_email
            }">
              ${truncateEmail(data.original_email)}
            </span>
          </td>
          <td>
            <span style="cursor: pointer" class="email-display" data-email="${
              data.school_email
            }">
              ${truncateEmail(data.school_email)}
            </span>
          </td>
          <td>${data.phone_number}</td>
          <td>${data.major}</td>
          <td>${data.expired_date}</td>
          <td>${data.gender}</td>
          <td>
            <button class="action-button edit" onclick="openUpdateModal({${data}})">កែ</button>
            <button class="action-button delete" onclick="deleteRecord('${
              data.stu_id
            }')">លុប</button>
          </td>
        `;

        tableBody.appendChild(row);
      })
      .catch((error) => {
        console.error("Error fetching student data:", error);
        checkIfNoData("error");
      });
  }, 300); // Adjust debounce time if needed (300ms)
}

// ✅ Add event listener for real-time search
const searchInput = document.getElementById("search-input");

// ✅ Listen for "input" event + "keyup" for backspace detection
searchInput.addEventListener("input", searchStudentById);
searchInput.addEventListener("keyup", (event) => {
  if (event.key === "Backspace" && searchInput.value.trim() === "") {
    // console.log("Backspace cleared input, fetching all students...");
    getAllStudents();
  }
});

// update modal

// Function to open the update modal and fill in the form with student data
function openUpdateModal(student) {
  console.log(student);
  // Fill the form with the student's data
  // document.getElementById("stu_id").value = student.stu_id;
  // document.getElementById("khmer_name").value = student.khmer_name;
  // document.getElementById("latin_name").value = student.latin_name;
  // document.getElementById("father_name").value = student.father_name;
  // document.getElementById("mother_name").value = student.mother_name;
  // document.getElementById("date_of_birth").value = student.date_of_birth;
  // document.getElementById("place_of_birth").value = student.place_of_birth;
  // document.getElementById("original_email").value = student.original_email;
  // document.getElementById("school_email").value = student.school_email;
  // document.getElementById("phone_number").value = student.phone_number;
  // document.getElementById("major").value = student.major;
  // document.getElementById("expired_date").value = student.expired_date;
  // document.getElementById("gender").value = student.gender;

  // Show the modal
  document.getElementById("updateStudentModal").style.display = "flex";
}

// Function to close the modal
function closeUpdateModal() {
  document.getElementById("updateStudentModal").style.display = "none";
}

// ended of search

function checkIfNoData(status) {
  const tableBody = document.querySelector(".student-table tbody");
  const message = document.createElement("tr");
  const cell = document.createElement("td");
  cell.colSpan = 15; // Adjust the number of columns
  cell.style.textAlign = "center";

  if (status.toLowerCase() === "error") {
    cell.textContent = "ការទទួលទិន្នន័យពី Server មានបញ្ហា ⚠️"; // "Error fetching data from Server" in Khmer
  } else if (status.toLowerCase() === "empty") {
    cell.textContent = "មិនមានទិន្នន័យ 🪹"; // "No data available" in Khmer
  } else {
    cell.textContent = status + " ⚠️";
  }

  message.appendChild(cell);
  tableBody.appendChild(message);
}

getAllStudents();
// animation button click
let currentTooltip;

function openModal() {
  document.getElementById("deleteConfirmationModal").style.display = "block";
}

function closeModal() {
  document.getElementById("deleteConfirmationModal").style.display = "none";
}

// Optional: Close the modal if the user clicks outside the modal
window.onclick = function (event) {
  var modal = document.getElementById("deleteConfirmationModal");
  if (event.target == modal) {
    closeModal();
  }
};

//

function startDeleteStudent() {
  let stu_id = localStorage.getItem("stu_id");
  deleteUser(stu_id);
  localStorage.removeItem("stu_id");
}

function deleteUser(student_id) {
  // Send a POST request to delete the student by stu_id
  fetch("../php/services/student_service.php", {
    method: "POST",
    body: new URLSearchParams({
      delete: true,
      stu_id: student_id, // Pass the student ID for deletion
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.message) {
        // alert(data.message); // Show success message
        removeStudentRow(stu_id); // Remove the row from the table
      } else {
        console.log("Error deleting user.");
      }
    })
    .catch((error) => {
      console.log("Error: " + error);
    });
  window.location.reload();
}
// update

//
function removeStudentRow(stu_id) {
  // Find the row with the corresponding stu_id and remove it from the table
  const rows = document.querySelectorAll(".student-table tbody tr");
  rows.forEach((row) => {
    const rowStuId = row.querySelector("td").textContent; // Assume the first td is stu_id
    if (rowStuId === stu_id) {
      row.remove();
    }
  });
}

// Example usage: Attach event listener for delete button in the table
document.querySelectorAll(".action-button.delete").forEach((button) => {
  button.addEventListener("click", function () {
    const stu_id = this.closest("tr").querySelector("td").textContent; // Get stu_id from the table row
    if (confirm("Are you sure you want to delete this student?")) {
      deleteUser(stu_id); // Call deleteUser with the stu_id
    }
  });
});

// ------------------------------------------------------------------------------------------------
// Function to handle email clicks
function handleEmailClick(event) {
  console.log("អ៊ីមែលត្រូវបានចុច!"); // "Email clicked!" in Khmer
  event.preventDefault(); // Prevent the default action (i.e., highlighting the email or any other default browser behavior)

  const emailElement = event.target;
  const fullEmail = emailElement.dataset.email || emailElement.innerText.trim(); // Get full email from data attribute
  if (!fullEmail) {
    console.error("រកអ៊ីមែលមិនឃើញ!"); // "Couldn't find the email!"
    return;
  }

  // Remove any existing tooltip
  if (currentTooltip) {
    currentTooltip.remove();
  }

  // Create a tooltip after a small delay to avoid blocking copy interaction
  setTimeout(() => {
    // Create tooltip elements
    const tooltip = document.createElement("div");
    tooltip.style.position = "absolute";
    tooltip.style.background = "white";
    tooltip.style.border = "1px solid black";
    tooltip.style.padding = "10px";
    tooltip.style.zIndex = "1000";
    tooltip.style.top = `${event.clientY + 20}px`; // Make sure it's not overlapping
    tooltip.style.left = `${event.clientX}px`;

    // Email text
    const emailText = document.createElement("span");
    emailText.textContent = fullEmail;

    // Copy button
    const copyButton = document.createElement("button");
    copyButton.style.cursor = "pointer";
    copyButton.textContent = "ចម្លង"; // "Copy" in Khmer
    copyButton.onclick = function () {
      navigator.clipboard
        .writeText(fullEmail) // Copy full email from data-email
        .then(() => alert("អ៊ីមែលត្រូវបានចម្លងទៅក្ដារតម្លាក់ខ្ទាស់!")) // "Email copied to clipboard!" in Khmer
        .catch((err) => console.error("មិនអាចចម្លងអ៊ីមែលបានទេ: ", err));
      tooltip.remove();
      currentTooltip = null;
    };

    // Append elements
    tooltip.appendChild(emailText);
    tooltip.appendChild(document.createElement("br"));
    tooltip.appendChild(copyButton);
    document.body.appendChild(tooltip);
    currentTooltip = tooltip;

    // Close tooltip when clicking outside
    setTimeout(() => {
      document.addEventListener("click", function handleOutsideClick(event) {
        if (currentTooltip && !tooltip.contains(event.target)) {
          tooltip.remove();
          currentTooltip = null;
          document.removeEventListener("click", handleOutsideClick);
        }
      });
    }, 10);
  }, 100); // Delay to avoid blocking interaction
}
// Attach event listener to the table container using event delegation
document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM បានបង្ហាញរួចហើយ!"); // "DOM is ready!" in Khmer

  // Event delegation: Listen for clicks on any email display element inside the table
  document
    .querySelector(".student-table")
    .addEventListener("click", function (event) {
      if (event.target && event.target.classList.contains("email-display")) {
        handleEmailClick(event);
      }
    });
});
