function checkInputFields() {
    const elements = document.getElementsByClassName("form-control")

    let emptyCount = Array.from(elements).filter(element => (!element.value || element.value.length === 0)).length
    if (emptyCount === 0) {
        document.querySelector('.hidable').removeAttribute("disabled")
    } else {
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

async function updateSubcategories() {
    var subcategorySelectObject = document.getElementById("subcategory")
    var selectedValue = document.getElementById("category").value
    try {
        const response = await $.ajax({
            url: '?c=posts&a=updateSubcategories',
            method: 'POST',
            data: {selectedValue},
            dataType: 'json'
        });

        if (response.hasOwnProperty('subcategories')) {
            while (subcategorySelectObject.options.length > 0) {
                subcategorySelectObject.remove(0);
            }
            response.subcategories.forEach(subcategory => {
                subcategorySelectObject.add(new Option(subcategory.description, subcategory.id), undefined)
            })
        }
    } catch (error) {
        console.error(error);
    }
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