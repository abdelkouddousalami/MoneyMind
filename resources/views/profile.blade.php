@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="profile-image mb-3">
                        <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" 
                             class="rounded-circle img-fluid" style="width: 150px;">
                    </div>
                    <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-3">Account #: {{ auth()->user()->account_number }}</p>
                    <button class="btn btn-primary btn-sm">Edit Profile</button>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary">Transfer Money</a>
                        <a href="#" class="btn btn-outline-primary">View Statements</a>
                        <a href="#" class="btn btn-outline-primary">Card Settings</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Personal Information</h5>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->first_name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->last_name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" value="{{ auth()->user()->phone }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->address }}" readonly>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Security Settings</h5>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Two-Factor Authentication</h6>
                            <p class="text-muted mb-0 small">Add an extra layer of security to your account</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">Change Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-image img {
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .card {
        border-radius: 15px;
        border: none;
    }
    .card-title {
        color: #333;
        font-weight: 600;
    }
</style>
@endsection
