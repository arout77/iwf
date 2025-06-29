<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Step into the Ring! 
                    Are you ready to book the dream matches you've always imagined? Do you love debating who would win in a clash of wrestling legends? Then get ready, because the Pro Wrestling Match Maker App is here to bring your fantasy bookings to life!">
    <title>IWF | Internet Wrestling Federation</title>
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

        /* Mode buttons */
        .mode-button.active {
            background: linear-gradient(to right, #cbceff, #F97316);
            color: #1F2937;
            border-color: transparent;
            box-shadow: 0 5px 15px rgba(250, 204, 21, 0.4);
        }
        .mode-button:not(.active) {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .mode-button:not(.active):hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

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
    </style>
</head>
<body class="min-h-screen flex flex-col items-center py-8 px-4 sm:px-6 text-gray-100 antialiased">
    <!-- Animated Background Container -->
    <div class="fixed inset-0 overflow-hidden" aria-hidden="true">
        <div class="animated-blob" style="width: 40vw;height: 40vw;top: -10vh;left: -10vw;--color-start: #720697;--color-end: #720697;--duration: 25s;--delay: 0s;--x-start: 0vw;--y-start: 0vh;--scale-start: 1;--x-mid: 20vw;--y-mid: 20vh;--scale-mid: 1.2;--x-end: 10vw;--y-end: 10vh;--scale-end: 1;"></div>
        <div class="animated-blob" style="width: 30vw;height: 30vw;top: 60vh;left: 70vw;--color-start: #1647f9;--color-end: #be03ff;--duration: 30s;--delay: 5s;--x-start: 0vw;--y-start: 0vh;--scale-start: 0.8;--x-mid: -10vw;--y-mid: -20vh;--scale-mid: 1;--x-end: 0vw;--y-end: 0vh;--scale-end: 0.8;"></div>
        <div class="animated-blob" style="width: 50vw;height: 50vw;top: 30vh;left: -30vw;--color-start: #3aa4ff;--color-end: #6a0497;--duration: 40s;--delay: 10s;--x-start: 0vw;--y-start: 0vh;--scale-start: 1.1;--x-mid: 30vw;--y-mid: -10vh;--scale-mid: 0.9;--x-end: 10vw;--y-end: 20vh;--scale-end: 1.1;"></div>
        <div class="animated-blob" style="width: 35vw;height: 35vw;top: -5vh;left: 80vw;--color-start: rgb(59 130 246 / 0.5);--color-end: rgb(59 130 246 / 0.5);--duration: 35s;--delay: 15s;--x-start: 0vw;--y-start: 0vh;--scale-start: 0.9;--x-mid: -20vw;--y-mid: 10vh;--scale-mid: 1.1;--x-end: -10vw;--y-end: -5vh;--scale-end: 0.9;"></div>
    </div>

    <div class="container max-w-7xl mx-auto flex flex-col items-center relative z-10">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 mb-12 drop-shadow-lg text-center leading-tight">
            Internet Wrestling Federation
        </h1>

        <!-- Gold Display -->
        <div class="fixed top-4 left-4 p-3 glassmorphism-card rounded-lg shadow-md text-yellow-300 font-bold flex items-center z-20">
            <svg class="w-6 h-6 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
            Gold Coins: <span id="gold-display" class="ml-2">1000</span>
        </div>

        <div id="message-box" class="hidden battle-message fixed top-4 md:top-8 w-full max-w-sm md:max-w-md py-3 px-6 rounded-xl font-semibold text-center z-50 text-white shadow-lg"></div>

        <!-- Match Type Selector -->
        <div class="flex justify-center gap-4 mb-8">
            <button id="mode-singles" class="mode-button text-lg font-bold py-2 px-6 rounded-full transition-all duration-200">Singles Match</button>
            <button id="mode-tag" class="mode-button text-lg font-bold py-2 px-6 rounded-full transition-all duration-200">Tag Team</button>
        </div>

        <!-- Match Setup Area -->
        <div id="match-setup" class="mb-8 p-4 glassmorphism-card rounded-2xl w-full max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] items-center gap-4">
                <!-- Team 1 -->
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-blue-400 mb-4">Team 1</h2>
                    <div id="team1-slots" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div id="p1-slot" class="drop-zone h-32 rounded-lg flex flex-col items-center justify-center text-slate-500 p-2">
                            <p class="text-center text-sm">Drag Player 1 Here</p>
                        </div>
                        <div id="p2-slot" class="drop-zone h-32 rounded-lg flex flex-col items-center justify-center text-slate-500 p-2 hidden">
                            <p class="text-center text-sm">Drag Player 2 Here</p>
                        </div>
                    </div>
                </div>
                
                <div class="vs-text my-4 md:my-0">VS</div>

                <!-- Team 2 -->
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-red-400 mb-4">Team 2</h2>
                    <div id="team2-slots" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div id="p3-slot" class="drop-zone h-32 rounded-lg flex flex-col items-center justify-center text-slate-500 p-2">
                            <p class="text-center text-sm">Drag Player 3 Here</p>
                        </div>
                        <div id="p4-slot" class="drop-zone h-32 rounded-lg flex flex-col items-center justify-center text-slate-500 p-2 hidden">
                            <p class="text-center text-sm">Drag Player 4 Here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Betting Section -->
        <div id="betting-section" class="mb-8 p-4 glassmorphism-card rounded-2xl w-full max-w-xl hidden">
            <h2 class="text-2xl font-semibold text-yellow-300 mb-4 text-center">Place Your Bets!</h2>
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 mb-4">
                <label for="bet-amount-input" class="text-lg font-semibold text-gray-200">Bet Amount:</label>
                <input type="number" id="bet-amount-input" min="0" value="0" placeholder="Enter 0 to skip bet"
                       class="flex-grow w-full md:w-auto p-3 rounded-lg bg-gray-800 text-yellow-300 border border-gray-700 focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-center text-xl font-bold" />
            </div>

            <div id="bet-target-selection" class="flex justify-center gap-4 flex-wrap">
                <!-- Radio buttons for betting targets will be injected here by JS -->
            </div>
            <p id="bet-odds-display" class="text-center text-sm text-gray-400 mt-2">Payout for selected: <span id="odds-value">N/A</span></p>
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
                Random Matchup
            </button>
            <button id="reset-button" class="framer-button framer-button-secondary flex items-center justify-center">
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8c0-4.08-3.05-7.44-7-7.93V4z"/></svg>
                Clear Match
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
                                    Overall Winner! <span id="win-counts-label" class="text-sm font-normal ml-2">(Best of 100)</span>
                                </h3>
                                <div class="text-center">
                                    <div id="winner-images-container" class="flex justify-center items-center gap-4 mx-auto mb-4">
                                        <!-- Winner images will be placed here by JavaScript -->
                                    </div>
                                    <p id="match-winner-name" class="text-3xl font-extrabold text-yellow-400 mb-2">
                                        <!-- Winner Name Here -->
                                    </p>
                                    <p id="winner-description" class="text-md text-gray-300"></p>
                                    <p id="win-counts" class="text-sm text-gray-400 mt-2">
                                        <!-- Win counts will be displayed here -->
                                    </p>
                                    <p id="bet-result-display" class="text-lg font-bold mt-4"></p>
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
                Available Wrestlers (Drag & Drop!)
            </h2>
            <div id="wrestlers-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 custom-scrollbar max-h-[600px] overflow-y-auto p-2">
                <!-- Wrestler cards will be populated here by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Base URL for wrestler images
        const BASE_IMAGE_URL = "https://php-mentor.com/sandbox/wrestling/";

        // Function to get a random integer within a range
        const getRandomInt = (min, max) => {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        };

        // Helper to extract the last name from a wrestler's full name for image URL
        const getLastName = (fullName) => {
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
                if (fullName === "Daniel Bryan") return "bryan"; // Corrected from 'bryan'
                if (fullName === "Luke Harper") return "harper"; // Corrected from 'harper'
                if (fullName === "Michael Hayes") return "hayes";
                if (fullName === "Meng") return "meng";
                if (fullName === "Bobby Eaton") return "eaton"; // Corrected from 'eaton'
                if (fullName === "Lord Steven Regal") return "regal";
                if (fullName === "Barbarian") return "barbarian";
                if (fullName === "Paul Orndorff") return "orndorff";
                if (fullName === "Hacksaw Jim Duggan") return "duggan";
                if (fullName === "Jimmy Snuka") return "snuka";
                if (fullName === "Don Muraco") return "muraco";


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
                    grapple: { name: "Phenomenal Forearm", damage: { min: 15, max: 18 }, baseHitChance: 0.8, stat: 'aerialAbility' },
                    strike: { name: "Spiral Tap", damage: { min: 14, max: 17 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    highFlying: { name: "Calf Crusher", damage: { min: 12, max: 14 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Styles Clash", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Bodyslam", damage: { min: 15, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    strike: { name: "Headbutt", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    finisher: { name: "Sit-down Splash", damage: { min: 28, max: 40 }, baseHitChance: 0.85, stat: 'strength' }
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
                    grapple: { name: "Spinebuster", damage: { min: 13, max: 19 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Gourdbuster", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    highFlying: { name: "DDT", damage: { min: 9, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Double A Spinebuster", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Powerslam", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Big Boot", damage: { min: 12, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    highFlying: { name: "Bearhug", damage: { min: 10, max: 14 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Top Rope Headbutt", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'aerialAbility' }
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
                    grapple: { name: "Lariat", damage: { min: 12, max: 17 }, baseHitChance: 0.88, stat: 'brawlingAbility' },
                    strike: { name: "Flying Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Bulldog", damage: { min: 11, max: 14 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Superplex", damage: { min: 26, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Spear", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Spinebuster", damage: { min: 11, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Full Nelson Slam", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Batista Bomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Sidewalk Slam", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    strike: { name: "Pendulum Backbreaker", damage: { min: 10, max: 18 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Big Boot", damage: { min: 9, max: 15 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    finisher: { name: "Boss Man Slam", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Double Underhook Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Backbreaker", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Reverse Bear Hug", damage: { min: 28, max: 34 }, baseHitChance: 0.85, stat: 'strength' }
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
                    grapple: { name: "Atomic Knee Drop", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Belly-to-back Rolling Bridge", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    highFlying: { name: "Atomic Spinecrusher", damage: { min: 11, max: 17 }, baseHitChance: 0.65, stat: 'technicalAbility' },
                    finisher: { name: "Crossface Chickenwing", damage: { min: 25, max: 38 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Spinning Neckbreaker", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Armbar DDT", damage: { min: 12, max: 14 }, baseHitChance: 0.85, stat: 'technicalAbility' },
                    highFlying: { name: "Diving Knee Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Alabama Jam", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'aerialAbility' }
                }
            },
            {
                name: "Bobby Lashley",
                height: "6'3\"",
                weight: 273,
                description: "The All Mighty.  Former U.S. Army veteran who became WWE Champion and ECW Champion. Known for his incredible physique and legitimate amateur wrestling background. Successfully competed in mixed martial arts, proving his athletic credibility. His later career renaissance, particularly his work with MVP and The Hurt Business, showcased his improved mic skills and character development.",
                baseHp: 100,
                strength: 96,
                technicalAbility: 80,
                brawlingAbility: 92,
                stamina: 90,
                aerialAbility: 37,
                toughness: 93,
                moves: {
                    grapple: { name: "Spear", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Dominator", damage: { min: 10, max: 17 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Full Nelson Slam", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Hurt Lock", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Book End", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Houston Hangover", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Scissors Kick", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Fallaway Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Backbreaker", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Running Powerslam", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }
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
                    grapple: { name: "Sister Abigail", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    strike: { name: "Mandible Claw", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Senton", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Sister Abigail", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Snap Suplex", damage: { min: 11, max: 16 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Russian Leg Sweep", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'aerialAbility' },
                    highFlying: { name: "Backbreaker", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Sharpshooter", damage: { min: 24, max: 34 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "German Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Kimura Lock", damage: { min: 10, max: 18 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    highFlying: { name: "Knee Lift", damage: { min: 8, max: 14 }, baseHitChance: 0.6, stat: 'strength' },
                    finisher: { name: "F-5", damage: { min: 30, max: 36 }, baseHitChance: 0.92, stat: 'strength' }
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
                    grapple: { name: "Military Press Slam", damage: { min: 12, max: 16 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Spear", damage: { min: 15, max: 20 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Frankensteiner", damage: { min: 14, max: 18 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Steiner Recliner", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Running Big Boot", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Elbow Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Bearhug", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "King Kong Knee Drop", damage: { min: 27, max: 37 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Bearhug", damage: { min: 15, max: 18 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Body Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength' },
                    highFlying: { name: "Hammer Lock", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Backbreaker", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Tornado DDT", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Frog Splash", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Spear", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Unprettier", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "German Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Diving Headbutt", damage: { min: 11, max: 19 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Snap Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Crippler Crossface", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Codebreaker", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Lionsault", damage: { min: 12, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Diving Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Walls of Jericho", damage: { min: 23, max: 33 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Anaconda Vice", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Diving Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Springboard Clothesline", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Go To Sleep", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Deathlock", damage: { min: 12, max: 7 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Alabama Slam", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    highFlying: { name: "Din's Fire", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Cross Rhodes", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Standing Dropkick", damage: { min: 9, max: 16 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Swinging knee lift", damage: { min: 10, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    highFlying: { name: "Figure-four leglock", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Perfect-Plex", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Powerbomb", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Spinebuster", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' },
                    finisher: { name: "Spivey Spike (DDT)", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Top Rope Hurricanrana", damage: { min: 11, max: 18 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Busaiku Knee Kick", damage: { min: 11, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Suicide Dive", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Yes Lock (Omoplata Crossface)", damage: { min: 25, max: 38 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Dean Malenko",
                height: "5'10\"",
                weight: 212,
                description: "The Man of 1,000 Holds. Considered one of the greatest technical wrestlers ever. Known for his stoic demeanor and incredible wrestling ability. Key member of The Radicalz stable when they jumped from WCW to WWE. His matches were wrestling clinics that showcased pure technical skill. Respected by peers as a wrestler's wrestler who could make anyone look good.",
                baseHp: 100,
                strength: 74,
                technicalAbility: 100,
                brawlingAbility: 76,
                stamina: 91,
                aerialAbility: 42,
                toughness: 83,
                moves: {
                    grapple: { name: "Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Springboard Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Cross Armbreaker", damage: { min: 12, max: 19 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Texas Cloverleaf", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Fist Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Splash", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Inverted Atomic Drop", damage: { min: 9, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Diamond Cutter", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Atomic Drop", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'strength' },
                    strike: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "DDT", damage: { min: 11, max: 16 }, baseHitChance: 0.72, stat: 'brawlingAbility' },
                    finisher: { name: "Asiatic Spike", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Shattered Dreams (low blow)", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Running Uppercut", damage: { min: 11, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Cross Rhodes", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Atomic Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    highFlying: { name: "Bionic Knee Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Bionic Elbow", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Edgecution", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Flying Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Impailer DDT", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Spear", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Three Amigos", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "European Uppercut", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Hurricanrana", damage: { min: 9, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Frog Splash", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'aerialAbility' }
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
                    grapple: { name: "Spear", damage: { min: 15, max: 20 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 12, max: 17 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Clothesline", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Jackhammer", damage: { min: 30, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Powerbomb", damage: { min: 15, max: 20 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Chop!", damage: { min: 14, max: 18 }, baseHitChance: 0.9, stat: 'brawlingAbility' },
                    highFlying: { name: "Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.65, stat: 'strength' },
                    finisher: { name: "Sleeper Hold", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'technicalAbility' }
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
                    grapple: { name: "Body Slam", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'strength' },
                    strike: { name: "Old Glory", damage: { min: 12, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    highFlying: { name: "Three Point Stance Tackle", damage: { min: 11, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    finisher: { name: "Three-Point Stance Clothesline", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Knee Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Headbutt", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Vertical Suplex", damage: { min: 13, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Piledriver", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Body Slam", damage: { min: 13, max: 16 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 12, max: 20 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Reverse Chinlock", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    finisher: { name: "Leg Drop", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Bearhug", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Knee Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Belly-to-Belly Suplex", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Russian Sickle (Clothesline)", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Figure-Four Leglock", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Dropkick", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Swinging Neckbreaker", damage: { min: 9, max: 17 }, baseHitChance: 0.65, stat: 'technicalAbility' },
                    finisher: { name: "The Stroke", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Short-Arm Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Knee Lift", damage: { min: 8, max: 13 }, baseHitChance: 0.6, stat: 'technicalAbility' },
                    highFlying: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "DDT", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Headbutt", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    strike: { name: "Chop!", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Flying Crossbody", damage: { min: 15, max: 20 }, baseHitChance: 0.85, stat: 'aerialAbility' },
                    finisher: { name: "Superfly Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.95, stat: 'aerialAbility' }
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
                    grapple: { name: "Five Knuckle Shuffle", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Diving Leg Drop Bulldog", damage: { min: 11, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Spinning Powerbomb", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Attitude Adjustment", damage: { min: 25, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Thump (headbutt)", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Big Punch", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Body Slam", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Powerslam", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Big Boot", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Flying Clothesline", damage: { min: 12, max: 18 }, baseHitChance: 0.65, stat: 'strength' },
                    highFlying: { name: "Top Rope Clothesline", damage: { min: 11, max: 19 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Chokeslam", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Kerry Von Erich",
                height: "6'2\"",
                weight: 250,
                description: "The Modern Day Warrior. A powerful and athletic Von Erich.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(40, 60),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: { name: "Flying Crossbody", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    strike: { name: "Discus Punch", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Backhand Chop", damage: { min: 8, max: 13 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Iron Claw", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Sidewalk Slam", damage: { min: 10, max: 17 }, baseHitChance: 0.6, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Snake Eyes", damage: { min: 9, max: 15 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Jackknife Powerbomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Cannonball", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Senton", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Swanton Bomb", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Pop-up Powerbomb", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Iron Claw (hold)", damage: { min: 10, max: 16 }, baseHitChance: 0.80, stat: 'strength' },
                    strike: { name: "Dropkick", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Flying Crossbody", damage: { min: 11, max: 17 }, baseHitChance: 0.70, stat: 'aerialAbility' },
                    finisher: { name: "Iron Claw", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'strength' }
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
                    grapple: { name: "Angle Slam", damage: { min: 12, max: 17 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Moonsault", damage: { min: 12, max: 17 }, baseHitChance: 0.79, stat: 'aerialAbility' },
                    highFlying: { name: "Top Rope Belly-to-Belly", damage: { min: 14, max: 19 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Ankle Lock", damage: { min: 24, max: 34 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Abdominal Stretch", damage: { min: 10, max: 14 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Side Kick", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Larryland Dreamer (Guillotine Choke)", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Bionic Forearm", damage: { min: 10, max: 18 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Clothesline", damage: { min: 11, max: 17 }, baseHitChance: 0.8, stat: 'strength' },
                    highFlying: { name: "Powerslam", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'strength' },
                    finisher: { name: "Torture Rack", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Regal Cutter", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "European uppercut", damage: { min: 12, max: 14 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    highFlying: { name: "Knee Trembler", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Regal Stretch", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Discus Lariat", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    strike: { name: "Truck Stop (spinning side slam)", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Brodie Bomb (Running Senton)", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Axe Handle Drop", damage: { min: 13, max: 19 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Flying Crossbody", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Diving Elbow Drop", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }
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
                    grapple: { name: "World's Strongest Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Big Splash", damage: { min: 11, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    highFlying: { name: "Press Slam", damage: { min: 12, max: 17 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Mark Henry's Powerslam", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }
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
                    grapple: { name: "Savate Kick", damage: { min: 13, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Asiatic Spike", damage: { min: 12, max: 16 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    highFlying: { name: "Flying Headbutt", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Tongan Death Grip", damage: { min: 25, max: 39 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "DDT", damage: { min: 10, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Left Hand Punch", damage: { min: 12, max: 14 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    highFlying: { name: "Top Rope Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Freebird DDT", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Double Arm DDT", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Elbow Drop (from apron)", damage: { min: 9, max: 16 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    highFlying: { name: "Running Knee", damage: { min: 8, max: 15 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Mandible Claw", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Abdominal Stretch", damage: { min: 8, max: 13 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Falling Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Write-Off (Stock Market Crash)", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                stamina: 92,
                aerialAbility: 28,
                toughness: 86,
                moves: {
                    grapple: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Atomic Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' },
                    highFlying: { name: "Figure-Four Leglock", damage: { min: 14, max: 19 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Bockwinkel's Sleeper", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Bearhug", damage: { min: 14, max: 17 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Russian Sickle (Clothesline)", damage: { min: 18, max: 25 }, baseHitChance: 0.9, stat: 'brawlingAbility' },
                    highFlying: { name: "Running Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Russian Sickle", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Chokeslam", damage: { min: 14, max: 19 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    highFlying: { name: "Press Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Two-Handed Chokeslam", damage: { min: 35, max: 45 }, baseHitChance: 0.92, stat: 'strength' }
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
                    grapple: { name: "Bridging German Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Spinning Heel Kick", damage: { min: 11, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Sharpshooter", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Full Nelson", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Forearm Smash", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Bodyslam", damage: { min: 9, max: 15 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Piledriver", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Lie Detector (Corkscrew Scissor Kick)", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    strike: { name: "Little Jimmy (jumping reverse STO)", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Flying Forearm", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Axe Kick", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Punt Kick", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "DDT", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    highFlying: { name: "Powerslam", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "RKO", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Springboard Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    strike: { name: "West Coast Pop", damage: { min: 13, max: 19 }, baseHitChance: 0.8, stat: 'aerialAbility' },
                    highFlying: { name: "Hurricanrana", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "619", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'aerialAbility' }
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
                    grapple: { name: "Chop!", damage: { min: 11, max: 16 }, baseHitChance: 0.9, stat: 'brawlingAbility' },
                    strike: { name: "Knee Drop", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Suplex", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    finisher: { name: "Figure-Four Leglock", damage: { min: 20, max: 38 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Neckbreaker", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    highFlying: { name: "Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' },
                    finisher: { name: "Rude Awakening", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Steinerline", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Rebound Lariat", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Steiner Driver", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Arm Drag", damage: { min: 10, max: 16 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Chop", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Diving Crossbody", damage: { min: 12, max: 18 }, baseHitChance: 0.85, stat: 'aerialAbility' },
                    finisher: { name: "Double Chicken Wing", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'technicalAbility' }
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
                    grapple: { name: "Power Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.82, stat: 'strength' },
                    strike: { name: "Clothesline", damage: { min: 14, max: 16 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    highFlying: { name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    finisher: { name: "Powerslam", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Clothesline", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Flying Shoulder Tackle", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Powerslam", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Diving Clothesline", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Rolling Thunder", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    strike: { name: "Van Daminator (spinning heel kick)", damage: { min: 15, max: 19 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Split-Legged Moonsault", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Five-Star Frog Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }
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
                    grapple: { name: "Eye Poke", damage: { min: 5, max: 14 }, baseHitChance: 0.9, stat: 'brawlingAbility' },
                    strike: { name: "Punch Flurry", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Low Blow", damage: { min: 11, max: 16 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Sleeper Hold", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Superman Punch", damage: { min: 14, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Drive By (running dropkick)", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Samoan Drop", damage: { min: 13, max: 15 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Spear", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Spinebuster", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Powerbomb", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Dominator", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Muscle Buster", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Olé Kick", damage: { min: 12, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Diving Headbutt", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Coquina Clutch", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'technicalAbility' }
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
                    grapple: { name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.79, stat: 'brawlingAbility' },
                    strike: { name: "Chop!", damage: { min: 10, max: 15 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    highFlying: { name: "Fallaway Slam", damage: { min: 14, max: 19 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Razor's Edge", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Frankensteiner", damage: { min: 13, max: 19 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Diving Blockbuster", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Top Rope Steinerline", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Steiner Recliner", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Pedigree", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Frog Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Phoenix Splash", damage: { min: 13, max: 19 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Curb Stomp", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'aerialAbility' }
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
                    grapple: { name: "Flying Forearm", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    strike: { name: "Diving Elbow Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Teardrop Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Sweet Chin Music", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Ten Beats of the Bodhran", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Irish Curse Backbreaker", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "White Noise", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Brogue Kick", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Good Vibrations (corner stomps)", damage: { min: 10, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Bomaye (running knee)", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Sliding German Suplex", damage: { min: 11, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    finisher: { name: "Kinshasa", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Sid Vicious",
                height: "6'9\"",
                weight: 303,
                description: "The Master and Ruler of the World. Unstable powerhouse.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(60, 75),
                aerialAbility: getRandomInt(5, 20),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: { name: "Big Boot", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Leg Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Chokeslam", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' },
                    finisher: { name: "Powerbomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Stan Hansen",
                height: "6'4\"",
                weight: 290,
                description: "The Lariat. A wild and intense Texan brawler.",
                baseHp: 105,
                strength: 93,
                technicalAbility: 68,
                brawlingAbility: 98,
                stamina: 89,
                aerialAbility: 20,
                toughness: 97,
                moves: {
                    grapple: { name: "Piledriver", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    strike: { name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Belly-to-Back Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength' },
                    finisher: { name: "Western Lariat", damage: { min: 30, max: 40 }, baseHitChance: 0.95, stat: 'brawlingAbility' }
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
                    grapple: { name: "Stinger Splash", damage: { min: 12, max: 16 }, baseHitChance: 0.95, stat: 'brawlingAbility' },
                    strike: { name: "Scorpion Deathdrop", damage: { min: 14, max: 20 }, baseHitChance: 0.9, stat: 'technicalAbility' },
                    highFlying: { name: "Top Rope Crossbody", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Scorpion Deathlock", damage: { min: 25, max: 38 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Lou Thesz Press", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Mudhole Stomp", damage: { min: 8, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Bionic Elbow", damage: { min: 7, max: 13 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    finisher: { name: "Stone Cold Stunner", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
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
                    grapple: { name: "Fist Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Back Elbow", damage: { min: 8, max: 13 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Hotshot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Million Dollar Dream", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'technicalAbility' }
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
                    grapple: { name: "Spinning Toe Hold", damage: { min: 12, max: 17 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Taped Fist", damage: { min: 12, max: 17 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    highFlying: { name: "Diving Moonsault", damage: { min: 10, max: 16 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    finisher: { name: "Texas Death Match Driver", damage: { min: 24, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
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
                    grapple: { name: "Lariat", damage: { min: 14, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Big Splash", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Powerslam", damage: { min: 12, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Powerbomb", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Knockout Punch", damage: { min: 12, max: 20 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Banzai Drop", damage: { min: 10, max: 15 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Showstopper (Chokeslam)", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }
                }
            },
            {
                name: "The Great Khali",
                height: "7'1\"",
                weight: 347,
                description: "The Punjabi Nightmare. A towering giant with immense power and an intimidating presence.",
                baseHp: getRandomInt(130, 150),
                strength: getRandomInt(98, 100),
                technicalAbility: getRandomInt(20, 40),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(50, 70),
                aerialAbility: getRandomInt(1, 5),
                toughness: getRandomInt(60, 100),
                moves: {
                    grapple: { name: "Vice Grip", damage: { min: 18, max: 25 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Punjabi Chop", damage: { min: 15, max: 22 }, baseHitChance: 0.80, stat: 'brawlingAbility' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.60, stat: 'strength' },
                    finisher: { name: "Khali Bomb", damage: { min: 35, max: 45 }, baseHitChance: 0.90, stat: 'strength' }
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
                brawlingAbility: 94,
                stamina: 92,
                aerialAbility: 90,
                toughness: 85,
                moves: {
                    grapple: { name: "Dragon Screw", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Handspring Elbow", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Flash Elbow", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Moonsault", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'aerialAbility' }
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
                    grapple: { name: "Skull-Crushing Finale", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Reality Check (running knee lift)", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Awesome Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Figure-Four Leglock", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Sharpshooter", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Samoan Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength' },
                    highFlying: { name: "Flying Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "People's Elbow", damage: { min: 22, max: 32 }, baseHitChance: 0.88, stat: 'brawlingAbility' }
                }
            },
            {
                name: "The Undertaker",
                height: "6'10\"",
                weight: 309,
                description: "The Deadman. A mystical force with unparalleled longevity.",
                baseHp: 115,
                strength: 92,
                technicalAbility: 71,
                brawlingAbility: 94,
                stamina: 84,
                aerialAbility: 39,
                toughness: 96,
                moves: {
                    grapple: { name: "Chokeslam", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Old School (Arm Walk)", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'technicalAbility' },
                    highFlying: { name: "Flying Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Tombstone Piledriver", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Spinebuster", damage: { min: 12, max: 19 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Knee Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    highFlying: { name: "Facebreaker Knee Smash", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Pedigree", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Figure-Four Leglock", damage: { min: 10, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Knee Drop", damage: { min: 9, max: 15 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Piledriver", damage: { min: 12, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Slingshot Suplex", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'technicalAbility' }
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
                    grapple: { name: "Gorilla Press Slam", damage: { min: 11, max: 19 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Flying Clothesline", damage: { min: 13, max: 17 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Big Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Warrior Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
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
                    grapple: { name: "Fist Strikes", damage: { min: 13, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Moonsault (from top)", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Chokeslam", damage: { min: 10, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Vader Bomb", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }
                }
            },
        ];

        // Function to calculate a wrestler's overall rating by eliminating the weakest attribute
        function calculateOverallRating(wrestler) {
            const stats = [
                wrestler.strength,
                wrestler.technicalAbility,
                wrestler.brawlingAbility,
                wrestler.stamina,
                wrestler.aerialAbility
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
            
            // Average the remaining stats (divide by 4 instead of 5)
            return Math.round(sum / filteredStats.length); 
        }

        // Add overall rating to each wrestler object
        wrestlersData.forEach(wrestler => {
            wrestler.overallRating = calculateOverallRating(wrestler);
        });

        // Sort wrestlersData alphabetically by name
        wrestlersData.sort((a, b) => a.name.localeCompare(b.name));

        let userGold = 1000; // Initial gold coins
        let currentBet = { amount: 0, target: null, odds: 0 }; // Stores current bet info

        let matchState = {
            mode: 'singles', // 'singles' or 'tag'
            team1: [null, null], // Stores names of wrestlers for Player 1 & 2
            team2: [null, null], // Stores names of wrestlers for Player 3 & 4
        };
        let isLoading = false;

        // DOM Elements
        const goldDisplay = document.getElementById('gold-display');
        const bettingSection = document.getElementById('betting-section');
        const betAmountInput = document.getElementById('bet-amount-input');
        const betTargetSelection = document.getElementById('bet-target-selection');
        const betOddsDisplay = document.getElementById('bet-odds-display');
        const oddsValueDisplay = document.getElementById('odds-value');
        const betResultDisplay = document.getElementById('bet-result-display');


        const p1Slot = document.getElementById('p1-slot');
        const p2Slot = document.getElementById('p2-slot');
        const p3Slot = document.getElementById('p3-slot');
        const p4Slot = document.getElementById('p4-slot');
        const dropZones = [p1Slot, p2Slot, p3Slot, p4Slot]; // Array of all dropzones

        const wrestlersContainer = document.getElementById('wrestlers-container');
        const simulateButton = document.getElementById('simulate-button');
        const randomMatchupButton = document.getElementById('random-matchup-button');
        const resetButton = document.getElementById('reset-button');
        const battleLogElement = document.getElementById('battle-log');
        
        // Renamed for modal integration
        const battleResultsSectionContent = document.getElementById('battle-results-section-content'); 
        const matchOutcomeModal = document.getElementById('match-outcome-modal');
        const closeModalButton = document.getElementById('close-modal-button');

        const matchWinnerNameElement = document.getElementById('match-winner-name');
        const winnerImagesContainer = document.getElementById('winner-images-container'); 
        const winnerDescriptionElement = document.getElementById('winner-description');
        const simulateSpinner = document.getElementById('simulate-spinner');
        const simulatePlayIcon = document.getElementById('simulate-play-icon');
        const messageBox = document.getElementById('message-box');
        const winCountsElement = document.getElementById('win-counts');
        const winCountsLabel = document.getElementById('win-counts-label');
        const modeSinglesBtn = document.getElementById('mode-singles');
        const modeTagBtn = document.getElementById('mode-tag');

        // Function to update gold display
        function updateGoldDisplay() {
            goldDisplay.textContent = userGold.toFixed(0); // Display as integer
        }

        // Function to display messages to the user
        function showMessage(message, type = 'info') {
            messageBox.textContent = message;
            messageBox.classList.remove('hidden', 'bg-red-700', 'bg-green-700', 'bg-yellow-700', 'bg-gray-700', 'text-white', 'text-gray-900');
            messageBox.classList.add('show');

            if (type === 'error') {
                messageBox.classList.add('bg-red-700', 'text-white');
            } else if (type === 'success') {
                messageBox.classList.add('bg-green-700', 'text-white');
            } else if (type === 'warning') {
                messageBox.classList.add('bg-yellow-700', 'text-gray-900');
            } else {
                messageBox.classList.add('bg-gray-700', 'text-white');
            }

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
         * Sets the match mode (singles or tag team).
         * @param {string} mode - The mode to set ('singles' or 'tag').
         */
        function setMatchMode(mode) {
            matchState.mode = mode;
            if (mode === 'singles') {
                modeSinglesBtn.classList.add('active');
                modeTagBtn.classList.remove('active');
                p2Slot.classList.add('hidden');
                p4Slot.classList.add('hidden');
                matchState.team1[1] = null; // Clear P2 if switching to singles
                matchState.team2[1] = null; // Clear P4 if switching to singles
                // Also clear the content of the hidden slots
                p2Slot.innerHTML = '<p class="text-center text-sm">Drag Player 2 Here</p>';
                p2Slot.classList.remove('has-wrestler', 'drag-over');
                p4Slot.innerHTML = '<p class="text-center text-sm">Drag Player 4 Here</p>';
                p4Slot.classList.remove('has-wrestler', 'drag-over');
                showMessage("Switched to Singles Match mode.", 'info');
            } else { // Tag Team
                modeTagBtn.classList.add('active');
                modeSinglesBtn.classList.remove('active');
                p2Slot.classList.remove('hidden');
                p4Slot.classList.remove('hidden');
                showMessage("Switched to Tag Team mode.", 'info');
            }
            populateWrestlers(); // Re-populate to reflect available wrestlers after mode change
            checkMatchReady(); // Re-check button state
            updateBettingTargets(); // Update betting options based on new mode
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

            const lastName = getLastName(wrestler.name);
            const imageUrl = `${BASE_IMAGE_URL}${lastName}.webp`;

            if (isSmall) {
                card.className = 'wrestler-card-in-slot flex flex-col items-center justify-center text-center';
                card.innerHTML = `
                    <img src="${imageUrl}" alt="${wrestler.name}" class="w-16 h-16 rounded-full object-cover border-2 wrestler-image-border mb-1" onerror="this.onerror=null;this.src='https://placehold.co/64x64/1a1a1a/fff?text=${encodeURIComponent(wrestler.name.charAt(0))}'">
                    <p class="text-sm font-bold text-yellow-300 w-full truncate">${wrestler.name}</p>
                `;
            } else {
                card.className = 'wrestler-card p-4 rounded-xl flex flex-col items-center';
                card.draggable = true; 
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
                                    case 'toughness': statBarClass = 'bg-slate-500'; break; 
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
                    <p class="text-xs font-semibold text-orange-400 text-center mb-2">Finisher: ${wrestler.moves.finisher.name}</p>
                    <p class="text-sm text-gray-300 text-center mb-2 line-clamp-5">${wrestler.description}</p>
                    ${statsHtml}
                `;
            }
            return card;
        }

        // Populate available wrestlers
        function populateWrestlers() {
            wrestlersContainer.innerHTML = '';
            wrestlersData
                .filter(wrestler => {
                    const isSelectedInTeam1 = matchState.team1.includes(wrestler.name);
                    const isSelectedInTeam2 = matchState.team2.includes(wrestler.name);
                    return !isSelectedInTeam1 && !isSelectedInTeam2;
                })
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
                e.preventDefault();
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
            // Only allow drag over if the drop zone is empty
            if (!e.currentTarget.classList.contains('has-wrestler')) {
                e.currentTarget.classList.add('drag-over');
            }
        }

        function handleDragLeave(e) {
            e.currentTarget.classList.remove('drag-over');
        }

        function handleDrop(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('drag-over');

            const wrestlerName = e.dataTransfer.getData('text/plain');
            const wrestler = wrestlersData.find(w => w.name === wrestlerName);

            if (!wrestler) {
                showMessage("Could not find wrestler data. Drop canceled.", 'error');
                return;
            }

            if (e.currentTarget.classList.contains('has-wrestler')) {
                showMessage("This slot is already taken. Clear the match first, or remove the existing wrestler!", 'warning');
                return;
            }

            const allSelected = [...matchState.team1, ...matchState.team2].filter(name => name !== null);
            if (allSelected.includes(wrestler.name)) {
                showMessage("Wrestler already selected in another slot!", 'error');
                return;
            }

            placeWrestlerInDropzone(wrestler, e.currentTarget);

            // Assign wrestler to correct slot in matchState
            switch(e.currentTarget.id) {
                case 'p1-slot': matchState.team1[0] = wrestler.name; break;
                case 'p2-slot': matchState.team1[1] = wrestler.name; break;
                case 'p3-slot': matchState.team2[0] = wrestler.name; break;
                case 'p4-slot': matchState.team2[1] = wrestler.name; break;
            }

            showMessage(`${wrestler.name} added to the match!`, 'success');
            populateWrestlers(); // Re-render roster to remove selected wrestler
            checkMatchReady();
            updateBettingTargets(); // Update betting options
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

        function updateBettingTargets() {
            betTargetSelection.innerHTML = '';
            oddsValueDisplay.textContent = 'N/A';
            currentBet.target = null;
            currentBet.odds = 0;

            const p1 = matchState.team1[0] ? wrestlersData.find(w => w.name === matchState.team1[0]) : null;
            const p2 = matchState.team1[1] ? wrestlersData.find(w => w.name === matchState.team1[1]) : null;
            const p3 = matchState.team2[0] ? wrestlersData.find(w => w.name === matchState.team2[0]) : null;
            const p4 = matchState.team2[1] ? wrestlersData.find(w => w.name === matchState.team2[1]) : null;

            let canBet = false;
            let team1Overall = 0;
            let team2Overall = 0;
            let team1Name = '';
            let team2Name = '';

            if (matchState.mode === 'singles' && p1 && p3) {
                canBet = true;
                team1Overall = p1.overallRating;
                team2Overall = p3.overallRating;
                team1Name = p1.name;
                team2Name = p3.name;
            } else if (matchState.mode === 'tag' && p1 && p2 && p3 && p4) {
                canBet = true;
                team1Overall = (p1.overallRating + p2.overallRating) / 2;
                team2Overall = (p3.overallRating + p4.overallRating) / 2;
                team1Name = `Team 1 (${p1.name} & ${p2.name})`;
                team2Name = `Team 2 (${p3.name} & ${p4.name})`;
            }

            if (canBet) {
                bettingSection.classList.remove('hidden');

                const baseOdds = 1.8; // Base payout for an even match
                const ratingDifferenceFactor = 0.005; // How much difference in rating affects odds

                // Calculate odds for Team 1
                let odds1 = baseOdds;
                if (team1Overall !== team2Overall) {
                    const diff = team1Overall - team2Overall;
                    if (diff > 0) { // Team 1 is favorite
                        odds1 = Math.max(1.1, baseOdds - (diff * ratingDifferenceFactor));
                    } else { // Team 1 is underdog
                        odds1 = Math.min(2.5, baseOdds + (Math.abs(diff) * ratingDifferenceFactor));
                    }
                }

                // Calculate odds for Team 2
                let odds2 = baseOdds;
                if (team2Overall !== team1Overall) {
                    const diff = team2Overall - team1Overall;
                    if (diff > 0) { // Team 2 is favorite
                        odds2 = Math.max(1.1, baseOdds - (diff * ratingDifferenceFactor));
                    } else { // Team 2 is underdog
                        odds2 = Math.min(2.5, baseOdds + (Math.abs(diff) * ratingDifferenceFactor));
                    }
                }

                // Radio button for Team 1
                const radio1 = document.createElement('label');
                radio1.className = 'inline-flex items-center p-3 rounded-full cursor-pointer bg-gray-700 hover:bg-gray-600 transition duration-150 ease-in-out';
                radio1.innerHTML = `
                    <input type="radio" name="bet-target" value="${matchState.mode === 'singles' ? p1.name : 'Team 1'}" data-odds="${odds1.toFixed(2)}" class="form-radio h-5 w-5 text-yellow-400">
                    <span class="ml-2 text-gray-200 text-lg font-semibold">${team1Name} (${odds1.toFixed(2)}x)</span>
                `;
                betTargetSelection.appendChild(radio1);

                // Radio button for Team 2
                const radio2 = document.createElement('label');
                radio2.className = 'inline-flex items-center p-3 rounded-full cursor-pointer bg-gray-700 hover:bg-gray-600 transition duration-150 ease-in-out';
                radio2.innerHTML = `
                    <input type="radio" name="bet-target" value="${matchState.mode === 'singles' ? p3.name : 'Team 2'}" data-odds="${odds2.toFixed(2)}" class="form-radio h-5 w-5 text-yellow-400">
                    <span class="ml-2 text-gray-200 text-lg font-semibold">${team2Name} (${odds2.toFixed(2)}x)</span>
                `;
                betTargetSelection.appendChild(radio2);

                // Add event listener to update odds display
                betTargetSelection.querySelectorAll('input[name="bet-target"]').forEach(radio => {
                    radio.addEventListener('change', (e) => {
                        oddsValueDisplay.textContent = parseFloat(e.target.dataset.odds).toFixed(2);
                        currentBet.target = e.target.value;
                        currentBet.odds = parseFloat(e.target.dataset.odds);
                        checkMatchReady(); // Re-check button state after bet target selected
                    });
                });

            } else {
                bettingSection.classList.add('hidden');
            }
        }


        function checkMatchReady() {
            const { mode, team1, team2 } = matchState;
            let isMatchSetupReady = false;
            if (mode === 'singles') {
                isMatchSetupReady = team1[0] && team2[0];
            } else { // Tag Team
                isMatchSetupReady = team1[0] && team1[1] && team2[0] && team2[1];
            }

            let isBetValid = true;
            const betAmount = parseFloat(betAmountInput.value);
            const hasActiveBet = betAmount > 0; // Check if a positive bet amount is entered
            const betTargetSelected = currentBet.target !== null;

            if (hasActiveBet) {
                if (isNaN(betAmount) || betAmount <= 0) {
                    isBetValid = false;
                } else if (betAmount > userGold) {
                    isBetValid = false;
                } else if (!betTargetSelected) {
                    isBetValid = false;
                }
            }

            // Simulate button enabled if match is ready AND (no active bet OR active bet is valid)
            simulateButton.disabled = !isMatchSetupReady || (hasActiveBet && !isBetValid);
        }


        async function simulateMatch() {
            if (isLoading) {
                showMessage("A simulation is already in progress.", 'warning');
                return;
            }

            // Handle Betting Logic
            const betAmount = parseFloat(betAmountInput.value);
            const hasBet = !isNaN(betAmount) && betAmount > 0;
            
            betResultDisplay.textContent = ''; // Clear previous bet result

            if (hasBet) {
                if (betAmount > userGold) {
                    showMessage("Insufficient gold coins for this bet!", 'error');
                    simulateButton.disabled = true; // Keep disabled if bet invalid
                    return;
                }
                if (!currentBet.target) {
                    showMessage("Please select a wrestler or team to bet on before simulating.", 'error');
                    simulateButton.disabled = true; // Keep disabled if bet invalid
                    return;
                }

                // Deduct bet amount
                userGold -= betAmount;
                updateGoldDisplay();
                showMessage(`Bet placed: ${betAmount} gold on ${currentBet.target}!`, 'info');
            }

            isLoading = true;
            simulateButton.disabled = true;
            randomMatchupButton.disabled = true;
            resetButton.disabled = true;
            simulateSpinner.classList.remove('hidden');
            simulatePlayIcon.classList.add('hidden');
            
            // Hide the modal at the start of the simulation
            matchOutcomeModal.classList.remove('show');
            matchOutcomeModal.classList.add('hidden');
            
            battleLogElement.innerHTML = '<p class="text-gray-500">Simulating match series...</p>';
            matchWinnerNameElement.textContent = '';
            winnerImagesContainer.innerHTML = ''; // Clear winner images container
            winnerDescriptionElement.textContent = '';
            winCountsElement.textContent = '';


            const getWrestlerCopy = (name) => {
                const wrestler = JSON.parse(JSON.stringify(wrestlersData.find(w => w.name === name)));
                // Calculate current HP based on baseHp and stamina (stamina of 50 is neutral)
                wrestler.currentHp = Math.round(wrestler.baseHp * (1 + (wrestler.stamina - 50) / 100));
                return wrestler;
            };

            const numSimulations = 100;
            let winsTeam1 = 0;
            let winsTeam2 = 0;
            let draws = 0;
            let lastMatchLog = [];
            let overallWinnerName = null;

            if (matchState.mode === 'singles') {
                const wrestler1Base = getWrestlerCopy(matchState.team1[0]);
                const wrestler2Base = getWrestlerCopy(matchState.team2[0]);
                
                showMessage("Simulating 100 singles matches...", 'info');

                for (let i = 0; i < numSimulations; i++) {
                    let currentWrestlerA = getWrestlerCopy(wrestler1Base.name);
                    let currentWrestlerB = getWrestlerCopy(wrestler2Base.name);
                    const result = simulateSingleMatchInternal(currentWrestlerA, currentWrestlerB);
                    if (result.winner === wrestler1Base.name) {
                        winsTeam1++;
                    } else if (result.winner === wrestler2Base.name) {
                        winsTeam2++;
                    } else {
                        draws++;
                    }
                    lastMatchLog = result.log; // Store the log of the last match
                }

                if (winsTeam1 > winsTeam2) {
                    overallWinnerName = wrestler1Base.name;
                } else if (winsTeam2 > winsTeam1) {
                    overallWinnerName = wrestler2Base.name;
                } else {
                    overallWinnerName = "Draw";
                }

                battleLogElement.innerHTML = lastMatchLog.map((entry) =>
                    `<p class="${entry.startsWith('--- Turn') ? 'font-bold text-yellow-400 mt-2' : ''} ${entry.includes('FINISHING MOVE') ? 'text-orange-300' : ''} ${entry.includes('wins the match!') ? 'text-green-400 font-extrabold' : ''}">${entry}</p>`
                ).join('');
                battleLogElement.scrollTop = battleLogElement.scrollHeight;

                matchWinnerNameElement.textContent = overallWinnerName;
                winnerImagesContainer.innerHTML = ''; // Clear for single wrestler
                if (overallWinnerName !== "Draw") {
                    const winnerWrestler = wrestlersData.find(w => w.name === overallWinnerName);
                    const img = document.createElement('img');
                    img.src = `${BASE_IMAGE_URL}${getLastName(winnerWrestler.name)}.webp`;
                    img.alt = winnerWrestler.name;
                    img.className = 'w-32 h-32 rounded-full object-cover border-4 wrestler-image-border shadow-lg mx-auto';
                    img.onerror = function() { this.onerror=null; this.src=`https://placehold.co/150x150/1a1a1a/fff?text=${encodeURIComponent(winnerWrestler.name.replace(/\s/g, '+'))}`; };
                    winnerImagesContainer.appendChild(img);
                    winnerDescriptionElement.textContent = winnerWrestler.description;
                } else {
                    winnerImagesContainer.innerHTML = ''; // Ensure no image if draw
                    winnerDescriptionElement.textContent = "The series ended in a tie after many hard-fought battles.";
                }
                winCountsElement.textContent = `${wrestler1Base.name} Wins: ${winsTeam1} | ${wrestler2Base.name} Wins: ${winsTeam2} | Draws: ${draws}`;
                showMessage(`${overallWinnerName} wins the series!`, 'success');

            } else { // Tag Team Match
                const team1Names = [matchState.team1[0], matchState.team1[1]];
                const team2Names = [matchState.team2[0], matchState.team2[1]];

                showMessage("Simulating 100 tag team matches...", 'info');

                for (let i = 0; i < numSimulations; i++) {
                    const currentTeam1Live = [getWrestlerCopy(team1Names[0]), getWrestlerCopy(team1Names[1])];
                    const currentTeam2Live = [getWrestlerCopy(team2Names[0]), getWrestlerCopy(team2Names[1])];
                    const result = await simulateTagMatchInternal(currentTeam1Live, currentTeam2Live);
                    
                    if (result.winner && result.winner.includes("Team 1")) {
                        winsTeam1++;
                    } else if (result.winner && result.winner.includes("Team 2")) {
                        winsTeam2++;
                    } else {
                        draws++;
                    }
                    lastMatchLog = result.log; // Store the log of the last match
                }

                let overallWinnerTeamNames = null;
                let overallWinnerDescription = '';

                if (winsTeam1 > winsTeam2) {
                    overallWinnerTeamNames = team1Names;
                    overallWinnerName = `Team 1 (${team1Names.join(' & ')})`;
                    overallWinnerDescription = `${wrestlersData.find(w => w.name === team1Names[0])?.description || ''} ${wrestlersData.find(w => w.name === team1Names[1])?.description || ''}`.trim();
                    showMessage(`Team 1 (${team1Names.join(' & ')}) wins the series!`, 'success');
                } else if (winsTeam2 > winsTeam1) {
                    overallWinnerTeamNames = team2Names;
                    overallWinnerName = `Team 2 (${team2Names.join(' & ')})`;
                    overallWinnerDescription = `${wrestlersData.find(w => w.name === team2Names[0])?.description || ''} ${wrestlersData.find(w => w.name === team2Names[1])?.description || ''}`.trim();
                    showMessage(`Team 2 (${team2Names.join(' & ')}) wins the series!`, 'success');
                } else {
                    overallWinnerName = "Draw";
                    overallWinnerDescription = "The series ended in a tie after many hard-fought battles.";
                    showMessage(`The series ended in a draw!`, 'info');
                }

                battleLogElement.innerHTML = lastMatchLog.map((entry) =>
                    `<p class="${entry.startsWith('--- Turn') ? 'font-bold text-yellow-400 mt-2' : ''} ${entry.includes('FINISHING MOVE') ? 'text-orange-300' : ''} ${entry.includes('eliminated!') ? 'text-red-400 font-bold' : ''} ${entry.includes('tags in') ? 'text-blue-300' : ''} ${entry.includes('wins!') ? 'text-green-400 font-extrabold' : ''}">${entry}</p>`
                ).join('');
                battleLogElement.scrollTop = battleLogElement.scrollHeight;

                winnerImagesContainer.innerHTML = ''; // Clear previous images
                if (overallWinnerTeamNames) {
                    matchWinnerNameElement.textContent = overallWinnerName; // Set team name as winner
                    overallWinnerTeamNames.forEach(wrestlerName => {
                        const wrestler = wrestlersData.find(w => w.name === wrestlerName);
                        if (wrestler) {
                            const img = document.createElement('img');
                            img.src = `${BASE_IMAGE_URL}${getLastName(wrestler.name)}.webp`;
                            img.alt = wrestler.name;
                            img.className = 'w-32 h-32 rounded-full object-cover border-4 wrestler-image-border shadow-lg mx-2';
                            img.onerror = function() { this.onerror=null; this.src=`https://placehold.co/150x150/1a1a1a/fff?text=${encodeURIComponent(wrestler.name.replace(/\s/g, '+'))}`; };
                            winnerImagesContainer.appendChild(img);
                        }
                    });
                } else {
                    matchWinnerNameElement.textContent = "Draw";
                }
                winnerDescriptionElement.textContent = overallWinnerDescription;
                winCountsElement.textContent = `Team 1 Wins: ${winsTeam1} | Team 2 Wins: ${winsTeam2} | Draws: ${draws}`;
            }

            // Betting outcome calculation
            if (hasBet) {
                if (overallWinnerName.includes(currentBet.target)) { // Use .includes for team names
                    const winnings = betAmount * currentBet.odds;
                    userGold += winnings;
                    betResultDisplay.textContent = `You WON! +${(winnings - betAmount).toFixed(0)} gold! Total: ${userGold.toFixed(0)}`;
                    betResultDisplay.classList.remove('text-red-500');
                    betResultDisplay.classList.add('text-green-500');
                    showMessage(`You won ${winnings.toFixed(0)} gold!`, 'success');
                } else {
                    betResultDisplay.textContent = `You LOST! -${betAmount.toFixed(0)} gold! Total: ${userGold.toFixed(0)}`;
                    betResultDisplay.classList.remove('text-green-500');
                    betResultDisplay.classList.add('text-red-500');
                    showMessage(`You lost ${betAmount.toFixed(0)} gold.`, 'error');
                }
                updateGoldDisplay();
                // Reset betting UI
                betAmountInput.value = 0; // Reset to 0 for next optional bet
                betTargetSelection.querySelectorAll('input[name="bet-target"]').forEach(radio => radio.checked = false);
                oddsValueDisplay.textContent = 'N/A';
                currentBet = { amount: 0, target: null, odds: 0 };
            }


            // Show the modal ONLY after the simulation is complete
            matchOutcomeModal.classList.remove('hidden');
            matchOutcomeModal.classList.add('show');

            isLoading = false;
            simulateButton.disabled = false;
            randomMatchupButton.disabled = false;
            resetButton.disabled = false;
            simulateSpinner.classList.add('hidden');
            simulatePlayIcon.classList.remove('hidden');
            checkMatchReady(); // Re-check after simulation and bet processing
        }

        // Internal function for single match simulation (used by simulateMatch for singles mode)
        const simulateSingleMatchInternal = (wrestlerA, wrestlerB) => {
            let log = [];
            let currentWrestlerA = wrestlerA;
            let currentWrestlerB = wrestlerB;

            let turn = 1;
            let winner = null;
            const FINISHER_CHANCE = 0.1;

            const logAction = (message) => {
                log.push(message);
            };

            while (currentWrestlerA.currentHp > 0 && currentWrestlerB.currentHp > 0 && turn < 150) {
                logAction(`--- Turn ${turn} ---`);

                const attacker = turn % 2 === 1 ? currentWrestlerA : currentWrestlerB;
                const defender = turn % 2 === 1 ? currentWrestlerB : currentWrestlerA;

                let move;
                let isFinisher = false;

                if (Math.random() < FINISHER_CHANCE && attacker.currentHp > (attacker.baseHp * 0.2)) {
                    move = attacker.moves.finisher;
                    isFinisher = true;
                    logAction(`**${attacker.name} prepares for their devastating FINISHING MOVE, the ${move.name}!**`);
                } else {
                    const regularMoveTypes = ['grapple', 'strike', 'highFlying'];
                    const chosenMoveType = regularMoveTypes[getRandomInt(0, regularMoveTypes.length - 1)];
                    move = attacker.moves[chosenMoveType];
                }
                
                const relevantStat = attacker[move.stat];
                const statModifier = (relevantStat - 50) / 100;
                let effectiveHitChance = Math.min(0.95, Math.max(0.05, move.baseHitChance + statModifier * 0.2));
                
                let baseDamage = getRandomInt(move.damage.min, move.damage.max);
                let damageReduction = Math.floor(baseDamage * (defender.toughness / 200)); 
                let finalDamage = Math.max(0, baseDamage - damageReduction); 

                if (isFinisher) {
                    finalDamage = Math.round(finalDamage * 1.5);
                    effectiveHitChance = Math.min(0.98, effectiveHitChance + 0.1);
                    logAction(`${attacker.name}'s ${move.name} is attempted!`);
                } else {
                    logAction(`${attacker.name} attempts to use their ${move.name} on ${defender.name}.`);
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

        // Internal function for tag team match simulation
        const simulateTagMatchInternal = async (team1Live, team2Live) => {
            let log = [];
            let team1Active = team1Live[0];
            let team2Active = team2Live[0];
            let turn = 1;
            let winner = null;
            const FINISHER_CHANCE = 0.1;

            const logAction = (message, type = 'normal') => {
                log.push(message);
            };

            while (turn < 250) { // Increased turns for tag matches
                const currentAttacker = turn % 2 !== 0 ? team1Active : team2Active;
                const currentDefender = turn % 2 !== 0 ? team2Active : team1Active;

                // If an active wrestler is already eliminated, try to tag in
                if (currentAttacker.currentHp <= 0) {
                    const attackingTeam = turn % 2 !== 0 ? team1Live : team2Live;
                    const newActiveAttacker = attackingTeam.find(w => w.currentHp > 0 && w.name !== currentAttacker.name);
                    if (newActiveAttacker) {
                        if (turn % 2 !== 0) team1Active = newActiveAttacker;
                        else team2Active = newActiveAttacker;
                        logAction(`> ${currentAttacker.name} is down! ${newActiveAttacker.name} tags in for their team!`);
                        // Skip this turn's attack for the team that just tagged in due to elimination
                        turn++;
                        continue; 
                    }
                }
                if (currentDefender.currentHp <= 0) {
                     const defendingTeam = turn % 2 !== 0 ? team2Live : team1Live;
                     const newActiveDefender = defendingTeam.find(w => w.currentHp > 0 && w.name !== currentDefender.name);
                     if (newActiveDefender) {
                        if (turn % 2 !== 0) team2Active = newActiveDefender;
                        else team1Active = newActiveDefender;
                        logAction(`> ${currentDefender.name} is down! ${newActiveDefender.name} tags in for their team!`);
                        // No skip, defense happens as planned
                     }
                }

                if (currentAttacker.currentHp <= 0 || currentDefender.currentHp <= 0) {
                     // Re-check overall team elimination after potential tags
                    const team1Eliminated = team1Live.every(w => w.currentHp <= 0);
                    const team2Eliminated = team2Live.every(w => w.currentHp <= 0);

                    if (team1Eliminated) { winner = `Team 2 (${team2Live.map(w=>w.name).join(' & ')})`; break; }
                    if (team2Eliminated) { winner = `Team 1 (${team1Live.map(w=>w.name).join(' & ')})`; break; }
                }

                logAction(`--- Turn ${turn}: ${currentAttacker.name} (HP: ${Math.max(0, currentAttacker.currentHp)}) vs ${currentDefender.name} (HP: ${Math.max(0, currentDefender.currentHp)}) ---`);
                
                let move;
                let isFinisher = false;

                if (Math.random() < FINISHER_CHANCE && currentAttacker.currentHp > (currentAttacker.baseHp * 0.2)) {
                    move = currentAttacker.moves.finisher;
                    isFinisher = true;
                    logAction(`**${currentAttacker.name} prepares for their devastating FINISHING MOVE, the ${move.name}!**`);
                } else {
                    const regularMoveTypes = ['grapple', 'strike', 'highFlying'];
                    const chosenMoveType = regularMoveTypes[Math.floor(Math.random() * regularMoveTypes.length)];
                    move = currentAttacker.moves[chosenMoveType];
                }

                const relevantStat = currentAttacker[move.stat];
                const statModifier = (relevantStat - 50) / 100;
                let effectiveHitChance = Math.min(0.95, Math.max(0.05, move.baseHitChance + statModifier * 0.2));
                
                let baseDamage = getRandomInt(move.damage.min, move.damage.max);
                let damageReduction = Math.floor(baseDamage * (currentDefender.toughness / 200)); 
                let finalDamage = Math.max(0, baseDamage - damageReduction); 

                if (isFinisher) {
                    finalDamage = Math.round(finalDamage * 1.5);
                    effectiveHitChance = Math.min(0.98, effectiveHitChance + 0.1);
                    logAction(`${currentAttacker.name}'s ${move.name} is attempted!`);
                } else {
                    logAction(`${currentAttacker.name} attempts to use their ${move.name} on ${currentDefender.name}.`);
                }

                if (Math.random() < effectiveHitChance) {
                    currentDefender.currentHp -= finalDamage;
                    logAction(`${currentAttacker.name}'s ${move.name} hits ${currentDefender.name} for ${finalDamage} damage! ${currentDefender.name} HP: ${Math.max(0, currentDefender.currentHp)}`);

                    if (currentDefender.currentHp <= 0) {
                        currentDefender.currentHp = 0; 
                        logAction(`*** ${currentDefender.name} is knocked out and eliminated! ***`, 'elimination');
                        // Attempt to tag in new defender immediately if eliminated
                        const defendingTeam = turn % 2 !== 0 ? team2Live : team1Live;
                        const newActiveDefender = defendingTeam.find(w => w.currentHp > 0 && w.name !== currentDefender.name);
                        if (newActiveDefender) {
                            if (turn % 2 !== 0) team2Active = newActiveDefender;
                            else team1Active = newActiveDefender;
                            logAction(`> ${currentDefender.name} is down! ${newActiveDefender.name} tags in for their team!`);
                        }
                    }
                } else {
                    logAction(`${currentAttacker.name}'s ${move.name} misses!`);
                }
                
                // Check for overall team elimination after attack and potential tag-in
                const team1Eliminated = team1Live.every(w => w.currentHp <= 0);
                const team2Eliminated = team2Live.every(w => w.currentHp <= 0);

                if (team1Eliminated) { winner = `Team 2 (${team2Live.map(w=>w.name).join(' & ')})`; break; }
                if (team2Eliminated) { winner = `Team 1 (${team1Live.map(w=>w.name).join(' & ')})`; break; }

                // Tagging logic for active wrestler (random or strategic if low HP)
                const attackingTeam = turn % 2 !== 0 ? team1Live : team2Live;
                const currentActiveAttacker = turn % 2 !== 0 ? team1Active : team2Active;
                const partnerAttacker = attackingTeam.find(w => w.name !== currentActiveAttacker.name && w.currentHp > 0);

                const tagOutChance = (currentActiveAttacker.currentHp < (currentActiveAttacker.baseHp * 0.4)) ? 0.7 : 0.15; // 70% chance if low HP, 15% otherwise

                if (partnerAttacker && Math.random() < tagOutChance) {
                    logAction(`> ${currentActiveAttacker.name} tags out to ${partnerAttacker.name}!`);
                    if (turn % 2 !== 0) team1Active = partnerAttacker;
                    else team2Active = partnerAttacker;
                }

                turn++;
            }

            if (!winner) { // If match ended due to turn limit
                const team1RemainingHp = team1Live.reduce((sum, w) => sum + Math.max(0, w.currentHp), 0);
                const team2RemainingHp = team2Live.reduce((sum, w) => sum + Math.max(0, w.currentHp), 0);

                if (team1RemainingHp > team2RemainingHp) {
                    winner = `Team 1 (${team1Live.map(w=>w.name).join(' & ')})`;
                    logAction(`Match ends by time limit. Team 1 wins by total HP remaining!`, 'winner');
                } else if (team2RemainingHp > team1RemainingHp) {
                    winner = `Team 2 (${team2Live.map(w=>w.name).join(' & ')})`;
                    logAction(`Match ends by time limit. Team 2 wins by total HP remaining!`, 'winner');
                } else {
                    winner = "Draw";
                    logAction(`Match ends by time limit. It's a draw by total HP!`, 'winner');
                }
            }
            return { log, winner };
        };

        /**
         * Handles the random matchup selection.
         */
        function randomMatchup() {
            resetMatch(); // Clear any existing selection first

            const numNeeded = matchState.mode === 'singles' ? 2 : 4;
            if (wrestlersData.length < numNeeded) {
                showMessage("Not enough wrestlers for a random matchup in this mode!", "error");
                return;
            }

            let available = [...wrestlersData];
            const selectedWrestlers = [];

            for (let i = 0; i < numNeeded; i++) {
                const randomIndex = getRandomInt(0, available.length - 1);
                selectedWrestlers.push(available.splice(randomIndex, 1)[0]);
            }

            if (matchState.mode === 'singles') {
                matchState.team1[0] = selectedWrestlers[0].name;
                placeWrestlerInDropzone(selectedWrestlers[0], p1Slot);
                matchState.team2[0] = selectedWrestlers[1].name;
                placeWrestlerInDropzone(selectedWrestlers[1], p3Slot);
                showMessage(`Random singles match: ${selectedWrestlers[0].name} vs. ${selectedWrestlers[1].name}!`, 'success');
            } else { // Tag Team
                matchState.team1[0] = selectedWrestlers[0].name;
                placeWrestlerInDropzone(selectedWrestlers[0], p1Slot);
                matchState.team1[1] = selectedWrestlers[1].name;
                placeWrestlerInDropzone(selectedWrestlers[1], p2Slot);
                matchState.team2[0] = selectedWrestlers[2].name;
                placeWrestlerInDropzone(selectedWrestlers[2], p3Slot);
                matchState.team2[1] = selectedWrestlers[3].name;
                placeWrestlerInDropzone(selectedWrestlers[3], p4Slot);
                showMessage(`Random tag team match: Team ${selectedWrestlers[0].name} & ${selectedWrestlers[1].name} vs. Team ${selectedWrestlers[2].name} & ${selectedWrestlers[3].name}!`, 'success');
            }
            populateWrestlers();
            checkMatchReady();
            updateBettingTargets();
        }

        // Reset function
        function resetMatch() {
            matchState.team1 = [null, null];
            matchState.team2 = [null, null];

            // Reset all drop zones
            p1Slot.innerHTML = '<p class="text-center text-sm">Drag Player 1 Here</p>';
            p1Slot.classList.remove('has-wrestler', 'drag-over');

            p2Slot.innerHTML = '<p class="text-center text-sm">Drag Player 2 Here</p>';
            p2Slot.classList.remove('has-wrestler', 'drag-over');

            p3Slot.innerHTML = '<p class="text-center text-sm">Drag Player 3 Here</p>';
            p3Slot.classList.remove('has-wrestler', 'drag-over');

            p4Slot.innerHTML = '<p class="text-center text-sm">Drag Player 4 Here</p>';
            p4Slot.classList.remove('has-wrestler', 'drag-over');

            // Ensure battleResultsSection is hidden when resetting
            matchOutcomeModal.classList.add('hidden');
            matchOutcomeModal.classList.remove('show');

            battleLogElement.innerHTML = '<p class="text-gray-500">The play-by-play for the last simulated match will appear here.</p>';
            matchWinnerNameElement.textContent = '';
            winnerImagesContainer.innerHTML = ''; // Clear images when resetting
            winnerDescriptionElement.textContent = '';
            winCountsElement.textContent = '';
            betResultDisplay.textContent = ''; // Clear bet result on reset

            // Reset betting UI
            betAmountInput.value = 0; // Reset to 0 for optional betting
            betTargetSelection.querySelectorAll('input[name="bet-target"]').forEach(radio => radio.checked = false);
            oddsValueDisplay.textContent = 'N/A';
            currentBet = { amount: 0, target: null, odds: 0 };
            bettingSection.classList.add('hidden'); // Hide betting section if no wrestlers selected

            simulateButton.disabled = true;
            randomMatchupButton.disabled = false;
            resetButton.disabled = false;
            showMessage("Match setup cleared!", 'info');
            
            populateWrestlers(); // Re-populate all wrestlers in the roster
        }

        // Initial setup on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', () => {
            // Setup event listeners for mode buttons
            modeSinglesBtn.addEventListener('click', () => setMatchMode('singles'));
            modeTagBtn.addEventListener('click', () => setMatchMode('tag'));

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

            // Add input listener for bet amount to enable/disable button
            betAmountInput.addEventListener('input', checkMatchReady);


            // Initial mode setting
            setMatchMode('singles'); 

            updateGoldDisplay(); // Initial display of gold
            populateWrestlers();
            simulateButton.addEventListener('click', simulateMatch);
            randomMatchupButton.addEventListener('click', randomMatchup);
            resetButton.addEventListener('click', resetMatch);
            checkMatchReady();
        });
    </script>
</body>
</html>
