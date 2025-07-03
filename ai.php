<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Step into the Ring! Are you ready to book the dream matches you've always imagined? Do you love debating who would win in a clash of wrestling legends? Then get ready, because the Pro Wrestling Match Maker App is here to bring your fantasy bookings to life!">
    <title>IWF | Internet Wrestling Federation - Prospect Mode</title>
    <!-- Favicon -->
    <link rel="icon" href="https://placehold.co/16x16/facc15/000?text=🤼" type="image/png">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for elements not easily achievable with direct Tailwind classes, or for fine-tuning */
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at center, #0a0a0a 0%, #1a1e2c 100%);
            background-attachment: fixed;
            overflow-y: auto;
            overflow-x: hidden;
        }
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap');

        /* Animated Background Elements */
        .animated-blob {
            position: absolute;
            background: radial-gradient(circle, var(--color-start), var(--color-end));
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
            animation: float-and-fade var(--duration) ease-in-out infinite alternate var(--delay);
            z-index: -1;
            pointer-events: none;
        }

        /* Keyframes for floating and fading animation */
        @keyframes float-and-fade {
            0% {
                transform: translate(var(--x-start), var(--y-start)) scale(var(--scale-start));
                opacity: 0.2;
            }
            50% {
                transform: translate(var(--x-mid), var(--y-mid)) scale(var(--scale-mid));
                opacity: 0.4;
            }
            100% {
                transform: translate(var(--x-end), var(--y-end)) scale(var(--scale-end));
                opacity: 0.2;
            }
        }

        /* Custom scrollbar styles */
        .custom-scrollbar::-webkit-scrollbar {
            width: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1a1e2c;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 10px;
            border: 2px solid #1a1e2c;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6a748c;
        }

        /* Message Box animation */
        .battle-message {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
            pointer-events: none;
        }
        .battle-message.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Spinner animation */
        @keyframes spin {
          from { transform: rotate(0deg); }
          to { transform: rotate(360deg); }
        }

        /* Glassmorphism Effect */
        .glassmorphism-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px 0 rgba(0, 0, 0, 0.3);
        }

        .framer-button {
            padding: 1rem 2rem;
            border-radius: 9999px;
            font-weight: 800;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            border: none;
        }

        .framer-button-primary {
            background: linear-gradient(to right, #cbceff, #F97316);
            color: #1F2937;
        }

        .framer-button-primary:hover {
            box-shadow: 0 8px 25px rgba(250, 204, 21, 0.7);
            transform: translateY(-2px);
        }

        .framer-button-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .framer-button-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .framer-button-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .framer-button-secondary:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .framer-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        /* Wrestler card specific styles */
        .wrestler-card {
            background-color: #001532; /* Darker blue background for cards */
            border: 2px solid transparent; /* Default transparent border */
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            cursor: grab; /* Indicate draggable */
            user-select: none; /* Prevent text selection during drag */
        }
        .wrestler-card:hover {
            border-color: #cbceff; /* Yellow border on hover */
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }
        .wrestler-card.dragging {
            opacity: 0.6;
            cursor: grabbing;
        }

        /* Drop zone specific styles */
        .drop-zone {
            background: rgba(255, 255, 255, 0.05);
            border: 3px dashed #4A5568; /* Dashed gray border */
            transition: all 0.2s ease-in-out;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .drop-zone.drag-over {
            border-color: #cbceff; /* Yellow border on drag over */
            box-shadow: inset 0 0 20px rgba(250, 204, 21, 0.5); /* Yellow inner glow */
            background: rgba(250, 204, 21, 0.08); /* Light yellow background */
        }
        .drop-zone.has-wrestler {
            border-style: solid;
            border-color: #F97316; /* Orange solid border when wrestler is dropped */
            background: rgba(249, 115, 22, 0.15); /* Light orange background */
            display: flex; /* Ensure flexbox for content alignment */
            align-items: center; /* Center content vertically */
            justify-content: center; /* Center content horizontally */
            flex-direction: column; /* Stack content vertically */
            padding: 0.5rem; /* Reduced padding for selected cards */
        }

        /* Styles for wrestler cards within dropzones */
        .drop-zone .wrestler-card-in-slot {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%; /* Take full width of slot */
            height: 100%; /* Take full height of slot */
            justify-content: center;
            background: none; /* Remove background */
            box-shadow: none; /* Remove shadow */
            padding: 0; /* No padding on the inner card */
        }

        .drop-zone .wrestler-card-in-slot img {
            width: 64px; /* Smaller image size */
            height: 64px; /* Smaller image size */
            border-width: 2px; /* Thinner border for image */
            margin-bottom: 0.25rem; /* Small margin */
        }

        .drop-zone .wrestler-card-in-slot p {
            font-size: 0.875rem; /* text-sm */
            line-height: 1.25rem; /* text-sm */
            margin-top: 0;
            margin-bottom: 0;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 90%; /* Ensure name fits */
        }

        /* Wrestler image border */
        .wrestler-image-border {
            border-color: #cbceff; /* yellow-400 */
        }

        /* VS text for match setup */
        .vs-text {
            font-size: 4rem;
            font-weight: 900;
            color: #cbceff; /* yellow-400 */
            text-shadow: 0px 0px 15px rgba(250, 204, 21, 0.8);
        }

        /* Stat bars */
        .stat-bar-bg {
            background-color: #4A5568; /* bg-gray-600 */
        }
        .stat-bar-fill {
            background-color: #cbceff; /* bg-yellow-400 */
            transition: width 0.3s ease-out;
        }
        .stat-bar-strength { background-color: #EF4444; } /* red-500 */
        .stat-bar-technical { background-color: #3B82F6; } /* blue-500 */
        .stat-bar-brawling { background-color: #F97316; } /* orange-500 */
        .stat-bar-stamina { background-color: #10B981; } /* green-500 */
        .stat-bar-aerial { background-color: #A855F7; } /* purple-500 */
        .stat-bar-toughness { background-color: #6B7280; } /* gray-500 */


        /* Styles for the wrestling ring effect */
        #battle-results-section-content { /* Renamed from #battle-results-section for clarity within the modal */
            /* Keep original glassmorphism styles */
            display: flex; /* Use flex to center the inner ring-mat-container */
            justify-content: center;
            align-items: center;
            padding: 1.5rem; /* This will be the "apron" area around the ring */
            box-sizing: border-box; /* Include padding in element's total width and height */
        }

        #ring-mat-container { /* New div inside battle-results-section for the mat and ropes */
            background-color: #0d111b; /* A darker, almost black for the mat */
            border-radius: 1rem; /* Rounded corners for the mat */
            padding: 2.5rem; /* Generous padding inside the ropes, creating space for content */
            width: 100%; /* Make it fill the parent #battle-results-section-content */
            height: 100%; /* Make it fill the parent #battle-results-section-content */
            position: relative;
            z-index: 1; /* Ensure it's above background elements */
            
            /* Layered inset shadows for ring ropes */
            box-shadow: 
                inset 0 0 0 5px #cbceff, /* Yellow outer rope */
                inset 0 0 0 10px #F97316, /* Orange middle rope */
                inset 0 0 0 15px #EF4444; /* Red inner rope */
        }

        /* Adjust the inner content containers to ensure they fit within the new padding */
        #ring-mat-container > .flex {
            width: 100%;
            box-sizing: border-box;
        }

        /* Modal specific styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            overflow-y: auto;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px 0 rgba(0, 0, 0, 0.5);
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .modal-overlay.show .modal-content {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-close-button {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 1001;
            transition: background-color 0.2s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        .modal-close-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Avatar selection styles */
        .avatar-option {
            border: 3px solid transparent;
            border-radius: 50%;
            transition: border-color 0.2s ease;
            cursor: pointer;
        }
        .avatar-option.selected {
            border-color: #F97316; /* Orange border for selected avatar */
            box-shadow: 0 0 15px rgba(249, 115, 22, 0.7);
        }

        /* Manager card styles */
        .manager-card {
            background-color: #1a1e2c;
            border: 1px solid #3b4252;
            border-radius: 0.75rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .manager-card:hover:not(.hired) {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .manager-card.hired {
            border-color: #10b981; /* Green border for hired manager */
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.7);
            cursor: default;
            opacity: 0.9;
        }
        .manager-card button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center py-8 px-4 sm:px-6 text-gray-100 antialiased">
    <!-- Animated Background Container -->
    <div class="fixed inset-0 overflow-hidden" aria-hidden="true">
        <div class="animated-blob" style="width: 40vw;height: 40vw;top: -10vh;left: -10vw;--color-start: #720697;--color-end: #720697;--duration: 25s;--delay: 0s;--x-start: 0vw;--y-start: 0vh;--scale-start: 1;--x-mid: 20vw;--y-mid: 20vh;--scale-mid: 1.2;--x-end: 10vw;--y-end: 10vh;--scale-end: 1;"></div>
        <div class="animated-blob" style="width: 30vw;height: 30vw;top: 60vh;left: 70vw;--color-start: #1647f9;--color-end: #be03ff;--duration: 30s;--delay: 5s;--x-start: 0vw;--y-start: 0vh;--scale-start: 0.8;--x-mid: -10vw;--y-mid: -20vh;--scale-mid: 1;--x-end: 0vw;--y-end: 0vh;--scale-end: 0.8;"></div>
        <div class="animated-blob" style="width: 50vw;height: 50vw;top: 30vh;left: -30vw;--color-start: #3aa4ff;--color-end: #6a0497;--duration: 40s;--delay: 10s;--x-start: 0vw;--y-start: 0vh;--scale-start: 1.1;--x-mid: 30vw;--y-mid: -10vh;--scale-mid: 0.9;--x-end: 10vw;--y-end: 20vh;--scale-end: 1.1;"></div>
        <div class="animated-blob" style="width: 35vw;height: 35vw;top: -5vh;left: 80vw;--color-start: rgb(59 130 246 / 0.5);--color-end: rgb(59 130 246 / 0.5);--duration: 35s;--delay: 15s;--x-start: 0vw;--y-start: 0vh;--scale-start: 0.9;--x-mid: -20vw;--y-mid: 10vh;--x-end: -10vw;--y-end: -5vh;--scale-end: 0.9;"></div>
    </div>

    <div class="container max-w-7xl mx-auto flex flex-col items-center relative z-10">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 mb-12 drop-shadow-lg text-center leading-tight">
            IWF Prospect Mode
        </h1>

        <!-- Gold Display -->
        <div class="fixed top-4 left-4 p-3 glassmorphism-card rounded-lg shadow-md text-yellow-300 font-bold flex items-center z-20">
            <svg class="w-6 h-6 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
            Gold Coins: <span id="gold-display" class="ml-2">1000</span>
        </div>

        <div id="message-box" class="hidden battle-message fixed top-4 md:top-8 w-full max-w-sm md:max-w-md py-3 px-6 rounded-xl font-semibold text-center z-50 text-white shadow-lg"></div>

        <!-- My Wrestler Profile Section -->
        <div id="my-wrestler-profile" class="mb-8 p-4 glassmorphism-card rounded-2xl w-full max-w-xl">
            <h2 class="text-2xl font-semibold text-yellow-300 mb-4 text-center flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.29-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.93-3.5 3.22-6 3.22z"/></svg>
                Your Prospect
            </h2>
            <div id="my-wrestler-card-display" class="flex flex-col items-center">
                <!-- User wrestler card will be populated here -->
            </div>
            <div class="mt-4 text-center">
                <p class="text-lg font-bold text-gray-200">Level: <span id="user-level">1</span></p>
                <div class="w-full bg-gray-700 rounded-full h-4 mt-2">
                    <div id="user-xp-bar" class="bg-purple-500 h-4 rounded-full" style="width: 0%;"></div>
                </div>
                <p class="text-sm text-gray-400 mt-1">XP: <span id="user-xp">0</span> / <span id="user-xp-needed">100</span></p>
            </div>

            <!-- Skill Training Section -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-yellow-300 mb-3 text-center">Train Your Skills!</h3>
                <div id="skill-training-buttons" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Skill training buttons will be dynamically added here -->
                </div>
            </div>
        </div>

        <!-- Hire Manager Section -->
        <div id="hire-manager-section" class="mb-8 p-4 glassmorphism-card rounded-2xl w-full max-w-xl">
            <h2 class="text-2xl font-semibold text-yellow-300 mb-4 text-center flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                Hire a Manager!
            </h2>
            <div id="current-manager-display" class="mb-4 text-center text-gray-300">
                <!-- Current manager info will go here -->
                No manager hired.
            </div>
            <div id="managers-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4 custom-scrollbar max-h-96 overflow-y-auto p-2">
                <!-- Manager cards will be populated here by JavaScript -->
            </div>
        </div>

        <!-- Match Setup Area -->
        <div id="match-setup" class="mb-8 p-4 glassmorphism-card rounded-2xl w-full max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] items-center gap-4">
                <!-- Your Wrestler Slot -->
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-blue-400 mb-4">Your Wrestler</h2>
                    <div id="p1-slot" class="drop-zone h-32 rounded-lg flex flex-col items-center justify-center text-slate-500 p-2 has-wrestler">
                        <!-- Your wrestler will be fixed here by JS -->
                    </div>
                </div>
                
                <div class="vs-text my-4 md:my-0">VS</div>

                <!-- Opponent Slot -->
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-red-400 mb-4">Opponent</h2>
                    <div id="p3-slot" class="drop-zone h-32 rounded-lg flex flex-col items-center justify-center text-slate-500 p-2">
                        <p class="text-center text-sm">Drag Opponent Here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Battle Controls -->
        <div class="flex flex-wrap justify-center gap-6 mb-12">
            <button id="simulate-button" class="framer-button framer-button-primary flex items-center justify-center" disabled>
                <span id="simulate-spinner" class="hidden animate-spin h-6 w-6 text-white mr-3 -ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0012 4.002v1m0 16a8.001 8.001 0 006.002-14.356m-1.276 1.276A8.002 8.002 0 0115.748 10H17"></path></svg>
                </span>
                <svg id="simulate-play-icon" class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                Simulate Match
            </button>
            <button id="random-matchup-button" class="framer-button framer-button-secondary flex items-center justify-center">
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 8c-.6 0-1-.4-1-1V2c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4zm0 8c-.6 0-1-.4-1-1v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1h-4zM20 12c0-.6-.4-1-1-1h-4c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-4zM7 12c0-.6-.4-1-1-1H2c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-4zM13 18c0-.6-.4-1-1-1h-4c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-4zM20 6c0-.6-.4-1-1-1h-4c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1V6z"/></svg>
                Random Opponent
            </button>
            <button id="reset-button" class="framer-button framer-button-secondary flex items-center justify-center">
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8c0-4.08-3.05-7.44-7-7.93V4z"/></svg>
                Clear Opponent
            </button>
        </div>

        <!-- Match Outcome Modal Overlay -->
        <div id="match-outcome-modal" class="modal-overlay hidden">
            <div class="modal-content glassmorphism-card w-full max-w-5xl">
                <!-- Close Button for Modal -->
                <button class="modal-close-button" id="close-modal-button">
                    &times;
                </button>
                <!-- Match Outcome Content - moved inside the modal -->
                <div id="battle-results-section-content" class="rounded-2xl shadow-2xl">
                    <!-- This is the new "ring-mat" div -->
                    <div id="ring-mat-container" class="p-4 rounded-xl"> 
                        <h2 class="text-2xl font-semibold text-yellow-300 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                            Match Outcome
                        </h2>

                        <div class="flex flex-col lg:flex-row gap-6">
                            <!-- Match Play-by-Play Log -->
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-orange-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.9 2H19c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2-.5.3.8.3h1.9c.3 0 .6-.1.8-.4l2.1-2.1c-.2-.2-.3.5-.3.8V4.8c0-.3-.1-.6-.4-.8L21.7 2.4c-.2-.2-.5-.3-.8-.4zM3.1 22H5c.3 0 .6-.1.8-.4l2.1-2.1c-.2-.2-.3.5-.3.8V14.5c0-.3-.1-.6-.4-.8l-2.1-2.1c-.2-.2-.5-.3-.8-.3H3.1c-.3 0-.6.1-.8.4l-2.1 2.1c-.2-.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.4zM10 8c-.6 0-1-.4-1-1V2c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4zm0 8c-.6 0-1-.4-1-1v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1h-4z"/></svg>
                                    Last Match Play-by-Play
                                </h3>
                                <div id="battle-log" class="bg-gray-900 border border-gray-700 rounded-lg p-4 h-64 overflow-y-auto text-sm text-gray-300 custom-scrollbar">
                                    <p class="text-gray-500">The play-by-play for the last simulated match will appear here.</p>
                                </div>
                            </div>

                            <!-- Match Winner -->
                            <div class="flex-1 bg-gray-900 border border-gray-700 rounded-lg p-4">
                                <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-cyan-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                    Match Result!
                                </h3>
                                <div class="text-center">
                                    <div id="winner-images-container" class="flex justify-center items-center gap-4 mx-auto mb-4">
                                        <!-- Winner images will be placed here by JavaScript -->
                                    </div>
                                    <p id="match-winner-name" class="text-3xl font-extrabold text-yellow-400 mb-2">
                                        <!-- Winner Name Here -->
                                    </p>
                                    <p id="winner-description" class="text-md text-gray-300"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Wrestlers Section -->
        <div class="glassmorphism-card p-6 rounded-2xl shadow-2xl w-full max-w-7xl mt-12">
            <h2 class="text-2xl font-semibold text-yellow-300 mb-6 text-center flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                Available Opponents (Drag & Drop!)
            </h2>
            <div id="wrestlers-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 custom-scrollbar max-h-[600px] overflow-y-auto p-2">
                <!-- Wrestler cards will be populated here by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Initial Setup Modal Overlay -->
    <div id="initial-setup-modal" class="modal-overlay show">
        <div class="modal-content glassmorphism-card p-8 w-full max-w-md text-center">
            <h2 class="text-3xl font-extrabold text-yellow-400 mb-6">Create Your Prospect!</h2>
            
            <div class="mb-4">
                <label for="prospect-name-input" class="block text-lg font-semibold text-gray-200 mb-2">Your Wrestler's Name:</label>
                <input type="text" id="prospect-name-input" placeholder="e.g., 'The Rookie', 'Future Champ'"
                       class="w-full p-3 rounded-lg bg-gray-800 text-yellow-300 border border-gray-700 focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-center text-xl font-bold" />
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="prospect-height-input" class="block text-lg font-semibold text-gray-200 mb-2">Height (e.g., 6'2"):</label>
                    <input type="text" id="prospect-height-input" placeholder="e.g., 6'2&quot;" value="6'0&quot;"
                           class="w-full p-3 rounded-lg bg-gray-800 text-yellow-300 border border-gray-700 focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-center text-xl font-bold" />
                </div>
                <div>
                    <label for="prospect-weight-input" class="block text-lg font-semibold text-gray-200 mb-2">Weight (lbs):</label>
                    <input type="number" id="prospect-weight-input" placeholder="e.g., 220" value="220" min="150" max="500"
                           class="w-full p-3 rounded-lg bg-gray-800 text-yellow-300 border border-gray-700 focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-center text-xl font-bold" />
                </div>
            </div>

            <div class="mb-8">
                <p class="text-lg font-semibold text-gray-200 mb-3">Choose Your Avatar:</p>
                <div id="avatar-selection" class="flex justify-center gap-4 flex-wrap">
                    <img src="https://php-mentor.com/sandbox/wrestling/images/prospect1.webp" data-avatar="prospect1" class="avatar-option w-24 h-24 rounded-full object-cover border-4 border-transparent cursor-pointer" alt="Prospect Avatar 1">
                    <img src="https://php-mentor.com/sandbox/wrestling/images/prospect2.webp" data-avatar="prospect2" class="avatar-option w-24 h-24 rounded-full object-cover border-4 border-transparent cursor-pointer" alt="Prospect Avatar 2">
                    <img src="https://php-mentor.com/sandbox/wrestling/images/prospect3.webp" data-avatar="prospect3" class="avatar-option w-24 h-24 rounded-full object-cover border-4 border-transparent cursor-pointer" alt="Prospect Avatar 3">
                    <img src="https://php-mentor.com/sandbox/wrestling/images/prospect4.webp" data-avatar="prospect4" class="avatar-option w-24 h-24 rounded-full object-cover border-4 border-transparent cursor-pointer" alt="Prospect Avatar 4">
                </div>
            </div>

            <button id="start-game-button" class="framer-button framer-button-primary w-full" disabled>
                Start Your Career!
            </button>
        </div>
    </div>

    <script>
        // Base URL for wrestler images
        const BASE_IMAGE_URL = "https://php-mentor.com/sandbox/wrestling/images/";

        // Function to get a random integer within a range
        const getRandomInt = (min, max) => {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        };

        // Helper to extract the last name from a wrestler's full name for image URL
        const getLastName = (fullName) => {
            // Special handling for user's prospect
            if (fullName === userWrestler.name && userWrestler.avatar) {
                return userWrestler.avatar; // Use the chosen avatar identifier
            }

            const parts = fullName.split(' ');
            if (parts.length > 1) {
                // Special handling for specific wrestlers to match image filenames
                if (fullName === "Hulk Hogan") return "hogan";
                if (fullName === "The Rock") return "rock";
                if (fullName === "Stone Cold Steve Austin") return "austin";
                if (fullName === "The Undertaker") return "undertaker";
                if (fullName === "Macho Man Randy Savage") return "savage";
                if (fullName === "Andre the Giant") return "andre";
                if (fullName === "Big John Studd") return "studd";
                if (fullName === "Big Boss Man") return "bossman";
                if (fullName === "Junkyard Dog") return "jyd";
                if (fullName === "The Big Show") return "bigshow";
                if (fullName === "The Great Muta") return "muta";
                if (fullName === "Lex Luger") return "luger";
                if (fullName === "Rick Steiner") return "ricksteiner";
                if (fullName === "Scott Steiner") return "scottsteiner";
                if (fullName === "Bret Hart") return "brethart";
                if (fullName === "Owen Hart") return "owenhart";
                if (fullName === "Dusty Rhodes") return "dustyrhodes";
                if (fullName === "Dustin Rhodes") return "dustinrhodes";
                if (fullName === "Cody Rhodes") return "codyrhodes";
                if (fullName === "Road Warrior Hawk") return "hawk";
                if (fullName === "Road Warrior Animal") return "animal";
                if (fullName === "Sid Vicious") return "sid";
                if (fullName === "Ted DiBiase") return "dibiase";
                if (fullName === "Terry Gordy") return "gordy";
                if (fullName === "Stan Hansen") return "hansen";
                if (fullName === "Jake Roberts") return "roberts";
                if (fullName === "Dean Malenko") return "malenko";
                if (fullName === "Shinsuke Nakamura") return "nakamura";
                if (fullName === "Roman Reigns") return "reigns";
                if (fullName === "Seth Rollins") return "rollins";
                if (fullName === "Ron Simmons") return "simmons";
                if (fullName === "Bob Backlund") return "backlund";
                if (fullName === "Brock Lesnar") return "lesnar";
                if (fullName === "Bobby Lashley") return "lashley";
                if (fullName === "Terry Funk") return "funk";
                if (fullName === "Rick Rude") return "rude";
                if (fullName === "Harley Race") return "race";
                if (fullName === "Roddy Piper") return "piper";
                if (fullName === "Mike Rotunda") return "rotunda";
                if (fullName === "Booker T") return "bookert";
                if (fullName === "Kerry Von Erich") return "kerryvonerich";
                if (fullName === "Kevin Von Erich") return "kevinvonerich";
                if (fullName === "The Great Khali") return "khali";
                if (fullName === "Ivan Koloff") return "ivankoloff";
                if (fullName === "Nikita Koloff") return "nikitakoloff";
                if (fullName === "Daniel Bryan") return "bryan";
                if (fullName === "Luke Harper") return "harper";
                if (fullName === "Michael Hayes") return "hayes";
                if (fullName === "Meng") return "meng";
                if (fullName === "Bobby Eaton") return "eaton";
                if (fullName === "Lord Steven Regal") return "regal";
                if (fullName === "Barbarian") return "barbarian";
                if (fullName === "Paul Orndorff") return "orndorff";
                if (fullName === "Hacksaw Jim Duggan") return "duggan";
                if (fullName === "Jimmy Snuka") return "snuka";
                if (fullName === "Don Muraco") return "muraco";
                if (fullName === "Bam Bam Bigelow") return "bigelow";
                if (fullName === "Chyna") return "chyna";
                if (fullName === "King Kong Bundy") return "bundy";
                if (fullName === "Rhyno") return "rhyno";
                if (fullName === "Sabu") return "sabu";
                if (fullName === "One Man Gang") return "onemangang";
                if (fullName === "Brutus Beefcake") return "beefcake";
                if (fullName === "Greg Valentine") return "valentine";
                if (fullName === "Juventud Guerrera") return "guerrera";
                if (fullName === "Steve Williams") return "williams";
                if (fullName === "Ken Patera") return "patera";
                if (fullName === "Jimmy Garvin") return "garvin";
                if (fullName === "Ronnie Garvin") return "garvin"; // Assuming same image as Jimmy for now, or you'll need a new one
                if (fullName === "The Iron Sheik") return "ironsheik";
                if (fullName === "Gilbert") return "placeholder"; // Placeholder for Gilbert
                if (fullName === "Brooklyn Brawler") return "brawler";
                if (fullName === "Iron Mike Sharpe") return "sharpe";
                if (fullName === "Paul Heyman") return "heyman"; // Added Paul Heyman

                // Default to last word for other multi-word names
                return parts[parts.length - 1].toLowerCase();
            }
            // For single-word names like "Sting", "Vader", "Goldberg", "Kane", "Christian", "Sheamus"
            return fullName.toLowerCase().replace(/\s/g, ''); // Remove spaces, convert to lowercase
        };

        // Data for pro wrestlers including their finishing moves
        const wrestlersData = [
            {
                name: "AJ Styles",
                height: "5'11\"",
                weight: 218,
                description: "The Phenomenal One - One of the most technically gifted wrestlers of his generation. Two-time WWE Champion, former TNA World Heavyweight Champion, and IWGP Heavyweight Champion. Known for his incredible in-ring ability and signature moves like the Styles Clash and Phenomenal Forearm. Helped elevate TNA Wrestling during its peak years and brought legitimacy to WWE's acquisition of indie talent.",
                baseHp: 100,
                strength: 74,
                technicalAbility: 96,
                brawlingAbility: 81,
                stamina: 90,
                aerialAbility: 90,
                toughness: 81,
                moves: {
                    grapple: [{ name: "Phenomenal Forearm", damage: { min: 15, max: 18 }, baseHitChance: 0.8, stat: 'aerialAbility' }],
                    strike: [{ name: "Spiral Tap", damage: { min: 14, max: 17 }, baseHitChance: 0.78, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Calf Crusher", damage: { min: 12, max: 14 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "Styles Clash", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Andre the Giant",
                height: "7'4\"",
                weight: 520,
                description: "The Eighth Wonder of the World. Standing 7'4\" and weighing over 500 pounds, Andre was professional wrestling's most recognizable star worldwide. Famous for his undefeated streak that lasted over a decade, his match with Hulk Hogan at WrestleMania III drew over 93,000 fans. Beyond wrestling, he appeared in films like \"The Princess Bride.\" His physical presence and gentle personality made him a global ambassador for the sport.",
                baseHp: 110,
                strength: 98,
                technicalAbility: 40,
                brawlingAbility: 97,
                stamina: 68,
                aerialAbility: 2,
                toughness: 95,
                moves: {
                    grapple: [{ name: "Bodyslam", damage: { min: 15, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    strike: [{ name: "Headbutt", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    highFlying: [{ name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' }],
                    finisher: [{ name: "Sit-down Splash", damage: { min: 28, max: 40 }, baseHitChance: 0.85, stat: 'strength' }]
                }
            },
            {
                name: "Arn Anderson",
                height: "6'1\"",
                weight: 249,
                description: "The Enforcer. Master of fundamental wrestling and psychology. Key member of The Four Horsemen alongside Ric Flair. Never held a world championship but was considered one of the best wrestlers never to do so. Exceptional storyteller in the ring and on the microphone. Later became a respected backstage producer and trainer, helping develop future stars.",
                baseHp: 100,
                strength: 87,
                technicalAbility: 92,
                brawlingAbility: 85,
                stamina: 92,
                aerialAbility: 21,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Spinebuster", damage: { min: 13, max: 19 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Gourdbuster", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    highFlying: [{ name: "DDT", damage: { min: 9, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Double A Spinebuster", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Bam Bam Bigelow",
                height: "6'3\"",
                weight: 360,
                description: "The Beast from the East. Agile for his size, known for his cartwheels and top-rope maneuvers. Main evented WrestleMania XI. Had notable runs in ECW, WCW, and WWF. His flaming headbutt was an iconic visual. Respected for his ability to work with any opponent and deliver thrilling matches despite his size.",
                baseHp: 105,
                strength: 90,
                technicalAbility: 75,
                brawlingAbility: 88,
                stamina: 85,
                aerialAbility: 70,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Greetings from Kiss", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Headbutt", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Moonsault", damage: { min: 14, max: 20 }, baseHitChance: 0.8, stat: 'aerialAbility' }],
                    finisher: [{ name: "Diving Headbutt", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Barbarian",
                height: "6'2\"",
                weight: 280,
                description: "The Barbarian. Powerful wrestler known for his headbutt finishing move and his partnership with The Warlord as The Powers of Pain. Standing 6'2\" and weighing over 280 pounds of muscle, he was legitimately one of wrestling's strongest performers. Had successful runs in both WWF and WCW, often portrayed as a savage or monster character. His kick-out power was legendary, often requiring multiple finishers to keep him down. Part of Heenan Family and later formed successful tag teams. Known for his professionalism and longevity, competing effectively well into his 40s while maintaining his impressive physique.",
                baseHp: 105,
                strength: 95,
                technicalAbility: 65,
                brawlingAbility: 96,
                stamina: 90,
                aerialAbility: 48,
                toughness: 98,
                moves: {
                    grapple: [{ name: "Powerslam", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Big Boot", damage: { min: 12, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Bearhug", damage: { min: 10, max: 14 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Top Rope Headbutt", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Barry Windham",
                height: "6'6\"",
                weight: 275,
                description: "Son of wrestling legend Blackjack Mulligan, Barry was a gifted technical wrestler with remarkable athleticism for his size. Multiple-time tag team champion and singles titleholder across various promotions. Member of The Four Horsemen and known for his smooth in-ring style. Considered one of the most naturally talented wrestlers who perhaps didn't reach his full potential due to various circumstances.",
                baseHp: 105,
                strength: 88,
                technicalAbility: 95,
                brawlingAbility: 89,
                stamina: 100,
                aerialAbility: 54,
                toughness: 93,
                moves: {
                    grapple: [{ name: "Lariat", damage: { min: 12, max: 17 }, baseHitChance: 0.88, stat: 'brawlingAbility' }],
                    strike: [{ name: "Flying Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Bulldog", damage: { min: 11, max: 14 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Superplex", damage: { min: 26, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Batista",
                height: "6'6\"",
                weight: 290,
                description: "The Animal. Six-time World Champion (4-time World Heavyweight Champion, 2-time WWE Champion). Original member of Evolution alongside Triple H and Ric Flair. Known for his incredible physique and power moves like the Batista Bomb. Successfully transitioned to Hollywood, starring in \"Guardians of the Galaxy\" and other major films. His 2005 face turn and title win was one of WWE's most successful storylines.",
                baseHp: 100,
                strength: 96,
                technicalAbility: 67,
                brawlingAbility: 92,
                stamina: 89,
                aerialAbility: 30,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Spear", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Spinebuster", damage: { min: 11, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "Full Nelson Slam", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Batista Bomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Big Boss Man",
                height: "6'6\"",
                weight: 330,
                description: "Ray Traylor brought legitimacy to the \"corrections officer\" gimmick with his background in law enforcement. Surprisingly agile for his size, known for his sidewalk slam finisher. Had memorable feuds with Hulk Hogan and formed an unlikely tag team with Ken Shamrock. His character work and ability to be both heel and face effectively made him a valuable mid-card performer throughout the 1990s.",
                baseHp: 100,
                strength: 92,
                technicalAbility: 70,
                brawlingAbility: 89,
                stamina: 84,
                aerialAbility: 20,
                toughness: 91,
                moves: {
                    grapple: [{ name: "Sidewalk Slam", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    strike: [{ name: "Pendulum Backbreaker", damage: { min: 10, max: 18 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Big Boot", damage: { min: 9, max: 15 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Boss Man Slam", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Big John Studd",
                height: "6'10\"",
                weight: 364,
                description: "Standing 6'10\" and weighing over 360 pounds, Studd was one of the premier giants of the 1980s WWF. Won the first-ever Royal Rumble in 1989. Famous for his bodyslam challenges and feuds with Andre the Giant. His matches helped establish the spectacle of giant vs. giant encounters that became a wrestling staple.",
                baseHp: 100,
                strength: 94,
                technicalAbility: 55,
                brawlingAbility: 87,
                stamina: 75,
                aerialAbility: 10,
                toughness: 86,
                moves: {
                    grapple: [{ name: "Double Underhook Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "Backbreaker", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Reverse Bear Hug", damage: { min: 28, max: 34 }, baseHitChance: 0.85, stat: 'strength' }]
                }
            },
            {
                name: "Bob Backlund",
                height: "6'1\"",
                weight: 245,
                description: "Mr. Bob Backlund. WWE Champion for over 5 years (1978-1983), one of the longest reigns in company history. Known for his amateur wrestling background and technical prowess. His 1994 heel turn as a deranged former champion was one of wrestling's most effective character transformations. Helped bridge the gap between the territorial era and national expansion of wrestling.",
                baseHp: 105,
                strength: 87,
                technicalAbility: 97,
                brawlingAbility: 83,
                stamina: 95,
                aerialAbility: 45,
                toughness: 93,
                moves: {
                    grapple: [{ name: "Atomic Knee Drop", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Belly-to-back Rolling Bridge", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Atomic Spinecrusher", damage: { min: 11, max: 17 }, baseHitChance: 0.65, stat: 'technicalAbility' }],
                    finisher: [{ name: "Crossface Chickenwing", damage: { min: 25, max: 38 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Bobby Eaton",
                height: "5'10\"",
                weight: 230,
                description: "Beautiful Bobby. Before setting out as a singles wrestler, was one half of The Midnight Express with Dennis Condrey and later Stan Lane, considered one of the greatest tag teams in wrestling history. Known for his technical wrestling ability and his Alabama Jam (top rope legdrop) finishing move. Multiple-time NWA World Tag Team Champion whose matches with The Rock 'n' Roll Express were classics of tag team wrestling. His work with manager Jim Cornette helped establish the heel manager dynamic that influenced wrestling for decades. Respected as one of the most underrated technical wrestlers who could work with anyone and make them look good.",
                baseHp: 100,
                strength: 75,
                technicalAbility: 92,
                brawlingAbility: 86,
                stamina: 90,
                aerialAbility: 91,
                toughness: 87,
                moves: {
                    grapple: [{ name: "Spinning Neckbreaker", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Armbar DDT", damage: { min: 12, max: 14 }, baseHitChance: 0.85, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Diving Knee Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Alabama Jam", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Bobby Lashley",
                height: "6'3\"",
                weight: 273,
                description: "The All Mighty. Former U.S. Army veteran who became WWE Champion and ECW Champion. Known for his incredible physique and legitimate amateur wrestling background. Successfully competed in mixed martial arts, proving his athletic credibility. His later career renaissance, particularly his work with MVP and The Hurt Business, showcased his improved mic skills and character development.",
                baseHp: 100,
                strength: 96,
                technicalAbility: 80,
                brawlingAbility: 92,
                stamina: 90,
                aerialAbility: 37,
                toughness: 93,
                moves: {
                    grapple: [{ name: "Spear", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Dominator", damage: { min: 10, max: 17 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "Full Nelson Slam", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Hurt Lock", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Booker T",
                height: "6'3\"",
                weight: 256,
                description: "Can you dig it, sucka?! Five-time WCW World Heavyweight Champion and one-time World Heavyweight Champion in WWE. Master of the spinaroonie and Book End finisher. Successful tag team career with his brother Stevie Ray as Harlem Heat. Later became a respected commentator and trainer. His charisma and catchphrases made him one of the most entertaining performers of his era.",
                baseHp: 100,
                strength: 87,
                technicalAbility: 85,
                brawlingAbility: 92,
                stamina: 89,
                aerialAbility: 80,
                toughness: 84,
                moves: {
                    grapple: [{ name: "Book End", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Houston Hangover", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    finisher: [{ name: "Scissors Kick", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Braun Strowman",
                height: "6'8\"",
                weight: 385,
                description: "The Monster Among Men. Standing 6'8\" and weighing over 380 pounds, Strowman became known for incredible feats of strength and his catchphrase \"Get these hands!\" Former Universal Champion and multiple-time tag team champion. His feuds with Roman Reigns and Brock Lesnar were highlights of WWE programming. Started as a member of The Wyatt Family before becoming a fan-favorite monster face.",
                baseHp: 105,
                strength: 98,
                technicalAbility: 60,
                brawlingAbility: 92,
                stamina: 86,
                aerialAbility: 20,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Fallaway Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Backbreaker", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Running Powerslam", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
            {
                name: "Bray Wyatt",
                height: "6'3\"",
                weight: 285,
                description: "The Eater of Worlds/The Fiend. Mysterious, psychological, and dangerous.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(20, 40),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Sister Abigail", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    strike: [{ name: "Mandible Claw", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Senton", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Sister Abigail", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Bret Hart",
                height: "6'0\"",
                weight: 235,
                description: "\"The Excellence of Execution\" - Five-time WWE Champion and considered one of the greatest technical wrestlers ever. Member of the legendary Hart wrestling family from Calgary. His matches told perfect stories through pure wrestling ability. The Montreal Screwjob incident in 1997 became one of wrestling's most controversial moments. Later had a successful run in WCW before injuries ended his career.",
                baseHp: 110,
                strength: 81,
                technicalAbility: 100,
                brawlingAbility: 89,
                stamina: 100,
                aerialAbility: 42,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Snap Suplex", damage: { min: 11, max: 16 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Russian Leg Sweep", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Backbreaker", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Sharpshooter", damage: { min: 24, max: 34 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Brock Lesnar",
                height: "6'3\"",
                weight: 286,
                description: "The Beast Incarnate! Dominant and destructive.",
                baseHp: 105,
                strength: 98,
                technicalAbility: 91,
                brawlingAbility: 88,
                stamina: 87,
                aerialAbility: 22,
                toughness: 95,
                moves: {
                    grapple: [{ name: "German Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Kimura Lock", damage: { min: 10, max: 18 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Knee Lift", damage: { min: 8, max: 14 }, baseHitChance: 0.6, stat: 'strength' }],
                    finisher: [{ name: "F-5", damage: { min: 30, max: 36 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
            {
                name: "Bron Breakker",
                height: "6'0\"",
                weight: 232,
                description: "Son of Rick Steiner and nephew of Scott Steiner, representing the next generation of the Steiner wrestling dynasty. Two-time NXT Champion known for his incredible athleticism and power. His combination of amateur wrestling background and natural charisma has made him one of WWE's most promising young talents. His matches showcase both technical skill and explosive athleticism.",
                baseHp: 100,
                strength: 94,
                technicalAbility: 95,
                brawlingAbility: 87,
                stamina: 90,
                aerialAbility: 60,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Military Press Slam", damage: { min: 12, max: 16 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Spear", damage: { min: 15, max: 20 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Frankensteiner", damage: { min: 14, max: 18 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    finisher: [{ name: "Steiner Recliner", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Brooklyn Brawler",
                height: "6'2\"",
                weight: 230,
                description: "The Brooklyn Brawler. A quintessential jobber known for his gritty, street-fighting style and his signature t-shirt. Despite rarely winning, he was a beloved figure in WWF for decades, known for his resilience and ability to make opponents look good. His longevity and dedication to the craft earned him respect.",
                baseHp: 85,
                strength: 65,
                technicalAbility: 55,
                brawlingAbility: 70,
                stamina: 70,
                aerialAbility: 15,
                toughness: 80,
                moves: {
                    grapple: [{ name: "Arm Drag", damage: { min: 7, max: 10 }, baseHitChance: 0.6 }],
                    strike: [{ name: "Eye Poke", damage: { min: 5, max: 8 }, baseHitChance: 0.7 }],
                    highFlying: [{ name: "Small Package", damage: { min: 6, max: 9 }, baseHitChance: 0.65 }],
                    finisher: [{ name: "Brooklyn Crab", damage: { min: 15, max: 20 }, baseHitChance: 0.75 }]
                }
            },
            {
                name: "Bruiser Brody",
                height: "6'8\"",
                weight: 300,
                description: "One of the most feared and respected wrestlers in the world during the 1970s and 80s. Known for his wild, brawling style and refusal to follow traditional wrestling politics. Highly successful in Japan and Puerto Rico. His tragic murder in 1988 in Puerto Rico remains one of wrestling's darkest moments. His influence on hardcore wrestling and international wrestling culture was immense.",
                baseHp: 105,
                strength: 92,
                technicalAbility: 58,
                brawlingAbility: 96,
                stamina: 86,
                aerialAbility: 20,
                toughness: 94,
                moves: {
                    grapple: [{ name: "Running Big Boot", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    strike: [{ name: "Elbow Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Bearhug", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "King Kong Knee Drop", damage: { min: 27, max: 37 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Brutus Beefcake",
                height: "6'3\"",
                weight: 257,
                description: "The Barber. Known for his flamboyant persona and cutting opponents' hair after matches. Had a successful tag team run as one half of The Dream Team with Greg Valentine. Later became a close ally of Hulk Hogan. His character evolved significantly throughout his career, from a heel to a beloved babyface. His shears were an iconic prop.",
                baseHp: 95,
                strength: 80,
                technicalAbility: 65,
                brawlingAbility: 85,
                stamina: 80,
                aerialAbility: 30,
                toughness: 88,
                moves: {
                    grapple: [{ name: "High Knee", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    strike: [{ name: "Atomic Drop", damage: { min: 8, max: 13 }, baseHitChance: 0.65, stat: 'strength' }],
                    highFlying: [{ name: "Running Clothesline", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Sleeper Hold", damage: { min: 22, max: 32 }, baseHitChance: 0.85, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Bruno Sammartino",
                height: "6'1\"",
                weight: 265,
                description: "The Living Legend. WWE Champion for over 11 years total across two reigns, the longest combined championship reign in company history. Sold out Madison Square Garden over 180 times. His Italian-American immigrant story resonated with audiences and helped build WWE's foundation. Known for incredible strength and his bearhug finishing hold. Posthumously inducted into the WWE Hall of Fame after years of being estranged from the company.",
                baseHp: 110,
                strength: 97,
                technicalAbility: 70,
                brawlingAbility: 92,
                stamina: 94,
                aerialAbility: 20,
                toughness: 96,
                moves: {
                    grapple: [{ name: "Bearhug", damage: { min: 15, max: 18 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Body Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength' }],
                    highFlying: [{ name: "Hammer Lock", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    finisher: [{ name: "Backbreaker", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Chyna",
                height: "5'10\"",
                weight: 180,
                description: "The Ninth Wonder of the World. A groundbreaking female performer who competed primarily against men. First woman to enter the Royal Rumble and hold the Intercontinental Championship. Member of D-Generation X. His powerful physique and aggressive style broke barriers in professional wrestling, inspiring many.",
                baseHp: 95,
                strength: 85,
                technicalAbility: 70,
                brawlingAbility: 90,
                stamina: 85,
                aerialAbility: 25,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Gorilla Press Slam", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Handspring Back Elbow", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Low Blow", damage: { min: 8, max: 13 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Pedigree", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Christian",
                height: "6'2\"",
                weight: 230,
                description: "Captain Charisma. Two-time World Heavyweight Champion and multiple-time Intercontinental and tag team champion. Originally succeeded as part of Edge & Christian before establishing himself as a singles star. His \"peeps\" and various catchphrases showcased his natural comedic timing. Had career-defining runs in TNA Wrestling as a main event star. Known for his intelligence and psychology in crafting memorable matches.",
                baseHp: 100,
                strength: 85,
                technicalAbility: 93,
                brawlingAbility: 83,
                stamina: 90,
                aerialAbility: 80,
                toughness: 84,
                moves: {
                    grapple: [{ name: "Tornado DDT", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Frog Splash", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Spear", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Unprettier", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Chris Benoit",
                height: "5'11\"",
                weight: 220,
                description: "The Rabid Wolverine. Considered one of the greatest technical wrestlers ever, known for his intensity and submission expertise. World Heavyweight Champion and multiple-time Intercontinental Champion. His triple threat match at WrestleMania XX with Shawn Michaels and Triple H is considered a classic. His career accomplishments are overshadowed by the tragic events of 2007 that ended his life and the lives of his family members.",
                baseHp: 100,
                strength: 86,
                technicalAbility: 96,
                brawlingAbility: 89,
                stamina: 97,
                aerialAbility: 70,
                toughness: 95,
                moves: {
                    grapple: [{ name: "German Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Diving Headbutt", damage: { min: 11, max: 19 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Snap Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    finisher: [{ name: "Crippler Crossface", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Chris Jericho",
                height: "6'0\"",
                weight: 225,
                description: "Y2J! The Ayatollah of Rock 'n' Rolla! First-ever Undisputed Champion, holding both WWE and WCW titles simultaneously. Master reinventer who has remained relevant across multiple decades and promotions. Known for his wit, catchphrases, and ability to get heat as a heel. Also successful as a rock musician with his band Fozzy. His recent work in AEW has introduced him to new generations of fans.",
                baseHp: 105,
                strength: 76,
                technicalAbility: 94,
                brawlingAbility: 82,
                stamina: 90,
                aerialAbility: 74,
                toughness: 84,
                moves: {
                    grapple: [{ name: "Codebreaker", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Lionsault", damage: { min: 12, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Diving Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    finisher: [{ name: "Walls of Jericho", damage: { min: 23, max: 33 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "CM Punk",
                height: "6'2\"",
                weight: 218,
                description: "The Best in the World. Known for his 434-day WWE Championship reign and his famous \"pipe bomb\" promo in 2011. Master of both technical wrestling and microphone work. His straight-edge lifestyle became part of his character. Left WWE acrimoniously in 2014 but returned to wrestling in AEW and later back to WWE. Considered one of the most influential wrestlers of the 2000s.",
                baseHp: 100,
                strength: 81,
                technicalAbility: 93,
                brawlingAbility: 87,
                stamina: 92,
                aerialAbility: 71,
                toughness: 86,
                moves: {
                    grapple: [{ name: "Anaconda Vice", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Diving Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Springboard Clothesline", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Go To Sleep", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Cody Rhodes",
                height: "6'2\"",
                weight: 220,
                description: "The American Nightmare. Son of Dusty Rhodes who carved his own path to success. Left WWE to help found AEW, where he became a main event star. Returned to WWE and won the Royal Rumble before capturing the WWE Championship at WrestleMania XL. His story of proving himself outside WWE and returning as a conquering hero resonated with fans worldwide.",
                baseHp: 100,
                strength: 87,
                technicalAbility: 94,
                brawlingAbility: 86,
                stamina: 93,
                aerialAbility: 68,
                toughness: 91,
                moves: {
                    grapple: [{ name: "Deathlock", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Alabama Slam", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Din's Fire", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "Cross Rhodes", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Curt Hennig",
                height: "6'3\"",
                weight: 257,
                description: "Mr. Perfect. One of the most naturally gifted athletes in wrestling history. Known for his perfect execution of moves and his cocky persona. Intercontinental Champion who elevated that title's prestige. Son of Larry \"The Axe\" Hennig and father of current wrestler Joe Hennig. His perfectplex finishing move and athletic vignettes made him one of the most memorable characters of the early 1990s.",
                baseHp: 105,
                strength: 86,
                technicalAbility: 98,
                brawlingAbility: 84,
                stamina: 96,
                aerialAbility: 77,
                toughness: 95,
                moves: {
                    grapple: [{ name: "Standing Dropkick", damage: { min: 9, max: 16 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Swinging knee lift", damage: { min: 10, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Figure-four leglock", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "Perfect-Plex", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Dan Spivey",
                height: "6'8\"",
                weight: 280,
                description: "Large, athletic wrestler who competed primarily in the 1980s and 1990s. Known for his size and surprising agility. Had runs in various promotions including WWE, WCW, and All Japan Pro Wrestling. Often competed as part of tag teams and was known for his dropkick despite his 6'7\" frame. His career spanned the transition from territorial wrestling to national promotion dominance.",
                baseHp: 100,
                strength: 94,
                technicalAbility: 76,
                brawlingAbility: 94,
                stamina: 85,
                aerialAbility: 45,
                toughness: 93,
                moves: {
                    grapple: [{ name: "Powerbomb", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Spinebuster", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' }],
                    finisher: [{ name: "Spivey Spike (DDT)", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Daniel Bryan",
                height: "5'10\"",
                weight: 210,
                description: "The American Dragon. One of the most beloved wrestlers of the modern era. Known for his \"YES!\" chant that became a cultural phenomenon. Multiple-time WWE Champion whose WrestleMania XXX victory was one of the most emotional moments in wrestling history. Respected for his environmental activism and vegan lifestyle. His technical wrestling ability earned him comparisons to legends like Bret Hart.",
                baseHp: 100,
                strength: 80,
                technicalAbility: 97,
                brawlingAbility: 82,
                stamina: 94,
                aerialAbility: 89,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Top Rope Hurricanrana", damage: { min: 11, max: 18 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Busaiku Knee Kick", damage: { min: 11, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Suicide Dive", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Yes Lock (Omoplata Crossface)", damage: { min: 25, max: 38 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Dean Malenko",
                height: "5'10\"",
                weight: 212,
                description: "The Man of 1,000 Holds. Considered one of the greatest technical wrestlers ever. Known for his stoic demeanor and incredible wrestling ability. Key member of The Radicalz stable when they jumped from WCW to WWE. His matches were wrestling clinics that showcased pure technical skill. Respected by peers as a wrestler's wrestler who could work with anyone and make them look good.",
                baseHp: 100,
                strength: 74,
                technicalAbility: 100,
                brawlingAbility: 76,
                stamina: 91,
                aerialAbility: 42,
                toughness: 83,
                moves: {
                    grapple: [{ name: "Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Springboard Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Cross Armbreaker", damage: { min: 12, max: 19 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "Texas Cloverleaf", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Diamond Dallas Page",
                height: "6'5\"",
                weight: 260,
                description: "\"DDP\" - Self-made wrestler who didn't start his career until age 35. Three-time WCW World Heavyweight Champion known for his Diamond Cutter finishing move. Created the \"DDP Yoga\" fitness program that has helped numerous wrestlers and celebrities. His motivational story of starting late and achieving success inspired many. Known for his positive attitude and helping fellow wrestlers with addiction and health issues.",
                baseHp: 100,
                strength: 82,
                technicalAbility: 81,
                brawlingAbility: 92,
                stamina: 90,
                aerialAbility: 44,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Fist Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Splash", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Inverted Atomic Drop", damage: { min: 9, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    finisher: [{ name: "Diamond Cutter", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Don Muraco",
                height: "6'1\"",
                weight: 235,
                description: "The Magnificent Muraco. Two-time Intercontinental Champion. Known for his powerful physique and brawling style. Had memorable feuds with Pedro Morales and Jimmy Snuka. His segments with Jesse 'The Body' Ventura, including 'Fuji Vice', were comedy gold. Was the inaugural King of the Ring tournament winner. A consistent main event and upper mid-carder throughout the 80s in WWF.",
                baseHp: 100,
                strength: 92,
                technicalAbility: 70,
                brawlingAbility: 90,
                stamina: 85,
                aerialAbility: 30,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Atomic Drop", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'strength' }],
                    strike: [{ name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "DDT", damage: { min: 11, max: 16 }, baseHitChance: 0.72, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Asiatic Spike", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Dustin Rhodes",
                height: "6'6\"",
                weight: 260,
                description: "The Natural. Son of Dusty Rhodes who created one of wrestling's most unique characters in Goldust. Known for his androgynous, mind-games character that pushed boundaries in the 1990s. Multiple-time Intercontinental Champion with incredible longevity spanning over three decades. His ability to reinvent himself and remain relevant across different eras showcased his creativity and skill.",
                baseHp: 100,
                strength: 86,
                technicalAbility: 84,
                brawlingAbility: 91,
                stamina: 90,
                aerialAbility: 48,
                toughness: 96,
                moves: {
                    grapple: [{ name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Shattered Dreams (low blow)", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Running Uppercut", damage: { min: 11, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Cross Rhodes", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Dusty Rhodes",
                height: "6'2\"",
                weight: 275,
                description: "The American Dream. One of wrestling's greatest talkers and most beloved characters. Three-time NWA World Heavyweight Champion known for his \"common man\" persona. His feuds with The Four Horsemen were legendary. Later became one of wrestling's most respected bookers and trainers. Father to Cody and Dustin Rhodes, his influence on wrestling storytelling cannot be overstated.",
                baseHp: 105,
                strength: 88,
                technicalAbility: 62,
                brawlingAbility: 94,
                stamina: 90,
                aerialAbility: 26,
                toughness: 91,
                moves: {
                    grapple: [{ name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Atomic Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Bionic Knee Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Bionic Elbow", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Edge",
                height: "6'5\"",
                weight: 241,
                description: "The Rated-R Superstar. 11-time World Champion known for his opportunistic heel character. Master of ladder matches and hardcore wrestling. His surprise returns, particularly after career-threatening neck injuries, were some of wrestling's most emotional moments. Successful tag team career with Christian before establishing himself as a main event singles star. His spear finishing move and \"You think you know me\" entrance were iconic.",
                baseHp: 100,
                strength: 84,
                technicalAbility: 90,
                brawlingAbility: 90,
                stamina: 93,
                aerialAbility: 80,
                toughness: 91,
                moves: {
                    grapple: [{ name: "Edgecution", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Flying Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Impailer DDT", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "Spear", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Eddie Guerrero",
                height: "5'8\"",
                weight: 220,
                description: "Latino Heat! WWE Champion known for his incredible charisma and technical ability. Famous for \"lying, cheating, and stealing\" while remaining a beloved babyface. His matches with Rey Mysterio, Chris Benoit, and Kurt Angle are considered classics. Member of The Radicalz. His death in 2005 at age 38 was one of wrestling's greatest losses. His family legacy continues through various relatives in the business.",
                baseHp: 100,
                strength: 80,
                technicalAbility: 90,
                brawlingAbility: 81,
                stamina: 91,
                aerialAbility: 95,
                toughness: 88,
                moves: {
                    grapple: [{ name: "Three Amigos", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "European Uppercut", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Hurricanrana", damage: { min: 9, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    finisher: [{ name: "Frog Splash", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Gilbert",
                height: "6'0\"",
                weight: 220,
                description: "Gilbert. A lesser-known but dedicated competitor, often seen in regional promotions and as a reliable opponent for rising stars. Known for his solid fundamentals and willingness to put in the work, even if not always in the spotlight. A true workhorse of the squared circle.",
                baseHp: 80,
                strength: 60,
                technicalAbility: 65,
                brawlingAbility: 60,
                stamina: 70,
                aerialAbility: 30,
                toughness: 65,
                moves: {
                    grapple: [{ name: "Body Slam", damage: { min: 8, max: 12 }, baseHitChance: 0.65 }],
                    strike: [{ name: "Clothesline", damage: { min: 7, max: 11 }, baseHitChance: 0.6 }],
                    highFlying: [{ name: "Dropkick", damage: { min: 6, max: 10 }, baseHitChance: 0.55 }],
                    finisher: [{ name: "Gilbert Driver", damage: { min: 18, max: 25 }, baseHitChance: 0.7 }]
                }
            },
            {
                name: "Goldberg",
                height: "6'4\"",
                weight: 285,
                description: "Who's Next?! Former NFL player who became WCW's biggest homegrown star during the Monday Night Wars. Known for his incredible undefeated streak and dominant squash matches. His spear and jackhammer finishing moves were devastatingly effective. Universal Champion in WWE and WCW World Heavyweight Champion.",
                baseHp: 110,
                strength: 99,
                technicalAbility: 50,
                brawlingAbility: 97,
                stamina: 76,
                aerialAbility: 20,
                toughness: 96,
                moves: {
                    grapple: [{ name: "Spear", damage: { min: 15, max: 20 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Big Boot", damage: { min: 12, max: 17 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Clothesline", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Jackhammer", damage: { min: 30, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Greg Valentine",
                height: "6'0\"",
                weight: 249,
                description: "The Hammer. Son of Johnny Valentine, known for his brutal chop and figure-four leglock. Former Intercontinental Champion and one half of The Dream Team with Brutus Beefcake. A classic heel who excelled at drawing heat from the crowd. His longevity and consistent in-ring work made him a staple of wrestling throughout the 70s, 80s, and 90s.",
                baseHp: 98,
                strength: 85,
                technicalAbility: 88,
                brawlingAbility: 80,
                stamina: 85,
                aerialAbility: 20,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Piledriver", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    strike: [{ name: "Hammer Chop", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'technicalAbility' }],
                    finisher: [{ name: "Figure-Four Leglock", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Gunther",
                height: "6'4\"",
                weight: 297,
                description: "The Ring General. Austrian powerhouse known for his hard-hitting European style. Longest-reigning Intercontinental Champion in modern WWE history. His matches are physical affairs that showcase old-school wrestling psychology. Known for his chops and powerbomb finishing move. Leader of Imperium stable and considered one of WWE's most dominant champions in recent years.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(10, 25),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Powerbomb", damage: { min: 15, max: 20 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Chop!", damage: { min: 14, max: 18 }, baseHitChance: 0.9, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.65, stat: 'strength' }],
                    finisher: [{ name: "Sleeper Hold", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Hacksaw Jim Duggan",
                height: "6'3\"",
                weight: 280,
                description: "Hoooo! The patriotic American hero, known for carrying a 2x4 piece of wood and chanting 'U-S-A!'. Winner of the first Royal Rumble. A popular babyface whose simple, effective offense and unwavering patriotism made him a fan favorite throughout his career in WWF and WCW. His iconic 'Hoooo!' battle cry resonated with audiences worldwide.",
                baseHp: 100,
                strength: 93,
                technicalAbility: 55,
                brawlingAbility: 92,
                stamina: 80,
                aerialAbility: 20,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Body Slam", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'strength' }],
                    strike: [{ name: "Old Glory", damage: { min: 12, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Three Point Stance Tackle", damage: { min: 11, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Three-Point Stance Clothesline", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Harley Race",
                height: "6'1\"",
                weight: 245,
                description: "The King. Eight-time NWA World Champion.",
                baseHp: 105,
                strength: 85,
                technicalAbility: 87,
                brawlingAbility: 94,
                stamina: 93,
                aerialAbility: 28,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Knee Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    strike: [{ name: "Headbutt", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Vertical Suplex", damage: { min: 13, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Piledriver", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Hulk Hogan",
                height: "6'8\"",
                weight: 302,
                description: "The Immortal, Hollywood Hulk Hogan! The most recognizable wrestler in history and the face of wrestling's mainstream breakthrough in the 1980s. Six-time WWE Champion whose WrestleMania III match with Andre the Giant was wrestling's biggest moment. His heel turn as \"Hollywood Hogan\" in WCW was one of wrestling's most shocking moments. Despite controversies, his impact on popular culture and wrestling's growth cannot be denied.",
                baseHp: 110,
                strength: 98,
                technicalAbility: 64,
                brawlingAbility: 94,
                stamina: 81,
                aerialAbility: 30,
                toughness: 94,
                moves: {
                    grapple: [{ name: "Body Slam", damage: { min: 13, max: 16 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Big Boot", damage: { min: 12, max: 20 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Reverse Chinlock", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Leg Drop", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Iron Mike Sharpe",
                height: "6'4\"",
                weight: 257,
                description: "Canada's Greatest Athlete. Known for his perpetually taped forearm and his gruff demeanor. A classic enhancement talent who made many top stars look good. His unique look and aggressive style made him a memorable part of the WWF roster in the 1980s.",
                baseHp: 88,
                strength: 70,
                technicalAbility: 60,
                brawlingAbility: 75,
                stamina: 70,
                aerialAbility: 15,
                toughness: 82,
                moves: {
                    grapple: [{ name: "Forearm Smash", damage: { min: 9, max: 14 }, baseHitChance: 0.7 }],
                    strike: [{ name: "Headbutt", damage: { min: 8, max: 12 }, baseHitChance: 0.65 }],
                    highFlying: [{ name: "Backbreaker", damage: { min: 7, max: 11 }, baseHitChance: 0.6 }],
                    finisher: [{ name: "Running Forearm", damage: { min: 20, max: 28 }, baseHitChance: 0.8 }]
                }
            },
            {
                name: "Ivan Koloff",
                height: "5'11\"",
                weight: 245,
                description: "The Russian Bear. A brutal and unforgiving powerhouse.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 95),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(5, 20),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Bearhug", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Knee Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Belly-to-Belly Suplex", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Russian Sickle (Clothesline)", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Jeff Jarrett",
                height: "6'0\"",
                weight: 230,
                description: "Double J, J-E-Double F J-A-Double R-E-Double T! One of the most accomplished wrestlers in history, holding numerous championships across WCW, WWE, TNA, and AAA. Known for his country music rockstar gimmick and his guitar smash. Co-founded TNA Wrestling. Later became a successful promoter and producer, continuing to influence the industry behind the scenes.",
                baseHp: 100,
                strength: 78,
                technicalAbility: 92,
                brawlingAbility: 82,
                stamina: 89,
                aerialAbility: 60,
                toughness: 85,
                moves: {
                    grapple: [{ name: "Figure-Four Leglock", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Dropkick", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Swinging Neckbreaker", damage: { min: 9, max: 17 }, baseHitChance: 0.65, stat: 'technicalAbility' }],
                    finisher: [{ name: "The Stroke", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Jake Roberts",
                height: "6'2\"",
                weight: 249,
                description: "The Snake. Master of mind games and DDTs.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(75, 90),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(20, 40),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Short-Arm Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Knee Lift", damage: { min: 8, max: 13 }, baseHitChance: 0.6, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "DDT", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Jimmy Garvin",
                height: "6'0\"",
                weight: 230,
                description: "Gorgeous Jimmy Garvin. A flamboyant and charismatic wrestler known for his valet Precious and his high-energy style. Part of the Freebirds, he had a successful career in various promotions, often engaging in memorable feuds. His athleticism and showmanship made him a fan favorite.",
                baseHp: 90,
                strength: 70,
                technicalAbility: 75,
                brawlingAbility: 70,
                stamina: 80,
                aerialAbility: 60,
                toughness: 75,
                moves: {
                    grapple: [{ name: "Brainbuster", damage: { min: 10, max: 15 }, baseHitChance: 0.75 }],
                    strike: [{ name: "Superkick", damage: { min: 12, max: 18 }, baseHitChance: 0.7 }],
                    highFlying: [{ name: "Diving Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.65 }],
                    finisher: [{ name: "911 (DDT)", damage: { min: 25, max: 35 }, baseHitChance: 0.9 }]
                }
            },
            {
                name: "Jimmy Snuka",
                height: "6'0\"",
                weight: 250,
                description: "The Superfly. Pioneering high-flyer known for his breathtaking dives from the top rope. His leap off the top of a steel cage at Madison Square Garden in 1983 is one of wrestling's most iconic moments, inspiring a generation of wrestlers. Hall of Famer who had memorable feuds with Bob Backlund and Don Muraco. Despite legal controversies later in life, his in-ring innovation left an undeniable mark on the sport.",
                baseHp: 95,
                strength: 78,
                technicalAbility: 70,
                brawlingAbility: 85,
                stamina: 88,
                aerialAbility: 98,
                toughness: 80,
                moves: {
                    grapple: [{ name: "Headbutt", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    strike: [{ name: "Chop!", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Flying Crossbody", damage: { min: 15, max: 20 }, baseHitChance: 0.85, stat: 'aerialAbility' }],
                    finisher: [{ name: "Superfly Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.95, stat: 'aerialAbility' }]
                }
            },
            {
                name: "John Cena",
                height: "6'1\"",
                weight: 251,
                description: "17-time World Champion, the most in wrestling history. The face of WWE for over a decade and one of wrestling's biggest mainstream stars. Known for his \"Never Give Up\" motto and his Five Knuckle Shuffle. Successful Hollywood actor and philanthropist who has granted over 650 Make-A-Wish requests. His polarizing character sparked \"Let's Go Cena/Cena Sucks\" chants that defined an era.",
                baseHp: 105,
                strength: 93,
                technicalAbility: 76,
                brawlingAbility: 92,
                stamina: 88,
                aerialAbility: 42,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Five Knuckle Shuffle", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Diving Leg Drop Bulldog", damage: { min: 11, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Spinning Powerbomb", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Attitude Adjustment", damage: { min: 25, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Juventud Guerrera",
                height: "5'6\"",
                weight: 170,
                description: "The Juice. A high-flying Lucha Libre sensation, known for his innovative aerial maneuvers and charismatic personality. Part of the Latino World Order (LWO) and later the Filthy Animals in WCW. Held the Cruiserweight Championship multiple times, showcasing his incredible athleticism and risk-taking style. His matches were often highlights of WCW Monday Nitro.",
                baseHp: 90,
                strength: 60,
                technicalAbility: 85,
                brawlingAbility: 70,
                stamina: 90,
                aerialAbility: 98,
                toughness: 75,
                moves: {
                    grapple: [{ name: "Hurricanrana", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    strike: [{ name: "Spinning Heel Kick", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "450 Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'aerialAbility' }],
                    finisher: [{ name: "Juvi Driver", damage: { min: 24, max: 34 }, baseHitChance: 0.88, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Junkyard Dog",
                height: "6'3\"",
                weight: 280,
                description: "Woof woof! The charismatic and powerful JYD.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Thump (headbutt)", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Big Punch", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Body Slam", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Powerslam", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Kane",
                height: "6'10\"",
                weight: 323,
                description: "The Big Red Machine. The Undertaker's storyline brother known for his masked monster character. Mayor of Knox County, Tennessee, showing his intelligence beyond wrestling. Multiple-time World Champion with incredible longevity spanning over two decades. His debut at Hell in a Cell 1997 is one of wrestling's most memorable moments. Secondary image for demonstration purposes: https://placehold.co/150x150/1a1a1a/fff?text=Kane",
                baseHp: 105,
                strength: 96,
                technicalAbility: 68,
                brawlingAbility: 95,
                stamina: 90,
                aerialAbility: 41,
                toughness: 94,
                moves: {
                    grapple: [{ name: "Big Boot", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Flying Clothesline", damage: { min: 12, max: 18 }, baseHitChance: 0.65, stat: 'strength' }],
                    highFlying: [{ name: "Top Rope Clothesline", damage: { min: 11, max: 19 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Chokeslam", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Ken Patera",
                height: "6'1\"",
                weight: 280,
                description: "The Olympian. Former Olympic weightlifter and strongman, known for his incredible strength. Held the Intercontinental and Tag Team Championships. His full nelson submission finisher was a legitimate threat. Patera's real-life strength and legitimate athletic background made him a credible powerhouse heel in the 1980s.",
                baseHp: 100,
                strength: 95,
                technicalAbility: 60,
                brawlingAbility: 88,
                stamina: 75,
                aerialAbility: 10,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Powerslam", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Backbreaker", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "Elbow Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Full Nelson", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Kevin Nash",
                height: "7'0\"",
                weight: 320,
                description: "Big Sexy. 7-foot giant who was surprisingly agile and charismatic. Five-time World Champion across WWE and WCW. Founding member of the nWo, which revolutionized wrestling storylines. His powerbomb was one of wrestling's most devastating finishers. Later became successful backstage as a booker and creative consultant. Known for his wit and intelligence outside the ring.",
                baseHp: 100,
                strength: 95,
                technicalAbility: 65,
                brawlingAbility: 92,
                stamina: 83,
                aerialAbility: 20,
                toughness: 94,
                moves: {
                    grapple: [{ name: "Sidewalk Slam", damage: { min: 10, max: 17 }, baseHitChance: 0.6, stat: 'strength' }],
                    strike: [{ name: "Big Boot", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Snake Eyes", damage: { min: 9, max: 15 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Jackknife Powerbomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Kevin Owens",
                height: "6'0\"",
                weight: 266,
                description: "Fight Owens Fight! A prizefighter who does whatever it takes.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(30, 50),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Cannonball", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    strike: [{ name: "Senton", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Swanton Bomb", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Pop-up Powerbomb", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Kevin Von Erich",
                height: "6'2\"",
                weight: 220,
                description: "The Texas Tornado. A dynamic and athletic member of the legendary Von Erich family, known for his signature Iron Claw.",
                baseHp: getRandomInt(88, 103),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(50, 70),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Iron Claw (hold)", damage: { min: 10, max: 16 }, baseHitChance: 0.80, stat: 'strength' }],
                    strike: [{ name: "Dropkick", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Flying Crossbody", damage: { min: 11, max: 17 }, baseHitChance: 0.70, stat: 'aerialAbility' }],
                    finisher: [{ name: "Iron Claw", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
            {
                name: "King Kong Bundy",
                height: "6'4\"",
                weight: 458,
                description: "The Walking Condominium. A massive super-heavyweight known for his five-count pin. Main evented WrestleMania 2 against Hulk Hogan. His size and presence made him a formidable heel in the 1980s WWF. Famous for his 'Avalanche' splash in the corner.",
                baseHp: 115,
                strength: 98,
                technicalAbility: 40,
                brawlingAbility: 95,
                stamina: 60,
                aerialAbility: 5,
                toughness: 98,
                moves: {
                    grapple: [{ name: "Big Splash", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Bearhug", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Avalanche Splash", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
            {
                name: "Kurt Angle",
                height: "6'0\"",
                weight: 220,
                description: "It's true, it's damn true! Olympic gold medalist who became one of wrestling's greatest performers. Multiple-time WWE and World Heavyweight Champion known for his technical wrestling ability. His ankle lock submission hold was one of wrestling's most feared finishing moves. Successfully transitioned from amateur wrestling to professional wrestling faster than almost anyone.",
                baseHp: 105,
                strength: 89,
                technicalAbility: 97,
                brawlingAbility: 87,
                stamina: 95,
                aerialAbility: 50,
                toughness: 94,
                moves: {
                    grapple: [{ name: "Angle Slam", damage: { min: 12, max: 17 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Moonsault", damage: { min: 12, max: 17 }, baseHitChance: 0.79, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Top Rope Belly-to-Belly", damage: { min: 14, max: 19 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Ankle Lock", damage: { min: 24, max: 34 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Larry Zbyszko",
                height: "6'1\"",
                weight: 240,
                description: "The Living Legend. Technically gifted and a master of mind games.",
                baseHp: 100,
                strength: 76,
                technicalAbility: 92,
                brawlingAbility: 76,
                stamina: 89,
                aerialAbility: 25,
                toughness: 84,
                moves: {
                    grapple: [{ name: "Abdominal Stretch", damage: { min: 10, max: 14 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "Side Kick", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Larryland Dreamer (Guillotine Choke)", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Lex Luger",
                height: "6'4\"",
                weight: 275,
                description: "The Total Package. Known for his incredible physique and his torture rack finishing move. Multiple-time World Champion in both WCW and brief runs in WWE. His patriotic character in WWE was an 'attempt to replace Hulk Hogan as the company's top babyface'. Had career-defining feuds with Sting and Hulk Hogan. His career was cut short by spinal cord injuries that left him temporarily paralyzed.",
                baseHp: 110,
                strength: 98,
                technicalAbility: 70,
                brawlingAbility: 93,
                stamina: 92,
                aerialAbility: 30,
                toughness: 94,
                moves: {
                    grapple: [{ name: "Bionic Forearm", damage: { min: 10, max: 18 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Clothesline", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'strength' }],
                    highFlying: [{ name: "Powerslam", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'strength' }],
                    finisher: [{ name: "Torture Rack", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Lord Steven Regal",
                height: "6'2\"",
                weight: 240,
                description: "The Gentleman Villain. Master technician known for his European wrestling style and his Regal Stretch submission hold. Multiple-time Intercontinental Champion and television champion who elevated every title he held. His matches were wrestling clinics that showcased pure technical skill and old-school psychology. Successfully transitioned to trainer and talent scout, helping develop future WWE stars at the Performance Center. His knowledge of wrestling fundamentals and ability to teach made him invaluable behind the scenes.",
                baseHp: 100,
                strength: 82,
                technicalAbility: 96,
                brawlingAbility: 85,
                stamina: 93,
                aerialAbility: 40,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Regal Cutter", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "European uppercut", damage: { min: 12, max: 14 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Knee Trembler", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Regal Stretch", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Luke Harper",
                height: "6'5\"",
                weight: 275,
                description: "The Exalted One. Powerful, agile, and intense.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 95),
                technicalAbility: getRandomInt(65, 80),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(30, 50),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Discus Lariat", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    strike: [{ name: "Truck Stop (spinning side slam)", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' }],
                    highFlying: [{ name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Brodie Bomb (Running Senton)", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Macho Man Randy Savage",
                height: "6'1\"",
                weight: 237,
                description: "Ohhh Yeah! Two-time WWE Champion known for his flamboyant personality and colorful attire. His relationship with Miss Elizabeth was one of wrestling's greatest love stories. His flying elbow drop from the top rope was his signature finishing move. Master of the microphone with unforgettable catchphrases and promos. His match with Ricky Steamboat at WrestleMania III is considered one of the greatest ever.",
                baseHp: 105,
                strength: 89,
                technicalAbility: 84,
                brawlingAbility: 94,
                stamina: 95,
                aerialAbility: 90,
                toughness: 85,
                moves: {
                    grapple: [{ name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Axe Handle Drop", damage: { min: 13, max: 19 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Flying Crossbody", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Diving Elbow Drop", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Mark Henry",
                height: "6'4\"",
                weight: 412,
                description: "The World's Strongest Man. An absolute powerhouse.",
                baseHp: 105,
                strength: 99,
                technicalAbility: 50,
                brawlingAbility: 90,
                stamina: 79,
                aerialAbility: 5,
                toughness: 89,
                moves: {
                    grapple: [{ name: "World's Strongest Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Big Splash", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    highFlying: [{ name: "Press Slam", damage: { min: 12, max: 17 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Mark Henry's Powerslam", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
            {
                name: "Meng",
                height: "6'0\"",
                weight: 290,
                description: "The King of Tonga. Considered one of the most legitimately tough wrestlers in history, feared by his peers for his real-life street-fighting ability. Known for his Tongan Death Grip finishing move that was portrayed as a nerve hold. Multiple-time tag team champion both as part of The Islanders with Haku and solo runs. His reputation for being unbeatable in street fights made him one of wrestling's most respected figures backstage. Stories of his legendary toughness became part of wrestling folklore, with fellow wrestlers sharing tales of his incredible strength and pain tolerance.",
                baseHp: 105,
                strength: 94,
                technicalAbility: 75,
                brawlingAbility: 99,
                stamina: 82,
                aerialAbility: 64,
                toughness: 100,
                moves: {
                    grapple: [{ name: "Savate Kick", damage: { min: 13, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Asiatic Spike", damage: { min: 12, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Flying Headbutt", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Tongan Death Grip", damage: { min: 25, max: 39 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Michael Hayes",
                height: "6'1\"",
                weight: 235,
                description: "The leader of the Fabulous Freebirds! A charismatic brawler and innovator.",
                baseHp: 90,
                strength: 75,
                technicalAbility: 65,
                brawlingAbility: 90,
                stamina: 78,
                aerialAbility: 40,
                toughness: 85,
                moves: {
                    grapple: [{ name: "DDT", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Left Hand Punch", damage: { min: 12, max: 14 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Top Rope Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Freebird DDT", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Mick Foley",
                height: "6'2\"",
                weight: 287,
                description: "The Hardcore Legend. Three-time WWE Champion known for his hardcore wrestling style and multiple personalities (Mankind, Cactus Jack, Dude Love). His Hell in a Cell match with The Undertaker is one of wrestling's most brutal and memorable encounters. Successful author with multiple bestselling books. His ability to take punishment and tell compelling stories made him one of wrestling's most beloved figures. Known for his intelligence and articulate interviews outside the ring.",
                baseHp: 100,
                strength: 80,
                technicalAbility: 78,
                brawlingAbility: 94,
                stamina: 91,
                aerialAbility: 30,
                toughness: 100,
                moves: {
                    grapple: [{ name: "Double Arm DDT", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Elbow Drop (from apron)", damage: { min: 9, max: 16 }, baseHitChance: 0.65, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Running Knee", damage: { min: 8, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Mandible Claw", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Mike Rotunda",
                height: "6'1\"",
                weight: 252,
                description: "Irwin R. Schyster (IRS). A calculating taxman who gets his due.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(75, 90),
                brawlingAbility: getRandomInt(65, 80),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Abdominal Stretch", damage: { min: 8, max: 13 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Falling Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Write-Off (Stock Market Crash)", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Nick Bockwinkel",
                height: "6'1\"",
                weight: 235,
                description: "The Smartest Wrestler Alive. A scientific and articulate champion.",
                baseHp: 100,
                strength: 82,
                technicalAbility: 96,
                brawlingAbility: 74,
                stamina: 89,
                aerialAbility: 28,
                toughness: 86,
                moves: {
                    grapple: [{ name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Atomic Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' }],
                    highFlying: [{ name: "Figure-Four Leglock", damage: { min: 14, max: 19 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    finisher: [{ name: "Bockwinkel's Sleeper", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Nikita Koloff",
                height: "6'2\"",
                weight: 275,
                description: "The Russian Nightmare. A powerful and intense Soviet-era wrestler.",
                baseHp: 100,
                strength: 92,
                technicalAbility: 74,
                brawlingAbility: 91,
                stamina: 88,
                aerialAbility: 24,
                toughness: 86,
                moves: {
                    grapple: [{ name: "Bearhug", damage: { min: 14, max: 17 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Russian Sickle (Clothesline)", damage: { min: 18, max: 25 }, baseHitChance: 0.9, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Running Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Russian Sickle", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Omos",
                height: "7'3\"",
                weight: 403,
                description: "The Nigerian Giant. Imposing size and strength.",
                baseHp: getRandomInt(150, 170),
                strength: getRandomInt(98, 100),
                technicalAbility: getRandomInt(20, 40),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(50, 65),
                aerialAbility: getRandomInt(1, 5),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Chokeslam", damage: { min: 14, max: 19 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Big Boot", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' }],
                    highFlying: [{ name: "Press Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Two-Handed Chokeslam", damage: { min: 35, max: 45 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
            {
                name: "One Man Gang",
                height: "6'9\"",
                weight: 450,
                description: "The One Man Gang. A monstrous brawler from the Deep South, managed by Slick. Later became Akeem, the African Dream. His sheer size and brute force made him a formidable opponent. Had memorable feuds with Hulk Hogan and Randy Savage. His intimidating presence was a highlight of the late 80s WWF.",
                baseHp: 110,
                strength: 97,
                technicalAbility: 45,
                brawlingAbility: 95,
                stamina: 65,
                aerialAbility: 10,
                toughness: 95,
                moves: {
                    grapple: [{ name: "747 Splash", damage: { min: 15, max: 20 }, baseHitChance: 0.75, stat: 'strength' }],
                    strike: [{ name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Backbreaker", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Avalanche Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Owen Hart",
                height: "5'10\"",
                weight: 227,
                description: "The King of Harts. High-flying and technically gifted.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(90, 100),
                brawlingAbility: getRandomInt(60, 80),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(85, 100),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Bridging German Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Spinning Heel Kick", damage: { min: 11, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    finisher: [{ name: "Sharpshooter", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Paul Orndorff",
                height: "6'0\"",
                weight: 249,
                description: "Mr. Wonderful. A charismatic and arrogant powerhouse. Main evented the first WrestleMania alongside Roddy Piper against Hulk Hogan and Mr. T. Known for his incredible physique and intense rivalries. Had a memorable run as Hulk Hogan's tag team partner before a bitter feud ensued. His piledriver was a feared finishing move. A key villain in the golden era of professional wrestling.",
                baseHp: 100,
                strength: 94,
                technicalAbility: 80,
                brawlingAbility: 90,
                stamina: 85,
                aerialAbility: 35,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Full Nelson", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Forearm Smash", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Bodyslam", damage: { min: 9, max: 15 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Piledriver", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "R-Truth",
                height: "6'2\"",
                weight: 228,
                description: "Truth will set you free! Energetic and comedic, but can get serious.",
                baseHp: getRandomInt(80, 95),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(60, 75),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Lie Detector (Corkscrew Scissor Kick)", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'aerialAbility' }],
                    strike: [{ name: "Little Jimmy (jumping reverse STO)", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Flying Forearm", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Axe Kick", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Randy Orton",
                height: "6'5\"",
                weight: 250,
                description: "The Viper. Apex Predator with a cunning mind.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(20, 40),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Punt Kick", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "DDT", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Powerslam", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "RKO", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Rey Mysterio",
                height: "5'6\"",
                weight: 175,
                description: "The Master of the 619! Master of lucha libre who revolutionized cruiserweight wrestling in America. World Heavyweight Champion despite his small stature, proving that size doesn't always matter. His 619 finishing move became one of wrestling's most popular signature moves. Multiple-time Intercontinental and tag team champion with incredible longevity. His matches with Eddie Guerrero are considered classics of storytelling and athleticism.",
                baseHp: 95,
                strength: 60,
                technicalAbility: 92,
                brawlingAbility: 81,
                stamina: 92,
                aerialAbility: 97,
                toughness: 80,
                moves: {
                    grapple: [{ name: "Springboard Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'aerialAbility' }],
                    strike: [{ name: "West Coast Pop", damage: { min: 13, max: 19 }, baseHitChance: 0.8, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Hurricanrana", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "619", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Rhyno",
                height: "5'10\"",
                weight: 295,
                description: "The Man Beast. Known for his intense, hard-hitting style and his signature Gore finisher. Former ECW World Heavyweight Champion and multiple-time Hardcore Champion. His aggressive demeanor and powerful moves made him a fan favorite in ECW, WWE, and TNA. A truly impactful brawler.",
                baseHp: 100,
                strength: 90,
                technicalAbility: 65,
                brawlingAbility: 95,
                stamina: 80,
                aerialAbility: 20,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Spinebuster", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Piledriver", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Belly-to-Belly Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' }],
                    finisher: [{ name: "Gore", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Ric Flair",
                height: "6'1\"",
                weight: 243,
                description: "The Nature Boy! 16-time World Champion and arguably the greatest professional wrestler of all time. Known for his lavish lifestyle, custom suits, and \"Woo!\" catchphrase. Leader of The Four Horsemen, wrestling's most influential stable. His matches with Ricky Steamboat, Dusty Rhodes, and Sting are considered classics. Master of psychology and storytelling who could have a great match with anyone. His \"To be the man, you gotta beat the man\" promo is legendary.",
                baseHp: 110,
                strength: 77,
                technicalAbility: 95,
                brawlingAbility: 88,
                stamina: 100,
                aerialAbility: 35,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Chop!", damage: { min: 11, max: 16 }, baseHitChance: 0.9, stat: 'brawlingAbility' }],
                    strike: [{ name: "Knee Drop", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    finisher: [{ name: "Figure-Four Leglock", damage: { min: 20, max: 38 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Rick Rude",
                height: "6'3\"",
                weight: 252,
                description: "The Ravishing One. Arrogant and in incredible shape.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(20, 40),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Neckbreaker", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' }],
                    finisher: [{ name: "Rude Awakening", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Rick Steiner",
                height: "5'11\"",
                weight: 250,
                description: "The Dog-Faced Gremlin. A powerful and aggressive amateur wrestling powerhouse.",
                baseHp: 100,
                strength: 93,
                technicalAbility: 86,
                brawlingAbility: 90,
                stamina: 88,
                aerialAbility: 29,
                toughness: 86,
                moves: {
                    grapple: [{ name: "Steinerline", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Rebound Lariat", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Steiner Driver", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Ricky Steamboat",
                height: "5'10\"",
                weight: 225,
                description: "The Dragon. Known for his incredible athleticism, high-flying maneuvers, and technical prowess.",
                baseHp: 105,
                strength: 85,
                technicalAbility: 95,
                brawlingAbility: 72,
                stamina: 100,
                aerialAbility: 86,
                toughness: 87,
                moves: {
                    grapple: [{ name: "Arm Drag", damage: { min: 10, max: 16 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Chop", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Diving Crossbody", damage: { min: 12, max: 18 }, baseHitChance: 0.85, stat: 'aerialAbility' }],
                    finisher: [{ name: "Double Chicken Wing", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Road Warrior Animal",
                height: "6'2\"",
                weight: 280,
                description: "What a rush! The other half of the Legion of Doom.",
                baseHp: 105,
                strength: 95,
                technicalAbility: 55,
                brawlingAbility: 94,
                stamina: 80,
                aerialAbility: 40,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Power Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.82, stat: 'strength' }],
                    strike: [{ name: "Clothesline", damage: { min: 14, max: 16 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' }],
                    finisher: [{ name: "Powerslam", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Road Warrior Hawk",
                height: "6'3\"",
                weight: 260,
                description: "Ohhhhh, what a rush! Half of the Legion of Doom.",
                baseHp: 108,
                strength: 91,
                technicalAbility: 42,
                brawlingAbility: 94,
                stamina: 82,
                aerialAbility: 66,
                toughness: 91,
                moves: {
                    grapple: [{ name: "Clothesline", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Flying Shoulder Tackle", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' }],
                    highFlying: [{ name: "Powerslam", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Diving Clothesline", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Rob Van Dam",
                height: "6'0\"",
                weight: 245,
                description: "Mr. Pay Per View! One of a kind high-flying innovator.",
                baseHp: 100,
                strength: 75,
                technicalAbility: 83,
                brawlingAbility: 87,
                stamina: 88,
                aerialAbility: 92,
                toughness: 81,
                moves: {
                    grapple: [{ name: "Rolling Thunder", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    strike: [{ name: "Van Daminator (spinning heel kick)", damage: { min: 15, max: 19 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Split-Legged Moonsault", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Five-Star Frog Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Roddy Piper",
                height: "6'1\"",
                weight: 230,
                description: "Rowdy. One of the greatest talkers and most unpredictable.",
                baseHp: 100,
                strength: 83,
                technicalAbility: 81,
                brawlingAbility: 96,
                stamina: 90,
                aerialAbility: 20,
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Eye Poke", damage: { min: 5, max: 14 }, baseHitChance: 0.9, stat: 'brawlingAbility' }],
                    strike: [{ name: "Punch Flurry", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Low Blow", damage: { min: 11, max: 16 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Sleeper Hold", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Roman Reigns",
                height: "6'3\"",
                weight: 265,
                description: "The Tribal Chief. Head of the Table and Undisputed.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(90, 100),
                aerialAbility: getRandomInt(20, 40),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Superman Punch", damage: { min: 14, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    strike: [{ name: "Drive By (running dropkick)", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Samoan Drop", damage: { min: 13, max: 15 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Spear", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Ron Simmons",
                height: "6'2\"",
                weight: 270,
                description: "DAMN! Dominant and hard-hitting.",
                baseHp: 100,
                strength: 95,
                technicalAbility: 74,
                brawlingAbility: 93,
                stamina: 89,
                aerialAbility: 27,
                toughness: 94,
                moves: {
                    grapple: [{ name: "Spinebuster", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Powerbomb", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Dominator", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Ronnie Garvin",
                height: "5'10\"",
                weight: 215,
                description: "Rugged Ronnie Garvin. A tough, no-nonsense brawler and former NWA World Heavyweight Champion. Known for his stiff chops and his 'Hands of Stone' punch. Had a memorable feud with Ric Flair. A legitimate tough guy who brought a realistic fighting style to the ring.",
                baseHp: 95,
                strength: 75,
                technicalAbility: 70,
                brawlingAbility: 85,
                stamina: 80,
                aerialAbility: 20,
                toughness: 88,
                moves: {
                    grapple: [{ name: "Chop", damage: { min: 10, max: 15 }, baseHitChance: 0.75 }],
                    strike: [{ name: "Garvin Stomp", damage: { min: 8, max: 12 }, baseHitChance: 0.7 }],
                    highFlying: [{ name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.75 }],
                    finisher: [{ name: "Hands of Stone (KO Punch)", damage: { min: 25, max: 35 }, baseHitChance: 0.9 }]
                }
            },
            {
                name: "Sabu",
                height: "6'0\"",
                weight: 220,
                description: "The Homicidal, Suicidal, Genocidal, Death-Defying Maniac. An ECW original, known for his extreme high-flying and hardcore style. His willingness to take incredible risks and innovate with weapons made him a cult favorite. His matches were often chaotic and unforgettable, pushing the boundaries of professional wrestling.",
                baseHp: 90,
                strength: 70,
                technicalAbility: 75,
                brawlingAbility: 90,
                stamina: 85,
                aerialAbility: 95,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Triple Jump Moonsault", damage: { min: 15, max: 20 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    strike: [{ name: "Chair Shot", damage: { min: 10, max: 16 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Arabian Facebuster", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'aerialAbility' }],
                    finisher: [{ name: "Atomic Arabian Facebuster", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Samoa Joe",
                height: "6'2\"",
                weight: 282,
                description: "The Samoan Submission Machine. Brutal and dominant.",
                baseHp: 105,
                strength: 89,
                technicalAbility: 87,
                brawlingAbility: 94,
                stamina: 92,
                aerialAbility: 58,
                toughness: 96,
                moves: {
                    grapple: [{ name: "Muscle Buster", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Olé Kick", damage: { min: 12, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Diving Headbutt", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Coquina Clutch", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Scott Hall",
                height: "6'7\"",
                weight: 287,
                description: "The Bad Guy. Charismatic and cunning.",
                baseHp: 105,
                strength: 90,
                technicalAbility: 78,
                brawlingAbility: 88,
                stamina: 93,
                aerialAbility: 42,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.79, stat: 'brawlingAbility' }],
                    strike: [{ name: "Chop!", damage: { min: 10, max: 15 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Fallaway Slam", damage: { min: 14, max: 19 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Razor's Edge", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Scott Steiner",
                height: "6'1\"",
                weight: 276,
                description: "Big Poppa Pump. Genetically modified and mathematically superior.",
                baseHp: 100,
                strength: 97,
                technicalAbility: 84,
                brawlingAbility: 93,
                stamina: 92,
                aerialAbility: 58,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Frankensteiner", damage: { min: 13, max: 19 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Diving Blockbuster", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Top Rope Steinerline", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Steiner Recliner", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Seth Rollins",
                height: "6'1\"",
                weight: 217,
                description: "The Architect. Visionary and revolutionary.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(85, 100),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(70, 90),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Pedigree", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Frog Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Phoenix Splash", damage: { min: 13, max: 19 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    finisher: [{ name: "Curb Stomp", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'aerialAbility' }]
                }
            },
            {
                name: "Shawn Michaels",
                height: "6'1\"",
                weight: 225,
                description: "The Heartbreak Kid! Showstopper and highly agile performer.",
                baseHp: 110,
                strength: 76,
                technicalAbility: 92,
                brawlingAbility: 84,
                stamina: 100,
                aerialAbility: 89,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Flying Forearm", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'aerialAbility' }],
                    strike: [{ name: "Diving Elbow Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Teardrop Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    finisher: [{ name: "Sweet Chin Music", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Sheamus",
                height: "6'4\"",
                weight: 267,
                description: "The Celtic Warrior. A hard-hitting Irishman.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(20, 40),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Ten Beats of the Bodhran", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Irish Curse Backbreaker", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "White Noise", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Brogue Kick", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Shinsuke Nakamura",
                height: "6'2\"",
                weight: 229,
                description: "The King of Strong Style. Charismatic striker.",
                baseHp: 100,
                strength: 84,
                technicalAbility: 89,
                brawlingAbility: 94,
                stamina: 91,
                aerialAbility: 56,
                toughness: 85,
                moves: {
                    grapple: [{ name: "Good Vibrations (corner stomps)", damage: { min: 10, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Bomaye (running knee)", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Sliding German Suplex", damage: { min: 11, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    finisher: [{ name: "Kinshasa", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Sid Vicious",
                height: "6'9\"",
                weight: 303,
                description: "The Master and Ruler of the World. Unstable powerhouse.",
                baseHp: 100,
                strength: 95,
                technicalAbility: 56,
                brawlingAbility: 91,
                stamina: 78,
                aerialAbility: 41,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Big Boot", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Leg Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' }],
                    highFlying: [{ name: "Chokeslam", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' }],
                    finisher: [{ name: "Powerbomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Stan Hansen",
                height: "6'4\"",
                weight: 320,
                description: "The Lariat. A wild and intense Texan brawler.",
                baseHp: 105,
                strength: 93,
                technicalAbility: 68,
                brawlingAbility: 98,
                stamina: 89,
                aerialAbility: 20,
                toughness: 97,
                moves: {
                    grapple: [{ name: "Piledriver", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'brawlingAbility' }],
                    strike: [{ name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Belly-to-Back Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength' }],
                    finisher: [{ name: "Western Lariat", damage: { min: 30, max: 40 }, baseHitChance: 0.95, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Steve Williams",
                height: "6'1\"",
                weight: 275,
                description: "Dr. Death. A legitimate tough guy with a strong amateur wrestling background. Known for his powerful Oklahoma Stampede and his no-nonsense brawling style. Highly successful in Japan as part of the Miracle Violence Connection with Terry Gordy. His matches were always hard-hitting and believable, earning him immense respect from fans and peers alike.",
                baseHp: 105,
                strength: 95,
                technicalAbility: 80,
                brawlingAbility: 92,
                stamina: 90,
                aerialAbility: 20,
                toughness: 95,
                moves: {
                    grapple: [{ name: "Oklahoma Stampede", damage: { min: 15, max: 20 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Forearm Smash", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Suplex", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    finisher: [{ name: "Dangerous Backdrop", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Sting",
                height: "6'2\"",
                weight: 250,
                description: "The Icon! A dark and mysterious defender of justice.",
                baseHp: 105,
                strength: 92,
                technicalAbility: 84,
                brawlingAbility: 93,
                stamina: 98,
                aerialAbility: 78,
                toughness: 91,
                moves: {
                    grapple: [{ name: "Stinger Splash", damage: { min: 12, max: 16 }, baseHitChance: 0.95, stat: 'brawlingAbility' }],
                    strike: [{ name: "Scorpion Deathdrop", damage: { min: 14, max: 20 }, baseHitChance: 0.9, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Top Rope Crossbody", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    finisher: [{ name: "Scorpion Deathlock", damage: { min: 25, max: 38 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Stone Cold Steve Austin",
                height: "6'2\"",
                weight: 252,
                description: "The Texas Rattlesnake! A beer-swilling, rule-breaking anti-hero.",
                baseHp: 105,
                strength: 88,
                technicalAbility: 76,
                brawlingAbility: 96,
                stamina: 91,
                aerialAbility: 25,
                toughness: 91,
                moves: {
                    grapple: [{ name: "Lou Thesz Press", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Mudhole Stomp", damage: { min: 8, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Bionic Elbow", damage: { min: 7, max: 13 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Stone Cold Stunner", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Ted DiBiase",
                height: "6'3\"",
                weight: 249,
                description: "The Million Dollar Man. Everyone has a price!",
                baseHp: 100,
                strength: 78,
                technicalAbility: 90,
                brawlingAbility: 73,
                stamina: 91,
                aerialAbility: 24,
                toughness: 84,
                moves: {
                    grapple: [{ name: "Fist Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    strike: [{ name: "Back Elbow", damage: { min: 8, max: 13 }, baseHitChance: 0.6, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Hotshot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' }],
                    finisher: [{ name: "Million Dollar Dream", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Terry Funk",
                height: "6'1\"",
                weight: 249,
                description: "The Funker. Hardcore legend with incredible longevity.",
                baseHp: 100,
                strength: 86,
                technicalAbility: 80,
                brawlingAbility: 97,
                stamina: 93,
                aerialAbility: 31,
                toughness: 98,
                moves: {
                    grapple: [{ name: "Spinning Toe Hold", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' }],
                    strike: [{ name: "Taped Fist", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Diving Moonsault", damage: { min: 10, max: 16 }, baseHitChance: 0.65, stat: 'aerialAbility' }],
                    finisher: [{ name: "Texas Death Match Driver", damage: { min: 24, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "Terry Gordy",
                height: "6'3\"",
                weight: 280,
                description: "One of the Fabulous Freebirds. A tough and hard-hitting brawler.",
                baseHp: 105,
                strength: 89,
                technicalAbility: 74,
                brawlingAbility: 92,
                stamina: 90,
                aerialAbility: 30,
                toughness: 93,
                moves: {
                    grapple: [{ name: "Lariat", damage: { min: 14, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' }],
                    strike: [{ name: "Big Splash", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' }],
                    highFlying: [{ name: "Powerslam", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    finisher: [{ name: "Powerbomb", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "The Big Show",
                height: "7'0\"",
                weight: 450,
                description: "The World's Largest Athlete. A giant among men.",
                baseHp: 110,
                strength: 100,
                technicalAbility: 45,
                brawlingAbility: 93,
                stamina: 77,
                aerialAbility: 26,
                toughness: 92,
                moves: {
                    grapple: [{ name: "Knockout Punch", damage: { min: 12, max: 20 }, baseHitChance: 0.8, stat: 'strength' }],
                    strike: [{ name: "Banzai Drop", damage: { min: 10, max: 15 }, baseHitChance: 0.6, stat: 'strength' }],
                    highFlying: [{ name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Showstopper (Chokeslam)", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
            {
                name: "The Great Khali",
                height: "7'1\"",
                weight: 347,
                description: "The Punjabi Nightmare. A towering giant with immense power and an intimidating presence.",
                baseHp: 110,
                strength: 100,
                technicalAbility: 34,
                brawlingAbility: 91,
                stamina: 58,
                aerialAbility: 12,
                toughness: 93,
                moves: {
                    grapple: [{ name: "Vice Grip", damage: { min: 18, max: 25 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Punjabi Chop", damage: { min: 15, max: 22 }, baseHitChance: 0.80, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.60, stat: 'strength' }],
                    finisher: [{ name: "Khali Bomb", damage: { min: 35, max: 45 }, baseHitChance: 0.90, stat: 'strength' }]
                }
            },
            {
                name: "The Great Muta",
                height: "6'2\"",
                weight: 236,
                description: "The Essence of Muta. A mystical and dangerous Japanese legend.",
                baseHp: 100,
                strength: 81,
                technicalAbility: 86,
                brawlingAbility: 90,
                stamina: 92,
                aerialAbility: 94,
                toughness: 85,
                moves: {
                    grapple: [{ name: "Dragon Screw", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Handspring Elbow", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' }],
                    highFlying: [{ name: "Flash Elbow", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Moonsault", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'aerialAbility' }]
                }
            },
            {
                name: "The Iron Sheik",
                height: "6'0\"",
                weight: 260,
                description: "The Iron Sheik. Former WWE Champion and one of wrestling's most iconic villains. Known for his anti-American promos and his Camel Clutch submission hold. His feud with Hulk Hogan helped launch the Hulkamania era. A true legend of the Golden Era.",
                baseHp: 95,
                strength: 80,
                technicalAbility: 60,
                brawlingAbility: 85,
                stamina: 70,
                aerialAbility: 10,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Gutwrench Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.75 }],
                    strike: [{ name: "Forearm Shot", damage: { min: 8, max: 12 }, baseHitChance: 0.65 }],
                    highFlying: [{ name: "Belly-to-Belly Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.7 }],
                    finisher: [{ name: "Camel Clutch", damage: { min: 25, max: 35 }, baseHitChance: 0.95 }]
                }
            },
            {
                name: "The Miz",
                height: "6'2\"",
                weight: 221,
                description: "The A-Lister. Arrogant, cunning, and surprisingly resilient.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(30, 50),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: [{ name: "Skull-Crushing Finale", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Reality Check (running knee lift)", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Awesome Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Figure-Four Leglock", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "The Rock",
                height: "6'4\"",
                weight: 270,
                description: "The Most Electrifying Man in Sports Entertainment! Charismatic and powerful.",
                baseHp: 105,
                strength: 90,
                technicalAbility: 78,
                brawlingAbility: 91,
                stamina: 90,
                aerialAbility: 35,
                toughness: 89,
                moves: {
                    grapple: [{ name: "Sharpshooter", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'technicalAbility' }],
                    strike: [{ name: "Samoan Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength' }],
                    highFlying: [{ name: "Flying Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' }],
                    finisher: [{ name: "People's Elbow", damage: { min: 22, max: 32 }, baseHitChance: 0.88, stat: 'brawlingAbility' }]
                }
            },
            {
                name: "The Undertaker",
                height: "6'10\"",
                weight: 309,
                description: "The Deadman. A mystical force with unparalleled longevity.",
                baseHp: 115,
                strength: 94,
                technicalAbility: 71,
                brawlingAbility: 94,
                stamina: 84,
                aerialAbility: 39,
                toughness: 96,
                moves: {
                    grapple: [{ name: "Chokeslam", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Old School (Arm Walk)", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'technicalAbility' }],
                    highFlying: [{ name: "Flying Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Tombstone Piledriver", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Triple H",
                height: "6'4\"",
                weight: 256,
                description: "The Game! The Cerebral Assassin! King of Kings.",
                baseHp: 105,
                strength: 92,
                technicalAbility: 88,
                brawlingAbility: 94,
                stamina: 91,
                aerialAbility: 28,
                toughness: 93,
                moves: {
                    grapple: [{ name: "Spinebuster", damage: { min: 12, max: 19 }, baseHitChance: 0.78, stat: 'strength' }],
                    strike: [{ name: "Knee Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'strength' }],
                    highFlying: [{ name: "Facebreaker Knee Smash", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    finisher: [{ name: "Pedigree", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Tully Blanchard",
                height: "5'10\"",
                weight: 220,
                description: "The Brain Buster. An original member of the Four Horsemen, known for his cunning, aggression, and technical prowess. Held multiple championships, including the NWA National Heavyweight and US Heavyweight titles. Renowned for his feuds with Dusty Rhodes and Magnum T.A. and his tag team with Arn Anderson. Later became a successful manager, guiding many top stars. His sharp mind for wrestling psychology made him a formidable opponent and a respected figure.",
                baseHp: 98,
                strength: 75,
                technicalAbility: 90,
                brawlingAbility: 80,
                stamina: 88,
                aerialAbility: 35,
                toughness: 82,
                moves: {
                    grapple: [{ name: "Figure-Four Leglock", damage: { min: 10, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    strike: [{ name: "Knee Drop", damage: { min: 9, max: 15 }, baseHitChance: 0.75, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Piledriver", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' }],
                    finisher: [{ name: "Slingshot Suplex", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'technicalAbility' }]
                }
            },
            {
                name: "Ultimate Warrior",
                height: "6'4\"",
                weight: 280,
                description: "Feel the power of the Warrior! Intense and energetic.",
                baseHp: 110,
                strength: 98,
                technicalAbility: 43,
                brawlingAbility: 90,
                stamina: 81,
                aerialAbility: 25,
                toughness: 90,
                moves: {
                    grapple: [{ name: "Gorilla Press Slam", damage: { min: 11, max: 19 }, baseHitChance: 0.85, stat: 'strength' }],
                    strike: [{ name: "Flying Clothesline", damage: { min: 13, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    highFlying: [{ name: "Big Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Warrior Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }]
                }
            },
            {
                name: "Vader",
                height: "6'5\"",
                weight: 350,
                description: "The Mastodon. A dominant super-heavyweight.",
                baseHp: 105,
                strength: 98,
                technicalAbility: 65,
                brawlingAbility: 96,
                stamina: 87,
                aerialAbility: 41,
                toughness: 96,
                moves: {
                    grapple: [{ name: "Fist Strikes", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' }],
                    strike: [{ name: "Moonsault (from top)", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    highFlying: [{ name: "Chokeslam", damage: { min: 10, max: 18 }, baseHitChance: 0.7, stat: 'strength' }],
                    finisher: [{ name: "Vader Bomb", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }]
                }
            },
        ];


        // User's move pool - new moves unlock as level increases
        const userMovesPool = {
            grapple: [
                { name: "Body Slam", damage: { min: 8, max: 12 }, baseHitChance: 0.7, stat: 'strength', levelRequired: 1 },
                { name: "Snap Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'technicalAbility', levelRequired: 3 },
                { name: "Powerslam", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength', levelRequired: 6 },
                { name: "German Suplex", damage: { min: 14, max: 20 }, baseHitChance: 0.85, stat: 'technicalAbility', levelRequired: 10 },
                { name: "Piledriver", damage: { min: 16, max: 22 }, baseHitChance: 0.88, stat: 'strength', levelRequired: 15 },
                { name: "Brainbuster", damage: { min: 18, max: 25 }, baseHitChance: 0.9, stat: 'technicalAbility', levelRequired: 20 }
            ],
            strike: [
                { name: "Punch Combo", damage: { min: 7, max: 11 }, baseHitChance: 0.65, stat: 'brawlingAbility', levelRequired: 1 },
                { name: "Dropkick", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'aerialAbility', levelRequired: 4 },
                { name: "Superkick", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility', levelRequired: 8 },
                { name: "Forearm Smash", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'strength', levelRequired: 12 },
                { name: "Spinning Backfist", damage: { min: 15, max: 20 }, baseHitChance: 0.82, stat: 'brawlingAbility', levelRequired: 18 }
            ],
            highFlying: [
                { name: "Basic Dropkick", damage: { min: 6, max: 10 }, baseHitChance: 0.6, stat: 'aerialAbility', levelRequired: 1 },
                { name: "Crossbody", damage: { min: 8, max: 13 }, baseHitChance: 0.68, stat: 'aerialAbility', levelRequired: 5 },
                { name: "Missile Dropkick", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'aerialAbility', levelRequired: 9 },
                { name: "Springboard Moonsault", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility', levelRequired: 14 },
                { name: "450 Splash", damage: { min: 14, max: 19 }, baseHitChance: 0.78, stat: 'aerialAbility', levelRequired: 19 }
            ],
            finisher: [
                { name: "Rookie Driver", damage: { min: 18, max: 25 }, baseHitChance: 0.8, stat: 'strength', levelRequired: 1 },
                { name: "Prospect Slam", damage: { min: 22, max: 30 }, baseHitChance: 0.85, stat: 'strength', levelRequired: 7 },
                { name: "Rising Star Suplex", damage: { min: 26, max: 35 }, baseHitChance: 0.88, stat: 'technicalAbility', levelRequired: 13 },
                { name: "Legend Maker", damage: { min: 30, max: 40 }, baseHitChance: 0.9, stat: 'brawlingAbility', levelRequired: 20 }
            ]
        };

        // Manager Data
        const managersData = [
            {
                name: "Bobby 'The Brain' Heenan",
                image: "heenan", // Assuming image filename like heenan.webp
                cost: 500,
                description: "The Weasel! A master strategist and one of the greatest managers of all time. Known for his quick wit and ability to get under anyone's skin. His clients often found themselves in championship contention.",
                xpBonus: 0.20, // 20% more XP
                goldBonus: 0.10, // 10% more Gold
                statBoosts: { technicalAbility: 5, brawlingAbility: 5 }, // Boosts multiple stats
                interferenceChance: 0.05 // 5% chance to interfere
            },
            {
                name: "Paul Bearer",
                image: "bearer", // Assuming image filename like paulbearer.webp
                cost: 400,
                description: "Ohhh Yessss! The macabre manager of The Undertaker and Kane. His urn held the source of their power, and his ghostly presence struck fear into opponents.",
                xpBonus: 0.15,
                goldBonus: 0.05,
                statBoosts: { toughness: 10 }, // Boosts toughness significantly
                interferenceChance: 0.07 // 7% chance to interfere
            },
            {
                name: "Miss Elizabeth",
                image: "elizabeth", // Assuming image filename like elizabeth.webp
                cost: 300,
                description: "The First Lady of Wrestling. Known for her elegance and grace, she was the beloved manager of Randy 'Macho Man' Savage. Her presence often inspired her clients to victory.",
                xpBonus: 0.10,
                goldBonus: 0.08,
                statBoosts: { stamina: 8 }, // Boosts stamina
                interferenceChance: 0.03 // 3% chance (less direct interference)
            },
            {
                name: "Jim Cornette",
                image: "cornette", // Assuming image filename like cornette.webp
                cost: 600,
                description: "The Louisville Lip. A controversial but brilliant manager, known for his fiery promos and tennis racket. His teams, like The Midnight Express, were among the best.",
                xpBonus: 0.25,
                goldBonus: 0.12,
                statBoosts: { strength: 7, aerialAbility: 3, technicalAbility: 7 }, // Boosts multiple stats
                interferenceChance: 0.08 // 8% chance to interfere
            },
            {
                name: "Captain Lou Albano",
                image: "albano", // Assuming image filename like albano.webp
                cost: 350,
                description: "The Guiding Light! Eccentric and boisterous, Captain Lou managed numerous tag teams to championship gold. His wild appearance and antics made him unforgettable.",
                xpBonus: 0.12,
                goldBonus: 0.07,
                statBoosts: { brawlingAbility: 10 }, // Boosts brawling
                interferenceChance: 0.06 // 6% chance to interfere
            },
            {
                name: "Paul Heyman",
                image: "heyman", // Assuming image filename like heyman.webp
                cost: 700,
                description: "The Advocate. A brilliant orator and master manipulator, Paul Heyman has guided numerous champions to greatness. His strategic mind can turn any match in your favor.",
                xpBonus: 0.30, // 30% more XP
                goldBonus: 0.15, // 15% more Gold
                statBoosts: { technicalAbility: 8, brawlingAbility: 8 }, // Boosts technical and brawling
                interferenceChance: 0.07 // 7% chance to interfere
            }
        ];


        // Function to calculate a wrestler's overall rating by eliminating the weakest attribute
        function calculateOverallRating(wrestler) {
            const stats = [
                wrestler.strength,
                wrestler.technicalAbility,
                wrestler.brawlingAbility,
                wrestler.stamina,
                wrestler.aerialAbility,
                wrestler.toughness // Include toughness in overall calculation
            ];
            
            // Find the lowest stat
            const minStat = Math.min(...stats);
            
            // Create a new array excluding the first occurrence of the lowest stat
            let filteredStats = [...stats];
            const minIndex = filteredStats.indexOf(minStat);
            if (minIndex > -1) {
                filteredStats.splice(minIndex, 1);
            }
            
            // Calculate the sum of the remaining stats
            const sum = filteredStats.reduce((acc, stat) => acc + stat, 0);
            
            // Average the remaining stats (divide by 5 instead of 6, as one was removed)
            return Math.round(sum / filteredStats.length); 
        }

        // Add overall rating to each wrestler object
        wrestlersData.forEach(wrestler => {
            wrestler.overallRating = calculateOverallRating(wrestler);
        });

        // Sort wrestlersData alphabetically by name
        wrestlersData.sort((a, b) => a.name.localeCompare(b.name));

        // --- User Wrestler Definition ---
        let userWrestler = {
            name: "Your Prospect", // This will be updated by user input
            avatar: "prospect1", // Default avatar, will be updated by user selection
            height: "6'0\"",
            weight: 220,
            description: "An aspiring wrestling superstar, ready to climb the ranks!",
            baseHp: 80, // Starting HP
            baseStrength: 50,
            baseTechnicalAbility: 50,
            baseBrawlingAbility: 50,
            baseStamina: 50,
            baseAerialAbility: 50,
            baseToughness: 50,
            // Effective stats will be calculated based on base stats + manager boosts
            effectiveStrength: 50,
            effectiveTechnicalAbility: 50,
            effectiveBrawlingAbility: 50,
            effectiveStamina: 50,
            effectiveAerialAbility: 50,
            effectiveToughness: 50,
            // Initialize moves as arrays, taking the first move from the userMovesPool
            moves: {
                grapple: [userMovesPool.grapple[0]],
                strike: [userMovesPool.strike[0]],
                highFlying: [userMovesPool.highFlying[0]],
                finisher: [userMovesPool.finisher[0]]
            },
            level: 1,
            experience: 0,
            xpToNextLevel: 100,
            overallRating: 0, // Will be calculated on init
            manager: null // Stores the hired manager object
        };
        // Calculate initial effective stats and overall rating
        calculateEffectiveStats(); // Call this once after userWrestler is defined
        userWrestler.overallRating = calculateOverallRating(userWrestler);

        let userGold = 1000; // Initial gold coins
        let currentManager = null; // Stores the currently hired manager

        let opponentWrestler = null; // Stores the currently selected opponent

        let isLoading = false;

        // DOM Elements
        const goldDisplay = document.getElementById('gold-display');
        const p1Slot = document.getElementById('p1-slot'); // Your Wrestler slot
        const p3Slot = document.getElementById('p3-slot'); // Opponent slot
        const dropZones = [p3Slot]; // Only opponent slot is a dropzone

        const wrestlersContainer = document.getElementById('wrestlers-container');
        const simulateButton = document.getElementById('simulate-button');
        const randomMatchupButton = document.getElementById('random-matchup-button');
        const resetButton = document.getElementById('reset-button');
        const battleLogElement = document.getElementById('battle-log');
        
        const matchOutcomeModal = document.getElementById('match-outcome-modal');
        const closeModalButton = document.getElementById('close-modal-button');

        const matchWinnerNameElement = document.getElementById('match-winner-name');
        const winnerImagesContainer = document.getElementById('winner-images-container'); 
        const winnerDescriptionElement = document.getElementById('winner-description');
        const simulateSpinner = document.getElementById('simulate-spinner');
        const simulatePlayIcon = document.getElementById('simulate-play-icon');
        const messageBox = document.getElementById('message-box');

        // User Profile Elements
        const myWrestlerCardDisplay = document.getElementById('my-wrestler-card-display');
        const userLevelElement = document.getElementById('user-level');
        const userXpElement = document.getElementById('user-xp');
        const userXpNeededElement = document.getElementById('user-xp-needed');
        const userXpBar = document.getElementById('user-xp-bar');
        const skillTrainingButtonsContainer = document.getElementById('skill-training-buttons');
        // const currentManagerDisplay = document.getElementById('current-manager-display'); // This was duplicated
        // const availableManagersContainer = document.getElementById('available-managers-container'); // This element doesn't exist in HTML

        // Manager Section Elements
        const managersContainer = document.getElementById('managers-container');
        const currentManagerDisplay = document.getElementById('current-manager-display');

        // Initial Setup Modal Elements
        const initialSetupModal = document.getElementById('initial-setup-modal');
        const prospectNameInput = document.getElementById('prospect-name-input');
        const prospectHeightInput = document.getElementById('prospect-height-input'); // New
        const prospectWeightInput = document.getElementById('prospect-weight-input'); // New
        const avatarSelection = document.getElementById('avatar-selection');
        const startGameButton = document.getElementById('start-game-button');
        let selectedAvatar = userWrestler.avatar; // Keep track of selected avatar

        /**
         * Calculates the effective stats of the user's wrestler by applying manager boosts.
         * This function should be called whenever base stats or the manager changes.
         */
        function calculateEffectiveStats() {
            const stats = ['strength', 'technicalAbility', 'brawlingAbility', 'stamina', 'aerialAbility', 'toughness'];
            stats.forEach(stat => {
                const baseStatName = `base${stat.charAt(0).toUpperCase() + stat.slice(1)}`;
                const effectiveStatName = `effective${stat.charAt(0).toUpperCase() + stat.slice(1)}`;
                let effectiveValue = userWrestler[baseStatName];

                if (userWrestler.manager && userWrestler.manager.statBoosts && userWrestler.manager.statBoosts[stat]) {
                    effectiveValue += userWrestler.manager.statBoosts[stat];
                }
                userWrestler[effectiveStatName] = Math.min(100, effectiveValue); // Cap at 100
            });
            userWrestler.overallRating = calculateOverallRating(userWrestler);
        }

        // Function to update gold display
        function updateGoldDisplay() {
            goldDisplay.textContent = userGold.toFixed(0); // Display as integer
            updateTrainingButtons(); // Update training button states when gold changes
            populateManagers(); // Update manager buttons when gold changes
        }

        // Function to display messages to the user
        function showMessage(message, type = 'info') {
            messageBox.textContent = message;
            messageBox.classList.remove('hidden', 'bg-red-700', 'bg-green-700', 'bg-yellow-700', 'bg-gray-700', 'text-white', 'text-gray-900');
            
            // Set background color based on message type
            if (type === 'success') {
                messageBox.classList.add('bg-green-700');
            } else if (type === 'error') {
                messageBox.classList.add('bg-red-700');
            } else if (type === 'warning') {
                messageBox.classList.add('bg-yellow-700', 'text-gray-900'); // Yellow text for warning
            } else { // info or default
                messageBox.classList.add('bg-gray-700');
            }

            messageBox.classList.add('show');

            const duration = message.includes('Simulating match') ? 1000 : 5000;

            setTimeout(() => {
                messageBox.classList.remove('show');
                messageBox.addEventListener('transitionend', function handler() {
                    messageBox.classList.add('hidden');
                    messageBox.removeEventListener('transitionend', handler);
                }, { once: true });
            }, duration);
        }

        /**
         * Creates an HTML card for a wrestler.
         * @param {object} wrestler - The wrestler data object.
         * @param {boolean} isSmall - Whether to create a smaller card for dropzones.
         * @returns {HTMLElement} The created wrestler card element.
         */
        function createWrestlerCard(wrestler, isSmall = false) {
            const card = document.createElement('div');
            card.dataset.wrestlerName = wrestler.name; 
            card.id = `wrestler-card-${wrestler.name.replace(/\s/g, '-')}`; 

            const wrestlerImageName = getLastName(wrestler.name);
            const imageUrl = `${BASE_IMAGE_URL}${wrestlerImageName}.webp`;

            // Display the name of the first finisher in the array
            const finisherName = wrestler.moves.finisher && wrestler.moves.finisher.length > 0 
                                ? wrestler.moves.finisher[0].name 
                                : "No Finisher";

            if (isSmall) {
                card.className = 'wrestler-card-in-slot flex flex-col items-center justify-center text-center';
                card.innerHTML = `
                    <img src="${imageUrl}" alt="${wrestler.name}" class="w-16 h-16 rounded-full object-cover border-2 wrestler-image-border mb-1" onerror="this.onerror=null;this.src='https://placehold.co/64x64/1a1a1a/fff?text=${encodeURIComponent(wrestler.name.charAt(0))}'">
                    <p class="text-sm font-bold text-yellow-300 w-full truncate">${wrestler.name}</p>
                `;
            } else {
                card.className = 'wrestler-card p-4 rounded-xl flex flex-col items-center';
                // Only make draggable if not the user's prospect card
                if (wrestler.name !== userWrestler.name) { // Compare against actual userWrestler.name
                    card.draggable = true; 
                } else {
                    card.classList.add('cursor-default'); // Make user card not draggable
                }
                
                const statsHtml = `
                    <div class="w-full text-xs mt-2 space-y-1">
                        <div class="flex items-center mb-2">
                            <span class="w-20 text-gray-200 font-bold text-base">Overall:</span>
                            <div class="flex-1 h-4 rounded-full stat-bar-bg relative">
                                <div class="h-full rounded-full bg-yellow-500 p-2" style="width: ${wrestler.overallRating}%;"></div>
                                <span class="absolute top-0 right-1 text-xs text-white font-bold">${wrestler.overallRating}</span>
                            </div>
                        </div>
                        ${Object.keys(wrestler).map(key => {
                            if (['strength', 'technicalAbility', 'brawlingAbility', 'stamina', 'aerialAbility', 'toughness'].includes(key)) {
                                const value = wrestler[key];
                                const statName = key.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase()); 
                                let statBarClass = '';
                                switch (key) {
                                    case 'strength': statBarClass = 'stat-bar-strength'; break;
                                    case 'technicalAbility': statBarClass = 'stat-bar-technical'; break;
                                    case 'brawlingAbility': statBarClass = 'stat-bar-brawling'; break;
                                    case 'stamina': statBarClass = 'stat-bar-stamina'; break;
                                    case 'aerialAbility': statBarClass = 'stat-bar-aerial'; break;
                                    case 'toughness': statBarClass = 'stat-bar-toughness'; break; 
                                }
                                return `
                                    <div class="flex items-center">
                                        <span class="w-20 text-gray-300 font-semibold">${statName}:</span>
                                        <div class="flex-1 h-3 rounded-full stat-bar-bg relative">
                                            <div class="h-full rounded-full ${statBarClass}" style="width: ${value}%;"></div>
                                            <span class="absolute top-0 right-1 text-xs text-white">${value}</span>
                                        </div>
                                    </div>
                                `;
                            }
                            return '';
                        }).join('')}
                    </div>
                `;

                card.innerHTML = `
                    <img src="${imageUrl}" loading="lazy" alt="${wrestler.name}" class="w-48 h-48 rounded-full object-cover border-4 wrestler-image-border shadow-md mb-2" onerror="this.onerror=null;this.src='https://placehold.co/150x150/1a1a1a/fff?text=${encodeURIComponent(wrestler.name.replace(/\s/g, '+'))}';">
                    <p class="text-xl font-bold text-yellow-300 text-center mb-1">${wrestler.name}</p>
                    <p class="text-sm font-bold text-yellow-200 text-center mb-1">${wrestler.height} ${wrestler.weight} lbs</p>
                    <p class="text-xs font-semibold text-orange-400 text-center mb-2">Finisher: ${finisherName}</p>
                    <p class="text-sm text-gray-300 text-center mb-2 line-clamp-5">${wrestler.description}</p>
                    ${statsHtml}
                `;
            }
            return card;
        }

        /**
         * Updates the display of the user's wrestler profile.
         */
        function updateUserWrestlerProfile() {
            myWrestlerCardDisplay.innerHTML = '';
            const userCard = createWrestlerCard(userWrestler, false); // Full size card for profile
            // Remove draggable attribute from the user's own card in the profile display
            userCard.draggable = false;
            userCard.classList.add('cursor-default');
            myWrestlerCardDisplay.appendChild(userCard);

            userLevelElement.textContent = userWrestler.level;
            userXpElement.textContent = userWrestler.experience;
            userXpNeededElement.textContent = userWrestler.xpToNextLevel;
            const xpPercentage = (userWrestler.experience / userWrestler.xpToNextLevel) * 100;
            userXpBar.style.width = `${xpPercentage}%`;

            updateTrainingButtons(); // Update training button states
        }

        /**
         * Calculates the cost to train a specific skill.
         * @param {string} skillName - The name of the skill (e.g., 'strength').
         * @returns {number} The cost in gold.
         */
        function getTrainingCost(skillName) {
            const skillValue = userWrestler[`base${skillName.charAt(0).toUpperCase() + skillName.slice(1)}`];
            if (skillValue < 60) {
                return 25;
            } else if (skillValue >= 60 && skillValue < 70) {
                return 50;
            } else if (skillValue >= 70 && skillValue < 90) {
                return 75;
            } else { // skillValue >= 90
                return 100;
            }
        }

        /**
         * Dynamically creates and updates skill training buttons.
         */
        function updateTrainingButtons() {
            skillTrainingButtonsContainer.innerHTML = '';
            const skills = ['strength', 'technicalAbility', 'brawlingAbility', 'stamina', 'aerialAbility', 'toughness'];
            const skillDisplayNames = {
                strength: 'Strength',
                technicalAbility: 'Technical',
                brawlingAbility: 'Brawling',
                stamina: 'Stamina',
                aerialAbility: 'Aerial',
                toughness: 'Toughness'
            };

            skills.forEach(skill => {
                const currentSkillValue = userWrestler[`base${skill.charAt(0).toUpperCase() + skill.slice(1)}`]; // Check base stat for training cost
                const cost = getTrainingCost(skill);
                const button = document.createElement('button');
                button.className = 'framer-button framer-button-secondary text-sm flex items-center justify-between px-4 py-2';
                button.dataset.skill = skill;
                button.disabled = userGold < cost || currentSkillValue >= 100; // Disable if not enough gold or maxed out

                const skillNameSpan = document.createElement('span');
                skillNameSpan.textContent = skillDisplayNames[skill];
                skillNameSpan.className = 'font-bold';

                const costSpan = document.createElement('span');
                costSpan.className = 'text-yellow-300 ml-2';
                costSpan.innerHTML = `+1 (${cost} <svg class="w-4 h-4 inline-block align-middle text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>)`;

                if (currentSkillValue >= 100) {
                    costSpan.textContent = 'MAX';
                    costSpan.classList.remove('text-yellow-300');
                    costSpan.classList.add('text-green-400');
                }

                button.appendChild(skillNameSpan);
                button.appendChild(costSpan);
                skillTrainingButtonsContainer.appendChild(button);

                button.addEventListener('click', () => trainWrestler(skill));
            });
        }

        /**
         * Handles training a specific skill for the user's wrestler.
         * @param {string} skillName - The name of the skill to train.
         */
        function trainWrestler(skillName) {
            const baseStatName = `base${skillName.charAt(0).toUpperCase() + skillName.slice(1)}`;
            const currentSkillValue = userWrestler[baseStatName];
            const cost = getTrainingCost(skillName);

            if (currentSkillValue >= 100) {
                showMessage(`Your ${skillName} is already at maximum!`, 'warning');
                return;
            }

            if (userGold < cost) {
                showMessage(`Not enough gold to train ${skillName}! You need ${cost} gold.`, 'error');
                return;
            }

            userGold -= cost;
            userWrestler[baseStatName] = Math.min(100, currentSkillValue + 1); // Increase by 1, cap at 100
            calculateEffectiveStats(); // Recalculate effective stats after training
            updateGoldDisplay();
            updateUserWrestlerProfile();
            showMessage(`Your ${skillName.replace(/([A-Z])/g, ' $1').toLowerCase()} increased to ${userWrestler[baseStatName]}!`, 'success');
        }

        /**
         * Populates the available managers section.
         */
        function populateManagers() {
            managersContainer.innerHTML = '';
            managersData.forEach(manager => {
                const managerCard = document.createElement('div');
                managerCard.className = 'manager-card';
                if (userWrestler.manager && userWrestler.manager.name === manager.name) {
                    managerCard.classList.add('hired');
                }

                const managerImage = `${BASE_IMAGE_URL}${manager.image}.webp`;

                managerCard.innerHTML = `
                    <img src="${managerImage}" alt="${manager.name}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-600 mb-2" onerror="this.onerror=null;this.src='https://placehold.co/96x96/1a1a1a/fff?text=${encodeURIComponent(manager.name.replace(/\s/g, '+'))}';">
                    <h3 class="text-lg font-bold text-yellow-300 mb-1">${manager.name}</h3>
                    <p class="text-xs text-gray-400 mb-2 line-clamp-3">${manager.description}</p>
                    <p class="text-sm text-gray-300">Cost: <span class="text-yellow-400">${manager.cost}</span> <svg class="w-4 h-4 inline-block align-middle text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg></p>
                    <button class="framer-button framer-button-primary mt-3 px-4 py-2 text-sm" data-manager-name="${manager.name}" ${userWrestler.manager ? 'disabled' : ''}>
                        ${userWrestler.manager && userWrestler.manager.name === manager.name ? 'HIRED!' : 'Hire Manager'}
                    </button>
                `;
                managersContainer.appendChild(managerCard);

                const hireButton = managerCard.querySelector('button');
                hireButton.addEventListener('click', () => hireManager(manager));
            });

            // Update current manager display
            if (userWrestler.manager) {
                currentManagerDisplay.innerHTML = `
                    <p class="text-lg font-bold text-green-400">Current Manager: ${userWrestler.manager.name}</p>
                    <p class="text-sm text-gray-400">XP Bonus: +${(userWrestler.manager.xpBonus * 100).toFixed(0)}%</p>
                    <p class="text-sm text-gray-400">Gold Bonus: +${(userWrestler.manager.goldBonus * 100).toFixed(0)}%</p>
                    <p class="text-sm text-gray-400">Stat Boosts: ${Object.entries(userWrestler.manager.statBoosts || {}).map(([stat, value]) => `${stat.replace(/([A-Z])/g, ' $1').toLowerCase()}: +${value}`).join(', ') || 'None'}</p>
                `;
            } else {
                currentManagerDisplay.textContent = "No manager hired.";
            }
        }

        /**
         * Handles hiring a manager.
         * @param {object} manager - The manager object to hire.
         */
        function hireManager(manager) {
            if (userWrestler.manager) {
                showMessage("You already have a manager hired!", 'warning');
                return;
            }
            if (userGold < manager.cost) {
                showMessage(`Not enough gold to hire ${manager.name}! You need ${manager.cost} gold.`, 'error');
                return;
            }

            userGold -= manager.cost;
            userWrestler.manager = manager;
            calculateEffectiveStats(); // Recalculate effective stats after hiring manager
            updateGoldDisplay();
            updateUserWrestlerProfile(); // Re-render profile to show updated stats
            populateManagers(); // Re-render manager list to update button states
            showMessage(`You hired ${manager.name}!`, 'success');
        }

        // Populate available wrestlers (opponents)
        function populateWrestlers() {
            wrestlersContainer.innerHTML = '';
            wrestlersData
                .filter(wrestler => wrestler.name !== userWrestler.name && wrestler.name !== opponentWrestler?.name) // Exclude user and selected opponent
                .forEach(wrestler => {
                    const card = createWrestlerCard(wrestler);
                    wrestlersContainer.appendChild(card);
                });
            addDragListeners();
        }

        /**
         * Places a wrestler card into a specified dropzone, using the smaller card format.
         * @param {object} wrestler - The wrestler data object to place.
         * @param {HTMLElement} dropzoneElement - The dropzone element (e.g., p1-slot).
         */
        function placeWrestlerInDropzone(wrestler, dropzoneElement) {
            const card = createWrestlerCard(wrestler, true); // Create a small card
            dropzoneElement.innerHTML = '';
            dropzoneElement.appendChild(card);
            dropzoneElement.classList.add('has-wrestler');
        }


        // Handle drag and drop logic
        let draggedWrestler = null;

        function handleDragStart(e) {
            const draggedCardElement = e.target.closest('.wrestler-card');
            if (!draggedCardElement) return;

            const wrestlerName = draggedCardElement.dataset.wrestlerName;
            draggedWrestler = wrestlersData.find(w => w.name === wrestlerName);
            
            if (draggedWrestler) {
                e.dataTransfer.setData('text/plain', wrestlerName);
                draggedCardElement.classList.add('dragging');
                showMessage(`Dragging ${draggedWrestler.name}.`, 'info');
            } else {
                showMessage("Cannot drag an invalid wrestler card.", 'error');
            }
        }

        function handleDragEnd(e) {
            const draggedCardElement = e.target.closest('.wrestler-card');
            if (draggedCardElement) {
                draggedCardElement.classList.remove('dragging');
            }
            draggedWrestler = null;
        }

        function handleDragOver(e) {
            e.preventDefault();
            // Only allow drag over if the drop zone is the opponent slot and is empty
            if (e.currentTarget.id === 'p3-slot' && !e.currentTarget.classList.contains('has-wrestler')) {
                e.currentTarget.classList.add('drag-over');
            }
        }

        function handleDragLeave(e) {
            e.currentTarget.classList.remove('drag-over');
        }

        function handleDrop(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('drag-over');

            // Only allow drop on the opponent slot (p3-slot)
            if (e.currentTarget.id !== 'p3-slot') {
                showMessage("You can only drop opponents into the opponent slot.", 'warning');
                return;
            }

            const wrestlerName = e.dataTransfer.getData('text/plain');
            const wrestler = wrestlersData.find(w => w.name === wrestlerName);

            if (!wrestler) {
                showMessage("Could not find wrestler data. Drop canceled.", 'error');
                return;
            }

            if (e.currentTarget.classList.contains('has-wrestler')) {
                showMessage("This slot is already taken. Clear the opponent first!", 'warning');
                return;
            }

            if (wrestler.name === userWrestler.name) {
                showMessage("You cannot wrestle yourself!", 'error');
                return;
            }

            placeWrestlerInDropzone(wrestler, e.currentTarget);
            opponentWrestler = wrestler;

            showMessage(`${wrestler.name} selected as opponent!`, 'success');
            populateWrestlers(); // Re-render roster to remove selected opponent
            checkMatchReady();
        }

        function addDragListeners() {
            wrestlersContainer.querySelectorAll('.wrestler-card').forEach(card => {
                card.addEventListener('dragstart', handleDragStart);
                card.addEventListener('dragend', handleDragEnd);
            });

            dropZones.forEach(dz => {
                dz.addEventListener('dragover', handleDragOver);
                dz.addEventListener('dragleave', handleDragLeave);
                dz.addEventListener('drop', handleDrop);
            });
        }

        // Simplified checkMatchReady - no betting logic
        function checkMatchReady() {
            simulateButton.disabled = opponentWrestler === null;
        }

        async function simulateMatch() {
            if (isLoading) {
                showMessage("A simulation is already in progress.", 'warning');
                return;
            }

            isLoading = true;
            simulateButton.disabled = true;
            randomMatchupButton.disabled = true;
            resetButton.disabled = true;
            simulateSpinner.classList.remove('hidden');
            simulatePlayIcon.classList.add('hidden');
            
            // Ensure modal is hidden before starting simulation
            matchOutcomeModal.classList.remove('show');
            matchOutcomeModal.classList.add('hidden');
            
            battleLogElement.innerHTML = '<p class="text-gray-500">Simulating match...</p>';
            matchWinnerNameElement.textContent = '';
            winnerImagesContainer.innerHTML = ''; // Clear winner images container
            winnerDescriptionElement.textContent = '';


            const getWrestlerCopy = (wrestlerObj) => {
                const copy = JSON.parse(JSON.stringify(wrestlerObj));
                // Calculate current HP based on baseHp and stamina (stamina of 50 is neutral)
                copy.currentHp = Math.round(copy.baseHp * (1 + (copy.stamina - 50) / 100));
                return copy;
            };

            const userWrestlerLive = getWrestlerCopy(userWrestler);
            const opponentWrestlerLive = getWrestlerCopy(opponentWrestler);

            // Apply manager stat boosts to userWrestlerLive for this simulation
            if (userWrestler.manager && userWrestler.manager.statBoosts) {
                for (const stat in userWrestler.manager.statBoosts) {
                    // Ensure the stat exists on the wrestler object before trying to boost it
                    if (userWrestlerLive.hasOwnProperty(`effective${stat.charAt(0).toUpperCase() + stat.slice(1)}`)) {
                        const effectiveStatName = `effective${stat.charAt(0).toUpperCase() + stat.slice(1)}`;
                        userWrestlerLive[effectiveStatName] = Math.min(100, userWrestlerLive[effectiveStatName] + userWrestler.manager.statBoosts[stat]);
                        battleLogElement.innerHTML += `<p class="text-blue-300">Your manager ${userWrestler.manager.name} boosts your ${stat} by ${userWrestler.manager.statBoosts[stat]}!</p>`;
                    }
                }
            }
            
            showMessage("Simulating match...", 'info');

            const result = simulateSingleMatchInternal(userWrestlerLive, opponentWrestlerLive);
            const matchWinnerName = result.winner;
            const matchLoserName = (matchWinnerName === userWrestler.name) ? opponentWrestler.name : userWrestler.name;

            battleLogElement.innerHTML = result.log.map((entry) =>
                `<p class="${entry.startsWith('--- Turn') ? 'font-bold text-yellow-400 mt-2' : ''} ${entry.includes('FINISHING MOVE') ? 'text-orange-300' : ''} ${entry.includes('wins the match!') ? 'text-green-400 font-extrabold' : ''} ${entry.includes('Manager Interference!') ? 'text-red-500 font-bold' : ''}">${entry}</p>`
            ).join('');
            battleLogElement.scrollTop = battleLogElement.scrollHeight;

            matchWinnerNameElement.textContent = matchWinnerName;
            winnerImagesContainer.innerHTML = ''; // Clear for single wrestler
            if (matchWinnerName !== "Draw") {
                const winnerWrestlerObj = (matchWinnerName === userWrestler.name) ? userWrestler : opponentWrestler;
                const img = document.createElement('img');
                const winnerImageName = getLastName(winnerWrestlerObj.name); // Use getLastName for winner image
                img.src = `${BASE_IMAGE_URL}${winnerImageName}.webp`;
                img.alt = winnerWrestlerObj.name;
                img.className = 'w-32 h-32 rounded-full object-cover border-4 wrestler-image-border shadow-lg mx-auto';
                img.onerror = function() { this.onerror=null; this.src=`https://placehold.co/150x150/1a1a1a/fff?text=${encodeURIComponent(winnerWrestlerObj.name.replace(/\s/g, '+'))}`; };
                winnerImagesContainer.appendChild(img);
                winnerDescriptionElement.textContent = winnerWrestlerObj.description;
            } else {
                winnerImagesContainer.innerHTML = ''; // Ensure no image if draw
                winnerDescriptionElement.textContent = "The match ended in a tie after a hard-fought battle.";
            }
            
            // Experience and gold gain (with manager bonuses)
            gainExperience(matchWinnerName, matchLoserName); 

            // Show the modal ONLY after the simulation is complete
            matchOutcomeModal.classList.remove('hidden');
            matchOutcomeModal.classList.add('show');

            isLoading = false;
            simulateButton.disabled = false;
            randomMatchupButton.disabled = false;
            resetButton.disabled = false;
            checkMatchReady(); // Re-check after simulation and bet processing
            simulateSpinner.classList.add('hidden');
            simulatePlayIcon.classList.remove('hidden');
        }

        // Internal function for single match simulation
        const simulateSingleMatchInternal = (wrestlerA, wrestlerB) => {
            let log = [];
            let currentWrestlerA = wrestlerA;
            let currentWrestlerB = wrestlerB;

            let turn = 1;
            let winner = null;
            const FINISHER_CHANCE = 0.1; // Base chance for a finisher

            const logAction = (message) => {
                log.push(message);
            };

            while (currentWrestlerA.currentHp > 0 && currentWrestlerB.currentHp > 0 && turn < 150) {
                logAction(`--- Turn ${turn} ---`);

                const attacker = turn % 2 === 1 ? currentWrestlerA : currentWrestlerB;
                const defender = turn % 2 === 1 ? currentWrestlerB : currentWrestlerA;

                // Manager Interference (only for user's wrestler)
                if (currentManager && attacker.name === userWrestler.name && Math.random() < currentManager.interferenceChance) {
                    const interferenceDamage = getRandomInt(5, 15); // Small damage from interference
                    defender.currentHp -= interferenceDamage;
                    logAction(`*** Manager Interference! ${currentManager.name} distracts ${defender.name}, causing ${interferenceDamage} damage! ***`);
                }

                let move;
                let isFinisher = false;

                // Finisher logic: higher chance if opponent is low HP, or if attacker has high stamina
                const currentFinisherChance = FINISHER_CHANCE + 
                                            (defender.currentHp < (defender.baseHp * 0.3) ? 0.15 : 0) + // Increased chance if defender is low
                                            ((attacker.stamina - 50) / 100 * 0.05); // Small boost from stamina

                if (Math.random() < currentFinisherChance && attacker.currentHp > (attacker.baseHp * 0.2) && attacker.moves.finisher.length > 0) {
                    // Select a random finisher from the array
                    move = attacker.moves.finisher[getRandomInt(0, attacker.moves.finisher.length - 1)];
                    isFinisher = true;
                    logAction(`**${attacker.name} prepares for their devastating FINISHING MOVE, the ${move.name}!**`);
                } else {
                    const regularMoveTypes = ['grapple', 'strike', 'highFlying'];
                    const availableMovesForType = [];
                    // Collect all available regular moves
                    regularMoveTypes.forEach(type => {
                        if (attacker.moves[type] && attacker.moves[type].length > 0) {
                            availableMovesForType.push(...attacker.moves[type]);
                        }
                    });

                    if (availableMovesForType.length === 0) {
                        // Fallback if no moves are defined (shouldn't happen with proper data)
                        logAction(`${attacker.name} has no moves! Skipping turn.`);
                        turn++;
                        continue;
                    }
                    // Select a random move from all available regular moves
                    move = availableMovesForType[getRandomInt(0, availableMovesForType.length - 1)];
                }
                
                const relevantStat = attacker[move.stat];
                const statModifier = (relevantStat - 50) / 100; // Example: 100 stat = +0.5, 0 stat = -0.5
                let effectiveHitChance = Math.min(0.95, Math.max(0.05, move.baseHitChance + statModifier * 0.2)); // Cap between 5% and 95%
                
                let baseDamage = getRandomInt(move.damage.min, move.damage.max);
                // Damage reduction based on defender's toughness
                let damageReduction = Math.floor(baseDamage * (defender.toughness / 200)); // Toughness of 100 means 50% reduction
                let finalDamage = Math.max(0, baseDamage - damageReduction); 

                if (isFinisher) {
                    finalDamage = Math.round(finalDamage * 1.5); // Finisher deals 50% more damage
                    effectiveHitChance = Math.min(0.98, effectiveHitChance + 0.1); // Finisher has higher hit chance
                    logAction(`${attacker.name}'s ${move.name} is attempted!`);
                } else {
                    logAction(`${attacker.name}'s ${move.name} on ${defender.name}.`);
                }

                if (Math.random() < effectiveHitChance) {
                    defender.currentHp -= finalDamage;
                    logAction(`${attacker.name}'s ${move.name} hits ${defender.name} for ${finalDamage} damage! ${defender.name} HP: ${Math.max(0, defender.currentHp)}`);

                    if (defender.currentHp <= 0) {
                        defender.currentHp = 0;
                        winner = attacker.name;
                        logAction(`*** ${defender.name} is knocked out and ${attacker.name} wins the match! ***`, 'elimination');
                        break;
                    }
                } else {
                    logAction(`${attacker.name}'s ${move.name} misses!`);
                }
                turn++;
                if (turn >= 150) {
                    if (currentWrestlerA.currentHp > currentWrestlerB.currentHp) {
                        winner = currentWrestlerA.name;
                        logAction(`Turn limit reached. ${currentWrestlerA.name} wins with more HP.`);
                    } else if (currentWrestlerB.currentHp > currentWrestlerA.currentHp) {
                        winner = currentWrestlerB.name;
                        logAction(`Turn limit reached. ${currentWrestlerB.name} wins with more HP.`);
                    } else {
                        winner = "Draw";
                        logAction(`Turn limit reached. It's a draw!`);
                    }
                }
            }
            return { log, winner };
        };

        /**
         * Handles experience gain for the user's wrestler.
         * @param {string} winnerName - The name of the match winner.
         * @param {string} loserName - The name of the match loser.
         */
        function gainExperience(winnerName, loserName) {
            let xpGained = 0;
            let goldGained = 0;

            if (winnerName === userWrestler.name) {
                xpGained = userWrestler.level * getRandomInt(20, 30);
                goldGained = userWrestler.level * getRandomInt(10, 15);
                showMessage(`You won! You gained ${xpGained.toFixed(0)} XP and ${goldGained.toFixed(0)} gold!`, 'success');
            } else if (loserName === userWrestler.name) {
                xpGained = userWrestler.level * getRandomInt(10, 20);
                goldGained = userWrestler.level * getRandomInt(5, 10);
                showMessage(`You lost. You gained ${xpGained.toFixed(0)} XP and ${goldGained.toFixed(0)} gold.`, 'info');
            } else { // Draw
                xpGained = userWrestler.level * getRandomInt(15, 25);
                goldGained = userWrestler.level * getRandomInt(7, 12);
                showMessage(`It was a draw! You gained ${xpGained.toFixed(0)} XP and ${goldGained.toFixed(0)} gold.`, 'info');
            }

            // Apply manager bonuses
            if (currentManager) {
                xpGained *= (1 + currentManager.xpBonus);
                goldGained *= (1 + currentManager.goldBonus);
                showMessage(`Manager bonus applied! Gained ${xpGained.toFixed(0)} XP and ${goldGained.toFixed(0)} gold.`, 'info');
            }

            userWrestler.experience += Math.round(xpGained);
            userGold += Math.round(goldGained);
            checkLevelUp();
            updateUserWrestlerProfile();
            updateGoldDisplay();
        }

        /**
         * Checks if the user's wrestler has leveled up and applies stat increases and new moves.
         */
        function checkLevelUp() {
            while (userWrestler.experience >= userWrestler.xpToNextLevel) {
                userWrestler.level++;
                userWrestler.experience -= userWrestler.xpToNextLevel; // Carry over excess XP
                userWrestler.xpToNextLevel = Math.round(userWrestler.xpToNextLevel * 1.5); // Increase XP needed for next level

                // Award gold coins on level up
                const goldAwarded = userWrestler.level * 50; // Example: 50 gold per level
                userGold += goldAwarded;
                showMessage(`LEVEL UP! Your prospect is now Level ${userWrestler.level}! You gained ${goldAwarded} gold!`, 'success');

                // Apply stat increases
                const statsToIncrease = ['strength', 'technicalAbility', 'brawlingAbility', 'stamina', 'aerialAbility', 'toughness'];
                const randomStatIndex = getRandomInt(0, statsToIncrease.length - 1);
                const statToIncrease = statsToIncrease[randomStatIndex];
                
                // Increase stat by a random amount (e.g., 2-5 points)
                const increaseAmount = getRandomInt(2, 5);
                userWrestler[statToIncrease] = Math.min(100, userWrestler[statToIncrease] + increaseAmount); // Cap at 100
                showMessage(`Your ${statToIncrease} increased by ${increaseAmount}!`, 'info');

                // Also slightly increase base HP
                userWrestler.baseHp = Math.round(userWrestler.baseHp * 1.05); // 5% increase

                // Update user's move pool to include all unlocked moves up to the current level
                for (const moveType in userMovesPool) {
                    userWrestler.moves[moveType] = userMovesPool[moveType].filter(move => move.levelRequired <= userWrestler.level);
                    // Ensure there's at least one move if the pool is empty (shouldn't happen for level 1 but good for safety)
                    if (userWrestler.moves[moveType].length === 0) {
                        userWrestler.moves[moveType].push(userMovesPool[moveType][0]); // Fallback to the very first move
                    }
                }

                // Recalculate overall rating
                userWrestler.overallRating = calculateOverallRating(userWrestler);

                updateUserWrestlerProfile(); // Update profile immediately after level up
            }
        }

        /**
         * Allows the user to spend gold to train a specific skill.
         * @param {string} skillName - The name of the skill to train.
         */
        function trainWrestler(skillName) {
            const trainingCost = getTrainingCost(skillName);
            const currentSkillValue = userWrestler[skillName];

            if (currentSkillValue >= 100) {
                showMessage(`${skillName} is already at maximum (100)!`, 'warning');
                return;
            }

            if (userGold < trainingCost) {
                showMessage(`Not enough gold to train ${skillName}! You need ${trainingCost} gold.`, 'error');
                return;
            }

            userGold -= trainingCost;
            userWrestler[skillName] = Math.min(100, currentSkillValue + 1); // Increase by 1 point, cap at 100

            userWrestler.overallRating = calculateOverallRating(userWrestler); // Recalculate overall rating
            updateGoldDisplay(); // Updates gold and re-renders training buttons
            updateUserWrestlerProfile();
            showMessage(`You trained ${skillName}! It is now ${userWrestler[skillName]}.`, 'success');
        }


        /**
         * Handles the random opponent selection.
         */
        function randomMatchup() {
            resetMatch(); // Clear any existing opponent first

            // Filter out user's wrestler and any currently selected opponent (though resetMatch clears opponentWrestler)
            const availableOpponents = wrestlersData.filter(wrestler => wrestler.name !== userWrestler.name);

            if (availableOpponents.length === 0) {
                showMessage("No available opponents for a random matchup!", "error");
                return;
            }

            const randomIndex = getRandomInt(0, availableOpponents.length - 1);
            opponentWrestler = availableOpponents[randomIndex];
            placeWrestlerInDropzone(opponentWrestler, p3Slot);
            
            showMessage(`Random opponent selected: ${opponentWrestler.name}!`, 'success');
            populateWrestlers(); // Re-render roster to remove selected opponent
            checkMatchReady();
        }

        // Reset function
        function resetMatch() {
            opponentWrestler = null; // Clear opponent

            // Reset opponent drop zone
            p3Slot.innerHTML = '<p class="text-center text-sm">Drag Opponent Here</p>';
            p3Slot.classList.remove('has-wrestler', 'drag-over');

            // Ensure battleResultsSection is hidden when resetting
            matchOutcomeModal.classList.add('hidden');
            matchOutcomeModal.classList.remove('show');

            battleLogElement.innerHTML = '<p class="text-gray-500">The play-by-play for the last simulated match will appear here.</p>';
            matchWinnerNameElement.textContent = '';
            winnerImagesContainer.innerHTML = ''; // Clear images when resetting
            winnerDescriptionElement.textContent = '';

            simulateButton.disabled = true;
            randomMatchupButton.disabled = false;
            resetButton.disabled = false;
            showMessage("Opponent cleared!", 'info');
            
            populateWrestlers(); // Re-populate all wrestlers in the roster
        }

        // --- Initial Setup Modal Logic ---
        function checkSetupReady() {
            const nameEntered = prospectNameInput.value.trim().length > 0;
            const heightEntered = prospectHeightInput.value.trim().length > 0;
            const weightEntered = parseInt(prospectWeightInput.value) > 0;

            startGameButton.disabled = !(nameEntered && heightEntered && weightEntered && selectedAvatar);
        }

        function handleAvatarSelection(e) {
            // Remove 'selected' class from all avatars
            avatarSelection.querySelectorAll('.avatar-option').forEach(img => {
                img.classList.remove('selected');
            });

            // Add 'selected' class to the clicked avatar
            const clickedAvatar = e.target.closest('.avatar-option');
            if (clickedAvatar) {
                clickedAvatar.classList.add('selected');
                selectedAvatar = clickedAvatar.dataset.avatar;
                checkSetupReady();
            }
        }

        function startGame() {
            const name = prospectNameInput.value.trim();
            const height = prospectHeightInput.value.trim();
            const weight = parseInt(prospectWeightInput.value);

            if (!name || !height || !weight || !selectedAvatar) {
                showMessage("Please enter your wrestler's name, height, weight, and choose an avatar!", 'error');
                return;
            }
            if (isNaN(weight) || weight < 150 || weight > 500) {
                showMessage("Please enter a valid weight between 150 and 500 lbs.", 'error');
                return;
            }

            userWrestler.name = name;
            userWrestler.height = height;
            userWrestler.weight = weight;
            userWrestler.avatar = selectedAvatar;
            userWrestler.overallRating = calculateOverallRating(userWrestler); // Recalculate after name/avatar set

            initialSetupModal.classList.remove('show');
            initialSetupModal.classList.add('hidden');

            // Now that userWrestler is set, proceed with game initialization
            placeWrestlerInDropzone(userWrestler, p1Slot);
            updateUserWrestlerProfile();
            updateGoldDisplay(); // This will also call updateTrainingButtons
            populateWrestlers();
            checkMatchReady();
            showMessage(`Welcome to IWF, ${userWrestler.name}! Your career begins now.`, 'success');
        }


        // Initial setup on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', () => {
            // Setup initial prospect modal listeners
            prospectNameInput.addEventListener('input', checkSetupReady);
            prospectHeightInput.addEventListener('input', checkSetupReady);
            prospectWeightInput.addEventListener('input', checkSetupReady);
            avatarSelection.addEventListener('click', handleAvatarSelection);
            startGameButton.addEventListener('click', startGame);

            // Initially select the first avatar and check setup ready state
            const firstAvatar = avatarSelection.querySelector('.avatar-option');
            if (firstAvatar) {
                firstAvatar.classList.add('selected');
                selectedAvatar = firstAvatar.dataset.avatar;
            }
            checkSetupReady(); // Check button state on load

            // Event listener for closing the modal
            closeModalButton.addEventListener('click', () => {
                matchOutcomeModal.classList.remove('show');
                matchOutcomeModal.classList.add('hidden');
            });
            // Also close modal if clicked outside content
            matchOutcomeModal.addEventListener('click', (e) => {
                if (e.target === matchOutcomeModal) {
                    matchOutcomeModal.classList.remove('show');
                    matchOutcomeModal.classList.add('hidden');
                }
            });
            // Close modal with Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && matchOutcomeModal.classList.contains('show')) {
                    matchOutcomeModal.classList.remove('show');
                    matchOutcomeModal.classList.add('hidden');
                }
            });

            // Attach listeners for main game buttons
            simulateButton.addEventListener('click', simulateMatch);
            randomMatchupButton.addEventListener('click', randomMatchup);
            resetButton.addEventListener('click', resetMatch);
            
            checkMatchReady(); // Initial check for simulate button state
        });
    </script>
</body>
</html>
