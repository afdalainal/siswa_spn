@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Edit Tugas Peleton</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('tugaspeleton.update', $tugaspeleton->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    {{-- Pengasuh & Peleton --}}
                    @foreach(['danton', 'danki', 'danmen'] as $role)
                    <div class="col-sm‑6">
                        <div class="form-group">
                            <label for="pengasuh_{{ $role }}_id">Pilih Pengasuh {{ ucfirst($role) }}</label>
                            <select class="form-select" id="pengasuh_{{ $role }}_id" name="pengasuh_{{ $role }}_id"
                                required>
                                <option value="" disabled>-- Pilih --</option>
                                @foreach($pengasuh as $p)
                                <option value="{{ $p->id }}"
                                    {{ old("pengasuh_{$role}_id", $tugaspeleton->{"pengasuh_{$role}_id"}) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-sm‑6">
                        <div class="form-group">
                            <label for="user_id">Pilih Peleton</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="" disabled>-- Pilih --</option>
                                @foreach($user as $u)
                                <option value="{{ $u->id }}"
                                    {{ old('user_id', $tugaspeleton->user_id) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @foreach(['ton_ki_yon','minggu_ke','hari_tgl_1','tempat_1','hari_tgl_2','tempat_2','hari_tgl_3','tempat_3','hari_tgl_4','tempat_4','hari_tgl_5','tempat_5','hari_tgl_6','tempat_6','hari_tgl_7','tempat_7','keterangan']
                    as $field)
                    <div class="col-sm‑6">
                        <div class="form-group">
                            <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" id="{{ $field }}" name="{{ $field }}"
                                value="{{ old($field, $tugaspeleton->{$field}) }}" class="form-control square"
                                placeholder="Input {{ $field }}" required>
                        </div>
                    </div>
                    @endforeach

                    {{-- Multiple select siswa --}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="siswa_id">Pilih Siswa</label>
                            <select class="form-select" id="siswa_id" name="siswa_id[]" multiple required>
                                @foreach($siswas as $s)
                                @php
                                $joined = $siswa_terkait->firstWhere('siswa_id', $s->id);
                                $status = $joined?->status;
                                @endphp
                                <option value="{{ $s->id }}" {{ in_array($s->id, $siswa_ids_aktif) ? 'selected' : '' }}>
                                    {{ $s->nama }} @if($status === 'nonaktif') (Nonaktif) @endif
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Siswa nonaktif diberi tag, centang kembali untuk aktifkan.</small>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 col-2 mx-auto">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// jika ingin initialize select2
$('#siswa_id').select2({
    placeholder: "Pilih siswa",
    width: '100%'
});
</script>
@endpush