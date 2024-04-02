
// Function to remove option
function removeOption(element) {
    var inputGroup = element.closest(".input-group");
    inputGroup.remove();
}

// Add event listener to "Add Option" button
document.getElementById("addOptionBtn").addEventListener("click", function () {
    var optionsContainer = document.getElementById("optionsContainer");
    var optionIndex = optionsContainer.querySelectorAll(".input-group").length + 1;

    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group");

    var prependDiv = document.createElement("div");
    prependDiv.classList.add("input-group-prepend");

    var radioSpan = document.createElement("span");
    radioSpan.classList.add("input-group-text");

    var radioButton = document.createElement("input");
    radioButton.setAttribute("type", "radio");
    radioButton.setAttribute("name", "option");

    radioSpan.appendChild(radioButton);
    prependDiv.appendChild(radioSpan);
    newInputGroup.appendChild(prependDiv);

    var inputField = document.createElement("input");
    inputField.setAttribute("type", "text");
    inputField.classList.add("form-control");
    inputField.setAttribute("placeholder", "Option " + optionIndex);
    inputField.setAttribute("name", "choices[]");

    newInputGroup.appendChild(inputField);

    var appendDiv = document.createElement("div");
    appendDiv.classList.add("input-group-append");

    var trashSpan = document.createElement("span");
    trashSpan.classList.add("input-group-text");
    trashSpan.style.backgroundColor = "red";
    trashSpan.style.cursor = "pointer";
    trashSpan.onclick = function () {
        removeOption(this); // Pass 'this' instead of 'trashSpan' to reference the clicked element
    };

    var trashIcon = document.createElement("i");
    trashIcon.classList.add("fas");
    trashIcon.classList.add("fa-trash");
    trashIcon.style.color = "white";

    trashSpan.appendChild(trashIcon);
    appendDiv.appendChild(trashSpan);
    newInputGroup.appendChild(appendDiv);

    optionsContainer.appendChild(newInputGroup);
});

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
document.getElementById("resetButton").addEventListener("click", function () {
    CountdownTimer.resetCountdown();
});
