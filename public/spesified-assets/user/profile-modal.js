const modalEditProfile = document.getElementById('editProfileModal');
const modalEditProfileInstance = bootstrap.Modal.getOrCreateInstance(modalEditProfile);
modalEditProfile.addEventListener('show.bs.modal', async () => {
    drawHistoriDiagnosisTable(); // Menampilkan histori diagnosis

    const btnSubmitEditProfile = document.getElementById('btnSubmitEditProfile');
    btnSubmitEditProfile.addEventListener('click', async (e) => {
        e.preventDefault();
        Swal.fire({
            title: 'Mohon tunggu',
            html: 'Sedang memproses data',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            },
        });
        try {
            const response = await ajaxPostEditProfile();
            await new Promise(resolve => setTimeout(resolve, 1000)); // Delay selama 1 detik
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message,
                showConfirmButton: false,
                timer: 1500
            });
            return window.location.reload();
        } catch (error) {
            swalError(error.responseJSON);
        }
    });

    const setElementAttributes = (element, value, disabled = false) => {
        element.value = value;
        element.disabled = disabled;
    };

    const elements = {
        nameInput: document.querySelector('input[name="name"]'),
        emailInput: document.querySelector('input[name="email"]')
    };

    setElementAttributes(elements.nameInput, 'Mohon Tunggu...', true);
    setElementAttributes(elements.emailInput, 'Mohon Tunggu...', true);

    try {
        const response = await ajaxRequestEditProfile();
        setElementAttributes(elements.nameInput, response.user.name);
        setElementAttributes(elements.emailInput, response.user.email);
    } catch (error) {
        swalError(error.responseJSON);
    }
});

modalEditProfile.addEventListener('hide.bs.modal', async () => {
    // Code to clear the modal content when it's closed
});
