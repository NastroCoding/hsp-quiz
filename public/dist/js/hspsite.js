// Function to remove option
function removeOption(element) {
    var inputGroup = element.closest(".input-group");
    inputGroup.remove();
}

function removeWeightedOption(element) {
    var inputGroup = element.closest(".weighted-input-group");
    inputGroup.remove();
}

// Add event listener to "Add Option" button
document.getElementById("addOptionBtn").addEventListener("click", function () {
    var optionsContainer = document.getElementById("optionsContainer");
    var optionIndex =
        optionsContainer.querySelectorAll(".input-group").length + 1;

    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group");

    var prependDiv = document.createElement("div");
    prependDiv.classList.add("input-group-prepend");

    var radioSpan = document.createElement("span");
    radioSpan.classList.add("input-group-text");

    var radioButton = document.createElement("input");
    radioButton.setAttribute("type", "radio");
    radioButton.setAttribute("name", "is_right");

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
    trashSpan.classList.add("input-group-text", "btn-danger", "btn");
    trashSpan.style.cursor = "pointer";
    trashSpan.onclick = function () {
        removeOption(this); // Pass 'this' instead of 'trashSpan' to reference the clicked element
    };

    var trashIcon = document.createElement("i");
    trashIcon.classList.add("fas", "fa-trash");

    trashSpan.appendChild(trashIcon);
    appendDiv.appendChild(trashSpan);
    newInputGroup.appendChild(appendDiv);

    optionsContainer.appendChild(newInputGroup);
});



// Add event listener to "Add Weighted Option" button
document.getElementById("addWeightedOptionBtn").addEventListener("click", function () {
    var optionsContainer = document.getElementById("weighted-optionsContainer");
    var optionIndex = optionsContainer.querySelectorAll(".weighted-input-group").length + 1;

    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group", "weighted-input-group");

    var prependDiv = document.createElement("div");
    prependDiv.classList.add("input-group-prepend");

    var radioSpan = document.createElement("span");
    radioSpan.classList.add("input-group-text");

    var radioButton = document.createElement("input");
    radioButton.setAttribute("type", "radio");
    radioButton.setAttribute("name", "is_correct");

    radioSpan.appendChild(radioButton);
    prependDiv.appendChild(radioSpan);
    newInputGroup.appendChild(prependDiv);

    var inputField = document.createElement("input");
    inputField.setAttribute("type", "text");
    inputField.classList.add("form-control");
    inputField.setAttribute("placeholder", "Option " + optionIndex);
    inputField.setAttribute("name", "choices[]");

    newInputGroup.appendChild(inputField);

    var pointInput = document.createElement("input");
    pointInput.setAttribute("type", "number");
    pointInput.setAttribute("min", "0");
    pointInput.classList.add("form-control");
    pointInput.setAttribute("placeholder", "Points");
    pointInput.setAttribute("name", "point_value[]");

    newInputGroup.appendChild(pointInput);

    var appendDiv = document.createElement("div");
    appendDiv.classList.add("input-group-append");

    var trashSpan = document.createElement("span");
    trashSpan.classList.add("input-group-text", "btn-danger", "btn");
    trashSpan.style.cursor = "pointer";
    trashSpan.onclick = function () {
        removeWeightedOption(this); // Pass 'this' instead of 'trashSpan' to reference the clicked element
    };

    var trashIcon = document.createElement("i");
    trashIcon.classList.add("fas", "fa-trash");

    trashSpan.appendChild(trashIcon);
    appendDiv.appendChild(trashSpan);
    newInputGroup.appendChild(appendDiv);

    optionsContainer.appendChild(newInputGroup);
});
