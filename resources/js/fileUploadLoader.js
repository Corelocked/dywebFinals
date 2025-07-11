// File Upload Loading Preview
class FileUploadLoader {
    constructor(options = {}) {
        this.options = {
            container: null,
            compact: false,
            showFileName: true,
            showFileSize: true,
            allowCancel: true,
            ...options
        };
        
        this.loadingElement = null;
        this.progressCircle = null;
        this.progressText = null;
        this.statusText = null;
        this.fileInfo = null;
        this.cancelBtn = null;
        this.currentXHR = null;
    }

    // Create the loading preview HTML
    createLoadingElement() {
        const loadingHtml = `
            <div class="file-upload-loading ${this.options.compact ? 'compact' : ''}">
                <div class="upload-progress-circle">
                    <svg viewBox="0 0 60 60">
                        <circle class="progress-bg" cx="30" cy="30" r="26"></circle>
                        <circle class="progress-bar" cx="30" cy="30" r="26"></circle>
                    </svg>
                    <div class="upload-progress-text">0%</div>
                </div>
                <div class="upload-status-text">Uploading...</div>
                ${this.options.showFileName || this.options.showFileSize ? '<div class="upload-file-info"></div>' : ''}
                ${this.options.allowCancel ? '<button class="upload-cancel-btn">Cancel</button>' : ''}
            </div>
        `;

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = loadingHtml;
        this.loadingElement = tempDiv.firstElementChild;

        // Get references to elements
        this.progressCircle = this.loadingElement.querySelector('.upload-progress-circle');
        this.progressBar = this.loadingElement.querySelector('.progress-bar');
        this.progressText = this.loadingElement.querySelector('.upload-progress-text');
        this.statusText = this.loadingElement.querySelector('.upload-status-text');
        this.fileInfo = this.loadingElement.querySelector('.upload-file-info');
        this.cancelBtn = this.loadingElement.querySelector('.upload-cancel-btn');

        // Add cancel functionality
        if (this.cancelBtn) {
            this.cancelBtn.addEventListener('click', () => this.cancel());
        }

        return this.loadingElement;
    }

    // Show the loading preview
    show(container, file = null) {
        if (!this.loadingElement) {
            this.createLoadingElement();
        }

        const targetContainer = container || this.options.container;
        if (!targetContainer) {
            console.error('No container provided for file upload loader');
            return;
        }

        // Set file information
        if (file && this.fileInfo) {
            let fileInfoText = '';
            if (this.options.showFileName) {
                fileInfoText += file.name;
            }
            if (this.options.showFileSize) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                fileInfoText += this.options.showFileName ? ` (${sizeMB} MB)` : `${sizeMB} MB`;
            }
            this.fileInfo.textContent = fileInfoText;
        }

        // Position the loading element
        if (targetContainer.style.position === '' || targetContainer.style.position === 'static') {
            targetContainer.style.position = 'relative';
        }

        targetContainer.appendChild(this.loadingElement);
        
        // Trigger the show animation
        setTimeout(() => {
            this.loadingElement.classList.add('active');
        }, 10);
    }

    // Update progress
    updateProgress(percent) {
        if (!this.progressBar || !this.progressText) return;

        const circumference = this.options.compact ? 100.53 : 163.36; // 2 * π * radius
        const offset = circumference - (percent / 100) * circumference;
        
        this.progressBar.style.strokeDashoffset = offset;
        this.progressText.textContent = `${Math.round(percent)}%`;

        // Remove indeterminate class if it exists
        this.progressCircle.classList.remove('indeterminate');
    }

    // Set indeterminate state
    setIndeterminate() {
        if (this.progressCircle) {
            this.progressCircle.classList.add('indeterminate');
            this.progressText.textContent = '...';
        }
    }

    // Update status text
    updateStatus(text) {
        if (this.statusText) {
            this.statusText.textContent = text;
        }
    }

    // Show success state
    showSuccess(message = 'Upload completed!') {
        this.loadingElement.classList.add('success');
        this.updateProgress(100);
        this.updateStatus(message);
        
        // Auto-hide after shorter delay to avoid blocking scrolling
        setTimeout(() => this.hide(), 1500);
    }

    // Show error state
    showError(message = 'Upload failed!') {
        this.loadingElement.classList.add('error');
        this.updateStatus(message);
        this.progressText.textContent = '!';
        
        // Auto-hide after shorter delay to avoid blocking scrolling
        setTimeout(() => this.hide(), 2500);
    }

    // Cancel upload
    cancel() {
        if (this.currentXHR) {
            this.currentXHR.abort();
        }
        this.updateStatus('Cancelled');
        setTimeout(() => this.hide(), 1000);
    }

    // Hide the loading preview
    hide() {
        if (this.loadingElement) {
            this.loadingElement.classList.remove('active');
            setTimeout(() => {
                if (this.loadingElement && this.loadingElement.parentNode) {
                    this.loadingElement.parentNode.removeChild(this.loadingElement);
                }
                this.reset();
            }, 300);
        }
    }

    // Reset states
    reset() {
        if (this.loadingElement) {
            this.loadingElement.classList.remove('success', 'error');
        }
        this.currentXHR = null;
    }

    // Upload file with progress tracking
    uploadFile(file, url, options = {}) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            this.currentXHR = xhr;
            
            const formData = new FormData();
            formData.append(options.fieldName || 'file', file);
            
            // Add additional form data
            if (options.additionalData) {
                Object.keys(options.additionalData).forEach(key => {
                    formData.append(key, options.additionalData[key]);
                });
            }

            // Progress tracking
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = (e.loaded / e.total) * 100;
                    this.updateProgress(percent);
                }
            });

            // Success handler
            xhr.addEventListener('load', () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        this.showSuccess();
                        resolve(response);
                    } catch (error) {
                        this.showSuccess();
                        resolve(xhr.responseText);
                    }
                } else {
                    this.showError(`Upload failed (${xhr.status})`);
                    reject(new Error(`HTTP ${xhr.status}: ${xhr.statusText}`));
                }
            });

            // Error handler
            xhr.addEventListener('error', () => {
                this.showError('Network error');
                reject(new Error('Network error occurred'));
            });

            // Abort handler
            xhr.addEventListener('abort', () => {
                this.updateStatus('Cancelled');
                reject(new Error('Upload cancelled'));
            });

            // Start upload
            xhr.open('POST', url);
            
            // Add headers
            if (options.headers) {
                Object.keys(options.headers).forEach(key => {
                    xhr.setRequestHeader(key, options.headers[key]);
                });
            }

            // Add CSRF token if available
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.getAttribute('content'));
            }

            this.updateStatus('Uploading...');
            this.setIndeterminate();
            xhr.send(formData);
        });
    }
}

// Helper function to create a simple file upload loader
window.createFileUploadLoader = function(options = {}) {
    return new FileUploadLoader(options);
};

// Helper function for quick file upload with progress
window.uploadFileWithProgress = function(file, container, url, options = {}) {
    const loader = new FileUploadLoader({
        container: container,
        compact: options.compact || false,
        allowCancel: options.allowCancel !== false
    });
    
    loader.show(container, file);
    
    return loader.uploadFile(file, url, options)
        .finally(() => {
            // Clean up after a delay
            setTimeout(() => loader.hide(), 1000);
        });
};

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FileUploadLoader;
}
