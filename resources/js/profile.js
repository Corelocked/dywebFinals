document.addEventListener('DOMContentLoaded', function() {
    const modal = document.querySelector('.modal');
    const profilePanel = modal.querySelector('.modal-profile');
    const notificationsPanel = modal.querySelector('.modal-notifications');

    // Open notifications panel when bell is clicked
    document.querySelectorAll('.open-user-panel').forEach(function(el) {
    el.addEventListener('click', function(e) {
        e.preventDefault?.();
        modal.style.display = 'flex';
        profilePanel.classList.add("hidden");
        notificationsPanel.classList.remove("hidden");
        readNotifications();
    });
});

    // Open user panel when profile is clicked
    document.querySelectorAll('.open-profile-panel').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault?.();
            modal.style.display = 'flex';
            profilePanel.classList.remove("hidden");
            notificationsPanel.classList.add("hidden");
        });
    });

    // Close modal when clicking the close button
    document.querySelectorAll('.close-modal').forEach(function(btn) {
        btn.addEventListener('click', function() {
            modal.style.display = 'none';
            profilePanel.classList.add("hidden");
            notificationsPanel.classList.add("hidden");
        });
    });

    // Close modal when clicking outside the panels
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            profilePanel.classList.add("hidden");
            notificationsPanel.classList.add("hidden");
        }
    });

    // Hide both panels by default on page load
    modal.style.display = 'none';
    profilePanel.classList.add("hidden");
    notificationsPanel.classList.add("hidden");

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

    // Back button in notifications panel
    document.querySelectorAll('.modal-notifications .back').forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Hide notifications, show user panel
            notificationsPanel.classList.add("hidden");
            profilePanel.classList.remove("hidden");
        });
    });

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
