var CountdownTimer = {
    resetCountdown: function () {
        var countDownDate = new Date().getTime() + 90 * 60 * 1000;
        localStorage.setItem("countdownDate", countDownDate.toString());
        location.reload();
    },

    init: function (timerId) {
        var x = setInterval(function () {
            var now = new Date().getTime();
            var storedCountdownDate = localStorage.getItem("countdownDate");
            var countDownDate = storedCountdownDate
                ? parseInt(storedCountdownDate)
                : new Date().getTime() + 90 * 60 * 1000;

            var distance = countDownDate - now;
            var hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            var minutes = Math.floor(
                (distance % (1000 * 60 * 60)) / (1000 * 60)
            );
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            var timerElement = document.getElementById(timerId);
            if (timerElement) {
                timerElement.innerHTML =
                    hours + "h " + minutes + "m " + seconds + "s ";
            }

            if (distance < 0) {
                clearInterval(x);
                if (timerElement) {
                    timerElement.innerHTML = "EXPIRED";
                }
            }
        }, 1000);
    },
};

// Initialize countdown timer when the page loads
window.addEventListener("load", function () {
    CountdownTimer.init("countdownTimer1");
});

// Add event listener to reset button
document.getElementById("resetButton").addEventListener("click", function () {
    CountdownTimer.resetCountdown();
});
