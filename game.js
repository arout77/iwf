// game.js

import { wrestlersData, userMovesPool, managersData } from './data.js';
import { BASE_IMAGE_URL, getRandomInt, getLastName, calculateOverallRating, showMessage, getTrainingCost, calculateEffectiveStats } from './utils.js';

// --- Global Game State Variables ---
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

let userGold = 1000; // Initial gold coins
let currentManager = null; // Stores the currently hired manager (redundant with userWrestler.manager, but kept for clarity based on original)

let opponentWrestler = null; // Stores the currently selected opponent

let isLoading = false; // Flag to prevent multiple simulations

// --- DOM Elements ---
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
const messageBox = document.getElementById('message-box'); // Referenced from utils, but also here for direct manipulation

// User Profile Elements
const myWrestlerCardDisplay = document.getElementById('my-wrestler-card-display');
const userLevelElement = document.getElementById('user-level');
const userXpElement = document.getElementById('user-xp');
const userXpNeededElement = document.getElementById('user-xp-needed');
const userXpBar = document.getElementById('user-xp-bar');
const skillTrainingButtonsContainer = document.getElementById('skill-training-buttons');

// Manager Section Elements
const managersContainer = document.getElementById('managers-container');
const currentManagerDisplay = document.getElementById('current-manager-display');

// Initial Setup Modal Elements
const initialSetupModal = document.getElementById('initial-setup-modal');
const prospectNameInput = document.getElementById('prospect-name-input');
const prospectHeightInput = document.getElementById('prospect-height-input');
const prospectWeightInput = document.getElementById('prospect-weight-input');
const avatarSelection = document.getElementById('avatar-selection');
const startGameButton = document.getElementById('start-game-button');
let selectedAvatar = userWrestler.avatar; // Keep track of selected avatar

// --- Game Initialization and Core Functions ---

// Add overall rating to each wrestler object in wrestlersData
wrestlersData.forEach(wrestler => {
    wrestler.overallRating = calculateOverallRating(wrestler);
});

// Sort wrestlersData alphabetically by name
wrestlersData.sort((a, b) => a.name.localeCompare(b.name));

// Calculate initial effective stats and overall rating for userWrestler
calculateEffectiveStats(userWrestler);
userWrestler.overallRating = calculateOverallRating(userWrestler);


/**
 * Updates the display of gold coins.
 */
function updateGoldDisplay() {
    goldDisplay.textContent = userGold.toFixed(0); // Display as integer
    updateTrainingButtons(); // Update training button states when gold changes
    populateManagers(); // Update manager buttons when gold changes
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

    const wrestlerImageName = getLastName(wrestler.name, userWrestler);
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
        if (wrestler.name !== userWrestler.name) {
            card.draggable = true;
        } else {
            card.classList.add('cursor-default'); // Make user card not draggable
        }

        // Determine which stats to display and their corresponding values
        const statsMap = {
            strength: { name: 'Strength', baseKey: 'baseStrength', effectiveKey: 'effectiveStrength' },
            technicalAbility: { name: 'Technical', baseKey: 'baseTechnicalAbility', effectiveKey: 'effectiveTechnicalAbility' },
            brawlingAbility: { name: 'Brawling', baseKey: 'baseBrawlingAbility', effectiveKey: 'effectiveBrawlingAbility' },
            stamina: { name: 'Stamina', baseKey: 'baseStamina', effectiveKey: 'effectiveStamina' },
            aerialAbility: { name: 'Aerial', baseKey: 'baseAerialAbility', effectiveKey: 'effectiveAerialAbility' },
            toughness: { name: 'Toughness', baseKey: 'baseToughness', effectiveKey: 'effectiveToughness' }
        };

        // Ensure overallRating is a number, default to 0 if NaN or not a number
        const overallRatingValue = typeof wrestler.overallRating === 'number' && !isNaN(wrestler.overallRating) ? wrestler.overallRating : 0;

        const statsHtml = `
            <div class="w-full text-xs mt-2 space-y-1">
                <div class="flex items-center mb-2">
                    <span class="w-20 text-gray-200 font-bold text-base">Overall:</span>
                    <div class="flex-1 h-4 rounded-full stat-bar-bg relative">
                        <div class="h-full rounded-full bg-yellow-500 p-2" style="width: ${overallRatingValue}%;"></div>
                        <span class="absolute top-0 right-1 text-xs text-white font-bold">${overallRatingValue}</span>
                    </div>
                </div>
                ${Object.keys(statsMap).map(statKey => {
                    const statInfo = statsMap[statKey];
                    // Use effective stat for the user's wrestler, and base stat for opponents
                    const value = (wrestler.name === userWrestler.name) ? wrestler[statInfo.effectiveKey] : wrestler[statKey];
                    // Ensure individual stat values are numbers, default to 0 if NaN or not a number
                    const displayValue = typeof value === 'number' && !isNaN(value) ? value : 0;
                    const statName = statInfo.name;
                    let statBarClass = '';
                    switch (statKey) {
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
                                <div class="h-full rounded-full ${statBarClass}" style="width: ${displayValue}%;"></div>
                                <span class="absolute top-0 right-1 text-xs text-white">${displayValue}</span>
                            </div>
                        </div>
                    `;
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
        const cost = getTrainingCost(userWrestler, skill);
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
    const cost = getTrainingCost(userWrestler, skillName);

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
    calculateEffectiveStats(userWrestler); // Recalculate effective stats after training
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

        // Format stat boosts for display
        const statBoostsHtml = Object.entries(manager.statBoosts || {})
            .map(([stat, value]) => {
                const statDisplayName = stat.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase());
                return `<span class="text-blue-300">${statDisplayName}: +${value}</span>`;
            })
            .join(', ');

        managerCard.innerHTML = `
            <img src="${managerImage}" alt="${manager.name}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-600 mb-2" onerror="this.onerror=null;this.src='https://placehold.co/96x96/1a1a1a/fff?text=${encodeURIComponent(manager.name.replace(/\s/g, '+'))}';">
            <h3 class="text-lg font-bold text-yellow-300 mb-1">${manager.name}</h3>
            <p class="text-xs text-gray-400 mb-2 line-clamp-3">${manager.description}</p>
            <p class="text-sm text-gray-300">Cost: <span class="text-yellow-400">${manager.cost}</span> <svg class="w-4 h-4 inline-block align-middle text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg></p>
            <p class="text-sm text-gray-300">XP Bonus: <span class="text-green-400">+${(manager.xpBonus * 100).toFixed(0)}%</span></p>
            <p class="text-sm text-gray-300">Gold Bonus: <span class="text-yellow-400">+${(manager.goldBonus * 100).toFixed(0)}%</span></p>
            <p class="text-sm text-gray-300">Stat Boosts: ${statBoostsHtml || 'None'}</p>
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
    calculateEffectiveStats(userWrestler); // Recalculate effective stats after hiring manager
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
        const winnerImageName = getLastName(winnerWrestlerObj.name, userWrestler); // Use getLastName for winner image
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
        if (userWrestler.manager && attacker.name === userWrestler.name && Math.random() < userWrestler.manager.interferenceChance) {
            const interferenceDamage = getRandomInt(5, 15); // Small damage from interference
            defender.currentHp -= interferenceDamage;
            logAction(`*** Manager Interference! ${userWrestler.manager.name} distracts ${defender.name}, causing ${interferenceDamage} damage! ***`);
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

        const relevantStat = attacker[`effective${move.stat.charAt(0).toUpperCase() + move.stat.slice(1)}`]; // Use effective stat
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
    if (userWrestler.manager) { // Use userWrestler.manager
        xpGained *= (1 + userWrestler.manager.xpBonus);
        goldGained *= (1 + userWrestler.manager.goldBonus);
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
        userWrestler[`base${statToIncrease.charAt(0).toUpperCase() + statToIncrease.slice(1)}`] = Math.min(100, userWrestler[`base${statToIncrease.charAt(0).toUpperCase() + statToIncrease.slice(1)}`] + increaseAmount); // Cap at 100
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

        calculateEffectiveStats(userWrestler); // Recalculate effective stats after level up
        updateUserWrestlerProfile(); // Update profile immediately after level up
    }
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

    // Corrected condition: check if name, height, or selectedAvatar are empty, OR if weight is NaN (not a number)
    if (!name || !height || isNaN(weight) || !selectedAvatar) {
        showMessage("Please enter your wrestler's name, height, weight, and choose an avatar!", 'error');
        return;
    }
    if (weight < 150 || weight > 500) {
        showMessage("Please enter a valid weight between 150 and 500 lbs.", 'error');
        return;
    }

    userWrestler.name = name;
    userWrestler.height = height;
    userWrestler.weight = weight;
    userWrestler.avatar = selectedAvatar;
    calculateEffectiveStats(userWrestler); // Recalculate after name/avatar set
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


// --- Event Listeners and Initial Setup on DOMContentLoaded ---
document.addEventListener('DOMContentLoaded', () => {
    // Setup initial prospect modal listeners
    prospectNameInput.addEventListener('input', checkSetupReady);
    prospectHeightInput.addEventListener('input', checkSetupReady);
    prospectHeightInput.addEventListener('change', checkSetupReady); // Add change listener for height
    prospectWeightInput.addEventListener('input', checkSetupReady);
    prospectWeightInput.addEventListener('change', checkSetupReady); // Add change listener for weight
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
