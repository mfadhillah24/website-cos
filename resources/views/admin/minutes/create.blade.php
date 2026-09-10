@extends('layouts.admin')

@section('title', 'Tambah Notulen Rapat')
@section('page_title', 'Tambah Notulen Rapat')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Tambah Notulen Rapat</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.minutes.store') }}" method="POST" >
            @csrf
            <div class="form-group"><label>Rapat</label><select name="meeting_id" class="form-control" required><option value="">Pilih</option>
@foreach($meetings as $rel)
                <option value="{{ $rel->id }}" >{{ $rel->title }}</option>
                @endforeach</select></div>
            <div class="form-group"><label>Pemimpin</label><input type="text" name="leader"  class="form-control" required></div>
            <div class="form-group"><label>Notulis</label><input type="text" name="notulist"  class="form-control" required></div>
            <div class="form-group"><label>Hasil Pembahasan</label><textarea name="discussion_results" class="form-control" rows="4" required></textarea></div>
            <div class="form-group"><label>Keputusan</label><textarea name="decisions" class="form-control" rows="4" required></textarea></div>
            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.minutes.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection