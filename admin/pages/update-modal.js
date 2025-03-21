document.getElementById(
  "updateStudentModal"
).innerHTML = `<div class="modal-content">
        <span class="close-button" onclick="closeUpdateModal()">×</span>
        <h3>កែប្រែព័ត៌មាននិស្សិត</h3>
        <form id="updateStudentForm">
          <label for="stu_id">លេខសម្គាល់ (ID)</label>
          <input type="text" id="stu_id" name="stu_id" readonly>

          <label for="khmer_name">ឈ្មោះខ្មែរ</label>
          <input type="text" id="khmer_name" name="khmer_name" required>

          <label for="latin_name">ឈ្មោះឡាតាំង</label>
          <input type="text" id="latin_name" name="latin_name" required>

          <label for="father_name">ឈ្មោះឪពុក</label>
          <input type="text" id="father_name" name="father_name" required>

          <label for="mother_name">ឈ្មោះម្តាយ</label>
          <input type="text" id="mother_name" name="mother_name" required>

          <label for="date_of_birth">ថ្ងៃខែឆ្នាំកំណើត</label>
          <input type="date" id="date_of_birth" name="date_of_birth" required>

          <label for="place_of_birth">ទីកន្លែងកំណើត</label>
          <input type="text" id="place_of_birth" name="place_of_birth" required>

          <label for="original_email">អ៊ីមែលដើម</label>
          <input type="email" id="original_email" name="original_email" required>

          <label for="school_email">អ៊ីមែលសាលា</label>
          <input type="email" id="school_email" name="school_email" required>

          <label for="phone_number">លេខទូរស័ព្ទ</label>
          <input type="text" id="phone_number" name="phone_number" required>

          <label for="major">ជំនាញ</label>
          <input type="text" id="major" name="major" required>

          <label for="expired_date">គណនីផុតកំណត់</label>
          <input type="date" id="expired_date" name="expired_date" required>

          <label for="gender">ភេទ</label>
          <select id="gender" name="gender" required>
            <option value="male">ប្រុស</option>
            <option value="female">ស្រី</option>
          </select>

          <button type="submit" class="confirm-button">អាប់ដេត</button>
          <button type="button" class="cancel-button" onclick="closeUpdateModal()">បោះបង់</button>
        </form>
      </div>`;
