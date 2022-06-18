const ws = new WebSocket("ws://localhost:2346");
const postForm = document.getElementById('createPost');
const postFormEl = document.forms.createPost
postForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(postFormEl)
    console.log(formData.get('title'))
    console.log(formData.get('post_description'))
    console.log(formData.get('category_id'))
    console.log(`/img/postomg/${formData.get('post_img').name}`)
});