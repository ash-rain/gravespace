<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Server Error — GraveSpace</title>

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

            .error-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 5rem;
                height: 5rem;
                border-radius: 50%;
                background-color: rgba(239, 68, 68, 0.1);
                border: 1px solid rgba(239, 68, 68, 0.2);
            }

            .error-icon svg {
                width: 2.5rem;
                height: 2.5rem;
                color: #ef4444;
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

            .btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.875rem 2rem;
                font-size: 1rem;
                font-weight: 600;
                color: var(--primary);
                background-color: var(--accent);
                border: none;
                border-radius: 0.5rem;
                text-decoration: none;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 10px 15px -3px rgba(201, 168, 76, 0.2);
            }

            .btn-primary:hover {
                background-color: var(--accent-hover);
                box-shadow: 0 10px 15px -3px rgba(201, 168, 76, 0.3);
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
                <!-- Error icon -->
                <div class="icon-wrapper">
                    <div class="error-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                </div>

                <!-- Error code -->
                <p class="error-code">Error 500</p>

                <!-- Heading -->
                <h1>Something Went Wrong</h1>

                <!-- Message -->
                <p class="message">
                    We're working to fix the issue. Please try again later.
                </p>

                <!-- Button -->
                <a href="/" class="btn-primary">Return Home</a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            &copy; 2026 GraveSpace. All rights reserved.
        </footer>
    </body>
</html>
