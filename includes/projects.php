<div class="container part hideit" id="Projects">
    <br>
    <div class="mb-4">
        <h4>This is the Projects section:</h4>
        <p>Here you will enter all the projects you want to add in your CV.</p>
    </div>
    <form id="projForm" name="projForm" enctype="multipart/form-data">

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="mb-3">
                    <h4>Enter project name:</h4>
                    <input type="text" name="projectName" class="form-control projectInput" id="projectName" placeholder="Project name..." value="">
                </div>

                <div class="mb-3">
                    <h4>Tech stack used:</h4>
                    <span class="techStack"></span>
                    <input type="hidden" name="techStack" id="techStack">
                </div>

                <div class="mb-3">
                    <h4>Project Details:</h4>
                    <textarea name="projectDetails" id="projectDetails" rows="3" class="form-control" placeholder="Enter some details about your project..."></textarea>
                </div>

            </div>
            <div class="col-lg-4 d-none d-lg-block" style="height: 326.4px;">
                <img src="./assets/images/Project Stages-rafiki.png" alt="alt" class="img-fluid">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <h4>Project Link:</h4>
                    <input type="text" name="projectLink" class="form-control" placeholder="Enter project Link..." id="projectLink">
                    <!--or text change later-->
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <h4>Project image: </h4>
                    <input class="form-control hideFile" type="file" name="projectImages" id="projectImages" accept=".jpg, .png .jpeg .webp">
                    <div class="row">
                        <div class="col">
                            <label class="form-control" id="projImgLabel">jpeg, png, webp...</label>
                        </div>
                        <div class="col-6 px-0 justify-content-center">
                            <button type="button" class="btn btn-outline-primary" onclick="activeFile()">Choose Image </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row justify-content-center">
        <button type="button" class="btn btn-primary col-6 col-md-3" id="projectBtn">+ Add project</button>
    </div>
    <div class="mb-3 mt-4">
        <h4>Your projects:</h4>
        <div class="md-3">
            <div class="row justify-content-evenly" id="myProjects">

            </div>
        </div>
    </div>
</div>