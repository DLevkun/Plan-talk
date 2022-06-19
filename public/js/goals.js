/**
 * Show create goal form
 * @type {HTMLElement}
 */
createGoalButton = document.getElementById('create-goal-btn');
goalForm = document.getElementById('goal-form');

createGoalButton.addEventListener('click', () => {
    goalForm.classList.toggle('hidden');
})
