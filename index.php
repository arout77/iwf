<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro Wrestling Match Maker</title>
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

        /* Button styling for Framer.ai look */
        .framer-button {
            padding: 1rem 2rem;
            border-radius: 9999px;
            font-weight: 800;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            border: none;
        }

        .framer-button-primary {
            background: linear-gradient(to right, #FACC15, #F97316);
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
            background-color: #2D3748; /* Darker gray background for cards */
            border: 2px solid transparent; /* Default transparent border */
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            cursor: grab; /* Indicate draggable */
            user-select: none; /* Prevent text selection during drag */
        }
        .wrestler-card:hover {
            border-color: #FACC15; /* Yellow border on hover */
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
            border-color: #FACC15; /* Yellow border on drag over */
            box-shadow: inset 0 0 20px rgba(250, 204, 21, 0.5); /* Yellow inner glow */
            background: rgba(250, 204, 21, 0.08); /* Light yellow background */
        }
        .drop-zone.has-wrestler {
            border-style: solid;
            border-color: #F97316; /* Orange solid border when wrestler is dropped */
            background: rgba(249, 115, 22, 0.15); /* Light orange background */
        }

        /* Wrestler image border */
        .wrestler-image-border {
            border-color: #FACC15; /* yellow-400 */
        }

        /* VS text for match setup */
        .vs-text {
            font-size: 4rem;
            font-weight: 900;
            color: #FACC15; /* yellow-400 */
            text-shadow: 0px 0px 15px rgba(250, 204, 21, 0.8);
        }

        /* Stat bars */
        .stat-bar-bg {
            background-color: #4A5568; /* bg-gray-600 */
        }
        .stat-bar-fill {
            background-color: #FACC15; /* bg-yellow-400 */
            transition: width 0.3s ease-out;
        }
        .stat-bar-strength { background-color: #EF4444; } /* red-500 */
        .stat-bar-technical { background-color: #3B82F6; } /* blue-500 */
        .stat-bar-brawling { background-color: #F97316; } /* orange-500 */
        .stat-bar-stamina { background-color: #10B981; } /* green-500 */
        .stat-bar-aerial { background-color: #A855F7; } /* purple-500 */

    </style>
</head>
<body class="min-h-screen flex flex-col items-center py-8 px-4 sm:px-6 text-gray-100 antialiased">
    <!-- Animated Background Container -->
    <div class="fixed inset-0 overflow-hidden" aria-hidden="true">
        <div class="animated-blob" style="width: 40vw; height: 40vw; top: -10vh; left: -10vw; --color-start: #FACC15; --color-end: #F97316; --duration: 25s; --delay: 0s; --x-start: 0vw; --y-start: 0vh; --scale-start: 1; --x-mid: 20vw; --y-mid: 20vh; --scale-mid: 1.2; --x-end: 10vw; --y-end: 10vh; --scale-end: 1;"></div>
        <div class="animated-blob" style="width: 30vw; height: 30vw; top: 60vh; left: 70vw; --color-start: #F97316; --color-end: #EF4444; --duration: 30s; --delay: 5s; --x-start: 0vw; --y-start: 0vh; --scale-start: 0.8; --x-mid: -10vw; --y-mid: -20vh; --scale-mid: 1; --x-end: 0vw; --y-end: 0vh; --scale-end: 0.8;"></div>
        <div class="animated-blob" style="width: 50vw; height: 50vw; top: 30vh; left: -30vw; --color-start: #EF4444; --color-end: #BE123C; --duration: 40s; --delay: 10s; --x-start: 0vw; --y-start: 0vh; --scale-start: 1.1; --x-mid: 30vw; --y-mid: -10vh; --scale-mid: 0.9; --x-end: 10vw; --y-end: 20vh; --scale-end: 1.1;"></div>
        <div class="animated-blob" style="width: 35vw; height: 35vw; top: -5vh; left: 80vw; --color-start: #BE123C; --color-end: #FACC15; --duration: 35s; --delay: 15s; --x-start: 0vw; --y-start: 0vh; --scale-start: 0.9; --x-mid: -20vw; --y-mid: 10vh; --scale-mid: 1.1; --x-end: -10vw; --y-end: -5vh; --scale-end: 0.9;"></div>
    </div>

    <div class="container max-w-7xl mx-auto flex flex-col items-center relative z-10">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 mb-12 drop-shadow-lg text-center leading-tight">
            Pro Wrestling Match Maker
        </h1>

        <div id="message-box" class="hidden battle-message fixed top-4 md:top-8 w-full max-w-sm md:max-w-md py-3 px-6 rounded-xl font-semibold text-center z-50 text-white shadow-lg"></div>

        <!-- Match Setup Area -->
        <div class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-10 w-full max-w-6xl mb-12">
            <!-- Wrestler 1 Drop Zone -->
            <div id="wrestler1-dropzone" class="drop-zone flex flex-col items-center justify-center p-6 rounded-2xl shadow-xl w-full md:w-1/2 min-h-[200px] text-gray-400 text-center text-lg">
                <p>Drag Wrestler 1 Here</p>
            </div>

            <!-- VS Element -->
            <div class="relative flex items-center justify-center w-20 h-20 sm:w-28 sm:h-28">
                <span class="vs-text">VS</span>
            </div>

            <!-- Wrestler 2 Drop Zone -->
            <div id="wrestler2-dropzone" class="drop-zone flex flex-col items-center justify-center p-6 rounded-2xl shadow-xl w-full md:w-1/2 min-h-[200px] text-gray-400 text-center text-lg">
                <p>Drag Wrestler 2 Here</p>
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
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 8c-.6 0-1-.4-1-1V2c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4zm0 8c-.6 0-1-.4-1 1v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1h-4zM20 12c0-.6-.4-1-1-1h-4c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-4zM7 12c0-.6-.4-1-1-1H2c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-4zM13 18c0-.6-.4-1-1-1h-4c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-4zM20 6c0-.6-.4-1-1-1h-4c-.6 0-1 .4-1 1v4c0 .6.4 1 1 1h4c.6 0 1-.4 1-1V6z"/></svg>
                Random Matchup
            </button>
            <button id="reset-button" class="framer-button framer-button-secondary flex items-center justify-center">
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8c0-4.08-3.05-7.44-7-7.93V4z"/></svg>
                Clear Match
            </button>
        </div>

        <!-- Battle Log and Summary -->
        <div id="battle-results-section" class="rounded-2xl shadow-2xl p-6 w-full max-w-5xl hidden glassmorphism-card">
            <h2 class="text-2xl font-semibold text-yellow-300 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                Match Outcome
            </h2>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Match Play-by-Play Log -->
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.9 2H19c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.3h1.9c.3 0 .6-.1.8-.4l2.1-2.1c-.2-.2-.3-.5-.3.8V4.8c0-.3-.1-.6-.4-.8L21.7 2.4c-.2-.2-.5-.3-.8-.4zM3.1 22H5c.3 0 .6-.1.8-.4l2.1-2.1c-.2-.2-.3.5-.3.8V14.5c0-.3-.1-.6-.4-.8l-2.1-2.1c-.2-.2-.5-.3-.8-.3H3.1c-.3 0-.6.1-.8.4l-2.1 2.1c-.2-.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.4zM10 8c-.6 0-1-.4-1-1V2c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4zm0 8c-.6 0-1-.4-1 1v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1h-4z"/></svg>
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
                        Overall Winner! (Best of 100)
                    </h3>
                    <div class="text-center">
                        <img id="winner-image" src="" alt="Match Winner" class="w-32 h-32 rounded-full object-cover border-4 wrestler-image-border shadow-lg mx-auto mb-4 hidden">
                        <p id="match-winner-name" class="text-3xl font-extrabold text-yellow-400 mb-2">
                            <!-- Winner Name Here -->
                        </p>
                        <p id="winner-description" class="text-md text-gray-300"></p>
                        <p id="win-counts" class="text-sm text-gray-400 mt-2">
                            <!-- Win counts will be displayed here -->
                        </p>
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
                // Road Warriors
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


                // Default to last word for other multi-word names
                return parts[parts.length - 1].toLowerCase();
            }
            // For single-word names like "Sting", "Vader", "Goldberg", "Kane", "Christian", "Sheamus"
            return fullName.toLowerCase().replace(/\s/g, ''); // Remove spaces, convert to lowercase
        };

        // Data for pro wrestlers including their finishing moves
        const wrestlersData = [
            {
                name: "Hulk Hogan",
                description: "The Immortal, Hollywood Hulk Hogan! Known for his strength and crowd-pleasing antics.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Full Nelson", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Big Boot", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Axe Bomber (running leg drop)", damage: { min: 8, max: 12 }, baseHitChance: 0.6, stat: 'aerialAbility' },
                    finisher: { name: "Leg Drop", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "The Rock",
                description: "The Most Electrifying Man in Sports Entertainment! Charismatic and powerful.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Sharpshooter", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Samoan Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'strength' },
                    highFlying: { name: "Flying Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "People's Elbow", damage: { min: 22, max: 32 }, baseHitChance: 0.88, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Stone Cold Steve Austin",
                description: "The Texas Rattlesnake! A beer-swilling, rule-breaking anti-hero.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(55, 75),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(15, 35),
                moves: {
                    grapple: { name: "Lou Thesz Press", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Mudhole Stomp", damage: { min: 8, max: 12 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Bionic Elbow", damage: { min: 7, max: 11 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    finisher: { name: "Stone Cold Stunner", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
                }
            },
            {
                name: "The Undertaker",
                description: "The Deadman. A mystical force with unparalleled longevity.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(65, 85),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(90, 100),
                aerialAbility: getRandomInt(10, 25),
                moves: {
                    grapple: { name: "Chokeslam", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Old School (Arm Walk)", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'technicalAbility' },
                    highFlying: { name: "Flying Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Tombstone Piledriver", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "John Cena",
                description: "Never Give Up! A powerful and popular modern-day hero.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(30, 50),
                moves: {
                    grapple: { name: "Five Knuckle Shuffle", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Diving Leg Drop Bulldog", damage: { min: 11, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Spinning Powerbomb", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Attitude Adjustment", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Ric Flair",
                description: "The Nature Boy! Sixteen-time World Champion, stylin', profilin', limousine-riding.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(50, 70),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(60, 80),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(15, 35),
                moves: {
                    grapple: { name: "Chop!", damage: { min: 8, max: 13 }, baseHitChance: 0.9, stat: 'brawlingAbility' },
                    strike: { name: "Top Rope Crossbody (misses)", damage: { min: 7, max: 12 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    highFlying: { name: "Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Figure-Four Leglock", damage: { min: 20, max: 30 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Shawn Michaels",
                description: "The Heartbreak Kid! Showstopper and highly agile performer.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(65, 85),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(60, 80),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(85, 100),
                moves: {
                    grapple: { name: "Flying Forearm", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    strike: { name: "Diving Elbow Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Teardrop Suplex", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Sweet Chin Music", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Bret Hart",
                description: "The Best There Is, The Best There Was, and The Best There Ever Will Be! A technical master.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(70, 90),
                technicalAbility: getRandomInt(90, 100),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(25, 45),
                moves: {
                    grapple: { name: "Snap Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Diving Elbow", damage: { min: 10, max: 15 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Backbreaker", damage: { min: 8, max: 13 }, baseHitChance: 0.65, stat: 'strength' },
                    finisher: { name: "Sharpshooter", damage: { min: 24, max: 34 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Andre the Giant",
                description: "The Eighth Wonder of the World. Unstoppable force.",
                baseHp: getRandomInt(140, 160),
                strength: getRandomInt(95, 100),
                technicalAbility: getRandomInt(30, 50),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(60, 80),
                aerialAbility: getRandomInt(1, 10),
                moves: {
                    grapple: { name: "Bodyslam", damage: { min: 15, max: 22 }, baseHitChance: 0.7, stat: 'strength' },
                    strike: { name: "Headbutt", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    finisher: { name: "Sit-down Splash", damage: { min: 28, max: 40 }, baseHitChance: 0.85, stat: 'strength' }
                }
            },
            {
                name: "Macho Man Randy Savage",
                description: "Ohhh Yeah! The cream of the crop!",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 90),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(70, 90),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(80, 95),
                moves: {
                    grapple: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Axe Handle Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Flying Crossbody", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Diving Elbow Drop", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }
                }
            },
            {
                name: "Triple H",
                description: "The Game! The Cerebral Assassin! King of Kings.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(65, 85),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Spinebuster", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Knee Drop", damage: { min: 8, max: 12 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Facebreaker Knee Smash", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Pedigree", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Kane",
                description: "The Big Red Machine. Demonic and powerful.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(88, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(15, 30),
                moves: {
                    grapple: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Flying Clothesline", damage: { min: 12, max: 18 }, baseHitChance: 0.65, stat: 'strength' },
                    highFlying: { name: "Top Rope Clothesline", damage: { min: 11, max: 17 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Chokeslam", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Mick Foley",
                description: "The Hardcore Legend. A master of pain and resilience.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Double Arm DDT", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Elbow Drop (from apron)", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    highFlying: { name: "Running Knee", damage: { min: 8, max: 13 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Mandible Claw", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Chris Jericho",
                description: "Y2J! The Ayatollah of Rock 'n' Rolla! Master of reinvention.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(60, 80),
                moves: {
                    grapple: { name: "Codebreaker", damage: { min: 15, max: 22 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Lionsault", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Diving Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Walls of Jericho", damage: { min: 23, max: 33 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Eddie Guerrero",
                description: "Latino Heat! Lie, Cheat, Steal, and Win!",
                baseHp: getRandomInt(80, 95),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(75, 90),
                brawlingAbility: getRandomInt(65, 80),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(85, 100),
                moves: {
                    grapple: { name: "Three Amigos (Suplexes)", damage: { min: 8, max: 13 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Suicide Dive", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Splash", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Frog Splash", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'aerialAbility' }
                }
            },
            {
                name: "Rey Mysterio",
                description: "The Master of the 619! High-flying luchador legend.",
                baseHp: getRandomInt(75, 90),
                strength: getRandomInt(40, 60),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(50, 70),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(95, 100),
                moves: {
                    grapple: { name: "Springboard Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    strike: { name: "West Coast Pop", damage: { min: 13, max: 19 }, baseHitChance: 0.8, stat: 'aerialAbility' },
                    highFlying: { name: "Hurricanrana", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "619", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'aerialAbility' }
                }
            },
            {
                name: "Kurt Angle",
                description: "It's true, it's damn true! An Olympic gold medalist.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(95, 100),
                brawlingAbility: getRandomInt(60, 80),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(40, 60),
                moves: {
                    grapple: { name: "Angle Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Moonsault", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Top Rope Belly-to-Belly", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Ankle Lock", damage: { min: 24, max: 34 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Goldberg",
                description: "Who's Next?! Dominant powerhouse.",
                baseHp: getRandomInt(105, 120),
                strength: getRandomInt(95, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(60, 80),
                aerialAbility: getRandomInt(5, 20),
                moves: {
                    grapple: { name: "Military Press Slam", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 10, max: 15 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Clothesline", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Spear", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Sting",
                description: "The Icon! A dark and mysterious defender of justice.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(55, 75),
                moves: {
                    grapple: { name: "Stinger Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.95, stat: 'brawlingAbility' },
                    strike: { name: "Diving Splash", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Top Rope Crossbody", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Scorpion Deathdrop", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Booker T",
                description: "Can you dig it, sucka?! Five-time WCW Champion.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(60, 80),
                moves: {
                    grapple: { name: "Book End", damage: { min: 13, max: 19 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Houston Hangover", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Scissors Kick", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "The Big Show",
                description: "The World's Largest Athlete. A giant among men.",
                baseHp: getRandomInt(120, 135),
                strength: getRandomInt(95, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(60, 75),
                aerialAbility: getRandomInt(1, 10),
                moves: {
                    grapple: { name: "Showstopper (Chokeslam)", damage: { min: 18, max: 25 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Banzai Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Knockout Punch", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }
                }
            },
            {
                name: "Kevin Nash",
                description: "Big Sexy. A dominant force with a cool demeanor.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(10, 25),
                moves: {
                    grapple: { name: "Sidewalk Slam", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Snake Eyes", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Jackknife Powerbomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Scott Hall",
                description: "The Bad Guy. Charismatic and cunning.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    strike: { name: "Chop!", damage: { min: 9, max: 14 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    highFlying: { name: "Fallaway Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Razor's Edge", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Diamond Dallas Page",
                description: "Feel the Bang! A late bloomer who achieved superstardom.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(65, 85),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(40, 60),
                moves: {
                    grapple: { name: "Fist Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Splash", damage: { min: 8, max: 13 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    highFlying: { name: "Inverted Atomic Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Diamond Cutter", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Chris Benoit",
                description: "The Rabid Wolverine. A highly technical and intense competitor.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(90, 100),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(50, 70),
                moves: {
                    grapple: { name: "German Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Diving Headbutt", damage: { min: 13, max: 19 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Snap Suplex", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    finisher: { name: "Crippler Crossface", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Rob Van Dam",
                description: "Mr. Pay Per View! One of a kind high-flying innovator.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(90, 100),
                moves: {
                    grapple: { name: "Rolling Thunder", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    strike: { name: "Van Daminator (spinning heel kick)", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Split-Legged Moonsault", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Five-Star Frog Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'aerialAbility' }
                }
            },
            {
                name: "Dusty Rhodes",
                description: "The American Dream. A common man's champion.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Atomic Drop", damage: { min: 8, max: 13 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    highFlying: { name: "Bionic Knee Drop", damage: { min: 7, max: 12 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    finisher: { name: "Bionic Elbow", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Dustin Rhodes",
                description: "The Natural. Known for his unique style and incredible resilience.",
                baseHp: getRandomInt(88, 102),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(30, 50),
                moves: {
                    grapple: { name: "Bulldog", damage: { min: 10, max: 15 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Shattered Dreams (low blow)", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Running Uppercut", damage: { min: 8, max: 12 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Cross Rhodes", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Ultimate Warrior",
                description: "Feel the power of the Warrior! Intense and energetic.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(10, 25),
                moves: {
                    grapple: { name: "Gorilla Press Slam", damage: { min: 18, max: 25 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Flying Clothesline", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    highFlying: { name: "Big Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Warrior Splash", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Bruiser Brody",
                description: "Unpredictable and wild brawler. A true hardcore legend.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(30, 50),
                brawlingAbility: getRandomInt(95, 100),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(5, 20),
                moves: {
                    grapple: { name: "Running Big Boot", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Elbow Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Bearhug", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "King Kong Knee Drop", damage: { min: 27, max: 37 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Scott Steiner",
                description: "Big Poppa Pump. Genetically modified and mathematically superior.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Frankensteiner", damage: { min: 13, max: 19 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Diving Blockbuster", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Top Rope Steinerline", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Steiner Recliner", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Barry Windham",
                description: "The Lone Wolf. A versatile and skilled wrestler.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(50, 70),
                moves: {
                    grapple: { name: "Lariat", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Flying Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Bulldog", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Superplex", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Lex Luger",
                description: "The Total Package. Imposing physique and powerful moves.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Bionic Forearm", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Elbow Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Powerslam", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Torture Rack", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "CM Punk",
                description: "The Best in the World. Straight Edge and outspoken.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(85, 100),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(60, 80),
                moves: {
                    grapple: { name: "Anaconda Vice", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Diving Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Springboard Clothesline", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Go To Sleep", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Curt Hennig",
                description: "Mr. Perfect. Technically brilliant and arrogant.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(90, 100),
                brawlingAbility: getRandomInt(65, 80),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(40, 60),
                moves: {
                    grapple: { name: "Dropkick", damage: { min: 9, max: 14 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Fisherman Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Perfect-Plex", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "AJ Styles",
                description: "The Phenomenal One. Agile, innovative, and world-class.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(85, 100),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(80, 95),
                moves: {
                    grapple: { name: "Phenomenal Forearm", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'aerialAbility' },
                    strike: { name: "Spiral Tap", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    highFlying: { name: "Calf Crusher", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Styles Clash", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Samoa Joe",
                description: "The Samoan Submission Machine. Brutal and dominant.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(75, 90),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Muscle Buster", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Olé Kick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Diving Headbutt", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Coquina Clutch", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'technicalAbility' }
                }
            },
            {
                name: "Kevin Owens",
                description: "Fight Owens Fight! A prizefighter who does whatever it takes.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(30, 50),
                moves: {
                    grapple: { name: "Cannonball", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Senton", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Swanton Bomb", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Pop-up Powerbomb", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Kerry Von Erich",
                description: "The Modern Day Warrior. A powerful and athletic Von Erich.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(40, 60),
                moves: {
                    grapple: { name: "Flying Crossbody", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    strike: { name: "Discus Punch", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Backhand Chop", damage: { min: 8, max: 13 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Iron Claw", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Kevin Von Erich",
                description: "The Texas Tornado. A dynamic and athletic member of the legendary Von Erich family, known for his signature Iron Claw.",
                baseHp: getRandomInt(88, 103),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(50, 70),
                moves: {
                    grapple: { name: "Iron Claw (hold)", damage: { min: 10, max: 16 }, baseHitChance: 0.80, stat: 'strength' },
                    strike: { name: "Dropkick", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Flying Crossbody", damage: { min: 11, max: 17 }, baseHitChance: 0.70, stat: 'aerialAbility' },
                    finisher: { name: "Iron Claw", damage: { min: 26, max: 36 }, baseHitChance: 0.92, stat: 'strength' }
                }
            },
            {
                name: "The Great Khali",
                description: "The Punjabi Nightmare. A towering giant with immense power and an intimidating presence.",
                baseHp: getRandomInt(130, 150),
                strength: getRandomInt(98, 100),
                technicalAbility: getRandomInt(20, 40),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(50, 70),
                aerialAbility: getRandomInt(1, 5),
                moves: {
                    grapple: { name: "Vice Grip", damage: { min: 18, max: 25 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Punjabi Chop", damage: { min: 15, max: 22 }, baseHitChance: 0.80, stat: 'brawlingAbility' },
                    highFlying: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.60, stat: 'strength' },
                    finisher: { name: "Khali Bomb", damage: { min: 35, max: 45 }, baseHitChance: 0.90, stat: 'strength' }
                }
            },
            {
                name: "Dean Malenko",
                description: "The Man of 1,000 Holds. Unrivaled technical prowess.",
                baseHp: getRandomInt(80, 95),
                strength: getRandomInt(60, 75),
                technicalAbility: getRandomInt(95, 100),
                brawlingAbility: getRandomInt(55, 70),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(30, 50),
                moves: {
                    grapple: { name: "Suplex", damage: { min: 8, max: 13 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Springboard Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Cross Armbreaker", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Texas Cloverleaf", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Shinsuke Nakamura",
                description: "The King of Strong Style. Charismatic striker.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(40, 60),
                moves: {
                    grapple: { name: "Good Vibrations (corner stomps)", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Bomaye (running knee)", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Sliding German Suplex", damage: { min: 11, max: 17 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    finisher: { name: "Kinshasa", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Roman Reigns",
                description: "The Tribal Chief. Head of the Table and Undisputed.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(90, 100),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Superman Punch", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Drive By (running dropkick)", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Samoan Drop", damage: { min: 13, max: 19 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Spear", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Seth Rollins",
                description: "The Architect. Visionary and revolutionary.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(85, 100),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(70, 90),
                moves: {
                    grapple: { name: "Pedigree", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Frog Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Phoenix Splash", damage: { min: 13, max: 19 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Curb Stomp", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'aerialAbility' }
                }
            },
            {
                name: "Ron Simmons",
                description: "DAMN! Dominant and hard-hitting.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Spinebuster", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'strength' },
                    strike: { name: "Powerbomb", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Dominator", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Bob Backlund",
                description: "Mr. Bob Backlund. An intense amateur wrestling phenom.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(90, 100),
                brawlingAbility: getRandomInt(60, 80),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Atomic Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Piledriver", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    highFlying: { name: "Backbreaker", damage: { min: 8, max: 13 }, baseHitChance: 0.65, stat: 'strength' },
                    finisher: { name: "Crossface Chickenwing", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Brock Lesnar",
                description: "The Beast Incarnate! Dominant and destructive.",
                baseHp: getRandomInt(105, 120),
                strength: getRandomInt(95, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(1, 20),
                moves: {
                    grapple: { name: "German Suplex", damage: { min: 15, max: 21 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Kimura Lock", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    highFlying: { name: "Knee Lift", damage: { min: 8, max: 13 }, baseHitChance: 0.6, stat: 'strength' },
                    finisher: { name: "F-5", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }
                }
            },
            {
                name: "Bobby Lashley",
                description: "The All Mighty. Powerful and athletic.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Spear", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Dominator", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Vertical Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Full Nelson (Hurt Lock)", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Terry Funk",
                description: "The Funker. Hardcore legend with incredible longevity.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(15, 35),
                moves: {
                    grapple: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Diving Moonsault (often misses)", damage: { min: 10, max: 16 }, baseHitChance: 0.65, stat: 'aerialAbility' },
                    highFlying: { name: "Spinning Toe Hold", damage: { min: 14, max: 20 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    finisher: { name: "Texas Death Match Driver", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Sid Vicious",
                description: "The Master and Ruler of the World. Unstable powerhouse.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(60, 75),
                aerialAbility: getRandomInt(5, 20),
                moves: {
                    grapple: { name: "Big Boot", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Leg Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Chokeslam", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' },
                    finisher: { name: "Powerbomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Terry Gordy",
                description: "One of the Fabulous Freebirds. A tough and hard-hitting brawler.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Lariat", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Big Splash", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Powerslam", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Powerbomb", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Stan Hansen",
                description: "The Lariat. A wild and intense Texan brawler.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(30, 50),
                brawlingAbility: getRandomInt(95, 100),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(5, 20),
                moves: {
                    grapple: { name: "Piledriver", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'brawlingAbility' },
                    strike: { name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Belly-to-Back Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Western Lariat", damage: { min: 30, max: 40 }, baseHitChance: 0.95, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Jake Roberts",
                description: "The Snake. Master of mind games and DDTs.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(75, 90),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Short-Arm Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Knee Lift", damage: { min: 8, max: 13 }, baseHitChance: 0.6, stat: 'technicalAbility' },
                    highFlying: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "DDT", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Sheamus",
                description: "The Celtic Warrior. A hard-hitting Irishman.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(60, 80),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Ten Beats of the Bodhran", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Irish Curse Backbreaker", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "White Noise", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Brogue Kick", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Road Warrior Hawk",
                description: "Ohhhhh, what a rush! Half of the Legion of Doom.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(5, 20),
                moves: {
                    grapple: { name: "Clothesline", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Flying Shoulder Tackle", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Powerslam", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Diving Clothesline", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Road Warrior Animal",
                description: "What a rush! The other half of the Legion of Doom.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(5, 20),
                moves: {
                    grapple: { name: "Power Slam", damage: { min: 17, max: 24 }, baseHitChance: 0.82, stat: 'strength' },
                    strike: { name: "Clothesline", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    highFlying: { name: "Elbow Drop", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    finisher: { name: "Powerslam", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Edge",
                description: "The Rated-R Superstar. Opportunistic and cunning.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(60, 80),
                moves: {
                    grapple: { name: "Edgecution", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Flying Crossbody", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Impailer DDT", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    finisher: { name: "Spear", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Christian",
                description: "Captain Charisma. A master strategist and innovator.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(85, 100),
                brawlingAbility: getRandomInt(65, 80),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(70, 90),
                moves: {
                    grapple: { name: "Unprettier", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Frog Splash", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Diving Headbutt", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Killswitch", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Batista",
                description: "The Animal. Powerful and intense.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Spear", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Spinebuster", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Powerbomb", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    finisher: { name: "Batista Bomb", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Randy Orton",
                description: "The Viper. Apex Predator with a cunning mind.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Punt Kick", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "DDT", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    highFlying: { name: "Powerslam", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "RKO", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'brawlingAbility' }
                }
            },
            {
                name: "Cody Rhodes",
                description: "The American Nightmare. Driven to finish the story.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(75, 90),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(50, 70),
                moves: {
                    grapple: { name: "Cody Cutter", damage: { min: 14, max: 20 }, baseHitChance: 0.78, stat: 'aerialAbility' },
                    strike: { name: "Moonsault", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    highFlying: { name: "Disaster Kick", damage: { min: 11, max: 17 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    finisher: { name: "Cross Rhodes", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Vader",
                description: "The Mastodon. A dominant super-heavyweight.",
                baseHp: getRandomInt(110, 125),
                strength: getRandomInt(95, 100),
                technicalAbility: getRandomInt(40, 60),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(60, 75),
                aerialAbility: getRandomInt(10, 25),
                moves: {
                    grapple: { name: "Powerbomb", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Moonsault (from top)", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'strength' },
                    highFlying: { name: "Chokeslam", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Vader Bomb", damage: { min: 30, max: 40 }, baseHitChance: 0.92, stat: 'strength' }
                }
            },
            {
                name: "Rick Rude",
                description: "The Ravishing One. Arrogant and in incredible shape.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(70, 85),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Neckbreaker", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Piledriver", damage: { min: 12, max: 18 }, baseHitChance: 0.7, stat: 'technicalAbility' },
                    highFlying: { name: "Suplex", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'strength' },
                    finisher: { name: "Rude Awakening", damage: { min: 26, max: 36 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Ted DiBiase",
                description: "The Million Dollar Man. Everyone has a price!",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(65, 80),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(20, 40),
                moves: {
                    grapple: { name: "Fist Drop", damage: { min: 9, max: 14 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    strike: { name: "Back Elbow", damage: { min: 8, max: 13 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Hotshot", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Million Dollar Dream", damage: { min: 25, max: 35 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Harley Race",
                description: "The King. Eight-time NWA World Champion.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Knee Drop", damage: { min: 12, max: 18 }, baseHitChance: 0.78, stat: 'brawlingAbility' },
                    strike: { name: "Headbutt", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'brawlingAbility' },
                    highFlying: { name: "Vertical Suplex", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Piledriver", damage: { min: 27, max: 37 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Roddy Piper",
                description: "Rowdy. One of the greatest talkers and most unpredictable.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(65, 80),
                technicalAbility: getRandomInt(60, 75),
                brawlingAbility: getRandomInt(90, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(15, 35),
                moves: {
                    grapple: { name: "Eye Poke", damage: { min: 5, max: 10 }, baseHitChance: 0.9, stat: 'brawlingAbility' },
                    strike: { name: "Punch Flurry", damage: { min: 8, max: 13 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Low Blow", damage: { min: 7, max: 12 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Sleeper Hold", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'brawlingAbility' }
                }
            },
            {
                name: "The Great Muta",
                description: "The Essence of Muta. A mystical and dangerous Japanese legend.",
                baseHp: getRandomInt(90, 105),
                strength: getRandomInt(75, 90),
                technicalAbility: getRandomInt(80, 95),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(70, 90),
                moves: {
                    grapple: { name: "Dragon Screw", damage: { min: 10, max: 16 }, baseHitChance: 0.78, stat: 'technicalAbility' },
                    strike: { name: "Handspring Elbow", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Flash Elbow", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    finisher: { name: "Moonsault", damage: { min: 28, max: 38 }, baseHitChance: 0.92, stat: 'aerialAbility' }
                }
            },
            {
                name: "Rick Steiner",
                description: "The Dog-Faced Gremlin. A powerful and aggressive amateur wrestling powerhouse.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(70, 85),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(85, 100),
                aerialAbility: getRandomInt(15, 30),
                moves: {
                    grapple: { name: "Steinerline", damage: { min: 15, max: 22 }, baseHitChance: 0.85, stat: 'strength' },
                    strike: { name: "Bulldog", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Rebound Lariat", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    finisher: { name: "Steiner Driver", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Mike Rotunda",
                description: "Irwin R. Schyster (IRS). A calculating taxman who gets his due.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(75, 90),
                brawlingAbility: getRandomInt(65, 80),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Abdominal Stretch", damage: { min: 8, max: 13 }, baseHitChance: 0.75, stat: 'technicalAbility' },
                    strike: { name: "Clothesline", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Falling Clothesline", damage: { min: 9, max: 14 }, baseHitChance: 0.65, stat: 'brawlingAbility' },
                    finisher: { name: "Write-Off (Stock Market Crash)", damage: { min: 24, max: 34 }, baseHitChance: 0.9, stat: 'technicalAbility' }
                }
            },
            {
                name: "Owen Hart",
                description: "The King of Harts. High-flying and technically gifted.",
                baseHp: getRandomInt(85, 100),
                strength: getRandomInt(70, 85),
                technicalAbility: getRandomInt(90, 100),
                brawlingAbility: getRandomInt(60, 80),
                stamina: getRandomInt(80, 95),
                aerialAbility: getRandomInt(85, 100),
                moves: {
                    grapple: { name: "Bridging German Suplex", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'technicalAbility' },
                    strike: { name: "Missile Dropkick", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'aerialAbility' },
                    highFlying: { name: "Spinning Heel Kick", damage: { min: 11, max: 17 }, baseHitChance: 0.7, stat: 'aerialAbility' },
                    finisher: { name: "Sharpshooter", damage: { min: 26, max: 36 }, baseHitChance: 0.95, stat: 'technicalAbility' }
                }
            },
            {
                name: "Big Boss Man",
                description: "The G-Man! A law enforcement officer who brings the pain.",
                baseHp: getRandomInt(100, 115),
                strength: getRandomInt(85, 100),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(80, 95),
                stamina: getRandomInt(70, 85),
                aerialAbility: getRandomInt(5, 20),
                moves: {
                    grapple: { name: "Sidewalk Slam", damage: { min: 12, max: 18 }, baseHitChance: 0.75, stat: 'strength' },
                    strike: { name: "Boss Man Straddle", damage: { min: 10, max: 16 }, baseHitChance: 0.7, stat: 'brawlingAbility' },
                    highFlying: { name: "Big Boot", damage: { min: 9, max: 14 }, baseHitChance: 0.6, stat: 'strength' },
                    finisher: { name: "Boss Man Slam", damage: { min: 28, max: 38 }, baseHitChance: 0.9, stat: 'strength' }
                }
            },
            {
                name: "Big John Studd",
                description: "A Giant! He demanded respect and money.",
                baseHp: getRandomInt(110, 125),
                strength: getRandomInt(90, 100),
                technicalAbility: getRandomInt(30, 50),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(60, 75),
                aerialAbility: getRandomInt(1, 10),
                moves: {
                    grapple: { name: "Full Nelson", damage: { min: 15, max: 22 }, baseHitChance: 0.8, stat: 'strength' },
                    strike: { name: "Big Boot", damage: { min: 10, max: 16 }, baseHitChance: 0.6, stat: 'strength' },
                    highFlying: { name: "Elbow Drop", damage: { min: 8, max: 13 }, baseHitChance: 0.5, stat: 'strength' },
                    finisher: { name: "Atomic Drop", damage: { min: 28, max: 38 }, baseHitChance: 0.85, stat: 'strength' }
                }
            },
            {
                name: "Junkyard Dog",
                description: "Woof woof! The charismatic and powerful JYD.",
                baseHp: getRandomInt(95, 110),
                strength: getRandomInt(80, 95),
                technicalAbility: getRandomInt(50, 70),
                brawlingAbility: getRandomInt(85, 100),
                stamina: getRandomInt(75, 90),
                aerialAbility: getRandomInt(10, 30),
                moves: {
                    grapple: { name: "Thump (headbutt)", damage: { min: 12, max: 18 }, baseHitChance: 0.8, stat: 'brawlingAbility' },
                    strike: { name: "Big Punch", damage: { min: 10, max: 16 }, baseHitChance: 0.75, stat: 'brawlingAbility' },
                    highFlying: { name: "Body Slam", damage: { min: 9, max: 14 }, baseHitChance: 0.7, stat: 'strength' },
                    finisher: { name: "Powerslam", damage: { min: 25, max: 35 }, baseHitChance: 0.9, stat: 'strength' }
                }
            }
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

        let selectedWrestler1 = null;
        let selectedWrestler2 = null;
        let isLoading = false;

        // DOM Elements
        const wrestler1Dropzone = document.getElementById('wrestler1-dropzone');
        const wrestler2Dropzone = document.getElementById('wrestler2-dropzone');
        const wrestlersContainer = document.getElementById('wrestlers-container');
        const simulateButton = document.getElementById('simulate-button');
        const randomMatchupButton = document.getElementById('random-matchup-button'); // New button
        const resetButton = document.getElementById('reset-button');
        const battleLogElement = document.getElementById('battle-log');
        const battleResultsSection = document.getElementById('battle-results-section');
        const matchWinnerNameElement = document.getElementById('match-winner-name');
        const winnerImageElement = document.getElementById('winner-image');
        const winnerDescriptionElement = document.getElementById('winner-description');
        const simulateSpinner = document.getElementById('simulate-spinner');
        const simulatePlayIcon = document.getElementById('simulate-play-icon');
        const messageBox = document.getElementById('message-box');
        const winCountsElement = document.getElementById('win-counts');

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

            // Keep message visible for a bit longer if it's a simulation progress update
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
         * @returns {HTMLElement} The created wrestler card element.
         */
        function createWrestlerCard(wrestler) {
            const card = document.createElement('div');
            card.className = 'wrestler-card p-4 rounded-xl flex flex-col items-center';
            card.draggable = true; // Draggable by default for the roster
            card.dataset.wrestlerName = wrestler.name; 
            card.id = `wrestler-card-${wrestler.name.replace(/\s/g, '-')}`; 

            // Construct image URL based on last name
            const lastName = getLastName(wrestler.name);
            const imageUrl = `${BASE_IMAGE_URL}${lastName}.webp`;

            // Stats HTML
            const statsHtml = `
                <div class="w-full text-xs mt-2 space-y-1">
                    <div class="flex items-center mb-2">
                        <span class="w-20 text-gray-200 font-bold text-base">Overall:</span>
                        <div class="flex-1 h-4 rounded-full stat-bar-bg relative">
                            <div class="h-full rounded-full bg-yellow-500" style="width: ${wrestler.overallRating}%;"></div>
                            <span class="absolute top-0 right-1 text-xs text-white font-bold">${wrestler.overallRating}</span>
                        </div>
                    </div>
                    ${Object.keys(wrestler).map(key => {
                        if (['strength', 'technicalAbility', 'brawlingAbility', 'stamina', 'aerialAbility'].includes(key)) {
                            const value = wrestler[key];
                            const statName = key.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase()); // Convert camelCase to Title Case
                            let statBarClass = '';
                            switch (key) {
                                case 'strength': statBarClass = 'stat-bar-strength'; break;
                                case 'technicalAbility': statBarClass = 'stat-bar-technical'; break;
                                case 'brawlingAbility': statBarClass = 'stat-bar-brawling'; break;
                                case 'stamina': statBarClass = 'stat-bar-stamina'; break;
                                case 'aerialAbility': statBarClass = 'stat-bar-aerial'; break;
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
                <p class="text-xs font-semibold text-orange-400 text-center mb-2">Finisher: ${wrestler.moves.finisher.name}</p>
                <p class="text-sm text-gray-400 text-center mb-2 line-clamp-2">${wrestler.description}</p>
                ${statsHtml}
            `;
            return card;
        }

        // Populate available wrestlers
        function populateWrestlers() {
            wrestlersContainer.innerHTML = ''; // Clear previous cards
            wrestlersData.sort((a, b) => a.name.localeCompare(b.name)); // Sort alphabetically

            wrestlersData.forEach(wrestler => {
                const card = createWrestlerCard(wrestler);
                wrestlersContainer.appendChild(card);
            });
            addDragListeners(); // Add drag listeners to newly created cards
        }

        // Simulate a single match between two wrestlers
        const simulateSingleMatch = (wrestlerA, wrestlerB) => {
            let log = [];
            // Deep copy wrestlers and calculate effective HP based on stamina
            let currentWrestlerA = JSON.parse(JSON.stringify(wrestlerA));
            currentWrestlerA.currentHp = Math.round(wrestlerA.baseHp * (1 + (wrestlerA.stamina - 50) / 100));
            let currentWrestlerB = JSON.parse(JSON.stringify(wrestlerB));
            currentWrestlerB.currentHp = Math.round(wrestlerB.baseHp * (1 + (wrestlerB.stamina - 50) / 100));

            let turn = 1;
            let winner = null;
            const FINISHER_CHANCE = 0.1; // 10% chance to attempt a finisher each turn

            // Helper to log actions
            const logAction = (message) => {
                log.push(message);
            };

            while (currentWrestlerA.currentHp > 0 && currentWrestlerB.currentHp > 0 && turn < 150) { // Max 150 turns for a match
                logAction(`--- Turn ${turn} ---`);

                const attacker = turn % 2 === 1 ? currentWrestlerA : currentWrestlerB;
                const defender = turn % 2 === 1 ? currentWrestlerB : currentWrestlerA;

                let move;
                let isFinisher = false;

                // Determine if a finisher is attempted
                if (Math.random() < FINISHER_CHANCE && attacker.currentHp > (attacker.baseHp * 0.2)) { // Can't hit finisher if too low HP
                    move = attacker.moves.finisher;
                    isFinisher = true;
                    logAction(`${attacker.name} prepares for their devastating FINISHING MOVE, the ${move.name}!`);
                } else {
                    // Randomly choose a regular move type
                    const regularMoveTypes = ['grapple', 'strike', 'highFlying'];
                    const chosenMoveType = regularMoveTypes[getRandomInt(0, regularMoveTypes.length - 1)];
                    move = attacker.moves[chosenMoveType];
                }
                
                const relevantStat = attacker[move.stat];

                // Calculate effective hit chance and damage based on attributes
                const statModifier = (relevantStat - 50) / 100;
                let effectiveHitChance = Math.min(0.95, Math.max(0.05, move.baseHitChance + statModifier * 0.2));
                
                let baseDamage = getRandomInt(move.damage.min, move.damage.max);
                let damageDealt = Math.round(baseDamage * (1 + statModifier * 0.5 + attacker.strength * 0.005));

                // If it's a finisher, apply a damage bonus
                if (isFinisher) {
                    damageDealt = Math.round(damageDealt * 1.5); // Finisher deals 50% more damage
                    effectiveHitChance = Math.min(0.98, effectiveHitChance + 0.1); // Finisher is also 10% more likely to hit (capped at 98%)
                    logAction(`${attacker.name}'s ${move.name} is attempted!`);
                } else {
                    logAction(`${attacker.name} attempts to use their ${move.name} (${move.stat} based move) on ${defender.name}.`);
                }


                if (Math.random() < effectiveHitChance) {
                    defender.currentHp -= damageDealt;
                    logAction(`${attacker.name}'s ${move.name} hits ${defender.name} for ${damageDealt} damage! ${defender.name} HP: ${Math.max(0, defender.currentHp)}`);

                    if (defender.currentHp <= 0) {
                        winner = attacker.name;
                        break;
                    }
                } else {
                    logAction(`${attacker.name}'s ${move.name} misses!`);
                }
                turn++;
            }

            if (!winner) { // If match ended due to turn limit
                if (currentWrestlerA.currentHp > currentWrestlerB.currentHp) {
                    winner = currentWrestlerA.name;
                    logAction(`Turn limit reached. ${currentWrestlerA.name} wins with more HP.`);
                } else if (currentWrestlerB.currentHp > currentWrestlerA.currentHp) {
                    winner = currentWrestlerB.name;
                    logAction(`Turn limit reached. ${currentWrestlerB.name} wins with more HP.`);
                } else {
                    winner = "Draw";
                    logAction(`Turn limit reached. It's a draw! No winner for this match.`);
                }
            }
            return { log, winner };
        };

        // Simulate a best of X series
        const simulateBestOfX = async (wrestler1, wrestler2, numSimulations) => {
            let winsA = 0;
            let winsB = 0;
            let draws = 0;
            let lastMatchLog = [];

            for (let i = 0; i < numSimulations; i++) {
                showMessage(`Simulating match ${i + 1} of ${numSimulations}...`, 'info');
                // Use a small delay to allow the message to show, but not too long to slow down too much
                await new Promise(resolve => setTimeout(resolve, 10)); 
                const result = simulateSingleMatch(wrestler1, wrestler2);
                if (result.winner === wrestler1.name) {
                    winsA++;
                } else if (result.winner === wrestler2.name) {
                    winsB++;
                } else {
                    draws++;
                }
                lastMatchLog = result.log; // Store the log of the last match
            }

            let overallWinner = "Draw";
            if (winsA > winsB) {
                overallWinner = wrestler1.name;
            } else if (winsB > winsA) {
                overallWinner = wrestler2.name;
            }

            return {
                overallWinner,
                winsA,
                winsB,
                draws,
                lastMatchLog
            };
        };

        /**
         * Places a wrestler card into a specified dropzone.
         * @param {object} wrestler - The wrestler data object to place.
         * @param {HTMLElement} dropzoneElement - The dropzone element (e.g., wrestler1-dropzone).
         */
        function placeWrestlerInDropzone(wrestler, dropzoneElement) {
            const card = createWrestlerCard(wrestler);
            card.draggable = false; // Make dropped card non-draggable from here
            card.classList.remove('wrestler-card', 'cursor-grab'); // Remove source card styling
            card.classList.add('glassmorphism-card', 'p-4', 'shadow-lg'); // Add dropzone card styling

            dropzoneElement.innerHTML = ''; // Clear "Drag Wrestler Here" text
            dropzoneElement.appendChild(card);
            dropzoneElement.classList.add('has-wrestler'); // Mark as occupied
        }


        // Handle drag and drop logic
        let draggedWrestler = null; // Stores the wrestler data of the dragged card

        function handleDragStart(e) {
            // Find the closest parent with the 'wrestler-card' class
            const draggedCardElement = e.target.closest('.wrestler-card');
            if (!draggedCardElement) {
                // If for some reason the dragged element is not a wrestler card or inside one, exit.
                console.error("Drag started on an element not associated with a wrestler card.");
                return;
            }

            const wrestlerName = draggedCardElement.dataset.wrestlerName;
            draggedWrestler = wrestlersData.find(w => w.name === wrestlerName);
            
            // It's important to set data only if a valid wrestler is found
            if (draggedWrestler) {
                e.dataTransfer.setData('text/plain', wrestlerName); // Set data for drag
                draggedCardElement.classList.add('dragging'); // Add visual cue for dragging
                showMessage(`Dragging ${draggedWrestler.name}.`, 'info');
            } else {
                e.preventDefault(); // Prevent drag if no valid wrestler data
                showMessage("Cannot drag an invalid wrestler card.", 'error');
            }
        }

        function handleDragEnd(e) {
            const draggedCardElement = e.target.closest('.wrestler-card');
            if (draggedCardElement) {
                draggedCardElement.classList.remove('dragging'); // Remove visual cue
            }
            draggedWrestler = null;
        }

        function handleDragOver(e) {
            e.preventDefault(); // Essential to allow drop
            if (!e.currentTarget.classList.contains('has-wrestler')) { // Only allow drag over if not already occupied
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

            // Check if dropzone is already occupied
            if (e.currentTarget.classList.contains('has-wrestler')) {
                showMessage("This slot is already taken. Clear the match first!", 'warning');
                return;
            }

            // Prevent dropping the same wrestler in both slots
            if ((e.currentTarget.id === 'wrestler1-dropzone' && selectedWrestler2 && selectedWrestler2.name === wrestler.name) ||
                (e.currentTarget.id === 'wrestler2-dropzone' && selectedWrestler1 && selectedWrestler1.name === wrestler.name)) {
                showMessage("You cannot select the same wrestler for both slots!", 'error');
                return;
            }

            placeWrestlerInDropzone(wrestler, e.currentTarget);

            if (e.currentTarget.id === 'wrestler1-dropzone') {
                selectedWrestler1 = wrestler;
            } else {
                selectedWrestler2 = wrestler;
            }
            showMessage(`${wrestler.name} added to the match!`, 'success');
            checkMatchReady();
        }

        function addDragListeners() {
            // Attach dragstart and dragend listeners directly to the wrestler-card elements
            // The event delegation approach is more robust
            wrestlersContainer.querySelectorAll('.wrestler-card').forEach(card => {
                card.addEventListener('dragstart', handleDragStart);
                card.addEventListener('dragend', handleDragEnd);
            });

            wrestler1Dropzone.addEventListener('dragover', handleDragOver);
            wrestler1Dropzone.addEventListener('dragleave', handleDragLeave);
            wrestler1Dropzone.addEventListener('drop', handleDrop);

            wrestler2Dropzone.addEventListener('dragover', handleDragOver);
            wrestler2Dropzone.addEventListener('dragleave', handleDragLeave);
            wrestler2Dropzone.addEventListener('drop', handleDrop);
        }

        function checkMatchReady() {
            if (selectedWrestler1 && selectedWrestler2) {
                simulateButton.disabled = false;
                showMessage("Match ready! Click 'Simulate Match'!", 'info');
            } else {
                simulateButton.disabled = true;
            }
        }

        async function simulateMatch() {
            if (!selectedWrestler1 || !selectedWrestler2) {
                showMessage("Please drag two wrestlers into the slots first!", 'error');
                return;
            }

            isLoading = true;
            simulateButton.disabled = true;
            randomMatchupButton.disabled = true; // Disable random button during simulation
            resetButton.disabled = true;
            simulateSpinner.classList.remove('hidden');
            simulatePlayIcon.classList.add('hidden');
            battleResultsSection.classList.add('hidden'); // Hide previous results
            battleLogElement.innerHTML = '<p class="text-gray-500">Simulating matches...</p>';
            winCountsElement.textContent = ''; // Clear previous win counts
            matchWinnerNameElement.textContent = ''; // Clear previous winner
            winnerImageElement.classList.add('hidden'); // Hide winner image
            winnerDescriptionElement.textContent = ''; // Clear description


            const numSimulations = 100;
            const overallResult = await simulateBestOfX(selectedWrestler1, selectedWrestler2, numSimulations);

            // Display results
            battleLogElement.innerHTML = overallResult.lastMatchLog.map((entry) =>
                `<p class="${entry.startsWith('--- Turn') ? 'font-bold text-yellow-400 mt-2' : ''} ${entry.includes('FINISHING MOVE') ? 'text-orange-300' : ''}">${entry}</p>`
            ).join('');
            battleLogElement.scrollTop = battleLogElement.scrollHeight; // Scroll to bottom

            if (overallResult.overallWinner && overallResult.overallWinner !== "Draw") {
                const winnerWrestler = wrestlersData.find(w => w.name === overallResult.overallWinner);
                matchWinnerNameElement.textContent = winnerWrestler.name;
                // Construct winner image URL using the same logic
                const winnerLastName = getLastName(winnerWrestler.name);
                winnerImageElement.src = `${BASE_IMAGE_URL}${winnerLastName}.webp`;
                winnerImageElement.alt = winnerWrestler.name;
                winnerImageElement.classList.remove('hidden');
                winnerDescriptionElement.textContent = winnerWrestler.description;
                showMessage(`${winnerWrestler.name} wins the series! (${overallResult.winsA} - ${overallResult.winsB})`, 'success');
            } else {
                matchWinnerNameElement.textContent = "It's a Draw!";
                winnerImageElement.classList.add('hidden'); // Hide image for draws
                winnerDescriptionElement.textContent = "The series ended in a tie after many hard-fought battles.";
                showMessage("The series ended in a draw!", 'warning');
            }
            
            winCountsElement.textContent = `${selectedWrestler1.name} Wins: ${overallResult.winsA} | ${selectedWrestler2.name} Wins: ${overallResult.winsB} | Draws: ${overallResult.draws}`;
            
            battleResultsSection.classList.remove('hidden');

            isLoading = false;
            simulateButton.disabled = false;
            randomMatchupButton.disabled = false; // Re-enable random button after simulation
            resetButton.disabled = false;
            simulateSpinner.classList.add('hidden');
            simulatePlayIcon.classList.remove('hidden');
        }

        /**
         * Handles the random matchup selection.
         */
        function handleRandomMatchup() {
            if (wrestlersData.length < 2) {
                showMessage("Not enough wrestlers for a random matchup!", "error");
                return;
            }

            resetMatch(); // Clear any existing selection first

            let index1 = getRandomInt(0, wrestlersData.length - 1);
            let index2;
            do {
                index2 = getRandomInt(0, wrestlersData.length - 1);
            } while (index1 === index2); // Ensure two different wrestlers are selected

            selectedWrestler1 = wrestlersData[index1];
            selectedWrestler2 = wrestlersData[index2];

            placeWrestlerInDropzone(selectedWrestler1, wrestler1Dropzone);
            placeWrestlerInDropzone(selectedWrestler2, wrestler2Dropzone);

            showMessage(`Random matchup: ${selectedWrestler1.name} vs. ${selectedWrestler2.name}!`, 'success');
            checkMatchReady();
        }

        // Reset function
        function resetMatch() {
            selectedWrestler1 = null;
            selectedWrestler2 = null;

            wrestler1Dropzone.innerHTML = '<p>Drag Wrestler 1 Here</p>';
            wrestler1Dropzone.classList.remove('has-wrestler', 'drag-over');

            wrestler2Dropzone.innerHTML = '<p>Drag Wrestler 2 Here</p>';
            wrestler2Dropzone.classList.remove('has-wrestler', 'drag-over');

            battleResultsSection.classList.add('hidden');
            battleLogElement.innerHTML = '<p class="text-gray-500">The play-by-play for the last simulated match will appear here.</p>';
            matchWinnerNameElement.textContent = '';
            winnerImageElement.src = '';
            winnerImageElement.classList.add('hidden');
            winnerDescriptionElement.textContent = '';
            winCountsElement.textContent = ''; // Clear win counts

            simulateButton.disabled = true;
            randomMatchupButton.disabled = false; // Re-enable random button
            resetButton.disabled = false; // Reset button remains enabled
            showMessage("Match setup cleared!", 'info');
            
            // Re-populate all wrestlers in case some were removed (not strictly necessary with this approach, but good for robustness)
            populateWrestlers();
        }

        // Initial setup on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', () => {
            populateWrestlers();
            simulateButton.addEventListener('click', simulateMatch);
            randomMatchupButton.addEventListener('click', handleRandomMatchup); // New event listener
            resetButton.addEventListener('click', resetMatch);
            checkMatchReady(); // Initial check to disable simulate button
        });
    </script>
</body>
</html>
