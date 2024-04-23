@extends('layout')

@section('title', 'Dashboard')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


@section('content')
    
    <div class="main-content container mt-5" style="margin-bottom: 3rem;">
        <div class="content-left">
            <h1 id="username">{{ $user->name }}</h1>
            <div class="user-info">
                <p><strong>E-Mail:</strong> {{ $user->email }}</p>
                @if($user->phone_number == null)
                    <p class="error"><strong>Phone Number:</strong> No Phone Number!</p>
                @else
                    <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
                @endif
                <p><strong>Cars Listed:</strong> {{ $nb_cars }}</p>
            </div>

            <div class="buttons">
                <button id = "edit-btn"> Edit Profile </button> 
                <a href="{{ route('logout') }}"><button id = "logout-btn"> Log Out </button></a>
            </div>
        </div>

        <div class="visits-box">
            @if($visits->isEmpty()) 
                <p>No new visits</p>
            @endif
            @foreach ($visits->reverse() as $visit)
                <div class="visit">
                    @if ($visit->visitor_id == 0)
                        <p>Guest {{ $visit->guest_id }} seems interested in your {{ $visit->car->year }} {{ $visit->car->brand->name }} {{ $visit->car->model->name }}</p>
                    @else
                        <p>{{ $visit->visitor->name }} seems interested in your {{ $visit->car->year }} {{ $visit->car->brand->name }} {{ $visit->car->model->name }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    </div>

    
    @if(session('success') || session('error') || $errors->any())
        <div id = "edit-modal" style = "display:block">
    @else
        <div id = "edit-modal">
    @endif
        <div id = "modal-content">
        <div class="modal-header">
        <h5 id = "modal-title">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="phoneNumberForm" action = "{{route("update.phone_number")}}" method = "post">
            @csrf
          <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Enter new phone number">
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <form id="emailForm" action = "{{route("update.email")}}" method = "post">
            @csrf
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter new email address">
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <form id="passwordForm" action = "{{route("update.password")}}" method = "post">
            @csrf
          <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password">
          </div>
          <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password">
          </div>
          @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const contactButton = document.getElementById('edit-btn');
            const closeButton = document.getElementsByClassName('close')[0];
            const modal = document.getElementById('edit-modal');
            const alerts = document.getElementsByClassName("alert");

            contactButton.onclick = function() {
                modal.style.display = "block";
            }

            closeButton.onclick = function() {
                modal.style.display = "none";
                for (let i = 0; i < alerts.length; i++) {
                    const alert = alerts[i];
                    alert.style.display = "none";
                }
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
@endsection