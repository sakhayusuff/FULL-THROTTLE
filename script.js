document.addEventListener("DOMContentLoaded", function () {

    // tombol edit profil
    const editBtn = document.querySelector(".profile-info .btn.red");

    // hanya input profil
    const profileInputs = [
        document.getElementById("nama"),
        document.getElementById("email"),
        document.getElementById("no_telpon")
    ];

    // tampilan atas
    const nameDisplay = document.querySelector(".profile-info h3");
    const emailDisplay = document.querySelector(".profile-info p");

    let isEdit = false;

    editBtn.addEventListener("click", function () {

        if (!isEdit) {

            // MODE EDIT
            profileInputs.forEach(input => {

                input.removeAttribute("readonly");

                input.style.background = "#fff";

                input.style.borderColor = "red";

            });

            editBtn.textContent = "Simpan";

            isEdit = true;

        } else {

            // MODE SIMPAN
            profileInputs.forEach(input => {

                input.setAttribute("readonly", true);

                input.style.background = "#f9f9f9";

                input.style.borderColor = "#ccc";

            });

            // update tampilan atas
            nameDisplay.textContent =
            profileInputs[0].value;

            emailDisplay.textContent =
            profileInputs[1].value;

            editBtn.textContent = "Edit Profil";

            isEdit = false;

            alert("Profil berhasil diperbarui!");
        }

        // animasi tombol
        editBtn.style.transform = "scale(0.9)";

        setTimeout(() => {

            editBtn.style.transform = "scale(1)";

        }, 150);

    });

});