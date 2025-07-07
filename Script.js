
// document.getElementById("appointmentForm").addEventListener("submit", function (e) {
//   e.preventDefault();
//   const form = this;
//   const formData = new FormData(form);

//   fetch("submit_appointment.php", {
//     method: "POST",
//     body: formData
//   })
//   .then(response => response.text())
//   .then(data => {
//     const msg = document.getElementById("formMessage");
//     if (data.trim() === "success") {
//       msg.textContent = "Appointment submitted successfully!";
//       msg.style.color = "green";
//       form.reset();
//     } else {
//       msg.textContent = "There was an error. Try again.";
//       msg.style.color = "red";
//     }
//   })
//   .catch(error => {
//     const msg = document.getElementById("formMessage");
//     msg.textContent = "Something went wrong.";
//     msg.style.color = "red";
//   });
// });

