//Alpinejs
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();


// Handles the email link click event and opens Gmail directly in a new tab if Gmail is likely in 
// use (heuristic: Gmail tab open). Otherwise, it offers options via a simple prompt or defaults to mailto.

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.email-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default anchor behavior
            const email = this.getAttribute('data-email');

            // Gmail compose URL
            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(email)}`;

            // Check if Gmail is likely in use (heuristic: Gmail tab open)
            const isGmailLikely = document.referrer.includes('google.com') || window.location.hostname.includes('google.com');

            if (isGmailLikely) {
                // Open Gmail directly in a new tab
                window.open(gmailUrl, '_blank');
            } else {
                // Fallback: Offer options via a simple prompt or default to mailto
                const useGmail = confirm('Open in Gmail? Click Cancel to use your default email client or another service.');
                if (useGmail) {
                    window.open(gmailUrl, '_blank');
                } else {
                    // Fallback to mailto (default client)
                    window.location.href = `mailto:${email}`;
                }
            }
        });
    });
});

