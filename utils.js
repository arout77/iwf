// utils.js

// Base URL for wrestler images
export const BASE_IMAGE_URL = "https://php-mentor.com/sandbox/wrestling/images/";

// Function to get a random integer within a range
export const getRandomInt = (min, max) => {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
};

/**
 * Helper to extract the last name from a wrestler's full name for image URL.
 * Special handling for user's prospect and specific wrestler names to match image filenames.
 * @param {string} fullName - The full name of the wrestler.
 * @param {object} userWrestler - The user's wrestler object (to check for avatar).
 * @returns {string} The formatted name for the image URL.
 */
export const getLastName = (fullName, userWrestler) => {
    // Special handling for user's prospect
    if (userWrestler && fullName === userWrestler.name && userWrestler.avatar) {
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
        if (fullName === "Jimmy Garvin") return "jimmygarvin";
        if (fullName === "Ronnie Garvin") return "ronniegarvin";
        if (fullName === "The Iron Sheik") return "sheik";
        if (fullName === "Gillberg") return "gillberg";
        if (fullName === "Brooklyn Brawler") return "brawler";
        if (fullName === "Iron Mike Sharpe") return "sharpe";
        if (fullName === "Eddie Gilbert") return "gilbert"; // Added Eddie Gilbert

        // Default to last word for other multi-word names
        return parts[parts.length - 1].toLowerCase();
    }
    // For single-word names like "Sting", "Vader", "Goldberg", "Kane", "Christian", "Sheamus"
    return fullName.toLowerCase().replace(/\s/g, ''); // Remove spaces, convert to lowercase
};

/**
 * Calculates a wrestler's overall rating by eliminating the weakest attribute.
 * @param {object} wrestler - The wrestler data object.
 * @returns {number} The calculated overall rating.
 */
export function calculateOverallRating(wrestler) {
    // Determine which stats to use for the calculation.
    // If the wrestler object has 'effectiveStrength' (meaning it's the user's wrestler),
    // use the effective stats. Otherwise, use the base stats (for opponents).
    const statsToUse = [
        wrestler.effectiveStrength !== undefined ? wrestler.effectiveStrength : wrestler.strength,
        wrestler.effectiveTechnicalAbility !== undefined ? wrestler.effectiveTechnicalAbility : wrestler.technicalAbility,
        wrestler.effectiveBrawlingAbility !== undefined ? wrestler.effectiveBrawlingAbility : wrestler.brawlingAbility,
        wrestler.effectiveStamina !== undefined ? wrestler.effectiveStamina : wrestler.stamina,
        wrestler.effectiveAerialAbility !== undefined ? wrestler.effectiveAerialAbility : wrestler.aerialAbility,
        wrestler.effectiveToughness !== undefined ? wrestler.effectiveToughness : wrestler.toughness
    ];

    // Filter out any undefined or non-numeric values that might have slipped through
    const numericStats = statsToUse.filter(stat => typeof stat === 'number' && !isNaN(stat));

    if (numericStats.length === 0) {
        return 0; // Return 0 if no valid stats are found to prevent division by zero
    }

    // Find the lowest stat among the numeric ones
    const minStat = Math.min(...numericStats);

    // Create a new array excluding the first occurrence of the lowest stat
    let filteredStats = [...numericStats];
    const minIndex = filteredStats.indexOf(minStat);
    if (minIndex > -1) {
        filteredStats.splice(minIndex, 1);
    }

    // If after filtering, there are no stats left (e.g., only one stat was provided initially),
    // handle this case to prevent division by zero.
    if (filteredStats.length === 0) {
        return numericStats.length > 0 ? numericStats[0] : 0; // If only one stat, return that stat, else 0
    }

    // Calculate the sum of the remaining stats
    const sum = filteredStats.reduce((acc, stat) => acc + stat, 0);

    // Average the remaining stats (divide by 5 if 6 were initially present and one removed)
    return Math.round(sum / filteredStats.length);
}

/**
 * Displays messages to the user in a styled message box.
 * @param {string} message - The message to display.
 * @param {string} type - The type of message ('info', 'success', 'error', 'warning').
 */
export function showMessage(message, type = 'info') {
    const messageBox = document.getElementById('message-box');
    if (!messageBox) {
        console.error('Message box element not found!');
        return;
    }

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
 * Calculates the cost to train a specific skill.
 * @param {object} userWrestler - The user's wrestler object.
 * @param {string} skillName - The name of the skill (e.g., 'strength').
 * @returns {number} The cost in gold.
 */
export function getTrainingCost(userWrestler, skillName) {
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
 * Calculates the effective stats of the user's wrestler by applying manager boosts.
 * This function should be called whenever base stats or the manager changes.
 * @param {object} userWrestler - The user's wrestler object.
 */
export function calculateEffectiveStats(userWrestler) {
    const stats = ['strength', 'technicalAbility', 'brawlingAbility', 'stamina', 'aerialAbility', 'toughness'];
    stats.forEach(stat => {
        const baseStatName = `base${stat.charAt(0).toUpperCase() + stat.slice(1)}`;
        const effectiveStatName = `effective${stat.charAt(0).toUpperCase() + stat.slice(1)}`;
        let effectiveValue = userWrestler[baseStatName];

        // Ensure manager and its statBoosts exist before trying to access them
        if (userWrestler.manager && userWrestler.manager.statBoosts && typeof userWrestler.manager.statBoosts[stat] === 'number') {
            effectiveValue += userWrestler.manager.statBoosts[stat];
        }
        userWrestler[effectiveStatName] = Math.min(100, effectiveValue); // Cap at 100
    });
    userWrestler.overallRating = calculateOverallRating(userWrestler);
}
