@extends('siswa.layout.app')
@section('konten')
    <style>
        .container-fluid {
            background-color: white;

        }

        h1 {
            font-family: Times, sans-serif;
            margin-left: 60px;
            margin-top:  20px
        }

        .content {
            margin-left: 60px;

        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>ILMU PENGETAHUAN ALAM</h1>
                <div class="content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('siswa.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><span class="no-link">My courses</span></li>
                        <li class="breadcrumb-item"><a href="#" >ILMU PENGETAHUAN SOSIAL</a></li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection
