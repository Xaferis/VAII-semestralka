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
    let subcategorySelectObject = document.getElementById("subcategory")
    let selectedValue = document.getElementById("category").value
    try {
        const response = await $.ajax({
            url: '?c=posts&a=updateSubcategories',
            method: 'POST',
            data: {selectedValue},
            dataType: 'json'
        });

        if (response.hasOwnProperty('subcategories')) {
            while (subcategorySelectObject.options.length > 0) {
                subcategorySelectObject.remove();
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

    if (document.getElementsByName("file_names[]").length + img.length > 10) {
        window.scrollTo(0,0)
        createAlert("Maximálny počet súborov je 10!", "danger")
        document.getElementById("photo").value = ""
        return
    }

    if(img.length > 0){
        for (let i = 0; i < img.length; i++) {
            form_data.append('photo[]', img[i])
        }

        try {
            const response = await $.ajax({
                url: '?c=posts&a=uploadImages',
                method: 'POST',
                data: form_data,
                contentType: false,
                processData: false
            });

            if (response.hasOwnProperty('isSuccessful') && response.hasOwnProperty('file_names')) {
                if (!response.isSuccessful) {
                    createAlert("Došlo k chybe pri nahrávaní obrázkov.", true)
                    return
                }

                let formElement = document.getElementById("post-form")
                let imageShowcaseElement = document.getElementById("images-showcase")
                for (let i = 0; i < response.file_names.length; i++) {
                    let inputElement = document.createElement("input")
                    inputElement.type = "hidden"
                    inputElement.name = "file_names[]"
                    inputElement.value = response.file_names[i]

                    let divElement = document.createElement("div")
                    divElement.className = "col py-3 show-image"

                    let imgElement = document.createElement("img")
                    imgElement.className = "img-fluid"
                    imgElement.src = "public/images/uploads/" + response.file_names[i]

                    let buttonElement = document.createElement("button")
                    buttonElement.className = "btn btn-danger"
                    buttonElement.innerHTML = "X"
                    buttonElement.value = response.file_names[i]
                    buttonElement.onclick = function(){ deleteUploadedImages(buttonElement, "posts") };

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

async function uploadProfileImage() {
    let form_data = new FormData();
    let profileImageElement = document.getElementById("profile-image")
    let divProfileElement = profileImageElement.parentElement
    let image = document.getElementById("photo").files[0]

    form_data.append('photo', image)

    try {
        const response = await $.ajax({
            url: '?c=profile&a=uploadImage',
            method: 'POST',
            data: form_data,
            contentType: false,
            processData: false
        });

        if (response.hasOwnProperty('isSuccessful') && response.hasOwnProperty('file_path')) {
            if (!response.isSuccessful) {
                createAlert("Došlo k chybe pri nahrávaní obrázka.", true)
                return
            }

            let formElement = document.getElementById("profile-form")
            let button = document.getElementById("delete_button")
            if (button) {
                await deleteUploadedImages(button, "profile")
            }

            let buttonElement = document.createElement("button")
            buttonElement.className = "btn btn-danger"
            buttonElement.id = "delete_button"
            buttonElement.innerHTML = "X"
            buttonElement.type = "button"
            buttonElement.value = response.file_path
            divProfileElement.appendChild(buttonElement)
            buttonElement.onclick = function(){ deleteUploadedImages(buttonElement, "profile") };

            let inputElement = document.createElement("input")
            inputElement.type = "hidden"
            inputElement.name = "file_path"
            inputElement.id = "file_path_input"
            inputElement.value = response.file_path
            formElement.appendChild(inputElement)

            profileImageElement.src = response.file_path
            if (!divProfileElement.className.includes("show-image")) {
                divProfileElement.className += " show-image"
            }
        }
    } catch (error) {
        console.error(error);
    }

}

async function updateProfileData() {
    let formData = new FormData()
    let usernameInput = document.getElementById("username");
    let telephoneInput = document.getElementById("telephone");
    let filePathInput = document.getElementById("file_path_input")

    if (!usernameInput && !telephoneInput) {
        createAlert("Niekde nastala chyba.", true)
    }

    formData.append("username", usernameInput.value)
    formData.append("telephone", telephoneInput.value)
    if (filePathInput) {
        formData.append("file_path", filePathInput.value)
    }

    try {
        const response = await $.ajax({
            url: '?c=profile&a=update',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false
        });

        if (response.hasOwnProperty('isSuccessful')
            && response.hasOwnProperty('user')
            && response.hasOwnProperty('message')
        ) {
            if (response.isSuccessful) {
                createAlert(response.message, false)
            } else {
                if (response.cause === "username") {
                    usernameInput.value = response.user.name
                } else if (response.cause === "telephone") {
                    telephoneInput.value = response.user.telephone
                }
                createAlert(response.message, true)
            }
        }
    } catch (error) {
        console.error(error);
    }
}

function deletePostImageElements(button) {
    let imageName = button.value
    let parentElement = button.parentElement
    let inputElements = document.getElementsByName("file_names[]");
    let inputElement = Array.from(inputElements).filter(element => (element.value === imageName))[0];

    while (parentElement.firstChild) {
        parentElement.removeChild(parentElement.lastChild);
    }
    parentElement.remove()
    if (inputElement) {
        inputElement.remove()
    }
}

function deleteProfileImageElements() {
    let button = document.getElementById("delete_button")
    let buttonDiv = button.parentElement
    let inputElement = document.getElementById("file_path_input")
    let profileImageElement = document.getElementById("profile-image")

    button.remove()
    inputElement.remove()
    profileImageElement.src = "public/images/profile/placeholder-user.png"
    if (buttonDiv) {
        buttonDiv.className = "col-3 p-3"
    }
}

async function deleteUploadedImages(button, controller) {
    let imageName = button.value

    try {
        const response = await $.ajax({
            url: '?c=' + controller + '&a=deleteImage',
            method: 'POST',
            data: {imageName},
            dataType: 'json'
        });

        if (response.hasOwnProperty('isSuccessful')) {
            if (controller === "profile") {
                deleteProfileImageElements()
            } else {
                deletePostImageElements(button)
            }
        }
    } catch (error) {
        console.error(error);
    }
}

function createAlert(message, isDanger) {
    console.log("fungujem")
    let containerElement = document.getElementsByClassName("inner-container")[0]

    let type = isDanger ? "danger" : "success"

    let divElement = document.createElement("div")
    divElement.className = "alert alert-" + type + " alert-dismissible fade show"
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