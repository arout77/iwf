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
    <link rel="stylesheet" href="style.css" data-precedence="next"/>
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
            Internet Wrestling Federation
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
                <div class="w-full bg-gray-500 rounded-full h-4 mt-2">
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

    <!-- <script src="data.js"></script>
    <script src="utils.js"></script> -->
    <script type="module" src="game.js"></script>
</body>
</html>
