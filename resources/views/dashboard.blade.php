@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Total Project</h5>
                        <span class="badge badge-primary">Overall</span>
                    </div>
                    <h3><span class="counter">{{ $totalProject }}</span></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Recent Project</h5>
                        <span class="badge badge-warning">Monthly</span>
                    </div>
                    <h3><span class="counter">{{ $totalRecentProject }}</span></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Active Project</h5>
                        <span class="badge badge-primary">Overall</span>
                    </div>
                    <h3><span class="counter">{{ $totalActiveProject }}</span></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Finished Project</h5>
                        <span class="badge badge-primary">Overall</span>
                    </div>
                    <h3><span class="counter">{{ $totalCompletedProject }}</span></h3>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Quick Action</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card card-list">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <svg class="svg-icon text-primary mr-3" width="24" height="24"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                    <path
                                        d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                    </path>
                                </svg>
                                <div class="pl-3 border-left">
                                    <h5 class="mb-1">See All Projects</h5>
                                    <p class="mb-0">Click here to see all projects</p>
                                </div>
                                <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg ml-auto">
                                    <i class="ri-arrow-right-fill"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
@endsection
