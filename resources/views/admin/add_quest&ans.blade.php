@extends('layouts.admin')
@section('container')
<!-- Main content -->
<section class="content">
  <div class="row justify-content-center align-items-center" style="height:100%;">
    <div class="col-md-6 m-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Add Questions & Options</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="inputName">Question</label>
            <textarea id="inputDescription" class="form-control" rows="4"></textarea>
          </div>
          <div id="optionsContainer" class="form-group">
            <textarea class="form-control option" style="margin-bottom:10px;" rows="1" placeholder="Option 1"></textarea>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-success" id="addOptionBtn">Add Option</button>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("addOptionBtn").addEventListener("click", function () {
        // Clone the first textarea element
        const optionsContainer = document.getElementById("optionsContainer");
        const optionCount = optionsContainer.querySelectorAll(".option").length + 1;
        const newOption = document.querySelector('.option').cloneNode(true);

        // Update placeholder and id attributes
        newOption.placeholder = "Option " + optionCount;
        newOption.id = "inputOption" + optionCount;

        // Append the cloned textarea to the options container
        optionsContainer.appendChild(newOption);
    });
});
  </script>

</section>
@endsection