let pathString = window.location.pathname;
let pathSegments = pathString.split('/');
let id = pathSegments[pathSegments.length - 2];
let myTimer;

function startTimer() {
    myTimer = setInterval(function() {
        window.savePost(false);
    }, 60000);
}

document.addEventListener("DOMContentLoaded", function() {
    startTimer();
});

// Image upload functionality for edit form
document.getElementById('image').addEventListener('change', function(event) {
    if (event.target.files && event.target.files[0]) {
        const file = event.target.files[0];
        const outputImg = document.getElementById('output');
        
        if (outputImg) {
            // Show a simple loading state on the image itself
            outputImg.style.opacity = '0.7';
        }
        
        // Read file for preview
        var reader = new FileReader();
        reader.onload = function(e) {
            // Set the preview image
            if (outputImg) {
                outputImg.src = e.target.result;
                outputImg.style.opacity = '1';
                console.log('Edit post image preview updated:', file.name);
            }
        };
        
        reader.onerror = function() {
            // Reset image state on error
            if (outputImg) {
                outputImg.style.opacity = '1';
            }
            console.error('Failed to load image preview');
        };
        
        reader.readAsDataURL(file);
    }
});

window.detectedAutoSave = function () {
    clearInterval(myTimer);
    Swal.fire({
        title: 'Auto-save detected!',
        text: "Do you want to load the save or reject it?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Load',
        cancelButtonText: 'Reject',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            loadAutoSave();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            rejectAutoSave();
        }
        startTimer();
    })
}

window.savePost = function(submit = false) {
    let title = document.querySelector('input[name=title]').value,
        excerpt = document.querySelector('textarea[name=excerpt]').value,
        body = document.querySelector(".ql-editor").innerHTML,
        image = document.querySelector('input[name=image]'),
        is_published = document.querySelector('input[name=is_published]').checked ? 'on' : null,
        category = parseInt(document.querySelector('input[name=category_id]').value),
        token = document.querySelector('input[name=_token]').value;

    // Check if there's a file to upload
    const hasFile = image && image.files && image.files.length > 0;

    // Show upload progress if file is being uploaded and submitting
    if (hasFile && submit) {
        const saveButton = document.querySelector('button[type="submit"]') || document.querySelector('.save-button');
        if (saveButton) {
            // Show a simple loading state on the button instead of the large overlay
            const originalText = saveButton.textContent;
            saveButton.textContent = 'Updating...';
            saveButton.disabled = true;
            
            // Store the original text for later restoration
            saveButton.setAttribute('data-original-text', originalText);
        }
    }

    let form = new FormData();
    form.append('title', title);
    form.append('excerpt', excerpt);
    form.append('body', body);
    // Always include image if selected, whether submitting or auto-saving
    if (hasFile) {
        form.append('image', image.files[0]);
    }
    form.append('is_published', is_published);
    form.append('category_id', category);
    form.append('_token', token);
    form.append('_method', 'PUT');

    fetch("/dashboard/posts/" + id, {
        method: "POST",
        body: form,
        headers: {
            'Accept': 'application/json',
            'enctype': 'multipart/form-data',
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
            // Restore button state if it was modified
            const saveButton = document.querySelector('button[type="submit"]') || document.querySelector('.save-button');
            if (saveButton && saveButton.hasAttribute('data-original-text')) {
                saveButton.textContent = saveButton.getAttribute('data-original-text');
                saveButton.disabled = false;
                saveButton.removeAttribute('data-original-text');
            }
            
            if (image) {
                document.querySelector('input[name=image]').value = null;
            }
            document.querySelector(".post__create .post_options .auto-save-info").innerHTML = '<i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Saved: ' + getCurrentTime();
        })
        .catch(error => {
            // Restore button state if it was modified
            const saveButton = document.querySelector('button[type="submit"]') || document.querySelector('.save-button');
            if (saveButton && saveButton.hasAttribute('data-original-text')) {
                saveButton.textContent = saveButton.getAttribute('data-original-text');
                saveButton.disabled = false;
                saveButton.removeAttribute('data-original-text');
            }
            
            console.error('Fetch Error: ', error.message);
        });
}

function loadAutoSave() {
    fetch('/dashboard/posts/' + id + '/auto-save')
        .then(response => {
            if (!response.ok) {
                Toast.fire({
                    icon: 'error',
                    title: 'Cannot load!'
                })
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const category = document.querySelector(".post__create form .category-selected");
            document.querySelector(".post__create .post_container .info .title").value = data.title;
            document.querySelector("input[name='category_id']").value = data.category_id;
            category.innerHTML = data.category.name;
            category.style.background = data.category.backgroundColor + 'CC';
            category.style.color = data.category.textColor;

            const postInfo = document.querySelector(".post__create .post_container .info .reading-info");
            const readTime = postInfo.querySelector(".reading-info .reading-time");
            const readInfo = postInfo.querySelector(".reading-info");

            if (data.read_time === null) {
                if (readInfo) {
                    readInfo.innerHTML = "";
                }
            }

            if (readTime) {
                readTime.innerHTML = data.read_time + " min";
            } else {
                const readTimeTextElement = document.createElement('p');
                readTimeTextElement.className = 'reading-text';
                readTimeTextElement.textContent = 'Reading time: ';

                const watchIcon = document.createElement('i');
                watchIcon.className = 'fa-solid fa-clock';

                const readTimeElement = document.createElement('p');
                readTimeElement.className = 'reading-time';
                readTimeElement.textContent = data.read_time + ' min';

                postInfo.querySelector(".reading-info").appendChild(readTimeTextElement, watchIcon, readTimeElement);
            }

            document.getElementById('hiddenArea').innerHTML = data.body;
            const quill = window.quill;

            quill.setContents(quill.clipboard.convert(data.body));

            const output = document.querySelector("#output");
            output.src = data.image_path;

            document.querySelector("form textarea[name='excerpt']").value = data.excerpt;

            const visibility = document.querySelector("input[name=is_published]");

            visibility.checked = data.is_published === 1;
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}

function rejectAutoSave() {
    const token = document.querySelector('input[name=_token]').value;
    let form = new FormData();
    form.append('_token', token);
    form.append('_method', 'DELETE');
    fetch("/dashboard/posts/" + id + "/reject", {
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
        })
        .catch(error => {
            console.error('Fetch Error: ', error);
        });
}

function getCurrentTime() {
    const now = new Date();

    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');

    return `${hours}:${minutes}:${seconds}`;
}

window.addEventListener('beforeunload', function (event) {
    if (!window.submitEdit) {
        window.savePost(true);
    }
});
