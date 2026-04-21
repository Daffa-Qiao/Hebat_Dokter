<div class="mb-3">
    <label for="title" class="form-label fw-bold">Judul Artikel</label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $article->title ?? '') }}" required>
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="specialization" class="form-label fw-bold">Spesialisasi</label>
    <select name="specialization" id="specialization" class="form-select">
        <option value="">-- Umum (semua spesialisasi) --</option>
        @foreach(['Jantung','Pencernaan','Ginjal','Paru-paru','Saraf','Kulit','Anak','Gigi','Mata','Ortopedi','Umum'] as $spec)
            <option value="{{ $spec }}" {{ old('specialization', $article->specialization ?? '') === $spec ? 'selected' : '' }}>{{ $spec }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="thumbnail" class="form-label fw-bold">Thumbnail (opsional)</label>
    @if(isset($article) && $article->thumbnail)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" style="height:80px; border-radius:6px;"
                 onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
        </div>
    @endif
    <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
</div>

<div class="mb-3">
    <label for="content" class="form-label fw-bold">Isi Artikel</label>
    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror"
              rows="12" required>{{ old('content', $article->content ?? '') }}</textarea>
    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" name="published" id="published" value="1"
               {{ old('published', $article->published ?? true) ? 'checked' : '' }}>
        <label class="form-check-label fw-semibold" for="published">Publish Artikel</label>
    </div>
</div>
