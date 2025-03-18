function deleteTab() {

  // Replace main body content with a message after deletion
  const mainContent = document.querySelector("main");
  if (mainContent) {
    mainContent.innerHTML = "<h2>Deleted student</h2>";
  }

  // You can also make an API call to delete the student from the database here.
  // After successful deletion, you can either reload the page or adjust the UI accordingly.
}


