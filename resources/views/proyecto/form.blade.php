<form action="{{ route('proyectos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row padding-1 p-1">
        <div class="col-md-12">

            <div class="form-group mb-2 mb20">
                <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $proyecto?->nombre) }}" id="nombre" placeholder="Nombre">
                {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-2 mb20">
                <label for="imagen" class="form-label">{{ __('Imagen') }}</label>
                <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" id="imagen">
                {!! $errors->first('imagen', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-2 mb20">
                <label for="descripcion" class="form-label">{{ __('Descripcion') }}</label>
                <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion', $proyecto?->descripcion) }}" id="descripcion" placeholder="Descripcion">
                {!! $errors->first('descripcion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

            <div class="form-group mb-2 mb20">
                <label for="url" class="form-label">{{ __('Url') }}</label>
                <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $proyecto?->url) }}" id="url" placeholder="Url">
                {!! $errors->first('url', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

        </div>
        <div class="col-md-12 mt20 mt-2">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </div>
    </div>
</form>
