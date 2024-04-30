// Add event listener to "Add Weighted Option" button
document
    .getElementById("addWeightedOptionBtn")
    .addEventListener("click", function () {
        var optionsContainer = document.getElementById(
            "weighted-optionsContainer"
        );
        if (!optionsContainer) {
            console.error("Weighted options container not found");
            return; // Exit function if weighted options container is not found
        }

        var optionIndex =
            optionsContainer.querySelectorAll(".weighted-input-group").length +
            1;

        var newInputGroup = document.createElement("div");
        newInputGroup.classList.add("input-group", "weighted-input-group");

        // Generate unique IDs for option elements
        var uniqueId = "weightedOptionImageInput_" + optionIndex;
        var previewId = "weightedImagePreview" + optionIndex; // Unique ID for image preview

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

        var imageSpan = document.createElement("span");
        imageSpan.classList.add("input-group-text", "btn", "btn-default");
        imageSpan.style.cursor = "pointer";

        var imageIcon = document.createElement("i");
        imageIcon.classList.add("fas", "fa-image");

        var imageInput = document.createElement("input");
        imageInput.setAttribute("type", "file");
        imageInput.setAttribute("accept", "image/*");
        imageInput.style.display = "none";
        imageInput.setAttribute("name", "choice_images[]");
        imageInput.id = uniqueId; // Assign unique ID to the image input field

        // Set onchange event for image input
        imageInput.addEventListener("change", function (event) {
            previewWeightedOptionImage(event, uniqueId, previewId); // Pass the unique IDs to the preview function
        });

        // Create unique id for image preview
        var imagePreview = document.createElement("div");
        imagePreview.classList.add("weightedOptionImagePreview", "m-1");
        imagePreview.setAttribute("id", previewId); // Assign unique ID to the image preview

        // Add a click event listener to the span
        imageSpan.addEventListener("click", function () {
            // Simulate a click on the file input when the span is clicked
            imageInput.click();
        });

        var trashSpan = document.createElement("span");
        trashSpan.classList.add("input-group-text", "btn-danger", "btn");
        trashSpan.style.cursor = "pointer";
        trashSpan.onclick = function () {
            optionsContainer.removeChild(newInputGroup);
            optionsContainer.removeChild(imagePreview); // Remove the corresponding image preview
        };

        var trashIcon = document.createElement("i");
        trashIcon.classList.add("fas", "fa-trash");

        imageSpan.appendChild(imageIcon);
        appendDiv.appendChild(imageSpan);
        appendDiv.appendChild(trashSpan); // Moved trash icon after the image icon
        trashSpan.appendChild(trashIcon);
        newInputGroup.appendChild(appendDiv);
        newInputGroup.appendChild(imageInput);

        optionsContainer.appendChild(newInputGroup);
        optionsContainer.appendChild(imagePreview); // Append the image preview right after the input group
    });

function removeWeightedOption(element) {
    var inputGroup = element.closest(".weighted-input-group");
    var imagePreview = inputGroup.nextElementSibling; // Change 'option' to 'inputGroup'
    inputGroup.parentNode.removeChild(inputGroup); // Remove the option
    if (
        imagePreview &&
        imagePreview.classList.contains("weightedOptionImagePreview")
    ) {
        imagePreview.parentNode.removeChild(imagePreview); // Remove the image preview if it exists
    }
}

// Function to preview an option image for weighted multiple choice modal
function previewWeightedOptionImage(event, inputId, previewId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const previewContainer = document.getElementById(previewId);
    const label = document.getElementById(inputId);

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels

        // Clear existing images from the preview container
        previewContainer.innerHTML = "";

        // Append the new image preview to the container
        previewContainer.appendChild(imgElement);
    };

    reader.readAsDataURL(file);

    // Update label with the name of the selected file
    if (label) {
        label.innerText = file.name;
    } else {
        console.error("Label element with ID '" + inputId + "' not found.");
    }
}

// Global variable to track the index for image previews

document.getElementById("addOptionBtn").addEventListener("click", function () {
    var optionsContainer = document.getElementById("optionsContainer");
    if (!optionsContainer) {
        console.error("Options container not found");
        return; // Exit function if options container is not found
    }

    // Find all existing option input fields
    var existingOptions = optionsContainer.querySelectorAll(
        "input[name='choices[]']"
    );

    // Find the highest index currently in use among existing options
    var highestIndex = 0;
    existingOptions.forEach(function (option) {
        var placeholderText = option.getAttribute("placeholder");
        var currentIndex = parseInt(placeholderText.split(" ")[1]);
        if (currentIndex > highestIndex) {
            highestIndex = currentIndex;
        }
    });

    // Increment the highest index to get the next index
    var nextIndex = highestIndex + 1;

    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group", "normal-input-group");

    // Generate unique IDs for option elements
    var uniqueId = "optionImageInput_" + nextIndex;
    var previewId = "imagePreview" + nextIndex; // Unique ID for image preview

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
    inputField.setAttribute("placeholder", "Option " + nextIndex); // Update placeholder with next index
    inputField.setAttribute("name", "choices[]");

    newInputGroup.appendChild(inputField);

    var appendDiv = document.createElement("div");
    appendDiv.classList.add("input-group-append");

    var imageSpan = document.createElement("span");
    imageSpan.classList.add("input-group-text", "btn", "btn-default");
    imageSpan.style.cursor = "pointer";

    var imageIcon = document.createElement("i");
    imageIcon.classList.add("fas", "fa-image");

    var imageInput = document.createElement("input");
    imageInput.setAttribute("type", "file");
    imageInput.setAttribute("accept", "image/*");
    imageInput.style.display = "none";
    imageInput.setAttribute("name", "choice_images[]");
    imageInput.id = uniqueId; // Assign unique ID to the image input field

    // Set onchange event for image input
    imageInput.addEventListener("change", function (event) {
        previewOptionImage(event, uniqueId, previewId); // Pass the unique IDs to the preview function
    });

    // Create unique id for image preview
    var imagePreview = document.createElement("div");
    imagePreview.classList.add("optionImagePreview", "mb-1");
    imagePreview.setAttribute("id", previewId); // Assign unique ID to the image preview

    // Add a click event listener to the span
    imageSpan.addEventListener("click", function () {
        // Simulate a click on the file input when the span is clicked
        imageInput.click();
    });

    var trashSpan = document.createElement("span");
    trashSpan.classList.add("input-group-text", "btn-danger", "btn");
    trashSpan.style.cursor = "pointer";
    trashSpan.addEventListener("click", function () {
        removeOption(this);
    });

    var trashIcon = document.createElement("i");
    trashIcon.classList.add("fas", "fa-trash");

    imageSpan.appendChild(imageIcon);
    appendDiv.appendChild(imageSpan);
    trashSpan.appendChild(trashIcon);
    appendDiv.appendChild(trashSpan);
    newInputGroup.appendChild(appendDiv);
    newInputGroup.appendChild(imageInput);

    // Append the new input group and image preview together to the options container
    optionsContainer.appendChild(newInputGroup);
    optionsContainer.appendChild(imagePreview);
});

function removeOption(element) {
    var option = element.closest(".input-group");
    var imagePreview = option.nextElementSibling; // Get the next sibling which is the image preview
    option.parentNode.removeChild(option); // Remove the option
    if (imagePreview && imagePreview.classList.contains("optionImagePreview")) {
        imagePreview.parentNode.removeChild(imagePreview); // Remove the image preview if it exists
    }
}

// Function to mark the correct answer when checkbox is clicked
document
    .querySelectorAll('input[type="checkbox"]')
    .forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            var isChecked = this.checked;
            var inputField =
                this.parentNode.parentNode.nextElementSibling.querySelector(
                    'input[type="text"]'
                );
            inputField.dataset.correct = isChecked ? "1" : "0";
        });
    });

document.addEventListener("DOMContentLoaded", function () {
    var questionForm = document.getElementById("questionForm");
    if (questionForm) {
        questionForm.addEventListener("submit", function () {
            var inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(function (input) {
                var checkbox = input.previousElementSibling.querySelector(
                    'input[type="checkbox"]'
                );
                if (checkbox && checkbox.checked) {
                    // Set the value as integer 1 for correct answer
                    input.setAttribute("data-correct", "1");
                } else {
                    // Set the value as integer 0 for incorrect answer
                    input.setAttribute("data-correct", "0");
                }
            });
        });
    } else {
        console.error("Form with ID 'questionForm' not found");
    }
});

// Function to set the question number based on the last question number
function setQuestionNumber() {
    var lastQuestionNumber = "{{ $lastQuestionNumber }}";
    var questionNumberInput = document.getElementById("question_number");

    if (lastQuestionNumber != "") {
        // If lastQuestionNumber exists, increment it by one
        var nextQuestionNumber = parseInt(lastQuestionNumber) + 1;
        questionNumberInput.value = nextQuestionNumber;
    } else {
        // If it's the first question, set the question number to 1
        questionNumberInput.value = 1;
    }
}

// Function to close the question modal
function closeQuestionModal() {
    var modal = document.getElementById("add-question");
    var modalBackdrop = document.querySelector(".modal-backdrop");
    modalBackdrop.parentNode.removeChild(modalBackdrop);
    modal.classList.remove("show");
    modal.style.display = "none";
}

// Function to preview an image
function previewImage(event, type, labelId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const label = document.getElementById(labelId);

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels

        if (type === "question") {
            document.getElementById("questionImagePreview").innerHTML = "";
            document
                .getElementById("questionImagePreview")
                .appendChild(imgElement);
        } else {
            // For options
            // Assuming you have multiple previews for multiple options
            const previewContainer = document.getElementById("imagePreview");
            previewContainer.appendChild(imgElement);
        }
    };

    reader.readAsDataURL(file);

    // Update label with the name of the selected file
    label.innerText = file.name;
}

// Function to preview an image for the essay modal
function previewEssayImage(event, labelId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const label = document.getElementById(labelId);
    const previewContainer = document.getElementById("essayImagePreview");

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels

        // Clear existing images from the preview container
        previewContainer.innerHTML = "";

        // Append the new image preview to the container
        previewContainer.appendChild(imgElement);
    };

    reader.readAsDataURL(file);

    // Update label with the name of the selected file
    label.innerText = file.name;
}

function previewQuizImage(event, labelId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const label = document.getElementById(labelId);
    const previewContainer = document.getElementById("quizImagePreview");

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels

        // Clear existing images from the preview container
        previewContainer.innerHTML = "";

        // Append the new image preview to the container
        previewContainer.appendChild(imgElement);
    };

    reader.readAsDataURL(file);

    // Update label with the name of the selected file
    label.innerText = file.name;
}

function editPreviewQuizImage(event, labelId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const label = document.getElementById(labelId);
    const previewContainer = document.getElementById("editQuizImagePreview");

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels

        // Clear existing images from the preview container
        previewContainer.innerHTML = "";

        // Append the new image preview to the container
        previewContainer.appendChild(imgElement);
    };

    reader.readAsDataURL(file);

    // Update label with the name of the selected file
    label.innerText = file.name;
}

// Function to trigger the click event on option image input
function uploadOptionImage(element) {
    // Find the input element within the same group
    var imageInput =
        element.parentElement.parentElement.getElementsByClassName(
            "optionImageInput"
        )[0];
    imageInput.click();
}

function uploadWeightedOptionImage(element) {
    var imageInput = element.parentElement.parentElement.getElementsByClassName(
        "weightedOptionImageInput"
    )[0];
    imageInput.click();
}

// Function to preview an option image
// Function to preview an option image
function previewOptionImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const previewContainer = event.target.parentElement.nextElementSibling; // Get the image preview container

    // Clear existing images from the preview container
    previewContainer.innerHTML = "";

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels
        // Append the new image preview to the container
        previewContainer.appendChild(imgElement);
    };

    reader.readAsDataURL(file);
}

// Function to preview an image for the weighted multiple choice modal
function previewWeightedEssayImage(event, labelId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const label = document.getElementById(labelId);
    const previewContainer = document.getElementById(
        "weighted-essayImagePreview"
    );

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels

        // Clear existing images from the preview container
        previewContainer.innerHTML = "";

        // Append the new image preview to the container
        previewContainer.appendChild(imgElement);
    };

    reader.readAsDataURL(file);

    // Update label with the name of the selected file
    label.innerText = file.name;
}

// Define the function to set current date
function setCurrentDate(inputId) {
    var now = new Date();
    // Extract the date part (YYYY-MM-DD)
    var currentDate = now.toISOString().slice(0, 10);
    // Set the value of the input field with the specified ID to the current date
    document.getElementById(inputId).value = currentDate;
}

// Call the function after the DOM has loaded
document.addEventListener("DOMContentLoaded", function () {
    setCurrentDate("local-date");
});
