// adds option and delete
function removeOption(element) {
    var inputGroup = element.closest(".input-group");
    inputGroup.remove();
}

document.getElementById("addOptionBtn").addEventListener("click", function () {
    var optionsContainer = document.getElementById("optionsContainer");
    var optionIndex =
        optionsContainer.querySelectorAll("input[type='radio']").length + 1;

    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group");

    var prependDiv = document.createElement("div");
    prependDiv.classList.add("input-group-prepend");

    var radioSpan = document.createElement("span");
    radioSpan.classList.add("input-group-text");

    var radioButton = document.createElement("input");
    radioButton.setAttribute("type", "radio");
    radioButton.setAttribute("name", "option"); // Set the name attribute

    radioSpan.appendChild(radioButton);
    prependDiv.appendChild(radioSpan);
    newInputGroup.appendChild(prependDiv);

    var inputField = document.createElement("input");
    inputField.setAttribute("type", "text");
    inputField.classList.add("form-control");
    inputField.setAttribute("placeholder", "Option " + optionIndex);

    newInputGroup.appendChild(inputField);

    var appendDiv = document.createElement("div");
    appendDiv.classList.add("input-group-append");

    var trashSpan = document.createElement("span");
    trashSpan.classList.add("input-group-text");
    trashSpan.style.backgroundColor = "red";
    trashSpan.style.cursor = "pointer";
    trashSpan.onclick = function () {
        removeOption(trashSpan);
    };

    var trashIcon = document.createElement("i");
    trashIcon.classList.add("fas");
    trashIcon.classList.add("fa-trash");
    trashIcon.style.color = "white"; // Set the color of the trashcan icon to white

    trashSpan.appendChild(trashIcon);
    appendDiv.appendChild(trashSpan);
    newInputGroup.appendChild(appendDiv);

    optionsContainer.appendChild(newInputGroup);
});

