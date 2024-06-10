function addWeightedOption() {
    // Get the options container
    var optionsContainer = document.getElementById("weighted-optionsContainer");

    // Count the number of existing options
    var optionCount =
        optionsContainer.getElementsByClassName("input-group").length + 1;

    // Create a new option div
    var newOptionDiv = document.createElement("div");
    newOptionDiv.className = "input-group weighted-input-group";

    // Create the HTML for the new option
    var newOptionHTML = `
    <input type="text" class="form-control" placeholder="Option ${optionCount}" name="choices[]">
    <input type="number" min="0" class="form-control" placeholder="Points" name="point_value[]">
    <div class="input-group-append">
        <span class="input-group-text btn btn-default" style="cursor: pointer;" onclick="uploadWeightedOptionImage(this)">
            <i class="fas fa-image"></i>
        </span>
        <span class="input-group-text btn-danger btn" style="cursor: pointer;" onclick="removeWeightedOption(this)">
            <i class="fas fa-trash"></i>
        </span>
    </div>
    <input type="file" accept="image/*" style="display: none;" onchange="previewWeightedOptionImage(event, 'imageLabel${optionCount}', 'weightedImagePreview${optionCount}')"
        class="weightedOptionImageInput" name="choice_images[]">
    `;

    // Set the HTML for the new option div
    newOptionDiv.innerHTML = newOptionHTML;

    // Append the new option to the options container
    optionsContainer.appendChild(newOptionDiv);

    // Create a new div for image preview
    var imagePreview = document.createElement("div");
    imagePreview.classList.add("weightedOptionImagePreview");
    imagePreview.setAttribute("id", "weightedImagePreview" + optionCount);

    // Append the image preview div to the options container
    optionsContainer.appendChild(imagePreview);
}

function removeWeightedOption(element) {
    var optionGroup = element.parentElement.parentElement;
    var imagePreview = optionGroup.nextElementSibling;
    optionGroup.remove();
    imagePreview.remove();
}

function editWeightedOption() {
    var optionsContainer = document.getElementById(
        "editWeighted-optionsContainer"
    );
    var optionCount =
        optionsContainer.getElementsByClassName("input-group").length;

    var newOptionDiv = document.createElement("div");
    newOptionDiv.className = "input-group weighted-input-group mb-2";

    var newOptionHTML = `
        <input type="text" class="form-control" placeholder="Option ${
            optionCount + 1
        }" name="choices[${optionCount}]">
        <input type="number" min="0" class="form-control" placeholder="Points" name="point_value[${optionCount}]">
        <div class="input-group-append">
            <span class="input-group-text btn btn-default" style="cursor: pointer;" onclick="uploadWeightedOptionImage(this)">
                <i class="fas fa-image"></i>
            </span>
            <span class="input-group-text btn-danger btn" style="cursor: pointer;" onclick="removeWeightedOption(this)">
                <i class="fas fa-trash"></i>
            </span>
        </div>
        <input type="file" accept="image/*" style="display: none;" class="weightedOptionImageInput" name="choice_images[${optionCount}]" onchange="previewWeightedOptionImage(event, 'imageLabel${optionCount}', 'weightedImagePreview${optionCount}')">
    `;

    newOptionDiv.innerHTML = newOptionHTML;
    optionsContainer.appendChild(newOptionDiv);

    var imagePreview = document.createElement("div");
    imagePreview.classList.add("weightedOptionImagePreview", "mb-2");
    imagePreview.setAttribute("id", "weightedImagePreview" + optionCount);
    optionsContainer.appendChild(imagePreview);
}

function previewWeightedOptionImage(event, labelId, previewId) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(previewId);
        output.innerHTML = `<img src="${reader.result}" style="max-width: 300px;" class="mb-2">`;
    };
    reader.readAsDataURL(event.target.files[0]);

    // Update the label text
    var label = document.getElementById(labelId);
    label.textContent = event.target.files[0].name;
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

function updatedIsCorrectValue(checkbox, index) {
    const isCorrectInput = document.getElementById(`isCorrect${index}`);
    isCorrectInput.value = checkbox.checked ? '1' : '0';
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

// Function to preview an image
function editPreviewImage(event, type, labelId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const label = document.getElementById(labelId);

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.width = "200px"; // Set width to 200 pixels

        if (type === "question") {
            document.getElementById("questionEditImagePreview").innerHTML = "";
            document
                .getElementById("questionEditImagePreview")
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
        imgElement.style.maxWidth = "200px"; // Set max width to 300 pixels

        // Clear existing images from the preview container
        previewContainer.innerHTML = "";

        // Append the new image preview to the container
        previewContainer.appendChild(imgElement);
    };

    reader.readAsDataURL(file);

    // Update label with the name of the selected file
    label.innerText = file.name;
}

// Function to preview an image for the edit essay modal
function previewEditEssayImage(event, labelId, previewContainerId) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const label = document.getElementById(labelId);
    const previewContainer = document.getElementById(previewContainerId);

    reader.onload = function () {
        const imgElement = document.createElement("img");
        imgElement.src = reader.result;
        imgElement.classList.add("img-thumbnail", "mb-1");
        imgElement.style.maxWidth = "200px"; // Set max width to 300 pixels

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
    var fileInput = element.parentElement.parentElement.querySelector(
        ".weightedOptionImageInput"
    );
    fileInput.click();
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

function previewWeightedEssayImage(event, labelId) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById("weighted-essayImagePreview");
        output.innerHTML = `<img src="${reader.result}" style="max-width: 300px;" class="mb-2">`;
    };
    reader.readAsDataURL(event.target.files[0]);

    // Update the label text
    var label = document.getElementById(labelId);
    label.textContent = event.target.files[0].name;
}

function previewEditWeightedEssayImage(event, labelId, previewId) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(previewId);
        output.innerHTML = `<img src="${reader.result}" style="max-width: 300px;" class="mb-2">`;
    };
    reader.readAsDataURL(event.target.files[0]);

    // Update the label text
    var label = document.getElementById(labelId);
    label.textContent = event.target.files[0].name;
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
