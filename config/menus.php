<?php

return [

    'admin' => [
        [
            'title' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon'  => 'fas fa-tachometer-alt',
        ],
        [
            'title' => 'Manage Users',
            'route' => 'admin.users.index',
            'icon'  => 'fas fa-users-cog',
        ],
        [
            'title' => 'Analytics',
            'route' => 'admin.analytics',
            'icon'  => 'fas fa-chart-line',
        ],
        [
            'title' => 'Activity Logs',
            'route' => 'admin.activity_logs.index',
            'icon'  => 'fas fa-file-alt',
        ],
        [
            'title' => 'Notifications',
            'route' => 'notifications.index',
            'icon'  => 'fas fa-bell',
        ],
        [
            'title' => 'Messages',
            'route' => 'messages.index',
            'icon'  => 'fas fa-envelope',
        ],
        [
            'title' => 'Settings',
            'route' => 'settings.index',
            'icon'  => 'fas fa-cogs',
        ],
    ],

    'barangay_staff' => [
        [
            'title' => 'Dashboard',
            'route' => 'barangay.dashboard',
            'icon'  => 'fas fa-tachometer-alt',
        ],
        [
            'title' => 'Manage Referrals',
            'route' => 'barangay.referrals.index',
            'icon'  => 'fas fa-file-medical',
        ],
        [
            'title' => 'Manage Appointments',
            'route' => 'barangay.appointments.index',
            'icon'  => 'fas fa-calendar-alt',
        ],
        [
            'title' => 'Notifications',
            'route' => 'notifications.index',
            'icon'  => 'fas fa-bell',
        ],
        [
            'title' => 'Messages',
            'route' => 'messages.index',
            'icon'  => 'fas fa-envelope',
        ],
    ],

    'regional_staff' => [
        [
            'title' => 'Dashboard',
            'route' => 'regional.dashboard',
            'icon'  => 'fas fa-tachometer-alt',
        ],
        [
            'title' => 'Manage Referrals',
            'route' => 'regional.referrals.index',
            'icon'  => 'fas fa-file-medical',
        ],
        [
            'title' => 'Manage Appointments',
            'route' => 'regional.appointments.index',
            'icon'  => 'fas fa-calendar-alt',
        ],
        [
            'title' => 'View Map',
            'route' => 'regional.map.index',
            'icon'  => 'fas fa-map-marked-alt',
        ],
        [
            'title' => 'Notifications',
            'route' => 'notifications.index',
            'icon'  => 'fas fa-bell',
        ],
        [
            'title' => 'Messages',
            'route' => 'messages.index',
            'icon'  => 'fas fa-envelope',
        ],
    ],

    'patient' => [
        [
            'title' => 'Dashboard',
            'route' => 'patient.dashboard',
            'icon'  => 'fas fa-tachometer-alt',
        ],
        [
            'title' => 'My Referrals',
            'route' => 'patient.referrals.index',
            'icon'  => 'fas fa-file-medical',
        ],
        [
            'title' => 'My Appointments',
            'route' => 'patient.appointments.index',
            'icon'  => 'fas fa-calendar-alt',
        ],
        [
            'title' => 'Payments',
            'route' => 'payments.process',
            'icon'  => 'fas fa-credit-card',
        ],
        [
            'title' => 'Notifications',
            'route' => 'notifications.index',
            'icon'  => 'fas fa-bell',
        ],
        [
            'title' => 'Messages',
            'route' => 'messages.index',
            'icon'  => 'fas fa-envelope',
        ],
    ],

];