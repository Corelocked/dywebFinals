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
    
    // Check if Quill editor is available and initialized
    let body = '<p><br></p>';
    const quilleditor = document.querySelector(".ql-editor");
    if (quilleditor && window.quill) {
        body = quilleditor.innerHTML;
    }
    
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

        // Check if there's a file to upload
        const hasFile = imageInput && imageInput.files && imageInput.files.length > 0;

        // Show upload progress if file is being uploaded and this is a form submission (not auto-save)
        if (hasFile && submit) {
            const saveButton = document.querySelector('button[type="submit"]') || document.querySelector('.save-button');
            if (saveButton) {
                // Show a simple loading state on the button instead of the large overlay
                const originalText = saveButton.textContent;
                saveButton.textContent = 'Saving...';
                saveButton.disabled = true;
                
                // Store the original text for later restoration
                saveButton.setAttribute('data-original-text', originalText);
            }
        }

        // Only include the image file for actual submissions, not auto-saves
        // Auto-saves will preserve the existing image path from saved posts
        if (hasFile && submit) {
            form.append('image', imageInput.files[0]);
            console.log('Including image file in submission:', imageInput.files[0].name);
        } else if (hasFile && !submit) {
            // For auto-save with a new file, we still need to include it to save the uploaded image
            form.append('image', imageInput.files[0]);
            console.log('Including image file in auto-save:', imageInput.files[0].name);
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
            // Restore button state if it was modified
            const saveButton = document.querySelector('button[type="submit"]') || document.querySelector('.save-button');
            if (saveButton && saveButton.hasAttribute('data-original-text')) {
                saveButton.textContent = saveButton.getAttribute('data-original-text');
                saveButton.disabled = false;
                saveButton.removeAttribute('data-original-text');
            }
            
            Toast.fire({
                icon: 'success',
                title: 'Saved!'
            });
            if(id === 0) {
                redirectToNewUrl(data);
            }
        })
        .catch(error => {
            // Restore button state if it was modified
            const saveButton = document.querySelector('button[type="submit"]') || document.querySelector('.save-button');
            if (saveButton && saveButton.hasAttribute('data-original-text')) {
                saveButton.textContent = saveButton.getAttribute('data-original-text');
                saveButton.disabled = false;
                saveButton.removeAttribute('data-original-text');
            }
            
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
    
    // Debug: Check if image file is still present before submission
    const imageInput = document.querySelector('input[type="file"][name="image"]');
    if (imageInput && imageInput.files && imageInput.files.length > 0) {
        console.log('Image file present at submission:', imageInput.files[0].name);
    } else {
        console.log('No image file present at submission');
    }
    
    document.getElementById('form').submit();
}

document.getElementById('image').addEventListener('change', function(event) {
    if (event.target.files && event.target.files[0]) {
        const file = event.target.files[0];
        const outputImg = document.getElementById('output');
        
        if (outputImg) {
            // Show a simple loading state on the image itself
            outputImg.style.opacity = '0.5';
            outputImg.style.filter = 'blur(2px)';
        }
        
        // Read file for preview
        var reader = new FileReader();
        reader.onload = function(e) {
            // Set the preview image
            if (outputImg) {
                outputImg.src = e.target.result;
                outputImg.style.opacity = '1';
                outputImg.style.filter = 'none';
                outputImg.classList.add('image-preview-loading');
                
                // Remove loading class after image loads
                outputImg.onload = function() {
                    outputImg.classList.remove('image-preview-loading');
                };
            }
        };
        
        reader.onerror = function() {
            // Reset image state on error
            if (outputImg) {
                outputImg.style.opacity = '1';
                outputImg.style.filter = 'none';
            }
            console.error('Failed to load image');
        };
        
        reader.readAsDataURL(file);
    }
});
