<div class="container part" id="User">
    <br>
    <div class="mb-4">
        <h4>This is the Users section:</h4>
        <p>Here you can add your personal details.</p>
    </div>

    <form id="userForm" name="userForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-lg-7">
                <div class="mb-3">
                    <h4>Enter our name: </h4>
                    <input type="text" name="name" class="form-control" placeholder="Name..." id="userName">
                </div>

                <div class="mb-3">
                    <h4>What do you define yourself as:</h4>
                    <span class="dropdown"></span>
                    <input type="hidden" name="skills" id="skills">
                </div>

                <div class="mb-3">
                    <h4>About me:</h4>
                    <div class="mb-3">
                        <div class="form-group">
                            <textarea name="about" rows="5" placeholder="Enter something about you..." class="form-control" id="aboutUser"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col d-flex justify-content-center align-items-center">
                        <div>
                            <p class="m-0 text-center mb-1">User Image..</p>
                            <input class="form-control hideFile" type="file" name="userImages" id="userImages" accept=".jpg, .png .jpeg .webp" onchange="userImgChange(this)">
                            <button type="button" id="userImgBtn" class="btn btn-outline-primary" onclick="activeUser()">Select User Img</button>
                        </div>
                    </div>
                    <div class="col"><img src="./assets/images/images.png" alt="demo img" width="134px" class="img-fluid" id="userImg"></div>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block">
                <img src="./assets/images/Bookmarks-bro.png" alt="alt" class="img-fluid">
            </div>

        </div>
    </form>

    <div class="text-center">
        <button type="button" class="btn btn-primary" id="userBtn">Update user details...</button>
    </div>
</div>