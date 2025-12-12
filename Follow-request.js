let followButtons = document.querySelectorAll('.follow-button');

followButtons.forEach(btn => {
    btn.addEventListener('click', function () {

        if (btn.innerText === 'Follow') {
            btn.innerText = 'Requested';
            btn.classList.add('requested');
        } 
        else {
            btn.innerText = 'Follow';
            btn.classList.remove('requested');
        }

    });
});
