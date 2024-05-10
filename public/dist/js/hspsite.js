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

function addOption() {
    // Get the options container
    var optionsContainer = document.getElementById("optionsContainer");

    // Count the number of existing options
    var optionCount =
        optionsContainer.getElementsByClassName("input-group").length;

    // Create a new option div
    var newOptionDiv = document.createElement("div");
    newOptionDiv.className = "input-group";

    // Create the HTML for the new option
    var newOptionHTML = `
        <input type="hidden" name="is_correct[]" value="0"> <!-- Default value is 0 -->
        <div class="input-group-prepend">
            <span class="input-group-text">
                <input type="checkbox" name="is_correct_checkbox[]" onchange="updateIsCorrectValue(this)">
            </span>
        </div>
        <input type="text" class="form-control" placeholder="Option ${
            optionCount + 1
        }" name="choices[]">
        <div class="input-group-append">
            <span class="input-group-text btn btn-default" style="cursor: pointer" onclick="uploadOptionImage(this)">
                <i class="fas fa-image"></i>
            </span>
            <span class="input-group-text btn btn-danger" style="cursor: pointer" onclick="removeOption(this)">
                <i class="fas fa-trash"></i>
            </span>
        </div>
        <input type="file" accept="image/*" style="display: none" onchange="previewOptionImage(event, 'imagePreview${
            optionCount + 1
        }')" class="optionImageInput" name="choice_images[]">
    `;

    // Set the HTML for the new option div
    newOptionDiv.innerHTML = newOptionHTML;

    var imagePreview = document.createElement("div");
    imagePreview.classList.add("optionImagePreview");
    imagePreview.setAttribute("id", "imagePreview".optionCount + 1);

    // Append the new option to the options container
    optionsContainer.appendChild(newOptionDiv);
    optionsContainer.appendChild(imagePreview);
}

function editAddOption(questionId) {
    // Get the options container
    var optionsContainer = document.getElementById(
        "editOptionsContainer" + questionId
    );

    // Count the number of existing options
    var optionCount =
        optionsContainer.getElementsByClassName("input-group").length;

    // Create a new option div
    var newOptionDiv = document.createElement("div");
    newOptionDiv.className = "input-group";

    // Create the HTML for the new option
    var newOptionHTML = `
        <input type="hidden" name="is_correct[]" value="0">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <input type="checkbox" name="is_correct_checkbox[]" onchange="updateIsCorrectValue(this)">
            </span>
        </div>
        <input type="text" class="form-control" placeholder="Option ${
            optionCount + 1
        }" name="choices[]">
        <div class="input-group-append">
            <span class="input-group-text btn btn-default" style="cursor: pointer" onclick="uploadOptionImage(this)">
                <i class="fas fa-image"></i>
            </span>
            <span class="input-group-text btn btn-danger" style="cursor: pointer" onclick="removeOption(this)">
                <i class="fas fa-trash"></i>
            </span>
        </div>
        <input type="file" accept="image/*" style="display: none" onchange="previewOptionImage(event, 'imagePreview${
            optionCount + 1
        }')" class="optionImageInput" name="choice_images[]">
    `;

    // Set the HTML for the new option div
    newOptionDiv.innerHTML = newOptionHTML;

    // Create a new image preview div
    var imagePreview = document.createElement("div");
    imagePreview.classList.add("optionImagePreview");
    imagePreview.setAttribute("id", "imagePreview" + (optionCount + 1));

    // Append the new option and image preview to the options container
    optionsContainer.appendChild(newOptionDiv);
    optionsContainer.appendChild(imagePreview);
}

function updateIsCorrectValue(checkbox) {
    // Get the corresponding hidden input
    var hiddenInput = checkbox.parentNode.parentNode.parentNode.querySelector(
        'input[name="is_correct[]"]'
    );

    // Update the value based on checkbox state
    hiddenInput.value = checkbox.checked ? "1" : "0";
}

// JavaScript function to update the hidden input value when checkbox is clicked
function createIsCorrectValue(checkbox) {
    // Get the parent input group
    var inputGroup = checkbox.closest(".input-group");
    // Find the hidden input field
    var hiddenInput = inputGroup.find('input[type="hidden"]');

    // If checkbox is checked, set hidden input value to 1, otherwise set it to 0
    hiddenInput.val(checkbox.checked ? "1" : "0");
}

function removeOption(element) {
    var option = element.closest(".input-group");
    var imagePreview = option.nextElementSibling; // Get the next sibling which is the image preview
    option.parentNode.removeChild(option); // Remove the option
    if (imagePreview && imagePreview.classList.contains("optionImagePreview")) {
        imagePreview.parentNode.removeChild(imagePreview); // Remove the image preview if it exists
    }
}

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
