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

$(document).ready(function () {
  $('#AddAcountBtn').on('click', function (event) {
    const fields = [
      { id: 'firstname', label: 'Firstname' },
      { id: 'lastname', label: 'Lastname' },
      { id: 'email', label: 'Email' },
      { id: 'phone', label: 'Phone number' },
      { id: 'address', label: 'Address' },
      { id: 'birthdate', label: 'Birthdate' },
      { id: 'gender', label: 'Gender' },
      { id: 'appointment', label: 'Appointment Date' },
      { id: 'doctor_id', label: 'Doctor' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/auth/appointment-basic/add',
      cache: false,
      data: $('#AddAccountData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#AddAccount').modal('hide');
        $('.preloader').show();
      },
      success: function (data) {
        $('.preloader').hide();
        if (data.Error == 1) {
          Swal.fire('Error!', data.Message, 'error');
        } else if (data.Error == 0) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Saved!',
            text: data.Message,
            showConfirmButton: true,
            confirmButtonText: 'OK'
          }).then(result => {
            location.reload();
          });
        }
      },
      error: function () {
        $('.preloader').hide();
        Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
      }
    });
  });
});

// for editing
$(document).ready(function () {
  $('body').on('click', '.Edit', function () {
    const appointmentId = $(this).data('id');
    const patientId = $(this).data('patient_id');
    const patientFirstName = $(this).data('patient-firstname');
    const patientLastName = $(this).data('patient-lastname');
    const patientDob = $(this).data('patient-dob');
    const patientGender = $(this).data('patient-gender');
    const patientPhone = $(this).data('patient-phone');
    const patientEmail = $(this).data('patient-email');
    const patientAddress = $(this).data('patient-address');
    const doctorFirstName = $(this).data('doctor-firstname');
    const doctorLastName = $(this).data('doctor-lastname');
    const appointmentDate = $(this).data('appointment-date');
    const appointmentStatus = $(this).data('status');

    // Populate the modal fields with the data using the new Edit_ prefixed IDs
    $('#EditAppointment').find('#Edit_appointment_id').val(appointmentId);
    $('#Edit_patient_id').val(patientId);
    $('#EditAppointment').find('#Edit_firstname').val(patientFirstName);
    $('#EditAppointment').find('#Edit_lastname').val(patientLastName);
    $('#EditAppointment').find('#Edit_dob').val(patientDob);
    $('#EditAppointment').find('#Edit_gender').val(patientGender);
    $('#EditAppointment').find('#Edit_phone').val(patientPhone);
    $('#EditAppointment').find('#Edit_email').val(patientEmail);
    $('#EditAppointment').find('#Edit_address').val(patientAddress);
    $('#EditAppointment')
      .find('#Edit_doctor_id')
      .val(doctorFirstName + ' ' + doctorLastName); // Optionally populate the doctor field dynamically
    $('#EditAppointment').find('#Edit_appointment_date').val(appointmentDate);
    $('#EditAppointment').find('#Edit_appointment_status').val(appointmentStatus);
  });

  $('body').on('click', '#SaveEditBtn', function (event) {
    $.ajax({
      type: 'POST',
      url: '/auth/appointment-basic/update',
      cache: false,
      data: $('#EditAppointmentData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#EditAppointment').modal('hide');
        $('.preloader').show();
      },
      success: function (data) {
        $('.preloader').hide();
        if (data.Error == 1) {
          Swal.fire('Error!', data.Message, 'error');
        } else if (data.Error == 0) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Saved!',
            text: data.Message,
            showConfirmButton: true,
            confirmButtonText: 'OK'
          }).then(result => {
            location.reload();
          });
        }
      },
      error: function () {
        $('.preloader').hide();
        Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
      }
    });
  });
});

//for deleting
$(document).ready(function () {
  $('body').on('click', '.DeleteBtn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '/auth/appointment-basic/delete',
          cache: false,
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
          },
          dataType: 'json',
          beforeSend: function () {
            $('.preloader').show();
          },
          success: function (data) {
            $('.preloader').hide();
            if (data.Error == 1) {
              Swal.fire('Error!', data.Message, 'error');
            } else if (data.Error == 0) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Saved!',
                text: data.Message,
                showConfirmButton: true,
                confirmButtonText: 'OK'
              }).then(result => {
                location.reload();
              });
            }
          },
          error: function () {
            $('.preloader').hide();
            Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
          }
        });
      }
    });
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
                <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditAppointment"
                  data-id="${appointment.appointment_id}"
                  data-patient_id="${appointment.patient_id}"
                  data-patient-firstname="${appointment.patient_first_name}"
                  data-patient-lastname="${appointment.patient_last_name}"
                  data-patient-dob="${appointment.patient_dob}"
                  data-patient-gender="${appointment.patient_gender}"
                  data-patient-phone="${appointment.patient_phone_number}"
                  data-patient-email="${appointment.patient_email}"
                  data-patient-address="${appointment.patient_address}"
                  data-doctor-firstname="${appointment.doctor_firstname}"
                  data-doctor-lastname="${appointment.doctor_lastname}"
                  data-doctor-email="${appointment.doctor_email}"
                  data-appointment-date="${appointment.appointment_date}"
                  data-status="${appointment.appointment_status}">
                  <i class="ri-pencil-line me-1"></i> Edit
                </a>
                <a class="dropdown-item DeleteBtn" href="javascript:void(0);" data-id="${appointment.appointment_id}">
                  <i class="ri-delete-bin-6-line me-1"></i> Delete
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
