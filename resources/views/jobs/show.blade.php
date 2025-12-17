@extends('layouts.app') 
@section('content') 
<div class="container"> 
<h2>{{ $job->title }}</h2> 
<p><strong>Company:</strong> {{ $job->company }}</p> 
<p><strong>Location:</strong> {{ $job->location }}</p> 
    <p><strong>Salary:</strong> Rp {{ number_format($job->salary, 
0, ',', '.') }}</p> 
    <p><strong>Description:</strong></p> 
    <p>{{ $job->description }}</p> 
     
    @if($job->logo) 
        <img src="{{ asset('storage/' . $job->logo) }}" 
alt="Logo" width="200"> 
    @endif 
     
    <hr> 
     
    <h3>Apply untuk Lowongan Ini</h3> 
     
    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') 
}}</div> 
    @endif 
     
    @if($errors->any()) 
        <div class="alert alert-danger"> 
            <ul> 
                @foreach($errors->all() as $error) 
                    <li>{{ $error }}</li> 
                @endforeach 
            </ul> 
        </div> 
    @endif 
     
    <form action="{{ route('applications.store') }}" 
method="POST" enctype="multipart/form-data"> 
        @csrf 
        <input type="hidden" name="job_id" value="{{ $job->id 
}}"> 
         
        <div class="mb-3"> 
PHP
            <label for="cv" class="form-label">Upload CV (PDF Max 
2MB) *</label> 
            <input type="file"  
                   class="form-control @error('cv') is-invalid 
@enderror"  
                   id="cv"  
                   name="cv"  
                   accept=".pdf"  
                   required> 
            @error('cv') 
                <div class="invalid-feedback">{{ $message 
}}</div> 
            @enderror 
        </div> 
         
        <div class="mb-3"> 
            <label for="cover_letter" class="form-label">Cover 
Letter</label> 
            <textarea class="form-control" id="cover_letter" 
name="cover_letter" rows="5"></textarea> 
        </div> 
         
        <button type="submit" class="btn btn-primary">Submit 
Lamaran</button> 
        <a href="{{ route('jobs.index') }}" class="btn 
btn-secondary">Kembali</a> 
    </form> 
</div> 
@endsection