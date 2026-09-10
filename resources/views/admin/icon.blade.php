@php
    $paths = [
        'grid' => 'M3 3h7v7H3z M14 3h7v7h-7z M3 14h7v7H3z M14 14h7v7h-7z',
        'layout' => 'M3 4h18v16H3z M3 9h18 M8 9v11',
        'image' => 'M3 3h18v18H3z M3 16l5-5 5 5 3-3 5 5 M15 7h.01',
        'images' => 'M7 3h14v14H7z M3 7v14h14 M7 13l4-4 4 4 2-2 4 4',
        'chart' => 'M4 20V10 M12 20V4 M20 20v-7',
        'building' => 'M5 21V3h14v18 M3 21h18 M9 7h1 M14 7h1 M9 11h1 M14 11h1 M10 21v-6h4v6',
        'box' => 'M12 3L3 7.5v9L12 21l9-4.5v-9z M3 7.5l9 4.5 9-4.5 M12 12v9 M7.5 5.25l9 4.5',
        'truck' => 'M3 5h11v12H3z M14 9h4l3 4v4h-7 M7 17a2 2 0 1 0 0 .01 M18 17a2 2 0 1 0 0 .01',
        'pin' => 'M12 21s7-7 7-12a7 7 0 0 0-14 0c0 5 7 12 7 12z M12 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6',
        'steps' => 'M4 5h4v4H4z M12 7h8 M4 15h4v4H4z M12 17h8 M6 9v6',
        'send' => 'M21 3L3 10l7 4 4 7z M10 14L21 3',
        'settings' => 'M4 7h16 M4 17h16 M8 4v6 M16 14v6',
        'inbox' => 'M3 4h18v16H3z M3 13h5l2 3h4l2-3h5',
        'external' => 'M14 3h7v7 M21 3L10 14 M10 3H3v18h18v-7',
        'arrow' => 'M5 12h14 M13 6l6 6-6 6',
        'back' => 'M19 12H5 M11 6l-6 6 6 6',
        'upload' => 'M12 16V3 M7 8l5-5 5 5 M4 15v6h16v-6',
        'check' => 'M5 12l4 4L19 6',
        'plus' => 'M12 5v14 M5 12h14',
        'close' => 'M6 6l12 12 M18 6L6 18',
        'menu' => 'M4 6h16 M4 12h16 M4 18h16',
        'user' => 'M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8 M4 21v-2a8 6 0 0 1 16 0v2',
        'logout' => 'M9 3H3v18h6 M10 12h11 M16 7l5 5-5 5',
        'search' => 'M10 3a7 7 0 1 0 0 14 7 7 0 0 0 0-14 M15 15l6 6',
    ];
@endphp
<svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $paths[$icon] ?? $paths['layout'] }}"/></svg>
