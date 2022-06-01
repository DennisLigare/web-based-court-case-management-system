// User type event listener
let userType = document.getElementById("user_type");

if (userType) {
  displayFields();

  userType.onchange = displayFields;
}

function displayFields() {
  if (userType.value == "admin") {
    showAdminFields();
    hideIndividualFields();
    hideOrganisationFields();
    hidelawfirmFields();
  } else if(userType.value == "individual") { 
    showIndividualFields();
    hideAdminFields();
    hideOrganisationFields();
    hidelawfirmFields();
  } else if(userType.value == "organisation") { 
    showOrganisationFields();
    hideAdminFields();
    hideIndividualFields();
    hideLawfirmFields();
  } else if(userType.value == "lawfirm") {
    showLawfirmFields();
    hideAdminFields();
    hideIndividualFields();
    hideOrganisationFields();
    
  }
}

function hideAdminFields() {
  let adminFields = document.getElementById('admin_fields');
  let fullName = document.getElementById('full_name')

  adminFields.classList.add('d-none')
  fullName.required = false
}

function showAdminFields() {
  let adminFields = document.getElementById('admin_fields');
  let fullName = document.getElementById('full_name')

  adminFields.classList.remove('d-none')
  fullName.required = true
}

function hideIndividualFields() {
  let individualsFields = document.getElementById("individual_fields");
  let firstName = document.getElementById('first_name');
  let lastName = document.getElementById('last_name');
  let nationality = document.getElementById('nationality');
  let idNumber = document.getElementById('id_number');

  firstName.required = false
  firstName.disabled = true

  lastName.required = false
  lastName.disabled = true
  
  nationality.required = false
  nationality.disabled = true

  idNumber.required = false
  idNumber.disabled = true

  individualsFields.classList.add("d-none");
}

function showIndividualFields() {
  let individualsFields = document.getElementById("individual_fields");
  let firstName = document.getElementById('first_name');
  let lastName = document.getElementById('last_name');
  let nationality = document.getElementById('nationality');
  let idNumber = document.getElementById('id_number');

  firstName.required = true
  firstName.disabled = false

  lastName.required = true
  lastName.disabled = false

  nationality.required = true
  nationality.disabled = false

  idNumber.required = true
  idNumber.disabled = false

  individualsFields.classList.remove("d-none");
}

function showOrganisationFields() {
  let organisationFields = document.getElementById("organisation_fields");
  let organisation_name = document.getElementById("organisation_name");

  organisationFields.classList.remove("d-none");
  organisation_name.required = true;
  organisation_name.disabled = false;
}
function hideOrganisationFields() {
  let organisationFields = document.getElementById("organisation_fields");
  let organisation_name = document.getElementById("organisation_name");

  organisationFields.classList.add("d-none");
  organisation_name.required = false;
  organisation_name.disabled = true;
}

function showLawfirmFields() {
  let lawfirmFields = document.getElementById("lawfirm_fields");
  let lawfirm_name = document.getElementById("lawfirm_name");

  lawfirmFields.classList.remove("d-none");
  lawfirm_name.required = true;
  lawfirm_name.disabled = false;
}
function hideLawfirmFields() {
  let lawfirmFields = document.getElementById("lawfirm_fields");
  let lawfirm_name = document.getElementById("lawfirm_name");

  lawfirmFields.classList.add("d-none");
  lawfirm_name.required = false;
  lawfirm_name.disabled = true;
}

// Password Verification
let password = document.getElementById("password");
let confirmPassword = document.getElementById("confirm_password");

password.onchange = validatePassword;
confirmPassword.onkeyup = validatePassword;

function validatePassword() {
  if (password.value != confirmPassword.value) {
    confirmPassword.setCustomValidity("Passwords Don't Match");
  } else {
    confirmPassword.setCustomValidity("");
  }
}
