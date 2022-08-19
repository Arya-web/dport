<div class="container part hideit" id="Skills">
    <br>
    <div class="mb-4">
        <h4>This is the Skills section:</h4>
        <p>Here you will enter all the skills you want to add in your CV.</p>
    </div>
    
    <div class="input-group mb-3">
        <input type="text" name="skills" placeholder="Add skill...." class="form-control" id="skillInput" style="height: 50px;">
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text col-12 col-md-2 justify-content-center">Set Proficiency:</span>

        <input type="range" name="skillProgress" class="form-control form-range" min="0" max="100" step="10" id="skillProgress" value="0">

        <button class="btn btn-primary" type="button" id="skillsBtn" style="margin: 0 5px;">+ Add</button>
    </div>

    <div class="mb-3">
        <h4>Your Skills:</h4>
        <div id="yourSkills">

        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-lg-2 d-none d-lg-block">
            <img src="./assets/images/Profiling-amico.png" alt="alt" class="img-fluid">
        </div>
    </div>

</div>