
const ws = new WebSocket("ws://localhost:2346");

var stringToHTML = function (str) {
	var parser = new DOMParser();
	var doc = parser.parseFromString(str, 'text/html');
	return doc.body;
};

const submitBut = document.getElementById('createPost');
const removeBut = document.querySelector('input[name="delete"]');
removeBut?.addEventListener('click', (e) => {
    ws.send(true);
})
submitBut?.addEventListener('click', (e) => {
    ws.send(true);
});

ws.onmessage = response => {
    console.log('ws');
    console.log(response);
    const queryString = window.location.toString();
    const url = queryString.includes('friends') ? '99' : 'home';
    setTimeout(() => {
        axios.get(url)
        .then(data =>{
            const html = stringToHTML(data.data);
            const posts = html.querySelector('#posts').innerHTML
            if(queryString.includes('friends')){
                document.querySelector("#posts").innerHTML = posts
            }            
        });
    }, 1000);

};
