@extends('layouts.app')

@section('title')
Project
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div
                        class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                        <h5>Projects</h5>
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="list-grid-toggle d-flex align-items-center mr-3">
                                <a href="{{ route('projects.index') }}"
                                    class="mr-2">
                                    <div class="grid-icon">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="14" width="7" height="7"></rect>
                                            <rect x="3" y="14" width="7" height="7"></rect>
                                        </svg>
                                    </div>
                                </a>
                                <div data-toggle-extra="tab" data-target-extra="#list" class="mr-2 active">
                                    <div class="grid-icon">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="21" y1="10" x2="3" y2="10"></line>
                                            <line x1="21" y1="6" x2="3" y2="6"></line>
                                            <line x1="21" y1="14" x2="3" y2="14"></line>
                                            <line x1="21" y1="18" x2="3" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-3 border-left btn-new">
                                <a href="#" class="btn btn-primary" data-target="#new-project-modal"
                                    data-toggle="modal">New Project</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="list" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('projects.list') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search by keyword" name="search" value="{{ request()->query('search') }}" onchange="this.form.submit()">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @foreach ($projects as $project)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="d-flex align-items-center">
                                    <div class="ml-3">
                                        <h5 class="mb-1">{{ $project->project_name }}</h5>
                                        <p class="mb-0">{{ $project->project_description }}</p>
                                        <span class="text-primary">Due Date: {{ $project->deadline->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <a href="{{ route('projects.files.index', $project->id) }}" class="btn btn-primary mt-2">
                                        <i class="ri-archive-drawer-fill"></i>Project Files
                                    </a>
                                </div>
                            </div>
                            <h5 class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                @if ($project->is_active)
                                <span class="badge badge-success ml-1">Active</span>
                                @else
                                <span class="badge badge-dark ml-1">Inactive</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <ul class="pagination">
            @if ($projects->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $projects->previousPageUrl() }}" tabindex="-1">Previous</a>
            </li>
            @endif

            @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $pageNumber => $url)
            @if ($pageNumber == $projects->currentPage())
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">{{ $pageNumber }} <span class="sr-only">(current)</span></a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $url }}">{{ $pageNumber }}</a>
            </li>
            @endif
            @endforeach

            @if ($projects->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $projects->nextPageUrl() }}">Next</a>
            </li>
            @else
            <li class="page-item disabled">
                <a class="page-link" href="#">Next</a>
            </li>
            @endif
        </ul>
    </div>
    <!-- Page end  -->
</div>
@endsection

@section('modals')
<div class="modal fade" role="dialog" aria-modal="true" id="new-project-modal">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="error-message" role="alert"></div>

                <form id="new-project-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="exampleInputText01" class="h5">Project Name*</label>
                                <input type="text" class="form-control @error('project_name') is-invalid @enderror" id="project_name" name="project_name" placeholder="Enter project name" value="{{ old('project_name') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="exampleInputText07" class="h5">Project Description*</label>
                                <textarea class="form-control @error('project_description') is-invalid @enderror" id="project_description" name="project_description" rows="3" placeholder="Enter project description" required>{{ old('project_description') }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="exampleInputText004" class="h5">Deadline*</label>
                                <input type="datetime-local" class="form-control @error('project_deadline') is-invalid @enderror" id="deadline" name="deadline" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex flex-wrap align-items-center justify-content-end mt-2">
                                <button type="button" class="btn btn-primary mr-2 px-4" onclick="createProjectForm()">Save</button>
                                <div class="btn btn-secondary px-4" data-dismiss="modal">Cancel</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" aria-modal="true" id="edit-project-modal">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="error-message" role="alert"></div>

                <form id="edit-project-form">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="exampleInputText01" class="h5">Project Name*</label>
                                <input type="text" class="form-control @error('project_name') is-invalid @enderror" id="edit_project_name" name="project_name" placeholder="Enter project name" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="exampleInputText07" class="h5">Project Description*</label>
                                <textarea class="form-control @error('project_description') is-invalid @enderror" id="edit_project_description" name="project_description" rows="3" placeholder="Enter project description" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="exampleInputText004" class="h5">Deadline*</label>
                                <input type="datetime-local" class="form-control @error('project_deadline') is-invalid @enderror" id="edit_deadline" name="deadline" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex flex-wrap align-items-center justify-content-end mt-2">
                                <button type="button" class="btn btn-primary mr-2 px-4" onclick="editProjectForm()">Save</button>
                                <div class="btn btn-secondary px-4" data-dismiss="modal">Cancel</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
    function createProjectForm() {
        let formData = new FormData(document.getElementById('new-project-form'));

        $.ajax({
            url: '{{ route("projects.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            success: function(data) {
                $('#new-project-modal .close').click();
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop").remove();

                Swal.fire({
                    title: "Success!",
                    text: "Project created successfully!",
                    icon: "success"
                });

                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error!",
                    text: 'An error occurred. Please try again.',
                    icon: "error"
                });
            }
        });
    }

    function openModalEditProject(id) {
        $.ajax({
            url: `{{ route("projects.edit", ":id") }}`.replace(':id', id),
            type: 'GET',
            success: function(data) {
                $('#edit-project-form')[0].reset();
                $('#edit_id').val(data.data.id);
                $('#edit_project_name').val(data.data.project_name);
                $('#edit_project_description').val(data.data.project_description);

                const deadline = new Date(data.data.deadline);
                const formattedDeadline = `${deadline.getFullYear()}-${(deadline.getMonth() + 1).toString().padStart(2, '0')}-${deadline.getDate().toString().padStart(2, '0')}T${deadline.getHours().toString().padStart(2, '0')}:${deadline.getMinutes().toString().padStart(2, '0')}`;
                $('#edit_deadline').val(formattedDeadline);

                $('#edit-project-form').attr('action', `{{ route("projects.update", ":id") }}`.replace(':id', id));

                $('#edit-project-modal').modal('show');
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error!",
                    text: 'An error occurred. Please try again.',
                    icon: "error"
                });
            }
        });
    }

    function editProjectForm() {
        let formData = new FormData(document.getElementById('edit-project-form'));

        $.ajax({
            url: `{{ route("projects.update", ":id") }}`.replace(':id', $('#edit_id').val()),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            success: function(data) {
                $('#edit-project-modal .close').click();
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop").remove();

                Swal.fire({
                    title: "Success!",
                    text: "Project updated successfully!",
                    icon: "success"
                });

                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error!",
                    text: 'An error occurred. Please try again.',
                    icon: "error"
                });
            }
        });
    }
</script>
@endsection
