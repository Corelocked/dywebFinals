// Multiple DOM ready detection methods for better compatibility
function domReady(fn) {
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(fn, 1);
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

domReady(function() {
    console.log('Profile.js: DOM ready, starting initialization...');
    
    // Check if already initialized
    if (window.profileJsInitialized) {
        console.log('Profile.js: Already initialized, skipping...');
        return;
    }
    window.profileJsInitialized = true;
    
    // Global variable to track notification read status
    let sentReadNotifications = false;
    
    // Wait a bit for all elements to be rendered, with multiple retries
    let retryCount = 0;
    const maxRetries = 5;
    
    function tryInitialize() {
        const modal = document.querySelector('.modal');
        console.log('Profile.js: Attempt', retryCount + 1, 'to find modal element');
        
        if (modal || retryCount >= maxRetries) {
            if (modal) {
                console.log('Profile.js: Modal found, initializing...');
            } else {
                console.warn('Profile.js: Modal not found after', maxRetries, 'attempts. User panel and notifications will not work.');
            }
            initializeModal();
        } else {
            retryCount++;
            setTimeout(tryInitialize, 200 * retryCount); // Exponential backoff
        }
    }
    
    tryInitialize();
    
    function initializeModal() {
        // Track modal state
        let modalIsOpen = false;
        
        const modal = document.querySelector('.modal');
        
        // Check if modal exists before proceeding
        if (!modal) {
            console.warn('Profile.js: Modal element not found. User panel and notifications will not work.');
            return;
        }
        
        console.log('Profile.js: Modal element found, setting up panels...');
        
        const profilePanel = modal.querySelector('.modal-profile');
        const notificationsPanel = modal.querySelector('.modal-notifications');
        
        // Check if at least one panel exists
        if (!profilePanel && !notificationsPanel) {
            console.warn('Profile.js: No valid panels found in modal. User panel and notifications will not work.');
            return;
        }
        
        console.log('Profile.js: Panels found -', {
            profile: !!profilePanel,
            notifications: !!notificationsPanel
        });

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
                 console.log('Profile.js: All panels hidden, showing modal...');
        
        // Also check for the authentication state
        const authUser = document.querySelector('meta[name="csrf-token"]');
        console.log('Profile.js: User authenticated (CSRF token exists):', !!authUser);
        
        // Force reflow to ensure the hidden state is applied
        void modal.offsetHeight;
            
            // Show the modal backdrop
            modal.style.display = 'block';
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
        
        console.log('Profile.js: Trigger elements found -', {
            notificationTriggers: notificationTriggers.length,
            profileTriggers: profileTriggers.length
        });
        
        if (notificationTriggers.length === 0 && profileTriggers.length === 0) {
            console.warn('Profile.js: No trigger elements found. User panel and notifications will not be accessible.');
        }

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
        try {
            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenElement) {
                console.error('Profile.js: CSRF token not found');
                return;
            }
            
            const csrfToken = csrfTokenElement.getAttribute('content');
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
                            
                            // Safely update notification count elements
                            const notificationCountElement = document.querySelector(".notification-badge");
                            if (notificationCountElement) {
                                notificationCountElement.innerHTML = "0";
                            }
                            
                            const profileNotificationElement = document.querySelector(".modal-profile .notifications");
                            if (profileNotificationElement) {
                                profileNotificationElement.innerHTML = "0 <i class=\"fa-solid fa-angles-right\"></i>";
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Profile.js: Error while processing read notifications request:', error);
                    });
            }
        } catch (error) {
            console.error('Profile.js: Error in readNotifications function:', error);
        }
    }

    window.clearNotifications = function () {
        try {
            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenElement) {
                console.error('Profile.js: CSRF token not found');
                return;
            }
            
            const csrfToken = csrfTokenElement.getAttribute('content');
            const modal = document.querySelector('.modal');
            
            if (!modal) {
                console.error('Profile.js: Modal not found');
                return;
            }
            
            const notificationsPanel = modal.querySelector('.modal-notifications');
            
            if (!notificationsPanel) {
                console.error('Profile.js: Notifications panel not found');
                return;
            }
            
            const notifications = notificationsPanel.querySelectorAll(".notification");
            const dateElements = notificationsPanel.querySelectorAll(".date");
            
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
                    console.error('Profile.js: Error occurred while clearing notifications:', error);
                });
        } catch (error) {
            console.error('Profile.js: Error in clearNotifications function:', error);
        }
    }

    startTime();
    function startTime() {
        try {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            h = checkTime(h);
            
            const hoursElement = document.getElementById('hours');
            const minutesElement = document.getElementById('minutes');
            
            if (hoursElement) {
                hoursElement.innerHTML = h;
            }
            if (minutesElement) {
                minutesElement.innerHTML = m;
            }
            
            setTimeout(startTime, 1000);
        } catch (error) {
            console.error('Profile.js: Error in startTime function:', error);
        }
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i}
        return i;
    }
});
