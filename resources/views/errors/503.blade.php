<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Under Maintenance — GraveSpace</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700,800&display=swap" rel="stylesheet" />

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            :root {
                --primary: #0a0a0f;
                --surface: #12121a;
                --elevated: #1a1a2e;
                --border: #2a2a3e;
                --text: #f5f5f0;
                --text-muted: #8a8a9a;
                --accent: #c9a84c;
                --accent-hover: #dbb85c;
            }

            body {
                font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
                background-color: var(--primary);
                color: var(--text);
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .header {
                background-color: rgba(18, 18, 26, 0.8);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid var(--border);
            }

            .header-inner {
                max-width: 80rem;
                margin: 0 auto;
                padding: 0 1rem;
                display: flex;
                align-items: center;
                height: 4rem;
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                text-decoration: none;
                color: var(--text);
            }

            .logo-icon {
                color: var(--accent);
                font-size: 1.5rem;
                line-height: 1;
            }

            .logo-text {
                font-family: 'Playfair Display', ui-serif, Georgia, serif;
                font-size: 1.25rem;
                font-weight: 700;
            }

            .content {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
            }

            .content-inner {
                text-align: center;
                max-width: 32rem;
                margin: 0 auto;
                animation: fadeIn 0.6s ease-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .icon-wrapper {
                margin-bottom: 2rem;
            }

            .maintenance-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 5rem;
                height: 5rem;
                border-radius: 50%;
                background-color: rgba(201, 168, 76, 0.1);
                border: 1px solid rgba(201, 168, 76, 0.2);
            }

            .maintenance-icon svg {
                width: 2.5rem;
                height: 2.5rem;
                color: var(--accent);
            }

            .error-code {
                color: var(--accent);
                font-weight: 600;
                font-size: 0.875rem;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                margin-bottom: 0.75rem;
            }

            h1 {
                font-family: 'Playfair Display', ui-serif, Georgia, serif;
                font-size: clamp(1.875rem, 4vw, 3rem);
                font-weight: 700;
                color: var(--text);
                margin-bottom: 1rem;
                line-height: 1.2;
            }

            .message {
                color: var(--text-muted);
                font-size: 1.125rem;
                line-height: 1.75;
                margin-bottom: 2.5rem;
                max-width: 28rem;
                margin-left: auto;
                margin-right: auto;
            }

            .progress-bar-wrapper {
                max-width: 16rem;
                margin: 0 auto 2rem;
                height: 4px;
                background-color: var(--elevated);
                border-radius: 9999px;
                overflow: hidden;
            }

            .progress-bar {
                height: 100%;
                width: 30%;
                background-color: var(--accent);
                border-radius: 9999px;
                animation: progress 2s ease-in-out infinite;
            }

            @keyframes progress {
                0% { transform: translateX(-100%); width: 30%; }
                50% { width: 50%; }
                100% { transform: translateX(400%); width: 30%; }
            }

            .status-note {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.25rem;
                background-color: var(--surface);
                border: 1px solid var(--border);
                border-radius: 0.5rem;
                color: var(--text-muted);
                font-size: 0.875rem;
            }

            .status-dot {
                width: 0.5rem;
                height: 0.5rem;
                background-color: var(--accent);
                border-radius: 50%;
                animation: pulse 2s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.4; }
            }

            .footer {
                border-top: 1px solid var(--border);
                padding: 1.5rem 1rem;
                text-align: center;
                font-size: 0.75rem;
                color: var(--text-muted);
            }

            @media (min-width: 640px) {
                .header-inner { padding: 0 1.5rem; }
            }

            @media (min-width: 1024px) {
                .header-inner { padding: 0 2rem; }
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header class="header">
            <div class="header-inner">
                <a href="/" class="logo">
                    <span class="logo-icon">&#x1F56F;</span>
                    <span class="logo-text">GraveSpace</span>
                </a>
            </div>
        </header>

        <!-- Content -->
        <main class="content">
            <div class="content-inner">
                <!-- Maintenance icon -->
                <div class="icon-wrapper">
                    <div class="maintenance-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.42 15.17l-5.384-3.19A2.625 2.625 0 003 14.07v.818c0 .527.21 1.033.586 1.406l5.088 5.088a1.875 1.875 0 002.652 0l5.088-5.088c.375-.373.586-.879.586-1.406v-.818a2.625 2.625 0 00-3.036-2.09l-5.384 3.19zm0 0l3.168-1.875M12 2.25c-2.54 0-4.822 1.05-6.456 2.738m12.912 0A8.962 8.962 0 0112 2.25"/>
                        </svg>
                    </div>
                </div>

                <!-- Error code -->
                <p class="error-code">Maintenance Mode</p>

                <!-- Heading -->
                <h1>Under Maintenance</h1>

                <!-- Message -->
                <p class="message">
                    We're making improvements. Please check back shortly.
                </p>

                <!-- Animated progress bar -->
                <div class="progress-bar-wrapper">
                    <div class="progress-bar"></div>
                </div>

                <!-- Status note -->
                <div class="status-note">
                    <span class="status-dot"></span>
                    Systems are being updated
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            &copy; 2026 GraveSpace. All rights reserved.
        </footer>
    </body>
</html>
