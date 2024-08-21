@extends('layouts.app')

@section('title')
Project Files
@endsection

@section('additional_css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <a href="{{ route('projects.index') }}" class="btn btn-light">
                <i class="ri-arrow-go-back-line"></i> Back
            </a>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div
                        class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content mb-3">
                        <h5>Project Files</h5>
                    </div>
                    <div class="">
                        <p class="mb-0"><b>Project Name: </b>{{ $project->project_name }}</p>
                        <p class="mb-0"><b>Project Description: </b>{{ $project->project_description }}</p>
                        <p class="mb-0"><b>Project Due Date: </b>{{ $project->deadline->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card-transparent mb-0">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-2">Documents</h5>
                                    <h3><span class="counter" style="visibility: visible;">{{ $totalDocuments }}</span> files</h3>
                                    <div class="d-flex justify-content-end">
                                        <span class="text-success">{{ $pctDocuments }}%</span>
                                    </div>
                                    <div class="iq-progress-bar bg-secondary-light mb-2">
                                        <span class="bg-secondary iq-progress progress-1" data-percent="{{ $pctDocuments }}"
                                            style="transition: width 2s ease 0s; width: 0%;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-2">Images</h5>
                                    <h3><span class="counter" style="visibility: visible;">{{ $totalImages }}</span> files</h3>
                                    <div class="d-flex justify-content-end">
                                        <span class="text-success">{{ $pctImages }}%</span>
                                    </div>
                                    <div class="iq-progress-bar bg-info-light mb-2">
                                        <span class="bg-info iq-progress progress-1" data-percent="{{ $pctImages }}"
                                            style="transition: width 2s ease 0s; width: 0%;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-2">Video</h5>
                                    <h3><span class="counter" style="visibility: visible;">{{ $totalVideos }}</span> files</h3>
                                    <div class="d-flex justify-content-end">
                                        <span class="text-success">{{ $pctVideos }}%</span>
                                    </div>
                                    <div class="iq-progress-bar bg-success-light mb-2">
                                        <span class="bg-success iq-progress progress-1" data-percent="{{ $pctVideos }}"
                                            style="transition: width 2s ease 0s; width: 0%;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-2">Audios</h5>
                                    <h3><span class="counter" style="visibility: visible;">{{ $totalAudios }}</span> files</h3>
                                    <div class="d-flex justify-content-end">
                                        <span class="text-success">{{ $pctAudios }}%</span>
                                    </div>
                                    <div class="iq-progress-bar bg-success-light mb-2">
                                        <span class="bg-success iq-progress progress-1" data-percent="{{ $pctAudios }}"
                                            style="transition: width 2s ease 0s; width: 0%;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <form action="{{ route('projects.files.store', $project->id) }}" class="dropzone" id="uploadProjectFile" enctype="multipart/form-data" files="true">
                @csrf
                <div class="dz-message">
                    <h5>Drag and drop files here or click to add new project files</h5>
                    <span>or click to add new project files</span>
                </div>
            </form>
            <span class="text-danger">* Maximum file size is 50MB. Allowed file types are pdf, txt, zip, jpeg, png, gif, bmp, tiff, svg, webp, mp4, webm, mpeg, avi, mpeg, ogg, wav, mp3</span>
        </div>
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
@endsection

@section('additional_scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script type="module">
    Dropzone.options.uploadProjectFile = {
        paramName: 'file',
        maxFilesize: 50,
        acceptedFiles: 'application/pdf, text/plain, application/zip, image/jpeg, image/png, image/gif, image/bmp, image/tiff, image/svg+xml, image/webp, video/mp4, video/webm, video/mpeg, video/avi, video/mpeg, video/ogg, audio/wav, audio/mpeg3, audio/x-mpeg-3, video/mpeg, video/x-mpeg',
        uploadMultiple: true,
        parallelUploads: 10,
        maxFiles: 10,
        success: function(file, response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'File uploaded successfully'
            });
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        },
        error: function(file, response) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response
            });

            this.removeFile(file);
        }
    };
</script>
@endsection
