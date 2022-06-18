const ws = new WebSocket("ws://localhost:2346");

var stringToHTML = function (str) {
    var parser = new DOMParser();
    var doc = parser.parseFromString(str, "text/html");
    return doc.body;
};

const addPostBut = document.getElementById("createPost");
const removePostBut = document.querySelector('input[name="delete"]');
const editPostBut = document.getElementById("editPost");

editPostBut?.addEventListener("click", (e) => {
    ws.send("post");
});
removePostBut?.addEventListener("click", (e) => {
    ws.send("post");
});
addPostBut?.addEventListener("click", (e) => {
    ws.send("post");
});


const addGoalBut = document.getElementById("addGoal");
const saveGoalBut = document.getElementById("saveGoal");
const deleteGoalBut = document.getElementById("deleteGoal");

addGoalBut?.addEventListener("click", (e) => {
    ws.send("goal");
});
deleteGoalBut?.addEventListener("click", (e) => {
    ws.send("goal");
});
saveGoalBut?.addEventListener("click", (e) => {
    ws.send("goal");
});

ws.onmessage = (response) => {
    const queryString = window.location.toString();
    const urlParams = queryString.split("/");
    const id = urlParams[urlParams.length - 1];

    switch (response.data) {
        case "post":
            const postUrl = queryString.includes("friends")
            ? id
            : "home";
            setTimeout(() => {
                axios.get(postUrl).then((data) => {
                    const html = stringToHTML(data.data);
                    if (queryString.includes("friends")) {
                        const posts = html.querySelector("#posts").innerHTML;
                        document.querySelector("#posts").innerHTML = posts;
                        showCommentButtons =
                            document.querySelectorAll("#show-comment");
                        commentForms =
                            document.querySelectorAll("#comment-form");

                        for (let i = 0; i < showCommentButtons.length; i++) {
                            showCommentButtons[i].addEventListener(
                                "click",
                                () => {
                                    commentForms[i].classList.toggle("hidden");
                                }
                            );
                        }
                    }
                });
            }, 1500);
            break;

        case "goal":
            const goalUrl = queryString.includes("goals")
            ? id
            : "home";
            setTimeout(() => {
                axios.get(goalUrl).then((data) => {
                    const html = stringToHTML(data.data);
                    const goals = html.querySelector("#goals").innerHTML;
                    if (queryString.includes("goals")) {
                        document.querySelector("#goals").innerHTML = goals;
                    }
                });
            }, 1500);
            break;
        default:
            break;
    }
};
