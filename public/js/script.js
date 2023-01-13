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

async function uploadImages() {
    let form_data = new FormData();
    let img = $("#photo")[0].files;

    if (document.getElementsByName("file_paths[]").length + img.length > 10) {
        window.scrollTo(0,0)
        createAlert("Maximálny počet súborov je 10!")
        document.getElementById("photo").value = ""
        return
    }

    if(img.length > 0){
        for (let i = 0; i < img.length; i++) {
            form_data.append('photo[]', img[i])
        }

        try {
            const response = await $.ajax({
                url: '?c=posts&a=processImages',
                method: 'POST',
                data: form_data,
                contentType: false,
                processData: false
            });

            if (response.hasOwnProperty('isSuccessful') && response.hasOwnProperty('file_names')) {
                let formElement = document.getElementById("post-form")
                let imageShowcaseElement = document.getElementById("images-showcase")
                for (let i = 0; i < response.file_names.length; i++) {
                    let inputElement = document.createElement("input")
                    inputElement.type = "hidden"
                    inputElement.name = "file_paths[]"
                    inputElement.value = response.file_names[i]

                    let divElement = document.createElement("div")
                    divElement.className = "col py-3 show-image"

                    let imgElement = document.createElement("img")
                    imgElement.className = "img-fluid"
                    imgElement.src = "public/images/uploads/" + response.file_names[i]

                    let buttonElement = document.createElement("button")
                    buttonElement.className = "btn btn-danger"
                    buttonElement.innerHTML = "X"

                    divElement.appendChild(imgElement)
                    divElement.appendChild(buttonElement)
                    formElement.appendChild(inputElement)
                    imageShowcaseElement.appendChild(divElement)
                }
            }
        } catch (error) {
            console.error(error);
        }
    }
}

function createAlert(message) {
    let containerElement = document.getElementsByClassName("inner-container")[0]

    let divElement = document.createElement("div")
    divElement.className = "alert alert-danger alert-dismissible fade show"
    divElement.setAttribute("role", "alert")
    divElement.innerHTML = message

    let exitButtonElement = document.createElement("button")
    exitButtonElement.type = "button"
    exitButtonElement.className = "btn-close"
    exitButtonElement.setAttribute("data-bs-dismiss", "alert")
    exitButtonElement.setAttribute("aria-label", "Close")

    divElement.appendChild(exitButtonElement)
    containerElement.insertBefore(divElement, containerElement.firstChild)
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