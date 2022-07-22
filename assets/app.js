// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// import bootstrap
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min'

// comment reply
document.querySelectorAll("[data-reply]").forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault()

        const parentId = document.getElementById('comment_parent_id')
        parentId.value = this.dataset.id

        const form = document.querySelector('.comment-form')
        this.after(form)

        console.log('ok')
    })
})