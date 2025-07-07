document.addEventListener('DOMContentLoaded', function() {
    // Check if already initialized
    if (window.profileJsInitialized) {
        return;
    }
    window.profileJsInitialized = true;
    
    // Global variable to track notification read status
    let sentReadNotifications = false;
    
    // Wait a bit for all elements to be rendered
    setTimeout(() => {
        initializeModal();
    }, 100);
    
    function initializeModal() {
        // Track modal state
        let modalIsOpen = false;
        
        const modal = document.querySelector('.modal');
        
        // Check if modal exists before proceeding
        if (!modal) {
            return;
        }
        
        const profilePanel = modal.querySelector('.modal-profile');
        const notificationsPanel = modal.querySelector('.modal-notifications');
        
        // Check if at least one panel exists
        if (!profilePanel && !notificationsPanel) {
            return;
        }

        // Initialize panels as hidden with explicit state
        modal.style.display = 'none';
        modal.style.visibility = 'hidden';
        modal.classList.remove('show');
        
        // Set initial panel states with both classes and inline styles
        if (profilePanel) {
            profilePanel.classList.add("hidden");
            profilePanel.style.display = 'none';
        }
        if (notificationsPanel) {
            notificationsPanel.classList.add("hidden");
            notificationsPanel.style.display = 'none';
        }
        
        console.log('Modal initialized with all panels hidden');
        
        // Force immediate application of styles
        void modal.offsetHeight;

        // Helper function to show modal with specific panel
        function showModal(panelToShow) {
            console.log('ShowModal called with panel:', panelToShow?.className);
            
            // Safety check
            if (!panelToShow) {
                console.error('Invalid panel provided to showModal');
                return;
            }
            
            // Check if modal is already open with the same panel
            if (modalIsOpen && !panelToShow.classList.contains('hidden')) {
                console.log('Modal already open with same panel, ignoring');
                return;
            }
            
            // Set modal state
            modalIsOpen = true;
            
            // FORCE hide ALL panels first with explicit visibility and display
            if (profilePanel) {
                profilePanel.classList.add("hidden");
                profilePanel.style.display = 'none';
            }
            if (notificationsPanel) {
                notificationsPanel.classList.add("hidden");
                notificationsPanel.style.display = 'none';
            }
            
            console.log('All panels hidden, showing modal...');
            
            // Force reflow to ensure the hidden state is applied
            void modal.offsetHeight;
            
            // Show the modal backdrop
            modal.style.display = 'flex';
            modal.style.visibility = 'visible';
            
            // Show only the target panel after ensuring others are hidden
            setTimeout(() => {
                // Double-check that other panels are still hidden
                if (profilePanel && profilePanel !== panelToShow) {
                    profilePanel.classList.add("hidden");
                    profilePanel.style.display = 'none';
                }
                if (notificationsPanel && notificationsPanel !== panelToShow) {
                    notificationsPanel.classList.add("hidden");
                    notificationsPanel.style.display = 'none';
                }
                
                // Show the target panel
                panelToShow.classList.remove("hidden");
                panelToShow.style.display = 'block';
                
                console.log('Panel shown:', {
                    targetPanel: panelToShow.className,
                    profileHidden: profilePanel ? profilePanel.classList.contains('hidden') : 'N/A',
                    notificationsHidden: notificationsPanel ? notificationsPanel.classList.contains('hidden') : 'N/A',
                    profileDisplay: profilePanel ? profilePanel.style.display : 'N/A',
                    notificationsDisplay: notificationsPanel ? notificationsPanel.style.display : 'N/A'
                });
                
                // Add show class for animation
                modal.classList.add('show');
            }, 50);
        }

        // Helper function to hide modal
        function hideModal() {
            console.log('HideModal called');
            
            if (!modalIsOpen) {
                console.log('Modal already closed');
                return;
            }
            
            modalIsOpen = false;
            modal.classList.remove('show');
            
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.visibility = 'hidden';
                
                // Reset both classes and inline styles for panels
                if (profilePanel) {
                    profilePanel.classList.add("hidden");
                    profilePanel.style.display = 'none';
                }
                if (notificationsPanel) {
                    notificationsPanel.classList.add("hidden");
                    notificationsPanel.style.display = 'none';
                }
                
                console.log('Modal fully hidden and reset');
            }, 300);
        }

        // Find trigger elements
        const notificationTriggers = document.querySelectorAll('.open-user-panel');
        const profileTriggers = document.querySelectorAll('.open-profile-panel');

        // Open notifications panel when bell is clicked
        notificationTriggers.forEach(function(el) {
            // Check if already has event listener
            if (el.hasAttribute('data-profile-js-bound')) {
                return;
            }
            el.setAttribute('data-profile-js-bound', 'true');
            
            el.addEventListener('click', function(e) {
                e.preventDefault();
                try {
                    // Show notifications panel if it exists, otherwise show profile panel as fallback
                    if (notificationsPanel) {
                        showModal(notificationsPanel);
                        if (typeof readNotifications === 'function') {
                            readNotifications();
                        }
                    } else if (profilePanel) {
                        showModal(profilePanel);
                    }
                } catch (error) {
                    console.error('Profile.js: Error opening notifications panel:', error);
                }
            });
        });

        // Open user panel when profile is clicked
        profileTriggers.forEach(function(el) {
            // Check if already has event listener
            if (el.hasAttribute('data-profile-js-bound')) {
                return;
            }
            el.setAttribute('data-profile-js-bound', 'true');
            
            el.addEventListener('click', function(e) {
                e.preventDefault();
                try {
                    if (profilePanel) {
                        showModal(profilePanel);
                    }
                } catch (error) {
                    console.error('Profile.js: Error opening profile panel:', error);
                }
            });
        });

        // Close modal when clicking the close button
        document.querySelectorAll('.close-modal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                hideModal();
            });
        });

        // Close modal when clicking outside the panels
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });

        // Keyboard escape key support
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modalIsOpen) {
                hideModal();
            }
        });

        // Back button in notifications panel (if it exists)
        document.querySelectorAll('.modal-notifications .back').forEach(function(btn) {
            btn.addEventListener('click', function() {
                console.log('Back button clicked - switching to profile panel');
                // Switch to profile panel using the helper function
                if (profilePanel) {
                    showModal(profilePanel);
                }
            });
        });

        // Notification badge in profile panel - switch to notifications
        document.querySelectorAll('.switch-to-notifications').forEach(function(btn) {
            // Check if already has event listener
            if (btn.hasAttribute('data-profile-js-bound')) {
                return;
            }
            btn.setAttribute('data-profile-js-bound', 'true');
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Notification badge clicked - switching to notifications panel');
                try {
                    // Switch to notifications panel if it exists
                    if (notificationsPanel) {
                        showModal(notificationsPanel);
                        // Mark notifications as read when viewing
                        if (typeof readNotifications === 'function') {
                            readNotifications();
                        }
                    }
                } catch (error) {
                    console.error('Profile.js: Error switching to notifications panel:', error);
                }
            });
        });
    }

    const date = Date.now();

    window.readNotifications = function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (!sentReadNotifications) {
            fetch('/read-notifications', {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    'date': date,
                }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    if (response.status === 200) {
                        sentReadNotifications = true;
                        document.querySelector(".notifications_count").innerHTML = "0";
                        document.querySelector(".modal-profile .notifications").innerHTML = "0 <i class=\"fa-solid fa-angles-right\"></i>";
                    }
                })
                .catch(error => {
                    console.error('An error occurred while processing the request:', error);
                });
        }
    }

    window.clearNotifications = function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const modal = document.querySelector('.modal');
        const notificationsPanel = modal.querySelector('.modal-notifications');
        const notifications = notificationsPanel.querySelectorAll(".notification");
        const dateElements = document.querySelectorAll(".modal-notifications .date");
        fetch('/clear-notifications', {
            method: 'delete',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                if (response.status === 200) {
                    for (const notification of notifications) {
                        notification.remove();
                    }
                    for (const dateElement of dateElements) {
                        dateElement.remove();
                    }
                    const notificationDiv = document.createElement('div');
                    notificationDiv.classList.add('notification', 'action');

                    const paragraph = document.createElement('p');
                    paragraph.classList.add('empty');
                    paragraph.textContent = 'No notifications';
                    notificationDiv.appendChild(paragraph);
                    notificationsPanel.appendChild(notificationDiv);
                }
            })
            .catch(error => {
                console.error('An error occurred while processing the request:', error);
            });
    }

    startTime();
    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        h = checkTime(h);
        document.getElementById('hours').innerHTML = h;
        document.getElementById('minutes').innerHTML = m;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i}
        return i;
    }
});
