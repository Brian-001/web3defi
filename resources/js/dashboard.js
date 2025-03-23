import Chart from 'chart.js/auto';

// Function to initialize charts when the DOM is ready
function initializeCharts(userStats, listingsPerDay, listingsByJobType) {
    // Users Bar Chart
    const ctxUsers = document.getElementById('usersChart')?.getContext('2d');
    if (ctxUsers) {
        new Chart(ctxUsers, {
            type: 'bar',
            data: {
                labels: Object.keys(userStats),
                datasets: [{
                    label: 'Users',
                    data: Object.values(userStats),
                    backgroundColor: 'rgba(34, 211, 238, 0.6)',
                    borderColor: 'rgba(34, 211, 238, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'User Count', color: '#4B5563' } },
                    x: { title: { display: true, text: 'Roles', color: '#4B5563' } }
                },
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'User Distribution', color: '#1F2937', font: { size: 16 } }
                }
            }
        });
    }

    // Listings Line Chart
    const ctxListings = document.getElementById('listingsChart')?.getContext('2d');
    if (ctxListings) {
        new Chart(ctxListings, {
            type: 'line',
            data: {
                labels: Object.keys(listingsPerDay),
                datasets: [{
                    label: 'Job Listings',
                    data: Object.values(listingsPerDay),
                    borderColor: 'rgba(34, 211, 238, 1)', // Fixed typo: removed "-diff"
                    backgroundColor: 'rgba(34, 211, 238, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(34, 211, 238, 1)',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Listings', color: '#4B5563' } },
                    x: { title: { display: true, text: 'Date (Last 7 Days)', color: '#4B5563' } }
                },
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Jobs Over Time', color: '#1F2937', font: { size: 16 } }
                }
            }
        });
    }

    // Job Type Pie Chart
    const ctxJobType = document.getElementById('jobTypeChart')?.getContext('2d');
    if (ctxJobType) {
        new Chart(ctxJobType, {
            type: 'pie',
            data: {
                labels: Object.keys(listingsByJobType),
                datasets: [{
                    label: 'Job Types',
                    data: Object.values(listingsByJobType),
                    backgroundColor: [
                        'rgba(34, 211, 238, 0.6)',
                        'rgba(16, 185, 129, 0.6)',
                        'rgba(59, 130, 246, 0.6)',
                    ],
                    borderColor: [
                        'rgba(34, 211, 238, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(59, 130, 246, 1)',
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#4B5563' } },
                    title: { display: true, text: 'Job Categories', color: '#1F2937', font: { size: 16 } }
                }
            }
        });
    }
}

// Expose the function globally or initialize it with data from Laravel
document.addEventListener('DOMContentLoaded', () => {
    // Get data from a global variable set by Laravel
    const userStats = window.userStats || {};
    const listingsPerDay = window.listingsPerDay || {};
    const listingsByJobType = window.listingsByJobType || {};
    
    initializeCharts(userStats, listingsPerDay, listingsByJobType);
});

// Handle Livewire updates
document.addEventListener('livewire:load', () => {
    // Reinitialize charts after Livewire updates if needed
    Livewire.hook('message.processed', () => {
        const userStats = window.userStats || {};
        const listingsPerDay = window.listingsPerDay || {};
        const listingsByJobType = window.listingsByJobType || {};
        initializeCharts(userStats, listingsPerDay, listingsByJobType);
    });
});