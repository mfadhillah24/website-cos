@extends('layouts.admin')

@section('title', 'Edit Notulen Rapat')
@section('page_title', 'Edit Notulen Rapat')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Notulen Rapat</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.minutes.update', $minute) }}" method="POST" >
            @csrf
            @method('PUT')
            <div class="form-group"><label>Rapat</label><select name="meeting_id" class="form-control" required><option value="">Pilih</option>
@foreach($meetings as $rel)
                <option value="{{ $rel->id }}" {{ $minute->meeting_id == $rel->id ? 'selected' : '' }}>{{ $rel->title }}</option>
                @endforeach</select></div>
            <div class="form-group"><label>Pemimpin</label><input type="text" name="leader" value="{{ $minute->leader }}" class="form-control" required></div>
            <div class="form-group"><label>Notulis</label><input type="text" name="notulist" value="{{ $minute->notulist }}" class="form-control" required></div>
            <div class="form-group"><label>Hasil Pembahasan</label><textarea name="discussion_results" class="form-control" rows="4" required>{{ $minute->discussion_results }}</textarea></div>
            <div class="form-group"><label>Keputusan</label><textarea name="decisions" class="form-control" rows="4" required>{{ $minute->decisions }}</textarea></div>
            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.minutes.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection