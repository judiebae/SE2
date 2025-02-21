<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="draft.css">

</head>
<body>
    <!-- pet-modal.php -->
<div class="modal-overlay">
  <div class="pet-modal">
    <div class="modal-header">
      <h2>Pet/s</h2>
      <button class="close-btn">&times;</button>
    </div>
    
    <form class="pet-form" method="post" enctype="multipart/form-data">
      <div class="form-grid">
        <div class="left-column">
          <div class="form-group">
            <label>NAME</label>
            <input type="text" name="pet_name" required>
          </div>

          <div class="form-group">
            <label>PET SIZE</label>
            <div class="radio-group">
              <label>
                <input type="radio" name="pet_size" value="small_dog">
                Small Dog
              </label>
              <label>
                <input type="radio" name="pet_size" value="large_dog">
                Large Dog
              </label>
              <label>
                <input type="radio" name="pet_size" value="regular_dog">
                Regular Dog
              </label>
              <label>
                <input type="radio" name="pet_size" value="regular_cat">
                Regular Cat
              </label>
            </div>
          </div>

          <div class="form-group">
            <label>BREED</label>
            <input type="text" name="breed" placeholder="Type Breed Here">
          </div>

          <div class="form-group">
            <label>AGE</label>
            <input type="text" name="age" placeholder="Type Age Here">
          </div>

          <div class="form-group">
            <label>GENDER</label>
            <div class="radio-group">
              <label>
                <input type="radio" name="gender" value="male">
                Male
              </label>
              <label>
                <input type="radio" name="gender" value="female">
                Female
              </label>
            </div>
          </div>

          <div class="form-group">
            <label>DESCRIPTION</label>
            <textarea name="description" placeholder="e.x. White Spots"></textarea>
          </div>
        </div>

        <div class="right-column">
          <div class="form-group">
            <label>PET PROFILE PHOTO</label>
            <input type="file" name="pet_photo" class="file-upload">
          </div>

          <div class="form-group">
            <label>VACCINATION STATUS</label>
            <div class="radio-group">
              <label>
                <input type="radio" name="vaccination_status" value="vaccinated">
                Vaccinated
              </label>
              <label>
                <input type="radio" name="vaccination_status" value="not_vaccinated">
                Not Vaccinated
              </label>
            </div>
          </div>

          <div class="form-group">
            <label>DATE ADMINISTERED</label>
            <input type="date" name="date_administered">
          </div>

          <div class="form-group">
            <label>EXPIRY DATE</label>
            <input type="date" name="expiry_date">
          </div>

          <div class="form-group">
            <label>SPECIAL INSTRUCTIONS</label>
            <textarea name="special_instructions" placeholder="e.x. Medications"></textarea>
          </div>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="submit-btn">Save and Go Back</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>