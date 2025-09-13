document.addEventListener("DOMContentLoaded", () => {
    const id = window.currentId;
    const imgElement = document.getElementById(`item${id}`);

    if (imgElement) {
        imgElement.src = `https://picsum.photos/id/${id}/600/400?grayscale`;
    }
});
