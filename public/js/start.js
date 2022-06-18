
const ws = new WebSocket("ws://localhost:2346");

var stringToHTML = function (str) {
	var parser = new DOMParser();
	var doc = parser.parseFromString(str, 'text/html');
	return doc.body;
};

const submitBut = document.getElementById('createPost');
const removeBut = document.querySelector('input[name="delete"]');
const editBut = document.getElementById('editPost');

editBut?.addEventListener('click', (e) => {
    ws.send('post');
})
removeBut?.addEventListener('click', (e) => {
    ws.send('post');
})
submitBut?.addEventListener('click', (e) => {
    ws.send('post');
});

ws.onmessage = response => {
    switch (response.data) {
        case 'post':
            const queryString = window.location.toString();
            const urlParams = queryString.split('/')
            const url = queryString.includes('friends') ? urlParams[urlParams.length - 1] : 'home';
            setTimeout(() => {
                axios.get(url)
                .then(data =>{
                    const html = stringToHTML(data.data);
                    const posts = html.querySelector('#posts').innerHTML
                    if(queryString.includes('friends')){
                        document.querySelector("#posts").innerHTML = posts
                        // editButton = document.getElementById('edit-btn');
                        if(editButton != null) {
                            editButton.addEventListener('click', () => {
                                descriptionForm.classList.toggle('hidden');
                        
                            });
                        }
                    }            
                });
            }, 1500);
            break;
    
        default:
            break;
    }


};
