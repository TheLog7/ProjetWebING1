import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
/*JS pour cantine */
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var menuElement = document.getElementById('menu-of-the-day');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        selectable: true,
        events: reservedDates.map(date => ({
            start: date,
            display: 'background',
            color: '#cccccc'
        })),
        dateClick: function(info) {
            displayMenuForDate(info.dateStr);
            document.getElementById('reservation-date').value = info.dateStr;
            colorSelectedDate(info.dateStr);
        }
    });

    calendar.render();

    function displayMenuForDate(date) {
        var menu = menus[date];
        if (menu) {
            const options = { weekday: 'long', day: 'numeric', month: 'long' };
            const formattedDate = new Date(date).toLocaleDateString('fr-FR', options);
            menuElement.innerHTML = `
                <h3>Menu du ${formattedDate}</h3>
                <div class="menu-item"><strong>Entrée :</strong> ${menu.entree}</div>
                <div class="menu-item"><strong>Plat :</strong> ${menu.plat}</div>
                <div class="menu-item"><strong>Dessert :</strong> ${menu.dessert}</div>
                <img src="https://i.postimg.cc/wTMnVyHt/cantine.jpg" alt="Pensez à réserver" style="max-width: 60%; height: auto; border-radius: 10px; margin-top: 20px;" />
            `;
        } else {
            menuElement.innerHTML = '<p>Aucun menu disponible pour cette date.</p>';
        }
    }

    function canReserve(date) {
        const today = new Date();
        const selected = new Date(date);
        return selected >= today;
    }

    function canUnreserve(date) {
        const today = new Date();
        const selected = new Date(date);
        return selected >= today && (selected.getTime() - today.getTime()) / (1000 * 60 * 60 * 24) >= 1;
    }

    window.handleReservation = function() {
        const selectedDate = document.getElementById('reservation-date').value;

        if (!selectedDate || !isValidDate(selectedDate)) {
            document.getElementById('error-message').innerText = 'Veuillez saisir une date valide (format: YYYY-MM-DD).';
            return;
        }

        if (!canReserve(selectedDate)) {
            document.getElementById('error-message').innerText = 'Vous ne pouvez pas réserver une date antérieure à aujourd\'hui.';
            return;
        }

        if (reservedDates.includes(selectedDate)) {
            document.getElementById('error-message').innerText = 'Cette date est déjà réservée.';
            return;
        }

        if (!menus[selectedDate]) {
            document.getElementById('error-message').innerText = 'Aucun menu disponible pour cette date. Vous ne pouvez pas réserver.';
            return;
        }

        fetch('/reserve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                date: selectedDate
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                reservedDates.push(selectedDate);
                calendar.addEvent({
                    start: selectedDate,
                    display: 'background',
                    color: '#cccccc'
                });
                calendar.refetchEvents();
                colorSelectedDate(selectedDate);
                document.getElementById('error-message').innerText = '';
            } else {
                document.getElementById('error-message').innerText = data.error;
            }
        })
        .catch(error => {
            console.error('Erreur dans le fetch ou la réservation:', error);
            document.getElementById('error-message').innerText = 'Une erreur est survenue lors de la réservation.';
        });
    };

    window.handleUnreserve = function() {
        const selectedDate = document.getElementById('reservation-date').value;

        if (!selectedDate || !isValidDate(selectedDate)) {
            document.getElementById('error-message').innerText = 'Veuillez saisir une date valide (format: YYYY-MM-DD).';
            return;
        }

        if (!canUnreserve(selectedDate)) {
            document.getElementById('error-message').innerText = 'Vous ne pouvez annuler une réservation que jusqu\'à 2 jours avant et pas pour une date antérieure.';
            return;
        }

        fetch('/unreserve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                date: selectedDate
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                reservedDates = reservedDates.filter(date => date !== selectedDate);

                const events = calendar.getEvents();
                events.forEach(event => {
                    if (event.startStr === selectedDate) {
                        event.remove();
                    }
                });

                document.querySelectorAll('.fc-day').forEach(function(day) {
                    if (day.getAttribute('data-date') === selectedDate) {
                        day.style.backgroundColor = '';
                    }
                });

                calendar.refetchEvents();
                document.getElementById('error-message').innerText = '';
            } else {
                document.getElementById('error-message').innerText = data.error;
            }
        })
        .catch(error => {
            console.error('Erreur dans le fetch ou la déréservation:', error);
            document.getElementById('error-message').innerText = 'Une erreur est survenue lors de la déréservation.';
        });
    };

    function colorSelectedDate(date) {
        document.querySelectorAll('.fc-day').forEach(function(day) {
            if (day.getAttribute('data-date') === date) {
                day.style.backgroundColor = '#4a90e2';
                day.style.color = 'white';
            } else {
                day.style.backgroundColor = '';
            }
        });
    }

    function isValidDate(date) {
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(date);
    }

    function validateDate() {
        const dateInput = document.getElementById('reservation-date').value;
        const regex = /^\d{4}-\d{2}-\d{2}$/;

        if (!regex.test(dateInput)) {
            document.getElementById('reservation-date').style.borderColor = 'red';
        } else {
            document.getElementById('reservation-date').style.borderColor = '';
            displayMenuForDate(dateInput);
        }
    }
});

/*fin JS pour cantine */