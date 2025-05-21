// error trapping
function validateForm(fields) {
  let valid = true;

  // Loop through all fields to check if any are empty
  fields.forEach(field => {
    const input = document.getElementById(field.id);
    const value = input.value.trim();
    const errorMessages = [];

    // Check for empty fields
    if (!value) {
      valid = false;
      errorMessages.push(`${field.label} is required.`);
    }

    if (field.id === 'password-confirmation' && value) {
      const password = document.getElementById('password').value.trim();
      if (value !== password) {
        valid = false;
        errorMessages.push('Passwords do not match.');
      }
    }

    if (errorMessages.length > 0) {
      input.classList.add('is-invalid'); // Add Bootstrap 'is-invalid' class
      let errorMessageContainer = input.parentNode.querySelector('.invalid-feedback');
      if (!errorMessageContainer) {
        errorMessageContainer = document.createElement('div');
        errorMessageContainer.classList.add('invalid-feedback');
        input.parentNode.appendChild(errorMessageContainer);
      }
      errorMessageContainer.innerHTML = errorMessages.join('<br>'); // Display all errors for this field
    } else {
      input.classList.remove('is-invalid'); // Remove 'is-invalid' class if valid
      let errorMessageContainer = input.parentNode.querySelector('.invalid-feedback');
      if (errorMessageContainer) {
        errorMessageContainer.remove(); // Remove error messages
      }
    }
  });

  return valid;
}

// for editing
$(document).ready(function () {
  $('body').on('click', '.Edit', function () {
    const doctor = $(this).data('doctor_id');
    const patient = $(this).data('patient_id');
    const appointment_id = $(this).data('appointment_id');

    $('#doctor_id').val(doctor);
    $('#patient_id').val(patient);
    $('#appointment_id').val(appointment_id);
  });
});

// search
$(document).ready(function () {
  function displayAppointments(appointments) {
    const $appointmentList = $('#appointmentlist'); // Assuming there's an element with id `appointmentlist`
    $appointmentList.empty();

    if (appointments.length === 0) {
      $appointmentList.html(`<tr><td colspan="7" class="text-center text-muted">No appointments found.</td></tr>`);
      return;
    }

    appointments.forEach(appointment => {
      const appointmentRow = `
        <tr>
          <td><span>${appointment.patient_first_name} ${appointment.patient_last_name}</span></td>
          <td>${appointment.patient_email}</td>
          <td>${appointment.patient_phone_number}</td>
          <td>${appointment.appointment_date}</td>
          <td>${appointment.appointment_status}</td>
          <td>
            <span>${appointment.doctor_firstname} ${appointment.doctor_lastname}</span> <br>
            <span class="text-muted">${appointment.doctor_email}</span>
          </td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#AddDiagnosis"
                  data-doctor_id="${appointment.doctor_id}"
                  data-patient_id="${appointment.patient_id}"
                  data-appointment_id="${appointment.appointment_id}">
                  <i class="ri-pencil-line me-1" data></i> Diagnos
                </a>
                <a class="dropdown-item DeleteBtn" href="javascript:void(0);">
                  <i class="ri-delete-bin-6-line me-1"></i> Cancel
                </a>
              </div>
            </div>
          </td>
        </tr>
      `;
      $appointmentList.append(appointmentRow);
    });
  }

  function filterAppointments(query) {
    const filtered = window.appointments.filter(appointment => {
      const patientFullName = `${appointment.patient_first_name} ${appointment.patient_last_name}`.toLowerCase();
      const doctorFullName = `${appointment.doctor_firstname} ${appointment.doctor_lastname}`.toLowerCase();
      return (
        patientFullName.includes(query) ||
        doctorFullName.includes(query) ||
        appointment.appointment_status.toLowerCase().includes(query)
      );
    });
    displayAppointments(filtered);
  }

  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterAppointments(query);
  });

  // Render all appointments on page load
  displayAppointments(window.appointments);
});
