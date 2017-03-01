(function () {
    var events = document.getElementsByClassName('event');

    for (var i = 0; i < events.length; i++) {
        let start = events[i].getAttribute('data-start').split(':');
        let end = events[i].getAttribute('data-end').split(':');

        events[i].style.top = ((parseInt(start[0]) + 1 + start[1] / 60) * 4) + '%';
        events[i].style.bottom = ((24 - parseInt(end[0]) - end[1] / 60) * 4) + '%';
    }
})();

(function () {
    var form = document.getElementById('addEvent');

    form.addEventListener('submit', function (e) {
        var params = [];

        for (var i = 0; i < form.childNodes.length; i++)
            if (form.childNodes[i].name)
                params[form.childNodes[i].name] = form.childNodes[i].value;

        sendAjax('ajax.addevent.php', params, 'handleEvents');

        e.preventDefault();
        return false;
    });
})();


function handleEvents (results) {
    if (results.done) {
        alert('Evénement ajouté, veuillez raffraichir la page.');
    }
    else {
        alert(results.errors);
    }
}