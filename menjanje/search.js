const searchBar = document.querySelector(".search-bar");
let typingTimer;

searchBar.addEventListener("input", () => {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        if(searchBar.value !== "")
            console.log(searchBar.value);
    }, 1000);
});