/**
 * Show edit description form
 * @type {HTMLElement}
 */
editButton = document.getElementById('edit-btn');
descriptionForm = document.getElementById('description-info');

if(editButton != null) {
    editButton.addEventListener('click', () => {
        descriptionForm.classList.toggle('hidden');

    });
}

/**
 * Show edit information form
 * @type {HTMLElement}
 */
editNameButton = document.getElementById('edit-name-btn');
userForm = document.getElementById('user-info');


if(editNameButton != null) {
    editNameButton.addEventListener('click', () => {
        userForm.classList.toggle('hidden');
    })
}

/**
 * Show comment section
 * @type {NodeListOf<Element>}
 */
showCommentButtons = document.querySelectorAll('#show-comment');
commentForms = document.querySelectorAll('#comment-form');

for(let i = 0; i < showCommentButtons.length; i++) {
    showCommentButtons[i].addEventListener('click', () => {
        commentForms[i].classList.toggle('hidden');
    })
}
