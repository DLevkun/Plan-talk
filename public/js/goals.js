ws = new WebSocket("ws://localhost:2346");

createGoalButton = document.getElementById('create-goal-btn');
goalForm = document.getElementById('goal-form');

createGoalButton.addEventListener('click', () => {
    goalForm.classList.toggle('hidden');
})
