@extends('layouts.backend.main')
@section('title','MyBlog | Users')
@section('content')
<div class="container-fluid p-4">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="overflow:auto">
    <h1 class="float-left font-weight-bold " style="color:#1d68a7;">
      Display All Users...
    </h1>
    <div class="create float-right py-2">
      <button class="btn btn-primary">
        New User
      </button>
    </div>
  </section>
  <!-- Main content -->
  <section class="container  mt-4">
    <div class="row">
      <div class="col">
        <div class="box">
          <!-- /.box-header -->
          <div class="box-body ">
            @if (session('message'))
            <div class="alert alert-info">
              {{ session('message')}}
            </div>
            @endif
            @if (!$users->count())
            <div class="alert alert-danger">
              <strong>No record</strong>
            </div>
            @else
              <table class="table table-striped table-dark table-hover  table-bordered ">
                <thead>
                  <tr>
                    <td scope="col">Name</td>
                    <td scope="col">Mail</td>
                    <td scope="col" width='80'>Post Count</td>
                    <td scope="col" width='80'>Role</td>
                    <td scope="col" width='80'>Actions</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td style="text-align:center;">{{$user->posts->count()}}</td>
                    <td>{{$user->role->name}}</td>
                    <td style="display:flex;">
                      <a href="/backend/users/{{$user->id}}/edit" class="mr-2 btn btn-xs btn-success">
                        <i class="fa fa-edit"></i>
                      </a>
                      <form action="/backend/users/{{$user->id}}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-xs btn-danger">
                          <i class="fa fa-times"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
          <!-- /.box-body -->
          <nav>
            {{-- {{$user->links()}} --}}
          </nav>
        </div>
      </div>
  </section>
</div>
@endsection