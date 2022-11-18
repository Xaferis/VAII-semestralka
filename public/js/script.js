function checkInputFields() {
    const elements = document.getElementsByClassName("form-control")

    let emptyCount = Array.from(elements).filter(element => (!element.value || element.value.length === 0)).length
    if (emptyCount === 0) {
        console.log("enabled")
        document.querySelector('.hidable').removeAttribute("disabled")
    } else {
        console.log("Disabled")
        document.querySelector('.hidable').setAttribute("disabled", "")
    }
}

function validateInputFields() {
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

function start() {
    if (window.location.toString().includes("?c=auth&a=register") ||
        window.location.toString().includes("?c=auth&a=login") ||
        window.location.toString().includes("?c=posts&a=create") ||
        window.location.toString().includes("?c=posts&a=edit")
    ) {
        validateInputFields();
    }
}

window.onload = start;