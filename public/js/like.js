const ws = new WebSocket("ws://localhost:2346");

likeBtns = document.querySelectorAll('#like-btn');
likesNumber = document.querySelectorAll('#likes-number');
for(let i = 0; i < likeBtns.length; i++){
    likeBtns[i].addEventListener('click', () => {
        likeValue = +likesNumber[i].innerHTML + 1;
        likesNumber[i].innerHTML = likeValue;
        postId = 400;
        const request = new XMLHttpRequest();
        const url = "localhost/posts/like";
        const params = {
            likesQuantity: likeValue,
            postID: postId
        };
        // "likes_quant=" + likeValue
        //     + "&post_id=" + postId;
        request.open("POST", url);

        //request.setRequestHeader("Content-type", "text/plain; charset=utf-8");

        // request.addEventListener('readystatechange', () => {
        //     if(request.readyState === 4 && request.status === 200){
        //         console.log(request.responseText);
        //     }
        // });


        console.log(ws);
        request.send(params);
    })
}
