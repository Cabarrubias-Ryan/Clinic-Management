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
          <td>
            <span>${appointment.patient_address}</span> <br>
          </td>
          <td>
            <a href="/auth/record-basic/${appointment.id}">View</a>
          </td>
        </tr>
      `;
      $appointmentList.append(appointmentRow);
    });
  }

  function filterAppointments(query) {
    const filtered = window.appointments.filter(appointment => {
      const patientFullName = `${appointment.patient_first_name} ${appointment.patient_last_name}`.toLowerCase();
      return patientFullName.includes(query);
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
