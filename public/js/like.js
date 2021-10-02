likeBtns = document.querySelectorAll('#like-btn');
likesNumber = document.querySelectorAll('#likes-number');
for(let i = 0; i < likeBtns.length; i++){
    likeBtns[i].addEventListener('click', () => {
        likeValue = +likesNumber[i].innerHTML + 1;
        likesNumber[i].innerHTML = likeValue;
        postId = 400;
        const request = new XMLHttpRequest();
        const url = '/posts/like';
        const params = "likes_quant=" + likeValue
            + "&post_id=" + postId;
        request.open("POST", url, true);

        request.setRequestHeader("Content-type", "text/plain");

        request.addEventListener('readystatechange', () => {
            if(request.readyState === 4 && request.status === 200){
                console.log(request.responseText);
            }
        });

        request.send(params);
    })
}
