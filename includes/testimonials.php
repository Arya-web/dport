<div class="container part hideit" id="Testimonials">
    <br>
    <div class="mb-4">
        <h4>This is the Testimonials section:</h4>
        <p>Here you can all your testimonials.</p>
    </div>
    <form id="tesForm" name="tesForm" enctype="multipart/form-data">
        <div class="mb-3">
            <h4>Enter person name:</h4>
            <input type="text" name="tesName" class="form-control" id="tesName" placeholder="Person's name..." value="">
        </div>

        <div class="mb-3">
            <h4>Testimonial:</h4>
            <textarea name="tesDetails" id="tesDetails" rows="3" class="form-control" placeholder="Enter your testimonial here..."></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <h4>Person Credentials:</h4>
                    <input type="text" name="tesCred" id="tesCred" class="form-control" placeholder="Person's credibility..">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <h4>Person image: </h4>
                    <input class="form-control hideFile" type="file" name="tesImages" id="tesImages" accept=".jpg, .png .jpeg .webp">
                    <div class="row">
                        <div class="col">
                            <label class="form-control" id="tesImgLabel">jpeg, png, webp...</label>
                        </div>
                        <div class="col-6 px-0 justify-content-center">
                            <button type="button" class="btn btn-outline-primary" onclick="activeTesFile()">Choose Image </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row justify-content-center">
        <button type="button" class="btn btn-primary col-6 col-md-3" id="tesBtn">+ Add testimonial</button>
    </div>
    <div class="mb-3 mt-4">
        <h4>Your testimonials:</h4>
        <div class="md-3">
            <div class="row justify-content-evenly" id="myTes">
                
            </div>
        </div>
    </div>

</div>