function checkInputFields() {
    console.log("fungujem?")
    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
}

if (window.location.toString().includes("?c=auth&a=register")) {
    console.log("im in")
    checkInputFields();
}
// window.onload = start;