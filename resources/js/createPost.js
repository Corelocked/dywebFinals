const Toast = Swal.mixin({
    toast: true,
    position: 'bottom',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

setInterval(() => {
    savePost(false);
}, 60000);

window.savePost = function(submit = false){
    const title = document.querySelector('input[name=title]').value;
    const excerpt = document.querySelector('textarea[name=excerpt]').value;
    const body = document.querySelector(".ql-editor").innerHTML;
    const imageInput = document.querySelector('input[type="file"][name="image"]');
    const is_published = document.querySelector('input[name=is_published]').checked ? 'on' : null;
    const category = parseInt(document.querySelector('input[name=category_id]').value);
    const token = document.querySelector('input[name=_token]').value;
    const id = parseInt(document.querySelector('input[name=id_saved_post]').value);

    if(title !== '' || excerpt !== '' || body !== '<p><br></p>'){
        let form = new FormData();
        form.append('title', title);
        form.append('excerpt', excerpt);
        form.append('body', body);

        // Only append the file if a file is selected
        if (imageInput && imageInput.files && imageInput.files.length > 0) {
            form.append('image', imageInput.files[0]);
        }

        form.append('is_published', is_published);
        form.append('category_id', category);
        form.append('_token', token);

        if(id !== 0){
            form.append('_method', 'PATCH');
        }

        fetch("/dashboard/posts-saved" + (id ? '/' + id : ''), {
            method: "POST",
            body: form,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Toast.fire({
                icon: 'success',
                title: 'Saved!'
            });
            if(id === 0) {
                redirectToNewUrl(data);
            }
        })
        .catch(error => {
            Toast.fire({
                icon: 'error',
                title: 'Not saved!'
            });
            console.error('Fetch Error: ', error);
        });
    }
}

function redirectToNewUrl(data) {
    document.querySelector('input[name=id_saved_post]').value = data.id;
    const newUrl = "/dashboard/posts/create?edit=" + data.id;
    history.pushState(null, null, newUrl);
}

window.addEventListener('beforeunload', function (event) {
    if (!window.submitEdit) {
        window.savePost(true);
    }
});

quill.on('text-change', function() {
    document.getElementById('hiddenArea').value = quill.root.innerHTML;
});

function submitForm() {
    document.getElementById('hiddenArea').value = quill.root.innerHTML;
    document.getElementById('form').submit();
}

document.getElementById('image').addEventListener('change', function(event) {
    if (event.target.files && event.target.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('output').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
});
