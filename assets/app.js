// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
// Initialization for ES Users
import {
    Collapse,
    Dropdown,
    Lightbox,
    Input,
    initTE,
} from "tw-elements";
import {addFormToCollection} from "./function";


initTE({ Collapse, Dropdown, Lightbox, Input });


document.querySelectorAll('.image_item').forEach(btn => {
    btn.addEventListener("click", addFormToCollection)
});


// Add image via fetch
document.querySelectorAll('form[name=image]').forEach(form => {
    const handleResponse = function (r) {
        if (r.code) {
            const images = document.querySelector('#js_images')
            images.insertAdjacentHTML('beforeend', r.image)
        }
    }

    console.log(form.querySelector('input').autocomplete = 'off', form.querySelector('input'))

    const addImage = (e) => {
        e.preventDefault()

        fetch(form.action, {
            body: new FormData(form),
            method: 'POST'
        })
            .then(r => r.json())
            .then(json => {
                handleResponse(json)
            })
    }

    form.addEventListener('change', addImage)
})