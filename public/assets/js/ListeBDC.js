const pageBtns = document.querySelectorAll('.btn_navigation');
const boxes = document.querySelectorAll('.box_liste');

function updatePages(selectedPage) {
    pageBtns.forEach((btn, index) => {
        if (selectedPage === parseInt(btn.getAttribute('data-page'))) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    });

    boxes.forEach((box, index) => {
        if (selectedPage === parseInt(box.getAttribute('data-page'))) {
            box.classList.remove('invisible');
        } else {
            box.classList.add('invisible');
        }
    });
}

updatePages(1);

pageBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const selectedPage = parseInt(btn.getAttribute('data-page'));
        updatePages(selectedPage);
    });
});