// Add event listener to "Add Weighted Option" button
document.getElementById("addWeightedOptionBtn").addEventListener("click", function () {
    var optionsContainer = document.getElementById("weighted-optionsContainer");
    var optionIndex = optionsContainer.querySelectorAll(".weighted-input-group").length + 1;

    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group", "weighted-input-group");

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
        optionsContainer.removeChild(newInputGroup);
    };

    var trashIcon = document.createElement("i");
    trashIcon.classList.add("fas", "fa-trash");

    trashSpan.appendChild(trashIcon);
    appendDiv.appendChild(trashSpan);
    newInputGroup.appendChild(appendDiv);

    optionsContainer.appendChild(newInputGroup);
});
// Function to remove option
function removeOption(element) {
    var inputGroup = element.closest(".input-group");
    inputGroup.remove();
}

function removeWeightedOption(element) {
    var inputGroup = element.closest(".weighted-input-group");
    inputGroup.remove();
}

document.getElementById("addOptionBtn").addEventListener("click", function () {
    var optionsContainer = document.getElementById("optionsContainer");
    var optionIndex = optionsContainer.querySelectorAll(".input-group").length + 1;

    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group");

    var prependDiv = document.createElement("div");
    prependDiv.classList.add("input-group-prepend");

    var checkboxSpan = document.createElement("span");
    checkboxSpan.classList.add("input-group-text");

    var checkbox = document.createElement("input");
    checkbox.setAttribute("type", "checkbox");
    checkbox.setAttribute("name", "is_correct[]");

    checkboxSpan.appendChild(checkbox);
    prependDiv.appendChild(checkboxSpan);
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
        removeOption(this);
    };

    var trashIcon = document.createElement("i");
    trashIcon.classList.add("fas", "fa-trash");

    trashSpan.appendChild(trashIcon);
    appendDiv.appendChild(trashSpan);
    newInputGroup.appendChild(appendDiv);

    optionsContainer.appendChild(newInputGroup);
});

function removeOption(element) {
    var option = element.closest(".input-group");
    option.parentNode.removeChild(option);
}

// Function to mark the correct answer when checkbox is clicked
document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var isChecked = this.checked;
        var inputField = this.parentNode.parentNode.nextElementSibling.querySelector('input[type="text"]');
        inputField.dataset.correct = isChecked ? '1' : '0';
    });
});

// Update the correct answer status in the hidden input
document.getElementById('questionForm').addEventListener('submit', function() {
    var inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach(function(input) {
        var checkbox = input.previousElementSibling.querySelector('input[type="checkbox"]');
        if (checkbox.checked) {
            // Set the value as integer 1 for correct answer
            input.setAttribute('data-correct', '1');
        } else {
            // Set the value as integer 0 for incorrect answer
            input.setAttribute('data-correct', '0');
        }
    });
});

