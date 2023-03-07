<!DOCTYPE html>
<html>

<head>
    <title>File upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #video_preview,
        video {
            max-width: 500px !important;
            max-height: 600px !important;
        }

        .hide {
            display: none;
        }

        .bar {
            background-color: #00ff00;

        }

        .percent {
            position: absolute;
            left: 50%;
            color: black
        }
    </style>

</head>

<body>
    <div class="container m-5">
        <div class="panel panel-primary">
            {{-- <img src="{{'https://festiv-films.s3.us-east-2.amazonaws.com/images/7qSEGWkgBzrPR5wyQmZKZzWRH6BP4H0ReGnIVuYl.jpg'}}"
                width="709px"
                height="709px"
                >  --}}
            {{-- <video id="my_video2" controls
                src="https://festiv-films.s3.us-east-2.amazonaws.com/images/m7dCPNSOFlSu6GQQCpI7bsLYJ44BP4Jwypxb11ZZ.mov">
                  Your browser does not support the video tag.
                </video> --}}

            <div class="panel-body">



                @if ($path = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                        <strong>Upload successful</strong>
                    </div>
                    {{-- <img src="{{ Session::get('image') }}">  --}}
                    <video id="my_video3" controls
                        src="https://festiv-films.s3.us-east-2.amazonaws.com/{{ $path }}">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="panel-heading">
                        <h2>Video upload </h2>
                    </div>
                    
                    <br/>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form method="post" enctype="multipart/form-data" action="/upload">
                        @csrf
                        <div class="col">
                            {{-- <div id='video_preview' class='hide' class="col-md-6">
                                <strong> Preview </strong>
                                <video id="my_video" controls>
                                    Your browser does not support the video tag.
                                </video>
                            </div> --}}

                            
                            <div class="row">
                                <div class="col-md-6">
                                    <input id="video_file" type="file" name="video_file"  accept="video/*"
                                        class="form-control" onChange="onFileInputHandler()">
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger" onClick="reset()">Reset</button>
                                </div>
                            </div>

                            <br />
                            <br />
                            <div class="mb-3 progress">
                                <div class="bar progress-bar"></div>
                                <div class="percent">0%</div>
                            </div>

                            <div class="col-md-6 mt-5">
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </div>
                    </form>
                @endif





            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- <script>
    $(document).ready(function() {
        var bar = $('.bar');
        var percent = $('.percent');

        // $('form').submit(function(e) {
        //     if ($('#video_file').get(0).files.length === 0) {
        //         // e.preventDefault();
        //         console.log("No files selected.");
        //         return false;
        //     }
        // });

        $('form').ajaxForm({
            beforeSend: function() {

                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);


            },
            uploadProgress: function(event, position, total, percentComplete) {
                // console.log('Position', position);
                // console.log('Total', total);
                var percentVal = '0%'
                if ($('#video_file').get(0).files.length > 0)
                    percentVal = (Math.floor(position / total) * 100) + '%';
                bar.width(percentval);
                percent.html(percentVal);
            },
            complete: function() {
                if ($('#video_file').get(0).files.length > 0) {
                    console.log('Completed!');
                    bar.width('100%');
                    percent.html('100%');
                }
                window.location.href = "{{ url('/upload') }}";
            }

        });

    })
</script> --}}

<script>
    var file;
    const videoWrapper = document.querySelector("#video_preview");
    const videoElement = document.querySelector("#my_video");
    const videoTag = document.querySelector("#video_file");
    console.log(videoElement)
    console.log(videoTag)
    videoWrapper.classList.add("hide");

    function onFileInputHandler(e) {
        file = videoTag.files[0];
        // console.log ( file )
        //set video preview
        let blobURL = URL.createObjectURL(file);

        // remove display

        videoWrapper.classList.remove("hide");
        videoElement.src = blobURL;
    }

    function uploadVideo(event) {
        event.preventDefault();

        const file = document.getElementById('video_file').
        console.log()
    }

    function reset() {
        event.preventDefault();
        videoWrapper.classList.add("hide");
        videoElement.src = '';
        videoTag.value = '';
    }
</script>

</html>
