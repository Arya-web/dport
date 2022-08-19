<div class="container part hideit" id="Blogs">
    <br>
    <div class="mb-4">
        <h4>This is the Blogs section:</h4>
        <p>Here you will enter all the blogs if you have any.</p>
    </div>

    <form id="blogForm" name="blogForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="mb-3">
                    <h4>Enter blog topic:</h4>
                    <input type="text" name="blogTopic" class="form-control" id="blogTopic" placeholder="Enter here...">
                </div>

                <div class="mb-3">
                    <h4>Type of blog:</h4>
                    <span class="blogTy"></span>
                    <input type="hidden" name="blogType" id="blogType">
                </div>

                <div class="mb-3">
                    <h4>Blog Details:</h4>
                    <textarea name="blogDetails" id="blogDetails" rows="3" class="form-control" placeholder="Enter some details about your blog..."></textarea>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block" style="height: 326.4px;">
                <img src="./assets/images/Blogging-amico.png" alt="alt" class="img-fluid">
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <h4>Blog Link:</h4>
                    <input type="text" name="blogLink" class="form-control" placeholder="Enter blog Link..." id="blogLink">
                    <!--or text change later-->
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <h4>Blog image: </h4>
                    <input class="form-control hideFile" type="file" name="blogImages" id="blogImages" accept=".jpg, .png .jpeg .webp">
                    <div class="row">
                        <div class="col">
                            <label class="form-control" id="blogImgLabel">jpeg, png, webp...</label>
                        </div>
                        <div class="col-6 px-0 justify-content-center">
                            <button type="button" class="btn btn-outline-primary" onclick="activeBlogFile()">Choose Image </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row justify-content-center">
        <button type="button" class="btn btn-primary col-6 col-md-3" id="blogBtn">+ Add blog</button>
    </div>

    <div class="mb-3 mt-4">
        <h4>Your blogs:</h4>
        <div class="md-3">
            <div class="row justify-content-evenly" id="myBlogs">

            </div>
        </div>
    </div>
</div>