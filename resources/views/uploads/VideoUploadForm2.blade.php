<!DOCTYPE html>
<html>

<head>
    <title>File upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"
        integrity="sha512-UWMGINgjUq/2sNur/d2LbiAX6IHmZkkCivoKSdoX+smfB+wB8f96/6Sp8ediwzXBXMXaAqymp6S55SALBk5tNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>'


    <style>
        #video_preview,
        video {
            max-width: 500px !important;
            max-height: 600px !important;
        }

        .hide {
            display: none;
        }
    </style>

</head>

<body>
    <div class="container m-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>Video upload </h2>
            </div>
            <div class="panel-body">


                <div class="container pt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h5>Upload File</h5>
                                </div>

                                <div class="card-body">
                                    <div id="upload-container" class="text-center">
                                        <p id="video_name" className="font-bold"> </p> 
                                        <input id="video_file" type="file" name="video_file" accept="video/*"
                                            class="form-control hide" onChange="onFileInputHandler()">

                                        <button id="browseFile" for="video_file" class="btn btn-primary">Browse
                                            File</button>
                                        <button id="resetBtn"  style="display: none" class="btn btn-danger" onClick="reset()">Reset</button>
                                    </div>
                                    <div style="display: none" class="progress mt-3" style="height: 25px">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 75%; height: 100%">75%</div>
                                    </div>

                                    <div class="text-center mt-5">
                                        <button id="uploadBtn" style="display: none" class="btn btn-primary">Upload</button>

                                    </div>
                                </div>

                                <div class="card-footer p-4" style="display: none">
                                    <video id="videoPreview" src="" controls
                                        style="width: 100%; height: auto"></video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    let browseFile = $('#browseFile');
    let uploadBtn = $('#uploadBtn');
    let resetBtn = $('#resetBtn');
    let currFileId ;

    let resumable = new Resumable({
        target: "{{ '/upload2' }}",
        query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: ['mp4', 'mov'],
        chunkSize: 10 * 1024 *
            1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
        
        maxFiles: 1,
        
        // simultaneousUploads: 3,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function(file) { // trigger when file picked
        showProgress();
        currFileId = file.uniqueIdentifier ;
        // console.log(file);
        $('#video_name').text( file.fileName)
        uploadBtn.click(function() {
            resumable.upload() // to actually start uploading.
        });
        
    });

    resumable.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
        uploadBtn.hide();
        response = JSON.parse(response)
        $('#videoPreview').attr('src', response.path);
        $('.card-footer').show();
        resumable.removeFile(file); //remove selected files
    });

    resumable.on('fileError', function(file, response) { // trigger when there is any error
        alert('file uploading error.')
    });

    let progress = $('.progress');


    function showProgress() {
        uploadBtn.show();
        resetBtn.show();
        progress.find('.progress-bar').css('width', '0%');
        progress.find('.progress-bar').html('0%');
        progress.find('.progress-bar').removeClass('bg-success');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.progress-bar').css('width', `${value}%`)
        progress.find('.progress-bar').html(`${value}%`)
    }

    function hideProgress() {
        progress.hide();
        uploadBtn.hide();

        $('#video_name').text( '') ;
        $('#videoPreview').attr('src', '');
        $('.card-footer').hide();
        resetBtn.hide();
    }
    
    function reset(){
        // console.log($('#video_file')[0].value)
        let file = resumable.getFromUniqueIdentifier(currFileId);
        resumable.removeFile(); //remove selected files
        $('#video_file').attr('value', '') ;
        hideProgress();
    }
</script>

</html>
